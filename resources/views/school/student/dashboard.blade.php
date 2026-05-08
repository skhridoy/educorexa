@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12)      { $greeting = "Good Morning";   $faIcon = "fa-sun";     $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = "Good Afternoon"; $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = "Good Evening";   $faIcon = "fa-sunset";  $greetColor = "#8b5cf6"; }
            else                               { $greeting = "Good Night";     $faIcon = "fa-moon";    $greetColor = "#3b82f6"; }
        @endphp

        {{-- ===== WELCOME HERO CARD ===== --}}
        <div class="welcome-card mb-4 p-4 p-md-5">
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box d-none d-sm-flex">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75 fs-6 fs-md-5" style="max-width:600px;">
                        Class : {{ $student->class->name }} | Section : {{ $student->section->name }} | Roll : {{ $student->roll }}
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> Student ID: {{ $student->student_id }}
                        </span>
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <i class="fa-solid fa-graduation-cap text-white opacity-10" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="row g-4 mb-4">
            
            <div class="col-md-4 col-12">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:rgba(13, 110, 253, 0.1); color:#0d6efd;">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <span class="stat-badge" style="background:rgba(13, 110, 253, 0.1); color:#0d6efd;">Attendance</span>
                    </div>
                    <div class="stat-label">This Month's Attendance</div>
                    <div class="stat-value">{{ $attendancePercentage }}%</div>
                    <div class="mt-2 text-muted small">{{ $presentDays }}/{{ $totalDays }} days present</div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:rgba(220, 53, 69, 0.1); color:#dc3545;">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <span class="stat-badge" style="background:rgba(220, 53, 69, 0.1); color:#dc3545;">Fees</span>
                    </div>
                    <div class="stat-label">Total Due Fee</div>
                    <div class="stat-value text-danger">৳ {{ number_format($totalDue) }}</div>
                    <div class="mt-2 text-muted small">{{ $unpaidFees->count() }} unpaid fees</div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:rgba(25, 135, 84, 0.1); color:#198754;">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <span class="stat-badge" style="background:rgba(25, 135, 84, 0.1); color:#198754;">Homework</span>
                    </div>
                    <div class="stat-label">Upcoming Assignments</div>
                    <div class="stat-value text-success">{{ $diaries->count() }}</div>
                    <div class="mt-2 text-muted small">Home Work & Class Work</div>
                </div>
            </div>
        </div>
    
        <div class="row g-4 mt-2">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-book-open me-2 text-primary"></i>আজকের ডায়েরি / বাড়ির কাজ</h5>
                    </div>
                    <div class="card-body">
                        @forelse($diaries as $diary)
                            <div class="p-3 mb-3 border-start border-4 border-primary rounded-3 shadow-sm" style="background: var(--card-bg);">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1 text-primary">{{ $diary->subject->name }}</h6>
                                    <small class="text-muted"><i class="far fa-user me-1"></i> {{ $diary->teacher->name ?? 'শিক্ষক' }}</small>
                                </div>
                                <p class="mb-0 opacity-75">{{ $diary->lesson_description }}</p>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fa-solid fa-clipboard-check fa-4x mb-3 opacity-25"></i>
                                <p class="text-muted">আজকের জন্য কোনো বাড়ির কাজ দেওয়া হয়নি।</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
    
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-file-invoice-dollar me-2 text-danger"></i>Unpaid Fee's List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table edu-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Fee Name</th>
                                        <th class="text-end pe-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unpaidFees as $fee)
                                        <tr>
                                            <td class="ps-3">
                                                <span class="d-block fw-bold">{{ $fee->feeHead->name }}</span>
                                                <small class="text-muted">{{ $fee->month }}</small>
                                            </td>
                                            <td class="text-end pe-3 text-danger fw-bold">৳{{ number_format($fee->amount, 0) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-5 text-success">
                                                <i class="fa-solid fa-circle-check fa-2x mb-2 d-block"></i>
                                                আপনার কোনো বকেয়া নেই!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($totalDue > 0)
                    <div class="card-footer border-0 bg-transparent py-3 px-3">
                        <a href="#" class="btn btn-danger w-100 rounded-pill py-2 shadow-sm fw-bold">Pay Now</a>
                    </div>
                    @endif
                </div>
            </div>
        {{-- ===== WEEKLY ROUTINE SECTION (TABLE CHART) ===== --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title"><i class="fa-solid fa-table-columns me-2 text-primary"></i>My Class Weekly Routine Chart</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table routine-chart-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Day</th>
                                    <th>Periods & Subjects</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                    $today = date('l');
                                @endphp
                                @foreach($days as $day)
                                    <tr class="{{ strtolower($day) == strtolower($today) ? 'chart-today' : '' }}">
                                        <td class="chart-day-cell">
                                            <span class="fw-bold">{{ $day }}</span>
                                            @if(strtolower($day) == strtolower($today))
                                                <span class="badge bg-primary ms-1" style="font-size: 8px;">Today</span>
                                            @endif
                                        </td>
                                        <td class="chart-content-cell">
                                            <div class="d-flex flex-wrap gap-2">
                                                @forelse($routines[$day] ?? [] as $r)
                                                    <div class="chart-routine-box">
                                                        <div class="time">{{ \Carbon\Carbon::parse($r->start_time)->format('h:i A') }}</div>
                                                        <div class="subject">{{ $r->subject->name }}</div>
                                                        <div class="teacher-info"><i class="fa-solid fa-chalkboard-user me-1"></i> {{ $r->teacher->name }}</div>
                                                    </div>
                                                @empty
                                                    <span class="text-muted small italic">No classes scheduled</span>
                                                @endforelse
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .routine-chart-table thead th {
                background: #f8fafc;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #64748b;
                padding: 12px 20px;
                border-bottom: 2px solid #e2e8f0;
            }
            .chart-day-cell {
                background: #f8fafc;
                border-right: 1px solid #e2e8f0;
                padding: 15px 20px !important;
                vertical-align: middle;
                color: #1e293b;
            }
            .chart-today .chart-day-cell {
                background: rgba(79, 70, 229, 0.05);
                color: #4f46e5;
            }
            .chart-content-cell {
                padding: 15px 20px !important;
            }
            .chart-routine-box {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 8px 12px;
                min-width: 170px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .chart-routine-box .time {
                font-size: 9px;
                font-weight: 800;
                color: #4f46e5;
                margin-bottom: 2px;
            }
            .chart-routine-box .subject {
                font-weight: 700;
                font-size: 0.85rem;
                color: #1e293b;
            }
            .chart-routine-box .teacher-info {
                font-size: 10px;
                color: #64748b;
            }
            .chart-today {
                border-left: 3px solid #4f46e5;
            }
        </style>
    </div>
</div>
@endsection