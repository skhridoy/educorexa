@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions Management</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 text-primary fw-bold">Permissions by Module</h4>
            <p class="text-muted small">Manage access control organized by system modules.</p>
        </div>
        <a href="{{ route('super.permissions.create') }}" class="btn btn-primary btn-icon-text shadow-sm">
            <i class="btn-icon-prepend" data-feather="plus-circle"></i> Create Permission
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-fill-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i data-feather="check-circle" class="me-2 icon-nm"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($permissions->groupBy('group_name') as $groupName => $groupPermissions)
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px; height: 100%;">
                    
                    <div class="card-header bg-soft-primary py-3 border-0 d-flex align-items-center justify-content-between sticky-top bg-white" style="z-index: 10;">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i data-feather="box" style="width: 14px;"></i>
                            </div>
                            <h6 class="card-title mb-0 text-primary fw-bolder">
                                {{ $groupName ?? 'General' }}
                            </h6>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ count($groupPermissions) }}</span>
                    </div>

                    <div class="card-body p-0 custom-card-scroll" style="max-height: 400px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <tbody>
                                    @foreach($groupPermissions as $permission)
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-3">
                                                <div class="fw-bold text-dark fs-6" style="font-size: 0.9rem;">
                                                    {{ ucwords(str_replace(['-', '_', '.'], ' ', $permission->name)) }}
                                                </div>
                                                <small class="text-muted d-block" style="font-size: 11px;">{{ $permission->name }}</small>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="dropdown">
                                                    <a href="javascript:;" class="p-2 text-muted" data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical" class="icon-sm"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('super.permissions.edit', $permission->id) }}">
                                                            <i data-feather="edit-2" class="icon-sm me-2"></i> Edit
                                                        </a>
                                                        <form action="{{ route('super.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                                                                <i data-feather="trash-2" class="icon-sm me-2"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-light py-2 text-center border-0">
                        <small class="text-muted fw-medium">{{ count($groupPermissions) }} items in module</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No data found.</div>
        @endforelse
    </div>

</div>

<style>
    .bg-soft-primary { background-color: rgba(101, 113, 255, 0.08); }
    .card-title { font-size: 0.85rem; }
    .table td { border-color: rgba(0,0,0,0.03); }
    .table tr:last-child td { border-bottom: 0; }
    .dropdown-item:active { background-color: #6571ff; color: #fff; }
    .card:hover { transform: translateY(-5px); transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .custom-card-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .custom-card-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-card-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .custom-card-scroll::-webkit-scrollbar-thumb:hover {
        background: #6571ff;
    }
    /* হেডার ফিক্সড রাখার জন্য */
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: #fff !important;
        border-bottom: 1px solid #f1f1f1 !important;
    }
</style>
@endsection