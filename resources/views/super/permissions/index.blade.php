@extends('layouts.main')

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Permissions Management</h6>
                        <a href="{{ route('super.permissions.create') }}" class="btn btn-primary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="plus-square"></i> Create Permission
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-fill-success alert-dismissible fade show" role="alert">
                            <i data-feather="check-circle" class="me-2 icon-sm"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 align-middle text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3" style="width: 10%;">ID</th>
                                    <th class="py-3 text-start">Permission Name</th>
                                    <th class="py-3">Module/Group</th> {{-- নতুন কলাম --}}
                                    <th class="py-3">Guard</th>
                                    <th class="py-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td><span class="text-muted fw-bold">#{{ $permission->id }}</span></td>
                                    <td class="text-start">
                                        <span class="text-dark fw-medium">{{ str_replace('-', ' ', $permission->name) }}</span>
                                    </td>
                                    <td>
                                        {{-- গ্রুপ নাম দেখানোর জন্য সুন্দর একটি ব্যাজ --}}
                                        <span class="badge bg-soft-info text-info px-3">
                                            {{ $permission->group_name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td><code class="small text-muted">{{ $permission->guard_name ?? 'web' }}</code></td>
                                    <td class="text-end">
                                        <a href="{{ route('super.permissions.edit', $permission->id) }}" 
                                           class="btn btn-xs btn-outline-info btn-icon me-1" 
                                           title="Edit Permission">
                                            <i data-feather="edit-3"></i>
                                        </a>
                                        
                                        <form action="{{ route('super.permissions.destroy', $permission->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-xs btn-outline-danger btn-icon delete-btn" title="Delete Permission">
                                                <i data-feather="trash-2"></i>
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