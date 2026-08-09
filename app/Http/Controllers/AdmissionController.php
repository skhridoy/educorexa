<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Student;
use App\Models\Classes;
use App\Models\AcademicYear;
use App\Models\Section;
use App\Models\SchoolCategory;
use App\Models\SchoolSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdmissionController extends Controller
{
    /**
     * Admin List
     */
    public function index()
    {
        $schoolId = app('currentSchool')->id;
        $admissions = Admission::where('school_id', Auth::user()->school_id)
            ->with(['academicYear', 'class'])
            ->latest()
            ->get();
        $sections   = Section::where('school_id', $schoolId)->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $subCategories = SchoolSubCategory::where('school_id', $schoolId)->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->orderBy('name', 'desc')->get();
        return view('school.admission.index', compact('admissions', 'sections', 'categories', 'subCategories', 'academicYears'));
    }

    /**
     * Public Form
     */
    public function create()
    {
        $school = app('currentSchool');
        $classes = Classes::where('school_id', $school->id)->get();
        $sections = Section::where('school_id', $school->id)->get();

        $admissionYear = $school->admissionAcademicYear
            ?: AcademicYear::where('school_id', $school->id)->where('is_active', 1)->first()
            ?: AcademicYear::where('school_id', $school->id)->latest()->first();

        $isAdmissionClosed = false;
        $closedMessage = $school->admission_closed_message ?: 'অনলাইন ভর্তি কার্যক্রম বর্তমানে বন্ধ রয়েছে। যেকোনো প্রয়োজনে স্কুল কর্তৃপক্ষের সাথে যোগাযোগ করার জন্য অনুরোধ করা হলো।';

        if (!$school->is_admission_open) {
            $isAdmissionClosed = true;
        } elseif ($school->admission_close_date && now()->greaterThan($school->admission_close_date)) {
            $isAdmissionClosed = true;
        }

        return view('school.website.admission', compact('classes', 'sections', 'isAdmissionClosed', 'closedMessage', 'school', 'admissionYear'));
    }

    /**
     * Store Public Admission
     */
    public function store(Request $request)
    {
        // ১. ভ্যালিডেশন (আপনার কোড ঠিক আছে)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'fathers_name' => 'required|string',
            'mothers_name' => 'required|string',
            'contact_number' => [
                'required',
                'digits:11',
                'regex:/^(01)[3-9]{1}[0-9]{8}$/'
            ],
            'photo' => 'nullable|image|max:2048',
            'email' => 'required|email|max:255|unique:admissions,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // ২. স্কুল এবং সাবডোমেইন আইডেন্টিফাই করা
        $currentSchool = app('currentSchool');
        $schoolId = $currentSchool->id;
        $tenantSlug = $currentSchool->slug;

        // অ্যাডমিশন ওপেন আছে কিনা চেক করা
        if (!$currentSchool->is_admission_open || ($currentSchool->admission_close_date && now()->greaterThan($currentSchool->admission_close_date))) {
            $closedMsg = $currentSchool->admission_closed_message ?: 'অনলাইন ভর্তি কার্যক্রম বর্তমানে বন্ধ রয়েছে।';
            return back()->withErrors(['admission_closed' => $closedMsg])->withInput();
        }

        // ৩. ক্লাস এবং একাডেমিক ইয়ার চেক
        $class = Classes::where('id', $validated['class_id'])
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $academicYear = $currentSchool->admissionAcademicYear
            ?: AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->first()
            ?: AcademicYear::where('school_id', $schoolId)->latest()->first();

        if (!$academicYear) {
            return back()->withErrors(['admission_closed' => 'কোনো সেশন নির্ধারণ করা নেই। কর্তৃপক্ষর সাথে যোগাযোগ করার নির্দেশ দেওয়া যাচ্ছে।'])->withInput();
        }

        // ৪. অ্যাডমিশন নাম্বার জেনারেশন (আপনার লজিক)
        $yearPart = substr($academicYear->name, -2);
        $classPart = str_pad($class->code, 2, '0', STR_PAD_LEFT);
        $lastAdmission = Admission::where('school_id', $schoolId)
            ->where('class_id', $class->id)
            ->where('academic_year_id', $academicYear->id)
            ->count();

        $running = str_pad($lastAdmission + 1, 4, '0', STR_PAD_LEFT);
        $admissionNumber = 'ADM-' . $yearPart . $classPart . $running;

        // ৫. ফটো আপলোড (ডাইনামিক ফোল্ডার স্ট্রাকচার)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // ফোল্ডার পাথ তৈরি: uploads/schools/abcschool/admissions
            $basePath = "uploads/schools/{$tenantSlug}/admissions";
            $fullPath = public_path($basePath);

            // ফোল্ডার না থাকলে তৈরি করা
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file = $request->file('photo');
            $filename = 'student_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // ফাইল মুভ করা
            $file->move($fullPath, $filename);
            $photoPath = $basePath . '/' . $filename;
        }

            // ৬. ডাটা ইনসার্ট
            DB::transaction(function () use ($schoolId, $academicYear, $class, $admissionNumber, $validated, $photoPath) {
            // ১. অ্যাডমিশন রেকর্ড তৈরি
            Admission::create([
                'school_id' => $schoolId,
                'academic_year_id' => $academicYear->id,
                'class_id' => $class->id,
                'admission_number' => $admissionNumber,
                'name' => $validated['name'],
                'fathers_name' => $validated['fathers_name'],
                'mothers_name' => $validated['mothers_name'],
                'contact_number' => $validated['contact_number'],
                'photo' => $photoPath,
                'status' => 'pending',
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

        });

        // After creating admission, store the ID in session and return to the form with success message
        $admission = Admission::where('admission_number', $admissionNumber)->first();
        return back()->with(['success' => 'Admission submitted successfully.', 'admission_id' => $admission->id]);
    }

    /**
     * Search Admission PDF by Phone Number
     */
    public function searchByPhone(Request $request, $tenant)
    {
        $phone = trim($request->query('phone') ?? $request->query('contact_number'));
        if (!$phone) {
            return response()->json(['status' => false, 'message' => 'অনুগ্রহ করে মোবাইল নম্বর প্রদান করুন।']);
        }

        $school = app('currentSchool');
        $admissions = Admission::where('school_id', $school->id)
            ->where('contact_number', 'like', '%' . $phone . '%')
            ->latest()
            ->get(['id', 'admission_number', 'name', 'contact_number', 'status', 'created_at']);

        if ($admissions->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'প্রদত্ত মোবাইল নম্বরে কোনো ভর্তি আবেদন পাওয়া যায়নি।']);
        }

        $results = $admissions->map(function ($adm) use ($tenant) {
            return [
                'id'               => $adm->id,
                'admission_number' => $adm->admission_number,
                'name'             => $adm->name,
                'contact_number'   => $adm->contact_number,
                'status'           => ucfirst($adm->status),
                'date'             => $adm->created_at ? $adm->created_at->format('d M, Y') : '',
                'pdf_url'          => route('admissions.pdf', ['tenant' => $tenant, 'id' => $adm->id]),
            ];
        });

        return response()->json(['status' => true, 'admissions' => $results]);
    }

    /**
     * Update Admission Settings (Open/Close, Deadline, Message, Admission Session)
     */
    public function updateSettings(Request $request, $tenant)
    {
        $request->validate([
            'is_admission_open'          => 'required|boolean',
            'admission_closed_message'   => 'nullable|string|max:1000',
            'admission_close_date'       => 'nullable|date',
            'admission_academic_year_id' => 'nullable|exists:academicyears,id',
        ]);

        $school = app('currentSchool');
        $school->update([
            'is_admission_open'          => $request->is_admission_open,
            'admission_closed_message'   => $request->admission_closed_message,
            'admission_close_date'       => $request->admission_close_date,
            'admission_academic_year_id' => $request->admission_academic_year_id,
        ]);

        return back()->with('success', 'অ্যাডমিশন সেটিংস সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Download Admission PDF
     */
    public function downloadPdf($tenant, $id)
    {
        $admission = Admission::findOrFail($id);
        $school = app('currentSchool');
        $qrData = "Admission No: {$admission->admission_number}\nName: {$admission->name}";
        $qrCode = base64_encode(QrCode::format('svg')->size(150)->generate($qrData));
        $pdf = Pdf::loadView('admission.pdf', compact('admission', 'school', 'qrCode'));
        return $pdf->download('admission_' . $admission->admission_number . '.pdf');
    }

    public function approve(Request $request, $tenant, Admission $admission)
    {
        // ১. সিকিউরিটি চেক
        abort_if($admission->school_id !== auth()->user()->school_id, 403);

        // ২. ভ্যালিডেশন
        $request->validate([
            'section_id'             => 'required|exists:sections,id',
            'school_category_id'     => 'nullable|exists:school_categories,id',
            'school_sub_category_id' => 'nullable|exists:school_sub_categories,id',
        ]);

        $currentSchool = app('currentSchool');
        $schoolId = $currentSchool->id;
        $tenantSlug = $currentSchool->slug;

        // ৩. ফর্ম থেকে নির্বাচিত Section
        $selectedSection = Section::where('id', $request->section_id)
            ->where('school_id', $schoolId)
            ->first();

        if (!$selectedSection) {
            return back()->with([
                'success' => 'নির্বাচিত সেকশন পাওয়া যায়নি। আবার চেষ্টা করুন।',
                'type'    => 'danger'
            ]);
        }

        $sectionId          = $selectedSection->id;
        $categoryId         = $request->school_category_id;
        $subCategoryId      = $request->school_sub_category_id;

        // ৩. ভর্তি আবেদনের নির্ধারিত সেশন / একাডেমিক ইয়ার খুঁজে বের করা
        $academicYear = $admission->academicYear 
            ?: AcademicYear::where('id', $admission->academic_year_id)->first()
            ?: AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->firstOrFail();

        // ৪. ইউনিক স্টুডেন্ট আইডি (Student ID) জেনারেশন লজিক
        $yearPart = substr($academicYear->name, -2);
        $prefix = 'STD-' . $yearPart;

        // ওই বছরের সর্বোচ্চ ৪ ডিজিটের সিরিয়াল নম্বরটি বের করা
        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $nextNumber = $lastSerial ? $lastSerial + 1 : 1001;
        $studentId = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $admissionDate = now()->format('Y-m-d');

        // ৫. ফটো হ্যান্ডেলিং (Admissions ফোল্ডার থেকে Students ফোল্ডারে মুভ করা)
        $finalPhotoPath = $admission->photo;
        if ($admission->photo && file_exists(public_path($admission->photo))) {
            $oldPath = public_path($admission->photo);
            $newFolder = "uploads/schools/{$tenantSlug}/students";
            
            if (!file_exists(public_path($newFolder))) {
                mkdir(public_path($newFolder), 0755, true);
            }

            $fileName = basename($oldPath);
            $newPath = $newFolder . '/' . $fileName;
            
            if (rename($oldPath, public_path($newPath))) {
                $finalPhotoPath = $newPath;
            }
        }
        $lastRoll = Student::where('school_id', $schoolId)
            ->where('class_id', $admission->class_id)
            ->where('academic_year_id', $admission->academic_year_id)
            ->max('roll');

        $nextRoll = $lastRoll ? $lastRoll + 1 : 1;
        // ৬. ডাটাবেজ ট্রানজ্যাকশন (নিরাপদ ইনসার্ট নিশ্চিত করতে)
        DB::transaction(function () use ($admission, $studentId, $schoolId, $admissionDate, $finalPhotoPath, $sectionId, $categoryId, $subCategoryId, $nextRoll) {
           // ১. ইউজার খুঁজে বের করা অথবা আপডেট করা
            $user = User::where('email', $admission->email)
                        ->where('school_id', $schoolId)
                        ->first();

            if ($user) {
                // বিদ্যমান ইউজার থাকলে শুধু রোল আপডেট
                $user->update(['role' => 'student']);
            } else {
                // যদি কোনো কারণে ইউজার না থাকে, তবেই শুধু নতুন তৈরি
                $user = User::create([
                    'school_id' => $schoolId,
                    'name'      => $admission->name,
                    'email'     => $admission->email,
                    'password'  => $admission->password,
                    'role'      => 'student',
                ]);
            }

            // রোল সিঙ্ক করা (Spatie)
            if (method_exists($user, 'syncRoles')) {
                $user->syncRoles(['student']);
            }
            // স্টুডেন্ট টেবিলে ডাটা ইনসার্ট (সহ অ্যাডমিশন আইডি রেফারেন্স)
            Student::create([
                'user_id'           => $user->id,
                'school_id'         => $schoolId,
                'admission_id'      => $admission->id, // Reference to Admission History
                'academic_year_id'  => $admission->academic_year_id,
                'class_id'          => $admission->class_id,
                'section_id'             => $sectionId,
                'school_category_id'     => $categoryId,
                'school_sub_category_id' => $subCategoryId,
                'student_id'        => $studentId,
                'roll'              => $nextRoll,
                'name'              => $admission->name,
                'email'             => $admission->email,
                'contact_number'    => $admission->contact_number,
                'fathers_name'      => $admission->fathers_name,
                'mothers_name'      => $admission->mothers_name,
                'father_nid'        => $admission->father_nid,
                'mother_nid'        => $admission->mother_nid,
                'student_birth_nid' => $admission->student_birth_nid,
                'gender'            => $admission->gender,
                'religion'          => $admission->religion,
                'blood_group'       => $admission->blood_group,
                'date_of_birth'     => $admission->date_of_birth,
                'admission_date'    => $admissionDate,
                'address'           => $admission->address,
                'previous_school'   => $admission->previous_school,
                'previous_class'    => $admission->previous_class,
                'photo'             => $finalPhotoPath,
                'status'            => 'active',
                'password'          => $admission->password,
            ]);

            // অ্যাডমিশন স্ট্যাটাস আপডেট (হিস্ট্রি সংরক্ষণের জন্য ডিলিট না করে অনুমোদিত হিসেবে মার্ক করা)
            $admission->update(['status' => 'approved']);
        });

        return back()->with([
            'success' => 'শিক্ষার্থী সফলভাবে ভর্তি করা হয়েছে এবং হিস্ট্রি সংরক্ষিত রয়েছে।',
            'type'    => 'success'
        ]);
    }

    public function bulkApprove(Request $request, $tenant)
    {
        // 1. Validation
        $request->validate([
            'admission_ids'        => 'required|array',
            'admission_ids.*'      => 'exists:admissions,id',
            'section_id'           => 'required|exists:sections,id',
            'school_category_id'   => 'nullable|exists:school_categories,id',
            'school_sub_category_id' => 'nullable|exists:school_sub_categories,id',
        ]);

        $currentSchool = app('currentSchool');
        $schoolId = $currentSchool->id;
        $tenantSlug = $currentSchool->slug;

        // 2. Fetch pending admissions for this school
        $admissions = Admission::whereIn('id', $request->admission_ids)
            ->where('school_id', $schoolId)
            ->where('status', 'pending')
            ->get();

        if ($admissions->isEmpty()) {
            return back()->with([
                'success' => 'কোনো পেন্ডিং আবেদন পাওয়া যায়নি।',
                'type'    => 'danger'
            ]);
        }

        // 3. Find selected section
        $selectedSection = Section::where('id', $request->section_id)
            ->where('school_id', $schoolId)
            ->first();

        if (!$selectedSection) {
            return back()->with([
                'success' => 'নির্বাচিত সেকশন পাওয়া যায়নি। আবার চেষ্টা করুন।',
                'type'    => 'danger'
            ]);
        }

        $sectionId          = $selectedSection->id;
        $categoryId         = $request->school_category_id;
        $subCategoryId      = $request->school_sub_category_id;

        // 4. Find active academic year
        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->first();

        if (!$academicYear) {
            return back()->with([
                'success' => 'কোনো সক্রিয় শিক্ষাবর্ষ পাওয়া যায়নি।',
                'type'    => 'danger'
            ]);
        }

        // 5. Setup Unique Student ID generation
        $yearPart = substr($academicYear->name, -2);
        $prefix = 'STD-' . $yearPart;

        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $nextNumber = $lastSerial ? $lastSerial + 1 : 1001;
        $admissionDate = now()->format('Y-m-d');

        // Track rolls per class to prevent duplicate rolls in the batch
        $classRolls = [];
        $approvedCount = 0;

        // 6. DB Transaction to ensure everything succeeds or fails together
        DB::transaction(function () use ($admissions, $schoolId, $tenantSlug, $academicYear, $prefix, &$nextNumber, $admissionDate, $sectionId, $categoryId, $subCategoryId, &$classRolls, &$approvedCount) {
            foreach ($admissions as $admission) {
                // Generate Student ID
                $studentId = $prefix . str_pad($nextNumber++, 4, '0', STR_PAD_LEFT);

                // Handle Roll Number
                $classId = $admission->class_id;
                if (!isset($classRolls[$classId])) {
                    $lastRoll = Student::where('school_id', $schoolId)
                        ->where('class_id', $classId)
                        ->where('academic_year_id', $academicYear->id)
                        ->max('roll');
                    $classRolls[$classId] = $lastRoll ? $lastRoll : 0;
                }
                $classRolls[$classId]++;
                $nextRoll = $classRolls[$classId];

                // Handle Photo Move
                $finalPhotoPath = $admission->photo;
                if ($admission->photo && file_exists(public_path($admission->photo))) {
                    $oldPath = public_path($admission->photo);
                    $newFolder = "uploads/schools/{$tenantSlug}/students";
                    
                    if (!file_exists(public_path($newFolder))) {
                        mkdir(public_path($newFolder), 0755, true);
                    }

                    $fileName = basename($oldPath);
                    $newPath = $newFolder . '/' . $fileName;
                    
                    if (rename($oldPath, public_path($newPath))) {
                        $finalPhotoPath = $newPath;
                    }
                }

                // Handle User
                $user = User::where('email', $admission->email)
                            ->where('school_id', $schoolId)
                            ->first();

                if ($user) {
                    $user->update(['role' => 'student']);
                } else {
                    $user = User::create([
                        'school_id' => $schoolId,
                        'name'      => $admission->name,
                        'email'     => $admission->email,
                        'password'  => $admission->password,
                        'role'      => 'student',
                    ]);
                }

                if (method_exists($user, 'syncRoles')) {
                    $user->syncRoles(['student']);
                }

                // Create Student with Admission Reference
                Student::create([
                    'user_id'                => $user->id,
                    'school_id'              => $schoolId,
                    'admission_id'           => $admission->id, // Reference to Admission History
                    'academic_year_id'       => $academicYear->id,
                    'class_id'               => $admission->class_id,
                    'section_id'             => $sectionId,
                    'school_category_id'     => $categoryId,
                    'school_sub_category_id' => $subCategoryId,
                    'student_id'             => $studentId,
                    'roll'                   => $nextRoll,
                    'name'                   => $admission->name,
                    'email'                  => $admission->email,
                    'contact_number'         => $admission->contact_number,
                    'fathers_name'           => $admission->fathers_name,
                    'mothers_name'           => $admission->mothers_name,
                    'father_nid'             => $admission->father_nid,
                    'mother_nid'             => $admission->mother_nid,
                    'student_birth_nid'      => $admission->student_birth_nid,
                    'gender'                 => $admission->gender,
                    'religion'               => $admission->religion,
                    'blood_group'            => $admission->blood_group,
                    'date_of_birth'          => $admission->date_of_birth,
                    'admission_date'         => $admissionDate,
                    'address'                => $admission->address,
                    'previous_school'        => $admission->previous_school,
                    'previous_class'         => $admission->previous_class,
                    'photo'                  => $finalPhotoPath,
                    'status'                 => 'active',
                    'password'               => $admission->password,
                ]);

                // Update Admission status to approved (preserves history)
                $admission->update(['status' => 'approved']);
                $approvedCount++;
            }
        });

        return back()->with([
            'success' => $approvedCount . ' জন শিক্ষার্থী সফলভাবে ভর্তি করা হয়েছে।',
            'type'    => 'success'
        ]);
    }

    /**
     * Reject Admission
     */
    public function reject(Request $request, $tenant, Admission $admission)
    {
        abort_if($admission->school_id !== auth()->user()->school_id, 403);

        $request->validate([
            'admin_note' => 'nullable|string'
        ]);

        $admission->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Admission rejected successfully.');
    }

    /**
     * Delete Admission
     */
    public function destroy($tenant, Admission $admission)
    {
        abort_if($admission->school_id !== auth()->user()->school_id, 403);

        // ফটো থাকলে মুছে ফেলা
        if ($admission->photo && file_exists(public_path($admission->photo))) {
            @unlink(public_path($admission->photo));
        }

        $admission->delete();

        return back()->with('success', 'Admission deleted successfully.');
    }
}