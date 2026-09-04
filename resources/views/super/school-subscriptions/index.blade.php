@extends('layouts.main')

@section('customCSS')
<style>
    .sub-pay-page { font-size: 0.82rem; }
    .sub-pay-title { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
    .sub-pay-sub { font-size: 0.76rem; color: #64748b; margin-bottom: 0; }
    
    .stat-card-compact {
        border-radius: 14px;
        padding: 12px 14px;
        border: 1px solid rgba(0,0,0,0.05);
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .stat-card-compact .stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }
    .stat-card-compact .stat-val {
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.2;
        margin-top: 2px;
    }
    .stat-card-compact .stat-sub {
        font-size: 0.68rem;
        color: #94a3b8;
    }
    .stat-icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.85rem;
    }

    .sub-nav-pills {
        gap: 6px;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }
    .sub-nav-pills::-webkit-scrollbar {
        height: 3px;
    }
    .sub-nav-pills::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .sub-nav-link {
        font-size: 0.74rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        white-space: nowrap;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .sub-table {
        font-size: 0.78rem;
        width: 100%;
        margin-bottom: 0;
    }
    .sub-table th {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        padding: 8px 10px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .sub-table td {
        padding: 7px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .school-name-text {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.8rem;
        line-height: 1.2;
    }
    .school-slug-text {
        font-size: 0.68rem;
        color: #94a3b8;
    }
    .pkg-badge {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .trx-code {
        font-size: 0.72rem;
        font-weight: 700;
        color: #4f46e5;
        font-family: monospace;
        background: #eef2ff;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }
    .amount-text {
        font-weight: 800;
        color: #16a34a;
        font-size: 0.82rem;
        white-space: nowrap;
    }
    .btn-action-xs {
        font-size: 0.68rem;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 600;
        white-space: nowrap;
    }

    @media (max-width: 767.98px) {
        .sub-pay-title { font-size: 1rem; }
        .sub-pay-sub { font-size: 0.72rem; }
        .stat-card-compact { padding: 10px 12px; }
        .stat-card-compact .stat-val { font-size: 1rem; }
        .stat-card-compact .stat-label { font-size: 0.65rem; }
        .sub-table th, .sub-table td { padding: 6px 8px; font-size: 0.74rem; }
        .hide-sm { display: none !important; }
    }
</style>
@endsection

@section('content')
<div class="page-content sub-pay-page">
    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h2 class="sub-pay-title">Package Subscription Payments & Revenue</h2>
            <p class="sub-pay-sub">Verify payment submissions and track subscription income.</p>
        </div>
        <div class="d-flex flex-wrap gap-1.5">
            <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill font-monospace" style="font-size:0.75rem;">
                {{ $pendingCount }} Pending (৳{{ number_format($pendingRevenue, 0) }})
            </span>
            <span class="badge bg-success px-2.5 py-1.5 rounded-pill font-monospace" style="font-size:0.75rem;">
                Total: ৳{{ number_format($totalRevenue, 0) }}
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-2 mb-3">
        <div class="col-sm-4 col-6">
            <div class="stat-card-compact" style="background:#f0fdf4; border-left:3px solid #16a34a !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Verified Revenue</div>
                        <div class="stat-val text-success">৳ {{ number_format($totalRevenue, 2) }}</div>
                        <div class="stat-sub">{{ $approvedCount }} paid</div>
                    </div>
                    <div class="stat-icon-wrap" style="background:#dcfce7;color:#16a34a;">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-6">
            <div class="stat-card-compact" style="background:#fffbeb; border-left:3px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Pending Verification</div>
                        <div class="stat-val text-warning">৳ {{ number_format($pendingRevenue, 2) }}</div>
                        <div class="stat-sub">{{ $pendingCount }} waiting</div>
                    </div>
                    <div class="stat-icon-wrap" style="background:#fef3c7;color:#d97706;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="stat-card-compact" style="background:#f8fafc; border-left:3px solid #64748b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Rejected Payments</div>
                        <div class="stat-val text-secondary">{{ $rejectedCount }}</div>
                        <div class="stat-sub">Failed / unverified</div>
                    </div>
                    <div class="stat-icon-wrap" style="background:#e2e8f0;color:#475569;">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="sub-nav-pills">
        <a class="sub-nav-link {{ $tab === 'pending' ? 'bg-primary text-white shadow-sm' : 'bg-light text-dark border' }}" 
           href="{{ route('super.subscription-payments.index', ['tab' => 'pending']) }}">
           <i class="fa-solid fa-clock"></i> Pending ({{ $pendingCount }})
        </a>
        <a class="sub-nav-link {{ $tab === 'approved' ? 'bg-success text-white shadow-sm' : 'bg-light text-dark border' }}" 
           href="{{ route('super.subscription-payments.index', ['tab' => 'approved']) }}">
           <i class="fa-solid fa-check-circle"></i> Verified ({{ $approvedCount }})
        </a>
        <a class="sub-nav-link {{ $tab === 'rejected' ? 'bg-danger text-white shadow-sm' : 'bg-light text-dark border' }}" 
           href="{{ route('super.subscription-payments.index', ['tab' => 'rejected']) }}">
           <i class="fa-solid fa-xmark-circle"></i> Rejected ({{ $rejectedCount }})
        </a>
        <a class="sub-nav-link {{ $tab === 'all' ? 'bg-dark text-white shadow-sm' : 'bg-light text-dark border' }}" 
           href="{{ route('super.subscription-payments.index', ['tab' => 'all']) }}">
           <i class="fa-solid fa-list"></i> All Records
        </a>
    </div>

    {{-- Table Panel --}}
    <div class="edu-panel p-0 overflow-hidden shadow-sm border-0" style="border-radius:14px;">
        <div class="table-responsive">
            <table class="table sub-table">
                <thead>
                    <tr>
                        <th style="width:35px;">#</th>
                        <th>School</th>
                        <th>Package</th>
                        <th>Method</th>
                        <th>Sender Number</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="hide-sm">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $key => $subscription)
                        <tr>
                            <td class="text-muted" style="font-size:0.72rem;">{{ $subscriptions->firstItem() + $key }}</td>
                            <td>
                                <div class="school-name-text text-truncate" style="max-width:160px;">{{ $subscription->school->name ?? '—' }}</div>
                                <div class="school-slug-text">{{ $subscription->school->slug ?? '' }}</div>
                            </td>
                            <td>
                                <span class="pkg-badge">
                                    {{ $subscription->package->name ?? 'Package' }} ({{ substr(ucfirst($subscription->package->duration ?? 'yr'), 0, 2) }})
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ strtolower($subscription->payment_method) === 'bkash' ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-2 py-0.5" style="font-size:0.65rem;">
                                    {{ strtoupper($subscription->payment_method ?? 'bKash') }}
                                </span>
                            </td>
                            <td><code style="font-size:0.72rem;">{{ $subscription->sender_number }}</code></td>
                            <td><span class="trx-code">{{ $subscription->payment_reference }}</span></td>
                            <td><span class="amount-text">৳{{ number_format($subscription->amount, 2) }}</span></td>
                            <td>
                                @if($subscription->status === 'active')
                                    <span class="badge bg-success rounded-pill px-2 py-0.5" style="font-size:0.65rem;">Active</span>
                                @elseif($subscription->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5" style="font-size:0.65rem;">Pending</span>
                                @elseif($subscription->status === 'cancelled')
                                    <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size:0.65rem;">Rejected</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2 py-0.5" style="font-size:0.65rem;">{{ ucfirst($subscription->status) }}</span>
                                @endif
                            </td>
                            <td class="hide-sm">
                                <small class="text-muted" style="font-size:0.7rem;">
                                    {{ ($subscription->paid_at ?? $subscription->payment_submitted_at ?? $subscription->created_at)->format('d M, h:i A') }}
                                </small>
                            </td>
                            <td class="text-center">
                                @if($subscription->status === 'pending')
                                    <div class="d-flex justify-content-center gap-1">
                                        <form action="{{ route('super.subscription-payments.approve', $subscription) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-action-xs" type="submit" title="Verify & Activate">
                                                <i class="fa-solid fa-check me-0.5"></i> Activate
                                            </button>
                                        </form>
                                        <form action="{{ route('super.subscription-payments.reject', $subscription) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" value="Payment details could not be verified.">
                                            <button class="btn btn-outline-danger btn-action-xs" type="submit" title="Reject">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size:0.7rem;">
                                        @if($subscription->status === 'active')
                                            <i class="fa-solid fa-check-double text-success"></i> Done
                                        @elseif($subscription->status === 'cancelled')
                                            <i class="fa-solid fa-ban text-danger"></i> Rejected
                                        @else
                                            —
                                        @endif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center py-4 text-muted" style="font-size:0.78rem;">No payment records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscriptions->hasPages())
            <div class="p-2.5 border-top d-flex justify-content-center" style="font-size:0.75rem;">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
