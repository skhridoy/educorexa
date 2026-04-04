@extends('layouts.main')

@section('customCSS')
<style>
    .permission-card {
        border: 1px solid #e8ebf1;
        border-radius: 8px;
        padding: 15px;
        background-color: #f9fafb;
    }
    .form-check-label {
        cursor: pointer;
        text-transform: capitalize;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Role</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title mb-0">Update Role: <span class="text-primary">{{ $role->name }}</span></h6>
                        <a href="{{ route('super.roles.index') }}" class="btn btn-sm btn-outline-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                            Back to List
                        </a>
                    </div>
                    <hr>
                    
                    <form action="{{ route('super.roles.update', ['role' => $role->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Role Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleNameId" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       id="roleNameId" placeholder="Role Name" value="{{ old('name', $role->name) }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Role Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleTypeId" class="form-label">Role Type <span class="text-danger">*</span></label>
                                <select name="role_type" class="form-select @error('role_type') is-invalid @enderror" id="roleTypeId">
                                    <option value="">Select Role Type</option>
                                    <option value="school_admin" {{ old('role_type', $role->role_type) == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                                    <option value="teacher" {{ old('role_type', $role->role_type) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ old('role_type', $role->role_type) == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                @error('role_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Permissions Section --}}
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Update Permissions</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                    <label class="form-check-label fw-bold text-primary" for="checkAll">Select All Permissions</label>
                                </div>
                            </div>
                            
                            <div class="permission-card">
                                <div class="row">
                                    @php
                                        // রোলের বর্তমান পারমিশনগুলোর নাম একটি অ্যারেতে নেওয়া
                                        $currentPermissions = $role->permissions->pluck('name')->toArray();
                                    @endphp
                                    @foreach($permissions as $permission)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   id="perm_{{ $permission->id }}"
                                                   value="{{ $permission->name }}"
                                                   {{ in_array($permission->name, old('permissions', $currentPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ str_replace('-', ' ', $permission->name) }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 text-white">
                                <i data-feather="refresh-cw" class="icon-sm me-1"></i> Update Role
                            </button>
                            <a href="{{ route('super.roles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
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

        const checkAll = document.querySelector('#checkAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // পেজ লোড হওয়ার সময় যদি সব চেক থাকে তবে 'Select All' চেক হবে
        const updateCheckAllStatus = () => {
            const allChecked = Array.from(checkboxes).every(c => c.checked);
            checkAll.checked = allChecked;
        };
        updateCheckAllStatus();

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = checkAll.checked;
            });
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCheckAllStatus);
        });
    });
</script>
@endsection