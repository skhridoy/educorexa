<style>
    /* ═══════════════════════════════════════════════
       PUBLIC RESULT VIEW PARTIAL — PREMIUM DESIGN
    ═══════════════════════════════════════════════ */
    .res-section { padding: 0; position: relative; animation: fadeInUp 0.4s ease; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Header Card ── */
    .res-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        padding: 28px 24px 24px;
        color: white;
        text-align: center;
        border-radius: 18px;
        margin-bottom: 20px;
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
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 3px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        margin: 0 auto 12px;
        overflow: hidden;
    }
    .res-avatar img {
        width: 100%; height: 100%;
        object-fit: cover; border-radius: 50%;
    }

    .res-student-name {
        font-size: 1.2rem; font-weight: 800;
        color: #fff; margin-bottom: 6px;
        font-family: 'Outfit', sans-serif;
    }
    .res-student-meta {
        font-size: 0.78rem; color: rgba(255,255,255,0.7);
        display: flex; justify-content: center;
        flex-wrap: wrap; gap: 10px;
    }
    .res-student-meta span { display: flex; align-items: center; gap: 4px; }

    .res-status-pill {
        display: inline-flex; align-items: center;
        padding: 6px 18px; border-radius: 50px;
        font-weight: 800; font-size: 0.78rem;
        margin-top: 14px; letter-spacing: 0.3px;
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
        margin-bottom: 18px;
        overflow: hidden;
    }
    .res-stat-box {
        padding: 14px 8px;
        text-align: center;
        border-right: 1.5px solid #e2e8f0;
    }
    .res-stat-box:last-child { border-right: none; }
    .res-stat-label {
        font-size: 0.67rem; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.5px;
        font-weight: 700; margin-bottom: 4px; display: block;
    }
    .res-stat-val {
        font-size: 1.3rem; font-weight: 800; color: #0f172a;
    }

    /* ── Exam/Session info ── */
    .res-exam-info {
        background: linear-gradient(135deg, #eff6ff, #f0fdf4);
        border: 1.5px solid #dbeafe;
        border-radius: 12px;
        padding: 14px 18px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .res-exam-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: #4f46e5;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(79,70,229,0.12);
        flex-shrink: 0;
    }
    .res-exam-title {
        font-size: 0.95rem; font-weight: 800; color: #0f172a;
        margin: 0 0 2px;
    }
    .res-exam-session {
        font-size: 0.77rem; color: #64748b; font-weight: 600;
    }

    /* ── Subject Marks Table ── */
    .res-subjects-section {
        margin-bottom: 18px;
    }
    .res-subjects-title {
        font-size: 0.8rem; font-weight: 800;
        color: #475569; text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex; align-items: center; gap: 6px;
    }
    .res-subject-table {
        width: 100%; border-collapse: separate;
        border-spacing: 0;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        font-size: 0.82rem;
    }
    .res-subject-table thead tr th {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: rgba(255,255,255,0.9);
        padding: 9px 12px;
        text-align: left;
        font-size: 0.68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
        border: none;
    }
    .res-subject-table tbody tr td {
        padding: 9px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #374151;
    }
    .res-subject-table tbody tr:last-child td { border-bottom: none; }
    .res-subject-table tbody tr:hover { background: #fafbff; }
    .res-subject-table tbody tr.row-absent { background: #fff5f5; }

    .res-grade-chip {
        display: inline-flex; align-items: center;
        padding: 2px 10px; border-radius: 20px;
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
        padding: 14px 20px;
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
    $isFailed    = ($studentSummary['fail'] ?? 0) > 0;
    $gpa         = number_format($studentSummary['gpa'] ?? 0, 2);
    $totalMarks  = $studentSummary['total'] ?? 0;
    $meritRank   = $meritPosition ?? 'N/A';
    $failSubjects = $studentSummary['fail'] ?? 0;
    $studentYear = $yearName ?? $student->academicYear?->name ?? 'N/A';
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
            <span class="res-stat-label">Total</span>
            <span class="res-stat-val">{{ $totalMarks }}</span>
        </div>
        <div class="res-stat-box">
            <span class="res-stat-label">Position</span>
            <span class="res-stat-val" style="color:#6366f1;">#{{ $meritRank }}</span>
        </div>
        <div class="res-stat-box">
            <span class="res-stat-label">Status</span>
            <span class="res-stat-val" style="font-size:0.9rem; {{ $isFailed ? 'color:#ef4444;' : 'color:#10b981;' }}">
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

    {{-- ── Per-Subject Marks Breakdown ── --}}
    @if(!empty($studentSubjectMarks))
    <div class="res-subjects-section">
        <div class="res-subjects-title">
            <i class="fa-solid fa-table-list" style="color:#6366f1;"></i>
            Subject-wise Marks Breakdown
        </div>
        <table class="res-subject-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th style="text-align:center;">Marks</th>
                    <th style="text-align:center;">Grade</th>
                    <th style="text-align:center;">Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentSubjectMarks as $i => $sm)
                    @php
                        $isAbsent   = $sm['status'] === 'absent';
                        $gradeClass = match($sm['grade']) {
                            'A+'    => 'grade-ap',
                            'A'     => 'grade-a',
                            'A-'    => 'grade-am',
                            'B'     => 'grade-b',
                            'C'     => 'grade-c',
                            'D'     => 'grade-d',
                            'F'     => 'grade-f',
                            default => 'grade-na',
                        };
                    @endphp
                    <tr class="{{ $isAbsent ? 'row-absent' : '' }}">
                        <td style="color:#94a3b8; font-weight:700; font-size:0.75rem;">{{ $i + 1 }}</td>
                        <td style="font-weight:700; color:#1e293b;">{{ $sm['subject'] }}</td>
                        <td style="text-align:center; font-weight:700;">
                            @if($isAbsent)
                                <span style="color:#ef4444; font-size:0.75rem;">Absent</span>
                            @elseif($sm['marks'] !== null)
                                {{ $sm['marks'] }}
                                <span style="color:#94a3b8; font-size:0.72rem;"> / {{ $sm['full_mark'] }}</span>
                            @else
                                <span style="color:#94a3b8; font-size:0.75rem;">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span class="res-grade-chip {{ $gradeClass }}">{{ $sm['grade'] ?? '—' }}</span>
                        </td>
                        <td style="text-align:center; font-weight:700; color:#475569;">
                            {{ $sm['point'] !== null ? number_format($sm['point'], 2) : '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- ── Download Marksheet ── --}}
    <a href="{{ route('frontend.generate_marksheet', ['tenant' => $tenant, 'studentId' => $student->id, 'classId' => $classId ?? $student->class_id, 'examId' => $exam->id]) }}"
       class="res-action-btn w-100">
        <i class="fa-solid fa-file-arrow-down"></i>
        Download Marksheet (PDF)
    </a>

</div>
