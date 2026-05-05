@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Roles Management</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-shield-halved me-2" style="color:#4f46e5;"></i> System Roles</h2>
            <p class="edu-page-sub">Manage user roles and their respective access permissions.</p>
        </div>
        <a href="{{ route('super.roles.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add New Role
        </a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div style="background:#fff;border-radius:14px;border:1px solid #f1f5f9;padding:20px 24px;display:flex;align-items:center;gap:16px;box-shadow:0 2px 12px rgba(15,23,42,0.05);">
                <div style="width:44px;height:44px;border-radius:12px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                    <i data-feather="shield" style="width:20px;height:20px;color:#4f46e5;"></i>
                </div>
                <div>
                    <div style="font-size:0.78rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Total Roles</div>
                    <div style="font-family:'Outfit',sans-serif;font-size:1.6rem;font-weight:700;color:#1e293b;line-height:1;">{{ $roles->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">All Roles</h6>
        </div>
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>Role Identity</th>
                        <th>Permissions</th>
                        <th class="text-center">Users</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                                    <i data-feather="shield" style="width:16px;height:16px;color:#4f46e5;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;color:#1e293b;font-size:0.875rem;">
                                        {{ ucfirst($role->name) }}
                                        @if($role->name == 'super-admin')
                                            <span class="badge-indigo" style="font-size:9px;margin-left:4px;">Protected</span>
                                        @endif
                                    </div>
                                    <div style="font-size:0.72rem;color:#94a3b8;">{{ ucfirst(str_replace('_', ' ', $role->role_type ?? 'Custom')) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;max-width:460px;">
                                @foreach($role->permissions->take(6) as $perm)
                                    <span style="background:#f1f5f9;color:#475569;font-size:10px;font-weight:600;padding:3px 8px;border-radius:20px;">
                                        {{ str_replace(['-', '.'], ' ', $perm->name) }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 6)
                                    <span style="background:#eef2ff;color:#4f46e5;font-size:10px;font-weight:700;padding:3px 8px;border-radius:20px;">
                                        +{{ $role->permissions->count() - 6 }} more
                                    </span>
                                @endif
                                @if($role->permissions->count() == 0)
                                    <span style="color:#94a3b8;font-size:0.8rem;font-style:italic;">No permissions</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-gray">{{ $role->users_count ?? 0 }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('super.roles.edit', $role->id) }}" class="act-btn" title="Edit Role">
                                    <i data-feather="edit-3" style="width:15px;height:15px;"></i>
                                </a>
                                @if($role->name !== 'super-admin')
                                <form action="{{ route('super.roles.destroy', $role->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="act-btn del delete-btn" title="Delete Role">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="edu-empty">
                            <i class="fa-solid fa-shield-slash"></i>
                            <p>No roles found. <a href="{{ route('super.roles.create') }}" style="color:#4f46e5;">Create the first role</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const form = this.closest('.delete-form');
        Swal.fire({ title:'Delete Role?', text:'Users with this role may lose access.',
            icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444',
            cancelButtonColor:'#6b7280', confirmButtonText:'Yes, delete' })
            .then(r => { if(r.isConfirmed) form.submit(); });
    });
});
@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
</script>
@endsection