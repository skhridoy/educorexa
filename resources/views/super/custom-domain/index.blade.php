@extends('layouts.main')
@section('title', 'Custom Domain Management')

@section('customCSS')
    @include('layouts._shared_styles')
    <style>
        .cd-stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: all 0.2s ease;
        }
        .cd-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }
        .cd-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .cd-stat-val {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.2;
            color: #1e293b;
        }
        .cd-stat-lbl {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
            font-weight: 500;
        }

        .domain-badge-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .domain-badge-verified {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .domain-badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .domain-badge-disabled {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .table-domain-link {
            font-family: monospace;
            font-size: 13.5px;
            font-weight: 600;
            color: #4f46e5;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .table-domain-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.schools.all') }}">Manage Schools</a></li>
        <li><span>/</span></li>
        <li class="active">Custom Domains</li>
    </ul>

    {{-- Page Header --}}
    <div class="sch-page-hd d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-globe me-2" style="color:#4f46e5;"></i> Custom Domain Requests</h2>
            <p class="edu-page-sub">Review, approve, and manage white-label custom domains configured by schools.</p>
        </div>
        <div>
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                <i class="fa-solid fa-server me-1"></i> DNS Target: {{ request()->getHost() }}
            </span>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="cd-stat-card">
                <div class="cd-stat-icon" style="background:#fffbeb; color:#d97706;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div class="cd-stat-val">{{ number_format($stats['pending']) }}</div>
                    <div class="cd-stat-lbl">Pending Review</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="cd-stat-card">
                <div class="cd-stat-icon" style="background:#ecfdf5; color:#059669;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <div class="cd-stat-val">{{ number_format($stats['verified']) }}</div>
                    <div class="cd-stat-lbl">Active & Verified</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="cd-stat-card">
                <div class="cd-stat-icon" style="background:#fef2f2; color:#dc2626;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div>
                    <div class="cd-stat-val">{{ number_format($stats['rejected']) }}</div>
                    <div class="cd-stat-lbl">Rejected Requests</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="edu-panel mb-4">
        <div class="p-3">
            <form method="GET" action="{{ route('super.custom-domain.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search school name or domain..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending Review</option>
                        <option value="verified" @selected(request('status') === 'verified')>Active / Verified</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        <option value="disabled" @selected(request('status') === 'disabled')>Disabled</option>
                    </select>
                </div>
                <div class="col-6 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-3">Filter</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('super.custom-domain.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Main Table Panel --}}
    <div class="edu-panel">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%;">School Info</th>
                        <th style="width: 25%;">Custom Domain</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">SSL / Verification</th>
                        <th style="width: 20%; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        {{-- School Info --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($school->logo)
                                    <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold bg-primary text-white" style="width:40px;height:40px;font-size:14px;">
                                        {{ strtoupper(substr($school->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $school->name }}</div>
                                    <div class="text-muted small">
                                        <code>{{ $school->slug }}.{{ config('app.main_domain') }}</code>
                                    </div>
                                    @if($school->admin)
                                        <div class="text-muted" style="font-size: 11.5px;">
                                            <i class="fa-regular fa-envelope me-1"></i>{{ $school->admin->email }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Custom Domain --}}
                        <td>
                            <a href="http://{{ $school->custom_domain }}" target="_blank" rel="noopener noreferrer" class="table-domain-link">
                                {{ $school->custom_domain }}
                                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i>
                            </a>
                            <div class="text-muted small mt-1">
                                <i class="fa-regular fa-clock me-1"></i>Updated: {{ $school->updated_at->diffForHumans() }}
                            </div>
                            @if($school->custom_domain_reject_reason)
                                <div class="mt-1 text-danger small p-2 rounded bg-danger-subtle">
                                    <strong>Reject Reason:</strong> {{ $school->custom_domain_reject_reason }}
                                </div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($school->custom_domain_status === 'verified')
                                <span class="badge domain-badge-verified px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Verified
                                </span>
                            @elseif($school->custom_domain_status === 'pending')
                                <span class="badge domain-badge-pending px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="fa-solid fa-clock"></i> Pending Review
                                </span>
                            @elseif($school->custom_domain_status === 'rejected')
                                <span class="badge domain-badge-rejected px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="fa-solid fa-circle-xmark"></i> Rejected
                                </span>
                            @elseif($school->custom_domain_status === 'disabled')
                                <span class="badge domain-badge-disabled px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="fa-solid fa-ban"></i> Disabled
                                </span>
                            @else
                                <span class="badge bg-light text-muted px-2.5 py-1.5 rounded-pill">None</span>
                            @endif
                        </td>

                        {{-- SSL / Verification --}}
                        <td>
                            @if($school->custom_domain_verified_at)
                                <div class="small text-success fw-semibold">
                                    <i class="fa-solid fa-calendar-check me-1"></i> {{ $school->custom_domain_verified_at->format('d M, Y') }}
                                </div>
                            @else
                                <div class="small text-muted">Not verified yet</div>
                            @endif

                            <div class="mt-1">
                                @if($school->custom_domain_ssl_status === 'active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">
                                        <i class="fa-solid fa-lock me-1"></i> SSL Active
                                    </span>
                                @elseif($school->custom_domain_ssl_status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">
                                        <i class="fa-solid fa-shield me-1"></i> SSL Pending
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td style="text-align: right;">
                            <div class="d-inline-flex gap-1">
                                @if($school->custom_domain_status === 'pending')
                                    {{-- Approve Form --}}
                                    <form action="{{ route('super.custom-domain.approve', $school->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই কাস্টম ডোমেইনটি Approve করতে চান?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="Approve Domain">
                                            <i class="fa-solid fa-check me-1"></i> Approve
                                        </button>
                                    </form>

                                    {{-- Reject Modal Trigger --}}
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $school->id }}" title="Reject Request">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                @endif

                                @if($school->custom_domain_status === 'verified')
                                    {{-- Disable Form --}}
                                    <form action="{{ route('super.custom-domain.disable', $school->id) }}" method="POST" onsubmit="return confirm('এই ডোমেইনটি কি সাময়িকভাবে Disable করতে চান?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning px-2 py-1" title="Disable Domain">
                                            <i class="fa-solid fa-ban me-1"></i> Disable
                                        </button>
                                    </form>
                                @endif

                                @if($school->custom_domain_status === 'disabled')
                                    {{-- Re-approve --}}
                                    <form action="{{ route('super.custom-domain.approve', $school->id) }}" method="POST" onsubmit="return confirm('এই ডোমেইনটি পুনরায় সক্রিয় করতে চান?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="Reactivate Domain">
                                            <i class="fa-solid fa-rotate-right me-1"></i> Enable
                                        </button>
                                    </form>
                                @endif

                                {{-- Reset / Force Remove Form --}}
                                <form action="{{ route('super.custom-domain.reset', $school->id) }}" method="POST" onsubmit="return confirm('সতর্কতা: এই ডোমেইনটি স্কুল থেকে সম্পূর্ণ অপসারণ করা হবে। আপনি কি নিশ্চিত?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Reset / Delete Domain">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Reject Modal --}}
                            @if($school->custom_domain_status === 'pending')
                            <div class="modal fade" id="rejectModal{{ $school->id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('super.custom-domain.reject', $school->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title text-danger">
                                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Reject Domain Request
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted small mb-3">
                                                    School: <strong>{{ $school->name }}</strong><br>
                                                    Requested Domain: <code>{{ $school->custom_domain }}</code>
                                                </p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Reject Reason <span class="text-danger">*</span></label>
                                                    <textarea name="reject_reason" class="form-control" rows="3" required placeholder="দয়া করে রিজেক্ট করার কারণ ব্যাখ্যা করুন (স্কুল এডমিন এই কারণটি দেখতে পারবেন)..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-globe fa-3x mb-3 text-secondary opacity-50"></i>
                            <div class="fw-semibold">কোনো কাস্টম ডোমেইন রিকোয়েস্ট পাওয়া যায়নি</div>
                            <div class="small">স্কুলগুলো ডোমেইন রিকোয়েস্ট পাঠালে এখানে প্রদর্শিত হবে।</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schools->hasPages())
            <div class="p-3 border-top">
                {{ $schools->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
