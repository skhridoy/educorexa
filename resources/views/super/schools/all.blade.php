@extends('layouts.main')

@section('content')

    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Schools List</h6>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schools as $school)
                                    <tr>
                                        <td>{{ $school->id }}</td>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->email ?? 'No Admin Email' }}</td>
                                        <td>
                                            <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank" class="text-primary text-decoration-none">
                                                <i data-feather="external-link" class="icon-sm me-1"></i>
                                                {{ $school->slug }}.{{ $mainDomain }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($school->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($school->is_active)
                                                <form action="{{ route('super.schools.reject', $school->id) }}" 
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm badge">
                                                        Reject
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('super.schools.approve', $school->id) }}" 
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-success btn-sm badge">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('super.schools.destroy', $school->id) }}" 
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm badge" onclick="confirmDelete(this)">
                                                        Delete
                                                    </button>
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
            text: "Do you want to delete this school?",
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