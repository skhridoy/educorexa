@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending Schools</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0 p-md-4"> {{-- মোবাইলে প্যাডিং কমানো হয়েছে --}}
                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 p-md-0">
                            <h4 class="card-title mb-0">New School Requests</h4>
                            <span class="badge bg-soft-warning text-warning">{{ $schools->count() }}, Pending</span>
                        </div>

                        <div class="table-responsive-custom">
                            <table class="table table-hover align-middle custom-mobile-table">
                                <thead class="d-none d-md-table-header-group">
                                    <tr>
                                        <th>ID</th>
                                        <th>School Name</th>
                                        <th>Admin Email</th>
                                        <th>Slug/Domain</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schools as $school)
                                    <tr>
                                        <td data-label="ID" class="fw-bold text-muted">#{{ $school->id }}</td>
                                        <td data-label="School Name">
                                            <div class="d-flex align-items-center justify-content-md-start justify-content-end">
                                                <div class="wd-30 ht-30 bg-soft-primary text-primary d-none d-md-flex align-items-center justify-content-center rounded-circle me-2">
                                                    {{ substr($school->name, 0, 1) }}
                                                </div>
                                                <div class="d-flex flex-column align-items-end text-end text-md-start align-items-md-start text-wrap">
                                                    <span class=" school-name-text text-uppercase">{{ $school->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Admin Email" class="text-end text-md-start">{{ $school->admin->email ?? 'No Admin Email' }}</td>
                                        <td data-label="Slug/Domain" class="text-end text-md-start"><code class="text-primary">{{ $school->slug }}.{{ $mainDomain }}</code></td>
                                        <td data-label="Action">
                                            <div class="d-flex justify-content-md-center justify-content-end gap-2">
                                                <form action="{{ route('super.schools.approve', $school->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-inverse-success btn-icon btn-sm" title="Approve">
                                                        <i data-feather="check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('super.schools.reject', $school->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-inverse-danger btn-icon btn-sm" type="button" onclick="confirmDelete(this)" title="Reject">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted border-0">
                                            <i data-feather="inbox" class="mb-2" style="width: 40px; height: 40px;"></i>
                                            <p>বর্তমানে কোনো পেন্ডিং রিকোয়েস্ট নেই।</p>
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