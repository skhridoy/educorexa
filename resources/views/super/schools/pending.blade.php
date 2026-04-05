@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid"> {{-- ব্রেডক্রাম্ব এবং টাইটেল --}}
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending Schools</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">নতুন স্কুল রেজিস্ট্রেশন রিকোয়েস্ট</h4>
                            <span class="badge bg-soft-warning text-warning">{{ $schools->count() }}টি রিকোয়েস্ট পেন্ডিং</span>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-fill-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle" class="me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-bottom-0">ID</th>
                                        <th class="border-bottom-0">School Name</th>
                                        <th class="border-bottom-0">Admin Email</th>
                                        <th class="border-bottom-0">Slug/Domain</th>
                                        <th class="border-bottom-0 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $school)
                                    <tr>
                                        <td class="fw-bold text-muted">#{{ $school->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="wd-35 ht-35 bg-soft-primary text-primary d-flex align-items-center justify-content-center rounded-circle me-2">
                                                    {{ substr($school->name, 0, 1) }}
                                                </div>
                                                <span class="fw-semibold">{{ $school->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $school->admin->email ?? 'No Admin Email' }}</td>
                                        <td><code class="text-primary">{{ $school->slug }}</code></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Approve Button --}}
                                                <form action="{{ route('super.schools.approve', $school->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-inverse-success btn-icon btn-sm" title="Approve">
                                                        <i data-feather="check"></i>
                                                    </button>
                                                </form>

                                                {{-- Reject Button --}}
                                                <form action="{{ route('super.schools.reject', $school->id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE') <button class="btn btn-inverse-danger btn-icon btn-sm" type="button" onclick="confirmDelete(this)">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i data-feather="inbox" class="mb-2" style="width: 40px; height: 40px;"></i>
                                            <p>বর্তমানে কোনো পেন্ডিং রিকোয়েস্ট নেই।</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
            text: "Do you want to reject this school?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!',
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