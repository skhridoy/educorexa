@extends('layouts.school')

@section('customCSS')
    <!-- @include('school.others._modern_design_styles') -->
 <style>
    /* ১. থিম ভ্যারিয়েবল সেট করা */
    :root {
        --card-bg: #ffffff;
        --card-border: #f1f5f9;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    /* ডার্ক মোড অ্যাক্টিভ হলে ভ্যারিয়েবল পরিবর্তন হবে */
    body.dark-mode {
        --card-bg: #0c1427; /* আপনার হেডার/সাইডবারের সাথে মিল রেখে */
        --card-border: #1a253b;
        --text-main: #ffffff;
        --text-muted: #ced4da;
    }

    /* ২. স্ট্যাট কার্ড আপডেট */
    .edu-stat-card {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border) !important;
        color: var(--text-main) !important;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .edu-stat-card .stat-label {
        color: var(--text-muted) !important;
    }

    .edu-stat-card .stat-value {
        color: var(--text-main) !important;
    }

    /* ৩. টেবিল এবং অন্যান্য প্যানেল আপডেট */
    .data-table-card, .schools-panel, .activity-card {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border) !important;
    }

    .panel-title, .table-title, .item-name {
        color: var(--text-main) !important;
    }

    /* ৪. টেবিলের নিচের বর্ডার এবং রো হোভার */
    body.dark-mode .edu-table tbody td {
        border-bottom: 1px solid #1a253b !important;
        color: #ced4da !important;
    }

    body.dark-mode .edu-table tbody tr:hover td {
        background: #111b2d !important;
    }

    /* ৫. কুইক অ্যাকশন কার্ড যদি সাদা হয়ে থাকে */
    .quick-actions-card {
        /* এটি গ্রেডিয়েন্ট থাকায় ডার্ক মোডেও ভালো দেখাবে, তবে বর্ডার ফিক্স করতে পারেন */
        border: 1px solid var(--card-border);
    }
    /* ===== Dashboard Specific Styles ===== */
    .edu-stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0px 4px 20px rgba(15, 23, 42, 0.05);
        transition: border-color 0.2s ease, transform 0.2s ease;
    }
    .edu-stat-card:hover {
        border-color: #c7d2fe;
        transform: translateY(-2px);
    }

    /* ৪. টেবিল আপডেট */
    .edu-table thead th {
        background: var(--table-header) !important;
        color: #fff;
    }

    .edu-table tbody td {
        border-bottom: 1px solid var(--card-border) !important;
        color: var(--text-muted) !important;
        background: var(--card-bg) !important;
        border-radius: 15px;
    }

    .edu-table tbody tr:hover td {
        background: rgba(99, 102, 241, 0.05) !important;
        
    }

    /* ৫. টেক্সট কালার ফিক্স */
    .panel-title, .item-name, .school-name, .activity-item p {
        color: var(--text-main) !important;

    }

    /* ৬. ব্যাজ এবং আইকন বক্স */
    .badge-edu { padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; display: inline-block; }
    .badge-present { background: rgba(22, 163, 74, 0.15); color: #22c55e; }
    .badge-absent { background: rgba(220, 38, 38, 0.15); color: #ef4444; }

    .stat-index, .teacher-name, .time-stamp, .item-date {
        color: var(--text-muted) !important;
    }

    @media (max-width: 576px) {
        .edu-stat-card { padding: 16px; }
        .edu-stat-card .stat-value { font-size: 1.4rem; }
        .edu-stat-card .icon-wrap { width: 38px; height: 38px; font-size: 1rem; }
    }
    .stat-value { font-size: 1.25rem !important; }
        .stat-label { font-size: 0.7rem !important; }
        .welcome-card h2 { font-size: 1.4rem !important; }
    .edu-stat-card .icon-wrap {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        transition: transform 0.2s ease;
    }
    .edu-stat-card:hover .icon-wrap { transform: scale(1.1); }
    .edu-stat-card .stat-badge {
        font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px;
    }
    .edu-stat-card .stat-label {
        font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase;
        font-weight: 700; color: #64748b; margin-bottom: 4px;
    }
    .edu-stat-card .stat-value {
        font-size: 1.75rem; font-weight: 700; color: #1e293b; line-height: 1;
    }

    /* Quick Actions gradient card */
    .quick-actions-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 16px; padding: 32px; color: #ffffff;
        min-height: 100%;
    }
    .quick-action-btn {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        padding: 14px 16px; background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;
        color: #ffffff; font-weight: 600; font-size: 0.875rem;
        transition: background 0.2s ease; text-decoration: none; margin-bottom: 10px;
    }
    .quick-action-btn:hover { background: rgba(255,255,255,0.2); color: #ffffff; }
    .quick-action-btn i { font-size: 1rem; opacity: 0.7; }
    .quick-action-btn .arrow { opacity: 0; transition: opacity 0.2s, transform 0.2s; }
    .quick-action-btn:hover .arrow { opacity: 1; transform: translateX(4px); }

    /* Activity Feed */
    .activity-card {
        background: #ffffff; border: 1px solid #f1f5f9; border-radius: 16px;
        padding: 32px; box-shadow: 0px 4px 20px rgba(15,23,42,0.05);
    }
    .activity-item { display: flex; gap: 16px; }
    .activity-avatar { position: relative; flex-shrink: 0; }
    .activity-avatar img, .activity-avatar .avatar-icon {
        width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
    }
    .activity-avatar .avatar-icon {
        display: flex; align-items: center; justify-content: center;
        background: #fef3c7; color: #d97706; font-size: 1rem;
    }
    .activity-badge {
        position: absolute; bottom: -2px; right: -2px;
        width: 18px; height: 18px; border-radius: 50%; border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center; font-size: 9px;
    }

    /* Events panel */
    .event-item {
        padding: 16px; border-radius: 14px; border-left: 5px solid transparent;
        transition: all 0.2s ease; cursor: pointer; background: #fff;
        border: 1px solid #f1f5f9; border-left-width: 5px;
    }
    .event-item:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .event-item.blue  { border-left-color: #3b82f6; background: #f0f7ff; }
    .event-item.purple{ border-left-color: #8b5cf6; background: #f5f3ff; }
    .event-item.green { border-left-color: #22c55e; background: #f0fdf4; }
    .event-time { font-size: 0.7rem; font-weight: 700; color: #64748b; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }

    /* Attendance bar chart */
    .attendance-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        border-radius: 16px; padding: 24px; color: #fff; position: relative; overflow: hidden;
    }
    .attendance-card::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 120px; height: 120px; border-radius: 50%;
        background: rgba(99,102,241,0.2); filter: blur(40px);
    }
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 80px; position: relative; z-index: 1; }
    .bar { flex: 1; border-radius: 4px 4px 0 0; background: rgba(255,255,255,0.15); transition: background 0.2s; }
    .bar.active { background: #6366f1; box-shadow: 0 0 15px rgba(99,102,241,0.5); }
    .bar:hover { background: rgba(255,255,255,0.3); }

    /* Recent Schools Table */
    .schools-panel { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0px 4px 20px rgba(15,23,42,0.05); }
    .panel-header { padding: 24px 28px; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center; }
    .panel-title { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0; }
    .edu-table thead th { background: #1e293b; color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 14px 16px; border: none; }
    .edu-table thead th:first-child { border-radius: 8px 0 0 8px; }
    .edu-table thead th:last-child  { border-radius: 0 8px 8px 0; }
    .edu-table tbody td { padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #475569; }
    .edu-table tbody tr:last-child td { border-bottom: none; }
    .edu-table tbody tr:hover td { background: #fafbff; }
    .school-name { font-weight: 700; color: #1e293b; font-size: 0.9rem; }
    .school-date { font-size: 0.75rem; color: #94a3b8; }
    .school-icon { width: 36px; height: 36px; background: #eef2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 0.9rem; flex-shrink: 0; }
    .slug-code { background: #eef2ff; color: #4f46e5; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; font-family: monospace; }
    .badge-active   { background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; }
    .badge-inactive { background: #f1f5f9; color: #64748b; font-weight: 700; font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; }

    /* Mobile Table Overrides */
    @media (max-width: 768px) {
        .edu-table thead { display: none; }
        .edu-table tbody tr { display: block; padding: 15px; border-bottom: 8px solid #f8fafc; }
        .edu-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; text-align: right; width: 100%; }
        .edu-table tbody td::before { content: attr(data-label); font-weight: 700; font-size: 10px; text-transform: uppercase; color: #94a3b8; text-align: left; }
        .edu-table tbody td:last-child { justify-content: center; border-top: 1px solid #f1f5f9; margin-top: 10px; padding-top: 15px; }
        .edu-table tbody td:last-child::before { display: none; }
    }
</style>
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
        <div class="welcome-card mb-4 p-4 p-md-5 position-relative overflow-hidden" 
             style="border-radius:24px; background:linear-gradient(135deg, #002147 0%, #003366 100%); color:white; box-shadow: 0 10px 30px rgba(0,33,71,0.15);">
            <div style="position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
            
            <div class="row align-items-center position-relative" style="z-index:1;">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="greet-icon-box d-none d-sm-flex" style="width:50px; height:50px; background:rgba(255,255,255,0.1); border-radius:14px; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor == '#3b82f6' ? '#60a5fa' : $greetColor }}"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="font-family:'Outfit',sans-serif;">
                            {{ $greeting }}, {{ auth()->user()->name }}!
                        </h2>
                    </div>
                    <p class="mb-0 opacity-75 fs-6 fs-md-5" style="max-width:600px;">
                        EduCorexa: আপনার স্কুলের গুরুত্বপূর্ণ তথ্যসমূহ এক নজরে দেখে নিন।
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ now()->format('d M Y') }}
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

            <div class="col-md-3 col-6">
                <div class="edu-stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-wrap" style="background:#bef3c7; color:#e977a6;">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <span class="stat-badge" style="background:#bef3c7;color:#e977a6;">Income</span>
                    </div>
                    <div class="stat-label">Total Expected</div>
                    <div class="stat-value">{{ number_format($totalExpected, 0) }}</div>
                </div>
            </div>
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

                    <a href="{{ route('students.create') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i> Add New Student
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('teachers.create') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-person-chalkboard"></i> Add New Teacher
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('attendances.index') ?? '#' }}" class="quick-action-btn">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-clipboard-check"></i> Mark Attendance
                        </span>
                        <i class="fa-solid fa-arrow-right arrow"></i>
                    </a>
                    <a href="{{ route('exams.index') ?? '#' }}" class="quick-action-btn mb-0">
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
                                    {{-- যেহেতু পুরো ক্লাসের হাজিরা শেষ, তাই এখানে একটি 'ইউজার-টাই' বা 'বুক' আইকন সুন্দর দেখাবে --}}
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div class="activity-badge" style="background:#22c55e;">
                                    <i class="fa-solid fa-check" style="color:#fff;font-size:8px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0" style="font-weight:700;color:#1e293b;font-size:0.9rem;">
                                        {{ $log->teacher->name ?? 'Unknown Teacher' }}
                                        <span style="font-weight:400;color:#64748b;"> - {{ $log->class->name ?? 'N/A' }}</span>
                                    </p>
                                    {{-- গ্রুপের শেষ হাজিরার সময়টি দেখাবে --}}
                                    <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;margin-left:12px;">
                                        {{ \Carbon\Carbon::parse($log->last_marked)->format('h:i A') }}
                                    </span>
                                </div>
                                <p class="mb-0 mt-1" style="font-size:0.8rem;color:#94a3b8;">
                                    <i class="fa-solid fa-circle-check text-success" style="font-size:10px;"></i>
                                    Attendance Completed for <strong>{{ $log->section->name ?? 'All Sections' }}</strong>
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-inbox fa-2x mb-2" style="color:#cbd5e1;"></i>
                            <p class="text-muted mb-0">No attendance marked yet today.</p>
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
                                    <th>Class & Section</th>
                                    <th class="text-center">Status</th>
                                    <th>Marked By</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceLogs ?? [] as $key => $log)
                                <tr>
                                    <td class="stat-index">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-icon d-none d-sm-flex"><i class="fa-solid fa-chalkboard"></i></div>
                                            <div class="text-start">
                                                <div class="item-name text-truncate" style="max-width:120px;">{{ $log->class->name ?? 'N/A' }}</div>
                                                <div class="item-date">Section: {{ $log->section->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($log->status == 'present')
                                            <span class="badge-edu badge-present">✓ Present</span>
                                        @else
                                            <span class="badge-edu badge-absent">✗ Absent</span>
                                        @endif
                                    </td>
                                    <td class="teacher-name">
                                        {{ $log->teacher->name ?? 'Admin' }}
                                    </td>
                                    <td class="time-stamp">
                                        {{ $log->last_marked ? \Carbon\Carbon::parse($log->last_marked)->format('h:i A') : 'N/A' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-25 mb-2">
                                            <i class="fa-solid fa-clipboard-question fa-3x"></i>
                                        </div>
                                        <p class="text-muted">No attendance activity recorded for today.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Attendance Chart (Dynamic Bars) --}}
            <div class="col-md-4 d-flex flex-column gap-4">
                <div class="attendance-card flex-grow-1">
                    <div style="position:relative;z-index:1;">
                        <h6 class="fw-bold mb-0" style="font-family:'Outfit',sans-serif;">Attendance This Week</h6>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-bottom:20px;">Daily attendance percentage</p>
                        
                        <div class="bar-chart">
                            @php
                                // এই অ্যারেটি কন্ট্রোলার থেকে আসা উচিত। নিচে একটি ডিফোল্ট স্ট্রাকচার দেওয়া হলো।
                                $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                $currentDay = date('D');
                            @endphp

                            @foreach($weekDays as $day)
                                @php
                                    // কন্ট্রোলার থেকে আসা $weeklyStats অ্যারে থেকে ডাটা নেয়া
                                    $percentage = $weeklyStats[$day] ?? 0; 
                                    $isActive = ($day == $currentDay);
                                @endphp
                                <div class="bar {{ $isActive ? 'active' : '' }}" 
                                    style="height: {{ $percentage }}%;" 
                                    data-bs-toggle="tooltip" 
                                    title="{{ $day }}: {{ $percentage }}%">
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mt-2" style="color:rgba(255,255,255,0.4);font-size:0.7rem;">
                            @foreach($weekDays as $day)
                                <span style="{{ $day == $currentDay ? 'color:#fff; font-weight:bold;' : '' }}">{{ $day }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
