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
        <div class="welcome-card mb-5 p-4 p-md-5 position-relative overflow-hidden" style="border-radius:24px; background:linear-gradient(135deg, #1e293b, #334155); color:white; box-shadow: 0 10px 30px rgba(15,23,42,0.15);">
            <!-- Abstract background shapes -->
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            <div style="position:absolute; bottom:-30px; left:10%; width:100px; height:100px; background:rgba(79,70,229,0.1); border-radius:50%; filter:blur(20px);"></div>
            
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box" style="width:50px; height:50px; background:rgba(255,255,255,0.1); border-radius:14px; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif; letter-spacing:-0.02em;">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75" style="font-size:1rem; max-width:500px;">
                        Welcome back to your School Admin Dashboard. Here's a real-time overview of your school's performance today.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <div style="font-size: 6rem; opacity: 0.1;">
                        <i class="fa-solid fa-school"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="row g-4 mb-4">

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Active</span>
                    </div>
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef3c7;color:#d97706;">Staff</span>
                    </div>
                    <div class="stat-label">Total Teachers</div>
                    <div class="stat-value">{{ $totalTeachers }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <span class="stat-badge" style="background:#dcfce7;color:#16a34a;">Available</span>
                    </div>
                    <div class="stat-label">Classes</div>
                    <div class="stat-value">{{ $classesCount ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#f5f3ff; color:#7c3aed;">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <span class="stat-badge" style="background:#e0e7ff;color:#4338ca;">Attendance</span>
                    </div>
                    <div class="stat-label">Present Today</div>
                    <div class="stat-value">{{ $presentCount ?? 0 }}</div>
                </div>
            </div>

        </div>

        {{-- ===== BENTO GRID: Quick Actions + Activity Feed ===== --}}
        <div class="row g-4 mb-4">

            {{-- Quick Actions --}}
            <div class="col-md-4">
                <div class="quick-actions-card">
                    <h5 class="mb-1 fw-bold" style="font-family:'Outfit',sans-serif;">Quick Actions</h5>
                    <p class="mb-4" style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Execute common tasks instantly.</p>

                    <a href="{{ route('student.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i> Add New Student
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('teacher.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-person-chalkboard"></i> Add New Teacher
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('attendance.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-check"></i> Mark Attendance
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('exam.index') ?? '#' }}" class="quick-action-btn mb-0">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen"></i> Manage Exams
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="col-md-8">
                <div class="activity-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;color:#1e293b;">Recent Attendance Logs</h5>
                    </div>
                    <div class="d-flex flex-column gap-4">
                        @forelse($attendanceLogs ?? [] as $log)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <div class="avatar-icon" style="background:#eef2ff;color:#4f46e5;">
                                    @if($log->status == 'present')
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid fa-times"></i>
                                    @endif
                                </div>
                                <div class="activity-badge" style="background:{{ $log->status == 'present' ? '#22c55e' : '#ef4444' }};">
                                    <i class="fa-solid fa-circle" style="color:#fff;font-size:6px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0" style="font-weight:700;color:#1e293b;font-size:0.9rem;">
                                        {{ $log->teacher->name ?? 'N/A' }}
                                        <span style="font-weight:400;color:#64748b;"> - {{ $log->class->name ?? 'N/A' }}</span>
                                    </p>
                                    <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;margin-left:12px;">{{ $log->created_at->format('h:i A') }}</span>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.8rem;color:#94a3b8;">
                                    <i class="fa-solid fa-circle" style="font-size:4px;"></i>
                                    Status: <strong>{{ ucfirst($log->status) }}</strong>
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-inbox fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0">No recent attendance logs</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== BOTTOM ROW: Attendance Activity Chart ===== --}}
        <div class="row g-4">

            {{-- Attendance Table --}}
            <div class="col-md-8">
                <div class="schools-panel">
                    <div class="panel-header">
                        <h6 class="panel-title">Today's Attendance Summary</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table edu-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceLogs ?? [] as $key => $log)
                                <tr>
                                    <td data-label="#" style="color:#94a3b8;font-weight:600;">{{ $key + 1 }}</td>
                                    <td data-label="Class">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-icon d-none d-sm-flex"><i class="fa-solid fa-chalkboard"></i></div>
                                            <div class="text-start">
                                                <div class="item-name text-truncate" style="max-width:120px;">{{ $log->class->name ?? 'N/A' }}</div>
                                                <div class="item-date">{{ $log->section->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Present">
                                        <span style="background:#dcfce7;color:#16a34a;padding:4px 10px;border-radius:6px;font-weight:600;font-size:0.85rem;">
                                            {{ $log->status == 'present' ? '✓ Present' : '-' }}
                                        </span>
                                    </td>
                                    <td data-label="Absent">
                                        <span style="background:#fee2e2;color:#dc2626;padding:4px 10px;border-radius:6px;font-weight:600;font-size:0.85rem;">
                                            {{ $log->status == 'absent' ? '✗ Absent' : '-' }}
                                        </span>
                                    </td>
                                    <td data-label="Date">{{ $log->date->format('d M, Y') ?? now()->format('d M, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fa-solid fa-inbox fa-2x mb-3 d-block" style="color:#e2e8f0;"></i>
                                        <span class="text-muted">No attendance records found.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Attendance Chart --}}
            <div class="col-md-4 d-flex flex-column gap-4">
                <div class="attendance-card flex-grow-1">
                    <div style="position:relative;z-index:1;">
                        <h6 class="fw-bold mb-0" style="font-family:'Outfit',sans-serif;">Attendance This Week</h6>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-bottom:20px;">Daily attendance percentage</p>
                        <div class="bar-chart">
                            <div class="bar" style="height:55%;"></div>
                            <div class="bar" style="height:75%;"></div>
                            <div class="bar" style="height:60%;"></div>
                            <div class="bar" style="height:90%;"></div>
                            <div class="bar" style="height:70%;"></div>
                            <div class="bar active" style="height:95%;"></div>
                            <div class="bar" style="height:40%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2" style="color:rgba(255,255,255,0.4);font-size:0.7rem;">
                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
