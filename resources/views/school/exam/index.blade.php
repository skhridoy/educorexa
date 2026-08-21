@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Modern Design System Overrides for Exams Page */
        .exam-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .exam-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(8px);
        }
        .exam-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }
        .exam-stat-val {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .exam-stat-lbl {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Filter Card Toolbar */
        .exam-filter-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
        }
        [data-bs-theme="dark"] .exam-filter-card,
        body.dark-mode .exam-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }

        /* Custom Badges */
        .badge-status {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        .badge-ongoing  { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-upcoming { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .badge-finished { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .badge-inactive { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

        /* Switches */
        .form-switch .form-check-input {
            width: 2.2em;
            height: 1.1em;
            cursor: pointer;
        }
        .form-switch .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        /* Actions Buttons */
        .btn-act {
            width: 28px; height: 28px;
            border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.72rem;
        }
        .btn-act-edit { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
        .btn-act-edit:hover { background: #3b82f6; color: #fff; }
        .btn-act-del  { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
        .btn-act-del:hover  { background: #ef4444; color: #fff; }

        /* Preset Chips */
        .preset-chip {
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 3px 8px;
            font-size: 0.72rem;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .preset-chip:hover {
            background: #e0e7ff;
            border-color: #818cf8;
            color: #4338ca;
        }
        [data-bs-theme="dark"] .preset-chip,
        body.dark-mode .preset-chip {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }
        .clone-exam-item {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            background: #ffffff;
            transition: all 0.2s ease;
        }
        .clone-exam-item:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        [data-bs-theme="dark"] .clone-exam-item,
        body.dark-mode .clone-exam-item {
            background: #111c35 !important;
            border-color: #1e2c4a !important;
        }

        /* Mobile Card view for small screens */
        .mobile-exam-card {
            display: none;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        @media (max-width: 991.98px) {
            .exam-stats-bar { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 767.98px) {
            .exam-stats-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .exam-stat-card { padding: 10px 12px; gap: 10px; }
            .exam-stat-icon { width: 36px; height: 36px; font-size: 1.1rem; }
            .exam-stat-val  { font-size: 1.25rem; }
            .exam-stat-lbl  { font-size: 0.7rem; }
            .desktop-exam-table { display: none !important; }
            .mobile-exam-card   { display: block !important; }
            .exam-filter-card .row > [class*="col-"] { margin-bottom: 4px; }
        }
        @media (max-width: 575.98px) {
            .exam-stats-bar { grid-template-columns: 1fr 1fr; gap: 8px; }
            .exam-stat-card { padding: 9px 10px; }
            .exam-stat-val  { font-size: 1.1rem; }
            .page-title     { font-size: 1.35rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ════ HERO HEADER BANNER ════ --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-start align-items-md-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title"><i class="fa-solid fa-pen-to-square me-2"></i>Exams Management</h1>
                        <p class="mb-0 opacity-85">Create, schedule and manage examinations &amp; result publishing</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0 flex-wrap">
                        <button type="button" class="btn btn-sm btn-light fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#cloneExamModal" style="border-radius: 8px; font-size: 0.8rem; padding: 6px 12px;">
                            <i class="fa-solid fa-copy me-1 text-primary"></i> Copy from Previous Year
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-light fw-bold" data-bs-toggle="modal" data-bs-target="#bulkGenerateModal" style="border-radius: 8px; font-size: 0.8rem; padding: 6px 12px; background: rgba(255,255,255,0.12);">
                            <i class="fa-solid fa-wand-magic-sparkles me-1 text-warning"></i> Auto-Generate Standard Exams
                        </button>
                    </div>
                </div>

                {{-- Header Live Stats Bar --}}
                <div class="exam-stats-bar">
                    <div class="exam-stat-card">
                        <div class="exam-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div>
                            <div class="exam-stat-val">{{ $allExamsCount ?? count($exams) }}</div>
                            <div class="exam-stat-lbl">Total Exams</div>
                        </div>
                    </div>
                    <div class="exam-stat-card">
                        <div class="exam-stat-icon" style="background:rgba(34,197,94,0.3);"><i class="fa-solid fa-circle-check"></i></div>
                        <div>
                            <div class="exam-stat-val">{{ $activeExamsCount ?? 0 }}</div>
                            <div class="exam-stat-lbl">Active Exams</div>
                        </div>
                    </div>
                    <div class="exam-stat-card">
                        <div class="exam-stat-icon" style="background:rgba(251,191,36,0.3);"><i class="fa-solid fa-square-poll-vertical"></i></div>
                        <div>
                            <div class="exam-stat-val">{{ $publishedCount ?? 0 }}</div>
                            <div class="exam-stat-lbl">Results Published</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- ════ LEFT COLUMN: CREATE EXAM FORM ════ --}}
            <div class="col-lg-4 mb-4">
                <div class="form-card h-100">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                        <div class="btn-act btn-act-edit" style="width:32px; height:32px; border-radius:8px;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h5 class="fw-800 mb-0 text-dark" style="font-size:1rem;">Create New Exam</h5>
                    </div>

                    <form action="{{ route('exams.store', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" method="POST">
                        @csrf

                        {{-- Exam Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-700 text-secondary small d-flex align-items-center justify-content-between">
                                <span><i class="fa-solid fa-pen text-indigo-500 me-1"></i>Exam Name <span class="text-danger">*</span></span>
                                <span class="text-muted" style="font-size: 0.7rem;">Quick Suggestions:</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="e.g., 1st Term Examination 2026"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            {{-- Suggestion Chips --}}
                            <div class="d-flex flex-wrap gap-1.5 mt-2">
                                <button type="button" class="preset-chip" data-name="১ম সাময়িক পরীক্ষা (1st Term Exam)">+ 1st Term</button>
                                <button type="button" class="preset-chip" data-name="অর্ধ-বার্ষিক পরীক্ষা (Half Yearly Exam)">+ Half Yearly</button>
                                <button type="button" class="preset-chip" data-name="২য় সাময়িক পরীক্ষা (2nd Term Exam)">+ 2nd Term</button>
                                <button type="button" class="preset-chip" data-name="বার্ষিক পরীক্ষা (Annual Exam)">+ Annual Exam</button>
                                <button type="button" class="preset-chip" data-name="প্রাক-নির্বাচনী পরীক্ষা (Pre-Test Exam)">+ Pre-Test</button>
                                <button type="button" class="preset-chip" data-name="নির্বাচনী পরীক্ষা (Test Exam)">+ Test Exam</button>
                            </div>
                        </div>

                        {{-- Academic Year --}}
                        <div class="mb-3">
                            <label for="year_id" class="form-label fw-700 text-secondary small">
                                <i class="fa-solid fa-calendar-days me-1"></i>Academic Year <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('year_id') is-invalid @enderror" id="year_id" name="year_id" required>
                                <option value="" selected disabled>-- Select Year --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}" {{ old('year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }} @if($year->is_active) (Active) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="school_category_id" class="form-label fw-700 text-secondary small">
                                <i class="fa-solid fa-tags me-1"></i>School Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('school_category_id') is-invalid @enderror" name="school_category_id" required>
                                <option value="" selected disabled>-- Select Category --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('school_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Start & End Dates --}}
                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label for="start_date" class="form-label fw-700 text-secondary small">
                                    <i class="fa-regular fa-clock text-success me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ old('start_date') }}"
                                       required>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-700 text-secondary small">
                                    <i class="fa-regular fa-circle-check text-danger me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       id="end_date"
                                       name="end_date"
                                       value="{{ old('end_date') }}"
                                       required>
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold shadow-sm" style="border-radius: 8px; font-size: 0.85rem;">
                            <i class="fa-solid fa-plus-circle me-1"></i> Create Exam
                        </button>
                    </form>
                </div>
            </div>

            {{-- ════ RIGHT COLUMN: EXAM LIST ════ --}}
            <div class="col-lg-8 mb-4">
                {{-- Filter Toolbar --}}
                <div class="exam-filter-card">
                    <form method="GET" action="{{ route('exams.index', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search exam name..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <select name="year_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Academic Years</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->id }}" {{ request('year_id') == $year->id ? 'selected' : '' }}>
                                            {{ $year->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2 d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-sm flex-grow-1" style="border-radius:6px;">Filter</button>
                                <a href="{{ route('exams.index', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" class="btn btn-outline-secondary btn-sm" title="Reset" style="border-radius:6px;">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table Card --}}
                <div class="data-table-card shadow-sm">
                    {{-- Desktop View --}}
                    <div class="desktop-exam-table table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 45px;" class="text-center">#</th>
                                    <th>Exam Details</th>
                                    <th>Duration</th>
                                    <th class="text-center">Time Status</th>
                                    <th class="text-center">Active State</th>
                                    <th class="text-center">Result</th>
                                    <th class="text-end pe-3" style="width: 90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                    <tr>
                                        <td class="text-center fw-bold text-muted small">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $exam->name }}</div>
                                            <div class="d-flex align-items-center gap-2 mt-0.5">
                                                <span class="badge bg-soft-primary text-primary" style="font-size: 0.72rem; padding: 2px 6px;">
                                                    <i class="fa-solid fa-calendar-days me-1"></i>{{ $exam->academicYear->name ?? 'N/A' }}
                                                </span>
                                                @if($exam->category)
                                                    <span class="badge bg-soft-info text-info" style="font-size: 0.72rem; padding: 2px 6px;">
                                                        <i class="fa-solid fa-tag me-1"></i>{{ $exam->category->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-muted">
                                                <div><i class="fa-regular fa-clock text-success me-1"></i>{{ \Carbon\Carbon::parse($exam->start_date)->format('d M, Y') }}</div>
                                                <div><i class="fa-regular fa-circle-check text-danger me-1"></i>{{ \Carbon\Carbon::parse($exam->end_date)->format('d M, Y') }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $state = $exam->exam_state;
                                                $badgeClass = match($state) {
                                                    'ongoing'  => 'badge-ongoing',
                                                    'upcoming' => 'badge-upcoming',
                                                    'finished' => 'badge-finished',
                                                    default    => 'badge-inactive',
                                                };
                                                $stateText = match($state) {
                                                    'ongoing'  => 'Ongoing',
                                                    'upcoming' => 'Upcoming',
                                                    'finished' => 'Finished',
                                                    default    => 'Inactive',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $badgeClass }}">
                                                <i class="fa-solid fa-circle" style="font-size:0.45rem;"></i> {{ $stateText }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input statusToggle"
                                                       type="checkbox"
                                                       data-id="{{ $exam->id }}"
                                                       data-year="{{ $exam->year_id }}"
                                                       {{ $exam->status == 1 ? 'checked' : '' }}
                                                       title="Toggle Active Exam">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input resultToggle"
                                                       type="checkbox"
                                                       data-id="{{ $exam->id }}"
                                                       {{ $exam->is_published ? 'checked' : '' }}
                                                       title="Toggle Result Publication">
                                            </div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button"
                                                        class="btn-act btn-act-edit editBtn"
                                                        data-id="{{ $exam->id }}"
                                                        title="Edit Exam">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>

                                                <form action="{{ route('exams.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => $exam->id]) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete(this)"
                                                            class="btn-act btn-act-del"
                                                            title="Delete Exam">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fa-solid fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                                                <p class="mb-0">No exams found for the selected criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="p-3 d-md-none">
                        @forelse ($exams as $exam)
                            <div class="mobile-exam-card">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $exam->name }}</h6>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <span class="badge bg-soft-primary text-primary" style="font-size: 0.7rem;">{{ $exam->academicYear->name ?? 'N/A' }}</span>
                                            @if($exam->category)
                                                <span class="badge bg-soft-info text-info" style="font-size: 0.7rem;">{{ $exam->category->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn-act btn-act-edit editBtn" data-id="{{ $exam->id }}"><i class="fa-solid fa-pen"></i></button>
                                        <form action="{{ route('exams.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => $exam->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn-act btn-act-del"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="small text-muted mb-2">
                                    <i class="fa-regular fa-calendar-check text-primary me-1"></i>
                                    {{ \Carbon\Carbon::parse($exam->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($exam->end_date)->format('d M, Y') }}
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <div>
                                        <span class="small text-muted me-1">Active:</span>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $exam->id }}" {{ $exam->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="small text-muted me-1">Publish:</span>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input resultToggle" type="checkbox" data-id="{{ $exam->id }}" {{ $exam->is_published ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                No exams found.
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($exams->hasPages())
                        <div class="p-3 border-top">
                            {{ $exams->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Exam Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="editExamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow:0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #334155); padding: 16px 20px;">
                <h5 class="modal-title fw-bold" id="editExamModalLabel"><i class="fa-solid fa-pen-to-square me-2" style="color:#818cf8;"></i> Edit Exam</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3.5" id="editBody">
                    <!-- Dynamic fields loaded by AJAX -->
                </div>
                <div class="modal-footer bg-light p-2.5 border-0">
                    <button type="button" class="btn btn-outline-secondary px-3 py-1.5 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.84rem;">Cancel</button>
                    <button type="submit" class="btn btn-primary-gradient px-3 py-1.5 fw-bold" style="border-radius: 8px; font-size: 0.84rem;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Copy / Clone from Previous Year Modal -->
<div class="modal fade" id="cloneExamModal" tabindex="-1" aria-labelledby="cloneExamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #334155); padding: 16px 20px;">
                <h5 class="modal-title fw-bold" id="cloneExamModalLabel">
                    <i class="fa-solid fa-copy me-2 text-primary"></i> Copy Exams from Previous Academic Year
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('exams.clone-year', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 rounded-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-circle-info fa-lg"></i>
                        <div>আগের কোনো শিক্ষাবর্ষের সকল বা নির্বাচিত পরীক্ষাসমূহ নতুন শিক্ষাবর্ষে ১-ক্লিকে কপি করুন। ডুপ্লিকেট পরীক্ষা স্বয়ংক্রিয়ভাবে বাদ দেওয়া হবে।</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="from_year_id" class="form-label fw-bold small text-secondary">
                                <i class="fa-solid fa-calendar-minus text-warning me-1"></i> From Academic Year (যে বছর থেকে কপি করবেন) <span class="text-danger">*</span>
                            </label>
                            <select name="from_year_id" id="from_year_id" class="form-select" required>
                                <option value="" selected disabled>-- Select Source Year --</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }} @if($year->is_active) (Active) @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="to_year_id" class="form-label fw-bold small text-secondary">
                                <i class="fa-solid fa-calendar-plus text-success me-1"></i> To Academic Year (যে নতুন বছরে কপি করবেন) <span class="text-danger">*</span>
                            </label>
                            <select name="to_year_id" id="to_year_id" class="form-select" required>
                                <option value="" selected disabled>-- Select Target Year --</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }} @if($year->is_active) (Active) @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Exam Selector Container --}}
                    <div id="cloneExamsWrapper" style="display: none;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold small text-dark mb-0">Select Exams to Copy:</label>
                            <button type="button" id="selectAllCloneBtn" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" style="font-size: 0.78rem;">
                                Select / Deselect All
                            </button>
                        </div>
                        <div id="cloneExamsList" class="d-flex flex-column gap-2" style="max-height: 250px; overflow-y: auto;">
                            <!-- Populated via AJAX -->
                        </div>
                    </div>
                    <div id="cloneLoadingSpinner" class="text-center py-4 text-muted" style="display: none;">
                        <i class="fa-solid fa-spinner fa-spin fa-2x mb-2 text-primary"></i>
                        <p class="small mb-0">পরীক্ষাসমূহ লোড হচ্ছে...</p>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2.5 border-0">
                    <button type="button" class="btn btn-outline-secondary px-3 py-1.5 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.84rem;">Cancel</button>
                    <button type="submit" id="cloneSubmitBtn" class="btn btn-primary-gradient px-4 py-1.5 fw-bold" style="border-radius: 8px; font-size: 0.84rem;" disabled>
                        <i class="fa-solid fa-copy me-1"></i> Copy Selected Exams
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Generate Standard Exams Modal -->
<div class="modal fade" id="bulkGenerateModal" tabindex="-1" aria-labelledby="bulkGenerateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #334155); padding: 16px 20px;">
                <h5 class="modal-title fw-bold" id="bulkGenerateModalLabel">
                    <i class="fa-solid fa-wand-magic-sparkles me-2 text-warning"></i> Auto-Generate Standard Exams
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('exams.bulk-generate', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant'))]) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-success border-0 rounded-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-wand-magic-sparkles fa-lg"></i>
                        <div>নতুন শিক্ষাবর্ষের সকল স্ট্যান্ডার্ড পরীক্ষা (১ম সাময়িক, অর্ধ-বার্ষিক, বার্ষিক ইত্যাদি) ১-ক্লিকে স্বয়ংক্রিয়ভাবে তৈরি করুন।</div>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_year_id" class="form-label fw-bold small text-secondary">
                            Academic Year <span class="text-danger">*</span>
                        </label>
                        <select name="year_id" id="bulk_year_id" class="form-select" required>
                            <option value="" selected disabled>-- Select Academic Year --</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }} @if($year->is_active) (Active) @endif</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_category_id" class="form-label fw-bold small text-secondary">
                            School Category <span class="text-danger">*</span>
                        </label>
                        <select name="school_category_id" id="bulk_category_id" class="form-select" required>
                            <option value="" selected disabled>-- Select School Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Select Standard Exams to Generate:</label>
                        <div class="d-flex flex-column gap-2">
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="1st_term" class="form-check-input mt-0" checked>
                                <span class="fw-semibold small">১ম সাময়িক পরীক্ষা (1st Term Examination)</span>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="half_yearly" class="form-check-input mt-0" checked>
                                <span class="fw-semibold small">অর্ধ-বার্ষিক পরীক্ষা (Half Yearly Examination)</span>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="2nd_term" class="form-check-input mt-0" checked>
                                <span class="fw-semibold small">২য় সাময়িক পরীক্ষা (2nd Term Examination)</span>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="annual" class="form-check-input mt-0" checked>
                                <span class="fw-semibold small">বার্ষিক পরীক্ষা (Annual Examination)</span>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="pre_test" class="form-check-input mt-0">
                                <span class="fw-semibold small">প্রাক-নির্বাচনী পরীক্ষা (Pre-Test Examination)</span>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-light cursor-pointer">
                                <input type="checkbox" name="presets[]" value="test_exam" class="form-check-input mt-0">
                                <span class="fw-semibold small">নির্বাচনী পরীক্ষা (Test Examination)</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2.5 border-0">
                    <button type="button" class="btn btn-outline-secondary px-3 py-1.5 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.84rem;">Cancel</button>
                    <button type="submit" class="btn btn-primary-gradient px-4 py-1.5 fw-bold" style="border-radius: 8px; font-size: 0.84rem;">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Generate Exams
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this exam?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-4' }
            });
        @endif

        // Quick Suggestion Chips Handler
        $(document).on('click', '.preset-chip', function() {
            let name = $(this).data('name');
            let selectedYearText = $('#year_id option:selected').text().trim().replace('(Active)', '').trim();
            if (selectedYearText && !isNaN(selectedYearText)) {
                $('#name').val(name + ' ' + selectedYearText);
            } else {
                $('#name').val(name);
            }
        });

        // Active Status toggle
        $(document).on('change', '.statusToggle', function () {
            let examId = $(this).data('id');
            let yearId = $(this).data('year');
            let toggle = $(this);

            $.ajax({
                url: "{{ route('exams.status', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => ':id']) }}".replace(':id', examId),
                type: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: 'Active exam state updated successfully.',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else if (response.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cannot Change Status',
                            text: response.message,
                            confirmButtonColor: '#4f46e5'
                        });
                        toggle.prop('checked', !toggle.is(':checked'));
                    }
                }
            });
        });

        // Result publish toggle
        $(document).on('change', '.resultToggle', function () {
            let examId = $(this).data('id');
            let toggle = $(this);

            $.ajax({
                url: "{{ route('exams.publish', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => ':id']) }}".replace(':id', examId),
                type: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message || 'Result Status Updated',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        toggle.prop('checked', !toggle.is(':checked'));
                    }
                },
                error: function () {
                    toggle.prop('checked', !toggle.is(':checked'));
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update result publish status.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });

        // Edit button click -> load AJAX modal
        $(document).on('click', '.editBtn', function(){
            let id = $(this).data('id');
            let editUrl = "{{ route('exams.edit', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => ':id']) }}".replace(':id', id);

            $.get(editUrl, function(data){
                let startDate = data.start_date ? data.start_date.split('T')[0].split(' ')[0] : '';
                let endDate = data.end_date ? data.end_date.split('T')[0].split(' ')[0] : '';

                let html = `
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Exam Name</label>
                        <input type="text" name="name" class="form-control" value="${data.name || ''}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Academic Year</label>
                        <select name="year_id" class="form-select" required>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" ${data.year_id == {{ $year->id }} ? 'selected' : ''}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">School Category</label>
                        <select name="school_category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" ${data.school_category_id == {{ $cat->id }} ? 'selected' : ''}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-secondary">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="${startDate}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-secondary">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="${endDate}" required>
                        </div>
                    </div>
                `;

                $('#editBody').html(html);
                let updateUrl = "{{ route('exams.update', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'exam' => ':id']) }}".replace(':id', id);
                $('#editForm').attr('action', updateUrl);
                $('#editExamModal').modal('show');
            });
        });

        // Clone Modal: Load source year's exams on change
        $('#from_year_id').on('change', function() {
            let fromYearId = $(this).val();
            if (!fromYearId) return;

            $('#cloneLoadingSpinner').show();
            $('#cloneExamsWrapper').hide();
            $('#cloneSubmitBtn').prop('disabled', true);

            let url = "{{ route('exams.by-year', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'yearId' => ':id']) }}".replace(':id', fromYearId);

            $.get(url, function(exams) {
                $('#cloneLoadingSpinner').hide();
                let listHtml = '';
                if (exams.length > 0) {
                    exams.forEach(function(exam) {
                        let catName = exam.category ? exam.category.name : 'All';
                        listHtml += `
                            <label class="clone-exam-item d-flex align-items-center justify-content-between gap-2 cursor-pointer mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="checkbox" name="exam_ids[]" value="${exam.id}" class="form-check-input clone-checkbox mt-0" checked>
                                    <div>
                                        <div class="fw-bold text-dark small">${exam.name}</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Category: <span class="badge bg-soft-info text-info">${catName}</span></div>
                                    </div>
                                </div>
                                <span class="badge bg-soft-secondary text-secondary" style="font-size: 0.7rem;">
                                    ${exam.start_date || ''} - ${exam.end_date || ''}
                                </span>
                            </label>
                        `;
                    });
                    $('#cloneExamsList').html(listHtml);
                    $('#cloneExamsWrapper').show();
                    $('#cloneSubmitBtn').prop('disabled', false);
                } else {
                    $('#cloneExamsList').html('<div class="text-center py-3 text-danger small">এই শিক্ষাবর্ষে কোনো পরীক্ষা পাওয়া যায়নি।</div>');
                    $('#cloneExamsWrapper').show();
                    $('#cloneSubmitBtn').prop('disabled', true);
                }
            }).fail(function() {
                $('#cloneLoadingSpinner').hide();
                $('#cloneExamsList').html('<div class="text-center py-3 text-danger small">পরীক্ষাসমূহ লোড করতে সমস্যা হয়েছে।</div>');
                $('#cloneExamsWrapper').show();
            });
        });

        // Toggle Select All in Clone Modal
        $('#selectAllCloneBtn').on('click', function() {
            let checkboxes = $('.clone-checkbox');
            let allChecked = checkboxes.filter(':checked').length === checkboxes.length;
            checkboxes.prop('checked', !allChecked);
        });
    </script>
@endsection