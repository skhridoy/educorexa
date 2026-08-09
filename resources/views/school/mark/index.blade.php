@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ══════════════════════════════════════════════
           MARK ENTRY HERO
        ══════════════════════════════════════════════ */
        .entry-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            border-radius: 20px;
            padding: 26px 32px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(15,23,42,0.18);
        }
        .entry-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: rgba(99,102,241,0.12);
            border-radius: 50%;
        }
        .entry-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -30px;
            width: 140px; height: 140px;
            background: rgba(79,70,229,0.07);
            border-radius: 50%;
        }
        .entry-hero-content { position: relative; z-index: 2; }
        .entry-hero-title {
            font-size: 1.7rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }
        .entry-hero-subtitle {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.68);
            margin: 0;
        }
        .entry-hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #a5b4fc;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 10px;
        }

        /* ══════════════════════════════════════════════
           FILTER CARD
        ══════════════════════════════════════════════ */
        .entry-filter-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 18px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(15,23,42,0.05);
        }
        .entry-filter-card .filter-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .entry-filter-card .form-select {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 9px 12px;
            font-size: 0.88rem;
            font-weight: 500;
            background: #f8fafc;
            transition: all 0.2s;
            height: 40px;
        }
        .entry-filter-card .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: #fff;
        }
        .btn-load-students {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            height: 40px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff !important;
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-load-students:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(79,70,229,0.32);
        }

        /* ══════════════════════════════════════════════
           ACTIVE FILTER INFO BAR
        ══════════════════════════════════════════════ */
        .active-filter-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .filter-tag.green { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .filter-tag.purple{ background: #f5f3ff; color: #6d28d9; border-color: #ddd6fe; }

        /* ══════════════════════════════════════════════
           EMPTY STATE
        ══════════════════════════════════════════════ */
        .entry-empty-card {
            background: #fff;
            border: 1.5px dashed #e2e8f0;
            border-radius: 18px;
            padding: 52px 24px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(15,23,42,0.04);
        }
        .entry-empty-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            color: #7c3aed;
            font-size: 1.8rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }

        /* ══════════════════════════════════════════════
           DARK MODE
        ══════════════════════════════════════════════ */
        body.dark-mode .entry-filter-card,
        [data-bs-theme="dark"] .entry-filter-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }
        body.dark-mode .entry-filter-card .form-select,
        [data-bs-theme="dark"] .entry-filter-card .form-select {
            background: #060c18 !important;
            border-color: #1a253b !important;
            color: #f8fafc !important;
        }
        body.dark-mode .entry-empty-card,
        [data-bs-theme="dark"] .entry-empty-card {
            background: #0c1427 !important;
            border-color: #1a253b !important;
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 767.98px) {
            .entry-hero { padding: 18px 16px; border-radius: 14px; margin-bottom: 16px; }
            .entry-hero-title { font-size: 1.25rem; }
            .entry-filter-card { padding: 14px; border-radius: 14px; }
        }
        @media (max-width: 399.98px) {
            .entry-hero-title { font-size: 1.1rem; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid px-3 px-md-4">

        {{-- ══ HERO BANNER ══ --}}
        <div class="entry-hero mb-4">
            <div class="entry-hero-content">
                <h1 class="entry-hero-title">
                    <i class="fa-solid fa-file-signature me-2"></i>Marks Entry
                </h1>
                <p class="entry-hero-subtitle">Record and manage student academic performance</p>
                <div class="entry-hero-pill">
                    <i class="fa-solid fa-bolt"></i>
                    Auto-saves on every input
                </div>
            </div>
        </div>

        {{-- ══ FILTER SECTION ══ --}}
        <div class="entry-filter-card mb-4">
            <form method="GET" action="{{ route('marks.index', ['tenant' => auth()->user()->school->slug]) }}">
                <div class="row align-items-end g-2">
                    <div class="col-6 col-md-3">
                        <label class="filter-label">
                            <i class="fa-solid fa-file-pen"></i> Exam
                        </label>
                        <select name="exam_id" class="form-select">
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="filter-label">
                            <i class="fa-solid fa-chalkboard"></i> Class
                        </label>
                        <select name="class_id" id="class_id" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="filter-label">
                            <i class="fa-solid fa-book-open"></i> Subject
                        </label>
                        <select id="subject_id" name="subject_id" class="form-select">
                            <option value="">Select Subject</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <button type="submit" class="btn-load-students">
                            <i class="fa-solid fa-arrows-rotate"></i>
                            Load Students
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Hidden inputs --}}
        <input type="hidden" id="hidden_class_id"   value="{{ $classId }}">
        <input type="hidden" id="hidden_exam_id"    value="{{ $examId }}">
        <input type="hidden" id="hidden_subject_id" value="{{ $subjectId }}">

        @if($students->count())
            {{-- Active Filter Tags --}}
            @if($classId || $examId || $subjectId)
            <div class="active-filter-bar mb-3">
                @foreach($exams as $e)
                    @if($e->id == $examId)
                        <span class="filter-tag purple">
                            <i class="fa-solid fa-file-pen" style="font-size:0.65rem;"></i>
                            {{ $e->name }}
                        </span>
                    @endif
                @endforeach
                @foreach($classes as $c)
                    @if($c->id == $classId)
                        <span class="filter-tag">
                            <i class="fa-solid fa-chalkboard" style="font-size:0.65rem;"></i>
                            {{ $c->name }}
                        </span>
                    @endif
                @endforeach
                <span class="filter-tag green">
                    <i class="fa-solid fa-users" style="font-size:0.65rem;"></i>
                    {{ $students->count() }} Students
                </span>
            </div>
            @endif

            @include('school.mark.partials.marks-table')
        @else
            <div class="entry-empty-card">
                <div class="entry-empty-icon">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color:#1e293b;">No Students to Display</h5>
                <p class="text-muted mb-0" style="font-size:0.88rem;">
                    Please select an exam, class, and subject above to begin marks entry.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
    document.getElementById('class_id').addEventListener('change', function () {
        let classId = this.value;
        let subjectBox = document.getElementById('subject_id');
        subjectBox.innerHTML = '<option value="">Loading...</option>';

        fetch("{{ route('marks.findSubject', ['tenant' => auth()->user()->school->slug]) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ class_id: classId })
        })
        .then(res => res.json())
        .then(data => {
            subjectBox.innerHTML = '<option value="">Select Subject</option>';
            if (data.status && data.subjects.length > 0) {
                data.subjects.forEach(subject => {
                    subjectBox.innerHTML += `
                    <option value="${subject.id}" ${'{{ $subjectId }}' == subject.id ? 'selected' : ''}>
                        ${subject.name}
                    </option>`;
                });
            }
        })
        .catch(err => console.error(err));
    });

    // Trigger change on load if class is selected
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

    // MARKS INPUT — auto-save via AJAX
    $(document).on('input', '.mark-input', function () {
        let input     = $(this);
        let marks     = parseFloat(input.val());
        let studentId = input.data('student');
        let fullMarks = parseFloat(input.data('fullmarks'));

        if (marks > fullMarks) {
            Swal.fire({
                icon: 'error',
                title: 'Limit Exceeded',
                text: `Marks cannot exceed ${fullMarks}`,
                confirmButtonColor: '#4f46e5',
            });
            marks = fullMarks;
            input.val(marks);
        }

        let classId   = $('#hidden_class_id').val();
        let examId    = $('#hidden_exam_id').val();
        let subjectId = $('#hidden_subject_id').val();
        let status    = input.closest('tr, .entry-student-card').find('.status-input').val();
        let grade     = calculateGrade(marks, fullMarks);

        if ($(`#grade-${studentId}`).length) {
            $(`#grade-${studentId}`).text(grade);
            updateGradeStyle(studentId, grade);
        }

        $.ajax({
            url: "{{ route('marks.autosave', auth()->user()->school->slug) }}",
            type: "POST",
            data: {
                student_id: studentId,
                class_id:   classId,
                exam_id:    examId,
                subject_id: subjectId,
                marks:      marks,
                status:     status,
                _token:     "{{ csrf_token() }}"
            },
            success: function () {
                input.addClass('is-valid').removeClass('is-invalid');
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 1000,
                });
                Toast.fire({ icon: 'success', title: 'Saved' });
            },
            error: function () {
                input.addClass('is-invalid').removeClass('is-valid');
            }
        });
    });

    // STATUS CHANGE
    $(document).on('change', '.status-input', function () {
        let container  = $(this).closest('tr, .entry-student-card');
        let status     = $(this).val();
        let markInput  = container.find('.mark-input');
        let studentId  = markInput.data('student');
        let classId    = $('#hidden_class_id').val();
        let examId     = $('#hidden_exam_id').val();
        let subjectId  = $('#hidden_subject_id').val();

        if (status == 'absent') {
            markInput.val(0).prop('disabled', true);
            $(`#grade-${studentId}`).text('ABS');
            updateGradeStyle(studentId, 'ABS');
            container.addClass('row-absent');
        } else {
            markInput.prop('disabled', false);
            $(`#grade-${studentId}`).text('-');
            updateGradeStyle(studentId, '-');
            container.removeClass('row-absent');
        }

        $.ajax({
            url: "{{ route('marks.statusUpdate', auth()->user()->school->slug) }}",
            type: "POST",
            data: {
                student_id: studentId,
                class_id:   classId,
                exam_id:    examId,
                subject_id: subjectId,
                status:     status,
                marks:      markInput.val(),
                _token:     "{{ csrf_token() }}"
            }
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