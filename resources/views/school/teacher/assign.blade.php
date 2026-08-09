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
            gap: 6px !important;
            padding: 10px 18px !important;
            border-radius: 12px !important;
            font-size: 0.88rem !important;
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

            /* Mobile Cards Responsive Override */
            .assign-desktop-table {
                display: none !important;
            }
            .assign-mobile-cards {
                display: flex !important;
                flex-direction: column !important;
                gap: 12px !important;
                padding: 12px 14px !important;
            }
            .assign-mobile-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 16px;
                box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
                transition: all 0.2s ease;
                position: relative;
            }
            [data-bs-theme="dark"] .assign-mobile-card,
            body.dark-mode .assign-mobile-card {
                background: #0c1427 !important;
                border-color: #1a253b !important;
            }
            .assign-mobile-card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }
            .assign-mobile-card-body {
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px dashed #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
            }
            [data-bs-theme="dark"] .assign-mobile-card-body,
            body.dark-mode .assign-mobile-card-body {
                border-top-color: #1a253b !important;
            }
        }

        @media (min-width: 769px) {
            .assign-mobile-cards {
                display: none !important;
            }
        }

        .pagination {
            --bs-pagination-border-radius: 50% !important;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
        }
        .pagination .page-item .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .bg-soft-info {
            background-color: rgba(6, 182, 212, 0.1) !important;
            color: #0891b2 !important;
        }
        .bg-soft-secondary {
            background-color: rgba(100, 116, 139, 0.1) !important;
            color: #475569 !important;
        }
        .bg-soft-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
        }
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
                            Allocate subjects and class sections to faculty members efficiently.
                        </p>
                    </div>
                    <div class="header-actions-group d-flex align-items-center flex-row gap-2">
                        <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" 
                           class="edu-header-btn edu-header-btn-white">
                            <i class="fa-solid fa-users text-primary"></i> <span>Faculty Directory</span>
                        </a>
                        <a href="{{ route('subjects.index', ['tenant' => auth()->user()?->school?->slug]) }}" 
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
                                <div class="stat-value text-primary">{{ $totalAssignments ?? $assignments->total() }}</div>
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
                                <div class="stat-label">Total Faculty</div>
                                <div class="stat-value text-info">{{ $teachers->count() }}</div>
                            </div>
                            <div class="icon-wrap bg-soft-info text-info">
                                <i class="fa-solid fa-users"></i>
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

                        <form action="{{ route('teacher.assign.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
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
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary-gradient w-100 py-2.5 shadow-sm">
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

                    {{-- Data Table Card --}}
                    <div class="schools-panel white-panel">
                        <div class="panel-header d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
                            <h5 class="panel-title d-flex align-items-center gap-2 mb-0">
                                <i class="fa-solid fa-list-check text-primary"></i> Assigned Teachers & Subjects
                            </h5>
                            <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.8rem;">
                                Active Records: {{ $assignments->total() }}
                            </span>
                        </div>
                        <div id="assignTable">
                            @include('school.teacher.partials.assign-table')
                        </div>
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

        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            let url = $(this).attr('href');
            if(url && url !== '#') {
                loadAssignments(url);
            }
        });

        function loadAssignments(url = null) {
            let query = $('#filterForm').serialize();
            let tableContainer = $('#assignTable');

            tableContainer.addClass('table-loading-overlay');

            if (!url) {
                url = "{{ route('teacher.assign', ['tenant' => auth()->user()?->school?->slug]) }}?" + query;
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