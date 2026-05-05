@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Subscription Packages</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-box-open me-2" style="color:#4f46e5;"></i> Subscription Packages</h2>
            <p class="edu-page-sub">Manage pricing plans and subscription tiers for school tenants.</p>
        </div>
        <a href="{{ route('super.subscription-packages.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i> Add Package
        </a>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">All Packages</h6>
            <span style="font-size:0.8rem;color:#94a3b8;">{{ $packages->count() }} total</span>
        </div>
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Limits</th>
                        <th>Popular</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td style="font-weight:700;color:#1e293b;">{{ $package->name }}</td>
                        <td style="font-weight:700;color:#4f46e5;">৳{{ number_format($package->price, 2) }}</td>
                        <td><span class="badge-gray">{{ ucfirst($package->duration) }}</span></td>
                        <td>
                            <div style="font-size:0.78rem;color:#64748b;">
                                <div>Students: <strong>{{ $package->student_limit ?? '∞' }}</strong></div>
                                <div>Teachers: <strong>{{ $package->teacher_limit ?? '∞' }}</strong></div>
                            </div>
                        </td>
                        <td>
                            @if($package->is_popular)
                                <span class="badge-amber"><i class="fa-solid fa-star" style="font-size:9px;"></i> Popular</span>
                            @else
                                <span style="color:#94a3b8;font-size:0.8rem;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($package->is_active)
                                <span class="badge-green">Active</span>
                            @else
                                <span class="badge-red">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('super.subscription-packages.edit', $package->id) }}" class="act-btn" title="Edit">
                                    <i data-feather="edit-3" style="width:15px;height:15px;"></i>
                                </a>
                                <form action="{{ route('super.subscription-packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="act-btn del" onclick="confirmDel(this)" title="Delete">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="edu-empty">
                            <i class="fa-solid fa-box"></i>
                            <p>No packages created yet.</p>
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
function confirmDel(btn) {
    Swal.fire({title:'Delete Package?',text:'This cannot be undone.',icon:'warning',
        showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',confirmButtonText:'Delete'})
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
</script>
@endsection
