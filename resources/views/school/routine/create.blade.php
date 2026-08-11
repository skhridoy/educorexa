@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="page-header-content">
                    <h1 class="page-title"><i class="fa-solid fa-plus-circle me-2"></i> Add New Routine Entry</h1>
                    <p class="page-subtitle">Schedule a class period, select teacher, and specify room number.</p>
                </div>
                <div>
                    <a href="{{ route('routine.index') }}" class="btn btn-outline-light px-4 py-2" style="border-radius:12px;">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Routine List
                    </a>
                </div>
            </div>
        </div>

        <div class="form-card">
            <form action="{{ route('routine.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select select2" required>
                            <option value="">Select Year</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                        <select name="class_id" id="class_id" class="form-select select2" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Section <span class="text-danger">*</span></label>
                        <select name="section_id" id="section_id" class="form-select select2" required>
                            <option value="">Select Section</option>
                            @php $school_sections = \App\Models\Section::where('school_id', auth()->user()->school_id)->get(); @endphp
                            @foreach($school_sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-select select2" required>
                            <option value="">Select Class First</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Teacher <span class="text-danger">*</span></label>
                        <select name="teacher_id" class="form-select select2" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Day <span class="text-danger">*</span></label>
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

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Room Number</label>
                        <input type="text" name="room_number" class="form-control" placeholder="e.g. 101">
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary-gradient px-5 py-2 fw-bold" style="border-radius:10px;">
                            <i class="fa-solid fa-check me-1"></i> Save Routine
                        </button>
                    </div>
                </div>
            </form>
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
                    
                    subjectDropdown.trigger('change');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
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
