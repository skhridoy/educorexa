@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <nav class="col-md-6 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('school.dashboard', ['tenant' => auth()->user()?->school?->slug]) }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Import</li>
                </ol>
            </nav>
            <div class="my-2 col-md-6 text-end">
                <a href="{{ route('students.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-primary btn-sm">Add Student</a>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Import Students</h6>
                        <p class="card-description">Upload an Excel file to import multiple students at once.</p>
                            <form action="{{ route('students.import', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control mb-3" required>
                            <button type="submit" class="btn btn-primary">Upload Excel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
<script>
    // Add any custom JavaScript for the teacher creation page here
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