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
        min-width: 24px;
        height: 20px;
        border-radius: 6px;
        font-size: 0.58rem;
        font-weight: 800;
        letter-spacing: 0.3px;
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0 4px;
        flex-shrink: 0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }
    .gpe-ap { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #047857; border-color: #a7f3d0; }
    .gpe-a  { background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: #15803d; border-color: #bbf7d0; }
    .gpe-am { background: linear-gradient(135deg, #f0fdfa, #ccfbf1); color: #0f766e; border-color: #99f6e4; }
    .gpe-b  { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #1d4ed8; border-color: #bfdbfe; }
    .gpe-c  { background: linear-gradient(135deg, #fefce8, #fef9c3); color: #a16207; border-color: #fef08a; }
    .gpe-d  { background: linear-gradient(135deg, #fff7ed, #ffedd5); color: #c2410c; border-color: #fed7aa; }
    .gpe-f  { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #b91c1c; border-color: #fca5a5; }
    .gpe-default { background: #f8fafc; color: #94a3b8; border-color: #e2e8f0; }

    /* ══ Mark Input Box ══ */
    .entry-mark-box {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        background: #fff;
        overflow: hidden;
        height: 22px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    .entry-mark-box:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
    }
    .total-box-readonly {
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        cursor: default;
    }
    .total-box-readonly .total-input {
        color: #4338ca !important;
        font-weight: 700 !important;
        font-size: 0.62rem !important;
        cursor: default !important;
        user-select: none !important;
    }
    .total-box-readonly:focus-within {
        border-color: #cbd5e1 !important;
        box-shadow: none !important;
    }
    .mark-input {
        width: 24px;
        height: 100%;
        text-align: center;
        border: none;
        font-size: 0.62rem;
        font-weight: 600;
        color: #0f172a;
        background: transparent;
        outline: none;
        padding: 0 1px;
    }
    .mark-input::placeholder {
        font-size: 0.54rem;
        font-weight: 500;
        color: #94a3b8;
        opacity: 0.9;
    }
    .mark-input:focus { background: transparent; }
    .mark-input.is-valid  { color: #15803d; }
    .mark-input.is-invalid{ color: #dc2626; }
    .mark-denom {
        font-size: 0.48rem;
        font-weight: 600;
        color: #94a3b8;
        padding: 0 3px 0 2px;
        border-left: 1px solid #e2e8f0;
        height: 100%;
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        white-space: nowrap;
        user-select: none;
    }

    /* ══ Status Toggle (Pill Segmented Design) ══ */
    .entry-status-toggle {
        display: inline-flex;
        align-items: center;
        border-radius: 20px;
        background: #f1f5f9;
        padding: 2px;
        border: 1px solid #e2e8f0;
        height: 24px;
        gap: 2px;
        transition: all 0.2s ease;
    }
    .entry-status-toggle .est-btn {
        padding: 0 8px;
        font-size: 0.58rem;
        font-weight: 600;
        border: none;
        border-radius: 14px;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        height: 100%;
    }
    .entry-status-toggle .est-btn:hover:not(.est-present):not(.est-absent) {
        color: #1e293b;
        background: rgba(255, 255, 255, 0.7);
    }
    .entry-status-toggle .est-btn.est-present {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: #ffffff !important;
        box-shadow: 0 1px 4px rgba(16, 185, 129, 0.35);
        font-weight: 700;
    }
    .entry-status-toggle .est-btn.est-absent {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        color: #ffffff !important;
        box-shadow: 0 1px 4px rgba(239, 68, 68, 0.35);
        font-weight: 700;
    }

    /* ══ Section Header ══ */
    .entry-table-header {
        padding: 8px 12px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }
    .entry-table-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .full-mark-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #6d28d9;
        border: 1px solid #c4b5fd;
        border-radius: 20px;
        padding: 2px 9px;
        font-size: 0.62rem;
        font-weight: 800;
        box-shadow: 0 1px 3px rgba(109, 40, 217, 0.1);
    }

    /* ══════════════════════════════════════════════
       DESKTOP TABLE
    ══════════════════════════════════════════════ */
    .entry-desktop-table { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .entry-mobile-cards  { display: none; }

    .entry-data-table { width: 100%; border-collapse: collapse; }
    .entry-data-table thead th {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        font-size: 0.58rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        padding: 5px 6px;
        border: none;
        white-space: nowrap;
    }
    .entry-data-table tbody td {
        padding: 3px 5px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.72rem;
    }
    .entry-data-table tbody tr:hover { background: #fafbff; }
    .entry-data-table tbody tr.row-absent { background: #fff8f8 !important; }

    .student-id-cell { font-size: 0.65rem; color: #64748b; font-weight: 600; white-space: nowrap; }
    .roll-cell { font-weight: 700; color: #1e293b; font-size: 0.74rem; }
    .name-cell { font-weight: 600; color: #0f172a; font-size: 0.72rem; white-space: nowrap; max-width: 120px; overflow: hidden; text-overflow: ellipsis; }


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
    /* Keep desktop table on all screens with horizontal scroll */
    @media (max-width: 991.98px) {
        .entry-desktop-table { display: block !important; overflow-x: auto !important; -webkit-overflow-scrolling: touch !important; }
        .entry-desktop-table table, .entry-data-table { min-width: 680px !important; display: table !important; }
        .entry-mobile-cards  { display: none !important; }
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
        .entry-status-toggle .est-btn { padding: 0 6px; }
    }
</style>

<div class="data-table-card">

    {{-- ══ TABLE HEADER ══ --}}
    <div class="entry-table-header">
        <h5 class="entry-table-title">
            <i class="fa-solid fa-file-pen" style="color:#7c3aed;"></i>
            {{ __('Enter Marks') }}
        </h5>
        <span class="full-mark-badge">
            <i class="fa-solid fa-bullseye" style="font-size:0.68rem;"></i>
            {{ __('Full Mark:') }} {{ $fullMarks }}
        </span>
    </div>

    {{-- ══════════════════════════════════════════════
         DESKTOP TABLE (hidden on tablet/mobile)
    ══════════════════════════════════════════════ --}}
    <div class="entry-desktop-table" style="overflow-x:auto;">
        <table class="entry-data-table">
            <thead>
                <tr>
                    <th style="width:10%;">{{ __('ID') }}</th>
                    <th style="width:6%;">{{ __('Roll') }}</th>
                    <th style="width:20%;">{{ __('Student Name') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('CQ') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('MCQ') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('Practical') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('Total (Obt.)') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('Grade') }}</th>
                    <th style="width:15%; text-align:center;">{{ __('Attendance') }}</th>
                </tr>
            </thead> 
            <tbody>
                @foreach($students as $student)
                    @php
                        $sts   = $marksWithGrade[$student->id]['status'] ?? 'present';
                        $cq    = (isset($marksWithGrade[$student->id]['cq']) && $marksWithGrade[$student->id]['cq'] !== null && $marksWithGrade[$student->id]['cq'] !== '') ? (int)$marksWithGrade[$student->id]['cq'] : '';
                        $mcq   = (isset($marksWithGrade[$student->id]['mcq']) && $marksWithGrade[$student->id]['mcq'] !== null && $marksWithGrade[$student->id]['mcq'] !== '') ? (int)$marksWithGrade[$student->id]['mcq'] : '';
                        $prac  = (isset($marksWithGrade[$student->id]['practical']) && $marksWithGrade[$student->id]['practical'] !== null && $marksWithGrade[$student->id]['practical'] !== '') ? (int)$marksWithGrade[$student->id]['practical'] : '';
                        $mval  = (isset($marksWithGrade[$student->id]['marks']) && $marksWithGrade[$student->id]['marks'] !== null && $marksWithGrade[$student->id]['marks'] !== '') ? (int)$marksWithGrade[$student->id]['marks'] : '';
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
                            <div class="entry-mark-box">
                                <input type="number" step="1" min="0" max="{{ $fullMarks }}"
                                       class="mark-input cq-input"
                                       data-student="{{ $student->id }}"
                                       data-type="cq"
                                       placeholder="CQ"
                                       value="{{ $cq }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- MCQ --}}
                        <td class="text-center">
                            <div class="entry-mark-box">
                                <input type="number" step="1" min="0" max="{{ $fullMarks }}"
                                       class="mark-input mcq-input"
                                       data-student="{{ $student->id }}"
                                       data-type="mcq"
                                       placeholder="MCQ"
                                       value="{{ $mcq }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- Practical --}}
                        <td class="text-center">
                            <div class="entry-mark-box">
                                <input type="number" step="1" min="0" max="{{ $fullMarks }}"
                                       class="mark-input prac-input"
                                       data-student="{{ $student->id }}"
                                       data-type="practical"
                                       placeholder="Prac."
                                       value="{{ $prac }}"
                                       {{ $sts == 'absent' ? 'disabled' : '' }}>
                            </div>
                        </td>

                        {{-- Total Obtained (Auto Calculated) --}}
                        <td class="text-center">
                            <div class="entry-mark-box total-box-readonly" title="Auto calculated: CQ + MCQ + Practical">
                                <input type="number" step="1" min="0" max="{{ $fullMarks }}"
                                       class="mark-input total-input"
                                       data-student="{{ $student->id }}"
                                       data-type="total"
                                       data-fullmarks="{{ $fullMarks }}"
                                       placeholder="0"
                                       value="{{ $mval }}"
                                       readonly
                                       tabindex="-1"
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
                                    <span>{{ __('Present') }}</span>
                                </button>
                                <button type="button"
                                        class="est-btn {{ $sts == 'absent' ? 'est-absent' : '' }}"
                                        onclick="setEntryStatus({{ $student->id }}, 'absent', this)">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>{{ __('Absent') }}</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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