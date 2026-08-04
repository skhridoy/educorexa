@extends($layout)

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Disable number input spin buttons */
        input.mark-input::-webkit-outer-spin-button,
        input.mark-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input.mark-input[type=number] {
            -moz-appearance: textfield;
        }

        .mark-input.saving { border-color: #f59e0b; background: #fffbeb; }
        .mark-input.saved  { border-color: #22c55e; background: #f0fdf4; }
        .mark-input.error  { border-color: #ef4444; background: #fef2f2; }

        .save-indicator {
            font-size: 0.68rem;
            font-weight: 700;
            min-height: 14px;
            margin-top: 2px;
            text-align: center;
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
            gap: 10px;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 4px;
            -webkit-overflow-scrolling: touch;
        }
        .stats-bar::-webkit-scrollbar {
            height: 3px;
        }
        .stats-bar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 10px 14px;
            border: 1.5px solid #f1f5f9;
            flex: 1 0 auto;
            min-width: 75px;
            text-align: center;
        }
        .stat-card .num { font-size: 1.2rem; font-weight: 800; color: #002147; line-height: 1.2; }
        .stat-card .lbl { font-size: 0.62rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

        /* ── Status Toggle ── */
        .status-toggle {
            display: inline-flex;
            border-radius: 10px;
            overflow: hidden;
            border: 1.5px solid #cbd5e1;
            background: #f8fafc;
            flex-shrink: 0;
            height: 38px;
        }
        .status-toggle .st-btn {
            padding: 0 12px;
            font-size: 0.78rem;
            font-weight: 700;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.18s ease-in-out;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .status-toggle .st-btn:first-child { border-right: 1.5px solid #cbd5e1; }
        .status-toggle .st-btn.active-present {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-toggle .st-btn.active-absent {
            background: #fee2e2;
            color: #dc2626;
        }
        .status-toggle .st-btn:hover:not(.active-present):not(.active-absent) {
            background: #f1f5f9;
            color: #475569;
        }

        /* ── Student Mark Card Grid ── */
        .student-card-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px;
        }
        .student-mark-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 16px;
            gap: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease-in-out;
        }
        .student-mark-card:hover {
            box-shadow: 0 6px 20px rgba(0, 33, 71, 0.07);
            border-color: #cbd5e1;
        }
        .student-mark-card.card-absent {
            background: #fff8f8;
            border-color: #fecaca;
        }

        /* Left: Avatar + Info */
        .smc-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1;
        }
        .smc-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(15, 23, 42, 0.12);
        }
        .smc-info {
            min-width: 0;
            flex: 1;
        }
        .smc-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
        }
        .smc-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
            flex-wrap: wrap;
        }
        .smc-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
        }
        .smc-roll-badge {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        /* Right: Controls */
        .smc-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .smc-mark-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── Unified Mark Box ── */
        .smc-mark-box-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .smc-mark-box {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            overflow: hidden;
            transition: all 0.2s ease-in-out;
            height: 38px;
            box-sizing: border-box;
        }
        .smc-mark-box:focus-within {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }
        .mark-input {
            width: 44px;
            height: 100%;
            text-align: center;
            border: none;
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
            background: transparent;
            outline: none;
            padding: 0 2px;
        }
        .save-icon-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            padding: 0 3px;
            height: 100%;
        }
        .smc-mark-denom {
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            padding-right: 8px;
            padding-left: 6px;
            border-left: 1px solid #e2e8f0;
            height: 100%;
            display: inline-flex;
            align-items: center;
            background: #f8fafc;
            user-select: none;
            white-space: nowrap;
        }

        .smc-grade-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .grade-pill-lg {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 800;
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .grade-pill-lg.gp-ap { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
        .grade-pill-lg.gp-a  { background: #d1fae5; color: #047857; border-color: #a7f3d0; }
        .grade-pill-lg.gp-am { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
        .grade-pill-lg.gp-b  { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
        .grade-pill-lg.gp-c  { background: #fef9c3; color: #a16207; border-color: #fef08a; }
        .grade-pill-lg.gp-d  { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }
        .grade-pill-lg.gp-f  { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }

        /* ── Responsive / Mobile Breakdown ── */
        .st-text { display: inline; }
        @media (max-width: 767.98px) {
            .st-text {
                display: none;
            }
            .st-icon {
                margin-right: 0 !important;
                font-size: 0.9rem;
            }
            .student-mark-card {
                flex-direction: column;
                align-items: stretch;
                padding: 12px 14px;
                gap: 10px;
            }
            .smc-left {
                width: 100%;
            }
            .smc-avatar {
                width: 38px;
                height: 38px;
                font-size: 1rem;
                border-radius: 10px;
            }
            .smc-name {
                font-size: 0.85rem;
                white-space: normal;
                word-break: break-word;
            }
            .smc-right {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                border-top: 1px solid #f1f5f9;
                padding-top: 8px;
                margin-top: 2px;
                gap: 8px;
            }
            .smc-mark-row {
                gap: 6px;
            }
            .status-toggle {
                height: 34px;
            }
            .status-toggle .st-btn {
                padding: 0 10px;
                font-size: 0.75rem;
            }
            .smc-mark-box {
                height: 34px;
            }
            .mark-input {
                width: 40px;
                font-size: 0.88rem;
            }
            .smc-mark-denom {
                font-size: 0.68rem;
                padding-right: 6px;
                padding-left: 4px;
            }
            .grade-pill-lg {
                width: 34px;
                height: 34px;
                font-size: 0.8rem;
                border-radius: 8px;
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

                {{-- Card Grid --}}
                <div class="student-card-grid">
                    @forelse($students as $i => $student)
                        @php
                            $markRecord = $subjectMarks->get($student->id);
                            $markValue  = $markRecord?->marks;
                            $status     = $markRecord?->status ?? 'present';
                            $grade      = null;
                            $gradeClass = '';
                            if ($markValue !== null && $fullMark > 0) {
                                $pct = ($markValue / $fullMark) * 100;
                                if      ($pct >= 80) { $grade = 'A+'; $gradeClass = 'gp-ap'; }
                                elseif  ($pct >= 70) { $grade = 'A';  $gradeClass = 'gp-a';  }
                                elseif  ($pct >= 60) { $grade = 'A-'; $gradeClass = 'gp-am'; }
                                elseif  ($pct >= 50) { $grade = 'B';  $gradeClass = 'gp-b';  }
                                elseif  ($pct >= 40) { $grade = 'C';  $gradeClass = 'gp-c';  }
                                elseif  ($pct >= 33) { $grade = 'D';  $gradeClass = 'gp-d';  }
                                else                 { $grade = 'F';  $gradeClass = 'gp-f';  }
                            }
                            $initials = strtoupper(substr($student->name, 0, 1));
                        @endphp

                        <div class="student-mark-card {{ $status === 'absent' ? 'card-absent' : '' }}" id="row-{{ $student->id }}" data-student="{{ $student->id }}">

                            {{-- LEFT: Profile + Info --}}
                            <div class="smc-left">
                                <div class="smc-avatar">{{ $initials }}</div>
                                <div class="smc-info">
                                    <div class="smc-name">{{ strtoupper($student->name) }}</div>
                                    <div class="smc-meta">
                                        <span class="smc-badge smc-id-badge"><i class="fa-solid fa-id-badge me-1"></i>{{ $student->student_id ?? 'N/A' }}</span>
                                        <span class="smc-badge smc-roll-badge"><i class="fa-solid fa-hashtag me-1"></i>Roll {{ $student->roll }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT: Controls --}}
                            <div class="smc-right">

                                {{-- Status Toggle --}}
                                <div class="status-toggle" data-student="{{ $student->id }}">
                                    <button type="button"
                                            class="st-btn {{ $status == 'present' ? 'active-present' : '' }}"
                                            data-value="present"
                                            data-student="{{ $student->id }}"
                                            onclick="setStatus({{ $student->id }}, 'present', this)">
                                        <i class="fa-solid fa-check me-1 st-icon"></i><span class="st-text">Present</span>
                                    </button>
                                    <button type="button"
                                            class="st-btn {{ $status == 'absent' ? 'active-absent' : '' }}"
                                            data-value="absent"
                                            data-student="{{ $student->id }}"
                                            onclick="setStatus({{ $student->id }}, 'absent', this)">
                                        <i class="fa-solid fa-xmark me-1 st-icon"></i><span class="st-text">Absent</span>
                                    </button>
                                </div>
                                <input type="hidden" class="status-hidden" id="status-{{ $student->id }}" value="{{ $status }}">

                                {{-- Mark + Grade Row --}}
                                <div class="smc-mark-row">
                                    <div class="smc-mark-box">
                                        <input type="number"
                                               class="mark-input"
                                               id="mark-{{ $student->id }}"
                                               value="{{ $markValue }}"
                                               min="0" max="{{ $fullMark }}"
                                               placeholder="—"
                                               data-student="{{ $student->id }}"
                                               {{ $status == 'absent' ? 'disabled' : '' }}>
                                        <span class="save-icon-indicator" id="ind-{{ $student->id }}">
                                            @if($markValue !== null)<i class="fa-solid fa-check text-success" title="Saved"></i>@endif
                                        </span>
                                        <span class="smc-mark-denom">/ {{ $fullMark }}</span>
                                    </div>

                                    <div class="smc-grade-wrap">
                                        <div class="grade-pill-lg {{ $gradeClass }}" id="grade-{{ $student->id }}">
                                            {{ $grade ?? '—' }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted w-100">
                            <i class="fa-solid fa-users fa-2x mb-2 d-block"></i>
                            No students found for this class.
                        </div>
                    @endforelse
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

// ── Status toggle button handler ──
function setStatus(sid, value, clickedBtn) {
    const markInput   = document.getElementById('mark-' + sid);
    const hiddenInput = document.getElementById('status-' + sid);
    const container   = clickedBtn.closest('.status-toggle');

    // Update hidden input
    hiddenInput.value = value;

    // Update button styles
    container.querySelectorAll('.st-btn').forEach(btn => {
        btn.classList.remove('active-present', 'active-absent');
    });
    clickedBtn.classList.add(value === 'absent' ? 'active-absent' : 'active-present');

    // Disable/enable mark input
    if (value === 'absent') {
        markInput.value    = 0;
        markInput.disabled = true;
    } else {
        markInput.disabled = false;
    }

    doSave(sid);
}

// ── Manual save button ──
function saveMark(sid) {
    clearTimeout(saveTimers[sid]);
    doSave(sid);
}

function doSave(sid) {
    const input  = document.getElementById('mark-' + sid);
    const status = document.getElementById('status-' + sid)?.value ?? 'present';
    const marks  = input?.value ?? '';

    if (marks === '' && status === 'present') {
        setIndicator(sid, '');
        input.classList.remove('saving','saved','error');
        return;
    }

    const val = parseFloat(marks);
    if (!isNaN(val) && FULL_MARK > 0 && val > FULL_MARK) {
        input.value = FULL_MARK;
    }

    setIndicator(sid, 'saving');
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
            setIndicator(sid, 'saved');
            input?.classList.remove('saving','error'); input?.classList.add('saved');
            updateGrade(sid, parseFloat(marks));
        } else {
            setIndicator(sid, 'error');
            input?.classList.remove('saving','saved'); input?.classList.add('error');
        }
    })
    .catch(() => {
        setIndicator(sid, 'error', '✗ Failed');
        input?.classList.remove('saving','saved'); input?.classList.add('error');
    });
}

function setIndicator(sid, type) {
    const el = document.getElementById('ind-' + sid);
    if (!el) return;
    if (type === 'saving') {
        el.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-warning" title="Saving..."></i>`;
    } else if (type === 'saved') {
        el.innerHTML = `<i class="fa-solid fa-check text-success" title="Saved"></i>`;
    } else if (type === 'error') {
        el.innerHTML = `<i class="fa-solid fa-circle-exclamation text-danger" title="Error"></i>`;
    } else {
        el.innerHTML = '';
    }
}

function updateGrade(sid, marks) {
    if (FULL_MARK <= 0 || isNaN(marks)) return;
    const pct = (marks / FULL_MARK) * 100;

    let grade = 'F', cls = 'gp-f';
    if      (pct >= 80) { grade = 'A+'; cls = 'gp-ap'; }
    else if (pct >= 70) { grade = 'A';  cls = 'gp-a';  }
    else if (pct >= 60) { grade = 'A-'; cls = 'gp-am'; }
    else if (pct >= 50) { grade = 'B';  cls = 'gp-b';  }
    else if (pct >= 40) { grade = 'C';  cls = 'gp-c';  }
    else if (pct >= 33) { grade = 'D';  cls = 'gp-d';  }

    const cell = document.getElementById('grade-' + sid);
    if (cell) {
        cell.className = `grade-pill-lg ${cls}`;
        cell.textContent = grade;
    }
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