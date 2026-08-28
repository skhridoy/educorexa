@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .form-section-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            padding: 24px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }
        .form-section-card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        }
        .section-title-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
        }
        .section-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            flex-shrink: 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .form-label-custom {
            font-weight: 600;
            color: #334155;
            font-size: 13.5px;
            margin-bottom: 6px;
        }
        .form-control-custom, .form-select-custom {
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s ease;
            background-color: #fafafa;
        }
        .form-control-custom:focus, .form-select-custom:focus {
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        }
        .btn-primary-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            letter-spacing: 0.3px;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
            color: #ffffff;
        }
        .info-notice-banner {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border-left: 4px solid #4f46e5;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.08);
        }
        .pointer-events-none {
            pointer-events: none;
        }

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


        /* Excel Dropzone Styles */
        .excel-dropzone {
            border: 2px dashed #86efac;
            border-radius: 14px;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 100%);
            padding: 36px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
        }
        .excel-dropzone:hover, .excel-dropzone.dragover {
            border-color: #16a34a;
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
            box-shadow: 0 6px 20px rgba(22,163,74,0.12);
        }
        .excel-dropzone.file-selected {
            border-color: #16a34a;
            border-style: solid;
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
        }
        .excel-dropzone-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg,#16a34a,#15803d);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: #fff;
            margin: 0 auto 12px;
            box-shadow: 0 6px 16px rgba(22,163,74,0.25);
            transition: transform 0.2s ease;
        }
        .excel-dropzone:hover .excel-dropzone-icon { transform: translateY(-3px); }
        .excel-dropzone-title {
            font-weight: 700; font-size: 15px; color: #166534; margin-bottom: 4px;
        }
        .excel-dropzone-sub { font-size: 12.5px; color: #64748b; margin: 0; }
        [data-bs-theme="dark"] .excel-dropzone,
        body.dark-mode .excel-dropzone {
            background: linear-gradient(135deg, rgba(22,163,74,0.08) 0%, rgba(15,23,42,0.5) 100%) !important;
            border-color: rgba(134,239,172,0.25) !important;
        }
        [data-bs-theme="dark"] .excel-dropzone:hover,
        [data-bs-theme="dark"] .excel-dropzone.dragover,
        body.dark-mode .excel-dropzone:hover,
        body.dark-mode .excel-dropzone.dragover {
            border-color: #16a34a !important;
            background: rgba(22,163,74,0.15) !important;
        }
        [data-bs-theme="dark"] .excel-dropzone-title,
        body.dark-mode .excel-dropzone-title {
            color: #4ade80 !important;
        }
        [data-bs-theme="dark"] .excel-demo-box,
        body.dark-mode .excel-demo-box {
            background: linear-gradient(135deg, rgba(22,163,74,0.1) 0%, rgba(22,163,74,0.05) 100%) !important;
            border-color: rgba(134,239,172,0.2) !important;
        }


        /* Header Icon Box */
        .header-icon-box {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #ffffff;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        /* Info Notice Banner - Light/Dark adaptive */
        .info-notice-banner {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border-left: 4px solid #4f46e5;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.08);
        }
        [data-bs-theme="dark"] .info-notice-banner,
        body.dark-mode .info-notice-banner {
            background: linear-gradient(135deg, rgba(79,70,229,0.15) 0%, rgba(99,102,241,0.1) 100%) !important;
            border-left-color: #6366f1 !important;
            box-shadow: 0 2px 10px rgba(99, 102, 241, 0.12) !important;
        }
        [data-bs-theme="dark"] .info-notice-banner h6,
        body.dark-mode .info-notice-banner h6 {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .info-notice-banner p,
        body.dark-mode .info-notice-banner p {
            color: #94a3b8 !important;
        }

        /* Form section card dark mode */
        [data-bs-theme="dark"] .form-section-card,
        body.dark-mode .form-section-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .section-title-box,
        body.dark-mode .section-title-box {
            border-color: #1a253b !important;
        }
        [data-bs-theme="dark"] .section-title,
        body.dark-mode .section-title {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-label-custom,
        body.dark-mode .form-label-custom {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .form-control-custom,
        [data-bs-theme="dark"] .form-select-custom,
        body.dark-mode .form-control-custom,
        body.dark-mode .form-select-custom {
            background-color: #060c18 !important;
            border-color: #1a253b !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control-custom::placeholder,
        body.dark-mode .form-control-custom::placeholder {
            color: #475569 !important;
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .form-section-card {
                padding: 16px;
                border-radius: 12px;
                margin-bottom: 16px;
            }
            .info-notice-banner {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px;
                padding: 12px 14px;
            }
            .info-notice-banner .badge {
                align-self: flex-start;
            }
            .dob-select-group {
                flex-direction: row;
            }
            .btn-submit-wrapper button {
                width: 100%;
            }
        }
        @media (max-width: 480px) {
            .dob-select-group {
                flex-direction: column;
                gap: 6px;
            }
            .dob-select-group select {
                width: 100% !important;
                border-radius: 8px !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-2 px-md-3">
        {{-- Page Header --}}
        <div class="page-header-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="page-header-content d-flex align-items-center gap-3">
                <div class="header-icon-box">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h1 class="page-title fs-4 mb-1">Add New Teacher</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">Fill in the profile and professional information to register a new teacher.</p>
                </div>
            </div>
            <div class="header-actions d-flex flex-row gap-2 flex-shrink-0">
                <button type="button" class="btn btn-sm btn-white rounded-pill px-3 shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#teacherImportModal"
                    style="border:1.5px solid rgba(255,255,255,0.4); font-weight:600; font-size:13px; white-space:nowrap;">
                    <i class="fa-solid fa-file-excel me-1" style="color:#16a34a;"></i> Import / Export
                </button>
                <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn btn-sm btn-white rounded-pill px-3 shadow-sm"
                   style="font-size:13px; white-space:nowrap;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Notice Banner for Default Password --}}
        <div class="info-notice-banner d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div style="width:36px;height:36px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">Default Login Password</h6>
                    <p class="mb-0 text-muted small">Teacher login account password is automatically set to <span class="badge bg-primary px-2 py-1">12345678</span>. Password input field is not required.</p>
                </div>
            </div>
            <span class="badge bg-indigo text-primary bg-opacity-10 px-3 py-2 rounded-pill fw-bold small mt-2 mt-sm-0">Auto-Generated</span>
        </div>

        {{-- Import Error / Skipped rows notification (from session after import) --}}
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

        {{-- Error Summary Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-4" role="alert" style="background:#fef2f2; border-left: 4px solid #ef4444 !important;">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-circle-exclamation me-2 fs-5 text-danger"></i>
                    <strong class="fs-6 text-danger">Please fix the following validation errors:</strong>
                </div>
                <ul class="mb-0 ps-4 text-danger small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <h5 class="modal-title fw-bold mb-0" id="teacherImportModalLabel">Teacher Import / Export</h5>
                                <small class="text-muted">Excel বা CSV ফাইলের মাধ্যমে শিক্ষক যুক্ত করুন</small>
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
                                    <i class="fa-solid fa-file-import me-2"></i>Import
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold px-4 py-2 rounded-3" id="export-tab"
                                    data-bs-toggle="pill" data-bs-target="#exportTabPane" type="button" role="tab"
                                    style="font-size:13.5px;">
                                    <i class="fa-solid fa-file-arrow-down me-2"></i>ডেমো ডাউনলোড
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
                                        <p class="fw-bold mb-1 text-dark"><i class="fa-solid fa-circle-info me-1 text-primary"></i>প্রয়োজনীয় কলামসমূহ:</p>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach(['name *','email *','phone *','gender','subject_name *','date_of_birth','father_name','mother_name','nid','blood_group','joining_date','qualification','address'] as $col)
                                                <span class="badge rounded-pill fw-normal"
                                                      style="background:{{ str_contains($col,'*') ? '#16a34a' : '#64748b' }};color:#fff;font-size:11px;">
                                                    {{ $col }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <p class="text-muted mt-2 mb-0" style="font-size:11px;">
                                            <span class="text-success fw-bold">*</span> চিহ্নিত কলামগুলো আবশ্যক &nbsp;|&nbsp;
                                            ডিফল্ট পাসওয়ার্ড: <span class="badge bg-primary">12345678</span>
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
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">বাতিল</button>
                        <button type="button" id="modal_import_submit_btn"
                                class="btn fw-semibold rounded-pill px-5"
                                style="background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border:none;box-shadow:0 4px 14px rgba(22,163,74,0.3);display:none;"
                                onclick="document.getElementById('modal_excel_import_form').submit();">
                            <i class="fa-solid fa-file-import me-2"></i> Import শুরু করুন
                        </button>
                    </div>

                </div>
            </div>
        </div>
        {{-- /MODAL --}}

        <form method="POST" action="{{ route('teachers.store', ['tenant' => auth()->user()?->school?->slug]) }}" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Basic & Contact Details --}}
            <div class="form-section-card">
                <div class="section-title-box">
                    <div class="section-icon">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Personal & Contact Information</h2>
                        <small class="text-muted">Primary contact and identification details</small>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Teacher Name --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="name">Teacher Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="name" class="form-control form-control-custom border-start-0 @error('name') is-invalid @enderror"
                                    id="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                            </div>
                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Email Address --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="email">Official Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-custom border-start-0 @error('email') is-invalid @enderror"
                                    id="email" value="{{ old('email') }}" placeholder="teacher@school.com" required>
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone Number with Real-time Validation --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group position-relative">
                            <label class="form-label-custom" for="phone">Phone Number <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control form-control-custom border-start-0 pe-5 @error('phone') is-invalid @enderror"
                                        id="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX" maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); validatePhone(this.value);" required>
                                </div>
                                <span id="phone_icon_status" class="position-absolute end-0 top-50 translate-middle-y me-3 pointer-events-none" style="display: none;"></span>
                            </div>
                            <small id="phone_help_text" class="text-muted d-block mt-1">১১ ডিজিট (শুরু হবে 01 দিয়ে, সর্বোচ্চ ১১ ডিজিট)</small>
                            @error('phone')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label-custom" for="gender">Gender <span class="text-danger">*</span></label>
                            <select class="form-select form-select-custom @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Date of Birth --}}
                    <div class="col-12 col-sm-6 col-lg-5">
                        <div class="form-group">
                            <label class="form-label-custom">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group dob-select-group">
                                <select name="dob_day" class="form-select form-select-custom" required>
                                    <option value="">Day</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        @php $dayVal = sprintf('%02d', $i); @endphp
                                        <option value="{{ $dayVal }}" {{ old('dob_day') == $dayVal ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>

                                <select name="dob_month" class="form-select form-select-custom" required>
                                    <option value="">Month</option>
                                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $index => $month)
                                        @php $monthVal = sprintf('%02d', $index + 1); @endphp
                                        <option value="{{ $monthVal }}" {{ old('dob_month') == $monthVal ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>

                                <select name="dob_year" class="form-select form-select-custom" required>
                                    <option value="">Year</option>
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 80;
                                    @endphp
                                    @for ($i = $currentYear; $i >= $startYear; $i--)
                                        <option value="{{ $i }}" {{ old('dob_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            @error('date_of_birth')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Profile Photo --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="photo">Profile Photo</label>
                            <input type="file" class="form-control form-control-custom @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Academic & Professional Details --}}
            <div class="form-section-card">
                <div class="section-title-box">
                    <div class="section-icon" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Academic & Professional Details</h2>
                        <small class="text-muted">Subject, qualification, and joining information</small>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Subject --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="subject_id">Department / Subject <span class="text-danger">*</span></label>
                            <select class="form-select form-select-custom @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }} class="text-capitalize">{{ $subject->code ? $subject->code . ' - ' : '' }}{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Qualification --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="qualification">Educational Qualification</label>
                            <input type="text" name="qualification" class="form-control form-control-custom"
                                id="qualification" value="{{ old('qualification') }}" placeholder="e.g., M.A. in English, B.Sc in CSE">
                        </div>
                    </div>

                    {{-- Joining Date --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="joining_date">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control form-control-custom"
                                id="joining_date" value="{{ old('joining_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Guardian & Identification Details --}}
            <div class="form-section-card">
                <div class="section-title-box">
                    <div class="section-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fa-solid fa-house-user"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Guardian & Additional Information</h2>
                        <small class="text-muted">Parents' names, NID, blood group, and address</small>
                    </div>
                </div>

                <div class="row g-3">
                    {{-- Father Name --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="father_name">Father's Name</label>
                            <input type="text" name="father_name" class="form-control form-control-custom"
                                id="father_name" value="{{ old('father_name') }}" placeholder="Enter father's name">
                        </div>
                    </div>

                    {{-- Mother Name --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="form-label-custom" for="mother_name">Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control form-control-custom"
                                id="mother_name" value="{{ old('mother_name') }}" placeholder="Enter mother's name">
                        </div>
                    </div>

                    {{-- NID Number with Real-time Validation --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group position-relative">
                            <label class="form-label-custom" for="nid">NID / Smart Card Number</label>
                            <div class="position-relative">
                                <input type="text" name="nid" class="form-control form-control-custom pe-5 @error('nid') is-invalid @enderror"
                                    id="nid" value="{{ old('nid') }}" placeholder="Enter 10 or 17 digit NID" maxlength="17"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); validateNid(this.value);">
                                <span id="nid_icon_status" class="position-absolute end-0 top-50 translate-middle-y me-3 pointer-events-none" style="display: none;"></span>
                            </div>
                            <small id="nid_help_text" class="text-muted d-block mt-1">এনআইডি ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে</small>
                            @error('nid')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Blood Group --}}
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label class="form-label-custom" for="blood_group">Blood Group</label>
                            <select class="form-select form-select-custom" id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="col-12 col-sm-6 col-lg-9">
                        <div class="form-group">
                            <label class="form-label-custom" for="address">Full Address</label>
                            <input type="text" name="address" class="form-control form-control-custom"
                                id="address" value="{{ old('address') }}" placeholder="Enter residential address">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Action Button --}}
            <div class="btn-submit-wrapper d-flex justify-content-end mb-5">
                <button type="submit" id="btn_submit_teacher" class="btn btn-primary-gradient px-5 py-3 rounded-3 shadow w-100 w-sm-auto">
                    <i class="fa-solid fa-user-plus me-2"></i> Register Teacher Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('customJs')
<script>
    // Real-time Phone Validation Function
    function validatePhone(val) {
        const iconSpan = document.getElementById('phone_icon_status');
        const helpText = document.getElementById('phone_help_text');
        const phoneInput = document.getElementById('phone');

        if (!val) {
            iconSpan.style.display = 'none';
            helpText.className = 'text-muted d-block mt-1';
            helpText.innerText = '১১ ডিজিট (শুরু হবে 01 দিয়ে, সর্বোচ্চ ১১ ডিজিট)';
            phoneInput.classList.remove('is-valid', 'is-invalid');
            return;
        }

        iconSpan.style.display = 'inline-block';
        
        // Valid Bangladesh mobile prefix pattern: ^01[3-9]
        const validPrefixRegex = /^01[3-9]/;
        const isValidPrefix = validPrefixRegex.test(val);

        if (!isValidPrefix) {
            // Invalid prefix -> Show Red Cross Icon
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-xmark text-danger fs-5"></i>';
            helpText.className = 'text-danger d-block mt-1 fw-semibold';
            helpText.innerText = 'ফোন নম্বর প্রেফিক্স ভুল! (যেমন: 013, 014, 017, 018, 019 হতে হবে)';
            phoneInput.classList.add('is-invalid');
            phoneInput.classList.remove('is-valid');
        } else if (val.length < 11) {
            // Valid prefix but incomplete length (< 11) -> Show Red Cross Icon
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-xmark text-danger fs-5"></i>';
            helpText.className = 'text-danger d-block mt-1 fw-semibold';
            helpText.innerText = `১১ ডিজিট প্রয়োজন (বর্তমানে ${val.length} ডিজিট)`;
            phoneInput.classList.add('is-invalid');
            phoneInput.classList.remove('is-valid');
        } else if (val.length === 11 && isValidPrefix) {
            // Exactly 11 digits & valid prefix -> Show Green Tick Icon
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-check text-success fs-5"></i>';
            helpText.className = 'text-success d-block mt-1 fw-semibold';
            helpText.innerText = 'ফোন নম্বরটি সঠিক (১১ ডিজিট)';
            phoneInput.classList.remove('is-invalid');
            phoneInput.classList.add('is-valid');
        }
    }

    // Real-time NID Validation Function
    function validateNid(val) {
        const iconSpan = document.getElementById('nid_icon_status');
        const helpText = document.getElementById('nid_help_text');
        const nidInput = document.getElementById('nid');

        if (!val) {
            iconSpan.style.display = 'none';
            helpText.className = 'text-muted d-block mt-1';
            helpText.innerText = 'এনআইডি ১০ ডিজিট অথবা ১৭ ডিজিট হতে হবে';
            nidInput.classList.remove('is-valid', 'is-invalid');
            return;
        }

        iconSpan.style.display = 'inline-block';

        if (val.length === 10 || val.length === 17) {
            // Valid length (10 or 17 digits) -> Show Green Tick Icon
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-check text-success fs-5"></i>';
            helpText.className = 'text-success d-block mt-1 fw-semibold';
            helpText.innerText = `এনআইডি নম্বরটি সঠিক (${val.length} ডিজিট)`;
            nidInput.classList.remove('is-invalid');
            nidInput.classList.add('is-valid');
        } else {
            // Invalid length -> Show Red Cross Icon
            iconSpan.innerHTML = '<i class="fa-solid fa-circle-xmark text-danger fs-5"></i>';
            helpText.className = 'text-danger d-block mt-1 fw-semibold';
            helpText.innerText = `এনআইডি অবশ্যই ১০ অথবা ১৭ ডিজিট হতে হবে (বর্তমানে ${val.length} ডিজিট)`;
            nidInput.classList.add('is-invalid');
            nidInput.classList.remove('is-valid');
        }
    }

    // Trigger initial validation check on DOM content loaded (for old input values)
    document.addEventListener('DOMContentLoaded', function() {
        const phoneElem = document.getElementById('phone');
        if (phoneElem && phoneElem.value) {
            validatePhone(phoneElem.value);
        }

        const nidElem = document.getElementById('nid');
        if (nidElem && nidElem.value) {
            validateNid(nidElem.value);
        }
    });

    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

    // Drag-and-drop file handler
    function handleDrop(event) {
        event.preventDefault();
        const dropzone = document.getElementById('excel_dropzone');
        dropzone.classList.remove('dragover');

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const input = document.getElementById('excel_file');
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            previewFile(input);
        }
    }

    // File selected preview handler (OLD - kept for backwards compat)
    function previewFile(input) {
        const file = input.files[0];
        if (!file) return;
        const allowed = ['xlsx', 'xls', 'csv'];
        const ext = file.name.split('.').pop().toLowerCase();
        if (!allowed.includes(ext)) return;
        const label = document.getElementById('excel_file_label');
        const btn   = document.getElementById('excel_import_btn');
        const dz    = document.getElementById('excel_dropzone');
        const icon  = document.getElementById('excel_upload_icon');
        const size  = file.size < 1024*1024 ? (file.size/1024).toFixed(1)+' KB' : (file.size/(1024*1024)).toFixed(2)+' MB';
        if(label) { label.innerHTML = `<i class="fa-solid fa-file-excel me-2" style="color:#16a34a;"></i>${file.name} <span style="color:#64748b;font-weight:400;">(${size})</span>`; }
        if(icon)  { icon.className = 'fa-solid fa-circle-check'; icon.style.color = '#fff'; }
        if(dz)    { dz.classList.add('file-selected'); }
        if(btn)   { btn.style.display = 'inline-block'; }
    }

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

    // Hide import button when Export tab is active
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('export-tab')?.addEventListener('shown.bs.tab', function () {
            document.getElementById('modal_import_submit_btn').style.display = 'none';
        });
        document.getElementById('import-tab')?.addEventListener('shown.bs.tab', function () {
            const hasFile = document.getElementById('modal_excel_file')?.files?.length > 0;
            if (hasFile) document.getElementById('modal_import_submit_btn').style.display = 'inline-block';
        });

        // Auto-open modal if there was a validation error for excel_file
        @if($errors->has('excel_file'))
            var importModal = new bootstrap.Modal(document.getElementById('teacherImportModal'));
            importModal.show();
        @endif
    });
</script>
@endsection