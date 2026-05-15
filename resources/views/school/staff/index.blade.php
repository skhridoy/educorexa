@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Staff Management</h1>
                        <p class="page-subtitle">Oversee and manage your institution's non-teaching personnel</p>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('staff.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-primary-modern shadow-sm">
                    <i class="fa-solid fa-user-plus me-2"></i> Add New Staff
                </a>
            </div>
        </div>

        {{-- Statistics Overview --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card glass-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="stats-icon bg-soft-primary text-primary rounded-3">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Total Staff</h6>
                        <h4 class="fw-bold mb-0">{{ count($staffs) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card glass-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="stats-icon bg-soft-success text-success rounded-3">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Active Roles</h6>
                        <h4 class="fw-bold mb-0">{{ $staffs->pluck('roles')->flatten()->unique('id')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card glass-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="stats-icon bg-soft-info text-info rounded-3">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">New This Month</h6>
                        <h4 class="fw-bold mb-0">{{ $staffs->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stats-card glass-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="stats-icon bg-soft-warning text-warning rounded-3">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">System Roles</h6>
                        <h4 class="fw-bold mb-0">Staff</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Section --}}
        <div class="search-card glass-card mb-4 p-3 border-0 shadow-sm">
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 bg-light" 
                                   placeholder="Search by name, email or ID..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="sort" class="form-select border-0 bg-light">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Sort: Oldest First</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Sort: Name (A-Z)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="fa-solid fa-sliders me-2"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Data Table Card --}}
        <div class="data-table-card glass-card border-0 shadow-sm overflow-hidden">
            <div class="table-header px-4 py-3 bg-white bg-opacity-50 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="table-title mb-0 fw-bold"><i class="fa-solid fa-list-ul me-2 text-primary"></i> Staff Directory</h5>
            </div>

            <div class="table-responsive">
                <table class="table edu-table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">Member Information</th>
                            <th class="py-3 text-uppercase small fw-bold">Assigned Role</th>
                            <th class="py-3 text-uppercase small fw-bold">Email Status</th>
                            <th class="py-3 text-uppercase small fw-bold">Joining Date</th>
                            <th class="text-center pe-4 py-3 text-uppercase small fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $staff)
                        <tr class="table-row-hover">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle shadow-sm bg-gradient-primary text-white d-flex align-items-center justify-content-center overflow-hidden">
                                        @if($staff->photo)
                                            <img src="{{ asset($staff->photo) }}" alt="{{ $staff->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            {{ substr($staff->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $staff->name }}</div>
                                        <div class="small text-muted"><i class="fa-solid fa-hashtag me-1"></i>STF-{{ str_pad($staff->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge-modern bg-soft-info text-info">
                                    <i class="fa-solid fa-circle-dot me-1"></i>
                                    {{ $staff->roles->first()?->display_name ?? 'School Staff' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex flex-column">
                                    <span class="text-dark small"><i class="fa-regular fa-envelope me-1 text-muted"></i> {{ $staff->email }}</span>
                                    <span class="badge bg-success bg-opacity-10 text-success border-0 small mt-1" style="width: fit-content; font-size: 10px;">Verified</span>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-muted small">
                                    <i class="fa-regular fa-calendar-check me-1"></i>
                                    {{ $staff->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="text-center pe-4 py-3">
                                <div class="action-buttons d-flex justify-content-center gap-2">
                                    <a href="{{ route('staff.edit', ['tenant' => auth()->user()?->school?->slug, 'staff' => $staff->id]) }}" 
                                       class="btn btn-action edit-btn" title="Edit Member">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('staff.destroy', ['tenant' => auth()->user()?->school?->slug,'staff' => $staff->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="btn btn-action delete-btn" title="Remove Member">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state py-5">
                                    <div class="empty-icon-box mb-4">
                                        <i class="fa-solid fa-users-viewfinder fa-3x text-muted opacity-20"></i>
                                    </div>
                                    <h5 class="text-dark fw-bold">No Staff Found</h5>
                                    <p class="text-muted mb-4">Start building your team by adding staff members.</p>
                                    <a href="{{ route('staff.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-primary rounded-pill shadow-sm">
                                        <i class="fa-solid fa-plus me-2"></i> Add First Member
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
            text: "Do you want to remove this staff member?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
