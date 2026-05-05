@extends('layouts.school')


@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .pagination{
            --bs-pagination-border-radius: 50% !important;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Assign Subject to Teacher</h6>
                        <form action="{{ route('teacher.assign.store', ['tenant' => auth()->user()?->school?->slug]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Teacher</label>
                                <select id="teacher_id" name="teacher_id" class="form-control">
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class</label>
                                <select id="class_id" name="class_id" class="form-control">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="section_id" class="form-label">Section</label>
                                <select name="section_id" class="form-control">
                                    <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                        <option value="{{$section->id}}">
                                        {{$section->name}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject</label>
                                <select id="subject_id" name="subject_id" class="form-control">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" class="text-capitalize">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-end">Assign Teacher</button>
                            <a href="{{ route('teachers.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                                class="btn btn-secondary btn-end">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form id="filterForm" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="class_id" class="form-control">
                                        <option value="">All Classes</option>

                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <h6 class="card-title">Assigned Teachers</h6>
                        <div id="assignTable" class="table-responsive">
                                @include('school.teacher.partials.assign-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this class?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    button.closest('form').submit();

                }
            })
        }
        @if(session('success'))
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 1500,
                showConfirmButton: false
            });
        @endif

        $('#filterForm select').on('change', function() {
    loadAssignments();
});

$(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    loadAssignments($(this).attr('href'));
});

function loadAssignments(url = null) {

    let query = $('#filterForm').serialize();

    if (!url) {
        url = "{{ route('teacher.assign', ['tenant' => auth()->user()?->school?->slug]) }}?" + query;
    }

    $.ajax({
        url: url,
        success: function(data){
            $('#assignTable').html(data);
        }
    });
}
    </script>

@endsection