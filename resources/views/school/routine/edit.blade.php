@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-sm-0">Edit Routine</h4>
                    <div class="page-title-right">
                        <a href="{{ route('routine.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form action="{{ route('routine.update', $routine->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" class="form-select select2" required>
                                        <option value="">Select Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ $routine->academic_year_id == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Class <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-select select2" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ $routine->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Section <span class="text-danger">*</span></label>
                                    <select name="section_id" id="section_id" class="form-select select2" required>
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ $routine->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-select select2" required>
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ $routine->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Teacher <span class="text-danger">*</span></label>
                                    <select name="teacher_id" class="form-select select2" required>
                                        <option value="">Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ $routine->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Day <span class="text-danger">*</span></label>
                                    <select name="day" class="form-select" required>
                                        <option value="">Select Day</option>
                                        @foreach(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                            <option value="{{ $day }}" {{ $routine->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control" value="{{ $routine->start_time }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control" value="{{ $routine->end_time }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Room Number</label>
                                    <input type="text" name="room_number" class="form-control" value="{{ $routine->room_number }}" placeholder="e.g. 101">
                                </div>

                                <div class="col-md-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 10px;">
                                        <i class="fa fa-save me-1"></i> Update Routine
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    $('#class_id').on('change', function() {
        var classId = $(this).val();
        if(classId) {
            $.ajax({
                url: "{{ url('get-subjects') }}/" + classId,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#subject_id').empty();
                    $('#subject_id').append('<option value="">Select Subject</option>');
                    $.each(data, function(key, value) {
                        $('#subject_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        } else {
            $('#subject_id').empty();
            $('#subject_id').append('<option value="">Select Class First</option>');
        }
    });
});
</script>
@endsection
