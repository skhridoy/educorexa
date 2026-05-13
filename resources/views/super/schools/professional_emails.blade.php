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
                                        <th>School Name</th>
                                        <th>Requested Email</th>
                                        <th>Status</th>
                                        <th>Requested At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $school)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary fw-bold">
                                                            {{ substr($school->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $school->name }}</h6>
                                                        <small class="text-muted">{{ $school->slug }}.{{ parse_url(config('app.url'), PHP_URL_HOST) ?? 'educorexa.com' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($school->pro_email_status == 'approved')
                                                    <span class="fw-semibold text-dark">{{ $school->pro_email_address }}</span>
                                                @else
                                                    <span class="fw-semibold text-dark">{{ $school->pro_email_prefix }}@...</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($school->pro_email_status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Pending</span>
                                                @elseif($school->pro_email_status == 'approved')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Active</span>
                                                @elseif($school->pro_email_status == 'rejected')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $school->updated_at->format('d M, Y h:i A') }}</td>
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
                                                    <button class="btn btn-sm btn-light rounded-pill px-3" disabled>
                                                        <i class="fa-solid fa-circle-check text-success me-1"></i> Provisioned
                                                    </button>
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
</script>
@endsection
