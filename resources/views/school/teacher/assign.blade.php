@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Responsive Header Card & Custom Header Buttons */
        .page-header-card {
            padding: 28px 32px;
            border-radius: 20px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
            position: relative;
            overflow: hidden;
        }
        .page-header-card .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
        }
        .page-header-card .page-subtitle {
            font-size: 0.92rem;
            color: rgba(248, 250, 252, 0.85);
            max-width: 650px;
        }

        /* Dedicated Header Button Styling */
        .header-actions-group {
            margin-left: auto;
        }
        .edu-header-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
            padding: 7px 14px !important;
            border-radius: 9px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            width: auto !important;
            height: auto !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            text-decoration: none !important;
            line-height: 1.3 !important;
        }
        .edu-header-btn-white {
            background: #ffffff !important;
            color: #4f46e5 !important;
            border: 1px solid #ffffff !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12) !important;
        }
        .edu-header-btn-white:hover {
            background: #f8fafc !important;
            color: #3730a3 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18) !important;
        }
        .edu-header-btn-outline {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            backdrop-filter: blur(4px) !important;
        }
        .edu-header-btn-outline:hover {
            background: rgba(255, 255, 255, 0.22) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.6) !important;
            transform: translateY(-2px) !important;
        }

        /* Filter Toolbar Card */
        .filter-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: var(--card-shadow);
        }
        [data-bs-theme="dark"] .filter-card,
        body.dark-mode .filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        .search-icon-group {
            position: relative;
        }
        .search-icon-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .search-icon-group input {
            padding-left: 38px;
        }

        /* Class-wise Assign Cards Styling */
        .class-assign-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .class-assign-card:hover {
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        }
        [data-bs-theme="dark"] .class-assign-card,
        body.dark-mode .class-assign-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }

        /* Class Card Header */
        .class-card-header {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        [data-bs-theme="dark"] .class-card-header,
        body.dark-mode .class-card-header {
            background: linear-gradient(to right, #111c35, #0c1427) !important;
            border-bottom-color: #1a253b !important;
        }
        .class-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .class-icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
            flex-shrink: 0;
        }
        .class-name-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.2px;
        }
        [data-bs-theme="dark"] .class-name-title,
        body.dark-mode .class-name-title {
            color: #f8fafc !important;
        }
        .class-category-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 6px;
            background: #e0e7ff;
            color: #4338ca;
        }
        [data-bs-theme="dark"] .class-category-badge,
        body.dark-mode .class-category-badge {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }
        .class-meta-subtext {
            font-size: 0.75rem;
            color: #64748b;
        }
        [data-bs-theme="dark"] .class-meta-subtext,
        body.dark-mode .class-meta-subtext {
            color: #94a3b8;
        }
        .class-header-stats {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .stat-badge-primary {
            background: rgba(79, 70, 229, 0.1) !important;
            color: #4f46e5 !important;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        .stat-badge-success {
            background: rgba(16, 185, 129, 0.1) !important;
            color: #059669 !important;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Desktop Table View */
        .class-subject-table {
            margin-bottom: 0;
        }
        .class-subject-table thead th {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            background: #f8fafc;
            padding: 10px 16px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }
        [data-bs-theme="dark"] .class-subject-table thead th,
        body.dark-mode .class-subject-table thead th {
            background: #0e172c !important;
            color: #94a3b8 !important;
            border-bottom-color: #1a253b !important;
        }
        .class-subject-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        [data-bs-theme="dark"] .class-subject-table tbody td,
        body.dark-mode .class-subject-table tbody td {
            border-bottom-color: #162035 !important;
        }
        .class-subject-table tbody tr:last-child td {
            border-bottom: none;
        }
        .class-subject-table tbody tr:hover {
            background-color: #f8fafc;
        }
        [data-bs-theme="dark"] .class-subject-table tbody tr:hover,
        body.dark-mode .class-subject-table tbody tr:hover {
            background-color: #131e36 !important;
        }

        .subject-tile-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .subject-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }
        [data-bs-theme="dark"] .subject-title,
        body.dark-mode .subject-title {
            color: #f1f5f9 !important;
        }
        .subject-code-tag {
            font-size: 0.72rem;
            color: #94a3b8;
        }
        .badge-section-custom {
            background: rgba(6, 182, 212, 0.1) !important;
            color: #0891b2 !important;
            font-size: 0.78rem;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        .badge-section-all {
            background: rgba(100, 116, 139, 0.1) !important;
            color: #475569 !important;
            font-size: 0.76rem;
            padding: 4px 8px;
            border-radius: 6px;
        }
        [data-bs-theme="dark"] .badge-section-all,
        body.dark-mode .badge-section-all {
            color: #94a3b8 !important;
        }

        .teacher-avatar-photo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e2e8f0;
            flex-shrink: 0;
        }
        .teacher-avatar-initials {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .teacher-title {
            font-size: 0.88rem;
            color: #1e293b;
        }
        [data-bs-theme="dark"] .teacher-title,
        body.dark-mode .teacher-title {
            color: #f1f5f9 !important;
        }
        .teacher-subtitle {
            font-size: 0.75rem;
            color: #64748b;
        }
        [data-bs-theme="dark"] .teacher-subtitle,
        body.dark-mode .teacher-subtitle {
            color: #94a3b8 !important;
        }

        .btn-icon-sm {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-soft-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        .btn-soft-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }


        /* Empty State */
        .class-assign-empty-state {
            background: #ffffff;
            border: 2px dashed #cbd5e1;
            border-radius: 18px;
            padding: 48px 24px;
            text-align: center;
        }
        [data-bs-theme="dark"] .class-assign-empty-state,
        body.dark-mode .class-assign-empty-state {
            background: #0c1427 !important;
            border-color: #1e293b !important;
        }
        .empty-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }
        .empty-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }
        [data-bs-theme="dark"] .empty-title,
        body.dark-mode .empty-title {
            color: #f8fafc !important;
        }
        .empty-desc {
            font-size: 0.88rem;
            color: #64748b;
            max-width: 440px;
            margin: 0 auto;
        }
        [data-bs-theme="dark"] .empty-desc,
        body.dark-mode .empty-desc {
            color: #94a3b8 !important;
        }

        /* Loading Spinner Overlay */
        .table-loading-overlay {
            position: relative;
            min-height: 200px;
        }
        .table-loading-overlay::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: 5;
            border-radius: 16px;
        }
        [data-bs-theme="dark"] .table-loading-overlay::before,
        body.dark-mode .table-loading-overlay::before {
            background: rgba(12, 20, 39, 0.7);
        }
        .table-loading-overlay::after {
            content: '\f110';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: #4f46e5;
            z-index: 6;
            animation: spin 1s infinite linear;
        }
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Responsive Breakpoints (Desktop vs Mobile) */
        @media (max-width: 768px) {
            .page-header-card {
                padding: 20px 16px !important;
                border-radius: 16px !important;
                margin-bottom: 20px !important;
            }
            .page-header-card .page-title {
                font-size: 1.35rem !important;
                margin-bottom: 6px !important;
            }
            .page-header-card .page-subtitle {
                font-size: 0.85rem !important;
                line-height: 1.4 !important;
            }
            .header-actions-group {
                width: 100% !important;
                margin-top: 12px !important;
                display: flex !important;
                flex-direction: row !important;
                gap: 8px !important;
            }
            .header-actions-group .edu-header-btn {
                flex: 1 1 0px !important;
                padding: 9px 10px !important;
                font-size: 0.8rem !important;
                text-align: center !important;
            }

            /* Hide Desktop Table on Mobile */
            .class-desktop-view {
                display: none !important;
            }
            /* Show Mobile Cards View */
            .class-mobile-view {
                display: block !important;
            }
            .class-card-header {
                padding: 12px 14px;
            }
            .class-header-stats {
                width: 100%;
                justify-content: flex-start;
                margin-top: 4px;
            }
            .mobile-subjects-list {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 12px;
            }
            .mobile-subject-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 12px;
                transition: all 0.2s ease;
            }
            [data-bs-theme="dark"] .mobile-subject-card,
            body.dark-mode .mobile-subject-card {
                background: #111c35 !important;
                border-color: #1e2c4a !important;
            }
            .mobile-subject-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
            }
            .mobile-subject-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px dashed #e2e8f0;
            }
            [data-bs-theme="dark"] .mobile-subject-footer,
            body.dark-mode .mobile-subject-footer {
                border-top-color: #1e2c4a !important;
            }
            .subject-tile-icon-sm {
                width: 30px;
                height: 30px;
                border-radius: 7px;
                background: rgba(79, 70, 229, 0.1);
                color: #4f46e5;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.78rem;
                flex-shrink: 0;
            }
            .teacher-avatar-photo-sm {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                object-fit: cover;
                flex-shrink: 0;
            }
            .teacher-avatar-initials-sm {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: linear-gradient(135deg, #0ea5e9, #6366f1);
                color: #ffffff;
                font-size: 0.75rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .mobile-sub-name {
                font-size: 0.88rem;
                color: #1e293b;
            }
            [data-bs-theme="dark"] .mobile-sub-name,
            body.dark-mode .mobile-sub-name {
                color: #f1f5f9 !important;
            }
            .mobile-teacher-name {
                font-size: 0.82rem;
                color: #1e293b;
            }
            [data-bs-theme="dark"] .mobile-teacher-name,
            body.dark-mode .mobile-teacher-name {
                color: #f1f5f9 !important;
            }
            .mobile-teacher-des {
                font-size: 0.72rem;
                color: #64748b;
            }
        }

        @media (min-width: 769px) {
            .class-mobile-view {
                display: none !important;
            }
            .class-desktop-view {
                display: block !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid p-0">
            
            {{-- Modern Header Banner --}}
            <div class="page-header-card mb-4">
                <div class="page-header-content d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="header-text-group">
                        <h1 class="page-title d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Assign Subject to Teacher</span>
                        </h1>
                        <p class="page-subtitle mb-0">
                            Allocate subjects and class sections to faculty members organized by class curriculum.
                        </p>
                    </div>
                    <div class="header-actions-group d-flex align-items-center flex-row gap-2">
                        <a href="{{ route('teachers.index', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" 
                           class="edu-header-btn edu-header-btn-white">
                            <i class="fa-solid fa-users text-primary"></i> <span>Faculty Directory</span>
                        </a>
                        <a href="{{ route('subjects.index', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" 
                           class="edu-header-btn edu-header-btn-outline">
                            <i class="fa-solid fa-book"></i> <span>Subjects List</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stat Cards Row --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="edu-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stat-label">Total Assignments</div>
                                <div class="stat-value text-primary">{{ $totalAssignments ?? ($groupedAssignments->flatten()->count()) }}</div>
                            </div>
                            <div class="icon-wrap bg-soft-primary text-primary">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="edu-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stat-label">Assigned Teachers</div>
                                <div class="stat-value text-success">{{ $assignedTeachersCount ?? 0 }}</div>
                            </div>
                            <div class="icon-wrap bg-soft-success text-success">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="edu-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stat-label">Total Classes</div>
                                <div class="stat-value text-info">{{ $classes->count() }}</div>
                            </div>
                            <div class="icon-wrap bg-soft-info text-info">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="edu-stat-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stat-label">Total Subjects</div>
                                <div class="stat-value text-warning">{{ $subjects->count() }}</div>
                            </div>
                            <div class="icon-wrap bg-soft-warning text-warning">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Form & Table Content Row --}}
            <div class="row g-4">
                
                {{-- Form Card --}}
                <div class="col-lg-4">
                    <div class="form-card sticky-top" style="top: 90px;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <div class="icon-wrap bg-soft-primary text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-plus-circle fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 fs-6">New Assignment</h5>
                                <span class="text-muted small" style="font-size: 0.78rem;">Select parameters to allocate subject</span>
                            </div>
                        </div>

                        <form action="{{ route('teacher.assign.store', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" method="POST">
                            @csrf
                            
                            {{-- Teacher --}}
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-user-tie text-primary"></i> Teacher <span class="text-danger">*</span>
                                </label>
                                <select id="teacher_id" name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" required>
                                    <option value="">-- Select Teacher --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} @if(!empty($teacher->designation)) ({{ $teacher->designation }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Class --}}
                            <div class="mb-3">
                                <label for="class_id" class="form-label d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-graduation-cap text-info"></i> Class <span class="text-danger">*</span>
                                </label>
                                <select id="class_id" name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Section --}}
                            <div class="mb-3">
                                <label for="section_id" class="form-label d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-layer-group text-warning"></i> Section <span class="text-danger">*</span>
                                </label>
                                <select id="section_id" name="section_id" class="form-select @error('section_id') is-invalid @enderror" required>
                                    <option value="">-- Select Section --</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Subject --}}
                            <div class="mb-4">
                                <label for="subject_id" class="form-label d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-book-open text-success"></i> Subject <span class="text-danger">*</span>
                                </label>
                                <select id="subject_id" name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                    <option value="">-- Select Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" class="text-capitalize" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->code ? $subject->code . ' - ' : '' }}{{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary-gradient w-100 py-1.5 shadow-sm fw-bold" style="font-size: 0.84rem; border-radius: 8px;">
                                <i class="fa-solid fa-check-circle me-1"></i> Assign Subject
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Table & Filter Column --}}
                <div class="col-lg-8">
                    
                    {{-- Filter Card Toolbar --}}
                    <div class="filter-card mb-3">
                        <form id="filterForm" onsubmit="return false;">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <div class="search-icon-group">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Search by teacher, subject, class..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <select name="class_id" id="filter_class_id" class="form-select form-select-sm">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <select name="section_id" id="filter_section_id" class="form-select form-select-sm">
                                        <option value="">All Sections</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-1 text-end">
                                    <button type="button" id="resetFiltersBtn" class="btn btn-outline-secondary btn-sm w-100" data-bs-toggle="tooltip" title="Reset Filters">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Class-wise Cards Container Wrapper --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-layer-group text-primary"></i> Class-wise Subject Allocation
                        </h6>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-1 fw-bold" style="font-size: 0.78rem;">
                            {{ $totalAssignmentsCount ?? ($groupedAssignments->count() ? $groupedAssignments->flatten()->count() : 0) }} Total Allocations
                        </span>
                    </div>

                    <div id="assignTable">
                        @include('school.teacher.partials.assign-table')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this subject assignment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: '{{ session('type') == 'warning' ? 'Notice' : 'Success!' }}',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        let searchTimer;
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                loadAssignments();
            }, 350);
        });

        $('#filterForm select').on('change', function() {
            loadAssignments();
        });

        $('#resetFiltersBtn').on('click', function() {
            $('#filterForm')[0].reset();
            loadAssignments();
        });

        function loadAssignments(url = null) {
            let query = $('#filterForm').serialize();
            let tableContainer = $('#assignTable');

            tableContainer.addClass('table-loading-overlay');

            if (!url) {
                url = "{{ route('teacher.assign', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}?" + query;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data){
                    tableContainer.html(data);
                    // Re-initialize tooltips if needed
                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                },
                error: function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load assignments. Please try again.',
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                },
                complete: function(){
                    tableContainer.removeClass('table-loading-overlay');
                }
            });
        }
    </script>
@endsection