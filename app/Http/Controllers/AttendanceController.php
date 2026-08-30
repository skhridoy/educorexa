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

    public function analytics(Request $request, $tenant)
    {
        $schoolId = auth()->user()->school_id;
        $selectedDate = $request->get('date', now()->toDateString());
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');
        $statusFilter = $request->get('status');
        $search = $request->get('search');

        // 1. Classes & Sections for filters
        $classes = \App\Models\Classes::where('school_id', $schoolId)->get();
        $sections = collect();
        if ($classId) {
            $sections = \App\Models\Section::where('school_id', $schoolId)->where('class_id', $classId)->get();
        }

        // 2. Total active students count in school (or filtered class/section)
        $totalStudentsQuery = Student::where('school_id', $schoolId);
        if ($classId) {
            $totalStudentsQuery->where('class_id', $classId);
        }
        if ($sectionId) {
            $totalStudentsQuery->where('section_id', $sectionId);
        }
        $totalStudents = $totalStudentsQuery->count();

        // 3. Attendance records for selected date
        $attendancesQuery = Attendance::with(['student', 'class', 'section', 'teacher'])
            ->where('school_id', $schoolId)
            ->where('date', $selectedDate);

        if ($classId) {
            $attendancesQuery->where('class_id', $classId);
        }
        if ($sectionId) {
            $attendancesQuery->where('section_id', $sectionId);
        }

        $allAttendancesForDate = (clone $attendancesQuery)->get();

        $presentCount = $allAttendancesForDate->where('status', 'present')->count();
        $absentCount  = $allAttendancesForDate->where('status', 'absent')->count();

        $presentPercentage = $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100, 1) : 0;
        $absentPercentage  = $totalStudents > 0 ? round(($absentCount / $totalStudents) * 100, 1) : 0;

        // 4. Class-wise Breakdown
        $classBreakdown = [];
        $allSectionsList = \App\Models\Section::with('class')
            ->where('school_id', $schoolId)
            ->when($classId, function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->get();

        foreach ($allSectionsList as $sec) {
            $secTotalStudents = Student::where('school_id', $schoolId)
                ->where('class_id', $sec->class_id)
                ->where('section_id', $sec->id)
                ->count();

            if ($secTotalStudents == 0) continue;

            $secAttendances = Attendance::with('teacher')
                ->where('school_id', $schoolId)
                ->where('class_id', $sec->class_id)
                ->where('section_id', $sec->id)
                ->where('date', $selectedDate)
                ->get();

            $secPresent = $secAttendances->where('status', 'present')->count();
            $secAbsent  = $secAttendances->where('status', 'absent')->count();
            $secMarked  = $secPresent + $secAbsent;
            $secRate    = $secTotalStudents > 0 ? round(($secPresent / $secTotalStudents) * 100, 1) : 0;

            $firstLog = $secAttendances->first();
            $takenBy = $firstLog && $firstLog->teacher ? $firstLog->teacher->name : 'N/A';
            $takenAt = $firstLog ? $firstLog->created_at->format('h:i A') : null;

            $classBreakdown[] = [
                'class_name'    => $sec->class ? $sec->class->name : 'N/A',
                'section_name'  => $sec->name,
                'class_id'      => $sec->class_id,
                'section_id'    => $sec->id,
                'total'         => $secTotalStudents,
                'present'       => $secPresent,
                'absent'        => $secAbsent,
                'rate'          => $secRate,
                'is_completed'  => $secMarked > 0,
                'taken_by'      => $takenBy,
                'taken_at'      => $takenAt,
            ];
        }

        $completedClassesCount = collect($classBreakdown)->where('is_completed', true)->count();
        $totalClassesCount     = count($classBreakdown);

        // 5. Last 7 Days Trend Data for Chart.js
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::parse($selectedDate)->subDays($i)->toDateString();
            $dayTotalPresent = Attendance::where('school_id', $schoolId)
                ->where('date', $date)
                ->where('status', 'present')
                ->count();
            $dayTotalAbsent = Attendance::where('school_id', $schoolId)
                ->where('date', $date)
                ->where('status', 'absent')
                ->count();

            $totalDayMarked = $dayTotalPresent + $dayTotalAbsent;
            $rate = $totalDayMarked > 0 ? round(($dayTotalPresent / $totalDayMarked) * 100, 1) : 0;

            $trendData[] = [
                'date'    => \Carbon\Carbon::parse($date)->format('d M'),
                'present' => $dayTotalPresent,
                'absent'  => $dayTotalAbsent,
                'rate'    => $rate
            ];
        }

        // 6. Detailed Student Attendance Logs Table with Search & Pagination
        $logsQuery = Attendance::with(['student', 'class', 'section', 'teacher'])
            ->where('school_id', $schoolId)
            ->where('date', $selectedDate);

        if ($classId) {
            $logsQuery->where('class_id', $classId);
        }
        if ($sectionId) {
            $logsQuery->where('section_id', $sectionId);
        }
        if ($statusFilter) {
            $logsQuery->where('status', $statusFilter);
        }
        if ($search) {
            $logsQuery->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('roll', 'like', "%{$search}%");
            });
        }

        $studentLogs = $logsQuery->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('school.attendance.analytics', compact(
            'classes',
            'sections',
            'selectedDate',
            'classId',
            'sectionId',
            'statusFilter',
            'search',
            'totalStudents',
            'presentCount',
            'absentCount',
            'presentPercentage',
            'absentPercentage',
            'completedClassesCount',
            'totalClassesCount',
            'classBreakdown',
            'trendData',
            'studentLogs'
        ));
    }

    /**
     * Display ID Card QR Attendance Scanner Page.
     */
    public function qrScan($tenant, Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $today = now()->toDateString();

        $totalStudents = Student::where('school_id', $schoolId)->where('status', 'active')->count();
        $presentCountToday = Attendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'present')->count();
        $attendanceRate = $totalStudents > 0 ? round(($presentCountToday / $totalStudents) * 100, 1) : 0;

        // Recent today's logs
        $recentLogs = Attendance::with(['student.class', 'student.section'])
            ->where('school_id', $schoolId)
            ->where('date', $today)
            ->where('status', 'present')
            ->latest('updated_at')
            ->take(15)
            ->get();

        return view('school.attendance.qr_scan', compact(
            'totalStudents',
            'presentCountToday',
            'attendanceRate',
            'today',
            'recentLogs'
        ));
    }

    /**
     * Process QR code scan and mark student present.
     */
    public function recordQrAttendance($tenant, Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $today = $request->date ?? now()->toDateString();
        $rawCode = trim($request->qr_code_data ?? '');

        if (empty($rawCode)) {
            return response()->json([
                'success' => false,
                'message' => 'কিউআর কোডের তথ্য পাওয়া যায়নি!'
            ], 400);
        }

        // Identify Teacher if logged in user is a teacher
        $teacher = Teacher::where('email', auth()->user()->email)->where('school_id', $schoolId)->first();

        // 1. Direct match by student_id or id
        $student = Student::with(['class', 'section', 'academicYear'])
            ->where('school_id', $schoolId)
            ->where(function($q) use ($rawCode) {
                $q->where('student_id', $rawCode)
                  ->orWhere('id', $rawCode);
            })->first();

        // 2. Extract STD-XXXX pattern via regex
        if (!$student && preg_match('/(STD-[A-Za-z0-9_-]+)/i', $rawCode, $matches)) {
            $extractedId = $matches[1];
            $student = Student::with(['class', 'section', 'academicYear'])
                ->where('school_id', $schoolId)
                ->where('student_id', $extractedId)
                ->first();
        }

        // 3. Extract from "ID: XXXX" format
        if (!$student && preg_match('/ID:\s*([^\|\n\r]+)/i', $rawCode, $matches)) {
            $parsedId = trim($matches[1]);
            $student = Student::with(['class', 'section', 'academicYear'])
                ->where('school_id', $schoolId)
                ->where(function($q) use ($parsedId) {
                    $q->where('student_id', $parsedId)
                      ->orWhere('id', $parsedId);
                })->first();
        }

        // If not found
        if (!$student) {
            return response()->json([
                'success' => false,
                'student_id' => $rawCode,
                'message' => "❌ শিক্ষার্থী পাওয়া যায়নি! (ID: {$rawCode})",
            ], 404);
        }

        // Check if attendance already recorded today
        $existing = Attendance::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->where('date', $today)
            ->first();

        $alreadyMarked = false;

        if ($existing && $existing->status === 'present') {
            $alreadyMarked = true;
            $message = "⚠️ [{$student->student_id}] {$student->name} এর আজকের হাজিরা ইতিমধ্যে নেওয়া হয়েছে!";
        } else {
            Attendance::updateOrCreate(
                [
                    'school_id'  => $schoolId,
                    'student_id' => $student->id,
                    'date'       => $today,
                ],
                [
                    'class_id'   => $student->class_id,
                    'section_id' => $student->section_id,
                    'teacher_id' => $teacher ? $teacher->id : null,
                    'status'     => 'present',
                ]
            );
            $message = "✅ [{$student->student_id}] {$student->name} - হাজিরা সফলভাবে নিশ্চিত করা হয়েছে!";
        }

        $totalPresentToday = Attendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'present')->count();
        $totalActiveStudents = Student::where('school_id', $schoolId)->where('status', 'active')->count();
        $rate = $totalActiveStudents > 0 ? round(($totalPresentToday / $totalActiveStudents) * 100, 1) : 0;

        return response()->json([
            'success' => true,
            'already_marked' => $alreadyMarked,
            'message' => $message,
            'student' => [
                'id'           => $student->id,
                'student_id'   => $student->student_id,
                'name'         => $student->name,
                'roll'         => $student->roll ?? 'N/A',
                'class_name'   => $student->class ? $student->class->name : 'N/A',
                'section_name' => $student->section ? $student->section->name : 'N/A',
                'photo'        => $student->photo ? asset($student->photo) : asset('assets/images/profile.webp'),
                'status'       => 'present',
                'time'         => now()->format('h:i:s A'),
            ],
            'stats' => [
                'today_present'   => $totalPresentToday,
                'total_students'  => $totalActiveStudents,
                'attendance_rate' => $rate
            ]
        ]);
    }
}
