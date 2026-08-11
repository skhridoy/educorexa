@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═══════════════════════════════════════════════
           ATTENDANCE ANALYTICS — PREMIUM RESPONSIVE DESIGN STYLES
        ═══════════════════════════════════════════════ */
        
        /* Stats Summary Cards Grid */
        .analytics-stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 18px;
        }
        .analytics-stat-card {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .analytics-stat-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.24);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .analytics-stat-icon {
            width: 48px; height: 48px;
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
            box-shadow: inset 0 0 10px rgba(255,255,255,0.2);
        }
        .analytics-stat-val {
            font-size: 1.6rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.5px;
        }
        .analytics-stat-lbl {
            font-size: 0.74rem; opacity: 0.92; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .analytics-stat-sub {
            font-size: 0.71rem; opacity: 0.85; margin-top: 3px; font-weight: 500;
        }

        /* Glass Filter Card */
        .analytics-filter-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            padding: 18px 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 20px rgba(15,23,42,0.03);
        }
        .analytics-filter-card .form-control, 
        .analytics-filter-card .form-select {
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 0.85rem;
            transition: all 0.2s;
            height: 42px;
        }
        .analytics-filter-card .form-control:focus, 
        .analytics-filter-card .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        /* Chart Cards */
        .chart-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 20px rgba(15,23,42,0.03);
            transition: all 0.2s;
        }
        .chart-card:hover {
            box-shadow: 0 8px 25px rgba(15,23,42,0.06);
        }
        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid #f1f5f9;
        }
        .chart-title {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .chart-container-box {
            height: 250px;
            position: relative;
        }

        /* Custom Status Badges */
        .badge-status-present {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #15803d;
            border: 1px solid #86efac;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-status-absent {
            background: linear-gradient(135deg, #fee2e2, #fca5a5);
            color: #b91c1c;
            border: 1px solid #f87171;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-completed {
            background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;
            padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .badge-pending {
            background: #fef3c7; color: #b45309; border: 1px solid #fde68a;
            padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 4px;
        }

        /* Pulsing Status Dot */
        .pulse-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            display: inline-block;
        }
        .pulse-dot-green { background: #22c55e; box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.3); }
        .pulse-dot-red   { background: #ef4444; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3); }
        .pulse-dot-amber { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3); }

        /* Progress Bar */
        .progress-sm {
            height: 8px;
            border-radius: 10px;
            background: #f1f5f9;
            overflow: hidden;
        }
        .progress-bar-gradient {
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 10px;
        }

        /* Student Initial Avatar */
        .avatar-initial {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Table Enhancements */
        .desktop-analytics-table table tbody tr {
            transition: all 0.15s;
        }
        .desktop-analytics-table table tbody tr:hover {
            background-color: #f8fafc !important;
            border-left: 3px solid #4f46e5;
        }

        /* Chart Center Overlay */
        .doughnut-center-stat {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }
        .doughnut-center-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }
        .doughnut-center-lbl {
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* 📱 RESPONSIVE BREAKPOINTS (MOBILE & TABLET) */
        @media (max-width: 991.98px) {
            /* Force 2 COLUMNS for Counter Cards on Mobile & Tablet */
            .analytics-stats-bar {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }
            .analytics-stat-card {
                padding: 12px 14px !important;
                gap: 10px !important;
                border-radius: 14px !important;
            }
            .analytics-stat-icon {
                width: 38px !important;
                height: 38px !important;
                font-size: 1.1rem !important;
                border-radius: 10px !important;
            }
            .analytics-stat-val {
                font-size: 1.3rem !important;
            }
            .analytics-stat-lbl {
                font-size: 0.68rem !important;
                letter-spacing: 0.3px !important;
            }
            .analytics-stat-sub {
                font-size: 0.65rem !important;
            }
        }

        @media (max-width: 767.98px) {
            /* Filter bar: Section & Buttons take full width on mobile */
            .analytics-filter-section-col,
            .analytics-filter-btn-col {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            /* Filter bar quick-buttons: stretch to full width on mobile */
            .analytics-filter-btn-group {
                flex-wrap: wrap !important;
                gap: 6px !important;
                justify-content: flex-start !important;
                width: 100% !important;
            }
            .analytics-filter-btn-group .btn {
                flex: 1 1 auto;
                min-width: 80px;
                text-align: center;
            }

            /* Table header: let search wrap below title */
            .student-logs-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
            }
            .student-logs-header .log-search-area {
                width: 100% !important;
            }
            .student-logs-header .log-search-area form {
                flex-direction: column !important;
                width: 100% !important;
                gap: 8px !important;
            }
            .student-logs-header .log-search-area form .form-select,
            .student-logs-header .log-search-area form .input-group {
                width: 100% !important;
            }

            /* Empty state fix: icon & text always stacked vertically */
            .empty-state-td > div {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                gap: 10px !important;
            }
            .empty-state-td > div > i {
                flex-shrink: 0 !important;
            }
            .empty-state-td > div > div {
                width: 100% !important;
            }
        }

        @media (max-width: 575.98px) {
            .analytics-stats-bar {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 8px !important;
            }
            .analytics-stat-card {
                padding: 10px 10px !important;
                gap: 8px !important;
            }
            .analytics-stat-icon {
                width: 34px !important;
                height: 34px !important;
                font-size: 0.95rem !important;
            }
            .analytics-stat-val {
                font-size: 1.15rem !important;
            }
            .analytics-stat-lbl {
                font-size: 0.62rem !important;
            }
            .chart-card {
                padding: 16px !important;
            }
            .chart-container-box {
                height: 210px !important;
            }
            .analytics-filter-card {
                padding: 14px 16px !important;
            }
        }

        /* ═══════════════════════════════════════════════
           🌙 DARK MODE — ATTENDANCE ANALYTICS
        ═══════════════════════════════════════════════ */

        /* Filter Card */
        [data-bs-theme="dark"] .analytics-filter-card,
        body.dark-mode .analytics-filter-card {
            background: #0c1427 !important;
            border-color: #1e2d45 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        }
        [data-bs-theme="dark"] .analytics-filter-card .form-label,
        body.dark-mode .analytics-filter-card .form-label {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .analytics-filter-card .form-control,
        [data-bs-theme="dark"] .analytics-filter-card .form-select,
        body.dark-mode .analytics-filter-card .form-control,
        body.dark-mode .analytics-filter-card .form-select {
            background: #0f1a2e !important;
            border-color: #1e2d45 !important;
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .analytics-filter-card .btn-outline-secondary,
        body.dark-mode .analytics-filter-card .btn-outline-secondary {
            color: #94a3b8 !important;
            border-color: #1e2d45 !important;
            background: #0f1a2e !important;
        }
        [data-bs-theme="dark"] .analytics-filter-card .btn-outline-secondary:hover,
        body.dark-mode .analytics-filter-card .btn-outline-secondary:hover {
            background: #1e2d45 !important;
            color: #e2e8f0 !important;
        }

        /* Chart Cards */
        [data-bs-theme="dark"] .chart-card,
        body.dark-mode .chart-card {
            background: #0c1427 !important;
            border-color: #1e2d45 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        }
        [data-bs-theme="dark"] .chart-header,
        body.dark-mode .chart-header {
            border-bottom-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .chart-title,
        body.dark-mode .chart-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .chart-card .border,
        body.dark-mode .chart-card .border {
            border-color: #1e2d45 !important;
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .doughnut-center-val,
        body.dark-mode .doughnut-center-val {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .doughnut-center-lbl,
        body.dark-mode .doughnut-center-lbl {
            color: #94a3b8 !important;
        }

        /* Data Table Cards */
        [data-bs-theme="dark"] .data-table-card,
        body.dark-mode .data-table-card {
            background: #0c1427 !important;
            border-color: #1e2d45 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        }
        [data-bs-theme="dark"] .data-table-card .table-header,
        [data-bs-theme="dark"] .data-table-card .border-bottom,
        body.dark-mode .data-table-card .table-header,
        body.dark-mode .data-table-card .border-bottom {
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .data-table-card .table-title,
        body.dark-mode .data-table-card .table-title {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .data-table-card .text-dark,
        body.dark-mode .data-table-card .text-dark {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .data-table-card .text-muted,
        body.dark-mode .data-table-card .text-muted {
            color: #64748b !important;
        }
        [data-bs-theme="dark"] .data-table-card small,
        body.dark-mode .data-table-card small {
            color: #64748b !important;
        }

        /* Table thead */
        [data-bs-theme="dark"] .data-table-card thead.bg-light,
        body.dark-mode .data-table-card thead.bg-light {
            background: #0f1a2e !important;
        }
        [data-bs-theme="dark"] .data-table-card thead th,
        body.dark-mode .data-table-card thead th {
            color: #64748b !important;
            border-bottom-color: #1e2d45 !important;
            background: #0f1a2e !important;
        }

        /* Table tbody rows */
        [data-bs-theme="dark"] .data-table-card tbody tr,
        body.dark-mode .data-table-card tbody tr {
            border-bottom-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .data-table-card tbody tr:hover,
        body.dark-mode .data-table-card tbody tr:hover {
            background-color: #0f1a2e !important;
        }
        [data-bs-theme="dark"] .data-table-card tbody td,
        body.dark-mode .data-table-card tbody td {
            color: #cbd5e1 !important;
            border-bottom-color: #1e2d45 !important;
        }

        /* Form controls inside table header */
        [data-bs-theme="dark"] .data-table-card .form-select,
        [data-bs-theme="dark"] .data-table-card .form-control,
        body.dark-mode .data-table-card .form-select,
        body.dark-mode .data-table-card .form-control {
            background: #0f1a2e !important;
            border-color: #1e2d45 !important;
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .data-table-card .form-select option,
        body.dark-mode .data-table-card .form-select option {
            background: #0c1427;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .data-table-card .input-group .form-control::placeholder,
        body.dark-mode .data-table-card .input-group .form-control::placeholder {
            color: #475569 !important;
        }

        /* Badges in dark mode */
        [data-bs-theme="dark"] .badge-status-present,
        body.dark-mode .badge-status-present {
            background: rgba(34, 197, 94, 0.12) !important;
            color: #4ade80 !important;
            border-color: rgba(74, 222, 128, 0.25) !important;
        }
        [data-bs-theme="dark"] .badge-status-absent,
        body.dark-mode .badge-status-absent {
            background: rgba(239, 68, 68, 0.12) !important;
            color: #f87171 !important;
            border-color: rgba(248, 113, 113, 0.25) !important;
        }
        [data-bs-theme="dark"] .badge-completed,
        body.dark-mode .badge-completed {
            background: rgba(99, 102, 241, 0.15) !important;
            color: #a5b4fc !important;
            border-color: rgba(165, 180, 252, 0.2) !important;
        }
        [data-bs-theme="dark"] .badge-pending,
        body.dark-mode .badge-pending {
            background: rgba(245, 158, 11, 0.12) !important;
            color: #fbbf24 !important;
            border-color: rgba(251, 191, 36, 0.2) !important;
        }
        [data-bs-theme="dark"] .data-table-card .badge.bg-light,
        body.dark-mode .data-table-card .badge.bg-light {
            background: #0f1a2e !important;
            color: #94a3b8 !important;
            border-color: #1e2d45 !important;
        }

        /* Progress bar track */
        [data-bs-theme="dark"] .progress-sm,
        body.dark-mode .progress-sm {
            background: #1e2d45 !important;
        }

        /* Table row hover */
        [data-bs-theme="dark"] .desktop-analytics-table table tbody tr:hover,
        body.dark-mode .desktop-analytics-table table tbody tr:hover {
            background-color: #0f1a2e !important;
        }

        /* Empty state in dark */
        [data-bs-theme="dark"] .empty-state-td .fa-folder-open,
        body.dark-mode .empty-state-td .fa-folder-open {
            color: #334155 !important;
        }
        [data-bs-theme="dark"] .empty-state-td h6,
        body.dark-mode .empty-state-td h6 {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .empty-state-td p,
        body.dark-mode .empty-state-td p {
            color: #64748b !important;
        }

        /* Border-top for pagination */
        [data-bs-theme="dark"] .data-table-card .border-top,
        body.dark-mode .data-table-card .border-top {
            border-color: #1e2d45 !important;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-2 px-md-4">

        {{-- ════ HERO HEADER BANNER ════ --}}
        <div class="page-header-card mb-3 mb-md-4">
            <div class="page-header-content">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title"><i class="fa-solid fa-chart-line me-2" style="color:#818cf8;"></i>Attendance Analytics & Daily Overview</h1>
                        <p class="mb-0 opacity-85">Real-time attendance monitoring, class-wise stats & trend insights</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('attendances.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-light btn-sm fw-bold shadow-sm px-3 py-2" style="border-radius:10px;">
                            <i class="fa-solid fa-clipboard-user me-1 text-indigo-600"></i> Take Attendance
                        </a>
                    </div>
                </div>

                {{-- Header Live Stats Bar (FORCE 2 COLUMNS ON MOBILE) --}}
                <div class="analytics-stats-bar">
                    {{-- Card 1: Total Students --}}
                    <div class="analytics-stat-card">
                        <div class="analytics-stat-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div>
                            <div class="analytics-stat-val">{{ number_format($totalStudents) }}</div>
                            <div class="analytics-stat-lbl">Total Students</div>
                            <div class="analytics-stat-sub"><i class="fa-solid fa-school me-1"></i>Active</div>
                        </div>
                    </div>

                    {{-- Card 2: Present --}}
                    <div class="analytics-stat-card">
                        <div class="analytics-stat-icon" style="background:rgba(34,197,94,0.3); color:#4ade80;"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <div class="analytics-stat-val">{{ number_format($presentCount) }}</div>
                            <div class="analytics-stat-lbl">Present ({{ $presentPercentage }}%)</div>
                            <div class="analytics-stat-sub"><i class="fa-regular fa-calendar me-1"></i>On {{ \Carbon\Carbon::parse($selectedDate)->format('d M') }}</div>
                        </div>
                    </div>

                    {{-- Card 3: Absent --}}
                    <div class="analytics-stat-card">
                        <div class="analytics-stat-icon" style="background:rgba(239,68,68,0.3); color:#f87171;"><i class="fa-solid fa-circle-xmark"></i></div>
                        <div>
                            <div class="analytics-stat-val">{{ number_format($absentCount) }}</div>
                            <div class="analytics-stat-lbl">Absent ({{ $absentPercentage }}%)</div>
                            <div class="analytics-stat-sub"><i class="fa-regular fa-calendar me-1"></i>On {{ \Carbon\Carbon::parse($selectedDate)->format('d M') }}</div>
                        </div>
                    </div>

                    {{-- Card 4: Submission Progress --}}
                    <div class="analytics-stat-card">
                        <div class="analytics-stat-icon" style="background:rgba(99,102,241,0.3); color:#a5b4fc;"><i class="fa-solid fa-list-check"></i></div>
                        <div>
                            <div class="analytics-stat-val">{{ $completedClassesCount }} / {{ $totalClassesCount }}</div>
                            <div class="analytics-stat-lbl">Classes Done</div>
                            <div class="analytics-stat-sub"><i class="fa-solid fa-clock-rotate-left me-1"></i>Submitted</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ FILTER BAR ════ --}}
        <div class="analytics-filter-card">
            <form method="GET" action="{{ route('attendance.analytics', ['tenant' => auth()->user()?->school?->slug]) }}" id="analyticsFilterForm">
                <div class="row g-2 align-items-end">
                    {{-- Date Filter --}}
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-bold text-secondary mb-1" style="font-size:0.73rem; text-transform:uppercase; letter-spacing:0.4px;">
                            <i class="fa-regular fa-calendar me-1 text-primary"></i>Select Date
                        </label>
                        <input type="date" name="date" class="form-control bg-light fw-semibold" value="{{ $selectedDate }}" onchange="this.form.submit()">
                    </div>

                    {{-- Class Filter --}}
                    <div class="col-6 col-md-3">
                        <label class="form-label fw-bold text-secondary mb-1" style="font-size:0.73rem; text-transform:uppercase; letter-spacing:0.4px;">
                            <i class="fa-solid fa-school me-1 text-indigo-500"></i>Class
                        </label>
                        <select name="class_id" class="form-select bg-light fw-semibold" onchange="this.form.submit()">
                            <option value="">All Classes</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ $classId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Section Filter --}}
                    <div class="col-6 col-md-3 analytics-filter-section-col">
                        <label class="form-label fw-bold text-secondary mb-1" style="font-size:0.73rem; text-transform:uppercase; letter-spacing:0.4px;">
                            <i class="fa-solid fa-layer-group me-1 text-purple-500"></i>Section
                        </label>
                        <select name="section_id" class="form-select bg-light fw-semibold" onchange="this.form.submit()">
                            <option value="">All Sections</option>
                            @foreach($sections as $s)
                                <option value="{{ $s->id }}" {{ $sectionId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quick Date Buttons --}}
                    <div class="col-6 col-md-3 analytics-filter-btn-col">
                        <div class="d-flex align-items-center gap-1 w-100 analytics-filter-btn-group">
                            <a href="{{ route('attendance.analytics', ['tenant' => auth()->user()?->school?->slug, 'date' => now()->toDateString()]) }}" 
                               class="btn btn-sm {{ $selectedDate == now()->toDateString() ? 'btn-primary' : 'btn-outline-secondary' }} fw-bold flex-fill py-2 text-center" 
                               style="border-radius:10px; font-size:0.8rem; height:42px; display:inline-flex; align-items:center; justify-content:center;">Today</a>
                            <a href="{{ route('attendance.analytics', ['tenant' => auth()->user()?->school?->slug, 'date' => now()->subDay()->toDateString()]) }}" 
                               class="btn btn-sm {{ $selectedDate == now()->subDay()->toDateString() ? 'btn-primary' : 'btn-outline-secondary' }} fw-bold flex-fill py-2 text-center" 
                               style="border-radius:10px; font-size:0.8rem; height:42px; display:inline-flex; align-items:center; justify-content:center;">Yesterday</a>
                            <a href="{{ route('attendance.analytics', ['tenant' => auth()->user()?->school?->slug]) }}" 
                               class="btn btn-sm btn-outline-secondary py-2 px-3 text-center" 
                               style="border-radius:10px; font-size:0.8rem; height:42px; display:inline-flex; align-items:center; justify-content:center;" title="Reset Filters"><i class="fa-solid fa-rotate-left"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ════ CHARTS SECTION ════ --}}
        <div class="row">
            {{-- 7-Day Trend Line Chart --}}
            <div class="col-lg-7 mb-4">
                <div class="chart-card h-100">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="fa-solid fa-chart-line text-indigo-600"></i> Attendance Rate Trend (Last 7 Days)
                        </h5>
                        <span class="border px-3 py-1 fw-bold" style="border-radius:10px; font-size:0.75rem;">
                            <i class="fa-regular fa-clock me-1"></i>Last 7 Days
                        </span>
                    </div>
                    <div class="chart-container-box">
                        <canvas id="attendanceTrendChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Doughnut Chart (Present vs Absent) --}}
            <div class="col-lg-5 mb-4">
                <div class="chart-card h-100">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="fa-solid fa-chart-pie text-emerald-600"></i> Present vs Absent Breakdown
                        </h5>
                        <span class="border px-2 py-1 fw-bold" style="border-radius:10px; font-size:0.7rem;">
                            <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($selectedDate)->format('d M, Y') }}
                        </span>
                    </div>
                    <div class="chart-container-box d-flex align-items-center justify-content-center">
                        <canvas id="attendanceDoughnutChart"></canvas>
                        <div class="doughnut-center-stat">
                            <div class="doughnut-center-val">{{ $presentPercentage }}%</div>
                            <div class="doughnut-center-lbl">Present Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ CLASS STATUS + STUDENT LOGS — SIDE BY SIDE ════ --}}
        <div class="row g-3 mb-4">

            {{-- ── LEFT: Class & Section Submission Status ── --}}
            <div class="col-12 col-lg-5">
                <div class="data-table-card h-100">
                    <div class="table-header d-flex align-items-center justify-content-between p-2 px-3 border-bottom">
                        <h5 class="table-title mb-0 fw-bold text-dark" style="font-size:0.85rem;">
                            <i class="fa-solid fa-school me-2 text-indigo-600"></i>Class &amp; Section Status
                        </h5>
                        <span class="badge bg-light text-muted border px-2 py-1" style="border-radius:8px; font-size:0.68rem;">
                            {{ count($classBreakdown) }} Classes
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table data-table mb-0 align-middle" style="font-size:0.75rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-2 px-2 text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Class / Section</th>
                                    <th class="py-2 px-2 text-center text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">P&nbsp;/&nbsp;A</th>
                                    <th class="py-2 px-2 text-center text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Rate</th>
                                    <th class="py-2 px-2 text-center text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classBreakdown as $row)
                                <tr>
                                    <td class="px-2 py-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <div style="width:24px;height:24px;border-radius:7px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.65rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ substr($row['class_name'], 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block" style="font-size:0.75rem; line-height:1.2;">{{ $row['class_name'] }}</span>
                                                <small class="text-muted" style="font-size:0.63rem;">{{ $row['section_name'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center px-2 py-2">
                                        <span class="fw-bold text-success" style="font-size:0.73rem;">{{ $row['present'] }}</span>
                                        <span class="text-muted" style="font-size:0.65rem;">/</span>
                                        <span class="fw-bold text-danger" style="font-size:0.73rem;">{{ $row['absent'] }}</span>
                                    </td>
                                    <td class="text-center px-2 py-2">
                                        <span class="fw-bold text-dark" style="font-size:0.73rem;">{{ $row['rate'] }}%</span>
                                    </td>
                                    <td class="text-center px-2 py-2">
                                        @if($row['is_completed'])
                                            <span class="badge-completed" style="font-size:0.62rem; padding:2px 7px;"><span class="pulse-dot pulse-dot-green"></span> Done</span>
                                        @else
                                            <span class="badge-pending" style="font-size:0.62rem; padding:2px 7px;"><span class="pulse-dot pulse-dot-amber"></span> Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted" style="font-size:0.78rem;">
                                        No classes found for selected filters.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Student Attendance Logs ── --}}
            <div class="col-12 col-lg-7">
                <div class="data-table-card h-100 d-flex flex-column">

                    {{-- Header --}}
                    <div class="p-2 px-3 border-bottom">
                        <div class="row g-1 align-items-center">
                            <div class="col-12 col-sm-5">
                                <h5 class="table-title mb-0 fw-bold text-dark" style="font-size:0.85rem;">
                                    <i class="fa-solid fa-list-ul me-2 text-indigo-600"></i>Student Attendance Logs
                                </h5>
                                <small class="text-muted" style="font-size:0.68rem;">{{ \Carbon\Carbon::parse($selectedDate)->format('d M, Y') }}</small>
                            </div>
                            <div class="col-12 col-sm-7">
                                <form method="GET" action="{{ route('attendance.analytics', ['tenant' => auth()->user()?->school?->slug]) }}">
                                    <input type="hidden" name="date" value="{{ $selectedDate }}">
                                    <input type="hidden" name="class_id" value="{{ $classId }}">
                                    <input type="hidden" name="section_id" value="{{ $sectionId }}">
                                    <div class="d-flex gap-1" style="height:32px;">
                                        <select name="status" class="form-select form-select-sm bg-light" style="width:110px; flex-shrink:0; border-radius:8px; border:1.5px solid #cbd5e1; font-size:0.75rem; height:32px; padding:0 8px;" onchange="this.form.submit()">
                                            <option value="">All Statuses</option>
                                            <option value="present" {{ $statusFilter == 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="absent" {{ $statusFilter == 'absent' ? 'selected' : '' }}>Absent</option>
                                        </select>
                                        <div class="input-group flex-grow-1" style="height:32px; flex-wrap:nowrap;">
                                            <input type="text" name="search" class="form-control bg-light" placeholder="Search name/roll..." value="{{ $search }}" style="border-radius:8px 0 0 8px; border:1.5px solid #cbd5e1; border-right:0; font-size:0.75rem; height:32px; line-height:1; box-shadow:none;">
                                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="border-radius:0 8px 8px 0; height:32px; width:36px; padding:0; flex-shrink:0; line-height:1;"><i class="fa-solid fa-magnifying-glass" style="font-size:0.7rem;"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive flex-grow-1">
                        <table class="table data-table mb-0 align-middle" style="font-size:0.75rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-2 px-2 text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Student</th>
                                    <th class="py-2 px-2 text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">ID &amp; Roll</th>
                                    <th class="py-2 px-2 text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Class</th>
                                    <th class="py-2 px-2 text-center text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">Status</th>
                                    <th class="py-2 px-2 text-secondary" style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentLogs as $log)
                                <tr>
                                    <td class="px-2 py-2">
                                        <div class="d-flex align-items-center gap-1">
                                            <div style="width:24px;height:24px;border-radius:7px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-weight:700;font-size:0.65rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ strtoupper(substr($log->student?->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size:0.75rem; white-space:nowrap;">{{ $log->student?->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2">
                                        <span class="fw-bold text-dark d-block" style="font-size:0.73rem;">{{ $log->student?->student_id ?? 'N/A' }}</span>
                                        <small class="text-muted" style="font-size:0.63rem;">Roll: {{ $log->student?->roll ?? 'N/A' }}</small>
                                    </td>
                                    <td class="px-2 py-2">
                                        <span class="text-secondary" style="font-size:0.73rem; white-space:nowrap;">{{ $log->class?->name ?? 'N/A' }} ({{ $log->section?->name ?? 'N/A' }})</span>
                                    </td>
                                    <td class="text-center px-2 py-2">
                                        @if($log->status == 'present')
                                            <span class="badge-status-present" style="font-size:0.62rem; padding:2px 7px;"><span class="pulse-dot pulse-dot-green"></span> Present</span>
                                        @else
                                            <span class="badge-status-absent" style="font-size:0.62rem; padding:2px 7px;"><span class="pulse-dot pulse-dot-red"></span> Absent</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2">
                                        <span class="fw-semibold text-dark d-block" style="font-size:0.72rem; white-space:nowrap;">{{ $log->teacher?->name ?? 'System' }}</span>
                                        <small class="text-muted" style="font-size:0.63rem;">{{ $log->created_at ? $log->created_at->format('h:i A') : 'N/A' }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 empty-state-td">
                                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;text-align:center;">
                                            <i class="fa-solid fa-folder-open fa-lg text-muted"></i>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1" style="font-size:0.82rem;">No Attendance Logs Found</h6>
                                                <p class="text-muted mb-0" style="font-size:0.75rem;">Select a date with submitted attendance or adjust filters.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($studentLogs->hasPages())
                        <div class="p-2 px-3 border-top">
                            {{ $studentLogs->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- /row --}}

    </div>
</div>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Trend Line Chart with Gradient Fill
        const trendLabels = {!! json_encode(array_column($trendData, 'date')) !!};
        const trendRates  = {!! json_encode(array_column($trendData, 'rate')) !!};

        const ctxTrend = document.getElementById('attendanceTrendChart').getContext('2d');
        
        // Create Gradient Fill for Line Chart
        const gradientLine = ctxTrend.createLinearGradient(0, 0, 0, 240);
        gradientLine.addColorStop(0, 'rgba(79, 70, 229, 0.35)');
        gradientLine.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Attendance Rate (%)',
                    data: trendRates,
                    borderColor: '#4f46e5',
                    backgroundColor: gradientLine,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { weight: 'bold', size: 13 },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) { return 'Attendance Rate: ' + context.raw + '%'; }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { weight: 'bold', size: 11 },
                            callback: function(val) { return val + '%'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold', size: 11 } }
                    }
                }
            }
        });

        // 2. Doughnut Chart (Present vs Absent)
        const ctxDoughnut = document.getElementById('attendanceDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{
                    data: [{{ $presentCount }}, {{ $absentCount }}],
                    backgroundColor: ['#10b981', '#f43f5e'],
                    hoverBackgroundColor: ['#059669', '#e11d48'],
                    borderWidth: 0,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { weight: 'bold', size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        cornerRadius: 10,
                        padding: 10
                    }
                },
                cutout: '76%'
            }
        });
    });
</script>
@endsection
