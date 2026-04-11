<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherAssignSubject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;
class AttendanceController extends Controller
{
    public function index($tenant, Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $teacher = Teacher::where('email', auth()->user()->email)->first();

        // যদি টিচার না পাওয়া যায় (যেমন অ্যাডমিন লগইন করলে)
        if (!$teacher) {
            return redirect()->back()->with('error', 'You can not take attendance. Please log in as a teacher.');
        }
        $classId = $request->class_id;
        $sectionId = $request->section_id;
        $date = $request->date ?? now()->toDateString();
        $assignedClasses = TeacherAssignSubject::with(['class','section'])
            ->where('school_id', $schoolId)
            ->where('teacher_id', $teacher->id)
            ->get();
        $getAttendance = Attendance::with(['class', 'section', 'teacher'])
            ->where('school_id', auth()->user()->school_id)
            ->where('date', now()->toDateString())
            ->select('class_id', 'section_id', 'teacher_id', 'created_at')
            ->groupBy('class_id', 'section_id', 'teacher_id', 'created_at')
            ->get();

        $students = collect();
        $existingAttendance = [];

        $attendanceInfo = null;

        if($request->class_id && $request->section_id){
            $attendanceInfo = Attendance::with(['teacher'])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->where('date', $date)
            ->first();
            if($classId && $sectionId){
                $students = Student::where('class_id', $classId)
                    ->where('section_id',  $sectionId)
                    ->paginate(20); 

                $existingAttendance = Attendance::where('class_id', $classId)
                    ->where('section_id', $sectionId)
                    ->where('date', $date)
                    ->pluck('status', 'student_id')
                    ->toArray();
            }
        }

        return view('school.attendance.take', compact(
            'assignedClasses',
            'students',
            'existingAttendance', 'attendanceInfo', 'getAttendance'
        ));
    }


    public function store($tenant, Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $teacher = Teacher::where('email', auth()->user()->email)->first();

        // ব্লেড ফাইল থেকে আসা তারিখটি ধরুন, না থাকলে আজকের তারিখ
        $attendanceDate = $request->date ?? now()->toDateString(); 

        if (!$request->attendance) {
            return response()->json(['success' => false, 'message' => 'হাজিরার ডাটা পাওয়া যায়নি!'], 400);
        }

        try {
            foreach ($request->attendance as $studentId => $status) {
                Attendance::updateOrCreate(
                    [
                        'school_id'  => $schoolId,
                        'student_id' => $studentId,
                        'date'       => $attendanceDate 
                    ],
                    [
                        'class_id'   => $request->class_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => $teacher->id,
                        'status'     => $status,
                    ]
                );
            }
            return response()->json(['success' => true, 'message' => 'Attendance saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function searchAjax(Request $request)
    {
        $query = $request->get('q');
        $classId = $request->get('class_id');

        $students = Student::where('school_id', auth()->user()->school_id)
            ->when($query, function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('student_id', 'LIKE', "%{$query}%"); // এখানে আইডি দিয়ে সার্চ হচ্ছে
            })
            ->when($classId, function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->limit(10)
            ->get(['id', 'name', 'student_id']);

        return response()->json($students);
    }
    public function report(Request $request, $tenant)
    {
        $year = $request->get('year', date('Y'));
        $studentIdInput = $request->get('student_id');

        $student = null;
        $attendanceData = [];
        
        // স্কুলের সকল বিশেষ ছুটির তারিখগুলো অ্যারে হিসেবে আনা
        $allHolidays = \App\Models\Holiday::where('school_id', auth()->user()->school_id)
                        ->whereYear('date', $year)
                        ->pluck('date')
                        ->map(fn($date) => $date instanceof \Carbon\Carbon ? $date->toDateString() : date('Y-m-d', strtotime($date)))
                        ->toArray();

        if ($studentIdInput) {
            $student = Student::with(['class', 'section'])
                            ->where('school_id', auth()->user()->school_id)
                            ->where('student_id', $studentIdInput) 
                            ->first();

            if ($student) {
                $attendances = Attendance::where('student_id', $student->id)
                                        ->whereYear('date', $year)
                                        ->get();

                foreach ($attendances as $record) {
                    $attendanceData[] = [
                        'title' => $record->status == 'present' ? 'P' : 'A',
                        'start' => date('Y-m-d', strtotime($record->date)), 
                    ];
                }
            }
        }

        return view('school.attendance.report', compact('student', 'year', 'attendanceData', 'tenant', 'allHolidays'));
    }

    private function isHoliday($date, $schoolId)
    {
        // ১. সাপ্তাহিক ছুটি (শুক্রবার) চেক করা
        $dayName = date('l', strtotime($date));
        if ($dayName == 'Friday') {
            return true;
        }

        // ২. ডাটাবেজে ওই দিনের জন্য কোনো বিশেষ ছুটি সেট করা আছে কি না
        $specialHoliday = Holiday::where('school_id', $schoolId)
                            ->where('date', $date)
                            ->exists();

        return $specialHoliday;
    }
}
