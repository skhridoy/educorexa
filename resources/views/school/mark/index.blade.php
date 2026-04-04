@extends('layouts.school')

@section('customCSS')
<style>
    input {
        min-width: 50px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .grade-box{
        margin-top: 10px;
        padding: 5px;
    }
</style>
@section('content')

    <div class="page-content">

        <div class="card">
            <div class="card-header">
                <h4>Marks Entry</h4>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('marks.index', ['tenant' => auth()->user()->school->slug]) }}">

                    <div class="row">

                        <div class="col-md-3">
                            <label>Exam</label>
                            <select name="exam_id" class="form-control">

                                <option value="">Select Exam</option>

                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Class</label>
                            <select name="class_id" id="class_id" class="form-control">
                                <option value="">Select Class</option>

                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">

                            <label>Subject</label>

                            <select id="subject_id" name="subject_id" class="form-control">

                                <option value="">Select Subject</option>

                            </select>

                        </div>

                        <div class="col-md-3 my-1">
                            <button class="btn btn-primary mt-3">Load Students</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        <br>
        <input type="hidden" id="hidden_class_id" value="{{ $classId }}">
        <input type="hidden" id="hidden_exam_id" value="{{ $examId }}">
        <input type="hidden" id="hidden_subject_id" value="{{ $subjectId }}">
        @if($students->count())

            @include('school.mark.partials.marks-table')
        @endif

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
                            <option value="${subject.id}">
                                ${subject.name}
                            </option>`;
                        });
                    }
                })
                .catch(err => console.error(err));
        });
        document.getElementById('subject_id').addEventListener('change', function () {

            let classId = document.getElementById('class_id').value;
            let examId = document.querySelector('[name="exam_id"]').value;
            let subjectId = this.value;

            if (classId && examId && subjectId) {

                window.location.href =
                    `?class_id=${classId}&exam_id=${examId}&subject_id=${subjectId}`;

            }

        });
    </script>
    @if(session('success'))

        <script>

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: "{{ session('success') }}",

                showConfirmButton: true,
                timer: 2000

            });

        </script>

    @endif
    <script>

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
            let fullMarks = input.data('fullmarks');

            // ড্রপডাউন থেকে না নিয়ে হিডেন ইনপুট থেকে নিন যা পেজ লোড হওয়ার সময় সেট হয়েছে
            let classId = $('#hidden_class_id').val();
            let examId = $('#hidden_exam_id').val();
            let subjectId = $('#hidden_subject_id').val();

            let status = input.closest('tr').find('.status-input').val();

            // গ্রেড ক্যালকুলেশন
            let grade = calculateGrade(marks, fullMarks);
            input.closest('tr').find('.grade-box').text(grade);

            // AJAX কল
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
                    console.log("Saved successfully");
                    // আপনি চাইলে এখানে ছোট একটা টিক চিহ্ন দেখাতে পারেন
                },
                error: function (err) {
                    console.error("Error saving mark");
                }
            });
        });

        // STATUS CHANGE (ABSENT SYSTEM)

        $('.status-input').change(function () {
            let row = $(this).closest('tr');
            let status = $(this).val();
            let markInput = row.find('.mark-input');

            let studentId = markInput.data('student');
            let classId = $('#hidden_class_id').val();
            let examId = $('#hidden_exam_id').val();
            let subjectId = $('#hidden_subject_id').val();

            // UI পরিবর্তন
            if (status == 'absent') {
                markInput.val(0).prop('disabled', true);
                row.find('.grade-box').text('ABS');
            } else {
                markInput.prop('disabled', false);
                row.find('.grade-box').text('-');
            }

            // AJAX এর মাধ্যমে ডাটাবেসে সেভ করা
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
                    console.log("Status synced with database");
                },
                error: function () {
                    alert("Error updating status!");
                }
            });
        });
    </script>
@endsection