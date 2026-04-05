@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Update Subject</h6>
                        <form action="{{ route('subjects.update', ['tenant' => auth()->user()->school->slug, 'subject' => $subject->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Subject Name: [Math, ...]" value="{{ $subject->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Subject Code: [101, ...]" value="{{ $subject->code }}">
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="" default selected>Select Type</option>
                                    <option value="theory" {{ $subject->type == 'theory' ? 'selected' : '' }}>Theory</option>
                                    <option value="practical" {{ $subject->type == 'practical' ? 'selected' : '' }}>Practical</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description for this subject" value="{{ $subject->description }}">
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
                        <h6 class="card-title">Subjects</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                    <tr>
                                        <td class="text-capitalize">{{ $subject->name }}</td>
                                        <td>{{ $subject->code }}</td>
                                        <td class="text-capitalize">{{ $subject->type }}</td>
                                        <td>{{ $subject->description }}</td>
                                        <td>
                                            <a href="{{ route('subjects.edit', ['tenant' => auth()->user()->school->slug,'subject' => $subject->id]) }}" class="btn btn-sm btn-warning badge">Edit</a>

                                            <form action="{{ route('subjects.destroy', ['tenant' => auth()->user()->school->slug,'subject' => $subject->id]) }}" method="POST" style="display:inline;">
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
        text: "Do you want to delete this subject?",
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
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}', // প্রথম এরর মেসেজটি দেখাবে
            confirmButtonColor: '#3085d6',
        });
    @endif
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