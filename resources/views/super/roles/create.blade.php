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
    .select-all-wrapper {
        background: #6571ff;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 15px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super.roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Role</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Add New Role</h6>
                    <hr>
                    
                    <form action="{{ route('super.roles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Role Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleNameId" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       id="roleNameId" placeholder="e.g. Manager" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Role Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="roleTypeId" class="form-label">Role Type <span class="text-danger">*</span></label>
                                <select name="role_type" class="form-select @error('role_type') is-invalid @enderror" id="roleTypeId">
                                    <option value="">Select Role Type</option>
                                    <option value="school_admin" {{ old('role_type') == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                                    <option value="teacher" {{ old('role_type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="student" {{ old('role_type') == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                @error('role_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Permissions Section --}}
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Assign Permissions</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                    <label class="form-check-label fw-bold text-primary" for="checkAll">Select All Permissions</label>
                                </div>
                            </div>
                            
                            <div class="permission-card">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   id="perm_{{ $permission->id }}"
                                                   value="{{ $permission->name }}"
                                                   {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
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
                            <button type="submit" class="btn btn-primary me-2">
                                <i data-feather="save" class="icon-sm me-1"></i> Create Role
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

        // Select All Logic
        const checkAll = document.querySelector('#checkAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = checkAll.checked;
            });
        });

        // Individual checkbox change logic
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                checkAll.checked = allChecked;
            });
        });
    });
</script>
@endsection