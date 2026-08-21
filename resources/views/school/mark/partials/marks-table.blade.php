{{-- ══════════════════════════════════════════════
     Marks Entry Table Partial
     — Desktop: table view
     — Mobile/Tablet: card-based layout
══════════════════════════════════════════════ --}}

<style>
    /* ══ Shared Mark Input Spin Remove ══ */
    input.mark-input::-webkit-outer-spin-button,
    input.mark-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input.mark-input[type=number] { -moz-appearance: textfield; }

    /* ══ Grade Pill (Entry Mode) ══ */
    .grade-pill-entry {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 28px;
        border-radius: 7px;
        font-size: 0.72rem;
        font-weight: 800;
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0 6px;
        flex-shrink: 0;
    }
    .gpe-ap { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
    .gpe-a  { background: #d1fae5; color: #047857; border-color: #a7f3d0; }
    .gpe-am { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
    .gpe-b  { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
    .gpe-c  { background: #fef9c3; color: #a16207; border-color: #fef08a; }
    .gpe-d  { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }
    .gpe-f  { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
    .gpe-default { background: #f1f5f9; color: #94a3b8; border-color: #e2e8f0; }

    /* ══ Mark Input Box ══ */
    .entry-mark-box {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #cbd5e1;
        border-radius: 9px;
        background: #fff;
        overflow: hidden;
        height: 34px;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .entry-mark-box:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }
    .mark-input {
        width: 44px;
        height: 100%;
        text-align: center;
        border: none;
        font-size: 0.86rem;
        font-weight: 700;
        color: #0f172a;
        background: transparent;
        outline: none;
        padding: 0 3px;
    }
    .mark-input:focus { background: transparent; }
    .mark-input.is-valid  { color: #15803d; }
    .mark-input.is-invalid{ color: #dc2626; }
    .mark-denom {
        font-size: 0.68rem;
        font-weight: 600;
        color: #94a3b8;
        padding: 0 7px 0 5px;
        border-left: 1px solid #e2e8f0;
        height: 100%;
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        white-space: nowrap;
        user-select: none;
    }

    /* ══ Status Toggle ══ */
    .entry-status-toggle {
        display: inline-flex;
        border-radius: 8px;
        overflow: hidden;
        border: 1.5px solid #cbd5e1;
        background: #f8fafc;
        height: 34px;
        flex-shrink: 0;
    }
    .entry-status-toggle .est-btn {
        padding: 0 9px;
        font-size: 0.72rem;
        font-weight: 700;
        border: none;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.18s;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        height: 100%;
    }
    .entry-status-toggle .est-btn:first-child { border-right: 1.5px solid #cbd5e1; }
    .entry-status-toggle .est-btn.est-present { background: #dcfce7; color: #16a34a; }
    .entry-status-toggle .est-btn.est-absent  { background: #fee2e2; color: #dc2626; }

    /* ══ Section Header ══ */
    .entry-table-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .entry-table-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .full-mark-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        color: #7c3aed;
        border: 1px solid #ddd6fe;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* ══════════════════════════════════════════════
       DESKTOP TABLE
    ══════════════════════════════════════════════ */
    .entry-desktop-table { display: block; }
    .entry-mobile-cards  { display: none; }

    .entry-data-table { width: 100%; border-collapse: collapse; }
    .entry-data-table thead th {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 13px 16px;
        border: none;
        white-space: nowrap;
    }
    .entry-data-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.87rem;
    }
    .entry-data-table tbody tr:hover { background: #fafbff; }
    .entry-data-table tbody tr.row-absent { background: #fff8f8 !important; }

    .student-id-cell { font-size: 0.78rem; color: #94a3b8; font-weight: 600; }
    .roll-cell { font-weight: 800; color: #1e293b; }
    .name-cell { font-weight: 700; color: #0f172a; }

    /* ══════════════════════════════════════════════
       MOBILE STUDENT CARD
    ══════════════════════════════════════════════ */
    .entry-student-card {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 13px 15px;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(15,23,42,0.04);
        transition: all 0.22s;
    }
    .entry-student-card:hover { border-color: #c7d2fe; box-shadow: 0 6px 20px rgba(99,102,241,0.08); }
    .entry-student-card.row-absent { background: #fff8f8 !important; border-color: #fecaca !important; }

    .esc-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        gap: 10px;
    }
    .esc-student-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        flex: 1;
    }
    .esc-avatar {
        width: 40px; height: 40px;
        border-radius: 11px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(79,70,229,0.22);
    }
    .esc-name {
        font-size: 0.87rem;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .esc-meta {
        display: flex;
        gap: 4px;
        margin-top: 3px;
        flex-wrap: nowrap;  /* keep roll+id on same line */
        align-items: center;
    }
    .esc-tag {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        font-size: 0.6rem;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        white-space: nowrap;
    }
    .esc-roll-tag { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .esc-id-tag   { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }

    /* bottom row: mark + status always side by side */
    .esc-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-top: 9px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: nowrap;  /* always one row */
    }
    .esc-mark-group {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    /* ══════════════════════════════════════════════
       DARK MODE
    ══════════════════════════════════════════════ */
    body.dark-mode .entry-student-card,
    [data-bs-theme="dark"] .entry-student-card {
        background: #0c1427 !important;
        border-color: #1a253b !important;
    }
    body.dark-mode .entry-student-card.row-absent,
    [data-bs-theme="dark"] .entry-student-card.row-absent {
        background: #1c0d0d !important;
        border-color: #7f1d1d !important;
    }
    body.dark-mode .esc-name,
    [data-bs-theme="dark"] .esc-name { color: #f8fafc !important; }
    body.dark-mode .entry-mark-box,
    [data-bs-theme="dark"] .entry-mark-box { background: #060c18 !important; border-color: #1a253b !important; }
    body.dark-mode .mark-input,
    [data-bs-theme="dark"] .mark-input { color: #f8fafc !important; }
    body.dark-mode .mark-denom,
    [data-bs-theme="dark"] .mark-denom { background: #060c18 !important; border-color: #1a253b !important; }
    body.dark-mode .entry-data-table tbody td,
    [data-bs-theme="dark"] .entry-data-table tbody td { border-color: #1a253b !important; }
    body.dark-mode .entry-data-table tbody tr:hover,
    [data-bs-theme="dark"] .entry-data-table tbody tr:hover { background: #0c1427 !important; }
    body.dark-mode .entry-table-title,
    [data-bs-theme="dark"] .entry-table-title { color: #f8fafc !important; }
    body.dark-mode .name-cell,
    [data-bs-theme="dark"] .name-cell { color: #f8fafc !important; }
    body.dark-mode .roll-cell,
    [data-bs-theme="dark"] .roll-cell { color: #f8fafc !important; }

    /* ══════════════════════════════════════════════
       RESPONSIVE BREAKPOINTS
    ══════════════════════════════════════════════ */
    @media (max-width: 991.98px) {
        .entry-desktop-table { display: none !important; }
        .entry-mobile-cards  { display: block !important; }
    }
    @media (max-width: 767.98px) {
        .entry-table-header { padding: 12px 14px; }
        .entry-table-title  { font-size: 0.9rem; }
        .entry-mark-box { height: 32px; }
        .mark-input { width: 40px; font-size: 0.82rem; }
        .entry-status-toggle { height: 32px; }
        .entry-status-toggle .est-btn { padding: 0 8px; font-size: 0.7rem; }
        .grade-pill-entry { height: 26px; min-width: 28px; font-size: 0.68rem; }
    }
    @media (max-width: 399.98px) {
        .esc-name { font-size: 0.82rem; }
        .entry-status-toggle .est-btn { padding: 0 6px; }
    }
</style>

<div class="data-table-card">

    {{-- ══ TABLE HEADER ══ --}}
    <div class="entry-table-header">
        <h5 class="entry-table-title">
            <i class="fa-solid fa-file-pen" style="color:#7c3aed;"></i>
            Enter Marks
        </h5>
        <span class="full-mark-badge">
            <i class="fa-solid fa-bullseye" style="font-size:0.68rem;"></i>
            Full Mark: {{ $fullMarks }}
        </span>
    </div>

    {{-- ══════════════════════════════════════════════
         DESKTOP TABLE (hidden on tablet/mobile)
    ══════════════════════════════════════════════ --}}
    <div class="entry-desktop-table" style="overflow-x:auto;">
        <table class="entry-data-table">
            <thead>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:6%;">Roll</th>
                    <th style="width:20%;">Student Name</th>
                    <th style="width:11%; text-align:center;">CQ</th>
                    <th style="width:11%; text-align:center;">MCQ</th>
                    <th style="width:11%; text-align:center;">Practical</th>
                    <th style="width:12%; text-align:center;">Total (Obt.)</th>
                    <th style="width:7%; text-align:center;">Grade</th>
                    <th style="width:12%; text-align:center;">Attendance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        $sts   = $marksWithGrade[$student->id]['status'] ?? 'present';
                        $cq    = $marksWithGrade[$student->id]['cq'] ?? '';
                        $mcq   = $marksWithGrade[$student->id]['mcq'] ?? '';
                        $prac  = $marksWithGrade[$student->id]['practical'] ?? '';
                        $mval  = $marksWithGrade[$student->id]['marks'] ?? '';
                        $gval  = $marksWithGrade[$student->id]['grade'] ?? '-';
                        $inits = strtoupper(substr($student->name, 0, 1));
                        $gradeClass = match($gval) {
                            'A+' => 'gpe-ap', 'A' => 'gpe-a', 'A-' => 'gpe-am',
                            'B'  => 'gpe-b',  'C' => 'gpe-c', 'D'  => 'gpe-d',
                            'F'  => 'gpe-f',  default => 'gpe-default'
                        };
                    @endphp
                    <tr class="align-middle {{ $sts === 'absent' ? 'row-absent' : '' }}" data-student="{{ $student->id }}">
                        <td class="student-id-cell">{{ $student->student_id }}</td>
                        <td class="roll-cell">{{ $student->roll }}</td>
                        <td class="name-cell">{{ strtoupper($student->name) }}</td>

                        {{-- CQ --}}
                        <td class="text-center">
                            <div class="entry-mark-box" style="width:70px;">
                                <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                       class="mark-input cq-input"
                                       style="width:100%;"
                                       data-student="{{ $student->id }}"
                                       data-type="cq"
                                       placeholder="CQ"
                                       value="{{ $cq }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- MCQ --}}
                        <td class="text-center">
                            <div class="entry-mark-box" style="width:70px;">
                                <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                       class="mark-input mcq-input"
                                       style="width:100%;"
                                       data-student="{{ $student->id }}"
                                       data-type="mcq"
                                       placeholder="MCQ"
                                       value="{{ $mcq }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- Practical --}}
                        <td class="text-center">
                            <div class="entry-mark-box" style="width:70px;">
                                <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                       class="mark-input prac-input"
                                       style="width:100%;"
                                       data-student="{{ $student->id }}"
                                       data-type="practical"
                                       placeholder="Prac."
                                       value="{{ $prac }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- Total Obtained --}}
                        <td class="text-center">
                            <div class="entry-mark-box">
                                <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                       class="mark-input total-input"
                                       data-student="{{ $student->id }}"
                                       data-type="total"
                                       data-fullmarks="{{ $fullMarks }}"
                                       placeholder="00"
                                       value="{{ $mval }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                                <span class="mark-denom">/ {{ $fullMarks }}</span>
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="grade-pill-entry {{ $gradeClass }}" id="grade-{{ $student->id }}">
                                {{ $sts == 'absent' ? 'ABS' : ($gval ?? '-') }}
                            </span>
                        </td>

                        <td class="text-center">
                            {{-- Hidden status-input for JS compatibility --}}
                            <input type="hidden" class="status-input"
                                   data-student="{{ $student->id }}"
                                   value="{{ $sts }}">
                            <div class="entry-status-toggle d-inline-flex">
                                <button type="button"
                                        class="est-btn {{ $sts == 'present' ? 'est-present' : '' }}"
                                        onclick="setEntryStatus({{ $student->id }}, 'present', this)">
                                    <i class="fa-solid fa-check"></i>
                                    <span>Present</span>
                                </button>
                                <button type="button"
                                        class="est-btn {{ $sts == 'absent' ? 'est-absent' : '' }}"
                                        onclick="setEntryStatus({{ $student->id }}, 'absent', this)">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>Absent</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ══════════════════════════════════════════════
         MOBILE CARD VIEW (shown on tablet/mobile)
    ══════════════════════════════════════════════ --}}
    <div class="entry-mobile-cards p-3">
        @foreach($students as $student)
            @php
                $sts   = $marksWithGrade[$student->id]['status'] ?? 'present';
                $cq    = $marksWithGrade[$student->id]['cq'] ?? '';
                $mcq   = $marksWithGrade[$student->id]['mcq'] ?? '';
                $prac  = $marksWithGrade[$student->id]['practical'] ?? '';
                $mval  = $marksWithGrade[$student->id]['marks']  ?? '';
                $gval  = $marksWithGrade[$student->id]['grade']  ?? '-';
                $inits = strtoupper(substr($student->name, 0, 1));
                $gradeClass = match($gval) {
                    'A+' => 'gpe-ap', 'A' => 'gpe-a', 'A-' => 'gpe-am',
                    'B'  => 'gpe-b',  'C' => 'gpe-c', 'D'  => 'gpe-d',
                    'F'  => 'gpe-f',  default => 'gpe-default'
                };
            @endphp
            <div class="entry-student-card {{ $sts === 'absent' ? 'row-absent' : '' }}"
                 id="card-{{ $student->id }}"
                 data-student="{{ $student->id }}">

                {{-- Top: Avatar + Info --}}
                <div class="esc-top">
                    <div class="esc-student-info">
                        <div class="esc-avatar">{{ $inits }}</div>
                        <div style="min-width:0; flex:1;">
                            <div class="esc-name">{{ strtoupper($student->name) }}</div>
                            <div class="esc-meta">
                                <span class="esc-tag esc-roll-tag">
                                    <i class="fa-solid fa-hashtag" style="font-size:0.55rem;"></i>
                                    Roll {{ $student->roll }}
                                </span>
                                <span class="esc-tag esc-id-tag">
                                    <i class="fa-solid fa-id-badge" style="font-size:0.55rem;"></i>
                                    {{ $student->student_id }}
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- Grade pill always visible top-right --}}
                    <span class="grade-pill-entry {{ $gradeClass }}" id="grade-{{ $student->id }}">
                        {{ $sts == 'absent' ? 'ABS' : ($gval ?? '-') }}
                    </span>
                </div>

                {{-- Middle: CQ, MCQ, Prac Inputs --}}
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="flex-fill">
                        <label style="font-size:10px;font-weight:700;color:#64748b;">CQ</label>
                        <div class="entry-mark-box w-100">
                            <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                   class="mark-input cq-input w-100"
                                   data-student="{{ $student->id }}"
                                   data-type="cq"
                                   placeholder="CQ"
                                   value="{{ $cq }}"
                                   {{ $sts == 'absent' ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <label style="font-size:10px;font-weight:700;color:#64748b;">MCQ</label>
                        <div class="entry-mark-box w-100">
                            <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                   class="mark-input mcq-input w-100"
                                   data-student="{{ $student->id }}"
                                   data-type="mcq"
                                   placeholder="MCQ"
                                   value="{{ $mcq }}"
                                   {{ $sts == 'absent' ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <label style="font-size:10px;font-weight:700;color:#64748b;">Practical</label>
                        <div class="entry-mark-box w-100">
                            <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                   class="mark-input prac-input w-100"
                                   data-student="{{ $student->id }}"
                                   data-type="practical"
                                   placeholder="Prac"
                                   value="{{ $prac }}"
                                   {{ $sts == 'absent' ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>

                {{-- Bottom: Total mark input + Status toggle --}}
                <div class="esc-bottom">
                    <div class="esc-mark-group">
                        <label style="font-size:11px;font-weight:700;color:#334155;">Total:</label>
                        <div class="entry-mark-box">
                            <input type="number" step="any" min="0" max="{{ $fullMarks }}"
                                   class="mark-input total-input"
                                   data-student="{{ $student->id }}"
                                   data-type="total"
                                   data-fullmarks="{{ $fullMarks }}"
                                   placeholder="00"
                                   value="{{ $mval }}"
                                   {{ $sts == 'absent' ? 'disabled' : '' }}>
                            <span class="mark-denom">/ {{ $fullMarks }}</span>
                        </div>
                    </div>

                    {{-- Status Toggle --}}
                    <div>
                        {{-- Hidden status-input for JS compatibility --}}
                        <input type="hidden" class="status-input"
                               data-student="{{ $student->id }}"
                               value="{{ $sts }}">
                        <div class="entry-status-toggle">
                            <button type="button"
                                    class="est-btn {{ $sts == 'present' ? 'est-present' : '' }}"
                                    onclick="setEntryStatus({{ $student->id }}, 'present', this)">
                                <i class="fa-solid fa-check"></i>
                                <span>Present</span>
                            </button>
                            <button type="button"
                                    class="est-btn {{ $sts == 'absent' ? 'est-absent' : '' }}"
                                    onclick="setEntryStatus({{ $student->id }}, 'absent', this)">
                                <i class="fa-solid fa-xmark"></i>
                                <span>Absent</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<script>
// ── Entry Status Toggle (shared desktop + mobile) ──
function setEntryStatus(sid, value, clickedBtn) {
    // Find all toggle wrappers for this student (desktop + mobile)
    document.querySelectorAll(`[data-student="${sid}"] .entry-status-toggle, .entry-status-toggle[data-student="${sid}"]`).forEach(wrap => {
        wrap.querySelectorAll('.est-btn').forEach(b => b.classList.remove('est-present', 'est-absent'));
    });
    // Apply active class to clicked button and its mirror
    document.querySelectorAll(`.est-btn[onclick*="setEntryStatus(${sid}, '${value}'"]`).forEach(b => {
        b.classList.add(value === 'absent' ? 'est-absent' : 'est-present');
    });

    // Update hidden inputs
    document.querySelectorAll(`.status-input[data-student="${sid}"]`).forEach(inp => {
        inp.value = value;
    });

    // Enable/disable all mark inputs for this student
    document.querySelectorAll(`.mark-input[data-student="${sid}"]`).forEach(inp => {
        if (value === 'absent') {
            inp.value    = 0;
            inp.disabled = true;
        } else {
            inp.disabled = false;
        }
    });

    // Update grade display
    const gradeEl = document.getElementById('grade-' + sid);
    if (gradeEl) {
        if (value === 'absent') {
            gradeEl.textContent = 'ABS';
            gradeEl.className = 'grade-pill-entry gpe-f';
        } else {
            gradeEl.textContent = '-';
            gradeEl.className = 'grade-pill-entry gpe-default';
        }
    }

    // Toggle absent class on card
    const card = document.getElementById('card-' + sid);
    if (card) {
        value === 'absent' ? card.classList.add('row-absent') : card.classList.remove('row-absent');
    }

    // Trigger AJAX via jQuery
    const markInput  = $(`.mark-input[data-student="${sid}"]`).first();
    const classId    = $('#hidden_class_id').val();
    const examId     = $('#hidden_exam_id').val();
    const subjectId  = $('#hidden_subject_id').val();

    $.ajax({
        url: "{{ route('marks.statusUpdate', auth()->user()->school->slug) }}",
        type: "POST",
        data: {
            student_id: sid,
            class_id:   classId,
            exam_id:    examId,
            subject_id: subjectId,
            status:     value,
            marks:      markInput.val(),
            _token:     "{{ csrf_token() }}"
        }
    });
}
</script>