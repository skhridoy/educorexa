@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Search Section --}}
        <div class="filter-section mb-4">
            <h5 class="mb-3 fw-bold text-primary"><i class="fa-solid fa-magnifying-glass me-2"></i> Attendance Report Search</h5>
            <form action="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" method="GET" class="row g-3">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                        <input type="text" name="student_id" class="form-control border-start-0 ps-0" placeholder="Enter Student ID (e.g. STD-26011)" value="{{ request('student_id') }}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-select">
                        @foreach(range(date('Y'), date('Y')-2) as $y)
                            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary-gradient w-100">
                        <i class="fa-solid fa-file-invoice me-2"></i> View Report
                    </button>
                </div>
            </form>
        </div>

        @if($student)
        <div class="row g-4">
            {{-- Profile Sidebar --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                    <div class="profile-header-premium">
                        <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" class="profile-img-premium mb-3">
                        <h5 class="text-white fw-bold mb-1">{{ $student->name }}</h5>
                        <span class="badge bg-primary bg-opacity-25 text-white rounded-pill px-3">{{ $student->student_id }}</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-4">
                                <small class="text-muted d-block mb-1">Class</small>
                                <div class="fw-bold text-dark">{{ $student->class->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-4 text-center">
                                <small class="text-muted d-block mb-1">Section</small>
                                <div class="fw-bold text-dark">{{ $student->section->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-4 text-end">
                                <small class="text-muted d-block mb-1">Roll</small>
                                <div class="fw-bold text-primary">#{{ $student->roll ?? 'N/A' }}</div>
                            </div>
                        </div>

                        @php
                            $pCount = collect($attendanceData)->where('title', 'P')->count();
                            $aCount = collect($attendanceData)->where('title', 'A')->count();
                            $total = $pCount + $aCount;
                            $rate = $total > 0 ? round(($pCount / $total) * 100) : 0;
                        @endphp

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="stat-card-mini">
                                    <h3 class="text-success fw-bold mb-0">{{ $pCount }}</h3>
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Present</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card-mini">
                                    <h3 class="text-danger fw-bold mb-0">{{ $aCount }}</h3>
                                    <small class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Absent</small>
                                </div>
                            </div>
                        </div>

                        <div class="attendance-progress">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="fw-bold text-dark">Attendance Rate</small>
                                <small class="fw-bold text-primary">{{ $rate }}%</small>
                            </div>
                            <div class="progress rounded-pill" style="height: 10px; background: #e2e8f0;">
                                <div class="progress-bar bg-primary-gradient" role="progressbar" style="width: {{ $rate }}%" aria-valuenow="{{ $rate }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Calendar Grid --}}
            <div class="col-lg-8">
                <div class="row g-4">
                    @php $formattedAtt = collect($attendanceData)->pluck('title', 'start')->toArray(); @endphp

                    @foreach(range(1, 12) as $month)
                    <div class="col-md-6">
                        <div class="calendar-card">
                            <div class="month-header-modern">
                                {{ date("F", mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                            </div>
                            <div class="card-body p-3">
                                <table class="calendar-table-modern">
                                    <thead>
                                        <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
                                    </thead>
                                    <tbody>
                                        @php
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
                                                    <td class="{{ ($isFriday || $isSpecialHoliday) ? 'day-off' : '' }} {{ $status == 'P' ? 'day-present' : ($status == 'A' ? 'day-absent' : '') }}">
                                                        @if($isFriday || $isSpecialHoliday)
                                                            <span class="off-label">OFF</span>
                                                        @endif
                                                        {{ $d++ }}
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
            <div class="text-center py-5">
                <i class="fa-solid fa-face-frown fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Student not found. Please verify the ID.</h5>
            </div>
        @endif
    </div>
</div>
@endsection