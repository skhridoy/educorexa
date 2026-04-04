@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Create Class</h6>
                        <form action="{{ route('classes.update', ['tenant' => auth()->user()->school->slug, 'class' => $class->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Class Name: [one, ...]" required value="{{ old('name', $class->name) }}">
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Class Code: [101, ...]" value="{{ old('code', $class->code) }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description for this class" value="{{ old('description', $class->description) }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-end">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Classes</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ $class->code }}</td>
                                        <td>{{ $class->description }}</td>
                                        <td>
                                            <a href="{{ route('classes.edit', ['tenant' => auth()->user()->school->slug,'class' => $class->id]) }}" class="btn btn-sm btn-warning badge">Edit</a>

                                            <form action="{{ route('classes.destroy', ['tenant' => auth()->user()->school->slug,'class' => $class->id]) }}" method="POST" style="display:inline;">
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