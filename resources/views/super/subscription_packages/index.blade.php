@extends('layouts.main')
@section('customCSS') 
@include('layouts._shared_styles')
<style>
/* Page Header Responsive */
.pkg-header-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 576px) {
    .pkg-header-wrap {
        flex-direction: column;
        align-items: stretch !important;
        gap: 14px;
    }
    .pkg-header-wrap .btn-edu {
        width: 100%;
        justify-content: center;
        padding: 12px 18px;
        font-size: 0.95rem;
    }
}

/* Stat Pills Bar */
.pkg-stat-bar {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 6px;
    margin-bottom: 20px;
    -webkit-overflow-scrolling: touch;
}
.pkg-stat-pill {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 8px 14px;
    font-size: 0.8rem;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.pkg-stat-pill strong {
    color: #1e293b;
    font-size: 0.95rem;
    font-weight: 700;
}

/* Mobile Card Layout (Visible only on screens < 768px) */
.pkg-mobile-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 16px 14px;
}
.pkg-m-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    padding: 18px;
    position: relative;
    overflow: hidden;
}
.pkg-m-card.is-popular {
    border-color: #fcd34d;
    background: linear-gradient(180deg, #fffdf8 0%, #ffffff 100%);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.08);
}
.pkg-m-card.is-popular::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
}

.pkg-m-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}
.pkg-m-title {
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    font-size: 1.2rem;
    color: #0f172a;
    line-height: 1.25;
}
.pkg-m-badges {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 6px;
}

.pkg-m-price-box {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 14px;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 14px;
}
.pkg-m-price {
    font-family: 'Outfit', sans-serif;
    font-weight: 800;
    font-size: 1.5rem;
    color: #4f46e5;
    line-height: 1;
}
.pkg-m-cycle {
    font-size: 0.82rem;
    font-weight: 500;
    color: #64748b;
    margin-left: 2px;
}

.pkg-m-desc {
    font-size: 0.82rem;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 14px;
}

/* Limits Box */
.pkg-m-limits {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 14px;
}
.pkg-m-limit-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 0.8rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #f1f5f9;
}

