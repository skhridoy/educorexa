<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherAssignSubject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Classes;
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

    public function StudentAttendanceReport($tenant, Request $request) 
    {
        $schoolId = auth()->user()->school_id;
        $classId = $request->class_id;
        $studentId = $request->student_id;
        $year = $request->year ?? date('Y');

        $student = null;
        $events = [];

        // ১. সকল ক্লাস নিয়ে আসা
        $classes = Classes::where('school_id', $schoolId)->get();

        if ($studentId) {
            $student = Student::where('id', $studentId)
                            ->where('school_id', $schoolId)
                            ->first();

            if ($student) {
                $attendances = Attendance::where('student_id', $student->id)
                                        ->whereYear('date', $year)
                                        ->where('school_id', $schoolId)
                                        ->get();
                
                foreach ($attendances as $attendance) {
                    $events[] = [
                        'title' => ucfirst($attendance->status),
                        'start' => $attendance->date,
                        'backgroundColor' => ($attendance->status == 'present') ? '#05a34a' : '#ff3366',
                        'borderColor' => ($attendance->status == 'present') ? '#05a34a' : '#ff3366',
                    ];
                }
            }
        }

        return view('school.attendance.report', compact('events', 'student', 'year', 'classes', 'classId', 'tenant'));
    }
}
