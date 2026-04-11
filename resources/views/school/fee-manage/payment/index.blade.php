@extends('layouts.school')

@section('customCSS')
<style>
    /* ক্যালেন্ডার স্টাইল */
    .calendar-table { table-layout: fixed; width: 100%; border-collapse: collapse; background: #fff; }
    .calendar-table th, .calendar-table td { 
        text-align: center; padding: 4px; border: 1px solid #f0f0f0; font-size: 10px; 
    }
    .calendar-table th { background: #fdfdfd; font-weight: 600; color: #888; height: 25px; border: none; border-bottom: 1px solid #eee; }
    .calendar-table td { height: 32px; vertical-align: middle; border: none; border-bottom: 1px solid #f9f9f9; }
    
    .present { background-color: #10b759 !important; color: #fff !important; border-radius: 50%; font-weight: bold; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; }
    .absent { background-color: #ff3366 !important; color: #fff !important; border-radius: 50%; font-weight: bold; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; }
    .today-cell { border: 1px solid #6571ff !important; border-radius: 4px; background-color: rgba(101, 113, 255, 0.05); }

    /* প্রোফাইল কার্ড ও স্ট্যাটাস বক্স */
    .bg-soft-light { background-color: rgba(255,255,255,0.2); }
    .stats-box { padding: 10px; border-radius: 8px; text-align: center; }
    .month-header { background: #f8f9fa; color: #333; padding: 8px; text-align: center; border-radius: 8px 8px 0 0; font-size: 12px; font-weight: bold; border-bottom: 1px solid #eee; }
    
    /* NobleUI image size fix */
    .wd-100 { width: 100px; }
    .ht-100 { height: 100px; }
</style>
@endsection

@section('content')
<div class="page-content">
    
    {{-- ১. সার্চ সেকশন (সব সময় থাকবে) --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary d-flex align-items-center">
                        <i data-feather="search" class="me-2 icon-sm"></i> Student Attendance Report
                    </h6>
                    <form action="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" method="GET" class="row g-3">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i data-feather="user"></i></span>
                                <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID (e.g. STD-26011)" value="{{ request('student_id') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="year" class="form-select form-select-lg">
                                @foreach(range(date('Y'), date('Y')-2) as $y)
                                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Search Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ২. স্টুডেন্ট ডাটা পাওয়া গেলে এই অংশটি দেখাবে --}}
    @if($student)
    <div class="row">
        
        {{-- প্রোফাইল কার্ড (বাম পাশে) --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-primary py-4 text-center border-0">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                             class="wd-100 ht-100 rounded-circle shadow-lg border border-3 border-white object-fit-cover">
                    </div>
                    <h5 class="mt-3 text-white mb-0">{{ $student->name }}</h5>
                    <span class="badge bg-soft-light text-white mt-1">{{ $student->student_id }}</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-muted small">Class</span>
                            <span class="fw-bold">{{ $student->class->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-muted small">Section</span>
                            <span class="fw-bold">{{ $student->section->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <span class="text-muted small">Roll No</span>
                            <span class="fw-bold text-primary">{{ $student->roll ?? 'N/A' }}</span>
                        </li>
                    </ul>

                    {{-- পরিসংখ্যান --}}
                    @php
                        $pCount = collect($attendanceData)->where('title', 'P')->count();
                        $aCount = collect($attendanceData)->where('title', 'A')->count();
                        $total = $pCount + $aCount;
                        $rate = $total > 0 ? round(($pCount / $total) * 100) : 0;
                    @endphp

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="stats-box bg-light">
                                <h4 class="text-success mb-0">{{ $pCount }}</h4>
                                <small class="text-muted">Present</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-box bg-light">
                                <h4 class="text-danger mb-0">{{ $aCount }}</h4>
                                <small class="text-muted">Absent</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted d-block mb-1">Attendance Rate: {{ $rate }}%</small>
                        <div class="progress ht-5">
                            <div class="progress-bar bg-success" style="width: {{ $rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ক্যালেন্ডার সেকশন (ডান পাশে) --}}
        <div class="col-md-8">
            <div class="row">
                @php
                    $formattedAttendance = collect($attendanceData)->pluck('title', 'start')->toArray();
                @endphp

                @foreach(range(1, 12) as $month)
                <div class="col-md-6 grid-margin">
                    <div class="card border-0 shadow-sm">
                        <div class="month-header">
                            {{ date("F", mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                        </div>
                        <div class="card-body p-2">
                            <table class="calendar-table">
                                <thead>
                                    <tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>
                                </thead>
                                <tbody>
                                    @php
                                        $firstDay = \Carbon\Carbon::create($year, $month, 1);
                                        $daysInMonth = $firstDay->daysInMonth;
                                        $skip = $firstDay->dayOfWeek;
                                        $dayCount = 1;
                                    @endphp

                                    @for($i = 0; $i < 6; $i++)
                                        <tr>
                                            @for($j = 0; $j < 7; $j++)
                                                @php
                                                    $cellNum = ($i * 7) + $j;
                                                    $currentDate = sprintf("%04d-%02d-%02d", $year, $month, $dayCount);
                                                    $status = $formattedAttendance[$currentDate] ?? null;
                                                @endphp

                                                @if($cellNum < $skip || $dayCount > $daysInMonth)
                                                    <td></td>
                                                @else
                                                    <td class="{{ $currentDate == date('Y-m-d') ? 'today-cell' : '' }}">
                                                        <span class="{{ $status == 'P' ? 'present' : ($status == 'A' ? 'absent' : '') }}">
                                                            {{ $dayCount }}
                                                        </span>
                                                    </td>
                                                    @php $dayCount++; @endphp
                                                @endif
                                            @endfor
                                        </tr>
                                        @if($dayCount > $daysInMonth) @break @endif
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @elseif(request('student_id'))
        <div class="alert alert-warning text-center shadow-sm">
            শিক্ষার্থী পাওয়া যায়নি। আইডি ঠিক আছে কি না যাচাই করুন।
        </div>
    @endif
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') { feather.replace(); }
    });
</script>
@endsection