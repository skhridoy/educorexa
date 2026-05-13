@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0 fw-bold text-primary">
                                <i class="fa-solid fa-envelope-open-text me-2"></i> Professional Email Requests
                            </h4>
                            <p class="text-muted small mb-0">Manage and approve professional email accounts for schools.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">School Name</th>
                                        <th>Email Address</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $school)
                                        <tr class="align-middle">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary fw-bold">
                                                            {{ substr($school->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $school->name }}</h6>
                                                        <small class="text-muted">{{ $school->slug }}.{{ config('services.cpanel.root_domain', 'educorexa.com') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($school->pro_email_status == 'approved')
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold text-primary">{{ $school->pro_email_address }}</span>
                                                        <small class="text-muted copyable" style="cursor: pointer" onclick="copyToClipboard('{{ $school->pro_email_password }}')">
                                                            <i class="fa-solid fa-key fa-xs me-1"></i> Pass: ******** (Click to Copy)
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="fw-semibold text-secondary">{{ $school->pro_email_prefix }}@<span class="opacity-50">{{ $school->slug }}.{{ config('services.cpanel.root_domain', 'educorexa.com') }}</span></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($school->pro_email_status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill fw-medium">
                                                        <i class="fa-solid fa-clock-rotate-left me-1"></i> Pending
                                                    </span>
                                                @elseif($school->pro_email_status == 'approved')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-medium">
                                                        <i class="fa-solid fa-circle-check me-1"></i> Active
                                                    </span>
                                                @elseif($school->pro_email_status == 'rejected')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-medium">
                                                        <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $school->updated_at->diffForHumans() }}</td>
                                            <td class="text-end">
                                                @if($school->pro_email_status == 'pending')
                                                    <form action="{{ route('manage.pro-email.approve', $school->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm me-1">
                                                            <i class="fa-solid fa-check me-1"></i> Approve & Create
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('manage.pro-email.reject', $school->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                                        </button>
                                                    </form>
                                                @elseif($school->pro_email_status == 'approved')
                                                    <form action="{{ route('manage.pro-email.delete', $school->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this email account?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fa-solid fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                                                <p class="text-muted">No professional email requests found.</p>
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#4f46e5',
            timer: 3000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444'
        });
    @endif

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Password copied to clipboard',
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
