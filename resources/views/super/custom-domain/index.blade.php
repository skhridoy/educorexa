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
                        <th style="width: 22%;">School Info</th>
                        <th style="width: 22%;">Custom Domain</th>
                        <th style="width: 20%;">Package & Server Fee</th>
                        <th style="width: 18%;">Status & Validity</th>
                        <th style="width: 18%; text-align: right;">Actions</th>
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

                        {{-- Package & Server Fee / Payment --}}
                        <td>
                            <div class="mb-1">
                                <span class="badge bg-light text-dark border fw-semibold" style="font-size:11px;">
                                    <i class="fa-solid fa-box me-1 text-primary"></i>
                                    {{ $school->subscriptionPackage?->name ?? 'Free Package' }}
                                </span>
                            </div>

                            @if($school->custom_domain_payment_method === 'package_included')
                                <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size:11px;">
                                    <i class="fa-solid fa-gift me-1"></i> Package Included (Free)
                                </span>
                            @elseif($school->custom_domain_payment_amount !== null || $school->custom_domain_payment_trx_id)
                                <div class="d-flex align-items-center gap-1">
                                    <span class="fw-bold text-dark" style="font-size:12.5px;">
                                        ৳ {{ number_format($school->custom_domain_payment_amount ?? 1500, 2) }}
                                    </span>
                                    @if($school->custom_domain_payment_status === 'paid')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">Paid</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">Pending</span>
                                    @endif
                                </div>
                                <div class="small text-muted mt-0.5">
                                    <span class="badge bg-secondary-subtle text-dark" style="font-size:10px;">
                                        {{ strtoupper($school->custom_domain_payment_method ?? 'bKash') }}
                                    </span>
                                    {{ $school->custom_domain_payment_sender }}
                                </div>
                                <div class="small text-primary font-monospace mt-0.5" style="font-size:11px;">
                                    Trx: <strong>{{ $school->custom_domain_payment_trx_id }}</strong>
                                </div>
                            @else
                                <span class="badge bg-secondary-subtle text-muted" style="font-size:11px;">No Payment Data</span>
                            @endif
                        </td>

                        {{-- Status & Validity --}}
                        <td>
                            <div class="mb-1">
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
                            </div>

                            {{-- Validity Date --}}
                            @if($school->custom_domain_status === 'verified')
                                @if($school->custom_domain_expires_at)
                                    @php $isExpired = $school->isCustomDomainExpired(); @endphp
                                    <div class="small fw-semibold {{ $isExpired ? 'text-danger' : ($school->isCustomDomainExpiringSoon() ? 'text-warning' : 'text-success') }}">
                                        <i class="fa-solid fa-calendar-days me-1"></i>
                                        Exp: {{ $school->custom_domain_expires_at->format('d M, Y') }}
                                    </div>
                                    <div class="small text-muted" style="font-size:11px;">
                                        {{ $isExpired ? 'Expired' : $school->customDomainDaysRemaining() . ' days left' }}
                                    </div>
                                @endif
                                <div class="mt-1">
                                    @if($school->custom_domain_ssl_status === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">
                                            <i class="fa-solid fa-lock me-1"></i> SSL Active
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">
                                            <i class="fa-solid fa-shield me-1"></i> SSL Pending
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td style="text-align: right;">
                            <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                {{-- Live DNS Check Button --}}
                                <button type="button" class="btn btn-sm btn-outline-info px-2 py-1" onclick="checkSuperDns('{{ route('super.custom-domain.check-dns', $school->id) }}', '{{ $school->custom_domain }}', '{{ addslashes($school->name) }}')" title="Live DNS Check">
                                    <i class="fa-solid fa-satellite-dish me-1"></i> Check DNS
                                </button>

                                @if($school->custom_domain_status === 'pending')
                                    {{-- Approve Form --}}
                                    <form action="{{ route('super.custom-domain.approve', $school->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই কাস্টম ডোমেইনটি Approve করতে চান? (এটি ১ বছরের জন্য সক্রিয় হবে)');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="Approve Domain (1 Year)">
                                            <i class="fa-solid fa-check me-1"></i> Approve
                                        </button>
                                    </form>

                                    {{-- Reject Modal Trigger --}}
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $school->id }}" title="Reject Request">
                                        <i class="fa-solid fa-xmark me-1"></i> Reject
                                    </button>
                                @endif

                                @if($school->custom_domain_status === 'verified')
                                    {{-- Extend 1 Year Form --}}
                                    <form action="{{ route('super.custom-domain.extend', $school->id) }}" method="POST" onsubmit="return confirm('ডোমেইনের মেয়াদ আরও ১ বছর বৃদ্ধি করতে চান?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success px-2 py-1" title="Extend 1 Year Validity">
                                            <i class="fa-solid fa-calendar-plus me-1"></i> +1 Year
                                        </button>
                                    </form>

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
    {{-- Super Admin Live DNS Check Modal --}}
    <div class="modal fade" id="superDnsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:18px; overflow:hidden;">
                <div class="modal-header border-0 py-3 px-4" style="background: linear-gradient(135deg, #1e293b, #0f172a); color:#fff;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:34px;height:34px;border-radius:10px;background:rgba(99,102,241,0.25);display:flex;align-items:center;justify-content:center;color:#818cf8;">
                            <i class="fa-solid fa-satellite-dish"></i>
                        </div>
                        <div>
                            <h6 class="modal-title fw-bold mb-0 text-white" style="font-size:15px;">Live DNS Verification</h6>
                            <small class="text-white-50" id="superDnsSchoolName">School Name</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="superDnsLoading" class="text-center py-4">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <div class="fw-semibold text-dark">Checking DNS Records...</div>
                        <small class="text-muted">Resolving A and CNAME records from global DNS</small>
                    </div>

                    <div id="superDnsResult" style="display:none;">
                        {{-- Status Banner --}}
                        <div id="superDnsStatusAlert" class="alert d-flex align-items-center gap-3 mb-4 rounded-3 border-0 py-3">
                            <div id="superDnsStatusIcon" style="font-size:22px;"></div>
                            <div>
                                <div id="superDnsStatusTitle" class="fw-bold"></div>
                                <small id="superDnsStatusMsg" class="opacity-75"></small>
                            </div>
                        </div>

                        {{-- Details Table --}}
                        <div class="bg-light p-3 rounded-3 mb-3 border">
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted small">Domain:</span>
                                <code id="superDnsDomain" class="fw-bold text-dark"></code>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted small">Target Server IP:</span>
                                <code id="superDnsTargetIp" class="text-primary fw-bold"></code>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted small">Detected IP(s):</span>
                                <span id="superDnsResolvedIps" class="small fw-semibold"></span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted small">CNAME Target(s):</span>
                                <span id="superDnsCnameTargets" class="small fw-semibold"></span>
                            </div>
                        </div>

                        <div class="small text-muted">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                            DNS changes can take anywhere from a few minutes up to 24-48 hours to propagate worldwide.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="superDnsRetryBtn">
                        <i class="fa-solid fa-rotate-right me-1"></i> Check Again
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    let currentCheckDnsUrl = '';
    let currentCheckDomain = '';
    let currentCheckSchool = '';

    function checkSuperDns(url, domain, schoolName) {
        currentCheckDnsUrl = url;
        currentCheckDomain = domain;
        currentCheckSchool = schoolName;

        const modalEl = document.getElementById('superDnsModal');
        const modal = new bootstrap.Modal(modalEl);
        document.getElementById('superDnsSchoolName').textContent = schoolName;

        document.getElementById('superDnsLoading').style.display = 'block';
        document.getElementById('superDnsResult').style.display = 'none';

        modal.show();
        performDnsCheck();
    }

    function performDnsCheck() {
        document.getElementById('superDnsLoading').style.display = 'block';
        document.getElementById('superDnsResult').style.display = 'none';

        fetch(currentCheckDnsUrl)
            .then(res => res.json())
            .then(data => {
                document.getElementById('superDnsLoading').style.display = 'none';
                document.getElementById('superDnsResult').style.display = 'block';

                document.getElementById('superDnsDomain').textContent = data.domain || currentCheckDomain;
                document.getElementById('superDnsTargetIp').textContent = data.server_ip || 'N/A';

                const ipsEl = document.getElementById('superDnsResolvedIps');
                if (data.resolved_ips && data.resolved_ips.length > 0) {
                    ipsEl.innerHTML = data.resolved_ips.map(ip => `<code>${ip}</code>`).join(', ');
                } else {
                    ipsEl.innerHTML = '<span class="text-danger">None detected</span>';
                }

                const cnameEl = document.getElementById('superDnsCnameTargets');
                if (data.cname_targets && data.cname_targets.length > 0) {
                    cnameEl.innerHTML = data.cname_targets.map(c => `<code>${c}</code>`).join(', ');
                } else {
                    cnameEl.innerHTML = '<span class="text-muted">None</span>';
                }

                const alertBox = document.getElementById('superDnsStatusAlert');
                const alertIcon = document.getElementById('superDnsStatusIcon');
                const alertTitle = document.getElementById('superDnsStatusTitle');
                const alertMsg = document.getElementById('superDnsStatusMsg');

                if (data.is_configured) {
                    alertBox.className = 'alert alert-success d-flex align-items-center gap-3 mb-4 rounded-3 border-0 py-3';
                    alertIcon.innerHTML = '<i class="fa-solid fa-circle-check text-success"></i>';
                    alertTitle.textContent = 'DNS Pointed Successfully!';
                    alertMsg.textContent = data.message || 'Domain is actively resolving to this server.';
                } else {
                    alertBox.className = 'alert alert-warning d-flex align-items-center gap-3 mb-4 rounded-3 border-0 py-3';
                    alertIcon.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-warning"></i>';
                    alertTitle.textContent = 'DNS Not Pointed Yet';
                    alertMsg.textContent = data.message || 'Domain records do not match the expected server IP.';
                }
            })
            .catch(err => {
                document.getElementById('superDnsLoading').style.display = 'none';
                document.getElementById('superDnsResult').style.display = 'block';

                const alertBox = document.getElementById('superDnsStatusAlert');
                alertBox.className = 'alert alert-danger d-flex align-items-center gap-3 mb-4 rounded-3 border-0 py-3';
                document.getElementById('superDnsStatusIcon').innerHTML = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                document.getElementById('superDnsStatusTitle').textContent = 'Error checking DNS';
                document.getElementById('superDnsStatusMsg').textContent = err.message || 'Failed to query DNS records.';
            });
    }

    document.getElementById('superDnsRetryBtn')?.addEventListener('click', () => {
        performDnsCheck();
    });
</script>
@endsection
