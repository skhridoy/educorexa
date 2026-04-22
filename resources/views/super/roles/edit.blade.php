@extends('layouts.main')

@section('customCSS')
<style>
    .card { border-radius: 10px; border: none; }
    .permission-section { background-color: #f8f9fa; border-radius: 12px; padding: 20px; }
    
    .permission-group-card {
        background-color: #fff;
        border: 1px solid #e8ebf1;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.3s ease;
    }
    .permission-group-card:hover { border-color: #6571ff; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    
    .permission-group-header {
        background-color: #f1f3f7;
        padding: 12px 15px;
        border-bottom: 1px solid #e8ebf1;
        border-radius: 10px 10px 0 0;
    }
    
    .custom-check { display: flex; align-items: flex-start; gap: 8px; margin-bottom: 10px; }
    .permission-label { 
        font-size: 0.85rem; 
        cursor: pointer; 
        text-transform: capitalize;
        word-break: break-word;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
        </ol>
    </nav>

    <form action="{{ route('super.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            {{-- Role Info Card --}}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Edit Role: <span class="text-primary">{{ $role->name }}</span></h6>
                            <a href="{{ route('super.roles.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="arrow-left"></i> Back
                            </a>
                        </div>
                        <hr class="mb-4">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control border-secondary @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $role->name) }}" placeholder="e.g. Manager">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Role Type <span class="text-danger">*</span></label>
                                <select name="role_type" class="form-select border-secondary @error('role_type') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    <option value="school_admin" {{ old('role_type', $role->role_type) == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                                    <option value="teacher" {{ old('role_type', $role->role_type) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ old('role_type', $role->role_type) == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="employee" {{ old('role_type', $role->role_type) == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                                @error('role_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permissions Card --}}
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">Update Permissions</h6>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                                <label class="form-check-label fw-bold text-primary" for="checkAll">Select All</label>
                            </div>
                        </div>
                        <hr class="mb-3">

                        <div class="permission-section">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                @php $currentPermissions = $role->permissions->pluck('name')->toArray(); @endphp
                                
                                @foreach($permissions->groupBy('group_name') as $group => $groupPermissions)
                                    <div class="col">
                                        <div class="permission-group-card shadow-sm">
                                            <div class="permission-group-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-bolder text-primary text-uppercase" style="font-size: 0.8rem;">
                                                    <i data-feather="layers" class="icon-sm me-1"></i> {{ $group }}
                                                </h6>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input select-group" id="group_{{ Str::slug($group) }}">
                                                    <label class="form-check-label small text-info fw-bold" for="group_{{ Str::slug($group) }}">Select All</label>
                                                </div>
                                            </div>
                                            <div class="permission-group-body p-3">
                                                <div class="row g-2">
                                                    @foreach($groupPermissions as $permission)
                                                    <div class="col-12 col-sm-6">
                                                        <div class="custom-check">
                                                            <input class="form-check-input permission-checkbox" 
                                                                   type="checkbox" name="permissions[]" 
                                                                   value="{{ $permission->name }}" 
                                                                   id="perm_{{ $permission->id }}"
                                                                   {{ in_array($permission->name, old('permissions', $currentPermissions)) ? 'checked' : '' }}>
                                                            <label class="permission-label" for="perm_{{ $permission->id }}" data-perm-name="{{ $permission->name }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @error('permissions') <p class="text-danger small mt-2 fw-bold text-center">{{ $message }}</p> @enderror

                        <div class="mt-5 d-flex flex-wrap justify-content-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow text-white mb-2">
                                <i data-feather="refresh-cw" class="icon-md me-2"></i> Update Role Now
                            </button>
                            <a href="{{ route('super.roles.index') }}" class="btn btn-secondary btn-lg ms-sm-3 mb-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof feather !== 'undefined') { feather.replace(); }

        // সুন্দর নাম দেখানোর জন্য
        document.querySelectorAll('.permission-label').forEach(label => {
            const rawName = label.getAttribute('data-perm-name');
            label.textContent = rawName.replace(/[.-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        });

        const checkAll = document.querySelector('#checkAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const groupCheckboxes = document.querySelectorAll('.select-group');

        // লোড হওয়ার সময় স্ট্যাটাস চেক
        const updateCheckAllStatus = () => {
            checkAll.checked = Array.from(checkboxes).every(c => c.checked);
            groupCheckboxes.forEach(groupCb => {
                const container = groupCb.closest('.permission-group-card');
                const childCheckboxes = container.querySelectorAll('.permission-checkbox');
                groupCb.checked = Array.from(childCheckboxes).every(c => c.checked);
            });
        };
        updateCheckAllStatus();

        // Select All Logic
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            groupCheckboxes.forEach(gb => gb.checked = checkAll.checked);
        });

        // Group Select Logic
        groupCheckboxes.forEach(groupCb => {
            groupCb.addEventListener('change', function() {
                const container = this.closest('.permission-group-card');
                container.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = groupCb.checked);
                updateCheckAllStatus();
            });
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCheckAllStatus);
        });
    });
</script>
@endsection