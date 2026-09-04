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

    <div class="edu-panel mb-4">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl"><i class="fa-solid fa-chart-column me-2 text-primary"></i>Location Analysis</h6>
            <span style="font-size:0.8rem;color:#94a3b8;">Marketing overview</span>
        </div>
        <form method="GET" class="row g-3 p-3">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted">Division</label>
                <select name="division" class="form-select" onchange="this.form.submit()">
                    <option value="">All divisions</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division }}" @selected(request('division') === $division)>{{ $division }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted">District</label>
                <select name="district" class="form-select">
                    <option value="">All districts</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(request('district') === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i>Analyze</button>
            </div>
        </form>
        <div class="row g-3 px-3 pb-3">
            @forelse($divisionSummary as $item)
                <div class="col-sm-6 col-lg-3">
                    <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                        <div class="small text-muted">{{ $item->division }}</div>
                        <div class="fs-4 fw-bold text-primary">{{ $item->total }}</div>
                        <div class="small text-muted">registered schools</div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted small">Location data will appear as schools register with division and district.</div>
            @endforelse
        </div>
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
                        <th>Location</th>
                        <th>Package</th>
                        <th>Admin Email</th>
                        <th>Domain</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get(); @endphp
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
                        <td>
                            <div class="small fw-semibold">{{ $school->district ?: '—' }}</div>
                            <div class="small text-muted">{{ $school->division ?: 'Location not set' }}</div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-indigo dropdown-toggle py-1 px-2 rounded-3" type="button" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    {{ $school->subscriptionPackage->name ?? 'No Package' }}
                                </button>
                                <ul class="dropdown-menu shadow border-0 rounded-4 p-2">
                                    <li class="px-2 py-1 small fw-bold text-muted border-bottom mb-1">Change Plan</li>
                                    @foreach($packages as $pkg)
                                    <li>
                                        <form action="{{ route('manage.schools.change-package', $school->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="package_id" value="{{ $pkg->id }}">
                                            <button type="submit" class="dropdown-item rounded-3 {{ $school->subscription_package_id == $pkg->id ? 'active' : '' }}">
                                                {{ $pkg->name }} (৳{{ number_format($pkg->price) }})
                                            </button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
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
                                        @csrf
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
                        <td colspan="7" class="edu-empty">
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