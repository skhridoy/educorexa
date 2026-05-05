@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-sm-0">Add New Routine</h4>
                    <div class="page-title-right">
                        <a href="{{ route('routine.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form action="{{ route('routine.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" class="form-select select2" required>
                                        <option value="">Select Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Class <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-select select2" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Section <span class="text-danger">*</span></label>
                                    <select name="section_id" id="section_id" class="form-select select2" required>
                                        <option value="">Select Section</option>
                                        {{-- In this system sections are global to school, but we can list all --}}
                                        @php $school_sections = \App\Models\Section::where('school_id', auth()->user()->school_id)->get(); @endphp
                                        @foreach($school_sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-select select2" required>
                                        <option value="">Select Class First</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Teacher <span class="text-danger">*</span></label>
                                    <select name="teacher_id" class="form-select select2" required>
                                        <option value="">Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Day <span class="text-danger">*</span></label>
                                    <select name="day" class="form-select" required>
                                        <option value="">Select Day</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Room Number</label>
                                    <input type="text" name="room_number" class="form-control" placeholder="e.g. 101">
                                </div>

                                <div class="col-md-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 10px;">
                                        <i class="fa fa-save me-1"></i> Save Routine
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
        var subjectDropdown = $('#subject_id');

        var routeUrl = "{{ route('getSubjects', ['tenant' => auth()->user()->school->slug, 'classId' => ':id']) }}";
        routeUrl = routeUrl.replace(':id', classId);
        if(classId) {
            $.ajax({
                // route name ব্যবহার করা নিরাপদ
                url: routeUrl,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    subjectDropdown.html('<option value="">Loading...</option>');
                },
                success:function(data) {
                    subjectDropdown.empty();
                    subjectDropdown.append('<option value="">Select Subject</option>');
                    
                    if(data.length > 0) {
                        $.each(data, function(key, value) {
                            subjectDropdown.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    } else {
                        subjectDropdown.append('<option value="">No subject found for this class</option>');
                    }
                    
                    // যদি Select2 ব্যবহার করেন তবে নিচের লাইনটি প্রয়োজন
                    subjectDropdown.trigger('change');
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // এরর চেক করার জন্য
                    subjectDropdown.html('<option value="">Error loading subjects</option>');
                }
            });
        } else {
            subjectDropdown.empty().append('<option value="">Select Class First</option>').trigger('change');
        }
    });
});
</script>
@endsection
