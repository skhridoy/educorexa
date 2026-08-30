@extends('layouts.school')

@section('customCSS')
<style>
    /* ══ HERO BANNER ══ */
    .entry-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        border-radius: 14px; padding: 18px 24px; margin-bottom: 14px;
        position: relative; overflow: hidden;
        box-shadow: 0 10px 25px rgba(15,23,42,0.14);
    }
    .entry-hero::before { content:''; position:absolute; top:-60px; right:-60px; width:160px; height:160px; background:rgba(99,102,241,0.12); border-radius:50%; }
    .entry-hero::after  { content:''; position:absolute; bottom:-40px; left:-30px; width:110px; height:110px; background:rgba(79,70,229,0.07); border-radius:50%; }
    .entry-hero-content { position: relative; z-index: 2; }
    .entry-hero-title { font-size:1.3rem; font-weight:800; color:#fff; margin:0 0 3px; letter-spacing:-0.4px; }
    .entry-hero-subtitle { font-size:0.78rem; color:rgba(255,255,255,0.68); margin:0; }
    .entry-hero-pill { display:inline-flex; align-items:center; gap:4px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); color:#a5b4fc; font-size:0.68rem; font-weight:700; padding:2px 9px; border-radius:20px; margin-top:6px; }

    /* ══ FILTER CARD ══ */
    .entry-filter-card { background:#fff; border:1px solid #f1f5f9; border-radius:14px; padding:14px 18px; margin-bottom:14px; box-shadow:0 3px 12px rgba(15,23,42,0.04); }
    .entry-filter-card .filter-label { font-size:0.64rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:5px; display:flex; align-items:center; gap:5px; }
    .entry-filter-card .form-select { border-radius:9px; border:1.5px solid #e2e8f0; padding:6px 10px; font-size:0.78rem; font-weight:500; background:#f8fafc; transition:all 0.2s cubic-bezier(0.4, 0, 0.2, 1); height:34px; }
    .entry-filter-card .form-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.12); background:#fff; }
    .btn-load-students {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        height: 34px;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #7c3aed 100%);
        color: #fff !important;
        border: none;
        border-radius: 9px;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }
    .btn-load-students:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.38);
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 50%, #6d28d9 100%);
    }
    .btn-load-students:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(79, 70, 229, 0.2);
    }
    .btn-hero-import {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 0.74rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-hero-import:hover {
        background: rgba(255, 255, 255, 0.22);
        border-color: rgba(255, 255, 255, 0.45);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }
    .active-filter-bar { display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-bottom:12px; }
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 0.66rem;
        font-weight: 700;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .filter-tag.green  { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
    .filter-tag.purple { background:#f5f3ff; color:#6d28d9; border-color:#ddd6fe; }

    /* ══ SIDE-BY-SIDE LAYOUT & SIDEBAR ══ */
    .mark-entry-row {
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: flex-start;
        width: 100%;
        max-width: 100%;
    }
    .mark-entry-main {
        flex: 1 1 0%;
        min-width: 0 !important;
        width: 0;
        max-width: 100% !important;
    }
    .submitted-sidebar {
        flex: 0 0 220px;
        width: 220px;
        min-width: 200px;
        max-width: 230px;
        position: sticky;
        top: 80px;
    }
    @media (max-width: 767.98px) {
        .mark-entry-row {
            flex-direction: column;
        }
        .mark-entry-main {
            width: 100%;
        }
        .submitted-sidebar {
            flex: 1 1 auto;
            width: 100%;
            max-width: 100%;
            order: -1;
            position: static;
            margin-bottom: 12px;
        }
    }
    .sidebar-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(15,23,42,0.04);
        overflow: hidden;
        width: 100%;
        max-width: 100%;
    }
    .sidebar-card-header { background:linear-gradient(135deg,#1e293b,#334155); padding:8px 10px; display:flex; align-items:center; justify-content:space-between; gap:6px; }
    .sidebar-card-header-title { color:#fff; font-size:0.75rem; font-weight:700; margin:0; display:flex; align-items:center; gap:5px; }
    .sidebar-count-badge { background:rgba(99,102,241,0.3); border:1px solid rgba(99,102,241,0.5); color:#a5b4fc; font-size:0.60rem; font-weight:700; padding:1px 6px; border-radius:20px; white-space:nowrap; }
    .sidebar-body { padding:6px; max-height:500px; overflow-y:auto; }
    .sidebar-body::-webkit-scrollbar { width:3px; }
    .sidebar-body::-webkit-scrollbar-track { background:#f8fafc; }
    .sidebar-body::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:3px; }
    .sub-item { display:flex; align-items:center; gap:6px; padding:6px 7px; border-radius:8px; margin-bottom:4px; border:1px solid transparent; cursor:pointer; transition:all 0.18s; background:#f8fafc; text-decoration:none; }
    .sub-item:hover { background:#f0f4ff; border-color:#c7d2fe; box-shadow:0 2px 6px rgba(99,102,241,0.08); transform:translateX(-1px); }
    .sub-item.active-subject { background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-color:#a78bfa; box-shadow:0 3px 8px rgba(124,58,237,0.12); }
    .sub-item-icon { width:24px; height:24px; border-radius:6px; background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.64rem; font-weight:800; flex-shrink:0; box-shadow:0 2px 4px rgba(79,70,229,0.18); }
    .sub-item.active-subject .sub-item-icon { background:linear-gradient(135deg,#7c3aed,#4f46e5); }
    .sub-item-info { flex:1; min-width:0; }
    .sub-item-name { font-size:0.72rem; font-weight:700; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:1px; }
    .sub-item.active-subject .sub-item-name { color:#5b21b6; }
    .sub-item-meta { display:flex; align-items:center; gap:3px; flex-wrap:wrap; }
    .sub-meta-tag { font-size:0.54rem; font-weight:600; padding:1px 4px; border-radius:3px; border:1px solid #e2e8f0; background:#fff; color:#64748b; white-space:nowrap; }
    .sub-meta-tag.entries-tag { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
    .sub-meta-tag.fm-tag      { background:#fff7ed; color:#c2410c; border-color:#fed7aa; }
    .sub-item-check { color:#16a34a; font-size:0.64rem; flex-shrink:0; }
    .sidebar-empty { text-align:center; padding:18px 10px; }
    .sidebar-empty-icon { width:34px; height:34px; border-radius:8px; background:linear-gradient(135deg,#f5f3ff,#ede9fe); color:#7c3aed; font-size:0.95rem; display:flex; align-items:center; justify-content:center; margin:0 auto 6px; }
    .sidebar-empty-text { font-size:0.68rem; color:#94a3b8; line-height:1.3; }
    .sidebar-footer { border-top:1px solid #f1f5f9; padding:6px 10px; background:#fafbff; }
    .sidebar-progress { display:flex; align-items:center; justify-content:space-between; margin-bottom:3px; }
    .sidebar-progress-label { font-size:0.60rem; font-weight:600; color:#64748b; }
    .sidebar-progress-pct   { font-size:0.60rem; font-weight:700; color:#4f46e5; }
    .progress-bar-track { height:3px; background:#e2e8f0; border-radius:6px; overflow:hidden; }
    .progress-bar-fill  { height:100%; background:linear-gradient(90deg,#4f46e5,#7c3aed); border-radius:6px; transition:width 0.5s ease; }
    .entry-empty-card { background:#fff; border:1.5px dashed #e2e8f0; border-radius:12px; padding:32px 16px; text-align:center; box-shadow:0 3px 12px rgba(15,23,42,0.03); }
    .entry-empty-icon { width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg,#f5f3ff,#ede9fe); color:#7c3aed; font-size:1.3rem; display:flex; align-items:center; justify-content:center; margin:0 auto 10px; }

    /* DARK MODE */
    body.dark-mode .entry-filter-card,[data-bs-theme="dark"] .entry-filter-card { background:#0c1427!important; border-color:#1a253b!important; }
    body.dark-mode .entry-filter-card .form-select,[data-bs-theme="dark"] .entry-filter-card .form-select { background:#060c18!important; border-color:#1a253b!important; color:#f8fafc!important; }
    body.dark-mode .entry-empty-card,[data-bs-theme="dark"] .entry-empty-card { background:#0c1427!important; border-color:#1a253b!important; }
    body.dark-mode .sidebar-card,[data-bs-theme="dark"] .sidebar-card { background:#0c1427!important; border-color:#1a253b!important; }
    body.dark-mode .sub-item,[data-bs-theme="dark"] .sub-item { background:#060c18!important; border-color:#1a253b!important; }
    body.dark-mode .sub-item:hover,[data-bs-theme="dark"] .sub-item:hover { background:#0f1e38!important; border-color:#4f46e5!important; }
    body.dark-mode .sub-item-name,[data-bs-theme="dark"] .sub-item-name { color:#f1f5f9!important; }
    body.dark-mode .sidebar-footer,[data-bs-theme="dark"] .sidebar-footer { background:#060c18!important; border-color:#1a253b!important; }
    @media (max-width:767.98px) { .entry-hero { padding:14px 12px; border-radius:10px; margin-bottom:12px; } .entry-hero-title { font-size:1.1rem; } .entry-filter-card { padding:10px; border-radius:10px; } }
    @media (max-width:399.98px) { .entry-hero-title { font-size:1rem; } }

    /* ══════════════════════════════════════════════
       COMPACT TABLE & CONTAINER OVERRIDES
    ══════════════════════════════════════════════ */
    .mark-entry-main .data-table-card {
        border-radius: 12px;
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }
    .mark-entry-main .entry-desktop-table {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .mark-entry-main .entry-table-header { padding: 8px 12px; }
    .mark-entry-main .entry-table-title   { font-size: 0.78rem; }

    /* thead row */
    .mark-entry-main .entry-data-table thead th {
        padding: 6px 7px;
        font-size: 0.58rem;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    /* tbody row */
    .mark-entry-main .entry-data-table tbody td {
        padding: 4px 6px;
        font-size: 0.72rem;
    }

    /* mark input box */
    .mark-entry-main .entry-mark-box {
        height: 22px !important;
        border-radius: 6px;
        width: auto !important;
        max-width: 52px;
    }
    .mark-entry-main .total-box-readonly .total-input {
        font-size: 0.62rem !important;
        font-weight: 700 !important;
        color: #4338ca !important;
    }
    .mark-entry-main .mark-input {
        width: 24px !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;
        padding: 0 1px !important;
    }
    .mark-entry-main .mark-input::placeholder {
        font-size: 0.54rem !important;
        font-weight: 500 !important;
        color: #94a3b8 !important;
        opacity: 0.9 !important;
    }
    .mark-entry-main .mark-denom {
        font-size: 0.48rem !important;
        padding: 0 3px !important;
    }

    /* grade pill */
    .mark-entry-main .grade-pill-entry {
        height: 20px;
        min-width: 24px;
        font-size: 0.58rem;
        border-radius: 6px;
        padding: 0 4px;
    }

    /* status toggle (Pill Switcher) */
    .mark-entry-main .entry-status-toggle {
        height: 24px;
        border-radius: 20px;
        background: #f1f5f9;
        padding: 2px;
        border: 1px solid #e2e8f0;
        gap: 2px;
    }
    .mark-entry-main .entry-status-toggle .est-btn {
        padding: 0 7px;
        font-size: 0.58rem;
        border-radius: 14px;
        gap: 3px;
    }

    /* student name / id / roll */
    .mark-entry-main .name-cell       { font-size: 0.72rem; font-weight: 600; white-space: nowrap; max-width: 120px; overflow: hidden; text-overflow: ellipsis; }
    .mark-entry-main .roll-cell       { font-size: 0.74rem; font-weight: 700; }
    .mark-entry-main .student-id-cell { font-size: 0.65rem; white-space: nowrap; }

    /* mobile card */
    .mark-entry-main .entry-student-card { padding: 8px 9px; border-radius: 10px; margin-bottom: 5px; }
    .mark-entry-main .esc-avatar         { width: 26px; height: 26px; font-size: 0.72rem; border-radius: 6px; }
    .mark-entry-main .esc-name           { font-size: 0.72rem; }
    .mark-entry-main .esc-tag            { font-size: 0.50rem; padding: 1px 3px; }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- HERO --}}
        <div class="entry-hero mb-4">
            <div class="entry-hero-content d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="entry-hero-title"><i class="fa-solid fa-file-signature me-2"></i>{{ __('Marks Entry') }}</h1>
                    <p class="entry-hero-subtitle">{{ __('Record and manage student academic performance') }}</p>
                    <div class="entry-hero-pill"><i class="fa-solid fa-bolt"></i> {{ __('Auto-saves on every input') }}</div>
                </div>
                <a href="{{ route('marks.import.form', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-hero-import">
                    <i class="fa-solid fa-file-arrow-up"></i> {{ __('Import Marks') }}
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="entry-filter-card mb-4">
            <form method="GET" action="{{ route('marks.index', ['tenant' => auth()->user()->school->slug]) }}">
                <div class="row align-items-end g-2">
                    <div class="col-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-file-pen"></i> {{ __('Exam Name') }}</label>
                        <select name="exam_id" class="form-select">
                            <option value="">{{ __('Select Exam') }}</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-chalkboard"></i> {{ __('Class') }}</label>
                        <select name="class_id" id="class_id" class="form-select">
                            <option value="">{{ __('Select Class') }}</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="filter-label"><i class="fa-solid fa-book-open"></i> {{ __('Subject') }}</label>
                        <select id="subject_id" name="subject_id" class="form-select">
                            <option value="">{{ __('Select Subject') }}</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="submit" class="btn-load-students">
                            <i class="fa-solid fa-arrows-rotate"></i> {{ __('Load Students') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <input type="hidden" id="hidden_class_id"   value="{{ $classId }}">
        <input type="hidden" id="hidden_exam_id"    value="{{ $examId }}">
        <input type="hidden" id="hidden_subject_id" value="{{ $subjectId }}">

        {{-- FILTER TAGS --}}
        @if($classId || $examId || $subjectId)
        <div class="active-filter-bar mb-3">
            @foreach($exams as $e)
                @if($e->id == $examId)
                    <span class="filter-tag purple"><i class="fa-solid fa-file-pen" style="font-size:0.65rem;"></i> {{ $e->name }}</span>
                @endif
            @endforeach
            @foreach($classes as $c)
                @if($c->id == $classId)
                    <span class="filter-tag"><i class="fa-solid fa-chalkboard" style="font-size:0.65rem;"></i> {{ $c->name }}</span>
                @endif
            @endforeach
            @if($students->count())
                <span class="filter-tag green"><i class="fa-solid fa-users" style="font-size:0.65rem;"></i> {{ $students->count() }} {{ __('Students') }}</span>
            @endif
        </div>
        @endif

        {{-- TWO-COLUMN LAYOUT --}}
        <div class="mark-entry-row">

            {{-- LEFT: Student Marks Table --}}
            <div class="mark-entry-main">
                @if($students->count())
                    @include('school.mark.partials.marks-table')
                @else
                    <div class="entry-empty-card">
                        <div class="entry-empty-icon"><i class="fa-solid fa-user-group"></i></div>
                        <h5 class="fw-bold mb-2" style="color:#1e293b;">{{ __('No Students to Display') }}</h5>
                        <p class="text-muted mb-0" style="font-size:0.88rem;">
                            {{ __('Please select an exam, class, and subject above to begin marks entry.') }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- RIGHT: Submitted Subjects Sidebar --}}
            <div class="submitted-sidebar">
                <div class="sidebar-card">

                    <div class="sidebar-card-header">
                        <h6 class="sidebar-card-header-title">
                            <i class="fa-solid fa-circle-check"></i> {{ __('Submitted Subjects') }}
                        </h6>
                        @if($submittedSubjects->count() > 0)
                            <span class="sidebar-count-badge">{{ $submittedSubjects->count() }} {{ __('done') }}</span>
                        @endif
                    </div>

                    <div class="sidebar-body">
                        @if(!$classId || !$examId)
                            <div class="sidebar-empty">
                                <div class="sidebar-empty-icon"><i class="fa-solid fa-filter"></i></div>
                                <p class="sidebar-empty-text">{{ __('Select an Exam and Class to see submitted subjects') }}</p>
                            </div>
                        @elseif($submittedSubjects->isEmpty())
                            <div class="sidebar-empty">
                                <div class="sidebar-empty-icon"><i class="fa-solid fa-inbox"></i></div>
                                <p class="sidebar-empty-text">{{ __('No marks submitted yet for this exam and class') }}</p>
                            </div>
                        @else
                            @foreach($submittedSubjects as $sub)
                                @php
                                    $isActive = ($subjectId == $sub['id']);
                                    $initials = strtoupper(substr($sub['name'], 0, 2));
                                    $subUrl   = route('marks.index', ['tenant' => auth()->user()->school->slug, 'class_id' => $classId, 'exam_id' => $examId, 'subject_id' => $sub['id']]);
                                @endphp
                                <a href="{{ $subUrl }}" class="sub-item {{ $isActive ? 'active-subject' : '' }}">
                                    <div class="sub-item-icon">{{ $initials }}</div>
                                    <div class="sub-item-info">
                                        <div class="sub-item-name" title="{{ $sub['name'] }}">{{ $sub['name'] }}</div>
                                        <div class="sub-item-meta">
                                            <span class="sub-meta-tag entries-tag">
                                                <i class="fa-solid fa-users" style="font-size:0.55rem;"></i>
                                                {{ $sub['total_entries'] }} {{ __('entries') }}
                                            </span>
                                            @if($sub['full_mark'])
                                                <span class="sub-meta-tag fm-tag">FM: {{ $sub['full_mark'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-circle-check sub-item-check"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>

                    @if($classId && $examId && $subjects->count() > 0)
                        @php
                            $totalSubjects   = $subjects->count();
                            $submittedCount  = $submittedSubjects->count();
                            $progressPercent = $totalSubjects > 0 ? round(($submittedCount / $totalSubjects) * 100) : 0;
                        @endphp
                        <div class="sidebar-footer">
                            <div class="sidebar-progress">
                                <span class="sidebar-progress-label"><i class="fa-solid fa-chart-pie" style="font-size:0.65rem;"></i> {{ __('Progress') }}</span>
                                <span class="sidebar-progress-pct">{{ $progressPercent }}%</span>
                            </div>
                            <div class="progress-bar-track">
                                <div class="progress-bar-fill" style="width:{{ $progressPercent }}%;"></div>
                            </div>
                            <div style="font-size:0.68rem;color:#94a3b8;margin-top:5px;text-align:center;">
                                {{ $submittedCount }} {{ __('of') }} {{ $totalSubjects }} {{ __('subjects submitted') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>{{-- end .mark-entry-row --}}

    </div>
</div>
@endsection

@section('customJs')
<script>
    document.getElementById('class_id').addEventListener('change', function () {
        let classId    = this.value;
        let subjectBox = document.getElementById('subject_id');
        subjectBox.innerHTML = '<option value="">Loading...</option>';

        fetch("{{ route('marks.findSubject', ['tenant' => auth()->user()->school->slug]) }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ class_id: classId })
        })
        .then(res => res.json())
        .then(data => {
            subjectBox.innerHTML = '<option value="">Select Subject</option>';
            if (data.status && data.subjects.length > 0) {
                data.subjects.forEach(s => {
                    subjectBox.innerHTML += `<option value="${s.id}" ${'{{ $subjectId }}' == s.id ? 'selected' : ''}>${s.name}</option>`;
                });
            }
        })
        .catch(err => console.error(err));
    });

    if (document.getElementById('class_id').value) {
        document.getElementById('class_id').dispatchEvent(new Event('change'));
    }

    document.getElementById('subject_id').addEventListener('change', function () {
        let classId   = document.getElementById('class_id').value;
        let examId    = document.querySelector('[name="exam_id"]').value;
        let subjectId = this.value;
        if (classId && examId && subjectId) {
            window.location.href = `?class_id=${classId}&exam_id=${examId}&subject_id=${subjectId}`;
        }
    });

    function calculateGrade(marks, fullMarks) {
        let pct = (marks / fullMarks) * 100;
        if (pct >= 80) return 'A+';
        if (pct >= 70) return 'A';
        if (pct >= 60) return 'A-';
        if (pct >= 50) return 'B';
        if (pct >= 40) return 'C';
        if (pct >= 33) return 'D';
        return 'F';
    }

    $(document).on('keypress', '.mark-input', function (e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });

    $(document).on('input', '.mark-input', function () {
        let input     = $(this);
        let rawVal    = input.val().replace(/[^0-9]/g, '');
        if (input.val() !== rawVal) {
            input.val(rawVal);
        }
        let container = input.closest('tr, .entry-student-card');
        let studentId = input.data('student');
        let fullMarks = parseInt($('.full-mark-badge').first().text().replace(/[^0-9]/g, '') || 100, 10);
        let cqInput    = container.find('.cq-input');
        let mcqInput   = container.find('.mcq-input');
        let pracInput  = container.find('.prac-input');
        let totalInput = container.find('.total-input');
        let cqVal   = cqInput.val()    !== '' ? parseInt(cqInput.val(), 10)    : null;
        let mcqVal  = mcqInput.val()   !== '' ? parseInt(mcqInput.val(), 10)   : null;
        let pracVal = pracInput.val()  !== '' ? parseInt(pracInput.val(), 10)  : null;
        let totalVal= totalInput.val() !== '' ? parseInt(totalInput.val(), 10) : null;
        if (input.hasClass('cq-input') || input.hasClass('mcq-input') || input.hasClass('prac-input')) {
            if (cqVal !== null || mcqVal !== null || pracVal !== null) {
                totalVal = (cqVal || 0) + (mcqVal || 0) + (pracVal || 0);
                totalInput.val(totalVal);
            } else {
                totalVal = null;
                totalInput.val('');
            }
        }
        if (totalVal !== null && totalVal > fullMarks) {
            Swal.fire({ icon:'error', title:'Limit Exceeded', text:`Marks cannot exceed ${fullMarks}`, confirmButtonColor:'#4f46e5' });
            totalVal = fullMarks; totalInput.val(totalVal);
        }
        let classId   = $('#hidden_class_id').val();
        let examId    = $('#hidden_exam_id').val();
        let subjectId = $('#hidden_subject_id').val();
        let status    = container.find('.status-input').val();
        let grade     = totalVal !== null ? calculateGrade(totalVal, fullMarks) : '-';
        if ($(`#grade-${studentId}`).length) { $(`#grade-${studentId}`).text(grade); updateGradeStyle(studentId, grade); }
        $.ajax({
            url: "{{ route('marks.autosave', auth()->user()->school->slug) }}",
            type: "POST",
            data: { student_id:studentId, class_id:classId, exam_id:examId, subject_id:subjectId, cq:cqVal, mcq:mcqVal, practical:pracVal, marks:totalVal, full_marks:fullMarks, status:status, _token:"{{ csrf_token() }}" },
            success: function () {
                container.find('.mark-input').addClass('is-valid').removeClass('is-invalid');
                Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:800 }).fire({ icon:'success', title:'Saved' });
            },
            error: function () { input.addClass('is-invalid').removeClass('is-valid'); }
        });
    });

    $(document).on('change', '.status-input', function () {
        let container  = $(this).closest('tr, .entry-student-card');
        let status     = $(this).val();
        let markInputs = container.find('.mark-input');
        let studentId  = container.data('student');
        let classId    = $('#hidden_class_id').val();
        let examId     = $('#hidden_exam_id').val();
        let subjectId  = $('#hidden_subject_id').val();
        if (status == 'absent') {
            markInputs.val(0).prop('disabled', true);
            $(`#grade-${studentId}`).text('ABS'); updateGradeStyle(studentId, 'ABS');
            container.addClass('row-absent');
        } else {
            markInputs.prop('disabled', false);
            $(`#grade-${studentId}`).text('-'); updateGradeStyle(studentId, '-');
            container.removeClass('row-absent');
        }
        $.ajax({
            url: "{{ route('marks.statusUpdate', auth()->user()->school->slug) }}",
            type: "POST",
            data: { student_id:studentId, class_id:classId, exam_id:examId, subject_id:subjectId, status:status, cq:container.find('.cq-input').val(), mcq:container.find('.mcq-input').val(), practical:container.find('.prac-input').val(), marks:container.find('.total-input').val(), _token:"{{ csrf_token() }}" }
        });
    });

    function updateGradeStyle(sid, grade) {
        const el = document.getElementById('grade-' + sid);
        if (!el) return;
        el.className = 'grade-pill-entry';
        if      (grade === 'A+') el.classList.add('gpe-ap');
        else if (grade === 'A')  el.classList.add('gpe-a');
        else if (grade === 'A-') el.classList.add('gpe-am');
        else if (grade === 'B')  el.classList.add('gpe-b');
        else if (grade === 'C')  el.classList.add('gpe-c');
        else if (grade === 'D')  el.classList.add('gpe-d');
        else if (grade === 'F' || grade === 'ABS') el.classList.add('gpe-f');
        else el.classList.add('gpe-default');
    }
</script>
@endsection
