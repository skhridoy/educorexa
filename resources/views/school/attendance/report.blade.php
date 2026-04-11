@extends('layouts.school')

@section('customCSS')
<style>
    /* ক্যালেন্ডার ও প্রোফাইল ডিজাইন */
    .calendar-table { table-layout: fixed; width: 100%; border-collapse: collapse; background: #fff; }
    .calendar-table th, .calendar-table td { text-align: center; padding: 4px; border: 1px solid #f0f0f0; font-size: 10px; }
    .calendar-table th { background: #fdfdfd; font-weight: 600; color: #888; height: 25px; border-bottom: 1px solid #eee; }
    .calendar-table td { height: 32px; border: none; border-bottom: 1px solid #f9f9f9; }
    
    .present { background-color: #10b759 !important; color: #fff !important; border-radius: 50%; font-weight: bold; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; }
    .absent { background-color: #ff3366 !important; color: #fff !important; border-radius: 50%; font-weight: bold; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; }
    
    .bg-soft-light { background-color: rgba(255,255,255,0.2); }
    .stats-box { padding: 10px; border-radius: 8px; text-align: center; background: #f8f9fa; border: 1px solid #eee; }
    .month-header { background: #f8f9fa; color: #333; padding: 8px; text-align: center; border-radius: 8px 8px 0 0; font-size: 12px; font-weight: bold; border-bottom: 1px solid #eee; }
    .wd-100 { width: 100px; height: 100px; }
</style>
@endsection

@section('content')
<div class="page-content">
    
    {{-- সার্চ সেকশন --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="card-title text-primary mb-3">Student Attendance Report Search</h6>
            <form action="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" method="GET" class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="student_id" class="form-control form-control-lg" placeholder="Enter Student ID (e.g. STD-26011)" value="{{ request('student_id') }}" required>
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

    @if($student)
    <div class="row">
        {{-- বাম পাশ: প্রোফাইল কার্ড --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden sticky-top" style="top: 80px; z-index: 10;">
                <div class="card-header bg-primary py-4 text-center border-0">
                    <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                         class="wd-100 rounded-circle shadow-lg border border-3 border-white object-fit-cover">
                    <h5 class="mt-3 text-white mb-0">{{ $student->name }}</h5>
                    <span class="badge bg-soft-light text-white mt-1">{{ $student->student_id }}</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                            <span class="text-muted">Class</span>
                            <span class="fw-bold">{{ $student->class->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                            <span class="text-muted">Section</span>
                            <span class="fw-bold">{{ $student->section->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 bg-transparent">
                            <span class="text-muted">Roll No</span>
                            <span class="fw-bold text-primary">{{ $student->roll ?? 'N/A' }}</span>
                        </li>
                    </ul>

                    @php
                        $pCount = collect($attendanceData)->where('title', 'P')->count();
                        $aCount = collect($attendanceData)->where('title', 'A')->count();
                        $total = $pCount + $aCount;
                        $rate = $total > 0 ? round(($pCount / $total) * 100) : 0;
                    @endphp

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="stats-box">
                                <h4 class="text-success mb-0">{{ $pCount }}</h4>
                                <small class="text-muted">Present</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-box">
                                <h4 class="text-danger mb-0">{{ $aCount }}</h4>
                                <small class="text-muted">Absent</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted d-block mb-1">Attendance Rate: {{ $rate }}%</small>
                        <div class="progress ht-5">
                            <div class="progress-bar bg-success" style="width: {{ $rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ডান পাশ: ক্যালেন্ডার --}}
        <div class="col-md-8">
            <div class="row">
                @php $formattedAtt = collect($attendanceData)->pluck('title', 'start')->toArray(); @endphp

                @foreach(range(1, 12) as $month)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="month-header">{{ date("F", mktime(0, 0, 0, $month, 1)) }} {{ $year }}</div>
                        <div class="card-body p-2">
                            <table class="calendar-table">
                                <thead><tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr></thead>
                                <tbody>
                                    @php
                                        // $1 এর পরিবর্তে শুধু 1 ব্যবহার করুন
                                        $dt = \Carbon\Carbon::create($year, $month, 1); 
                                        $days = $dt->daysInMonth;
                                        $skip = $dt->dayOfWeek;
                                        $d = 1;
                                    @endphp

                                    @for($i = 0; $i < 6; $i++)
                                    <tr>
                                        @for($j = 0; $j < 7; $j++)
                                            @php
                                                $cell = ($i * 7) + $j;
                                                if ($cell < $skip || $d > $days) {
                                                    $cDate = null;
                                                } else {
                                                    $cDate = sprintf("%04d-%02d-%02d", $year, $month, $d);
                                                }

                                                $isFriday = ($cDate) ? (\Carbon\Carbon::parse($cDate)->isFriday()) : false;
                                                $isSpecialHoliday = ($cDate) ? in_array($cDate, $allHolidays) : false;
                                                $status = ($cDate) ? ($formattedAtt[$cDate] ?? null) : null;
                                            @endphp

                                            @if($cell < $skip || $d > $days)
                                                <td></td>
                                            @else
                                                <td class="{{ ($isFriday || $isSpecialHoliday) ? 'bg-light' : '' }}" style="position: relative;">
                                                    @if($isFriday || $isSpecialHoliday)
                                                        <div style="font-size: 7px; color: #ff9800; position: absolute; top: 2px; width: 100%; text-align: center; font-weight: bold; line-height: 1;">
                                                            OFF
                                                        </div>
                                                    @endif
                                                    
                                                    <span class="{{ $status == 'P' ? 'present' : ($status == 'A' ? 'absent' : '') }}" 
                                                        style="{{ ($isFriday || $isSpecialHoliday) && !$status ? 'color: #bbb;' : '' }}">
                                                        {{ $d++ }}
                                                    </span>
                                                </td>
                                            @endif
                                        @endfor
                                    </tr>
                                    @if($d > $days) @break @endif
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
        <div class="alert alert-light text-center border">শিক্ষার্থী পাওয়া যায়নি। আইডিটি পুনরায় চেক করুন।</div>
    @endif
</div>
@endsection