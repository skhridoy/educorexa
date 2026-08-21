<style>
    /* ═══════════════════════════════════════════════
       PUBLIC RESULT VIEW PARTIAL — RESPONSIVE & CLEAN
    ═══════════════════════════════════════════════ */
    .res-section { padding: 0; position: relative; animation: fadeInUp 0.4s ease; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Header Card ── */
    .res-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        padding: 24px 18px 20px;
        color: white;
        text-align: center;
        border-radius: 16px;
        margin-bottom: 18px;
        position: relative;
        overflow: hidden;
    }
    .res-header::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 180px; height: 180px;
        background: rgba(99,102,241,0.15);
        border-radius: 50%;
        filter: blur(30px);
    }
    .res-header-inner { position: relative; z-index: 2; }

    .res-avatar {
        width: 72px; height: 72px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 3px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        margin: 0 auto 10px;
        overflow: hidden;
    }
    .res-avatar img {
        width: 100%; height: 100%;
        object-fit: cover; border-radius: 50%;
    }

    .res-student-name {
        font-size: 1.15rem; font-weight: 800;
        color: #fff; margin-bottom: 5px;
        letter-spacing: 0.3px;
    }
    .res-student-meta {
        font-size: 0.76rem; color: rgba(255,255,255,0.78);
        display: flex; justify-content: center;
        flex-wrap: wrap; gap: 8px 14px;
    }
    .res-student-meta span { display: flex; align-items: center; gap: 4px; }

    .res-status-pill {
        display: inline-flex; align-items: center;
        padding: 5px 16px; border-radius: 50px;
        font-weight: 800; font-size: 0.75rem;
        margin-top: 12px; letter-spacing: 0.3px;
        border: none;
    }
    .res-pill-pass { background: #10b981; color: #fff; }
    .res-pill-fail { background: #ef4444; color: #fff; }

    /* ── Stats Bar ── */
    .res-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        background: #f8fafc;
        margin-bottom: 16px;
        overflow: hidden;
    }
    @media (max-width: 576px) {
        .res-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .res-stat-box:nth-child(2) { border-right: none; }
        .res-stat-box:nth-child(1), .res-stat-box:nth-child(2) { border-bottom: 1.5px solid #e2e8f0; }
    }
    .res-stat-box {
        padding: 12px 6px;
        text-align: center;
        border-right: 1.5px solid #e2e8f0;
    }
    .res-stat-box:last-child { border-right: none; }
    .res-stat-label {
        font-size: 0.65rem; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        font-weight: 700; margin-bottom: 2px; display: block;
    }
    .res-stat-val {
        font-size: 1.2rem; font-weight: 800; color: #0f172a;
    }

    /* ── Exam/Session info ── */
    .res-exam-info {
        background: linear-gradient(135deg, #eff6ff, #f0fdf4);
        border: 1.5px solid #dbeafe;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 12px;
    }
    .res-exam-icon {
        width: 38px; height: 38px;
        background: #3b82f6; color: white;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0;
    }
    .res-exam-title {
        font-size: 0.92rem; font-weight: 800; color: #1e293b;
    }
    .res-exam-session {
        font-size: 0.75rem; color: #64748b; font-weight: 600;
    }

    /* ── Subject Marks Table Responsive Wrapper ── */
    .res-subjects-section {
        margin-bottom: 18px;
    }
    .res-subjects-title {
        font-size: 0.82rem; font-weight: 800;
        color: #334155; text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .res-scroll-hint {
        font-size: 0.7rem; font-weight: 600; color: #64748b;
        display: none; align-items: center; gap: 4px;
    }
    @media (max-width: 768px) {
        .res-scroll-hint { display: inline-flex; }
    }

    .res-table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
    }
    .res-subject-table {
        width: 100%;
        min-width: 540px;
        border-collapse: collapse;
        font-size: 0.82rem;
        margin: 0;
    }
    .res-subject-table thead tr th {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: rgba(255,255,255,0.95);
        padding: 9px 10px;
        font-size: 0.68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
        border: none;
        white-space: nowrap;
    }
    .res-subject-table tbody tr td {
        padding: 9px 10px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #374151;
    }
    .res-subject-table tbody tr:last-child td { border-bottom: none; }
    .res-subject-table tbody tr:hover { background: #fafbff; }
    .res-subject-table tbody tr.row-absent { background: #fff5f5; }

    .sub-meta-pill {
        display: inline-block;
        font-size: 0.68rem;
        color: #64748b;
        margin-top: 2px;
        font-weight: 600;
    }

    .res-grade-chip {
        display: inline-flex; align-items: center;
        padding: 2px 9px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 800;
    }
    .grade-ap { background: #dcfce7; color: #15803d; }
    .grade-a  { background: #d1fae5; color: #047857; }
    .grade-am { background: #e0f2fe; color: #0369a1; }
    .grade-b  { background: #dbeafe; color: #1d4ed8; }
    .grade-c  { background: #fef9c3; color: #a16207; }
    .grade-d  { background: #ffedd5; color: #c2410c; }
    .grade-f  { background: #fee2e2; color: #b91c1c; }
    .grade-na { background: #f1f5f9; color: #94a3b8; }

    /* ── Download Button ── */
    .res-action-btn {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff !important;
        font-weight: 800; border: none;
        border-radius: 12px;
        transition: all 0.25s;
        padding: 13px 20px;
        display: flex; align-items: center; justify-content: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 6px 18px rgba(79,70,229,0.28);
        font-size: 0.92rem;
    }
    .res-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(79,70,229,0.38);
        color: #fff !important;
    }
</style>

@php
    $isFailed     = ($studentSummary['fail'] ?? 0) > 0;
    $gpa          = number_format($studentSummary['gpa'] ?? 0, 2);
    $totalMarks   = $studentSummary['total'] ?? 0;
    $meritRank    = $meritPosition ?? 'N/A';
    $failSubjects = $studentSummary['fail'] ?? 0;
    $studentYear  = $yearName ?? $student->academicYear?->name ?? 'N/A';

    $fmtVal = function($val) {
        if ($val === null || $val === '') return '';
        if (!is_numeric($val)) return $val;
        return ((float)$val == (int)$val) ? (int)$val : (float)$val;
    };
@endphp

<div class="res-section">

    {{-- ── Student Header ── --}}
    <div class="res-header">
        <div class="res-header-inner">
            <div class="res-avatar">
                <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                     alt="{{ $student->name }}"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=4f46e5&color=fff'">
            </div>
            <div class="res-student-name">{{ strtoupper($student->name) }}</div>
            <div class="res-student-meta">
                <span><i class="fa-solid fa-id-card"></i> {{ $student->student_id }}</span>
                <span><i class="fa-solid fa-chalkboard"></i> Class: {{ $student->class?->name ?? 'N/A' }}</span>
                <span><i class="fa-solid fa-hashtag"></i> Roll: {{ $student->roll }}</span>
            </div>
            <div class="res-status-pill {{ $isFailed ? 'res-pill-fail' : 'res-pill-pass' }}">
                <i class="fa-solid {{ $isFailed ? 'fa-circle-xmark' : 'fa-circle-check' }} me-2"></i>
                {{ $isFailed ? "FAILED — {$failSubjects} Subject(s)" : 'RESULT: PASSED' }}
            </div>
        </div>
    </div>

    {{-- ── Stats Grid ── --}}
    <div class="res-stats-grid">
        <div class="res-stat-box">
            <span class="res-stat-label">GPA</span>
            <span class="res-stat-val {{ $isFailed ? 'text-danger' : 'text-success' }}">{{ $gpa }}</span>
        </div>
        <div class="res-stat-box">
            <span class="res-stat-label">Total Marks</span>
            <span class="res-stat-val">{{ $fmtVal($totalMarks) }}</span>
        </div>
        <div class="res-stat-box">
            <span class="res-stat-label">Merit Position</span>
            <span class="res-stat-val" style="color:#6366f1;">#{{ $meritRank }}</span>
        </div>
        <div class="res-stat-box">
            <span class="res-stat-label">Status</span>
            <span class="res-stat-val" style="font-size:0.95rem; {{ $isFailed ? 'color:#ef4444;' : 'color:#10b981;' }}">
                {{ $isFailed ? 'Failed' : 'Passed' }}
            </span>
        </div>
    </div>

    {{-- ── Exam Info ── --}}
    <div class="res-exam-info">
        <div class="res-exam-icon"><i class="fa-solid fa-file-pen"></i></div>
        <div style="flex:1; min-width:0;">
            <div class="res-exam-title">{{ $exam->name ?? 'Examination' }}</div>
            <div class="res-exam-session">
                <i class="fa-solid fa-calendar-days me-1"></i>
                Academic Session: <strong>{{ $studentYear }}</strong>
            </div>
        </div>
    </div>

    {{-- ── Per-Subject Marks Breakdown (Responsive Table) ── --}}
    @if(!empty($studentSubjectMarks))
    <div class="res-subjects-section">
        <div class="res-subjects-title">
            <span>
                <i class="fa-solid fa-table-list me-1" style="color:#6366f1;"></i>
                Subject-wise Marks Breakdown
            </span>
            <span class="res-scroll-hint">
                <i class="fa-solid fa-arrows-left-right"></i> স্ক্রল করুন
            </span>
        </div>

        <div class="res-table-responsive">
            <table class="res-subject-table">
                <thead>
                    <tr>
                        <th style="width: 5%; text-align:center;">#</th>
                        <th style="width: 35%;">Subject</th>
                        <th style="text-align:center; width: 15%;">Marks</th>
                        <th style="text-align:center; width: 20%;">Combined Total</th>
                        <th style="text-align:center; width: 13%;">Grade</th>
                        <th style="text-align:center; width: 12%;">Point</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentSubjectMarks as $i => $sm)
                        @php
                            $isAbsent   = ($sm['status'] ?? '') === 'absent';
                            $gradeClass = match($sm['grade'] ?? '') {
                                'A+'    => 'grade-ap',
                                'A'     => 'grade-a',
                                'A-'    => 'grade-am',
                                'B'     => 'grade-b',
                                'C'     => 'grade-c',
                                'D'     => 'grade-d',
                                'F'     => 'grade-f',
                                default => 'grade-na',
                            };

                            $hasBreakdown = ($sm['cq'] !== null || $sm['mcq'] !== null || $sm['practical'] !== null);
                            $breakdownParts = [];
                            if (($sm['cq'] ?? null) !== null) $breakdownParts[] = 'CQ: ' . $fmtVal($sm['cq']);
                            if (($sm['mcq'] ?? null) !== null) $breakdownParts[] = 'MCQ: ' . $fmtVal($sm['mcq']);
                            if (($sm['practical'] ?? null) !== null) $breakdownParts[] = 'Prac: ' . $fmtVal($sm['practical']);
                        @endphp
                        <tr class="{{ $isAbsent ? 'row-absent' : '' }}">
                            <td style="color:#94a3b8; font-weight:700; text-align:center; font-size:0.75rem;">{{ $i + 1 }}</td>
                            <td>
                                <div style="font-weight:700; color:#1e293b;">{{ strtoupper($sm['subject']) }}</div>
                                @if(!empty($breakdownParts))
                                    <div class="sub-meta-pill">
                                        <i class="fa-solid fa-angles-right me-1 text-primary"></i>{{ implode(' | ', $breakdownParts) }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align:center; font-weight:700;">
                                @if($isAbsent)
                                    <span style="color:#ef4444; font-size:0.75rem;">Absent</span>
                                @elseif(($sm['marks'] ?? null) !== null)
                                    {{ $fmtVal($sm['marks']) }}
                                    <span style="color:#94a3b8; font-size:0.72rem;"> / {{ $fmtVal($sm['full_mark']) }}</span>
                                @else
                                    <span style="color:#94a3b8; font-size:0.75rem;">—</span>
                                @endif
                            </td>

                            @if(!empty($sm['is_paired']))
                                @if($sm['is_first'])
                                    <td rowspan="2" style="text-align:center; vertical-align: middle; font-weight:800; background-color: #fafbff; color:#1e293b;">
                                        {{ $fmtVal($sm['combined_marks']) }} <span style="color:#94a3b8; font-size:0.72rem;"> / {{ $fmtVal($sm['combined_full']) }}</span>
                                    </td>
                                    <td rowspan="2" style="text-align:center; vertical-align: middle;">
                                        <span class="res-grade-chip {{ $gradeClass }}">{{ $sm['grade'] ?? '—' }}</span>
                                    </td>
                                    <td rowspan="2" style="text-align:center; vertical-align: middle; font-weight:800; color:#475569;">
                                        {{ ($sm['point'] ?? null) !== null ? number_format($sm['point'], 2) : '—' }}
                                    </td>
                                @endif
                            @else
                                <td style="text-align:center; font-weight:800; color:#1e293b;">
                                    {{ $fmtVal($sm['combined_marks']) }} <span style="color:#94a3b8; font-size:0.72rem;"> / {{ $fmtVal($sm['combined_full']) }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="res-grade-chip {{ $gradeClass }}">{{ $sm['grade'] ?? '—' }}</span>
                                </td>
                                <td style="text-align:center; font-weight:800; color:#475569;">
                                    {{ ($sm['point'] ?? null) !== null ? number_format($sm['point'], 2) : '—' }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ── Download Marksheet ── --}}
    <a href="{{ route('frontend.generate_marksheet', ['tenant' => $tenant, 'studentId' => $student->id, 'classId' => $classId ?? $student->class_id, 'examId' => $exam->id]) }}"
       class="res-action-btn w-100">
        <i class="fa-solid fa-file-arrow-down"></i>
        Download Marksheet (PDF)
    </a>

</div>
