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

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function teacherDashboard()
    {
        $schoolId = auth()->user()->school_id;
        $teacher = auth()->user()->teacher; // Assuming User hasOne Teacher relationship
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $dayName = Carbon::today()->format('l'); // যেমন: Monday, Tuesday

        // ১. শিক্ষকের আন্ডারে মোট কতজন শিক্ষার্থী (যদি টিচার ক্লাস টিচার হন)
        // অথবা স্কুলের মোট শিক্ষার্থী সংখ্যা
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
            ->where('teacher_id', $teacher->id)
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
            ->where('collected_by', $teacher->id) // কে কালেক্ট করেছে তা চেক করতে
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        // ২. এই শিক্ষকের মাধ্যমে মোট কত কালেকশন হয়েছে (SaaS এর ক্ষেত্রে টেন্যান্ট আইডি মাস্ট)
        $myTotalCollected = StudentFee::where('school_id', $user->school_id)
            ->where('collected_by', $teacher->id)
            ->sum('amount');

        // ৩. সর্বশেষ ৫টি কালেকশন হিস্টোরি (টেবিলে দেখানোর জন্য)
        $recentCollections = StudentFee::where('school_id', $schoolId)
            ->where('collected_by', $teacher->id)
            ->with(['student']) // স্টুডেন্ট রিলেশন
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
            ->where('teacher_id', auth()->id())
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
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $teachers = Teacher::where('school_id', $schoolId)->get();
        return view('school.teacher.index', compact('teachers'));
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
            'email'         => 'nullable|email|max:255|unique:teachers,email',
            'phone'         => 'nullable|string|max:20',
            'blood_group'   => 'nullable|string|max:10',
            'joining_date'  => 'nullable|date',
            'address'       => 'nullable|string|max:500',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        $schoolId = auth()->user()->school_id;
        $subjects = Subject::where('id', $validated['subject_id'])
            ->where('school_id', $schoolId)
            ->firstOrFail();
        $lastJoining = Teacher::where('school_id', $schoolId)->count();

        $running = str_pad($lastJoining + 1, 4, '0', STR_PAD_LEFT);

        $teacherId = 'TEA' . '-'. date('Y') . $running;
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
        DB::transaction(function () use ($request, $subjects, $schoolId, $teacherId, $photoPath) {

        // 1️⃣ Create Teacher Profile
        $teacher = Teacher::create([
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
            'password'  => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        $user->assignRole('teacher'); 

    });

    return redirect() 
        ->back()
        ->with('success', 'Teacher registered and permissions assigned successfully!');
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
}
