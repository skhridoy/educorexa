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
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25);
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
            background: rgba(99, 102, 241, 0.1) !important;
            color: #4f46e5 !important;
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
            background: rgba(99, 102, 241, 0.08);
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
        .badge-subcategory {
            background: rgba(99, 102, 241, 0.1) !important;
            color: #4f46e5 !important;
            font-size: 0.78rem;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        .badge-subcategory-none {
            background: rgba(100, 116, 139, 0.08) !important;
            color: #64748b !important;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
        }
        [data-bs-theme="dark"] .badge-subcategory-none,
        body.dark-mode .badge-subcategory-none {
            color: #94a3b8 !important;
        }

        .mark-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
        }
        .full-mark-pill {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .pass-mark-pill {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .btn-action-icon {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            transition: all 0.2s ease;
            border: none;
        }
        .btn-action-icon-sm {
            width: 22px;
            height: 22px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            border: none;
        }
        .btn-soft-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        .btn-soft-warning:hover {
            background: #f59e0b;
            color: #ffffff;
        }
        .btn-soft-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        .btn-soft-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }
        .btn-primary-gradient {
            padding: 7px 16px !important;
            font-size: 0.84rem !important;
            border-radius: 8px !important;
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
            background: rgba(99, 102, 241, 0.08);
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
                background: rgba(99, 102, 241, 0.1);
                color: #4f46e5;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.78rem;
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
            .btn-action-icon-sm {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0.75rem;
                border: none;
            }
            .mark-pill-sm {
                font-size: 0.72rem;
                padding: 3px 8px;
                border-radius: 6px;
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
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="page-header-card mb-4">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="fa-solid fa-layer-group me-2"></i> Assign Subjects to Classes</h1>
                    <p class="page-subtitle">Map curriculum subjects to classes, set pass & full marks, and configure subcategories.</p>
                </div>
            </div>

            <div class="row g-4">
                {{-- Form Column --}}
                <div class="col-lg-4">
                    <div class="form-card sticky-top" style="top: 90px;">
                        <h5 class="mb-4 fw-bold text-primary"><i class="fa-solid fa-paper-plane me-2"></i> Assign Subject</h5>
                        <form id="assignSubjectForm" action="{{ route('subjects.assign.store', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="class_id" class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" data-category-id="{{ $class->school_category_id }}" data-category-name="{{ $class->category?->name }}">
                                            {{ $class->name }} @if($class->category) ({{ $class->category->name }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_display" class="form-label fw-semibold">Category</label>
                                <input type="text" id="category_display" class="form-control" readonly placeholder="Category will show based on class">
                                <input type="hidden" name="school_category_id" id="school_category_id">
                            </div>

                            <div class="mb-3">
                                <label for="school_sub_category_id" class="form-label fw-semibold">Sub Category</label>
                                <select id="school_sub_category_id" name="school_sub_category_id" class="form-select" disabled>
                                    <option value="">Select Class First</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="subject_id" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                <select id="subject_id" name="subject_id" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="full_mark" class="form-label fw-semibold">Full Mark <span class="text-danger">*</span></label>
                                <input type="number" id="full_mark" name="full_mark" class="form-control" placeholder="e.g. 100" required>
                            </div>

                            <div class="mb-3">
                                <label for="pass_mark" class="form-label fw-semibold">Pass Marks <span class="text-danger">*</span></label>
                                <input type="number" id="pass_mark" name="pass_mark" class="form-control" placeholder="e.g. 33" required>
                            </div>

                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-1.5 px-3 fw-bold" style="font-size: 0.84rem; border-radius: 8px;">
                                    <i class="fa-solid fa-check me-1"></i> Assign Subject
                                </button>
                                <a href="{{ route('subjects.index', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" class="btn btn-outline-secondary py-1.5 px-3" style="font-size: 0.84rem; border-radius: 8px;">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Class Cards Column --}}
                <div class="col-lg-8">
                    {{-- Filter Card Toolbar --}}
                    <div class="filter-card mb-3">
                        <form id="filterForm" onsubmit="return false;">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <div class="search-icon-group">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Search by class or subject..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-8 col-md-5">
                                    <select id="filterClassId" name="class_id" class="form-select form-select-sm">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 col-md-1 text-end">
                                    <button type="button" id="resetFiltersBtn" class="btn btn-outline-secondary btn-sm w-100" data-bs-toggle="tooltip" title="Reset Filters">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Class-wise Cards Header --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-layer-group text-primary"></i> Class-wise Subject Mapping
                        </h6>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-1 fw-bold" style="font-size: 0.78rem;">
                            {{ $totalAssignmentsCount ?? ($groupedAssignments->count() ? $groupedAssignments->flatten()->count() : 0) }} Total Mappings
                        </span>
                    </div>

                    <div id="assignTable">
                        @include('school.subject.partials.assign-table')
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
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#4f46e5',
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: '{{ session('type') == 'warning' ? 'Notice' : 'Success!' }}',
                text: '{{ session('success') }}',
                timer: 2000,
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

        $('#filterClassId').on('change', function() {
            loadAssignments();
        });

        $('#resetFiltersBtn').on('click', function() {
            $('#filterForm')[0].reset();
            loadAssignments();
        });

        $('#class_id').on('change', function() {
            const classId = $(this).val();
            const categoryId = $(this).find(':selected').data('category-id');
            const categoryName = $(this).find(':selected').data('category-name') || '';
            $('#school_category_id').val(categoryId);
            $('#category_display').val(categoryName ? categoryName : 'No category');
            
            $('#school_sub_category_id').empty().append('<option value="">Select Sub Category</option>').prop('disabled', true);

            if (!classId) {
                $('#category_display').val('');
                return;
            }

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get.subcategories', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'categoryId' => 'CATEGORY_ID']) }}".replace('CATEGORY_ID', categoryId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#school_sub_category_id').prop('disabled', false);
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                $('#school_sub_category_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        } else {
                            $('#school_sub_category_id').append('<option value="">No subcategories found</option>');
                        }
                    }
                });
            }
        });

        $('#assignSubjectForm').on('submit', function(e) {
            e.preventDefault();
            $('#school_sub_category_id').prop('disabled', false);
            const form = $(this);
            const action = form.attr('action');
            const data = form.serialize();

            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Assigned!',
                        text: response.message || 'Subject assigned successfully',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    form[0].reset();
                    $('#school_sub_category_id').empty().append('<option value="">Select Class First</option>').prop('disabled', true);
                    $('#category_display').val('');
                    loadAssignments();
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const message = Object.values(errors).flat()[0];
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation failed',
                            text: message,
                        });
                        return;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Unable to assign subject. Please try again.',
                    });
                }
            });
        });

        function loadAssignments(url = null) {
            const tableContainer = $('#assignTable');
            tableContainer.addClass('table-loading-overlay');

            if (!url) {
                url = "{{ route('subjects.assign', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}";
            }
            const query = $('#filterForm').serialize();
            if (query) {
                url += (url.includes('?') ? '&' : '?') + query;
            }
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    tableContainer.html(data);
                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                },
                complete: function() {
                    tableContainer.removeClass('table-loading-overlay');
                }
            });
        }
    </script>
@endsection