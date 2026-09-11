@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
@php
    $authUser = auth()->user();
    $isRepUser = $authUser && !$authUser->hasRole('super_admin') && (
        $authUser->hasRole('Representative') || 
        $authUser->role === 'Representative' || 
        $authUser->role === 'employee' || 
        $authUser->employee
    );
    $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
@endphp

<div class="page-content">
    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ $isRepUser ? route('rep.dashboard') : route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">All Schools</li>
    </ul>

    {{-- Page Header --}}
    <div class="sch-page-hd">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-school me-2" style="color:#4f46e5;"></i> All Schools</h2>
            <p class="edu-page-sub">Manage all registered school tenants on the platform.</p>
        </div>
        @can('school.create')
        <a href="{{ route('manage.schools.create') }}" class="btn-edu btn-edu-primary">
            <i class="fa-solid fa-plus"></i>
            <span class="d-none d-sm-inline">Create School</span>
            <span class="d-sm-none">New</span>
        </a>
        @endcan
    </div>

    {{-- Location Analysis Panel --}}
    <div class="edu-panel mb-4">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl"><i class="fa-solid fa-chart-column me-2 text-primary"></i>Location Analysis</h6>
            <span style="font-size:0.78rem;color:#94a3b8;">Marketing overview</span>
        </div>
        <form method="GET" class="row g-2 p-3">
            <div class="col-6 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">Division</label>
                <select name="division" class="form-select form-select-sm edu-input" onchange="this.form.submit()">
                    <option value="">All divisions</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division }}" @selected(request('division') === $division)>{{ $division }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-5">
                <label class="form-label small fw-bold text-muted mb-1">District</label>
                <select name="district" class="form-select form-select-sm edu-input">
                    <option value="">All districts</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(request('district') === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
                <button class="sch-filter-btn w-100">
                    <i class="fa-solid fa-filter me-1"></i>Analyze
                </button>
            </div>
        </form>
        @if($divisionSummary->count())
        <div class="row g-2 px-3 pb-3">
            @foreach($divisionSummary as $item)
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="sch-stat-chip">
                    <div class="sch-stat-num">{{ $item->total }}</div>
                    <div class="sch-stat-label">{{ $item->division }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Schools Panel --}}
    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Schools List</h6>
            <span class="sch-count-badge">{{ $schools->count() }} total</span>
        </div>

        {{-- ===== MOBILE CARDS (visible < md) ===== --}}
        <div class="d-md-none px-3 pb-3 pt-2">
            @forelse($schools as $school)
            <div class="sch-m-card">
                {{-- Card Header --}}
                <div class="sch-m-card-hd">
                    <div class="sch-m-avatar">{{ strtoupper(substr($school->name, 0, 1)) }}</div>
                    <div class="sch-m-info">
                        <div class="sch-m-name">{{ $school->name }}</div>
                        <div class="sch-m-loc">
                            <i class="fa-solid fa-location-dot" style="font-size:10px;color:#94a3b8;"></i>
                            {{ $school->district ?: '—' }}{{ $school->division ? ', '.$school->division : '' }}
                        </div>
                    </div>
                    @if($school->is_active)
                        <span class="sch-m-pill sch-m-pill-active">Active</span>
                    @else
                        <span class="sch-m-pill sch-m-pill-inactive">Inactive</span>
                    @endif
                </div>

                {{-- Meta rows --}}
                <div class="sch-m-meta">
                    <div class="sch-m-meta-row">
                        <span class="sch-m-meta-lbl"><i class="fa-solid fa-box me-1"></i>Package</span>
                        <span class="sch-m-meta-val">{{ $school->subscriptionPackage->name ?? 'No Package' }}</span>
                    </div>
                    @if($school->email)
                    <div class="sch-m-meta-row">
                        <span class="sch-m-meta-lbl"><i class="fa-solid fa-envelope me-1"></i>Email</span>
                        <span class="sch-m-meta-val" style="font-size:0.78rem;">{{ $school->email }}</span>
                    </div>
                    @endif
                    <div class="sch-m-meta-row">
                        <span class="sch-m-meta-lbl"><i class="fa-solid fa-globe me-1"></i>Domain</span>
                        <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank" class="sch-m-domain">
                            {{ $school->slug }}.{{ $mainDomain }}
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:9px;"></i>
                        </a>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="sch-m-actions">
                    @if(!$isRepUser)
                        {{-- Package Change Dropdown --}}
                        <div class="dropdown flex-1">
                            <button class="sch-m-btn-pkg dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-cube me-1"></i>Change Plan
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

                        {{-- Approve/Reject --}}
                        @if($school->is_active)
                            <form action="{{ route('manage.schools.reject', $school->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="sch-m-icon-btn sch-m-icon-warn" title="Deactivate">
                                    <i class="fa-solid fa-ban" style="font-size:13px;"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('manage.schools.approve', $school->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="sch-m-icon-btn sch-m-icon-succ" title="Approve">
                                    <i class="fa-solid fa-check" style="font-size:13px;"></i>
                                </button>
                            </form>
                        @endif

                        @can('school.delete')
                        <form action="{{ route('manage.schools.destroy', $school->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="sch-m-icon-btn sch-m-icon-del" onclick="confirmDelete(this)" title="Delete">
                                <i class="fa-solid fa-trash" style="font-size:13px;"></i>
                            </button>
                        </form>
                        @endcan
                    @else
                        @php
                            $pendingReq = \App\Models\SchoolDeleteRequest::where('school_id', $school->id)->where('status', 'pending')->first();
                        @endphp
                        @if($pendingReq)
                            <span class="sch-m-pill sch-m-pill-warn">পেন্ডিং রিকোয়েস্ট</span>
                        @elseif($school->status === 'approved')
                            <button type="button" class="sch-m-btn-del-req" onclick="openDeleteRequestModal({{ $school->id }}, '{{ addslashes($school->name) }}')">
                                <i class="fa-solid fa-trash me-1" style="font-size:11px;"></i>ডিলিট রিকোয়েস্ট
                            </button>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    @endif
                </div>
            </div>
            @empty
            <div class="edu-empty">
                <i class="fa-solid fa-school-flag"></i>
                <p>No schools registered yet.</p>
            </div>
            @endforelse
        </div>

        {{-- ===== DESKTOP TABLE (visible >= md) ===== --}}
        <div class="d-none d-md-block table-responsive">
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
                                <button class="sch-pkg-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                        <td style="font-size:0.82rem;">{{ $school->email ?? '—' }}</td>
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
                                @if(!$isRepUser)
                                    @if($school->is_active)
                                        <form action="{{ route('manage.schools.reject', $school->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="act-btn" title="Reject / Deactivate" style="color:#d97706;border-color:#fde68a;">
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
                                    @can('school.delete')
                                    <form action="{{ route('manage.schools.destroy', $school->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="act-btn del" onclick="confirmDelete(this)" title="Delete">
                                            <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                        </button>
                                    </form>
                                    @endcan
                                @else
                                    @php
                                        $pendingReq = \App\Models\SchoolDeleteRequest::where('school_id', $school->id)->where('status', 'pending')->first();
                                    @endphp
                                    @if($pendingReq)
                                        <span class="badge bg-warning-subtle text-warning fw-semibold px-2 py-1" style="font-size:0.7rem;border-radius:8px;">পেন্ডিং</span>
                                    @elseif($school->status === 'approved')
                                        <button type="button" class="act-btn del" onclick="openDeleteRequestModal({{ $school->id }}, '{{ addslashes($school->name) }}')" title="ডিলিট রিকোয়েস্ট পাঠান">
                                            <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="edu-empty">
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

{{-- Delete Request Modal --}}
<div class="modal fade" id="deleteRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;border:none;box-shadow:0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>স্কুল ডিলিট রিকোয়েস্ট
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteRequestForm" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <p class="text-muted mb-3" style="font-size:0.92rem;">
                        আপনি <strong id="modalSchoolName" class="text-dark"></strong> স্কুলটি ডিলিট করার জন্য সুপার এডমিন বা HR এর কাছে রিকোয়েস্ট পাঠাচ্ছেন। ডিলিট করার সুনির্দিষ্ট কারণ উল্লেখ করুন:
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">ডিলিট করার কারণ <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control edu-input" rows="4"
                                  placeholder="যেমন: স্কুল কর্তৃপক্ষ সেবা বাতিল করেছে বা ভুলবশত খোলা হয়েছিল..."
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-edu btn-edu-light px-4" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn-edu btn-edu-danger px-4 fw-semibold">রিকোয়েস্ট পাঠান</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ===== Page Header ===== */
.sch-page-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
}

