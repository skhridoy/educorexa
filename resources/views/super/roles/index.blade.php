@extends('layouts.main')

@section('customCSS')
<style>
    .card { border-radius: 10px; }
    .table thead th {
        background-color: #f9fafb;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #6c757d;
        border-top: none;
    }
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        max-width: 500px;
    }
    .badge-perm {
        font-size: 10px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 50px; /* পিল ডিজাইন */
        text-transform: capitalize;
        transition: all 0.2s;
    }
    .badge-perm:hover {
        background-color: #6571ff !important;
        color: white !important;
        transform: translateY(-1px);
    }
    .role-name-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .role-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(101, 113, 255, 0.1);
        color: #6571ff;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles Management</li>
        </ol>
    </nav>

    {{-- Stats Section --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <div class="role-icon me-3">
                            <i data-feather="shield"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Total Roles</p>
                            <h4 class="mb-0 fw-bold">{{ $roles->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="card-title mb-1">System Roles</h6>
                            <p class="text-muted small mb-0">Manage user roles and their respective access permissions.</p>
                        </div>
                        <a href="{{ route('super.roles.create') }}" class="btn btn-primary btn-icon-text shadow-sm">
                            <i class="btn-icon-prepend" data-feather="plus"></i>
                            Add New Role
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-fill-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i data-feather="check-circle" class="me-2 icon-sm"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-light">
                            <thead>
                                <tr>
                                    <th class="ps-4">Role Identity</th>
                                    <th>Permissions Overview</th>
                                    <th class="text-center">Users</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td class="ps-4">
                                        <div class="role-name-wrapper">
                                            <div class="fw-bold text-dark d-block">
                                                {{ ucfirst($role->name) }}
                                                @if($role->name == 'super-admin')
                                                    <i data-feather="check-badge" class="text-primary icon-sm ms-1" title="System Protected"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-muted">Type: {{ ucfirst(str_replace('_', ' ', $role->role_type ?? 'Custom')) }}</small>
                                    </td>
                                    <td>
                                        <div class="permissions-container py-2">
                                            @php $limit = 6; @endphp
                                            @foreach($role->permissions->take($limit) as $perm)
                                                <span class="badge bg-soft-primary text-primary badge-perm border-0">
                                                    {{ str_replace(['-', '.'], ' ', $perm->name) }}
                                                </span>
                                            @endforeach
                                            
                                            @if($role->permissions->count() > $limit)
                                                <span class="badge bg-light text-muted badge-perm border" title="And {{ $role->permissions->count() - $limit }} more...">
                                                    +{{ $role->permissions->count() - $limit }} More
                                                </span>
                                            @endif

                                            @if($role->permissions->count() == 0)
                                                <span class="text-muted small fst-italic">No permissions assigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $role->users_count ?? 0 }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('super.roles.edit', $role->id) }}" 
                                               class="btn btn-outline-primary action-btn" 
                                               data-bs-toggle="tooltip" title="Edit Access">
                                                <i data-feather="edit-3" class="icon-sm"></i>
                                            </a>

                                            @if($role->name !== 'super-admin')
                                            <form action="{{ route('super.roles.destroy', $role->id) }}" 
                                                  method="POST" class="delete-form d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger action-btn delete-btn" 
                                                        data-bs-toggle="tooltip" title="Delete Role">
                                                    <i data-feather="trash-2" class="icon-sm"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i data-feather="alert-circle" class="icon-xxl mb-3"></i>
                                            <p>No roles found in the system.</p>
                                            <a href="{{ route('super.roles.create') }}" class="btn btn-sm btn-primary mt-2">Create First Role</a>
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
    </div>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Feather Icons Initialization
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Delete Confirmation with SweetAlert2
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                
                Swal.fire({
                    title: 'আপনি কি নিশ্চিত?',
                    text: "এই রোলটি মুছে ফেললে সংশ্লিষ্ট ইউজাররা লগইন করতে সমস্যায় পড়তে পারেন!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'হ্যাঁ, মুছে ফেলুন!',
                    cancelButtonText: 'বাতিল'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection