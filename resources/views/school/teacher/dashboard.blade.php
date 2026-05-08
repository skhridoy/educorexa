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
                        আপনার আজকের ক্লাসের সময়সূচী এবং রিপোর্ট এক নজরে দেখে নিন।
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <span class="badge bg-dark bg-opacity-10 border border-dark border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ now()->format('d M Y') }}
                        </span>
                        <span class="badge bg-dark bg-opacity-10 border border-dark border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <i class="fa-solid fa-person-chalkboard text-dark opacity-10" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#dcfce7; color:#16a34a;">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Collection</span>
                    </div>
                    <div class="stat-label">My Collection</div>
                    <div class="stat-value">৳{{ number_format($myTotalCollected) }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <span class="stat-badge" style="background:#eff6ff;color:#3b82f6;">Students</span>
                    </div>
                    <div class="stat-label">My Students</div>
                    <div class="stat-value">{{ $totalStudents ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-chalkboard"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef3c7;color:#d97706;">Classes</span>
                    </div>
                    <div class="stat-label">Today's Classes</div>
                    <div class="stat-value">5</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fee2e2; color:#dc2626;">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <span class="stat-badge" style="background:#fee2e2;color:#dc2626;">Pending</span>
                    </div>
                    <div class="stat-label">Pending Diary</div>
                    <div class="stat-value">{{ $pendingDiaries ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            {{-- Quick Actions --}}
            <div class="col-md-4">
                <div class="quick-actions-card">
                    <h5 class="mb-1 fw-bold" style="font-family:'Outfit',sans-serif;color:#1e293b;">Quick Actions</h5>
                    <p class="mb-4" style="color:rgba(0,0,0,0.5);font-size:0.85rem;">শর্টকাট বাটনগুলো ব্যবহার করুন।</p>

                    <a href="{{ route('attendances.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-user"></i> Take Attendance
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('marks.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen-nib"></i> Add Student Marks
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('students.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-users"></i> My Students List
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="#" class="quick-action-btn mb-0">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Collection Report
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                </div>
            </div>

            {{-- Attendance Chart --}}
            <div class="col-md-8">
                <div class="schools-panel white-panel h-100">
                    <div class="panel-header">
                        <h6 class="panel-title">Attendance Overview (Last 7 Days)</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="chart-container" style="position: relative; height:280px; width:100%">
                            <canvas id="teacherAttendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== WEEKLY ROUTINE SECTION (TABLE CHART) ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title"><i class="fa-solid fa-table-list me-2 text-primary"></i>My Weekly Class Routine Chart</h6>
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
                                                        <div class="class-info">{{ $r->class->name }} ({{ $r->section->name }})</div>
                                                    </div>
                                                @empty
                                                    <span class="text-muted small italic">No classes</span>
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
                background: #0f172a;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #f8fafc;
                padding: 12px 20px;
                border-bottom: 2px solid var(--border-color);
            }
            .chart-day-cell {
                background: rgba(0,0,0,0.02);
                border-right: 1px solid var(--border-color);
                padding: 15px 20px !important;
                vertical-align: middle;
                color: inherit;
            }
            [data-bs-theme="dark"] .chart-day-cell, body.dark-mode .chart-day-cell {
                background: rgba(255,255,255,0.02);
            }
            .chart-today .chart-day-cell {
                background: rgba(79, 70, 229, 0.05);
                color: #4f46e5;
            }
            .chart-content-cell {
                padding: 15px 20px !important;
            }
            .chart-routine-box {
                background: var(--card-bg, #fff);
                border: 1px solid var(--border-color, #e2e8f0);
                border-radius: 8px;
                padding: 8px 12px;
                min-width: 160px;
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
                color: inherit;
            }
            .chart-routine-box .class-info {
                font-size: 10px;
                color: var(--text-muted);
            }
            .chart-today {
                border-left: 3px solid #4f46e5;
            }
            @media (max-width: 768px) {
                .chart-routine-box { min-width: 100%; }
                .chart-day-cell { padding: 10px !important; font-size: 0.8rem; }
            }
        </style>

        <div class="row">
            {{-- Recent Collections --}}
            <div class="col-12">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title">My Recent Fee Collections</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table edu-table mb-0">
                            <thead>
                                <tr>
                                    <th>Roll</th>
                                    <th>Date</th>
                                    <th>Student Name</th>
                                    <th>Fee Category</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCollections as $collection)
                                <tr>
                                    <td><span class="badge bg-light text-dark fw-bold">{{ $collection->student->roll }}</span></td>
                                    <td>{{ $collection->created_at->format('d M, Y') }}</td>
                                    <td><span class="fw-bold">{{ $collection->student->name }}</span></td>
                                    <td>{{ $collection->feeHead->name ?? 'General Fee' }}</td>
                                    <td class="text-end fw-bold text-success">৳{{ number_format($collection->amount) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-25 mb-2">
                                            <i class="fa-solid fa-receipt fa-3x"></i>
                                        </div>
                                        <p class="text-muted">আপনি এখনও কোনো ফি কালেক্ট করেননি।</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    const ctx = document.getElementById('teacherAttendanceChart').getContext('2d');
    
    // Gradient for chart
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($lastSevenDays ?? ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri']) !!},
            datasets: [{
                label: 'Attendance (%)',
                data: {!! json_encode($attendanceStats ?? [85, 90, 88, 92, 80, 95, 89]) !!},
                borderColor: '#4f46e5',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    max: 100, 
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { callback: value => value + '%' }
                },
                x: { grid: { display: false, drawBorder: false } }
            }
        }
    });
});
</script>
@endsection