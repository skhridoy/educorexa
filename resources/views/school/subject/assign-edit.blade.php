@extends('layouts.school')


@section('customCSS')
<style>
    
</style>

@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Assign Subject to Class</h6>
                        <form action="{{ route('subjects.assign.update', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                                <div class="mb-3">
                                    <label for="class_id" class="form-label">Class</label>
                                    <select id="class_id" name="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" class="text-capitalize" {{ old('class_id', $assignment->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select id="subject_id" name="subject_id" class="form-control">
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" class="text-capitalize" {{ old('subject_id', $assignment->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Full Mark</label>
                                    <input type="text" id="full_mark" name="full_mark" class="form-control" placeholder="Enter full mark">
                                </div>
                                <div class="mb-3">
                                    <label for="pass_mark" class="form-label">Pass Marks</label>
                                    <input type="text" name="pass_mark" class="form-control" placeholder="Pass Marks">
                                </div>
                            
                            <button type="submit" class="btn btn-primary btn-end">Update</button>
                            <a href="{{ route('subjects.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-secondary btn-end">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Assigned Subjects</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Clas Name</th>
                                        <th>Subject</th>
                                        <th>Full Mark</th>
                                        <th>Pass Mark</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->id }}</td>
                                        <td>{{ $assignment->class->name }}</td>
                                        <td class="text-capitalize">{{ $assignment->subject->name }}</td>
                                        <td>{{ $assignment->full_mark ?? 'Null' }}</td>
                                        <td>{{ $assignment->pass_mark ?? 'Null' }}</td>
                                        <td>
                                            <a href="{{ route('subjects.assign.edit', ['tenant' => auth()->user()->school->slug,'assignment' => $assignment->id]) }}" class="btn btn-sm btn-warning badge">Edit</a>
    
                                            <form action="{{ route('subjects.assign.destroy', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-danger badge">Delete</button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
</script>

@endsection