/* Commission Box */
.pkg-m-comm {
    background: linear-gradient(135deg, #f8faff 0%, #f1f5f9 100%);
    border: 1px solid #e0e7ff;
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 16px;
}
.pkg-m-comm-title {
    font-size: 0.72rem;
    font-weight: 700;
    color: #4338ca;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.pkg-m-comm-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.pkg-m-comm-item {
    display: flex;
    flex-direction: column;
}
.pkg-m-comm-label {
    font-size: 0.72rem;
    color: #64748b;
    margin-bottom: 2px;
}
.pkg-m-comm-val {
    font-weight: 700;
    font-size: 0.88rem;
}

/* Actions */
.pkg-m-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.pkg-m-btn-edit {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: transparent;
    color: #4f46e5 !important;
    font-weight: 600;
    font-size: 0.78rem;
    padding: 7px 12px;
    border-radius: 10px;
    border: 2px solid #4f46e5;
    text-decoration: none;
    transition: all 0.2s ease;
}
.pkg-m-btn-edit:hover, .pkg-m-btn-edit:active {
    background: #4f46e5;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(79,70,229,0.22);
}
.pkg-m-btn-del {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: transparent;
    color: #ef4444;
    border-radius: 10px;
    border: 2px solid #ef4444;
    transition: all 0.2s ease;
    cursor: pointer;
    flex-shrink: 0;
}
.pkg-m-btn-del:hover, .pkg-m-btn-del:active {
    background: #ef4444;
    color: #ffffff;
    box-shadow: 0 3px 10px rgba(239,68,68,0.22);
}

/* Empty State on Mobile */
.pkg-m-empty {
    text-align: center;
    padding: 48px 16px;
}
.pkg-m-empty i {
    font-size: 2.8rem;
    color: #cbd5e1;
    margin-bottom: 12px;
    display: block;
}
</style>
@endsection

@section('content')
<div class="page-content">
    {{-- Breadcrumbs --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Subscription Packages</li>
    </ul>

    {{-- Page Header --}}
    <div class="pkg-header-wrap">
        <div>
            <h2 class="edu-page-title">
                <i class="fa-solid fa-box-open me-2" style="color:#4f46e5;"></i> Subscription Packages
            </h2>
            <p class="edu-page-sub">Manage pricing plans, resource quotas, and representative commissions.</p>
        </div>
        <a href="{{ route('super.subscription-packages.create') }}" class="btn-edu btn-edu-primary shadow-sm">
            <i class="fa-solid fa-plus"></i> Add New Package
        </a>
    </div>

    {{-- Quick Stat Pills Bar --}}
    <div class="pkg-stat-bar">
        <div class="pkg-stat-pill">
            <i class="fa-solid fa-layer-group text-primary"></i>
            <span>Total Packages: <strong>{{ $packages->count() }}</strong></span>
        </div>
        <div class="pkg-stat-pill">
            <i class="fa-solid fa-circle-check text-success"></i>
            <span>Active: <strong>{{ $packages->where('is_active', true)->count() }}</strong></span>
        </div>
        <div class="pkg-stat-pill">
            <i class="fa-solid fa-star text-warning"></i>
            <span>Popular: <strong>{{ $packages->where('is_popular', true)->count() }}</strong></span>
        </div>
    </div>

    {{-- Main Container Panel --}}
    <div class="edu-panel">
        <div class="edu-panel-hd">
            <div>
                <h6 class="edu-panel-ttl">All Packages</h6>
                <span class="text-muted small">Configured subscription plans & tiers</span>
            </div>
            <span class="badge" style="background:#eef2ff;color:#4f46e5;font-weight:700;font-size:0.75rem;padding:5px 12px;border-radius:20px;">
                {{ $packages->count() }} Packages
            </span>
        </div>

        {{-- 1. DESKTOP & TABLET TABLE VIEW (Hidden on Mobile < 768px) --}}
        <div class="table-responsive d-none d-md-block">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Limits</th>
                        <th>Commissions</th>
                        <th>Popular</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td style="font-weight:700;color:#1e293b;">
                            <div>{{ $package->name }}</div>
                            @if($package->description)
                                <div class="text-muted small text-truncate" style="max-width:200px;font-weight:400;font-size:0.75rem;">
                                    {{ $package->description }}
                                </div>
                            @endif
                        </td>
                        <td style="font-weight:700;color:#4f46e5;font-size:0.95rem;">৳{{ number_format($package->price, 2) }}</td>
                        <td><span class="badge-gray">{{ ucfirst($package->duration) }}</span></td>
                        <td>
                            <div style="font-size:0.78rem;color:#64748b;line-height:1.4;">
                                <div><i class="fa-solid fa-user-graduate me-1 text-muted"></i>Students: <strong>{{ $package->student_limit ?? '∞' }}</strong></div>
                                <div><i class="fa-solid fa-chalkboard-user me-1 text-muted"></i>Teachers: <strong>{{ $package->teacher_limit ?? '∞' }}</strong></div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:0.78rem;line-height:1.4;">
                                <div><span style="color:#6366f1;font-weight:600;">রেজিস্ট্রেশন:</span> 
                                    @if(($package->registration_commission_rate ?? 0) > 0)
                                        {{ $package->registration_commission_type === 'percentage' ? $package->registration_commission_rate.'%' : '৳'.number_format($package->registration_commission_rate, 0) }}
                                    @else
                                        <span class="text-muted">ডিফল্ট</span>
                                    @endif
                                </div>
                                <div><span style="color:#059669;font-weight:600;">মাসিক:</span> 
                                    @if(($package->monthly_commission_rate ?? 0) > 0)
                                        {{ $package->monthly_commission_type === 'percentage' ? $package->monthly_commission_rate.'%' : '৳'.number_format($package->monthly_commission_rate, 0) }}
                                    @else
                                        <span class="text-muted">ডিফল্ট</span>
                                    @endif
                                </div>
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
                                <a href="{{ route('super.subscription-packages.edit', $package->id) }}" class="act-btn" title="Edit Package">
                                    <i data-feather="edit-3" style="width:15px;height:15px;"></i>
                                </a>
                                <form action="{{ route('super.subscription-packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="act-btn del" onclick="confirmDel(this)" title="Delete Package">
                                        <i data-feather="trash-2" style="width:15px;height:15px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="edu-empty">
                            <i class="fa-solid fa-box"></i>
                            <p>No packages created yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 2. MOBILE CARD VIEW (Visible only on screens < 768px) --}}
        <div class="d-block d-md-none">
            @if($packages->isEmpty())
                <div class="pkg-m-empty">
                    <i class="fa-solid fa-box-open"></i>
                    <h6 class="text-muted fw-semibold">No packages found</h6>
                    <p class="text-muted small">Create your first subscription package to get started.</p>
                    <a href="{{ route('super.subscription-packages.create') }}" class="btn-edu btn-edu-primary mt-2">
                        <i class="fa-solid fa-plus"></i> Add Package
                    </a>
                </div>
            @else
                <div class="pkg-mobile-list">
                    @foreach($packages as $package)
                    <div class="pkg-m-card {{ $package->is_popular ? 'is-popular' : '' }}">
                        {{-- Top Header: Title & Badges --}}
                        <div class="pkg-m-header">
                            <div>
                                <div class="pkg-m-title">{{ $package->name }}</div>
                                <div class="pkg-m-badges">
                                    <span class="badge-gray" style="font-size:0.72rem;">
                                        <i class="fa-solid fa-calendar-days me-1"></i>{{ ucfirst($package->duration) }}
                                    </span>
                                    @if($package->is_popular)
                                        <span class="badge-amber" style="font-size:0.72rem;">
                                            <i class="fa-solid fa-star" style="font-size:9px;"></i> Popular
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($package->is_active)
                                    <span class="badge-green">Active</span>
                                @else
                                    <span class="badge-red">Inactive</span>
                                @endif
                            </div>
                        </div>

                        {{-- Price Highlight --}}
                        <div class="pkg-m-price-box">
                            <div>
                                <span class="text-muted" style="font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Package Price</span>
                                <div class="pkg-m-price mt-1">
                                    ৳{{ number_format($package->price, 2) }}
                                    <span class="pkg-m-cycle">/ {{ $package->duration }}</span>
                                </div>
                            </div>
                            @if($package->price == 0)
                                <span class="badge bg-success-subtle text-success fw-bold px-2 py-1" style="font-size:0.72rem;">
                                    FREE
                                </span>
                            @endif
                        </div>

                        {{-- Description if available --}}
                        @if($package->description)
                            <div class="pkg-m-desc">
                                {{ $package->description }}
                            </div>
                        @endif

                        {{-- Quota / Limits Grid --}}
                        <div class="pkg-m-limits">
                            <div class="pkg-m-limit-item">
                                <i class="fa-solid fa-user-graduate text-primary"></i>
                                <div>
                                    <span style="font-size:0.7rem;color:#94a3b8;display:block;">Students</span>
                                    <strong>{{ $package->student_limit ?? 'Unlimited (∞)' }}</strong>
                                </div>
                            </div>
                            <div class="pkg-m-limit-item">
                                <i class="fa-solid fa-chalkboard-user text-indigo" style="color:#6366f1;"></i>
                                <div>
                                    <span style="font-size:0.7rem;color:#94a3b8;display:block;">Teachers</span>
                                    <strong>{{ $package->teacher_limit ?? 'Unlimited (∞)' }}</strong>
                                </div>
                            </div>
                        </div>

                        {{-- Representative Commission Box --}}
                        <div class="pkg-m-comm">
                            <div class="pkg-m-comm-title">
                                <i class="fa-solid fa-handshake"></i> প্রতিনিধি কমিশন সেটিংস
                            </div>
                            <div class="pkg-m-comm-grid">
                                <div class="pkg-m-comm-item">
                                    <span class="pkg-m-comm-label">রেজিস্ট্রেশন কমিশন:</span>
                                    <span class="pkg-m-comm-val" style="color:#4f46e5;">
                                        @if(($package->registration_commission_rate ?? 0) > 0)
                                            {{ $package->registration_commission_type === 'percentage' ? $package->registration_commission_rate.'%' : '৳'.number_format($package->registration_commission_rate, 0) }}
                                        @else
                                            <span class="text-muted fw-normal" style="font-size:0.78rem;">ডিফল্ট রেট</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="pkg-m-comm-item">
                                    <span class="pkg-m-comm-label">মাসিক রিকারিং কমিশন:</span>
                                    <span class="pkg-m-comm-val" style="color:#059669;">
                                        @if(($package->monthly_commission_rate ?? 0) > 0)
                                            {{ $package->monthly_commission_type === 'percentage' ? $package->monthly_commission_rate.'%' : '৳'.number_format($package->monthly_commission_rate, 0) }}
                                        @else
                                            <span class="text-muted fw-normal" style="font-size:0.78rem;">ডিফল্ট রেট</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Actions --}}
                        <div class="pkg-m-actions">
                            <a href="{{ route('super.subscription-packages.edit', $package->id) }}" class="pkg-m-btn-edit">
                                <i class="fa-solid fa-pen-to-square"></i> Edit Package
                            </a>
                            <form action="{{ route('super.subscription-packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="pkg-m-btn-del" onclick="confirmDel(this)" title="Delete Package">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

@section('customJs')
<script>
function confirmDel(btn) {
    Swal.fire({
        title: 'Delete Package?',
        text: 'This package and its settings will be permanently removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete'
    }).then(r => { 
        if(r.isConfirmed) btn.closest('form').submit(); 
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

@if(session('success'))
Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
}).fire({
    icon: 'success',
    title: "{{ session('success') }}"
});
@endif

@if(session('error'))
Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000
}).fire({
    icon: 'error',
    title: "{{ session('error') }}"
});
@endif
</script>
@endsection
