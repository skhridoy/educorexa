@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-file-signature me-2"></i> Marks Entry</h1>
                <p style="margin: 0; opacity: 0.85;">Record and manage student academic performance</p>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-section">
            <form method="GET" action="{{ route('marks.index', ['tenant' => auth()->user()->school->slug]) }}">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Exam</label>
                        <select name="exam_id" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;">
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Class</label>
                        <select name="class_id" id="class_id" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="filter-label">Subject</label>
                        <select id="subject_id" name="subject_id" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;">
                            <option value="">Select Subject</option>
                            {{-- Subjects will be loaded via JS --}}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2" style="border-radius: 10px;">
                            <i class="fa-solid fa-arrows-rotate me-2"></i> Load Students
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <input type="hidden" id="hidden_class_id" value="{{ $classId }}">
        <input type="hidden" id="hidden_exam_id" value="{{ $examId }}">
        <input type="hidden" id="hidden_subject_id" value="{{ $subjectId }}">

        @if($students->count())
            @include('school.mark.partials.marks-table')
        @else
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fa-solid fa-user-group fa-3x text-light"></i>
                    </div>
                    <h5 class="text-muted">No students to display</h5>
                    <p class="text-muted small">Please select an exam, class, and subject to begin marks entry.</p>
                </div>
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
    if(document.getElementById('class_id').value) {
        document.getElementById('class_id').dispatchEvent(new Event('change'));
    }

    document.getElementById('subject_id').addEventListener('change', function () {
        let classId = document.getElementById('class_id').value;
        let examId = document.querySelector('[name="exam_id"]').value;
        let subjectId = this.value;

        if (classId && examId && subjectId) {
            window.location.href = `?class_id=${classId}&exam_id=${examId}&subject_id=${subjectId}`;
        }
    });

    function calculateGrade(marks, fullMarks) {
        let percentage = (marks / fullMarks) * 100;
        if (percentage >= 80) return 'A+';
        if (percentage >= 70) return 'A';
        if (percentage >= 60) return 'A-';
        if (percentage >= 50) return 'B';
        if (percentage >= 40) return 'C';
        if (percentage >= 33) return 'D';
        return 'F';
    }

    // MARKS INPUT
    $(document).on('input', '.mark-input', function () {
        let input = $(this);
        let marks = input.val();
        let studentId = input.data('student');
        let fullMarks = parseFloat(input.data('fullmarks')); 

        if (marks > fullMarks) {
            Swal.fire({
                icon: 'error',
                title: 'Limit Exceeded',
                text: `Marks cannot be more than ${fullMarks}`,
                confirmButtonColor: '#002147',
            });
            marks = fullMarks;
            input.val(marks);
        }

        let classId = $('#hidden_class_id').val();
        let examId = $('#hidden_exam_id').val();
        let subjectId = $('#hidden_subject_id').val();
        let status = input.closest('tr').find('.status-input').val();

        let grade = calculateGrade(marks, fullMarks);
        
        if($(`#grade-${studentId}`).length) {
            $(`#grade-${studentId}`).text(grade);
        }

        // AJAX AUTO-SAVE
        $.ajax({
            url: "{{ route('marks.autosave', auth()->user()->school->slug) }}",
            type: "POST",
            data: {
                student_id: studentId,
                class_id: classId,
                exam_id: examId,
                subject_id: subjectId,
                marks: marks,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                input.addClass('is-valid').removeClass('is-invalid');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: false,
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Saved'
                });
            },
            error: function (err) {
                input.addClass('is-invalid').removeClass('is-valid');
            }
        });
    });

    $('.status-input').change(function () {
        let row = $(this).closest('tr');
        let status = $(this).val();
        let markInput = row.find('.mark-input');

        let studentId = markInput.data('student');
        let classId = $('#hidden_class_id').val();
        let examId = $('#hidden_exam_id').val();
        let subjectId = $('#hidden_subject_id').val();

        if (status == 'absent') {
            markInput.val(0).prop('disabled', true);
            row.find('.grade-box').text('ABS');
        } else {
            markInput.prop('disabled', false);
            row.find('.grade-box').text('-');
        }

        $.ajax({
            url: "{{ route('marks.statusUpdate', auth()->user()->school->slug) }}",
            type: "POST",
            data: {
                student_id: studentId,
                class_id: classId,
                exam_id: examId,
                subject_id: subjectId,
                status: status,
                marks: markInput.val(),
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log("Status synced");
            }
        });
    });
</script>
@endsection