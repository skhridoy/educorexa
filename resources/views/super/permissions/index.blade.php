@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Permissions</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-lock me-2" style="color:#4f46e5;"></i> Permissions by Module</h2>
            <p class="edu-page-sub">Manage access control organized by system modules.</p>
        </div>
        <a href="{{ route('super.permissions.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Create Permission
        </a>
    </div>

    <div class="row g-3">
        @forelse($permissions->groupBy('group_name') as $groupName => $groupPermissions)
        <div class="col-md-6 col-xl-4">
            <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;box-shadow:0 4px 16px rgba(15,23,42,0.05);overflow:hidden;height:100%;display:flex;flex-direction:column;">
                <div style="padding:16px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;background:#fafbff;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:8px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                            <i data-feather="box" style="width:14px;height:14px;color:#4f46e5;"></i>
                        </div>
                        <span style="font-family:'Outfit',sans-serif;font-weight:700;color:#1e293b;font-size:0.9rem;">{{ $groupName ?? 'General' }}</span>
                    </div>
                    <span class="badge-indigo">{{ count($groupPermissions) }}</span>
                </div>
                <div style="flex:1;overflow-y:auto;max-height:300px;">
                    @foreach($groupPermissions as $permission)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 20px;border-bottom:1px solid #f8fafc;">
                        <div>
                            <div style="font-weight:600;color:#1e293b;font-size:0.82rem;">{{ ucwords(str_replace(['-','_','.'],' ',$permission->name)) }}</div>
                            <div style="font-size:10px;color:#94a3b8;font-family:monospace;">{{ $permission->name }}</div>
                        </div>
                        <div style="display:flex;gap:4px;">
                            <a href="{{ route('super.permissions.edit', $permission->id) }}" class="act-btn" title="Edit">
                                <i data-feather="edit-2" style="width:13px;height:13px;"></i>
                            </a>
                            <form action="{{ route('super.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn del" onclick="return confirm('Delete this permission?')">
                                    <i data-feather="trash-2" style="width:13px;height:13px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div style="padding:10px 20px;background:#fafbff;border-top:1px solid #f1f5f9;text-align:center;">
                    <span style="font-size:0.75rem;color:#94a3b8;">{{ count($groupPermissions) }} permissions</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 edu-empty"><i class="fa-solid fa-lock-open"></i><p>No permissions found.</p></div>
        @endforelse
    </div>
</div>
@endsection