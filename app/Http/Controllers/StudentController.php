<?php

namespace App\Http\Controllers;

use App\Models\SchoolCategory;
use App\Models\SchoolSubCategory;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Section;
use App\Models\FeeHead;
use App\Models\StudentFee;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\LessonPlan;
use App\Models\FeeAmount;
use Illuminate\Support\Facades\Hash;
use App\Imports\StudentsImport;
use App\Exports\StudentsExport;
use App\Exports\StudentTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function studentDashboard($tenant)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student || !$student->class_id || !$student->section_id) {
            return back()->with([
                'success' => 'আপনার স্টুডেন্ট প্রোফাইল বা ক্লাস/সেকশন তথ্য পাওয়া যায়নি।',
                'type' => 'error'
            ]);
        }

        // ১. আজকের ডিজিটাল ডায়েরি (Lesson Plan)
        $diaries = LessonPlan::where('class_id', $student->class_id)
                    ->where('section_id', $student->section_id)
                    ->whereDate('date', now())
                    ->with(['subject', 'user']) 
                    ->latest()
                    ->get();

        // ২. বকেয়া ফি (Unpaid Fees Summary)
        $unpaidFees = StudentFee::where('student_id', $student->id)
                    ->where('status', 'unpaid')
                    ->with('feeHead')
                    ->get();
        
        $totalDue = $unpaidFees->sum('amount');

        // ৩. শেষ ৩০ দিনের হাজিরা রিপোর্ট (Attendance Summary)
        $totalDays = Attendance::where('student_id', $student->id)
                    ->whereMonth('date', now()->month)
                    ->count();
                    
        $presentDays = Attendance::where('student_id', $student->id)
                    ->whereMonth('date', now()->month)
                    ->where('status', 'present')
                    ->count();

        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

        return view('school.student.dashboard', compact(
            'student', 
            'diaries', 
            'unpaidFees', 
            'totalDue', 
            'attendancePercentage',
            'presentDays',
            'totalDays'
        ));
    }
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        // ১. কোয়েরি বিল্ডার শুরু করা (এখনই গেট বা পেজিনেট করা যাবে না)
        $query = Student::where('school_id', $schoolId)
            ->with(['class', 'section', 'category', 'group']);

        // ২. সার্চ ফিল্টারসমূহ যোগ করা
        if ($request->filled('student_id')) {
            $query->where('student_id', 'like', '%' . $request->student_id . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('contact')) {
            // ডাটাবেজ কলামের নাম contact_number কি না নিশ্চিত হয়ে নিন
            $query->where('contact_number', 'like', '%' . $request->contact . '%');
        }

        // ৩. সর্টিং এবং পেজিনেশন (সবশেষে)
        $students = $query->orderBy('roll', 'asc')->paginate(10);

        // ৪. একটিভ স্টুডেন্ট কাউন্ট (এটি আগের মতোই থাকবে)
        $activeStudents = Student::where('school_id', $schoolId)->where('status', 'active')->count();

        // ৫. AJAX রেসপন্স হ্যান্ডেলিং
        if ($request->ajax()) {
            return view('school.student.partials.table', compact('students', 'activeStudents'))->render();
        }

        return view('school.student.index', compact('students', 'activeStudents'));
    }
    public function getSubCategories($tenant, $categoryId)
    {
        $subCategories = SchoolSubCategory::where('school_category_id', $categoryId)
                        ->where('school_id', auth()->user()->school_id)
                        ->get(['id', 'name']);
                        
        return response()->json($subCategories);
    }
    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        return view('school.student.create', compact('classes', 'sections', 'categories'));
    }

    public function store($tenant, Request $request)
    {
        // ১. আলাদা আসা দিন, মাস, বছরকে এক করে 'date_of_birth' তৈরি করা
        if ($request->filled(['dob_year', 'dob_month', 'dob_day'])) {
            $dob = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
            $request->merge(['date_of_birth' => $dob]);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'class_id' => 'required|exists:classes,id',
            'school_category_id' => 'required',
            'school_sub_category_id' => 'nullable',
            'section_id' => 'required|exists:sections,id',
            'father_nid' => 'nullable|string|max:255',
            'student_birth_nid' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:11',
            'admission_date' => 'required|date',
            'address' => 'nullable|string|max:500',
            'religion' => 'required|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        $schoolId = auth()->user()->school_id;
        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->firstOrFail();

        $tenantSlug = auth()->user()->school->slug;
        $photoPath = null;

        // ১. ফটো হ্যান্ডেলিং
        if ($request->hasFile('photo')) {
            $folder = public_path("uploads/schools/{$tenantSlug}/students");
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $filename);
            $photoPath = "uploads/schools/{$tenantSlug}/students/" . $filename;
        }

        // ট্রানজ্যাকশন শুরু
        DB::transaction(function () use ($schoolId, $request, $validated, $academicYear, $photoPath, $tenantSlug) {
            
            // ১. ইউজার তৈরি
            $user = User::create([
                'school_id' => $schoolId,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($request->password),
                'role'      => 'student',
            ]);

            if (method_exists($user, 'assignRole')) {
                    $user->assignRole('student');
                }
            // ২. স্টুডেন্ট তৈরি (school_category_id সহ)
            $student = Student::create([
                'user_id'                => $user->id,
                'school_id'              => $schoolId,
                'academic_year_id'       => $academicYear->id,
                'class_id'               => $validated['class_id'],
                'school_category_id'     => $validated['school_category_id'], // ইনসার্ট করা হচ্ছে
                'school_sub_category_id' => $request->school_sub_category_id,
                'section_id'             => $validated['section_id'],
                'student_id'             => $this->generateUniqueStudentId($schoolId, $academicYear), // আলাদা মেথডে করা ভালো
                'roll'                   => $this->getNextRoll($schoolId, $validated['class_id'], $academicYear->id),
                'name'                   => $validated['name'],
                'fathers_name'           => $request->father_name,
                'mothers_name'           => $request->mother_name,
                'date_of_birth'          => $request->date_of_birth,
                'gender'                 => $request->gender,
                'contact_number'         => $request->phone,
                'admission_date'         => $request->admission_date,
                'address'                => $request->address,
                'religion'               => $request->religion,
                'photo'                  => $photoPath,
                'status'                 => 'active',
                'password'               => Hash::make($request->password),
                'created_by'             => auth()->id(),
            ]);

            // ৬. অ্যাডমিশন ফি জেনারেশন
            $admissionFeeHead = FeeHead::where('school_id', $schoolId)
                ->where('name', 'LIKE', '%Admission%')
                ->first();

            if ($admissionFeeHead) {
                $feeAmount = FeeAmount::where('school_id', $schoolId)
                    ->where('fee_head_id', $admissionFeeHead->id)
                    ->where('class_id', $student->class_id)
                    ->first();

                if ($feeAmount) {
                    StudentFee::create([
                        'school_id'   => $schoolId,
                        'student_id'  => $student->id,
                        'fee_head_id' => $admissionFeeHead->id,
                        'amount'      => $feeAmount->amount,
                        'month'       => now()->format('F-Y'),
                        'status'      => 'unpaid',
                        'due_date'    => $request->admission_date,
                    ]);
                }
            }
        });

        return redirect()->route('students.index', ['tenant' => $tenantSlug])
            ->with('success', 'Student created and Admission Fee generated successfully.');
    }
    public function edit($tenant, $student)
    {
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->get();
        $categories = SchoolCategory::where('school_id', $schoolId)->get();
        $groups = SchoolSubCategory::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
       
        $student = Student::where('id', $student)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();
        return view('school.student.edit', compact('student', 'classes', 'categories','groups', 'sections', 'tenant'));
    }

    public function update(Request $request, $tenant, $student)
    {
        $schoolId = auth()->user()->school_id;

        if(auth()->user()->role == 'student') {
            $student = Student::where('user_id', auth()->id())->firstOrFail();
        } else {
            // এডমিন হলে আইডি এবং স্কুল আইডি দিয়ে খুঁজবে
            $student = Student::where('id', $student)->where('school_id', $schoolId)->firstOrFail();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user->id,
            'school_category_id' => 'required',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'contact_number' => 'nullable|string|max:11',
            'religion' => 'required|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        $tenant = auth()->user()->school->slug;

        $photoPath = $student->photo ?? null;

        if ($request->hasFile('photo')) {

            $folder = public_path("uploads/schools/{$tenant}/students");

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            // delete old photo
            if ($student->photo && file_exists(public_path($student->photo))) {
                unlink(public_path($student->photo));
            }

            $file = $request->file('photo');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move($folder, $filename);

            $photoPath = "uploads/schools/{$tenant}/students/".$filename;
        }

        // Update Data
        DB::transaction(function () use ($student, $request, $validated, $photoPath) {

            if ($student->user) {
                $student->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);
            }
           
            $student->update([
                'name' => $validated['name'],
                'class_id' => $request->class_id,
                'school_category_id'     => $request->school_category_id,
                'school_sub_category_id' => $request->school_sub_category_id,
                'section_id' => $request->section_id,
                'fathers_name' => $request->father_name,
                'mothers_name' => $request->mother_name,
                'mother_nid' => $request->mother_nid,
                'father_nid' => $request->father_nid,
                'student_birth_nid' => $request->student_birth_nid,
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'contact_number' => $validated['contact_number'],
                'previous_school' => $request->previous_school,
                'previous_class' => $request->previous_class,
                'admission_date' => $request->admission_date,
                'address' => $request->address,
                'religion' => $validated['religion'],
                'blood_group' => $validated['blood_group'],
                'photo' => $photoPath,
            ]);
        });

        // Password update only if provide

        return redirect()->route('students.index', $tenant)->with([
            'success' => 'Student updated successfully',
            'type' => 'success'
        ]);
    }

    // ইউনিক আইডি এবং রোল জেনারেশনের জন্য হেল্পার মেথড (কোড ক্লিন রাখার জন্য)
    private function generateUniqueStudentId($schoolId, $academicYear) {
        $yearPart = substr($academicYear->name, -2);
        $prefix = 'STD-' . $yearPart;
        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');
        $nextNumber = $lastSerial ? $lastSerial + 1 : 1001;
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    private function getNextRoll($schoolId, $classId, $academicYearId) {
        $lastRoll = Student::where('school_id', $schoolId)
            ->where('class_id', $classId)
            ->where('academic_year_id', $academicYearId)
            ->max('roll');
        return $lastRoll ? $lastRoll + 1 : 1;
    }

    public function destroy($tenant, $student)
    {
        $schoolId = auth()->user()->school_id;
        $student = Student::where('id', $student)->where('school_id', $schoolId)->firstOrFail();

        DB::transaction(function () use ($student) {
            // ১. আগে ইউজার ডিলিট (যদি থাকে)
            if ($student->user) {
                $student->user->delete();
            }
            // ২. স্টুডেন্ট ডিলিট
            $student->delete();
        });

        return back()->with('success', 'Student deleted successfully.');
    }

    public function importForm(){
        return view('school.student.import', );
    }

    public function import(Request $request )
    {
        
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
        Excel::import(new StudentsImport, $request->file('file'));
            return back()->with('success', 'Students imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error during import: ' . $e->getMessage());
        }
    }
    public function export() 
    {
        $fileName = 'students_list_' . now()->format('Y_m_d_His') . '.xlsx';
        return Excel::download(new StudentsExport, $fileName);
    }

    public function downloadTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'student_import_template.xlsx');
    }

    public function generateIDCard($tenant, $student)
    {
        $schoolId = auth()->user()->school_id;
        $student = Student::where('school_id', $schoolId)
                        ->with(['class', 'section', 'school'])
                        ->findOrFail($student);

        return view('school.student.id_card', compact('student'));
    }

    public function idCardIndex() 
    {
        $classes = Classes::where('school_id', auth()->user()->school_id)->get();
        return view('school.student.id_card_index', compact('classes'));
    }
    public function idCardPreview(Request $request) 
    {
        $schoolId = auth()->user()->school_id;
        $class_id = $request->class_id;
        $students = Student::where('school_id', $schoolId)
                        ->where('class_id', $class_id)
                        ->with('class')
                        ->get();
        
        return view('school.student.id_card_preview', compact('students', 'class_id'));
    }


    public function idCardPrint($tenant, $class_id) 
    {
        $schoolId = auth()->user()->school_id;
        $students = Student::where('class_id', $class_id)
                    ->where('school_id', $schoolId)
                    ->with(['class', 'school'])
                    ->get();

        
        if ($students->isEmpty()) {
            return "এই ক্লাসে কোনো শিক্ষার্থী খুঁজে পাওয়া যায়নি!";
        }

        return view('school.student.bulk_id_cards', compact('students', 'class_id'));
    }

    
}
