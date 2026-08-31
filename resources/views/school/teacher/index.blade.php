@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Modal Dropzone */
        .modal-dropzone {
            border: 2px dashed #86efac;
            border-radius: 14px;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%);
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            user-select: none;
        }
        .modal-dropzone:hover, .modal-dropzone.dz-over {
            border-color: #16a34a;
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
            box-shadow: 0 6px 20px rgba(22,163,74,0.12);
        }
        .modal-dropzone.dz-selected {
            border-color: #16a34a;
            border-style: solid;
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
        }
        .modal-dz-icon {
            width: 50px; height: 50px;
            background: linear-gradient(135deg,#16a34a,#15803d);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #fff;
            margin: 0 auto 10px;
            box-shadow: 0 4px 12px rgba(22,163,74,0.25);
            transition: transform 0.2s ease;
        }
        .modal-dropzone:hover .modal-dz-icon { transform: translateY(-3px); }
        .modal-dz-title { font-weight: 700; font-size: 14.5px; color: #166534; margin-bottom: 3px; }
        .modal-dz-sub   { font-size: 12px; color: #64748b; margin: 0; }
        [data-bs-theme="dark"] .modal-dropzone,
        body.dark-mode .modal-dropzone {
            background: rgba(22,163,74,0.08) !important;
            border-color: rgba(134,239,172,0.25) !important;
        }
        [data-bs-theme="dark"] .modal-dropzone:hover,
        [data-bs-theme="dark"] .modal-dropzone.dz-over,
        body.dark-mode .modal-dropzone:hover,
        body.dark-mode .modal-dropzone.dz-over {
            background: rgba(22,163,74,0.15) !important;
            border-color: #16a34a !important;
        }
        [data-bs-theme="dark"] .modal-dz-title,
        body.dark-mode .modal-dz-title { color: #4ade80 !important; }
        [data-bs-theme="dark"] .modal-content,
        body.dark-mode .modal-content { background: #0c1427 !important; color: #f8fafc !important; }
        [data-bs-theme="dark"] .modal-body .small,
        body.dark-mode .modal-body .small { color: #94a3b8; }
        [data-bs-theme="dark"] #importTabPane .p-3,
        body.dark-mode #importTabPane .p-3 {
            background: #060c18 !important;
            border-color: #1a253b !important;
        }

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

        /* Clean Compact Action Buttons */
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

        .teacher-avatar-ring {
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 1.5px solid #6366f1 !important;
            box-shadow: 0 1px 4px rgba(99, 102, 241, 0.15);
            flex-shrink: 0;
        }
        .teacher-id-text {
            font-weight: 600;
            color: #4f46e5;
            font-size: 0.78rem;
            letter-spacing: 0.2px;
        }
        [data-bs-theme="dark"] .teacher-id-text,
        body.dark-mode .teacher-id-text {
            color: #818cf8;
        }
        .teacher-name-text {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.25;
        }
        [data-bs-theme="dark"] .teacher-name-text,
        body.dark-mode .teacher-name-text {
            color: #f8fafc;
        }
        .teacher-meta-sub {
            font-size: 0.72rem;
            color: #64748b;
        }
        [data-bs-theme="dark"] .teacher-meta-sub,
        body.dark-mode .teacher-meta-sub {
            color: #94a3b8;
        }

        /* Search input wrapper with smooth focus */
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

        /* Strict Table Structure */
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
            .teacher-avatar-ring {
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
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h1 class="page-title fs-4 mb-1">{{ __('Teachers Management') }}</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">{{ __('Manage and view all teachers in your school') }}</p>
                </div>
            </div>
            <div class="header-actions">
                <button type="button" class="btn-header-outline"
                    data-bs-toggle="modal" data-bs-target="#teacherImportModal">
                    <i class="fa-solid fa-file-excel me-1.5"></i> {{ __('Import / Export') }}
                </button>
                <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-solid">
                    <i class="fa-solid fa-plus me-1.5"></i> {{ __('Add Teacher') }}
                </a>
            </div>
        </div>

        {{-- Import Error / Skipped rows notification --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 rounded-3 border-0" style="background:#fef2f2; border-left:4px solid #ef4444 !important;">
                <i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('skipped_rows') && count(session('skipped_rows')) > 0)
            <div class="alert alert-warning alert-dismissible fade show mb-3 rounded-3 border-0" style="background:#fffbeb; border-left:4px solid #f59e0b !important;">
                <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>
                <strong>এড়িয়ে যাওয়া সারিগুলো:</strong>
                <ul class="mb-0 ps-4 mt-1 small">
                    @foreach(session('skipped_rows') as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- =========================================================
             TEACHER IMPORT / EXPORT MODAL
             ========================================================= --}}
        <div class="modal fade" id="teacherImportModal" tabindex="-1" aria-labelledby="teacherImportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

                    {{-- Modal Header --}}
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#16a34a,#15803d);display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;box-shadow:0 4px 12px rgba(22,163,74,0.3);">
                                <i class="fa-solid fa-file-excel"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0" id="teacherImportModalLabel">{{ __('Teacher Import / Export') }}</h5>
                                <small class="text-muted">{{ __('Add teachers via Excel or CSV file') }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    {{-- Tabs --}}
                    <div class="px-4 pt-3">
                        <ul class="nav nav-pills gap-2" id="importExportTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-semibold px-4 py-2 rounded-3" id="import-tab"
                                    data-bs-toggle="pill" data-bs-target="#importTabPane" type="button" role="tab"
                                    style="font-size:13.5px;">
                                    <i class="fa-solid fa-file-import me-2"></i>{{ __('Import') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold px-4 py-2 rounded-3" id="export-tab"
                                    data-bs-toggle="pill" data-bs-target="#exportTabPane" type="button" role="tab"
                                    style="font-size:13.5px;">
                                    <i class="fa-solid fa-file-arrow-down me-2"></i>{{ __('Demo Download') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    {{-- Modal Body --}}
                    <div class="modal-body px-4 py-3">
                        <div class="tab-content" id="importExportTabContent">

                            {{-- ── IMPORT TAB ── --}}
                            <div class="tab-pane fade show active" id="importTabPane" role="tabpanel">
                                <form method="POST"
                                      action="{{ route('teachers.import', ['tenant' => auth()->user()?->school?->slug]) }}"
                                      enctype="multipart/form-data" id="modal_excel_import_form">
                                    @csrf

                                    {{-- Dropzone --}}
                                    <div id="modal_excel_dropzone"
                                         class="modal-dropzone"
                                         onclick="document.getElementById('modal_excel_file').click();"
                                         ondragover="event.preventDefault(); this.classList.add('dz-over');"
                                         ondragleave="this.classList.remove('dz-over');"
                                         ondrop="modalHandleDrop(event);">
                                        <div id="modal_dz_icon" class="modal-dz-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>
                                        <p class="modal-dz-title" id="modal_file_label">ফাইলটি এখানে টেনে আনুন বা ক্লিক করুন</p>
                                        <p class="modal-dz-sub">.xlsx &nbsp;•&nbsp; .xls &nbsp;•&nbsp; .csv &nbsp;—&nbsp; সর্বোচ্চ ৫ MB</p>
                                        <input type="file" name="excel_file" id="modal_excel_file"
                                               accept=".xlsx,.xls,.csv" class="d-none"
                                               onchange="modalPreviewFile(this);">
                                    </div>

                                    @error('excel_file')
                                        <small class="text-danger d-block mt-2">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>{{ $message }}
                                        </small>
                                    @enderror

                                    {{-- Info row --}}
                                    <div class="mt-3 p-3 rounded-3 small" style="background:#f8fafc; border:1px solid #e2e8f0;">
                                        <p class="fw-bold mb-1 text-dark"><i class="fa-solid fa-circle-info me-1 text-primary"></i>{{ __('Required Columns:') }}</p>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach(['name *','email *','phone *','gender','subject_name *','date_of_birth','father_name','mother_name','nid','blood_group','joining_date','qualification','address'] as $col)
                                                <span class="badge rounded-pill fw-normal"
                                                      style="background:{{ str_contains($col,'*') ? '#16a34a' : '#64748b' }};color:#fff;font-size:11px;">
                                                    {{ $col }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-muted mt-2 mb-0" style="font-size:11px;">
                                            <span class="text-success fw-bold">*</span> {{ __('marked columns are required') }} &nbsp;|&nbsp;
                                            {{ __('Default password') }}: <span class="badge bg-primary">12345678</span>
                                        </p>
                                    </div>
                                </form>
                            </div>

                            {{-- ── EXPORT / DEMO TAB ── --}}
                            <div class="tab-pane fade" id="exportTabPane" role="tabpanel">
                                <div class="text-center py-2">
                                    <div style="width:70px;height:70px;background:linear-gradient(135deg,#16a34a,#15803d);border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;margin:0 auto 16px;box-shadow:0 8px 20px rgba(22,163,74,0.25);">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1" style="color:#166534;font-size:15px;">ডেমো টেমপ্লেট ডাউনলোড</h6>
                                    <p class="text-muted small mb-4">সঠিক ফরম্যাট নিশ্চিত করতে নিচের নমুনা ফাইলটি ডাউনলোড করুন এবং সেটি পূরণ করে Import করুন।</p>

                                    <a href="{{ route('teachers.demo', ['tenant' => auth()->user()?->school?->slug]) }}"
                                       class="btn fw-bold px-5 py-2 rounded-pill"
                                       style="background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;box-shadow:0 4px 14px rgba(22,163,74,0.3);font-size:14px;">
                                        <i class="fa-solid fa-download me-2"></i> ডাউনলোড করুন (.csv)
                                    </a>

                                    <div class="mt-4 text-start p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                        <p class="fw-bold small mb-2 text-success"><i class="fa-solid fa-list-check me-1"></i>কলামের বিস্তারিত:</p>
                                        <table class="table table-sm table-borderless mb-0" style="font-size:12.5px;">
                                            <thead><tr><th class="text-muted ps-0">কলাম</th><th class="text-muted">উদাহরণ</th><th class="text-muted">প্রয়োজনীয়?</th></tr></thead>
                                            <tbody>
                                                @foreach([
                                                    ['name','Rahim Uddin','হ্যাঁ'],
                                                    ['email','rahim@school.com','হ্যাঁ'],
                                                    ['phone','01712345678','হ্যাঁ'],
                                                    ['gender','male / female','না'],
                                                    ['subject_name','Mathematics','হ্যাঁ'],
                                                    ['date_of_birth','1985-06-15','না'],
                                                    ['father_name','Karim Uddin','না'],
                                                    ['nid','1234567890','না'],
                                                    ['blood_group','B+','না'],
                                                ] as [$col,$ex,$req])
                                                <tr>
                                                    <td class="ps-0 fw-semibold text-dark">{{ $col }}</td>
                                                    <td class="text-muted">{{ $ex }}</td>
                                                    <td>
                                                        @if($req === 'হ্যাঁ')
                                                            <span class="badge bg-success" style="font-size:10px;">আবশ্যক</span>
                                                        @else
                                                            <span class="badge bg-secondary" style="font-size:10px;">ঐচ্ছিক</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /tab-content --}}
                    </div>

                    {{-- Modal Footer --}}
                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="button" id="modal_import_submit_btn"
                                class="btn fw-semibold rounded-pill px-5"
                                style="background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border:none;box-shadow:0 4px 14px rgba(22,163,74,0.3);display:none;"
                                onclick="document.getElementById('modal_excel_import_form').submit();">
                            <i class="fa-solid fa-file-import me-2"></i> {{ __('Start Import') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
        {{-- /MODAL --}}

        {{-- Search & Filter Section --}}
        <div class="search-card mb-4">
            <form action="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" method="GET" id="teacherFilterForm">
                <div class="row g-2 g-md-3 align-items-end">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label class="filter-label"><i class="fa-solid fa-magnifying-glass me-1 text-primary"></i> {{ __('Search Teacher') }}</label>
                        <div class="search-input-wrapper">
                            <span class="input-group-text text-muted">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" class="form-control" 
                                   placeholder="{{ __('Name, ID, Email, Phone...') }}" value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search-btn" onclick="clearSearchField()" title="Clear Search">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <label class="filter-label"><i class="fa-solid fa-book-open me-1 text-primary"></i> {{ __('Subject') }}</label>
                        <select name="subject_id" class="form-select" onchange="this.form.submit()">
                            <option value="">{{ __('All Subjects') }}</option>
                            @foreach($subjects ?? [] as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->code ? $subject->code . ' - ' : '' }}{{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <label class="filter-label"><i class="fa-solid fa-arrow-down-short-wide me-1 text-primary"></i> {{ __('Sort By') }}</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('Name (A-Z)') }}</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>{{ __('Name (Z-A)') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn-filter-action">
                                <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                            </button>
                            @if(request()->hasAny(['search', 'subject_id', 'sort']))
                                <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" 
                                   class="btn-reset-action" title="Reset Filters">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            {{-- Active Filter Badges --}}
            @if(request()->hasAny(['search', 'subject_id', 'sort']))
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top">
                    <span class="small text-muted me-1"><i class="fa-solid fa-sliders me-1"></i>{{ __('Active Filters:') }}</span>
                    @if(request('search'))
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 fw-medium" style="font-size:11px;">
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ms-1 text-primary"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('subject_id'))
                        @php $activeSubject = ($subjects ?? collect())->firstWhere('id', request('subject_id')); @endphp
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-medium" style="font-size:11px;">
                            Subject: {{ $activeSubject?->name ?? 'Selected' }}
                            <a href="{{ request()->fullUrlWithQuery(['subject_id' => null]) }}" class="ms-1 text-success"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('sort') && request('sort') !== 'newest')
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1.5 fw-medium" style="font-size:11px;">
                            Sort: {{ request('sort') }}
                            <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="ms-1 text-info"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="small text-danger ms-auto fw-semibold" style="font-size:11px;">
                        {{ __('Clear All') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="table-title mb-0"><i class="fa-solid fa-chalkboard-user me-2 text-primary"></i> {{ __('Teacher Directory') }}</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-0.5 fw-bold" style="font-size:11px;">
                        {{ method_exists($teachers, 'total') ? $teachers->total() : count($teachers) }} {{ __('Teachers') }}
                    </span>
                </div>
            </div>

            @if($teachers->count() > 0)
                {{-- Responsive Clean Table for all screens --}}
                <div class="table-responsive">
                    <table class="table edu-table align-middle mb-0 text-nowrap">
                        <thead>
                            <tr>
                                <th class="ps-3">{{ __('Teacher Info') }}</th>
                                <th>{{ __('ID & Designation') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Contact Info') }}</th>
                                <th class="text-center pe-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" 
                                             alt="{{ $teacher->name }}" class="teacher-avatar-ring me-3">
                                        <div>
                                            <div class="teacher-name-text">{{ $teacher->name }}</div>
                                            <div class="teacher-meta-sub">{{ $teacher->qualification ?? 'Teacher' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="teacher-id-text mb-0.5">{{ $teacher->teacher_id }}</div>
                                    <div class="teacher-meta-sub">{{ $teacher->designation ?? 'Teacher' }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary mb-0.5" style="font-size: 0.8rem;">
                                        <i class="fa-solid fa-book-open me-1 opacity-75"></i>{{ $teacher->subject?->name ?? 'General' }}
                                    </div>
                                    <div class="teacher-meta-sub">
                                        {{ $teacher->subject?->code ? 'Code: '.$teacher->subject->code : '' }}
                                    </div>
                                </td>
                                <td>
                                    @if($teacher->phone)
                                        <div class="mb-0.5" style="font-size: 0.76rem;">
                                            <a href="tel:{{ $teacher->phone }}" class="text-secondary text-decoration-none">
                                                <i class="fa-solid fa-phone me-1 text-success"></i>{{ $teacher->phone }}
                                            </a>
                                        </div>
                                    @endif
                                    @if($teacher->email)
                                        <div class="teacher-meta-sub">
                                            <a href="mailto:{{ $teacher->email }}" class="text-secondary text-decoration-none">
                                                <i class="fa-regular fa-envelope me-1 opacity-50"></i>{{ $teacher->email }}
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('teachers.show', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn-icon-sm btn-soft-primary" title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn-icon-sm btn-soft-warning" title="Edit Teacher">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', ['tenant' => auth()->user()?->school?->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn-icon-sm btn-soft-danger" title="Delete Teacher">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                {{-- Empty State --}}
                <div class="text-center py-5 px-3">
                    <div class="py-4">
                        <div class="mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: rgba(22,163,74,0.1); color: #16a34a;">
                                <i class="fa-solid fa-chalkboard-user fa-2x"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ __('No Teachers Found') }}</h5>
                        <p class="text-muted small mb-3">
                            @if(request()->hasAny(['search', 'subject_id', 'sort']))
                                {{ __('No teachers match your specified filter criteria.') }}
                            @else
                                {{ __('No teacher records available in the system.') }}
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'subject_id', 'sort']))
                            <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4">
                                <i class="fa-solid fa-rotate-left me-1"></i> {{ __('Clear Filters') }}
                            </a>
                        @else
                            <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-primary-modern rounded-pill px-4">
                                <i class="fa-solid fa-plus me-1"></i> {{ __('Add Your First Teacher') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            
            @if(method_exists($teachers, 'links'))
                <div class="px-4 py-3 border-top">
                    {{ $teachers->links() }}
                </div>
            @endif
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
            document.getElementById('teacherFilterForm').submit();
        }
    }

    // Delete Confirmation
    function confirmDelete(button) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('Do you want to delete this teacher?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Success Message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    @endif

    // Error Message
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    @endif

    // Feather Icons Initialization
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') {
            feather.replace({ width: '18', height: '18' });
        }
    });

    /* ── MODAL DROPZONE FUNCTIONS ── */
    function modalHandleDrop(event) {
        event.preventDefault();
        const dz = document.getElementById('modal_excel_dropzone');
        dz.classList.remove('dz-over');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const input = document.getElementById('modal_excel_file');
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            modalPreviewFile(input);
        }
    }

    function modalPreviewFile(input) {
        const file  = input.files[0];
        const label = document.getElementById('modal_file_label');
        const icon  = document.getElementById('modal_dz_icon');
        const btn   = document.getElementById('modal_import_submit_btn');
        const dz    = document.getElementById('modal_excel_dropzone');

        if (!file) return;

        const allowed = ['xlsx', 'xls', 'csv'];
        const ext = file.name.split('.').pop().toLowerCase();

        if (!allowed.includes(ext)) {
            label.textContent  = '❌ অনুমোদিত ফরম্যাট নয়! (.xlsx, .xls বা .csv বেছে নিন)';
            label.style.color  = '#ef4444';
            dz.classList.remove('dz-selected');
            btn.style.display  = 'none';
            return;
        }

        const size = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(1) + ' KB'
            : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

        label.innerHTML    = `<i class="fa-solid fa-file-excel me-2" style="color:#16a34a;"></i><strong>${file.name}</strong> <span style="color:#64748b;font-weight:400;">(${size})</span>`;
        label.style.color  = '#166534';
        icon.innerHTML     = '<i class="fa-solid fa-circle-check" style="color:#fff;font-size:1.4rem;"></i>';
        dz.classList.add('dz-selected');
        btn.style.display  = 'inline-block';
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('export-tab')?.addEventListener('shown.bs.tab', function () {
            document.getElementById('modal_import_submit_btn').style.display = 'none';
        });
        document.getElementById('import-tab')?.addEventListener('shown.bs.tab', function () {
            const hasFile = document.getElementById('modal_excel_file')?.files?.length > 0;
            if (hasFile) document.getElementById('modal_import_submit_btn').style.display = 'inline-block';
        });

        @if($errors->has('excel_file'))
            var importModal = new bootstrap.Modal(document.getElementById('teacherImportModal'));
            importModal.show();
        @endif
    });
</script>
@endsection