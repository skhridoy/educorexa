@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .perm-card { background:#fff; border:1px solid #f1f5f9; border-radius:16px; box-shadow:0 2px 12px rgba(15,23,42,0.04); overflow:hidden; transition:all 0.2s; }
    .perm-card:hover { border-color:#4f46e5; transform:translateY(-2px); box-shadow:0 8px 24px rgba(79,70,229,0.08); }
    .perm-header { background:#fafbff; padding:12px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; }
    .perm-title { font-family:'Outfit',sans-serif; font-weight:700; color:#4f46e5; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; margin:0; }
    .perm-body { padding:15px 20px; }
    
    .form-check-edu { margin-bottom:8px; display:flex; align-items:center; gap:8px; }
    .form-check-edu input { width:16px; height:16px; cursor:pointer; border-color:#cbd5e1; }
    .form-check-edu label { font-size:0.82rem; color:#475569; cursor:pointer; margin:0; text-transform:capitalize; }
    .form-check-edu input:checked + label { color:#4f46e5; font-weight:700; }

    .check-all-wrap { background:#eef2ff; border-radius:12px; padding:12px 24px; display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.roles.index') }}">Roles</a></li>
        <li><span>/</span></li>
        <li class="active">Create Role</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-shield-halved me-2" style="color:#4f46e5;"></i> Define New Role</h2>
            <p class="edu-page-sub">Configure role name, type and granular module permissions.</p>
        </div>
    </div>

    <form action="{{ route('super.roles.store') }}" method="POST">
        @csrf
        
        {{-- Basic Info --}}
        <div class="edu-panel mb-4">
            <div class="edu-panel-bd">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="edu-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control edu-input @error('name') is-invalid @enderror" placeholder="e.g. Finance Manager" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Role Category / Type <span class="text-danger">*</span></label>
                        <select name="role_type" class="form-select edu-input @error('role_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            @foreach($role_types as $type)
                                <option value="{{ $type }}" {{ old('role_type') == $type ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $type)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Permissions Selection --}}
        <div class="check-all-wrap">
            <div style="display:flex; align-items:center; gap:10px;">
                <i data-feather="lock" style="width:18px; color:#4f46e5;"></i>
                <span style="font-weight:700; color:#1e293b; font-size:0.9rem;">MODULE PERMISSIONS</span>
            </div>
            <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                <label class="form-check-label" for="checkAll" style="font-size:0.8rem; font-weight:700; color:#4f46e5; cursor:pointer;">SELECT ALL ACCESS</label>
                <input class="form-check-input" type="checkbox" id="checkAll" style="width:40px; height:20px; cursor:pointer;">
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
            @foreach($permissions->groupBy('group_name') as $groupName => $groupPermissions)
            <div class="col">
                <div class="perm-card h-100">
                    <div class="perm-header">
                        <h6 class="perm-title">{{ $groupName }}</h6>
                        <input type="checkbox" class="select-group" style="width:16px; height:16px; cursor:pointer;">
                    </div>
                    <div class="perm-body">
                        <div class="row">
                            @foreach($groupPermissions as $permission)
                            <div class="col-12">
                                <div class="form-check-edu">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="perm-checkbox" id="p_{{ $permission->id }}" {{ (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                    <label for="p_{{ $permission->id }}">{{ str_replace(['.', '-'], ' ', $permission->name) }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('super.roles.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
            <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                <i data-feather="save" style="width:16px; margin-right:5px;"></i> Save Role & Permissions
            </button>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
    const checkAll = document.getElementById('checkAll');
    const permCheckboxes = document.querySelectorAll('.perm-checkbox');
    const groupCheckboxes = document.querySelectorAll('.select-group');

    checkAll.addEventListener('change', function() {
        permCheckboxes.forEach(cb => cb.checked = this.checked);
        groupCheckboxes.forEach(cb => cb.checked = this.checked);
    });

    groupCheckboxes.forEach(groupCb => {
        groupCb.addEventListener('change', function() {
            const container = this.closest('.perm-card');
            const childCheckboxes = container.querySelectorAll('.perm-checkbox');
            childCheckboxes.forEach(cb => cb.checked = this.checked);
            updateMainCheckAll();
        });
    });

    permCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const container = this.closest('.perm-card');
            const groupCb = container.querySelector('.select-group');
            const childCheckboxes = container.querySelectorAll('.perm-checkbox');
            groupCb.checked = Array.from(childCheckboxes).every(c => c.checked);
            updateMainCheckAll();
        });
    });

    function updateMainCheckAll() {
        checkAll.checked = Array.from(permCheckboxes).every(cb => cb.checked);
    }
</script>
@endsection