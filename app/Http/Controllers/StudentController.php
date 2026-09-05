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
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

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

        // ৪. সাপ্তাহিক ক্লাস রুটিন (স্টুডেন্টের নিজ ক্লাসের জন্য)
        $routines = \App\Models\Routine::where('school_id', $user->school_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->with(['subject', 'teacher'])
            ->orderBy(DB::raw("FIELD(day, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('school.student.dashboard', compact(
            'student', 
            'diaries', 
            'unpaidFees', 
            'totalDue', 
            'attendancePercentage',
            'presentDays',
            'totalDays',
            'routines'
        ));
    }
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $query = Student::where('school_id', $schoolId)
            ->with(['class', 'section', 'category', 'group', 'user']);

        // Search Filter (Combined search or field specific)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('fathers_name', 'like', "%{$search}%")
                  ->orWhere('mothers_name', 'like', "%{$search}%")
                  ->orWhere('student_birth_nid', 'like', "%{$search}%");
            });
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', 'like', '%' . trim($request->student_id) . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . trim($request->name) . '%');
        }

        if ($request->filled('contact')) {
            $query->where('contact_number', 'like', '%' . trim($request->contact) . '%');
        }

        // Class & Section Filter
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'roll_asc':
                $query->orderBy('roll', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $students = $query->paginate(15)->withQueryString();
        $activeStudents = Student::where('school_id', $schoolId)->where('status', 'active')->count();

        $classes = Classes::where('school_id', $schoolId)->orderBy('name')->get();
        $sections = Section::where('school_id', $schoolId)->orderBy('name')->get();

        if ($request->ajax()) {
            return view('school.student.partials.table', compact('students', 'activeStudents', 'classes', 'sections'))->render();
        }

        return view('school.student.index', compact('students', 'activeStudents', 'classes', 'sections'));
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
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users,email',
            'password'               => 'nullable|string|min:6',
            'class_id'               => 'required|exists:classes,id',
            'school_category_id'     => 'required',
            'school_sub_category_id' => 'nullable',
            'section_id'             => 'required|exists:sections,id',
            'father_nid'             => [
                'nullable',
                'string',
                'regex:/^(\d{10}|\d{17})$/'
            ],
            'mother_nid'             => [
                'nullable',
                'string',
                'regex:/^(\d{10}|\d{17})$/'
            ],
            'student_birth_nid'      => [
                'required',
                'string',
                'regex:/^\d{17}$/',
                'unique:students,student_birth_nid'
            ],
            'date_of_birth'          => 'nullable|date|before:today',
            'gender'                 => 'nullable|in:male,female,other',
            'phone'                  => [
                'nullable',
                'string',
                'regex:/^01[3-9]\d{8}$/'
            ],
            'admission_date'         => 'required|date',
            'address'                => 'nullable|string|max:500',
            'religion'               => 'required|string|max:50',
            'blood_group'            => 'nullable|string|max:10',
            'photo'                  => 'nullable|image|max:2048',
        ], [
            'email.unique'               => 'এই ইমেইল ঠিকানাটি ইতিমধ্যে ব্যবহার করা হয়েছে। অন্য ইমেইল প্রদান করুন।',
            'phone.regex'                => 'ফোন নম্বরটি সঠিক নয় (১১ ডিজিট হতে হবে এবং 01 দিয়ে শুরু হতে হবে)।',
            'father_nid.regex'           => 'পিতার এনআইডি (NID) নম্বরটি অবশ্যই ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে।',
            'mother_nid.regex'           => 'মাতার এনআইডি (NID) নম্বরটি অবশ্যই ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে।',
            'student_birth_nid.required' => 'শিক্ষার্থীর জন্ম নিবন্ধন নম্বর প্রদান করা আবশ্যক।',
            'student_birth_nid.regex'    => 'শিক্ষার্থীর জন্ম নিবন্ধন নম্বরটি অবশ্যই ১৭ ডিজিটের হতে হবে।',
            'student_birth_nid.unique'   => 'এই জন্ম নিবন্ধন নম্বরটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
        ]);

        $schoolId = auth()->user()->school_id;
        $academicYear = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', 1)
            ->firstOrFail();

        $tenantSlug = auth()->user()->school->slug;
        $photoPath = null;
        $password = $request->filled('password') ? $request->password : '12345678';

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
        DB::transaction(function () use ($schoolId, $request, $validated, $academicYear, $photoPath, $tenantSlug, $password) {
            
            // ১. ইউজার তৈরি
            $user = User::create([
                'school_id' => $schoolId,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($password),
                'role'      => 'student',
            ]);

            if (method_exists($user, 'assignRole')) {
                    $user->assignRole('student');
                }
            // ২. স্টুডেন্ট তৈরি (school_category_id ও বাংলা ফিল্ড সহ)
            $student = Student::create([
                'user_id'                => $user->id,
                'school_id'              => $schoolId,
                'academic_year_id'       => $academicYear->id,
                'class_id'               => $validated['class_id'],
                'school_category_id'     => $validated['school_category_id'],
                'school_sub_category_id' => $request->school_sub_category_id,
                'section_id'             => $validated['section_id'],
                'student_id'             => $this->generateUniqueStudentId($schoolId, $academicYear),
                'roll'                   => $this->getNextRoll($schoolId, $validated['class_id'], $academicYear->id, $request->school_sub_category_id),
                'name'                   => $validated['name'],
                'name_bn'                => $request->name_bn,
                'fathers_name'           => $request->fathers_name ?? $request->father_name,
                'fathers_name_bn'        => $request->fathers_name_bn,
                'mothers_name'           => $request->mothers_name ?? $request->mother_name,
                'mothers_name_bn'        => $request->mothers_name_bn,
                'father_nid'             => $request->father_nid,
                'mother_nid'             => $request->mother_nid,
                'student_birth_nid'      => $request->student_birth_nid,
                'previous_school'        => $request->previous_school,
                'previous_school_bn'     => $request->previous_school_bn,
                'previous_class'         => $request->previous_class,
                'previous_class_bn'      => $request->previous_class_bn,
                'date_of_birth'          => $request->date_of_birth,
                'gender'                 => $request->gender ? strtolower($request->gender) : null,
                'contact_number'         => $request->contact_number ?? $request->phone,
                'admission_date'         => $request->admission_date,
                'address'                => $request->address,
                'address_bn'             => $request->address_bn,
                'religion'               => $request->religion,
                'blood_group'            => $request->blood_group,
                'photo'                  => $photoPath,
                'status'                 => 'active',
                'password'               => Hash::make($password),
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

        if (auth()->user()->role == 'student') {
            $student = Student::where('user_id', auth()->id())->firstOrFail();
        } else {
            // এডমিন হলে আইডি এবং স্কুল আইডি দিয়ে খুঁজবে
            $student = Student::where('id', $student)->where('school_id', $schoolId)->firstOrFail();
        }

        $userId = $student->user ? $student->user->id : 'NULL';

        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'name_bn'                => 'nullable|string|max:255',
            'email'                  => 'required|email|unique:users,email,' . $userId,
            'class_id'               => 'nullable|exists:classes,id',
            'section_id'             => 'nullable|exists:sections,id',
            'school_category_id'     => 'nullable',
            'school_sub_category_id' => 'nullable',
            'roll'                   => [
                'required',
                'integer',
                'min:1',
                Rule::unique('students', 'roll')->where(function ($query) use ($schoolId, $student, $request) {
                    $query->where('school_id', $schoolId)
                        ->where('academic_year_id', $student->academic_year_id)
                        ->where('class_id', $request->input('class_id', $student->class_id));

                    $subCategoryId = $request->input('school_sub_category_id', $student->school_sub_category_id);
                    $subCategoryId === null || $subCategoryId === ''
                        ? $query->whereNull('school_sub_category_id')
                        : $query->where('school_sub_category_id', $subCategoryId);
                })->ignore($student->id),
            ],
            'fathers_name'           => 'nullable|string|max:255',
            'fathers_name_bn'        => 'nullable|string|max:255',
            'father_name'            => 'nullable|string|max:255',
            'mothers_name'           => 'nullable|string|max:255',
            'mothers_name_bn'        => 'nullable|string|max:255',
            'mother_name'            => 'nullable|string|max:255',
            'father_nid'             => 'nullable|string|max:20',
            'mother_nid'             => 'nullable|string|max:20',
            'student_birth_nid'      => 'nullable|string|max:25',
            'date_of_birth'          => 'nullable|date',
            'gender'                 => 'nullable|string|max:20',
            'contact_number'         => 'nullable|string|max:20',
            'phone'                  => 'nullable|string|max:20',
            'religion'               => 'nullable|string|max:50',
            'blood_group'            => 'nullable|string|max:10',
            'previous_school'        => 'nullable|string|max:255',
            'previous_school_bn'     => 'nullable|string|max:255',
            'previous_class'         => 'nullable|string|max:255',
            'previous_class_bn'      => 'nullable|string|max:255',
            'admission_date'         => 'nullable|date',
            'address'                => 'nullable|string|max:500',
            'address_bn'             => 'nullable|string|max:500',
            'photo'                  => 'nullable|image|max:2048',
        ], [
            'roll.required' => 'Roll number is required.',
            'roll.integer'  => 'Roll number must be a whole number.',
            'roll.min'      => 'Roll number must be at least 1.',
            'roll.unique'   => 'এই class/group-এ এই roll number ইতিমধ্যে ব্যবহার করা হয়েছে।',
        ]);

        $tenantSlug = auth()->user()->school->slug ?? $tenant;

        $photoPath = $student->photo ?? null;

        if ($request->hasFile('photo')) {
            $folder = public_path("uploads/schools/{$tenantSlug}/students");

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            // delete old photo
            if ($student->photo && file_exists(public_path($student->photo))) {
                @unlink(public_path($student->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $filename);
            $photoPath = "uploads/schools/{$tenantSlug}/students/" . $filename;
        }

        // Update Data
        DB::transaction(function () use ($student, $request, $validated, $photoPath) {
            if ($student->user) {
                $student->user->update([
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                ]);
            }

            $student->update([
                'name'                   => $validated['name'],
                'name_bn'                => $request->has('name_bn') ? $request->name_bn : $student->name_bn,
                'class_id'               => $request->filled('class_id') ? $request->class_id : $student->class_id,
                'school_category_id'     => $request->filled('school_category_id') ? $request->school_category_id : $student->school_category_id,
                'school_sub_category_id' => $request->filled('school_sub_category_id') ? $request->school_sub_category_id : $student->school_sub_category_id,
                'section_id'             => $request->filled('section_id') ? $request->section_id : $student->section_id,
                'roll'                   => $validated['roll'],
                'fathers_name'           => $request->fathers_name ?? $request->father_name ?? $student->fathers_name,
                'fathers_name_bn'        => $request->has('fathers_name_bn') ? $request->fathers_name_bn : $student->fathers_name_bn,
                'mothers_name'           => $request->mothers_name ?? $request->mother_name ?? $student->mothers_name,
                'mothers_name_bn'        => $request->has('mothers_name_bn') ? $request->mothers_name_bn : $student->mothers_name_bn,
                'father_nid'             => $request->has('father_nid') ? $request->father_nid : $student->father_nid,
                'mother_nid'             => $request->has('mother_nid') ? $request->mother_nid : $student->mother_nid,
                'student_birth_nid'      => $request->has('student_birth_nid') ? $request->student_birth_nid : $student->student_birth_nid,
                'date_of_birth'          => $request->has('date_of_birth') ? $request->date_of_birth : $student->date_of_birth,
                'gender'                 => $request->gender ? strtolower($request->gender) : $student->gender,
                'contact_number'         => $request->contact_number ?? $request->phone ?? $student->contact_number,
                'previous_school'        => $request->has('previous_school') ? $request->previous_school : $student->previous_school,
                'previous_school_bn'     => $request->has('previous_school_bn') ? $request->previous_school_bn : $student->previous_school_bn,
                'previous_class'         => $request->has('previous_class') ? $request->previous_class : $student->previous_class,
                'previous_class_bn'      => $request->has('previous_class_bn') ? $request->previous_class_bn : $student->previous_class_bn,
                'admission_date'         => $request->admission_date ?? $student->admission_date,
                'address'                => $request->has('address') ? $request->address : $student->address,
                'address_bn'             => $request->has('address_bn') ? $request->address_bn : $student->address_bn,
                'religion'               => $request->religion ?? $student->religion,
                'blood_group'            => $request->blood_group ?? $student->blood_group,
                'photo'                  => $photoPath,
            ]);
        });

        return redirect()->route('students.index', ['tenant' => $tenantSlug])->with([
            'success' => 'Student updated successfully',
            'type'    => 'success'
        ]);
    }

    // ইউনিক আইডি এবং রোল জেনারেশনের জন্য হেল্পার মেথড (কোড ক্লিন রাখার জন্য)
    private function generateUniqueStudentId($schoolId, $academicYear) {
        return Student::generateStudentId($schoolId, $academicYear);
    }

    private function getNextRoll($schoolId, $classId, $academicYearId, $subCategoryId = null) {
        $query = Student::where('school_id', $schoolId)
            ->where('class_id', $classId)
            ->where('academic_year_id', $academicYearId);

        if ($subCategoryId) {
            $query->where('school_sub_category_id', $subCategoryId);
        } else {
            $query->whereNull('school_sub_category_id');
        }

        $lastRoll = $query->max('roll');
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $importer = new StudentsImport();
            Excel::import($importer, $request->file('file'));

            $success = $importer->successCount;
            $skipped = $importer->skipCount;
            $errors  = $importer->importErrors;

            if ($success === 0 && count($errors) > 0) {
                // Nothing imported at all
                $errorText = implode("\n", $errors);
                return back()->with('import_errors', $errors)
                             ->with('error', "কোনো student import হয়নি। নিচের সমস্যাগুলো সমাধান করুন:\n" . $errorText);
            }

            if (count($errors) > 0) {
                // Partial import
                return back()
                    ->with('import_errors', $errors)
                    ->with('import_success_count', $success)
                    ->with('import_skip_count', $skipped)
                    ->with('warning', "{$success} জন student সফলভাবে import হয়েছে। {$skipped} টি row এ সমস্যা পাওয়া গেছে।");
            }

            return back()->with('success', "{$success} জন student সফলভাবে import হয়েছে!");

        } catch (\Exception $e) {
            // Fatal error (e.g. no active academic year, file unreadable)
            $msg = $e->getMessage();
            // Strip raw SQL if present — only show the sentence before "SQL:"
            if (str_contains($msg, '(SQL:')) {
                $msg = trim(substr($msg, 0, strpos($msg, '(SQL:')));
            }
            return back()->with('error', 'Import ব্যর্থ হয়েছে: ' . $msg);
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
        $schoolId = auth()->user()->school_id;
        $classes = Classes::where('school_id', $schoolId)->withCount('students')->get();
        $totalStudents = Student::where('school_id', $schoolId)->count();
        return view('school.student.id_card_index', compact('classes', 'totalStudents'));
    }
    public function idCardPreview(Request $request) 
    {
        $school = auth()->user()?->school;
        if ($school && !$school->hasPackagePermission('student.idcard')) {
            return redirect()->route('students.idcard.index', ['tenant' => $school->slug])
                ->with('error', 'স্টুডেন্ট আইডি কার্ড প্রিভিউ ও জেনারেট সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। অনুগ্রহ করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

        $schoolId = auth()->user()->school_id;
        $class_id = $request->class_id;
        $selectedClass = Classes::where('school_id', $schoolId)->find($class_id);
        $students = Student::where('school_id', $schoolId)
                        ->where('class_id', $class_id)
                        ->with(['class', 'academicYear', 'school'])
                        ->orderBy('roll', 'asc')
                        ->get();
        
        return view('school.student.id_card_preview', compact('students', 'class_id', 'selectedClass'));
    }


    public function idCardDownload($tenant, $class_id) 
    {
        $school = auth()->user()?->school;
        if ($school && !$school->hasPackagePermission('student.idcard')) {
            return redirect()->route('students.idcard.index', ['tenant' => $school->slug])
                ->with('error', 'স্টুডেন্ট আইডি কার্ড ডাউনলোড সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। অনুগ্রহ করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

        $schoolId = auth()->user()->school_id;
        $class = Classes::where('school_id', $schoolId)->findOrFail($class_id);
        $students = Student::where('class_id', $class_id)
                    ->where('school_id', $schoolId)
                    ->with(['class', 'academicYear', 'school'])
                    ->orderBy('roll', 'asc')
                    ->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'এই ক্লাসে কোনো শিক্ষার্থী খুঁজে পাওয়া যায়নি!');
        }

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $pdf = Pdf::loadView('school.student.bulk_id_cards_pdf', compact('students', 'school', 'class'));
        $fileName = 'id-cards-' . Str::slug($class->name) . '-' . date('Ymd') . '.pdf';
        return $pdf->setPaper('a4', 'landscape')->download($fileName);
    }
}
