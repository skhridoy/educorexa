@extends('layouts.school')

@section('customCSS')
    <style>
        input{
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
    </style>
@endsection
@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ auth()->guard('admin')->check() 
                    ? route('admin.dashboard') 
                    : route('teacher.dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Marks Entry</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-title">Marks Entry</h6>

                    <!-- SEARCH FORM -->
                    <form method="POST" action="{{ route('marks.marks-entry', ) }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 mb-2">
                                <select name="exam_id" class="form-control" required>
                                    <option value="">Select Exam</option>
                                    @foreach($examTypes as $exam)
                                        <option value="{{ $exam->id }}" {{ (isset($exam_id) && $exam_id == $exam->id) ? 'selected' : '' }}>
                                            {{ $exam->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mb-2">
                                <select name="class_id" class="form-control" id="class_id" required>
                                    <option value="">Select Class</option>
                                    @if(is_array($classes) || $classes instanceof \Illuminate\Support\Collection)
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ (isset($class_id) && $class_id == $class->id) ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-3 mb-2">
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                            
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Search</button>
                    </form>

                    <!-- SHOW CLASS / SUBJECT / EXAM -->
                    @if(!empty($students) && count($students))
                        <div class="row mt-3 mb-2">
                            <div class="col-lg-4">
                                <span> Class : <strong> {{ $class_name }}</strong></span>
                            </div>
                            <div class="col-lg-4">
                                <span> Subject : <strong> {{$subject_name }}</strong></span>
                            </div>
                            <div class="col-lg-4">
                                <span> Exam Name :<strong> {{ $exam_name }}</strong></span>
                            </div>
                        </div>

                        <!-- STUDENTS TABLE -->
                        <form method="POST" action="{{ route('marks.marks-store') }}">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $classId }}">
                            <input type="hidden" name="subject_id" value="{{ $subjectId }}">
                            <input type="hidden" name="exam_id" value="{{ $examId }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="text-bold">
                                        <tr>
                                            <th>Id No</th>
                                            <th>Student Name</th>
                                            <th>Marks</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->id_no }}</td>
                                            <td>{{ $student->name }}</td>

                                            <td>
                                                <input type="number"
                                                    name="marks[{{ $student->id }}]"
                                                    class="form-control"
                                                    min="0"
                                                    max="100"
                                                    value="{{ $marksWithGrade[$student->id]['marks'] ?? '' }}">
                                            </td>

                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $marksWithGrade[$student->id]['grade'] ?? '' }}
                                                </span>
                                            </td>
                                    
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button class="btn btn-success mt-2">Save Marks</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
           
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
           
        });
    @endif
</script>

<script>
    document.getElementById('class_id').addEventListener('change', function () {
    let classId = this.value;
    let subjectBox = document.getElementById('subject_id');

    subjectBox.innerHTML = '<option value="">Loading...</option>';

    fetch("{{ route('marks.findSubject') }}", {
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
</script>
@endsection