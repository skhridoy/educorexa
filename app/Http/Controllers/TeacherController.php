<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Routine;
use App\Models\LessonPlan;
use App\Models\LeaveRequest;
use App\Models\Notice;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Imports\TeacherImport;
use App\Models\School;
use App\Mail\TeacherCredentialsMail;
use App\Traits\SchoolMailConfig;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TeacherController extends Controller
{
    use SchoolMailConfig;
    /**
     * Display a listing of the resource.
     */
    public function teacherDashboard()
    {
        $schoolId = auth()->user()->school_id;
        $user = Auth::user();
        $teacher = $user->teacher;
        $teacherId = $teacher?->id;
        $today = Carbon::today()->format('Y-m-d');
        $dayName = Carbon::today()->format('l');

        $totalStudents = Student::where('school_id', $user->school_id)->count();

        // ২. আজকের দিনে এই শিক্ষকের মোট কয়টি ক্লাস আছে
        // $routines = Routine::where('school_id', $user->school_id)
        //     ->where('teacher_id', $user->id)
        //     ->where('day', $dayName)
        //     ->with(['class', 'section', 'subject'])
        //     ->orderBy('start_time', 'asc')
        //     ->get();

        // $todayClassesCount = $routines->count();

        // ৩. আজকের ডায়েরি বা হোমওয়ার্ক কয়টি এন্ট্রি করা হয়েছে
        $pendingDiaries = LessonPlan::where('school_id', $user->school_id)
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->whereDate('created_at', $today)
            ->count();

        // ৪. পেন্ডিং ছুটির আবেদন (যদি টিচার কোনো ডিপার্টমেন্ট হেড হন বা নিজের আবেদন দেখতে চান)
        // $leaveRequests = LeaveRequest::where('school_id', $user->school_id)
        //     ->where('user_id', $user->id)
        //     ->where('status', 'pending')
        //     ->count();

        // ৫. লেটেস্ট নোটিশ (স্কুলের সাধারণ নোটিশ)
        $notices = Notice::where('school_id', $user->school_id)
            ->where('is_active', 1)
            ->latest()
            ->take(5)
            ->get();

        // ১. আজকের মোট কালেকশন (শিক্ষক নিজে যা করেছেন)
        $todayCollected = StudentFee::where('school_id', $user->school_id)
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->where('collected_by', $teacherId);
            })
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $myTotalCollected = StudentFee::where('school_id', $user->school_id)
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->where('collected_by', $teacherId);
            })
            ->sum('amount');

        $recentCollections = StudentFee::where('school_id', $schoolId)
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->where('collected_by', $teacherId);
            })
            ->with(['student', 'feeHead'])
            ->latest()
            ->take(5)
            ->get();
            
        // ৬. চার্টের জন্য বিগত ৭ দিনের হাজিরার ডেটা (Line Chart Data)
        $lastSevenDays = [];
        $attendanceStats = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $lastSevenDays[] = $date->format('D'); // Sat, Sun...

            // এই শিক্ষকের সেকশনের স্টুডেন্টদের গড় হাজিরা পারসেন্টেজ (উদাহরণস্বরূপ)
            $stats = Attendance::where('school_id', $schoolId)
                ->whereDate('date', $date->format('Y-m-d'))
                ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present')
                ->first();

            $percentage = ($stats->total > 0) ? ($stats->present / $stats->total) * 100 : 0;
            $attendanceStats[] = round($percentage, 2);
        }

        // ৭. সাপ্তাহিক ক্লাস রুটিন (শিক্ষকের নিজের জন্য)
        $routines = Routine::where('school_id', $schoolId)
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->with(['class', 'section', 'subject'])
            ->orderBy(DB::raw("FIELD(day, 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')"))
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('school.teacher.dashboard', compact(
            'totalStudents',
            'pendingDiaries',
            'notices',
            'lastSevenDays',
            'attendanceStats',
            'todayCollected',
            'myTotalCollected',
            'recentCollections',
            'routines'
        ));
    }
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        $query = Teacher::with('subject')->where('school_id', $schoolId);

        // Filter by Search (Name, Teacher ID, Email, Phone, Designation, Qualification, NID)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('teacher_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('qualification', 'like', "%{$search}%")
                  ->orWhere('nid', 'like', "%{$search}%");
            });
        }

        // Filter by Subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
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
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $teachers = $query->paginate(15)->withQueryString();
        $subjects = Subject::where('school_id', $schoolId)->orderBy('name')->get();

        return view('school.teacher.index', compact('teachers', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
        return view('school.teacher.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ১. আলাদা আসা দিন, মাস, বছরকে এক করে 'date_of_birth' তৈরি করা
        if ($request->filled(['dob_year', 'dob_month', 'dob_day'])) {
            $dob = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
            $request->merge(['date_of_birth' => $dob]);
        }
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'subject_id'   => 'required|exists:subjects,id',
            'date_of_birth' => 'nullable|date|before:today',
            'gender'        => 'nullable|in:male,female,other',
            'email'         => 'required|email|max:255|unique:users,email|unique:teachers,email',
            'phone'         => [
                'required',
                'string',
                'regex:/^01[3-9]\d{8}$/',
                'unique:teachers,phone'
            ],
            'nid'           => [
                'nullable',
                'string',
                'regex:/^(\d{10}|\d{17})$/',
                'unique:teachers,nid'
            ],
            'blood_group'   => 'nullable|string|max:10',
            'joining_date'  => 'nullable|date',
            'address'       => 'nullable|string|max:500',
        ], [
            'email.unique' => 'এই ইমেইল ঠিকানাটি ইতিমধ্যে ব্যবহার করা হয়েছে। অন্য ইমেইল প্রদান করুন।',
            'phone.required' => 'ফোন নম্বর প্রদান করা আবশ্যক।',
            'phone.regex'  => 'ফোন নম্বরটি সঠিক নয় (১১ ডিজিট হতে হবে এবং 01 দিয়ে শুরু হতে হবে)।',
            'phone.unique' => 'এই ফোন নম্বরটি ইতিমধ্যে ব্যবহার করা হয়েছে। অন্য ফোন নম্বর প্রদান করুন।',
            'nid.regex'    => 'এনআইডি (NID) নম্বরটি অবশ্যই ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে।',
            'nid.unique'   => 'এই এনআইডি (NID) নম্বরটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
        ]);

        $schoolId = auth()->user()->school_id;
        $subjects = Subject::where('id', $validated['subject_id'])
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $teacherId = Teacher::generateTeacherId($schoolId);
        $tenant = auth()->user()->school->slug;

        $photoPath = null;

        if ($request->hasFile('photo')) {

            $folder = public_path("uploads/schools/{$tenant}/teachers");

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $file = $request->file('photo');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move($folder, $filename);

            $photoPath = "uploads/schools/{$tenant}/teachers/".$filename;
        }

        $defaultPassword = $request->password ?? '12345678';

        $createdTeacher = null;

        DB::transaction(function () use ($request, $subjects, $schoolId, $teacherId, $photoPath, $defaultPassword, &$createdTeacher) {

            // 1️⃣ Create Teacher Profile
            $createdTeacher = Teacher::create([
                'school_id' => $schoolId,
                'teacher_id' => $teacherId,
                'name' => $request->name,
                'subject_id' => $subjects->id,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'nid' => $request->nid,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'blood_group' => $request->blood_group,
                'joining_date' => $request->joining_date,
                'qualification' => $request->qualification,
                'address' => $request->address,
                'photo' => $photoPath
            ]);

            // 2️⃣ Create User for Login
            $user = User::create([
                'school_id' => $schoolId,
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($defaultPassword),
                'role' => 'teacher',
            ]);

            if (method_exists($user, 'assignRole')) {
                try {
                    $user->assignRole('teacher');
                } catch (\Throwable $e) {
                    Log::warning("Could not assign 'teacher' role: " . $e->getMessage());
                }
            }

        });

        // 3️⃣ Send credentials email from School's Official Email & SMTP
        if ($createdTeacher && !empty($createdTeacher->email)) {
            try {
                $school = School::find($schoolId);
                if ($school) {
                    $this->setMailConfig($school);
                    // Explicitly use smtp mailer so the freshly configured SMTP is always used
                    // (avoids any cached 'log' mailer from .env MAIL_MAILER=log)
                    Mail::mailer('smtp')
                        ->to($createdTeacher->email)
                        ->send(new TeacherCredentialsMail($createdTeacher, $school, $defaultPassword));
                }
            } catch (\Exception $e) {
                Log::error("Failed to send teacher credentials email to {$createdTeacher->email}: " . $e->getMessage());
            }
        }

        return redirect() 
            ->back()
            ->with('success', 'Teacher registered and permissions assigned successfully! Login credentials have been sent via email.');
    }

    /**
     * Display the specified resource.
     */
    public function show($tenant, $teacher)
    {
        $schoolId = auth()->user()->school_id;
        $teacher = Teacher::where('id', $teacher)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.teacher.view', compact('teacher'));
    }

    public function edit($tenant, $teacher)
    {
        $classes = Teacher::all();
        $schoolId = auth()->user()->school_id;
        $subjects = Subject::where('school_id', $schoolId)->get();
        $teacher = Teacher::where('id', $teacher)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        return view('school.teacher.edit', compact('teacher', 'classes', 'subjects'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tenant, $teacher)
    {
        $schoolId = auth()->user()->school_id;

        $subjects = Subject::where('id', $request->subject_id)
            ->where('school_id', $schoolId)
            ->firstOrFail();

        $teacher = Teacher::where('id', $teacher)
                            ->where('school_id', $schoolId)
                            ->firstOrFail();

        $tenant = auth()->user()->school->slug;

        $photoPath = $teacher->photo ?? null;

        if ($request->hasFile('photo')) {

            $folder = public_path("uploads/schools/{$tenant}/teachers");

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            // delete old photo
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                unlink(public_path($teacher->photo));
            }

            $file = $request->file('photo');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move($folder, $filename);

            $photoPath = "uploads/schools/{$tenant}/teachers/".$filename;
        }

        DB::transaction(function () use ($teacher, $request, $subjects, $photoPath) {

        $teacher->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $teacher->update([
            'name' => $request->name,
            'subject_id' => $subjects->id,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'nid' => $request->nid,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
            'blood_group' => $request->blood_group,
            'joining_date' => $request->joining_date,
            'qualification' => $request->qualification,
            'address' => $request->address,
            'photo' => $photoPath
        ]);
    });
        return redirect()->route('teachers.index', ['tenant' => auth()->user()->school->slug])->with(['success' => 'Teacher updated successfully', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tenant, $teacher)
    {
        $schoolId = auth()->user()->school_id;

        $teacher = Teacher::where('id', $teacher)
            ->where('school_id', $schoolId)
            ->firstOrFail();

        DB::transaction(function () use ($teacher) {

            // delete teacher photo
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                unlink(public_path($teacher->photo));
            }

            // delete related user safely
            if ($teacher->user) {
                $teacher->user->delete();
            }

            // delete teacher
            $teacher->delete();
        });

        return redirect()->back()->with([
            'success' => 'Teacher deleted successfully',
            'type' => 'warning'
        ]);
    }

    /**
     * Import teachers from an uploaded Excel file.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'excel_file.required' => 'অনুগ্রহ করে একটি Excel ফাইল বাছাই করুন।',
            'excel_file.mimes'    => 'শুধুমাত্র .xlsx, .xls অথবা .csv ফাইল সমর্থিত।',
            'excel_file.max'      => 'ফাইলের সর্বোচ্চ সাইজ ৫ MB।',
        ]);

        $school = School::find(auth()->user()->school_id);
        $importer = new TeacherImport($school);

        try {
            Excel::import($importer, $request->file('excel_file'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'ফাইল প্রসেস করতে সমস্যা হয়েছে: ' . $e->getMessage())
                ->with('type', 'error');
        }

        $message = "সফলভাবে {$importer->importedCount} জন শিক্ষক যুক্ত হয়েছে।";
        if ($importer->skippedCount > 0) {
            $message .= " {$importer->skippedCount} টি সারি এড়িয়ে যাওয়া হয়েছে।";
        }

        return redirect()->route('teachers.index', ['tenant' => auth()->user()?->school?->slug])
            ->with('success', $message)
            ->with('type', $importer->importedCount > 0 ? 'success' : 'warning')
            ->with('skipped_rows', $importer->skippedRows);
    }

    /**
     * Download a demo Excel template file for teacher bulk import.
     */
    public function downloadDemo(): StreamedResponse
    {
        $headers = [
            'name', 'email', 'phone', 'gender', 'subject_name',
            'date_of_birth', 'father_name', 'mother_name',
            'nid', 'blood_group', 'joining_date', 'qualification', 'address',
        ];

        $rows = [
            [
                'Rahim Uddin', 'rahim@school.com', '01712345678', 'male', 'Mathematics',
                '1985-06-15', 'Karim Uddin', 'Fatema Begum',
                '1234567890', 'B+', '2024-01-10', 'M.Sc in Mathematics', 'Dhaka, Bangladesh',
            ],
            [
                'Salma Khatun', 'salma@school.com', '01812345679', 'female', 'English',
                '1990-03-22', 'Alam Hossain', 'Roksana Begum',
                '98765432101234567', 'O+', '2024-02-15', 'M.A. in English', 'Chittagong, Bangladesh',
            ],
        ];

        $callback = function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for proper Bengali/English display in Excel
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'teacher_import_demo.csv', [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="teacher_import_demo.csv"',
        ]);
    }
}
