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

        /* Compact Soft Icon Buttons */
        .btn-icon-sm {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 13.5px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
        }
        .btn-soft-primary {
            background-color: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
        }
        .btn-soft-primary:hover {
            background-color: #4f46e5;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            transform: translateY(-1px);
        }
        .btn-soft-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        .btn-soft-warning:hover {
            background-color: #f59e0b;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            transform: translateY(-1px);
        }
        .btn-soft-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        .btn-soft-danger:hover {
            background-color: #ef4444;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transform: translateY(-1px);
        }

        [data-bs-theme="dark"] .btn-soft-primary,
        body.dark-mode .btn-soft-primary { background: rgba(99, 102, 241, 0.2); color: #818cf8; }
        [data-bs-theme="dark"] .btn-soft-warning,
        body.dark-mode .btn-soft-warning { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        [data-bs-theme="dark"] .btn-soft-danger,
        body.dark-mode .btn-soft-danger { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        /* Mobile Responsive Card Styling */
        .teacher-mobile-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 4px 15px rgba(15,23,42,0.05);
            transition: all 0.25s ease;
        }
        .teacher-mobile-card:hover {
            box-shadow: 0 8px 25px rgba(15,23,42,0.1);
            transform: translateY(-2px);
        }
        [data-bs-theme="dark"] .teacher-mobile-card,
        body.dark-mode .teacher-mobile-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            box-shadow: none;
        }
        .teacher-avatar-ring {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #16a34a;
            box-shadow: 0 2px 8px rgba(22,163,74,0.2);
        }
        .teacher-id-badge {
            background: rgba(22,163,74,0.1);
            color: #16a34a;
            font-weight: 700;
            font-size: 11.5px;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
        }
        [data-bs-theme="dark"] .teacher-id-badge,
        body.dark-mode .teacher-id-badge {
            background: rgba(22,163,74,0.2);
            color: #4ade80;
        }

        /* Structured Mobile Info Box */
        .teacher-info-box {
            background: rgba(248, 250, 252, 0.95);
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }
        [data-bs-theme="dark"] .teacher-info-box,
        body.dark-mode .teacher-info-box {
            background: #09101f !important;
            border-color: #1a253b !important;
        }
        .teacher-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 3px 0;
            min-width: 0;
        }
        .teacher-info-row:not(:last-child) {
            margin-bottom: 8px;
        }
        .teacher-info-label {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .teacher-info-icon {
            width: 18px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }
        .teacher-info-value {
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
            .header-actions .btn {
                width: 100%;
                text-align: center;
                justify-content: center;
                padding: 7px 10px !important;
                font-size: 12px !important;
            }
            .search-card {
                padding: 16px !important;
                border-radius: 14px !important;
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
                    <h1 class="page-title fs-4 mb-1">Teachers Management</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">Manage and view all teachers in your school</p>
                </div>
            </div>
            <div class="header-actions d-flex flex-row gap-2 flex-shrink-0">
                <button type="button" class="btn btn-sm btn-white rounded-pill px-3 shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#teacherImportModal"
                    style="border:1.5px solid rgba(255,255,255,0.4); font-weight:600; font-size:13px; white-space:nowrap;">
                    <i class="fa-solid fa-file-excel me-1" style="color:#16a34a;"></i> Import / Export
                </button>
                <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn btn-sm btn-primary-modern rounded-pill px-3 shadow-sm"
                   style="font-size:13px; white-space:nowrap;">
                    <i class="fa-solid fa-plus me-1"></i> Add Teacher
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

        {{-- Search & Filter Section --}}
        <div class="search-card mb-4">
            <form action="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" method="GET" id="teacherFilterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label class="filter-label">Search Teacher</label>
                        <div class="input-group search-input-wrapper">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" class="form-control border-start-0 pe-4" 
                                   placeholder="Name, ID, Email, Phone..." value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search-btn" onclick="clearSearchField()" title="Clear Search">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <label class="filter-label">Subject</label>
                        <select name="subject_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Subjects</option>
                            @foreach($subjects ?? [] as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->code ? $subject->code . ' - ' : '' }}{{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6">
                        <label class="filter-label">Sort By</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary-modern flex-fill py-2 px-3 text-nowrap rounded-3">
                                <i class="fa-solid fa-filter me-1"></i> Filter
                            </button>
                            @if(request()->hasAny(['search', 'subject_id', 'sort']))
                                <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" 
                                   class="btn btn-light border py-2 px-3 rounded-3 text-danger flex-shrink-0" title="Reset Filters">
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
                    <span class="small text-muted me-1"><i class="fa-solid fa-sliders me-1"></i>Active Filters:</span>
                    @if(request('search'))
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-medium">
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ms-1 text-primary"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('subject_id'))
                        @php $activeSubject = ($subjects ?? collect())->firstWhere('id', request('subject_id')); @endphp
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-medium">
                            Subject: {{ $activeSubject?->name ?? 'Selected' }}
                            <a href="{{ request()->fullUrlWithQuery(['subject_id' => null]) }}" class="ms-1 text-success"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    @if(request('sort') && request('sort') !== 'newest')
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 fw-medium">
                            Sort: {{ request('sort') }}
                            <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="ms-1 text-info"><i class="fa-solid fa-xmark"></i></a>
                        </span>
                    @endif
                    <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="small text-danger ms-auto fw-semibold">
                        Clear All
                    </a>
                </div>
            @endif
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card">
            <div class="table-header px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="table-title mb-0"><i class="fa-solid fa-chalkboard-user me-2 text-primary"></i> Teacher Directory</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold" style="font-size:12px;">
                        {{ method_exists($teachers, 'total') ? $teachers->total() : count($teachers) }} Teachers
                    </span>
                </div>
            </div>

            @if($teachers->count() > 0)
                {{-- DESKTOP VIEW: Clean Table (Visible on Tablets & Laptops >= md) --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table edu-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Teacher Info</th>
                                <th>ID & Subject</th>
                                <th>Contact Info</th>
                                <th>Qualification</th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" 
                                             alt="{{ $teacher->name }}" class="teacher-avatar-ring">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $teacher->name }}</div>
                                            <div class="small text-muted"><i class="fa-solid fa-user-tag me-1 opacity-50"></i>{{ $teacher->designation ?? 'Teacher' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="teacher-id-badge mb-1">{{ $teacher->teacher_id }}</span>
                                    <div class="small fw-semibold text-primary"><i class="fa-solid fa-book-open me-1 opacity-75"></i>{{ $teacher->subject?->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    @if($teacher->email)
                                        <div class="small mb-1"><a href="mailto:{{ $teacher->email }}" class="text-secondary text-decoration-none"><i class="fa-regular fa-envelope me-1 text-primary"></i> {{ $teacher->email }}</a></div>
                                    @endif
                                    @if($teacher->phone)
                                        <div class="small"><a href="tel:{{ $teacher->phone }}" class="text-secondary text-decoration-none"><i class="fa-solid fa-phone me-1 text-success"></i> {{ $teacher->phone }}</a></div>
                                    @endif
                                </td>
                                <td>
                                    <span class="small fw-medium text-dark">{{ $teacher->qualification ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('teachers.show', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn btn-icon-sm btn-soft-primary" title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn btn-icon-sm btn-soft-warning" title="Edit Teacher">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', ['tenant' => auth()->user()?->school?->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-icon-sm btn-soft-danger" title="Delete Teacher">
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

                {{-- MOBILE VIEW: Ultra-Clean Spacious Card Grid (Visible on Mobile Screens < md) --}}
                <div class="d-block d-md-none p-3">
                    <div class="row g-3">
                        @foreach($teachers as $teacher)
                        <div class="col-12">
                            <div class="teacher-mobile-card">
                                {{-- Top Header Row: Photo, Name, ID Badge --}}
                                <div class="d-flex align-items-center justify-content-between mb-3 gap-2">
                                    <div class="d-flex align-items-center gap-2.5 min-w-0" style="min-width: 0;">
                                        <img src="{{ $teacher->photo ? asset($teacher->photo) : asset('assets/images/profile.webp') }}" 
                                             alt="{{ $teacher->name }}" class="teacher-avatar-ring flex-shrink-0">
                                        <div class="min-w-0" style="min-width: 0;">
                                            <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size:14.5px;">{{ $teacher->name }}</h6>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2.5 py-0.5 mt-1" style="font-size:10px;">
                                                {{ $teacher->designation ?? 'Teacher' }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="teacher-id-badge flex-shrink-0">{{ $teacher->teacher_id }}</span>
                                </div>

                                {{-- Middle Info Box: Subject, Qualification, Phone, Email --}}
                                <div class="teacher-info-box">
                                    {{-- Subject Row --}}
                                    <div class="teacher-info-row">
                                        <div class="teacher-info-label">
                                            <i class="fa-solid fa-book-open text-primary teacher-info-icon"></i>
                                            <span>Subject:</span>
                                        </div>
                                        <span class="teacher-info-value fw-semibold text-primary">
                                            {{ $teacher->subject?->name ?? 'N/A' }}
                                        </span>
                                    </div>

                                    {{-- Qualification Row --}}
                                    @if($teacher->qualification)
                                        <div class="teacher-info-row">
                                            <div class="teacher-info-label">
                                                <i class="fa-solid fa-graduation-cap text-success teacher-info-icon"></i>
                                                <span>Qualification:</span>
                                            </div>
                                            <span class="teacher-info-value fw-medium text-dark">
                                                {{ $teacher->qualification }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Phone Row --}}
                                    @if($teacher->phone)
                                        <div class="teacher-info-row">
                                            <div class="teacher-info-label">
                                                <i class="fa-solid fa-phone text-success teacher-info-icon"></i>
                                                <span>Phone:</span>
                                            </div>
                                            <a href="tel:{{ $teacher->phone }}" class="teacher-info-value fw-medium text-dark text-decoration-none">
                                                {{ $teacher->phone }}
                                            </a>
                                        </div>
                                    @endif

                                    {{-- Email Row --}}
                                    @if($teacher->email)
                                        <div class="teacher-info-row">
                                            <div class="teacher-info-label">
                                                <i class="fa-regular fa-envelope text-primary teacher-info-icon"></i>
                                                <span>Email:</span>
                                            </div>
                                            <a href="mailto:{{ $teacher->email }}" class="teacher-info-value fw-medium text-dark text-decoration-none">
                                                {{ $teacher->email }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                {{-- Bottom Action Row --}}
                                <div class="d-flex align-items-center justify-content-between pt-2.5 border-top">
                                    <span class="small text-muted fw-medium" style="font-size:11.5px;">Quick Actions</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('teachers.show', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn btn-icon-sm btn-soft-primary" title="View Details">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teachers.edit', ['tenant' => auth()->user()?->school?->slug, 'teacher' => $teacher->id]) }}" 
                                           class="btn btn-icon-sm btn-soft-warning" title="Edit Teacher">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', ['tenant' => auth()->user()?->school?->slug,'teacher' => $teacher->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-icon-sm btn-soft-danger" title="Delete Teacher">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
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
                        <h5 class="fw-bold text-dark mb-1">No Teachers Found</h5>
                        <p class="text-muted small mb-3">
                            @if(request()->hasAny(['search', 'subject_id', 'sort']))
                                No teachers match your specified filter criteria.
                            @else
                                No teacher records available in the system.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'subject_id', 'sort']))
                            <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4">
                                <i class="fa-solid fa-rotate-left me-1"></i> Clear Filters
                            </a>
                        @else
                            <a href="{{ route('teachers.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-primary-modern rounded-pill px-4">
                                <i class="fa-solid fa-plus me-1"></i> Add Your First Teacher
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
            title: 'Are you sure?',
            text: "Do you want to delete this teacher?",
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