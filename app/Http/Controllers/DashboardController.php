<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Attendance;
use \App\Models\StudentFee;
use \App\Models\Classes;
use \App\Models\LessonPlan;
use \App\Models\Student;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $school = app('currentSchool');
        $schoolId = auth()->user()->school_id;
        $today = now()->toDateString();

        // ১. বেসিক কাউন্টস (একক কুয়েরিতে আনার চেষ্টা)
        $data['totalStudents'] = Student::where('school_id', $schoolId)->count();
        $data['totalTeachers'] = $school->teacher()->count();
        $data['classesCount'] = $school->classes()->count();

        // ২. ফি সামারি (বর্তমান মাসের জন্য ডিফল্ট)
        // ১. বর্তমান মাসের ফি সামারি
        $currentMonth = now()->format('F-Y');
        $currentMonthSummary = StudentFee::where('school_id', $schoolId)
            ->where('month', $currentMonth)
            ->selectRaw("SUM(amount) as total, SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as collected")
            ->first();

        $data['currentTotal'] = $currentMonthSummary->total ?? 0;
        $data['currentCollected'] = $currentMonthSummary->collected ?? 0;
        $data['currentTotal'] = $currentMonthSummary->total ?? 0;
        $data['currentCollected'] = $currentMonthSummary->collected ?? 0;

        // ২. সর্বমোট (All Time) ফি সামারি
        $allTimeSummary = StudentFee::where('school_id', $schoolId)
            ->selectRaw("SUM(amount) as total, SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as collected")
            ->first();

        $data['allTimeTotal'] = $allTimeSummary->total ?? 0;
        $data['allTimeCollected'] = $allTimeSummary->collected ?? 0;
        $data['unpaidFees'] = $data['currentTotal'] - $data['currentCollected'];

        // ৩. ক্লাস-ভিত্তিক ফি চার্ট ডাটা (Optimization: Avoid Loop Queries)
        $classFeesData = DB::table('student_fees')
            ->join('students', 'student_fees.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->where('student_fees.school_id', $schoolId)
            ->where('student_fees.status', 'paid')
            ->select('classes.name', DB::raw('SUM(student_fees.amount) as total_paid'))
            ->groupBy('classes.name')
            ->get();

        $data['classNames'] = $classFeesData->pluck('name');
        $data['classFees'] = $classFeesData->pluck('total_paid');

        // ৪. আজকের উপস্থিতি স্ট্যাটাস
        $attendanceData = Attendance::where('school_id', $schoolId)
            ->where('date', $today)
            ->selectRaw("SUM(status = 'present') as present, SUM(status = 'absent') as absent")
            ->first();

        $data['presentCount'] = $attendanceData->present ?? 0;
        $data['absentCount'] = $attendanceData->absent ?? 0;

        // ৫. রিসেন্ট টিচার অ্যাটেনডেন্স লগ
        $data['attendanceLogs'] = Attendance::with(['teacher', 'class', 'section'])
            ->where('school_id', $schoolId)
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('school.dashboard', $data);
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
            ->get();

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