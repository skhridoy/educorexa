@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">School Management</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0" style="font-size: 1.2rem;">Active Schools</h6>
                        {{-- আপনি চাইলে এখানে সার্চ বা অ্যাড বাটন রাখতে পারেন --}}
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
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">ID</th>
                                    <th class="py-3">School Name</th>
                                    <th class="py-3">Admin Email</th>
                                    <th class="py-3">Subdomain (URL)</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $school)
                                <tr>
                                    <td class="fw-bold text-muted">#{{ $school->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- লোগো থাকলে এখানে দেখানো যাবে --}}
                                            <span class="fw-semibold text-dark">{{ $school->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $school->admin->email ?? 'No Admin Email' }}</td>
                                    <td>
                                        <a href="http://{{ $school->slug }}.schoolerp.test" target="_blank" class="text-primary text-decoration-none">
                                            <i data-feather="external-link" class="icon-sm me-1"></i>
                                            {{ $school->slug }}.schoolerp.test
                                        </a>
                                    </td>
                                    <td>
                                        @if($school->is_active)
                                            <span class="badge bg-soft-success text-success border border-success px-3">Active</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary border border-secondary px-3">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!$school->is_active)
                                            <form action="{{ route('super.schools.approve', $school->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-icon-text btn-sm px-3">
                                                    <i class="btn-icon-prepend" data-feather="check-square"></i>
                                                    Approve
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-info btn-sm btn-icon-text px-3" disabled>
                                                <i class="btn-icon-prepend" data-feather="shield"></i>
                                                Verified
                                            </button>
                                        @endif
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
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endsection