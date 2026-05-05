@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Pending Schools</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-hourglass-half me-2" style="color:#d97706;"></i> Pending School Requests</h2>
            <p class="edu-page-sub">Review and approve or reject new school registration requests.</p>
        </div>
        <span class="badge-amber" style="font-size:0.82rem;padding:6px 14px;">
            {{ $schools->count() }} Pending
        </span>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">New School Requests</h6>
        </div>
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>Admin Email</th>
                        <th>Domain</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        <td><span class="badge-id">{{ $school->id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:36px;height:36px;border-radius:10px;background:#fffbeb;color:#d97706;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($school->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:700;color:#1e293b;text-transform:uppercase;font-size:0.85rem;">{{ $school->name }}</span>
                            </div>
                        </td>
                        <td>{{ $school->admin->email ?? '—' }}</td>
                        <td>
                            <code style="background:#f8fafc;color:#4f46e5;padding:3px 8px;border-radius:6px;font-size:0.78rem;">
                                {{ $school->slug }}.{{ $mainDomain }}
                            </code>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <form action="{{ route('super.schools.approve', $school->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn-edu btn-edu-primary" style="padding:7px 16px;font-size:0.8rem;">
                                        <i data-feather="check" style="width:14px;height:14px;"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('super.schools.reject', $school->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-edu btn-edu-danger" style="padding:7px 16px;font-size:0.8rem;" onclick="confirmReject(this)">
                                        <i data-feather="x" style="width:14px;height:14px;"></i> Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="edu-empty">
                            <i class="fa-solid fa-inbox"></i>
                            <p>No pending requests. All caught up!</p>
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
function confirmReject(btn) {
    Swal.fire({ title:'Reject School?', text:'This will reject and delete the school request.',
        icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280',
        confirmButtonText:'Yes, reject' })
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:2000})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
</script>
@endsection