/* ===== Filter Button ===== */
.sch-filter-btn {
    background: transparent;
    border: 2px solid #4f46e5;
    color: #4f46e5;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 8px 14px;
    cursor: pointer;
    transition: all 0.2s;
}
.sch-filter-btn:hover { background: #4f46e5; color: #fff; }

/* ===== Stat Chips ===== */
.sch-stat-chip {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
    text-align: center;
    transition: box-shadow 0.2s;
}
.sch-stat-chip:hover { box-shadow: 0 4px 12px rgba(79,70,229,0.1); border-color: #c7d2fe; }
.sch-stat-num   { font-size: 1.4rem; font-weight: 800; color: #4f46e5; line-height: 1.2; }
.sch-stat-label { font-size: 0.7rem; color: #94a3b8; font-weight: 600; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.05em; }

/* ===== Count Badge ===== */
.sch-count-badge {
    font-size: 0.75rem;
    background: #eef2ff;
    color: #4f46e5;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
}

/* ===== Desktop Package Button ===== */
.sch-pkg-btn {
    background: transparent;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 5px 10px;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.sch-pkg-btn:hover { border-color: #4f46e5; color: #4f46e5; }

/* ========================================
   MOBILE CARD STYLES
   ======================================== */
.sch-m-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 12px;
    transition: box-shadow 0.2s, transform 0.2s;
}
.sch-m-card:hover { box-shadow: 0 6px 20px rgba(79,70,229,0.1); transform: translateY(-1px); }

/* Card Header */
.sch-m-card-hd {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.sch-m-avatar {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #eef2ff, #c7d2fe);
    color: #4f46e5;
    font-weight: 800;
    font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sch-m-info { flex: 1; min-width: 0; }
.sch-m-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sch-m-loc { font-size: 0.72rem; color: #94a3b8; margin-top: 2px; }

/* Status Pills */
.sch-m-pill {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}
.sch-m-pill-active   { background: #dcfce7; color: #15803d; }
.sch-m-pill-inactive { background: #f1f5f9; color: #64748b; }
.sch-m-pill-warn     { background: #fef3c7; color: #92400e; }

/* Meta Rows */
.sch-m-meta { margin-bottom: 12px; }
.sch-m-meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
    border-bottom: 1px solid #f8fafc;
    gap: 8px;
}
.sch-m-meta-row:last-child { border-bottom: none; }
.sch-m-meta-lbl {
    font-size: 0.72rem;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    white-space: nowrap;
    flex-shrink: 0;
}
.sch-m-meta-val {
    font-size: 0.8rem;
    color: #475569;
    font-weight: 600;
    text-align: right;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.sch-m-domain {
    font-size: 0.75rem;
    color: #4f46e5;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Card Actions */
.sch-m-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}

/* Package change button (mobile) */
.sch-m-btn-pkg {
    flex: 1;
    background: transparent;
    border: 2px solid #4f46e5;
    color: #4f46e5;
    border-radius: 10px;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.sch-m-btn-pkg:hover { background: #4f46e5; color: #fff; box-shadow: 0 3px 10px rgba(79,70,229,0.2); }

/* Icon action buttons (mobile) */
.sch-m-icon-btn {
    width: 36px; height: 36px;
    border-radius: 10px;
    border: 2px solid;
    background: transparent;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.sch-m-icon-warn { color: #d97706; border-color: #fbbf24; }
.sch-m-icon-warn:hover { background: #d97706; color: #fff; border-color: #d97706; }
.sch-m-icon-succ { color: #16a34a; border-color: #86efac; }
.sch-m-icon-succ:hover { background: #16a34a; color: #fff; border-color: #16a34a; }
.sch-m-icon-del  { color: #ef4444; border-color: #fca5a5; }
.sch-m-icon-del:hover  { background: #ef4444; color: #fff; border-color: #ef4444; box-shadow: 0 3px 10px rgba(239,68,68,0.25); }

/* Delete request button (mobile for reps) */
.sch-m-btn-del-req {
    background: transparent;
    border: 2px solid #ef4444;
    color: #ef4444;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 7px 12px;
    cursor: pointer;
    transition: all 0.2s;
}
.sch-m-btn-del-req:hover { background: #ef4444; color: #fff; }

/* Mobile empty card gap */
.d-md-none .edu-empty { padding: 40px 16px; }
</style>
@endsection

@section('customJs')
<script>
function confirmDelete(btn) {
    Swal.fire({ title:'Delete School?', text:'This action cannot be undone.', icon:'warning',
        showCancelButton:true, confirmButtonColor:'#4f46e5', cancelButtonColor:'#ef4444',
        confirmButtonText:'Yes, delete' })
        .then(r => { if(r.isConfirmed) btn.closest('form').submit(); });
}
function openDeleteRequestModal(schoolId, schoolName) {
    document.getElementById('modalSchoolName').innerText = schoolName;
    document.getElementById('deleteRequestForm').action = '/representative/request-delete/' + schoolId;
    new bootstrap.Modal(document.getElementById('deleteRequestModal')).show();
}
@if(session('success'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000,timerProgressBar:true})
    .fire({icon:'success',title:"{{ session('success') }}"});
@endif
@if(session('error'))
Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:4000,timerProgressBar:true})
    .fire({icon:'error',title:"{{ session('error') }}"});
@endif
</script>
@endsection