@extends('layouts.school')

@section('customCSS')
<style>
    :root {
        --edu-primary: #4f46e5;
        --edu-primary-light: #eef2ff;
        --edu-secondary: #64748b;
        --edu-bg: #f8fafc;
        --edu-card-bg: #ffffff;
    }

    .edu-header-glass {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        margin: -24px -24px 30px -24px;
        padding: 30px 40px;
    }

    .edu-bc {
        display: flex;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0 0 12px 0;
        gap: 8px;
    }
    .edu-bc li { font-size: 0.8rem; color: var(--edu-secondary); }
    .edu-bc li a { color: var(--edu-primary); text-decoration: none; font-weight: 500; transition: color 0.2s; }
    .edu-bc li a:hover { color: #4338ca; }
    .edu-bc li.active { font-weight: 600; color: #1e293b; }
    .edu-bc li:not(:last-child)::after { content: "›"; margin-left: 8px; color: #94a3b8; font-size: 1.1rem; }

    .perm-card { background:#fff; border:1px solid #f1f5f9; border-radius:20px; overflow:hidden; transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1); height: 100%; border-bottom: 3px solid #f1f5f9; }
    .perm-card:hover { border-color:#4f46e5; transform:translateY(-3px); box-shadow:0 12px 30px rgba(79,70,229,0.08); border-bottom-color: #4f46e5; }
    .perm-header { background:#fafbff; padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; }
    .perm-title { font-family:'Outfit',sans-serif; font-weight:800; color:#1e293b; font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; margin:0; }
    .perm-body { padding:20px; }
    
    .form-check-edu { margin-bottom:12px; display:flex; align-items:flex-start; gap:12px; padding: 10px; border-radius: 12px; transition: all 0.2s; cursor: pointer; }
    .form-check-edu:hover { background: #f5f3ff; }
    .form-check-edu input { width:18px; height:18px; cursor:pointer; border-radius: 6px; border-color:#cbd5e1; margin-top: 2px; }
    .form-check-edu label { font-size:0.85rem; color:#475569; cursor:pointer; margin:0; text-transform:capitalize; flex: 1; font-weight: 500; }
    .form-check-edu input:checked + label { color:#4f46e5; font-weight:700; }

    .sticky-sidebar { position: sticky; top: 100px; }
    .info-card { background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 24px; padding: 30px; color: white; box-shadow: 0 10px 30px rgba(79,70,229,0.2); }
    .info-card h4 { font-weight: 800; letter-spacing: -0.02em; }
    
    .check-all-panel { background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 20px 30px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }

    .btn-edu-primary {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    .btn-edu-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
        color: white;
    }
    .btn-edu-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-edu-light:hover { background: #f1f5f9; color: #1e293b; }
</style>
@endsection

@section('content')
<div class="page-content">
    {{-- Glassmorphism Header --}}
    <div class="edu-header-glass">
        <div class="container-fluid">
            <ul class="edu-bc">
                <li><a href="{{ route('school.dashboard', ['tenant' => $tenant]) }}">Dashboard</a></li>
                <li><a href="{{ route('school.roles.index', ['tenant' => $tenant]) }}">Roles</a></li>
                <li class="active">Edit Role</li>
            </ul>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 style="font-weight: 800; color: #1e293b; letter-spacing: -0.03em; margin: 0;">
                        <span style="background: linear-gradient(135deg, #4f46e5, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Modify</span> Role Access
                    </h2>
                    <p style="color: #64748b; margin-top: 4px; font-size: 0.95rem;">Update institutional access profile and permission parameters.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('school.roles.update', ['tenant' => $tenant, 'role' => $role->id]) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="row g-4">
            
            <div class="row g-4">
                {{-- Left: Role Information --}}
                <div class="col-xl-4">
                    <div class="sticky-sidebar">
                        <div class="info-card mb-4">
                            <div class="d-flex align-items-center mb-4">
                                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="mb-0">Edit Role</h4>
                                    <p class="mb-0 text-white-50 small">Update access profile</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-white-50 small mb-2 fw-bold text-uppercase">Role Display Name</label>
                                <input type="text" name="name" class="form-control" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 12px 18px; border-radius: 12px;" placeholder="e.g. Senior Teacher" value="{{ old('name', $role->display_name ?? $role->name) }}" required>
                                @error('name') <div class="text-warning small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="text-white-50 small mb-2 fw-bold text-uppercase">Hierarchy Group</label>
                                <select name="role_type" class="form-select" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 12px 18px; border-radius: 12px;" required>
                                    @foreach($role_types as $type)
                                        <option value="{{ $type }}" {{ old('role_type', $role->role_type) == $type ? 'selected' : '' }} class="text-dark">{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                                    @endforeach
                                </select>
                                @error('role_type') <div class="text-warning small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="edu-panel p-4" style="border-radius: 20px;">
                            <div class="d-flex flex-column gap-3">
                                <button type="submit" class="btn-edu btn-edu-primary w-100 py-3" style="border-radius: 14px; font-weight: 700;">
                                    <i data-feather="refresh-cw" class="me-2"></i> Update Hierarchy
                                </button>
                                <a href="{{ route('school.roles.index', ['tenant' => $tenant]) }}" class="btn-edu btn-edu-light w-100 py-3" style="border-radius: 14px;">Cancel Operation</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Permissions Grid --}}
                <div class="col-xl-8">
                    <div class="check-all-panel">
                        <div class="d-flex align-items-center">
                            <div class="edu-avatar-sm me-3" style="background: #eef2ff; color: #4f46e5; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                <i data-feather="key" style="width: 22px; height: 22px;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: #1e293b;">Permission Matrix</h6>
                                <p class="mb-0 text-muted small">Update module access levels</p>
                            </div>
                        </div>
                        <div class="form-check form-switch d-flex align-items-center gap-3">
                            <label class="form-check-label fw-bold text-primary small" for="checkAll" style="cursor: pointer;">UNLIMITED ACCESS</label>
                            <input class="form-check-input" type="checkbox" id="checkAll" style="width: 44px; height: 22px; cursor: pointer;">
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        @php
                            $groupedPermissions = $permissions->groupBy('group_name');
                            $configGroups = array_keys(config('permissions.permissions', []));
                            $configGroups = array_filter($configGroups, function($group) {
                                return strpos($group, 'SaaS Management') === false;
                            });
                        @endphp

                        @foreach($configGroups as $groupName)
                            @if(isset($groupedPermissions[$groupName]))
                                @php $groupPermissions = $groupedPermissions[$groupName]; @endphp
                                <div class="col-md-6">
                                    <div class="perm-card">
                                        <div class="perm-header">
                                            <h6 class="perm-title">{{ $groupName }}</h6>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input select-group" style="width: 32px; height: 16px; cursor: pointer;">
                                            </div>
                                        </div>
                                        <div class="perm-body">
                                            @foreach($groupPermissions as $permission)
                                            <div class="form-check-edu" onclick="this.querySelector('input').click()">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="perm-checkbox" id="p_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', $currentPermissions)) ? 'checked' : '' }} onclick="event.stopPropagation()">
                                                <label for="p_{{ $permission->id }}">
                                                    {{ config("permissions.permissions.$groupName.".$permission->name) ?? str_replace(['.', '-'], ' ', $permission->name) }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php unset($groupedPermissions[$groupName]); @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('customJs')
<script>
    const checkAll = document.getElementById('checkAll');
    const permCheckboxes = document.querySelectorAll('.perm-checkbox');
    const groupCheckboxes = document.querySelectorAll('.select-group');

    function updateMainCheckAll() {
        if(permCheckboxes.length > 0) {
            checkAll.checked = Array.from(permCheckboxes).every(cb => cb.checked);
        }
    }

    function updateGroupStates() {
        groupCheckboxes.forEach(groupCb => {
            const container = groupCb.closest('.perm-card');
            const childCheckboxes = container.querySelectorAll('.perm-checkbox');
            groupCb.checked = Array.from(childCheckboxes).every(c => c.checked);
        });
    }

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
            const groupCb = container.querySelector('.form-check-input.select-group');
            const childCheckboxes = container.querySelectorAll('.perm-checkbox');
            groupCb.checked = Array.from(childCheckboxes).every(c => c.checked);
            updateMainCheckAll();
        });
    });

    // Initial State
    updateGroupStates();
    updateMainCheckAll();
</script>
@endsection
