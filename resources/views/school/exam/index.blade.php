@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═══════════════════════════════════════════════
           EXAMS MANAGEMENT — PREMIUM DESIGN STYLES
        ═══════════════════════════════════════════════ */
        
        /* Stats Summary Cards in Header */
        .exam-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
        }
        .exam-stat-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
        }
        .exam-stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .exam-stat-val {
            font-size: 1.5rem; font-weight: 800; line-height: 1;
        }
        .exam-stat-lbl {
            font-size: 0.76rem; opacity: 0.85; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* Filter Bar Card */
        .exam-filter-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(15,23,42,0.03);
        }

        /* Compact Exam Table Styles */
        .desktop-exam-table .table th {
            padding: 9px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            white-space: nowrap;
            color: #475569;
            background-color: #f8fafc;
        }
        .desktop-exam-table .table td {
            padding: 8px 10px;
            vertical-align: middle;
            font-size: 0.8rem;
        }

        /* State Badges */
        .badge-state {
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
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
            width: 30px; height: 30px;
            border-radius: 7px;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 0.78rem;
        }
        .btn-act-edit { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
        .btn-act-edit:hover { background: #3b82f6; color: #fff; }
        .btn-act-del  { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
        .btn-act-del:hover  { background: #ef4444; color: #fff; }

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
            /* Filter bar stacks on mobile */
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
                        <div class="btn-act btn-act-edit" style="width:36px; height:36px; border-radius:10px;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h5 class="fw-800 mb-0 text-dark" style="font-size:1.05rem;">Create New Exam</h5>
                    </div>

                    <form action="{{ route('exams.store', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST">
                        @csrf

                        {{-- Exam Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-700 text-secondary small">
                                <i class="fa-solid fa-pen text-indigo-500 me-1"></i>Exam Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="e.g., 1st Term Examination 2026"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                    <i class="fa-solid fa-play me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-700 text-secondary small">
                                    <i class="fa-solid fa-flag-checkered me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-700">
                            <i class="fa-solid fa-circle-check me-2"></i>Create Exam
                        </button>
                    </form>
                </div>
            </div>

            {{-- ════ RIGHT COLUMN: EXAMS LIST TABLE ════ --}}
            <div class="col-lg-8">

                {{-- Filter & Search Bar --}}
                <div class="exam-filter-card">
                    <form method="GET" action="{{ route('exams.index', ['tenant' => auth()->user()?->school?->slug]) }}" id="filterForm">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search exam name..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <select name="year_id" class="form-select bg-light" onchange="this.form.submit()">
                                    <option value="">All Sessions</option>
                                    @foreach($years as $y)
                                        <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <select name="category_id" class="form-select bg-light" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2">
                                <a href="{{ route('exams.index', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-outline-secondary w-100" title="Reset Filters">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Exams Card Table --}}
                <div class="data-table-card">
                    <div class="table-header d-flex align-items-center justify-content-between">
                        <h5 class="table-title mb-0">
                            <i class="fa-solid fa-list-check me-2" style="color:#6366f1;"></i>Exams List
                        </h5>
                        <span class="badge bg-light text-muted border px-3 py-1" style="border-radius:10px;">
                            {{ $exams->total() }} Records
                        </span>
                    </div>

                    {{-- ── DESKTOP TABLE ── --}}
                    <div class="table-responsive desktop-exam-table">
                        <table class="table data-table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Category</th>
                                    <th>Session</th>
                                    <th>Schedule</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Active</th>
                                    <th class="text-center">Result Published</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                <tr>
                                    <td>
                                        <span class="fw-semibold text-dark d-block" style="font-size:0.83rem; white-space:nowrap;">{{ $exam->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size:0.7rem; font-weight: 500; white-space:nowrap;">
                                            {{ $exam->category?->name ?? 'All' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-secondary" style="font-size:0.78rem; white-space:nowrap;">
                                            {{ $exam->academicYear?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size:0.72rem; white-space:nowrap; line-height: 1.35;">
                                            <span><i class="fa-regular fa-calendar me-1 text-primary"></i>{{ \Carbon\Carbon::parse($exam->start_date)->format('d M, Y') }}</span>
                                            <br>
                                            <span class="text-muted"><i class="fa-solid fa-arrow-right-long me-1 opacity-50"></i>{{ \Carbon\Carbon::parse($exam->end_date)->format('d M, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php $state = $exam->exam_state; @endphp
                                        @if($state == 'ongoing')
                                            <span class="badge-state badge-ongoing statusBadge" data-id="{{ $exam->id }}" data-year="{{ $exam->year_id }}">
                                                <i class="fa-solid fa-circle-dot"></i> Ongoing
                                            </span>
                                        @elseif($state == 'upcoming')
                                            <span class="badge-state badge-upcoming statusBadge" data-id="{{ $exam->id }}" data-year="{{ $exam->year_id }}">
                                                <i class="fa-solid fa-clock"></i> Upcoming
                                            </span>
                                        @elseif($state == 'finished')
                                            <span class="badge-state badge-finished statusBadge" data-id="{{ $exam->id }}" data-year="{{ $exam->year_id }}">
                                                <i class="fa-solid fa-flag-checkered"></i> Finished
                                            </span>
                                        @else
                                            <span class="badge-state badge-inactive statusBadge" data-id="{{ $exam->id }}" data-year="{{ $exam->year_id }}">
                                                <i class="fa-solid fa-ban"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input statusToggle"
                                                   type="checkbox"
                                                   data-id="{{ $exam->id }}"
                                                   data-year="{{ $exam->year_id }}"
                                                   {{ $exam->status ? 'checked' : '' }}
                                                   title="Toggle Active Exam">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input resultToggle"
                                                   type="checkbox"
                                                   role="switch"
                                                   data-id="{{ $exam->id }}"
                                                   {{ $exam->is_published ? 'checked' : '' }}
                                                   title="Publish/Unpublish Result">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn-act btn-act-edit editBtn" data-id="{{ $exam->id }}" title="Edit Exam">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form action="{{ route('exams.destroy', ['tenant' => auth()->user()?->school?->slug, 'exam' => $exam->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn-act btn-act-del" title="Delete Exam">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fa-solid fa-folder-open fa-3x mb-3" style="color:#cbd5e1;"></i>
                                            <h6 class="fw-bold text-dark">No Exams Found</h6>
                                            <p class="text-muted small mb-0">Create your first exam using the form on the left.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- ── MOBILE CARDS ── --}}
                    <div class="p-3">
                        @forelse($exams as $exam)
                            @php $state = $exam->exam_state; @endphp
                            <div class="mobile-exam-card">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $exam->name }}</h6>
                                        <small class="text-muted">
                                            Session: <strong>{{ $exam->academicYear?->name ?? 'N/A' }}</strong> &nbsp;·&nbsp;
                                            Category: <strong>{{ $exam->category?->name ?? 'All' }}</strong>
                                        </small>
                                    </div>
                                    @if($state == 'ongoing')
                                        <span class="badge-state badge-ongoing">Ongoing</span>
                                    @elseif($state == 'upcoming')
                                        <span class="badge-state badge-upcoming">Upcoming</span>
                                    @elseif($state == 'finished')
                                        <span class="badge-state badge-finished">Finished</span>
                                    @else
                                        <span class="badge-state badge-inactive">Inactive</span>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-2 border-top border-bottom my-2 fs-7">
                                    <div>
                                        <small class="text-muted d-block">Start: {{ \Carbon\Carbon::parse($exam->start_date)->format('d M, Y') }}</small>
                                        <small class="text-muted d-block">End: {{ \Carbon\Carbon::parse($exam->end_date)->format('d M, Y') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="form-check form-switch d-inline-block me-2">
                                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $exam->id }}" data-year="{{ $exam->year_id }}" {{ $exam->status ? 'checked' : '' }}>
                                            <label class="small text-muted">Active</label>
                                        </div>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input resultToggle" type="checkbox" role="switch" data-id="{{ $exam->id }}" {{ $exam->is_published ? 'checked' : '' }}>
                                            <label class="small text-muted">Published</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-end gap-2 pt-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary editBtn" data-id="{{ $exam->id }}">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('exams.destroy', ['tenant' => auth()->user()?->school?->slug, 'exam' => $exam->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </button>
                                    </form>
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
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow:0 20px 50px rgba(0,0,0,0.15);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #334155); padding: 20px 24px;">
                <h5 class="modal-title fw-bold" id="editExamModalLabel"><i class="fa-solid fa-pen-to-square me-2" style="color:#818cf8;"></i> Edit Exam</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4" id="editBody">
                    <!-- Dynamic fields loaded by AJAX -->
                </div>
                <div class="modal-footer bg-light p-3 border-0">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-bold" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                    <button type="submit" class="btn btn-primary-gradient px-4 fw-bold" style="border-radius: 10px;">Save Changes</button>
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
                timer: 1800,
                showConfirmButton: false,
                customClass: { popup: 'rounded-4' }
            });
        @endif

        // Active Status toggle
        $(document).on('change', '.statusToggle', function () {
            let examId = $(this).data('id');
            let yearId = $(this).data('year');
            let toggle = $(this);

            $.ajax({
                url: "{{ route('exams.status', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}".replace(':id', examId),
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
                url: "{{ route('exams.publish', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}".replace(':id', examId),
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

            $.get("{{ route('exams.edit', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}".replace(':id', id),
                function(data){
                    let html = `
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-secondary">Exam Name</label>
                            <input type="text" name="name" class="form-control" value="${data.name}" required>
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
                                <input type="date" name="start_date" class="form-control" value="${data.start_date}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small text-secondary">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="${data.end_date}" required>
                            </div>
                        </div>
                    `;

                    $('#editBody').html(html);
                    $('#editForm').attr('action', "{{ route('exams.update', ['tenant' => auth()->user()?->school?->slug, 'exam' => ':id']) }}".replace(':id', id));
                    $('#editExamModal').modal('show');
                }
            );
        });
    </script>
@endsection