@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .mark-input {
            width: 80px;
            text-align: center;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s;
            outline: none;
        }
        .mark-input:focus {
            border-color: #002147;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0,33,71,0.08);
        }
        .mark-input.saving { border-color: #f59e0b; background: #fffbeb; }
        .mark-input.saved  { border-color: #22c55e; background: #f0fdf4; }
        .mark-input.error  { border-color: #ef4444; background: #fef2f2; }

        .save-indicator {
            font-size: 0.72rem;
            font-weight: 600;
            margin-top: 3px;
            min-height: 14px;
            transition: all 0.3s;
        }
        .save-indicator.saving { color: #f59e0b; }
        .save-indicator.saved  { color: #22c55e; }
        .save-indicator.error  { color: #ef4444; }

        .grade-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            background: #e0f2fe;
            color: #0369a1;
        }
        .grade-pill.F  { background: #fee2e2; color: #dc2626; }
        .grade-pill.Ap { background: #dcfce7; color: #16a34a; }

        .tab-toggle {
            display: flex;
            gap: 8px;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 4px;
        }
        .tab-btn {
            flex: 1;
            padding: 8px 16px;
            border: none;
            border-radius: 9px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            color: #64748b;
            text-decoration: none;
            text-align: center;
        }
        .tab-btn.active {
            background: #fff;
            color: #002147;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .stats-bar {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 12px 20px;
            border: 1.5px solid #f1f5f9;
            min-width: 110px;
            text-align: center;
        }
        .stat-card .num { font-size: 1.4rem; font-weight: 800; color: #002147; }
        .stat-card .lbl { font-size: 0.72rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-list-check me-2"></i> Marks Report</h1>
                <p style="margin: 0; opacity: 0.85;">View and analyze academic results — or filter by subject to edit marks</p>
            </div>
        </div>

        {{-- Tab Toggle --}}
        <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
            <div class="tab-toggle">
                <a href="{{ request()->fullUrlWithQuery(['subject_id' => '']) }}" 
                   class="tab-btn {{ !$selectedSubjectId ? 'active' : '' }}">
                    <i class="fa-solid fa-table me-1"></i> Full Report
                </a>
                <span class="tab-btn {{ $selectedSubjectId ? 'active' : '' }}" style="cursor:default;">
                    <i class="fa-solid fa-pencil me-1"></i> Subject Edit Mode
                </span>
            </div>
            @if($selectedSubjectId)
                <span class="badge bg-primary" style="font-size:0.82rem; padding: 7px 14px; border-radius:8px;">
                    Editing: {{ $selectedSubject?->name ?? 'Subject' }} | Full Mark: {{ $fullMark }}
                </span>
            @endif
        </div>

        {{-- Filter Section --}}
        <div class="filter-section mb-4">
            <form method="GET" action="{{ route('marks.view-marks', ['tenant' => auth()->user()->school->slug]) }}" id="filterForm">
                <div class="row align-items-end g-3">
                    <div class="col-md-2">
                        <label class="filter-label">Academic Year</label>
                        <select name="academic_year_id" class="form-select border-0 bg-light" style="border-radius:10px;padding:10px;">
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Class</label>
                        <select name="class_id" id="classSelect" class="form-select border-0 bg-light" required style="border-radius:10px;padding:10px;">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Exam</label>
                        <select name="exam_id" class="form-select border-0 bg-light" required style="border-radius:10px;padding:10px;">
                            <option value="">Select Exam</option>
                            @foreach($examTypes as $exam)
                                <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Subject <small class="text-muted">(optional — for edit mode)</small></label>
                        <select name="subject_id" id="subjectSelect" class="form-select border-0 bg-light" style="border-radius:10px;padding:10px;">
                            <option value="">All Subjects (Full Report)</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2" style="border-radius:10px;">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Show
                            </button>
                            @if($selectedClassId && $selectedExamId && !$selectedSubjectId)
                                <a href="{{ route('marks.download-sheet', array_merge(['tenant' => auth()->user()->school->slug], request()->all())) }}"
                                   class="btn btn-outline-success py-2" style="border-radius:10px;" title="Download CSV">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ════════════════════════════════════════════════════ --}}
        {{-- MODE 1: SINGLE SUBJECT EDIT TABLE                    --}}
        {{-- ════════════════════════════════════════════════════ --}}
        @if($selectedSubjectId && $selectedClassId && $selectedExamId)

            @php
                $totalStudents = $students->count();
                $enteredCount  = $subjectMarks->count();
                $absentCount   = $subjectMarks->where('status', 'absent')->count();
                $avgMark       = $enteredCount > 0 ? round($subjectMarks->avg('marks'), 1) : 0;
            @endphp

            {{-- Stats Bar --}}
            <div class="stats-bar mb-3">
                <div class="stat-card"><div class="num">{{ $totalStudents }}</div><div class="lbl">Total</div></div>
                <div class="stat-card"><div class="num text-success">{{ $enteredCount }}</div><div class="lbl">Entered</div></div>
                <div class="stat-card"><div class="num text-warning">{{ $totalStudents - $enteredCount }}</div><div class="lbl">Pending</div></div>
                <div class="stat-card"><div class="num text-danger">{{ $absentCount }}</div><div class="lbl">Absent</div></div>
                <div class="stat-card"><div class="num text-primary">{{ $avgMark }}</div><div class="lbl">Avg Mark</div></div>
            </div>

            <div class="data-table-card">
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="fa-solid fa-pencil me-2"></i>
                        {{ $selectedSubject?->name }} — Marks Entry & Edit
                    </h5>
                    <div class="text-muted small">Auto-saves on change</div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table mb-0">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th style="width:80px;">Roll</th>
                                <th>Student Name</th>
                                <th style="width:100px;" class="text-center">Status</th>
                                <th style="width:130px;" class="text-center">Marks <small class="opacity-50">/ {{ $fullMark }}</small></th>
                                <th style="width:80px;" class="text-center">Grade</th>
                                <th style="width:100px;" class="text-center">Save</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $i => $student)
                                @php
                                    $markRecord = $subjectMarks->get($student->id);
                                    $markValue  = $markRecord?->marks;
                                    $status     = $markRecord?->status ?? 'present';
                                    $gradeInfo  = ['grade' => null, 'point' => null];
                                    if ($markValue !== null && $fullMark > 0) {
                                        $pct = ($markValue / $fullMark) * 100;
                                        if ($pct >= 80)     $gradeInfo = ['grade' => 'A+', 'point' => 5];
                                        elseif ($pct >= 70) $gradeInfo = ['grade' => 'A',  'point' => 4];
                                        elseif ($pct >= 60) $gradeInfo = ['grade' => 'A-', 'point' => 3.5];
                                        elseif ($pct >= 50) $gradeInfo = ['grade' => 'B',  'point' => 3];
                                        elseif ($pct >= 40) $gradeInfo = ['grade' => 'C',  'point' => 2];
                                        elseif ($pct >= 33) $gradeInfo = ['grade' => 'D',  'point' => 1];
                                        else                $gradeInfo = ['grade' => 'F',  'point' => 0];
                                    }
                                @endphp
                                <tr class="align-middle" data-student="{{ $student->id }}" id="row-{{ $student->id }}">
                                    <td class="text-muted fw-bold small">{{ $i + 1 }}</td>
                                    <td class="fw-bold">{{ $student->roll }}</td>
                                    <td class="fw-bold text-dark">{{ strtoupper($student->name) }}</td>

                                    {{-- Status Toggle --}}
                                    <td class="text-center">
                                        <select class="form-select form-select-sm border-0 bg-light status-select"
                                                data-student="{{ $student->id }}"
                                                style="border-radius:8px; font-size:0.8rem; padding:5px;">
                                            <option value="present" {{ $status == 'present' ? 'selected' : '' }}>✅ Present</option>
                                            <option value="absent"  {{ $status == 'absent'  ? 'selected' : '' }}>❌ Absent</option>
                                        </select>
                                    </td>

                                    {{-- Mark Input --}}
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <input type="number"
                                                   class="mark-input"
                                                   id="mark-{{ $student->id }}"
                                                   value="{{ $markValue }}"
                                                   min="0" max="{{ $fullMark }}"
                                                   placeholder="—"
                                                   data-student="{{ $student->id }}"
                                                   {{ $status == 'absent' ? 'disabled' : '' }}>
                                            <div class="save-indicator" id="ind-{{ $student->id }}">
                                                @if($markValue !== null)
                                                    <span class="saved">✓ Saved</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Grade Display --}}
                                    <td class="text-center" id="grade-{{ $student->id }}">
                                        @if($gradeInfo['grade'])
                                            <span class="grade-pill {{ $gradeInfo['grade'] === 'F' ? 'F' : ($gradeInfo['grade'] === 'A+' ? 'Ap' : '') }}">
                                                {{ $gradeInfo['grade'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Manual Save Button --}}
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary save-btn"
                                                style="border-radius:8px; padding:4px 12px; font-size:0.8rem;"
                                                data-student="{{ $student->id }}"
                                                onclick="saveMark({{ $student->id }})">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users fa-2x mb-2 d-block"></i>
                                        No students found for this class.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ════════════════════════════════════════════════════ --}}
        {{-- MODE 2: FULL REPORT (all subjects)                   --}}
        {{-- ════════════════════════════════════════════════════ --}}
        @elseif(isset($paginatedResults) && count($paginatedResults) > 0)
            <div class="data-table-card">
                <div class="table-header">
                    <h5 class="table-title"><i class="fa-solid fa-table me-2"></i> Result Sheet</h5>
                    <div class="text-muted small">Total Records: {{ $paginatedResults->total() }}</div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Roll</th>
                                <th class="text-start">Student Name</th>
                                @foreach($subjects as $subject)
                                    <th>{{ $subject->name }} <br><small class="opacity-50">(M | G)</small></th>
                                @endforeach
                                <th class="bg-light">Total</th>
                                <th class="bg-light">GPA</th>
                                <th class="bg-light">Merit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedResults as $item)
                                @php
                                    $studentId = $item['student_id'];
                                    $student   = $students->where('id', $studentId)->first();
                                    $history   = DB::table('student_sessions')
                                                    ->where('student_id', $studentId)
                                                    ->where('academic_year_id', $selectedYearId)
                                                    ->first();
                                    $displayId = $history ? $history->old_student_id : ($student ? $student->student_id : 'N/A');
                                @endphp
                                @if($student)
                                <tr class="align-middle">
                                    <td class="fw-bold text-muted">{{ $displayId }}</td>
                                    <td class="fw-bold">{{ $student->roll }}</td>
                                    <td class="text-start fw-bold text-dark">{{ strtoupper($student->name) }}</td>
                                    @foreach($subjects as $subject)
                                        @php
                                            $m = $marksData[$student->id][$subject->id]['marks'] ?? null;
                                            $g = $marksData[$student->id][$subject->id]['grade'] ?? '-';
                                        @endphp
                                        <td class="mark-cell">
                                            @if($m !== null)
                                                {{ $m }} <span class="grade-text">| {{ $g }}</span>
                                            @else
                                                <span class="text-danger small">N/A</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="bg-light"><span class="total-badge">{{ $item['total_marks'] }}</span></td>
                                    <td class="bg-light"><span class="gpa-badge">{{ $marksData[$student->id]['GPA'] ?? '0.00' }}</span></td>
                                    <td class="bg-light">
                                        <span class="merit-badge">{{ $meritPosition[$student->id] ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('marks.marksheet', ['tenant' => auth()->user()->school->slug, 'student' => $student->id, 'class' => $selectedClassId, 'exam' => $selectedExamId, 'year' => $selectedYearId]) }}"
                                           class="btn btn-action btn-sm btn-outline-primary" title="Download Marksheet">
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">{{ $paginatedResults->links() }}</div>

        @elseif($selectedClassId && $selectedExamId)
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-circle-exclamation fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">No marks found for the selected criteria.</h5>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
const AUTOSAVE_URL = "{{ route('marks.autosave', ['tenant' => auth()->user()->school->slug]) }}";
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
const CLASS_ID   = '{{ $selectedClassId }}';
const EXAM_ID    = '{{ $selectedExamId }}';
const SUBJECT_ID = '{{ $selectedSubjectId }}';
const YEAR_ID    = '{{ $selectedYearId }}';
const FULL_MARK  = {{ $fullMark ?? 0 }};

let saveTimers = {};

// ── Auto save on mark input change ──
document.querySelectorAll('.mark-input').forEach(input => {
    input.addEventListener('input', function () {
        const sid = this.dataset.student;
        clearTimeout(saveTimers[sid]);
        setIndicator(sid, 'saving', '⏳ Saving...');
        this.classList.add('saving');
        saveTimers[sid] = setTimeout(() => doSave(sid), 800);
    });
    input.addEventListener('blur', function () {
        const sid = this.dataset.student;
        clearTimeout(saveTimers[sid]);
        doSave(sid);
    });
});

// ── Status select change ──
document.querySelectorAll('.status-select').forEach(sel => {
    sel.addEventListener('change', function () {
        const sid = this.dataset.student;
        const markInput = document.getElementById('mark-' + sid);
        if (this.value === 'absent') {
            markInput.value = 0;
            markInput.disabled = true;
        } else {
            markInput.disabled = false;
        }
        doSave(sid);
    });
});

// ── Manual save button ──
function saveMark(sid) {
    clearTimeout(saveTimers[sid]);
    doSave(sid);
}

function doSave(sid) {
    const input  = document.getElementById('mark-' + sid);
    const status = document.querySelector(`.status-select[data-student="${sid}"]`)?.value ?? 'present';
    const marks  = input?.value ?? '';

    if (marks === '' && status === 'present') {
        setIndicator(sid, '', '');
        input.classList.remove('saving','saved','error');
        return;
    }

    const val = parseFloat(marks);
    if (!isNaN(val) && FULL_MARK > 0 && val > FULL_MARK) {
        input.value = FULL_MARK;
    }

    setIndicator(sid, 'saving', '⏳ Saving...');
    input?.classList.remove('saved','error'); input?.classList.add('saving');

    fetch(AUTOSAVE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({
            student_id:       sid,
            class_id:         CLASS_ID,
            exam_id:          EXAM_ID,
            subject_id:       SUBJECT_ID,
            academic_year_id: YEAR_ID,
            marks:            marks,
            status:           status,
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status) {
            setIndicator(sid, 'saved', '✓ Saved');
            input?.classList.remove('saving','error'); input?.classList.add('saved');
            updateGrade(sid, parseFloat(marks));
        } else {
            setIndicator(sid, 'error', '✗ Error');
            input?.classList.remove('saving','saved'); input?.classList.add('error');
        }
    })
    .catch(() => {
        setIndicator(sid, 'error', '✗ Failed');
        input?.classList.remove('saving','saved'); input?.classList.add('error');
    });
}

function setIndicator(sid, type, msg) {
    const el = document.getElementById('ind-' + sid);
    if (!el) return;
    el.innerHTML = msg ? `<span class="${type}">${msg}</span>` : '';
}

function updateGrade(sid, marks) {
    if (FULL_MARK <= 0 || isNaN(marks)) return;
    const pct = (marks / FULL_MARK) * 100;
    let grade = 'F';
    if      (pct >= 80) grade = 'A+';
    else if (pct >= 70) grade = 'A';
    else if (pct >= 60) grade = 'A-';
    else if (pct >= 50) grade = 'B';
    else if (pct >= 40) grade = 'C';
    else if (pct >= 33) grade = 'D';

    const cls  = grade === 'F' ? 'F' : (grade === 'A+' ? 'Ap' : '');
    const cell = document.getElementById('grade-' + sid);
    if (cell) cell.innerHTML = `<span class="grade-pill ${cls}">${grade}</span>`;
}

// ── Load subjects when class changes ──
document.getElementById('classSelect')?.addEventListener('change', function () {
    const classId    = this.value;
    const subjectSel = document.getElementById('subjectSelect');
    if (!classId || !subjectSel) return;
    subjectSel.innerHTML = '<option value="">Loading...</option>';

    fetch("{{ route('marks.findSubject', ['tenant' => auth()->user()->school->slug]) }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ class_id: classId })
    })
    .then(r => r.json())
    .then(data => {
        subjectSel.innerHTML = '<option value="">All Subjects (Full Report)</option>';
        data.subjects.forEach(s => {
            subjectSel.innerHTML += `<option value="${s.id}">${s.name}</option>`;
        });
    })
    .catch(() => {
        subjectSel.innerHTML = '<option value="">Error loading subjects</option>';
    });
});
</script>
@endsection