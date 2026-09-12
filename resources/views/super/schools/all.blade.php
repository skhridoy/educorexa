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
        <div class="sch-mobile-list d-block d-md-none">
            @forelse($schools as $school)
            <div class="sch-mobile-card">
                {{-- Card Header --}}
                <div class="sch-m-header">
                    <div class="sch-m-avatar-wrap">
                        <div class="sch-m-avatar">{{ strtoupper(substr($school->name, 0, 1)) }}</div>
                    </div>
                    <div class="sch-m-title-area">
                        <div class="sch-m-name">{{ $school->name }}</div>
                        <div class="sch-m-top-meta">
                            @if($school->is_active)
                                <span class="status-badge active"><span class="status-dot"></span> Active</span>
                            @else
                                <span class="status-badge inactive"><span class="status-dot"></span> Inactive</span>
                            @endif
                            <span class="role-badge"><i class="fa-solid fa-box me-1"></i>{{ $school->subscriptionPackage->name ?? 'No Package' }}</span>
                        </div>
                    </div>

                    {{-- Three-dot action dropdown menu (Mobile) --}}
                    <div class="dropdown sch-m-dropdown">
                        <button type="button" class="btn-m-dots" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 sch-actions-menu">
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-dark" href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-primary" style="width:16px;"></i>
                                    <span>ওয়েবসাইট ভিজিট</span>
                                </a>
                            </li>
                            @if(!$isRepUser)
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-indigo" href="javascript:void(0)" onclick="openChangePackageModal({{ $school->id }}, '{{ addslashes($school->name) }}', {{ $school->subscription_package_id ?? 'null' }})">
                                    <i class="fa-solid fa-cube text-primary" style="width:16px;"></i>
                                    <span>প্যাকেজ পরিবর্তন</span>
                                </a>
                            </li>
                            <li>
                                @if($school->is_active)
                                <form action="{{ route('manage.schools.reject', $school->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-warning">
                                        <i class="fa-solid fa-ban text-warning" style="width:16px;"></i>
                                        <span>নিষ্ক্রিয় করুন</span>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('manage.schools.approve', $school->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-success">
                                        <i class="fa-solid fa-check text-success" style="width:16px;"></i>
                                        <span>অনুমোদন করুন</span>
                                    </button>
                                </form>
                                @endif
                            </li>
                            @can('school.delete')
                            <li>
                                <form action="{{ route('manage.schools.destroy', $school->id) }}" method="POST" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="button" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" onclick="confirmDelete(this)">
                                        <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                        <span>ডিলিট করুন</span>
                                    </button>
                                </form>
                            </li>
                            @endcan
                            @else
                            @php
                                $pendingReq = \App\Models\SchoolDeleteRequest::where('school_id', $school->id)->where('status', 'pending')->first();
                            @endphp
                            @if(!$pendingReq && $school->status === 'approved')
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" href="javascript:void(0)" onclick="openDeleteRequestModal({{ $school->id }}, '{{ addslashes($school->name) }}')">
                                    <i class="fa-solid fa-trash-can" style="width:16px;"></i>
                                    <span>ডিলিট রিকোয়েস্ট</span>
                                </a>
                            </li>
                            @endif
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Card Details Grid --}}
                <div class="sch-m-details-grid">
                    <div class="sch-m-detail-item">
                        <span class="sch-m-detail-label">
                            <i class="fa-solid fa-location-dot text-danger"></i> লোকেশন
                        </span>
                        <span class="sch-m-detail-val">
                            {{ $school->district ?: '—' }}{{ $school->division ? ', '.$school->division : '' }}
                        </span>
                    </div>

                    <div class="sch-m-detail-item">
                        <span class="sch-m-detail-label">
                            <i class="fa-solid fa-globe text-primary"></i> ডোমেন
                        </span>
                        <span class="sch-m-detail-val">
                            <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank" class="text-primary text-decoration-none fw-bold">
                                {{ $school->slug }}.{{ $mainDomain }}
                            </a>
                        </span>
                    </div>

                    @if($school->email)
                    <div class="sch-m-detail-item" style="grid-column: 1 / -1;">
                        <span class="sch-m-detail-label">
                            <i class="fa-solid fa-envelope text-indigo"></i> এডমিন ইমেইল
                        </span>
                        <span class="sch-m-detail-val">
                            <a href="mailto:{{ $school->email }}" class="text-secondary text-decoration-none">{{ $school->email }}</a>
                        </span>
                    </div>
                    @endif

                    @if($school->representative?->user)
                    <div class="sch-m-detail-item" style="grid-column: 1 / -1;">
                        <span class="sch-m-detail-label">
                            <i class="fa-solid fa-id-badge text-muted"></i> রিপ্রেজেন্টেটিভ
                        </span>
                        <span class="sch-m-detail-val text-dark fw-bold">
                            {{ $school->representative->user->name }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="sch-empty-state text-center py-5">
                <i class="fa-solid fa-school-flag fa-2x mb-2 d-block" style="color:#cbd5e1;"></i>
                <span style="color:#94a3b8;font-size:0.875rem;">No schools registered yet.</span>
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

{{-- Change Package Modal (Mobile) --}}
<div class="modal fade" id="changePackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;border:none;box-shadow:0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fa-solid fa-cube text-primary me-2"></i>প্যাকেজ পরিবর্তন
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="changePackageForm" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <p class="text-muted small mb-3">
                        স্কুল: <strong id="modalPackageSchoolName" class="text-dark"></strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">প্যাকেজ নির্বাচন করুন <span class="text-danger">*</span></label>
                        <select name="package_id" id="modalPackageSelect" class="form-select edu-input" required>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->name }} (৳{{ number_format($pkg->price) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">সংরক্ষণ করুন</button>
                </div>
            </form>
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
   MOBILE RESPONSIVE CARD VIEW (< 768px)
   ======================================== */
.sch-mobile-list {
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.sch-mobile-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1.5px solid #f1f5f9;
    padding: 16px;
    box-shadow: 0 4px 16px rgba(15,23,42,0.04);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    position: relative;
}
.sch-mobile-card:active {
    transform: scale(0.99);
}
.sch-m-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}
.sch-m-avatar-wrap {
    flex-shrink: 0;
}
.sch-m-avatar {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: linear-gradient(135deg, #eef2ff, #c7d2fe);
    color: #4f46e5;
    font-weight: 800;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e0e7ff;
}
.sch-m-title-area {
    flex-grow: 1;
    min-width: 0;
}
.sch-m-name {
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #1e293b;
    margin-bottom: 3px;
    line-height: 1.25;
}
.sch-m-top-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.sch-m-dropdown {
    flex-shrink: 0;
    margin-left: auto;
}
.btn-m-dots {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-m-dots:hover, .btn-m-dots:focus, .btn-m-dots[aria-expanded="true"] {
    background: #eef2ff;
    color: #4f46e5;
    border-color: #c7d2fe;
}
.sch-actions-menu {
    border-radius: 14px;
    padding: 6px;
    min-width: 175px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
    border: 1px solid #f1f5f9 !important;
    z-index: 1050;
}
.sch-actions-menu .dropdown-item {
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.15s;
}
.sch-actions-menu .dropdown-item:hover {
    background: #f8fafc;
}
.sch-m-details-grid {
    background: #f8fafc;
    border-radius: 12px;
    padding: 10px 12px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 12px;
    border: 1px solid #f1f5f9;
}
.sch-m-detail-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.sch-m-detail-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    gap: 4px;
}
.sch-m-detail-val {
    font-size: 0.82rem;
    font-weight: 600;
    color: #334155;
    word-break: break-all;
}
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 700;
    font-size: 0.72rem;
    padding: 3px 10px;
    border-radius: 20px;
}
.status-badge.active { background: #dcfce7; color: #16a34a; }
.status-badge.inactive { background: #fee2e2; color: #ef4444; }
.status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
.role-badge {
    background: #f1f5f9; color: #475569;
    font-weight: 600; font-size: 0.72rem;
    padding: 3px 9px; border-radius: 6px;
    border: 1px solid #e2e8f0;
    display: inline-block;
}
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