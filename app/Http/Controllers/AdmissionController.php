<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Student;
use App\Models\Classes;
use App\Models\AcademicYear;
use App\Models\Section;
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
            ->latest()
            ->get();
        return view('school.admission.index', compact('admissions'));
    }

    /**
     * Public Form
     */
    public function create()
    {
        $classes = Classes::where('school_id', app('currentSchool')->id)->get();
        $sections = Section::where('school_id', app('currentSchool')->id)->get();
        return view('school.website.admission', compact('classes', 'sections'));
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
        $tenantSlug = $currentSchool->slug; // এখান থেকে আমরা ডাইনামিক ফোল্ডার নাম পাবো

        // ৩. ক্লাস এবং একাডেমিক ইয়ার চেক
        $class = Classes::where('id', $validated['class_id'])
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->firstOrFail();

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

    public function approve($tenant, Admission $admission)
    {
        // ১. সিকিউরিটি চেক
        abort_if($admission->school_id !== auth()->user()->school_id, 403);

        $currentSchool = app('currentSchool');
        $schoolId = $currentSchool->id;
        $tenantSlug = $currentSchool->slug;

        // ২. ডাইনামিকভাবে ডিফল্ট সেকশন খুঁজে বের করা (ওই স্কুল ও ক্লাসের জন্য)
        $defaultSection = Section::where('school_id', $schoolId)->first();

        if (!$defaultSection) {
            return back()->with([
                'success' => 'এই ক্লাসের জন্য কোনো সেকশন খুঁজে পাওয়া যায়নি। আগে সেকশন তৈরি করুন।',
                'type'    => 'danger'
            ]);
        }

        $sectionId = $defaultSection->id;

        // ৩. একটিভ একাডেমিক ইয়ার খুঁজে বের করা
        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->firstOrFail();

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
        DB::transaction(function () use ($admission, $studentId, $schoolId, $admissionDate, $finalPhotoPath, $sectionId, $nextRoll) {
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
            // স্টুডেন্ট টেবিলে ডাটা ইনসার্ট
            Student::create([
                'user_id'           => $user->id,
                'school_id'         => $schoolId,
                'academic_year_id'  => $admission->academic_year_id,
                'class_id'          => $admission->class_id,
                'section_id'        => $sectionId,
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
                'password'          => $admission->password, // হ্যাস করা পাসওয়ার্ড
            ]);

            // অ্যাডমিশন রেকর্ড ডিলিট করা
            $admission->delete();
        });

        return back()->with([
            'success' => 'শিক্ষার্থী সফলভাবে ভর্তি করা হয়েছে। আইডি: ' . $studentId,
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
            'admin_note' => 'required|string'
        ]);

        // ৩. আপডেট
        $admission->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Admission rejected successfully.');
    }

    /**
     * Delete Admission
     */
}