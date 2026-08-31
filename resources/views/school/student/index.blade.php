@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Modal Dropzone */
        .modal-dropzone {
            border: 2px dashed #818cf8;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            user-select: none;
        }
        .modal-dropzone:hover, .modal-dropzone.dz-over {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);
            box-shadow: 0 6px 20px rgba(79,70,229,0.12);
        }
        .modal-dropzone.dz-selected {
            border-color: #4f46e5;
            border-style: solid;
            background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);
        }
        .modal-dz-icon {
            width: 50px; height: 50px;
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #fff;
            margin: 0 auto 10px;
            box-shadow: 0 4px 12px rgba(79,70,229,0.25);
            transition: transform 0.2s ease;
        }
        .modal-dropzone:hover .modal-dz-icon { transform: translateY(-3px); }
        .modal-dz-title { font-weight: 700; font-size: 14.5px; color: #3730a3; margin-bottom: 3px; }
        .modal-dz-sub   { font-size: 12px; color: #64748b; margin: 0; }
        [data-bs-theme="dark"] .modal-dropzone,
        body.dark-mode .modal-dropzone {
            background: rgba(79,70,229,0.08) !important;
            border-color: rgba(129,140,248,0.25) !important;
        }

        /* Clean Compact Action Buttons (Matching Button Design) */
        .btn-icon-sm {
            width: 30px !important;
            height: 30px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 5px !important;
            font-size: 0.76rem !important;
            transition: all 0.2s ease !important;
            border: 1px solid transparent !important;
            background: transparent !important;
            cursor: pointer;
        }
        .btn-icon-sm.btn-soft-primary {
            border-color: rgba(79, 70, 229, 0.25) !important;
            color: #4f46e5 !important;
        }
        .btn-icon-sm.btn-soft-primary:hover {
            background: rgba(79, 70, 229, 0.08) !important;
            border-color: #4f46e5 !important;
            color: #4338ca !important;
        }
        .btn-icon-sm.btn-soft-warning {
            border-color: rgba(217, 119, 6, 0.25) !important;
            color: #d97706 !important;
        }
        .btn-icon-sm.btn-soft-warning:hover {
            background: rgba(245, 158, 11, 0.08) !important;
            border-color: #d97706 !important;
            color: #b45309 !important;
        }
        .btn-icon-sm.btn-soft-danger {
            border-color: rgba(239, 68, 68, 0.25) !important;
            color: #ef4444 !important;
        }
        .btn-icon-sm.btn-soft-danger:hover {
            background: rgba(239, 68, 68, 0.08) !important;
            border-color: #ef4444 !important;
            color: #dc2626 !important;
        }

        /* Mobile Responsive Student Card Styling */
        .student-mobile-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 2px 10px rgba(15,23,42,0.03);
            transition: all 0.2s ease;
        }
        .student-mobile-card:hover {
            box-shadow: 0 4px 16px rgba(15,23,42,0.06);
        }
        [data-bs-theme="dark"] .student-mobile-card,
        body.dark-mode .student-mobile-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: none;
        }
        .student-avatar-ring {
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 1.5px solid #6366f1 !important;
            box-shadow: 0 1px 4px rgba(99, 102, 241, 0.15);
            flex-shrink: 0;
        }
        .student-id-badge {
            background: rgba(79, 70, 229, 0.07) !important;
            color: #4f46e5 !important;
            font-weight: 700 !important;
            font-size: 0.72rem !important;
            padding: 2px 8px !important;
            border-radius: 4px !important;
            display: inline-block;
            border: 1px solid rgba(79, 70, 229, 0.15);
        }
        [data-bs-theme="dark"] .student-id-badge,
        body.dark-mode .student-id-badge {
            background: rgba(79, 70, 229, 0.18) !important;
            color: #a5b4fc !important;
            border-color: rgba(99, 102, 241, 0.3) !important;
        }

        /* Structured Mobile Info Box */
        .student-info-box {
            background: rgba(248, 250, 252, 0.95);
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }
        [data-bs-theme="dark"] .student-info-box,
        body.dark-mode .student-info-box {
            background: #09101f !important;
            border-color: #1a253b !important;
        }
        .student-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 3px 0;
            min-width: 0;
        }
        .student-info-row:not(:last-child) {
            margin-bottom: 8px;
        }
        .student-info-label {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .student-info-icon {
            width: 18px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .student-info-value {
            font-size: 12.5px;
            text-align: right;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }

        .clear-search-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            font-size: 14px;
            z-index: 5;
        }
        .clear-search-btn:hover { color: #ef4444; }
        .search-input-wrapper { position: relative; }

        /* Header Action Buttons (Border-Only 5px radius Style) */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-header-outline {
            background: transparent !important;
            color: #ffffff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            height: 32px !important;
            padding: 0 12px !important;
            border-radius: 5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            box-shadow: none !important;
            cursor: pointer;
        }
        .btn-header-outline:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
            box-shadow: none !important;
            transform: none !important;
        }
        .btn-header-solid {
            background: transparent !important;
            color: #ffffff !important;
            border: 1.5px solid #818cf8 !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            height: 32px !important;
            padding: 0 12px !important;
            border-radius: 5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }
        .btn-header-solid:hover {
            background: rgba(129, 140, 248, 0.18) !important;
            border-color: #a5b4fc !important;
            color: #ffffff !important;
            box-shadow: none !important;
            transform: none !important;
        }

        /* Search & Filter Card Optimization */
        .search-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        }
        [data-bs-theme="dark"] .search-card,
        body.dark-mode .search-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        .search-card .filter-label {
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            margin-bottom: 6px !important;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        [data-bs-theme="dark"] .search-card .filter-label,
        body.dark-mode .search-card .filter-label {
            color: #94a3b8 !important;
        }

        /* Search input wrapper without awkward individual focus outline */
        .search-input-wrapper {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            background: #ffffff;
            height: 38px;
            transition: all 0.2s ease;
            position: relative;
        }
        .search-input-wrapper:focus-within {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
        }
        .search-input-wrapper .input-group-text {
            border: none !important;
            background: transparent !important;
            padding: 0 8px 0 12px !important;
            box-shadow: none !important;
            outline: none !important;
        }
        .search-input-wrapper .form-control {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            outline: none !important;
            height: 100% !important;
            font-size: 0.82rem !important;
            padding-left: 0 !important;
        }
        .search-input-wrapper .form-control:focus {
            box-shadow: none !important;
            outline: none !important;
            border: none !important;
        }

        .search-card .form-select {
            height: 38px !important;
            font-size: 0.82rem !important;
            border-radius: 5px !important;
            border-color: #cbd5e1 !important;
            padding: 6px 12px !important;
        }
        .search-card .form-select:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
            outline: none !important;
        }

        .search-card .btn-filter-action {
            height: 38px !important;
            background: transparent !important;
            border: 1.5px solid #4f46e5 !important;
            color: #4f46e5 !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            border-radius: 5px !important;
            padding: 0 14px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            width: 100%;
            cursor: pointer;
        }
        .search-card .btn-filter-action:hover {
            background: rgba(79, 70, 229, 0.08) !important;
            color: #4338ca !important;
            border-color: #4338ca !important;
        }
        .search-card .btn-reset-action {
            height: 38px !important;
            width: 38px !important;
            background: transparent !important;
            border: 1.5px solid #94a3b8 !important;
            color: #64748b !important;
            font-size: 0.8rem !important;
            border-radius: 5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            flex-shrink: 0;
        }
        .search-card .btn-reset-action:hover {
            background: rgba(239, 68, 68, 0.08) !important;
            border-color: #ef4444 !important;
            color: #ef4444 !important;
        }

        /* Clean Table Styles matching filter card design */
        .data-table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        }
        [data-bs-theme="dark"] .data-table-card,
        body.dark-mode .data-table-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        .data-table-card .table-header {
            padding: 12px 18px !important;
            background: #fafbfc;
            border-bottom: 1px solid #eef2f6 !important;
        }
        [data-bs-theme="dark"] .data-table-card .table-header,
        body.dark-mode .data-table-card .table-header {
            background: #101a33 !important;
            border-bottom-color: #1a253b !important;
        }
        .data-table-card .table-title {
            font-size: 0.88rem !important;
            font-weight: 700;
            color: #1e293b;
        }
        [data-bs-theme="dark"] .data-table-card .table-title,
        body.dark-mode .data-table-card .table-title {
            color: #f8fafc;
        }
        .edu-table {
            display: table !important;
            width: 100% !important;
            min-width: 650px !important;
            border-collapse: collapse !important;
            margin-bottom: 0 !important;
        }
        .edu-table thead {
            display: table-header-group !important;
        }
        .edu-table thead tr {
            display: table-row !important;
        }
        .edu-table thead th {
            display: table-cell !important;
            background: #f8fafc !important;
            color: #64748b !important;
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 9px 14px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            white-space: nowrap !important;
        }
        [data-bs-theme="dark"] .edu-table thead th,
        body.dark-mode .edu-table thead th {
            background: #0e172c !important;
            color: #94a3b8 !important;
            border-bottom-color: #1a253b !important;
        }
        .edu-table tbody {
            display: table-row-group !important;
        }
        .edu-table tbody tr {
            display: table-row !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
        }
        .edu-table tbody td {
            display: table-cell !important;
            vertical-align: middle !important;
            padding: 8px 14px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.78rem !important;
            white-space: nowrap !important;
            text-align: left !important;
        }
        .edu-table tbody td:last-child {
            text-align: center !important;
        }
        [data-bs-theme="dark"] .edu-table tbody td,
        body.dark-mode .edu-table tbody td {
            border-bottom-color: #162035 !important;
        }
        .edu-table tbody tr:hover {
            background-color: #fafbfc !important;
        }
        [data-bs-theme="dark"] .edu-table tbody tr:hover,
        body.dark-mode .edu-table tbody tr:hover {
            background-color: #111d38 !important;
        }

        .student-name-text {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.25;
        }
        [data-bs-theme="dark"] .student-name-text,
        body.dark-mode .student-name-text {
            color: #f8fafc;
        }
        .student-id-text {
            font-weight: 600;
            color: #4f46e5;
            font-size: 0.78rem;
            letter-spacing: 0.2px;
        }
        [data-bs-theme="dark"] .student-id-text,
        body.dark-mode .student-id-text {
            color: #818cf8;
        }
        .student-meta-sub {
            font-size: 0.72rem;
            color: #64748b;
        }
        [data-bs-theme="dark"] .student-meta-sub,
        body.dark-mode .student-meta-sub {
            color: #94a3b8;
        }

        .table-responsive {
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
            scrollbar-width: thin;
            width: 100%;
        }

        @media (max-width: 768px) {
            .edu-table thead th {
                padding: 8px 10px !important;
                font-size: 0.64rem !important;
            }
            .edu-table tbody td {
                padding: 7px 10px !important;
                font-size: 0.74rem !important;
            }
            .student-avatar-ring {
                width: 30px !important;
                height: 30px !important;
                margin-right: 8px !important;
            }
            .btn-icon-sm {
                width: 26px !important;
                height: 26px !important;
                font-size: 0.68rem !important;
            }
        }

        @media (max-width: 576px) {
            .page-header-card {
                padding: 16px !important;
                border-radius: 16px !important;
            }
            .header-actions {
                width: 100%;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px !important;
                margin-top: 6px;
            }
            .btn-header-outline, .btn-header-solid {
                width: 100%;
            }
            .search-card {
                padding: 14px !important;
                border-radius: 10px !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="page-header-content d-flex align-items-center gap-3">
                <div class="header-icon-box">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <h1 class="page-title fs-4 mb-1">{{ __('Students Management') }}</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">{{ __('Manage and view all students in your school') }}</p>
                </div>
            </div>
            <div class="header-actions">
                <button type="button" class="btn-header-outline"
                    data-bs-toggle="modal" data-bs-target="#studentImportModal">
                    <i class="fa-solid fa-file-excel me-1.5"></i> {{ __('Import / Export') }}
                </button>
                <a href="{{ route('students.create', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-solid">
                    <i class="fa-solid fa-plus me-1.5"></i> {{ __('Add Student') }}
                </a>
            </div>
        </div>

        {{-- Import Error / Notification --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 rounded-3 border-0" style="background:#fef2f2; border-left:4px solid #ef4444 !important;">
                <i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- =========================================================
             STUDENT IMPORT / EXPORT MODAL
             ========================================================= --}}
        <div class="modal fade" id="studentImportModal" tabindex="-1" aria-labelledby="studentImportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;box-shadow:0 4px 12px rgba(79,70,229,0.3);">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0" id="studentImportModalLabel">{{ __('Student Import / Export') }}</h5>
                                <small class="text-muted">{{ __('Upload Excel file to import multiple students') }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="px-4 pt-3">
                        <ul class="nav nav-pills gap-2" id="studentImportTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold px-4 py-2 rounded-3" id="stu-import-tab"
                                    data-bs-toggle="pill" data-bs-target="#stuImportTabPane" type="button" role="tab"
                                    style="font-size:13.5px;">
                                    <i class="fa-solid fa-file-import me-2"></i>{{ __('Import Excel') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('students.downloadTemplate', ['tenant' => auth()->user()?->school?->slug]) }}" 
                                   class="nav-link fw-semibold px-4 py-2 rounded-3 text-success" style="font-size:13.5px;">
                                    <i class="fa-solid fa-download me-2"></i>{{ __('Download Template') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="modal-body px-4 py-3">
                        <div class="tab-content" id="studentImportTabContent">
                            <div class="tab-pane fade show active" id="stuImportTabPane" role="tabpanel">
                                <form method="POST"
                                       action="{{ route('students.import', ['tenant' => auth()->user()?->school?->slug]) }}"
                                       enctype="multipart/form-data" id="modal_student_import_form">
                                    @csrf
                                    <div id="modal_stu_dropzone"
                                         class="modal-dropzone"
                                         onclick="document.getElementById('modal_stu_file').click();"
                                         ondragover="event.preventDefault(); this.classList.add('dz-over');"
                                         ondragleave="this.classList.remove('dz-over');">
                                        <div id="modal_stu_dz_icon" class="modal-dz-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>
                                        <p class="modal-dz-title" id="modal_stu_file_label">{{ __('Click or drag Excel/CSV file here') }}</p>
                                        <p class="modal-dz-sub">.xlsx &nbsp;•&nbsp; .xls &nbsp;•&nbsp; .csv &nbsp;—&nbsp; Max 5 MB</p>
                                        <input type="file" name="file" id="modal_stu_file"
                                               accept=".xlsx,.xls,.csv" class="d-none" required
                                               onchange="modalStuPreviewFile(this);">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="button" id="modal_stu_import_submit_btn"
                                class="btn fw-semibold rounded-pill px-5"
                                style="background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;border:none;box-shadow:0 4px 14px rgba(79,70,229,0.3);display:none;"
                                onclick="document.getElementById('modal_student_import_form').submit();">
                            <i class="fa-solid fa-file-import me-2"></i> {{ __('Start Import') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Section --}}
        <div class="search-card mb-4">
            <form action="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}" method="GET" id="searchForm">
                <div class="row g-2 g-md-3 align-items-end">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <label class="filter-label"><i class="fa-solid fa-magnifying-glass text-primary me-1"></i>{{ __('Search Student') }}</label>
                        <div class="input-group search-input-wrapper">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 0.8rem;"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" class="form-control border-start-0 pe-4" 
                                   placeholder="{{ __('Name, Roll, ID, Contact...') }}" value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search-btn" onclick="clearSearchField()" title="{{ __('Clear Search') }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-lg-3">
                        <label class="filter-label"><i class="fa-solid fa-chalkboard text-primary me-1"></i>{{ __('Class') }}</label>
                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">{{ __('All Classes') }}</option>
                            @foreach($classes ?? [] as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <label class="filter-label"><i class="fa-solid fa-layer-group text-primary me-1"></i>{{ __('Section') }}</label>
                        <select name="section_id" class="form-select" onchange="this.form.submit()">
                            <option value="">{{ __('All Sections') }}</option>
                            @foreach($sections ?? [] as $sec)
                                <option value="{{ $sec->id }}" {{ request('section_id') == $sec->id ? 'selected' : '' }}>
                                    {{ $sec->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <label class="filter-label"><i class="fa-solid fa-arrow-down-short-wide text-primary me-1"></i>{{ __('Sort By') }}</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                            <option value="roll_asc" {{ request('sort') == 'roll_asc' ? 'selected' : '' }}>{{ __('Roll No') }}</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('Name (A-Z)') }}</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn-filter-action flex-grow-1" title="{{ __('Apply Filter') }}">
                                <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                            </button>
                            @if(request()->hasAny(['search', 'class_id', 'section_id', 'sort']))
                                <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}" 
                                   class="btn-reset-action" title="{{ __('Reset Filters') }}">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            {{-- Active Filter Badges --}}
            @if(request()->hasAny(['search', 'class_id', 'section_id', 'sort']))
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top">
                    <span class="small text-muted me-1"><i class="fa-solid fa-sliders me-1"></i>{{ __('Active Filters:') }}</span>
                    @if(request('search'))
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-medium">
                            {{ __('Search:') }} "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ms-1 text-primary"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('class_id'))
                        @php $activeClass = ($classes ?? collect())->firstWhere('id', request('class_id')); @endphp
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-medium">
                            {{ __('Class:') }} {{ $activeClass?->name ?? 'Selected' }}
                            <a href="{{ request()->fullUrlWithQuery(['class_id' => null]) }}" class="ms-1 text-success"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('section_id'))
                        @php $activeSec = ($sections ?? collect())->firstWhere('id', request('section_id')); @endphp
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 fw-medium">
                            {{ __('Section:') }} {{ $activeSec?->name ?? 'Selected' }}
                            <a href="{{ request()->fullUrlWithQuery(['section_id' => null]) }}" class="ms-1 text-info"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="small text-danger ms-auto fw-semibold">
                        {{ __('Clear All') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="table-title mb-0"><i class="fa-solid fa-user-graduate me-2 text-primary"></i> {{ __('Active Students Directory') }}</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold" style="font-size:12px;">
                        {{ $activeStudents ?? 0 }} {{ __('Total Active') }}
                    </span>
                </div>
            </div>

            <div id="loadingSpinner" class="text-center py-5" style="display:none;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted mt-2">{{ __('Loading students...') }}</p>
            </div>

            <div id="studentTable">
                @include('school.student.partials.table')
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function clearSearchField() {
        const input = document.getElementById('searchInput');
        if (input) {
            input.value = '';
            document.getElementById('searchForm').submit();
        }
    }

    function modalStuPreviewFile(input) {
        const file = input.files[0];
        const label = document.getElementById('modal_stu_file_label');
        const icon = document.getElementById('modal_stu_dz_icon');
        const btn = document.getElementById('modal_stu_import_submit_btn');
        const dz = document.getElementById('modal_stu_dropzone');

        if (!file) return;

        const allowed = ['xlsx', 'xls', 'csv'];
        const ext = file.name.split('.').pop().toLowerCase();

        if (!allowed.includes(ext)) {
            label.textContent = '❌ Invalid format! Please choose .xlsx, .xls or .csv';
            label.style.color = '#ef4444';
            btn.style.display = 'none';
            return;
        }

        const size = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(1) + ' KB'
            : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

        label.innerHTML = `<i class="fa-solid fa-file-excel me-2" style="color:#4f46e5;"></i><strong>${file.name}</strong> <span style="color:#64748b;font-weight:400;">(${size})</span>`;
        label.style.color = '#3730a3';
        icon.innerHTML = '<i class="fa-solid fa-circle-check" style="color:#fff;font-size:1.4rem;"></i>';
        dz.classList.add('dz-selected');
        btn.style.display = 'inline-block';
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this student record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endsection