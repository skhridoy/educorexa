<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Attendance;
use \App\Models\StudentFee;
use \App\Models\Classes;
use \App\Models\LessonPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \App\Models\Student;
class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $school = app('currentSchool');
        $schoolId = auth()->user()->school_id;
        $today = now()->toDateString();

        // ১. বেসিক কাউন্টস
        $data['totalStudents'] = Student::where('school_id', $schoolId)->count();
        $data['totalTeachers'] = $school->teacher()->count();
        $data['classesCount'] = $school->classes()->count();

        // ২. ফি সামারি (বর্তমান মাসের জন্য)
        $totalExpected = StudentFee::where('school_id', $schoolId)->sum('amount');
        $totalCollected = StudentFee::where('school_id', $schoolId)
            ->where('status', 'paid')
            ->sum('amount');
        $currentMonth = now()->format('F-Y');
        $currentMonthSummary = StudentFee::where('school_id', $schoolId)
            ->where('month', $currentMonth)
            ->selectRaw("SUM(amount) as total, SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as collected")
            ->first();

        $data['totalExpected'] = $totalExpected;
        $data['totalCollected'] = $totalCollected;
        $data['currentTotal'] = $currentMonthSummary->total ?? 0;
        $data['currentCollected'] = $currentMonthSummary->collected ?? 0;

        // ৩. আজকের উপস্থিতির পরিসংখ্যান (ওভাররাইট এড়াতে ভেরিয়েবল নাম পরিবর্তন করা হয়েছে)
        $todayAttendance = Attendance::where('school_id', $schoolId)
            ->whereDate('date', $today)
            ->selectRaw("COUNT(CASE WHEN status = 'present' THEN 1 END) as present, 
                        COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent")
            ->first();

        $data['presentCount'] = $todayAttendance->present ?? 0;
        $data['absentCount'] = $todayAttendance->absent ?? 0;

        // ৪. রিসেন্ট অ্যাটেনডেন্স লগ (টেবিলের জন্য)
        $data['attendanceLogs'] = Attendance::with(['teacher', 'class', 'section'])
            ->where('school_id', $schoolId)
            ->whereDate('date', today())
            ->select('teacher_id', 'class_id', 'section_id', DB::raw('MAX(created_at) as last_marked'))
            ->groupBy('teacher_id', 'class_id', 'section_id')
            ->latest('last_marked')
            ->take(5)
            ->get();

        // ৫. সাপ্তাহিক উপস্থিতির রিয়েল ডাটা ক্যালকুলেশন
        $startOfWeek = now()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = now()->endOfWeek(Carbon::FRIDAY);

        // ডাটাবেস থেকে একবারে সপ্তাহের সব ডাটা আনা (পারফরম্যান্সের জন্য ভালো)
        $weeklyAttendanceRaw = Attendance::where('school_id', $schoolId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw("DATE_FORMAT(date, '%a') as day_name"),
                DB::raw("COUNT(*) as total_count"),
                DB::raw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count")
            )
            ->groupBy('day_name', 'date')
            ->orderBy('date')
            ->get()
            ->keyBy('day_name');

        // ৬. গ্রাফের জন্য ৭ দিনের অ্যারে ম্যাপ করা
        $weekDays = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
        $data['weeklyStats'] = [];

        foreach ($weekDays as $day) {
            if (isset($weeklyAttendanceRaw[$day])) {
                $present = $weeklyAttendanceRaw[$day]->present_count;
                $total = $weeklyAttendanceRaw[$day]->total_count;
                $data['weeklyStats'][$day] = $total > 0 ? round(($present / $total) * 100) : 0;
            } else {
                $data['weeklyStats'][$day] = 0;
            }
        }

        return view('school.admin.dashboard', $data);
    }

    // বকেয়া তালিকা লোড করার জন্য আলাদা মেথড (Ajax)
    public function getUnpaidList(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $month = $request->get('month', now()->format('F-Y'));

        $unpaidList = StudentFee::with(['student.class', 'feeHead'])
            ->where('school_id', $schoolId)
            ->where('status', 'unpaid')
            ->where('month', $month)
            ->whereHas('student')
            ->paginate(5);

        return response()->json([
            'html' => view('school.partials._unpaid_list', compact('unpaidList'))->render()
        ]);
    }

    // অ্যাটেনডেন্স চার্ট ডাটা (API)
    public function getAttendanceChartData(Request $request) {
        $schoolId = auth()->user()->school_id;
        $filter = $request->filter ?? 'monthly';
        
        $query = Attendance::where('school_id', $schoolId);

        if ($filter == 'weekly') {
            $query->where('date', '>=', now()->subDays(7)->toDateString());
        } elseif ($filter == 'monthly') {
            $query->where('date', '>=', now()->subDays(30)->toDateString());
        } elseif ($filter == 'custom' && $request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $attendanceData = $query->select('date', 
                DB::raw('count(case when status="present" then 1 end) as present'),
                DB::raw('count(case when status="absent" then 1 end) as absent'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($attendanceData);
    }


    public function filterFee(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $monthNum = $request->month;
        $year = $request->year ?? date('Y');

        $formattedMonth = $monthNum ? date('F-Y', mktime(0, 0, 0, $monthNum, 1, $year)) : null;

        // ১. ক্লাস ভিত্তিক পেইড ফি এর ডাটা (একটি কুয়েরিতে)
        $query = DB::table('student_fees')
            ->join('students', 'student_fees.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->where('student_fees.school_id', $schoolId)
            ->where('student_fees.status', 'paid');

        if ($formattedMonth) {
            $query->where('student_fees.month', $formattedMonth);
        } else {
            $query->where('student_fees.month', 'LIKE', "%-$year");
        }

        $classWiseFees = $query->select('classes.name', DB::raw('SUM(student_fees.amount) as total_paid'))
            ->groupBy('classes.name')
            ->pluck('total_paid', 'name');

        // ২. সকল ক্লাসের নাম নিশ্চিত করা (যাতে কোনো ক্লাসে ফি না থাকলেও ০ দেখায়)
        $allClasses = Classes::where('school_id', $schoolId)->pluck('name');
        $classNames = [];
        $classFees = [];

        foreach ($allClasses as $name) {
            $classNames[] = $name;
            $classFees[] = (float) ($classWiseFees[$name] ?? 0);
        }

        // ৩. সামারি ক্যালকুলেশন
        $summaryQuery = DB::table('student_fees')->where('school_id', $schoolId);
        if ($formattedMonth) {
            $summaryQuery->where('month', $formattedMonth);
        } else {
            $summaryQuery->where('month', 'LIKE', "%-$year");
        }

        $summary = $summaryQuery->selectRaw("
            SUM(amount) as total_expected, 
            SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as collected
        ")->first();

        return response()->json([
            'classNames'    => $classNames,
            'classFees'     => $classFees,
            'collectedFees' => (float)$summary->collected,
            'unpaidFees'    => (float)($summary->total_expected - $summary->collected),
            'totalExpected' => (float)$summary->total_expected
        ]);
    }
}