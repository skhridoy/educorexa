@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">All Schools</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-school me-2" style="color:#4f46e5;"></i> All Schools</h2>
            <p class="edu-page-sub">Manage all registered school tenants on the platform.</p>
        </div>
        @can('school.create')
        <a href="{{ route('manage.schools.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Create School
        </a>
        @endcan
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Schools List</h6>
            <span style="font-size:0.8rem;color:#94a3b8;">{{ $schools->count() }} total</span>
        </div>
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School</th>
                        <th>Admin Email</th>
                        <th>Domain</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        <td><span class="badge-id">{{ $school->id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($school->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:700;color:#1e293b;">{{ $school->name }}</span>
                            </div>
                        </td>
                        <td>{{ $school->email ?? '—' }}</td>
                        <td>
                            <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank"
                               style="color:#4f46e5;font-size:0.82rem;font-weight:600;text-decoration:none;">
                                <i data-feather="external-link" style="width:13px;height:13px;margin-right:4px;"></i>
                                {{ $school->slug }}.{{ $mainDomain }}
                            </a>
                        </td>
                        <td>
                            @if($school->is_active)
                                <span class="badge-green">Active</span>
                            @else
                                <span class="badge-gray">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if($school->is_active)
                                    <form action="{{ route('manage.schools.reject', $school->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="act-btn" title="Reject / Deactivate" style="color:#d97706;">
                                            <i data-feather="x-circle" style="width:15px;height:15px;"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('manage.schools.approve', $school->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="act-btn succ" title="Approve">
                                            <i data-feather="check-circle" style="width:15px;height:15px;"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('manage.schools.destroy', $school->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="act-btn del" onclick="confirmDelete(this)" title="Delete">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="edu-empty">
                            <i class="fa-solid fa-school-flag"></i>
                            <p>No schools registered yet.</p>
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
function confirmDelete(btn) {
    Swal.fire({ title:'Delete School?', text:'This action cannot be undone.', icon:'warning',
        showCancelButton:true, confirmButtonColor:'#4f46e5', cancelButtonColor:'#ef4444',
        confirmButtonText:'Yes, delete' })
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000,timerProgressBar:true})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
</script>
@endsection