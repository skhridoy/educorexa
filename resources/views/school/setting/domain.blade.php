@extends('layouts.school')

@section('title', __('Custom Domain Setup'))

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .domain-page-wrap { max-width: 960px; margin: 0 auto; }

        /* ── Hero Header ── */
        .domain-header-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 20px;
            padding: 24px 28px;
            color: #fff;
            box-shadow: 0 10px 30px rgba(15,23,42,0.13);
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .domain-header-card::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .domain-header-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        }

        /* ── Status Banner ── */
        .domain-status-card {
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            border: none;
        }
        .domain-status-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        /* ── Pricing Box ── */
        .pricing-banner-card {
            background: linear-gradient(135deg, #f8fafc, #eff6ff);
            border: 1.5px solid #bfdbfe;
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .payment-method-box {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .payment-method-box:hover {
            border-color: #6366f1;
            background: #f8fafc;
        }

        /* ── Steps Card ── */
        .steps-wrap { counter-reset: step; }
        .step-item {
            display: flex; gap: 16px;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .step-item:last-child { border-bottom: none; }
        .step-num {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800;
            flex-shrink: 0;
        }
        .step-content h6 { font-size: 13.5px; font-weight: 700; margin-bottom: 4px; color: #1e293b; }
        .step-content p { font-size: 12px; color: #64748b; margin: 0; line-height: 1.5; }
        .step-content code {
            background: #f1f5f9;
            color: #4f46e5;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 11.5px;
        }

        /* ── Form Card ── */
        .domain-form-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .domain-form-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            background: #f8fafc;
        }
        .domain-input-wrap {
            display: flex;
            align-items: stretch;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.2s;
        }
        .domain-input-wrap:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .domain-input-prefix {
            background: #eef2ff;
            color: #6366f1;
            padding: 0 14px;
            font-size: 12px;
            font-weight: 700;
            display: flex; align-items: center;
            border-right: 1.5px solid #e0e7ff;
            white-space: nowrap;
        }
        .domain-input-wrap input {
            border: none;
            background: transparent;
            padding: 12px 14px;
            flex: 1;
            font-size: 14px;
            color: #1e293b;
        }
        .domain-input-wrap input:focus { outline: none; }

        /* ── DNS Table ── */
        .dns-table-wrap {
            background: #0f172a;
            border-radius: 12px;
            overflow: hidden;
        }
        .dns-table-wrap table th {
            background: #1e293b;
            color: #94a3b8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 16px;
            border: none;
        }
        .dns-table-wrap table td {
            color: #e2e8f0;
            font-size: 12.5px;
            padding: 10px 16px;
            border-color: #1e293b;
            font-family: 'Courier New', monospace;
        }
        .dns-copy-btn {
            background: #1e293b;
            border: 1px solid #334155;
            color: #94a3b8;
            border-radius: 6px;
            padding: 3px 8px;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .dns-copy-btn:hover { background: #334155; color: #e2e8f0; }
    </style>
@endsection

@section('content')
<div class="domain-page-wrap px-2 px-md-0">

    {{-- Header --}}
    <div class="domain-header-card mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="domain-header-icon">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div>
                <h1 style="font-size:18px; font-weight:800; margin:0; color:#fff;">{{ __('Custom Domain Setup') }}</h1>
                <p style="font-size:12.5px; color:#94a3b8; margin:3px 0 0;">
                    {{ __('আপনার নিজস্ব ডোমেইন দিয়ে স্কুল পোর্টাল ও ওয়েবসাইট ব্র্যান্ডিং পরিচালনা করুন') }}
                </p>
            </div>
            <div class="ms-auto text-end">
                @if($school->custom_domain_status === 'verified')
                    <span class="badge" style="background:#10b981; font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-circle-check me-1"></i> Active
                    </span>
                @elseif($school->custom_domain_status === 'pending')
                    <span class="badge bg-warning text-dark" style="font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-clock me-1"></i> Reviewing Payment
                    </span>
                @elseif($school->custom_domain_status === 'rejected')
                    <span class="badge bg-danger" style="font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-times-circle me-1"></i> Rejected
                    </span>
                @elseif($school->custom_domain_status === 'disabled')
                    <span class="badge" style="background:#f59e0b; font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-ban me-1"></i> Disabled
                    </span>
                @else
                    <span class="badge" style="background:rgba(255,255,255,0.15); font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-circle me-1 text-muted"></i> Not Configured
                    </span>
                @endif
                <div class="text-white-50 mt-1" style="font-size:11px;">
                    প্যাকেজ: <strong>{{ $school->subscriptionPackage?->name ?? 'Free Package' }}</strong>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-4 shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Column: Status + Form --}}
        <div class="col-lg-7">

            {{-- ── 0. DISABLED STATE ── --}}
            @if($school->custom_domain_status === 'disabled')
                @php
                    $subdomainFallback = (request()->isSecure() ? 'https://' : 'http://') . $school->slug . '.' . config('app.main_domain');
                @endphp
                <div class="domain-status-card d-flex align-items-start gap-3 mb-4" style="background:linear-gradient(135deg,#fff7ed,#fffbeb); border:1.5px solid #fed7aa;">
                    <div class="domain-status-icon" style="background:#f97316; color:#fff;">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-wrap gap-2">
                            <h6 class="fw-bold mb-0" style="color:#9a3412; font-size:15px;">কাস্টম ডোমেইন সাময়িকভাবে Disabled</h6>
                            <span class="badge" style="background:#f97316; font-size:11px;"><i class="fa-solid fa-ban me-1"></i> Disabled</span>
                        </div>
                        <p class="mb-2" style="color:#7c2d12; font-size:13px;">
                            আপনার কাস্টম ডোমেইন <strong>{{ $school->custom_domain }}</strong> সুপার এডমিন কর্তৃক সাময়িকভাবে বন্ধ করা হয়েছে।
                            আপনার স্কুল পোর্টাল এখনও সাবডোমেইন থেকে সচল আছে।
                        </p>

                        {{-- Fallback Subdomain --}}
                        <div class="p-3 rounded-3 mb-3" style="background:#fff; border:1px solid #fed7aa;">
                            <div class="small text-muted mb-1"><i class="fa-solid fa-arrow-right me-1"></i> এই লিংকে স্কুল পোর্টাল অ্যাক্সেস করুন:</div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <code style="font-size:13px; color:#ea580c;">{{ $school->slug }}.{{ config('app.main_domain') }}</code>
                                <a href="{{ $subdomainFallback }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-3" style="font-size:11px;">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> ভিজিট করুন
                                </a>
                            </div>
                        </div>

                        {{-- Expiry if available --}}
                        @if($school->custom_domain_expires_at)
                            <div class="small" style="color:#9a3412;">
                                <i class="fa-regular fa-calendar me-1"></i>
                                ডোমেইন মেয়াদ: <strong>{{ $school->custom_domain_expires_at->format('d M, Y') }}</strong>
                                @if($school->custom_domain_expires_at->isFuture())
                                    <span class="badge bg-success-subtle text-success ms-1" style="font-size:10px;">মেয়াদ আছে</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger ms-1" style="font-size:10px;">মেয়াদ শেষ</span>
                                @endif
                            </div>
                        @endif

                        <div class="mt-3 p-2 rounded-3" style="background:#fff3e0; border:1px dashed #fb923c; font-size:12px; color:#7c2d12;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            কাস্টম ডোমেইন পুনরায় সক্রিয় করতে <strong>Super Admin</strong>-এর সাথে যোগাযোগ করুন অথবা সাপোর্ট টিকেট তৈরি করুন।
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── 1. ACTIVE / VERIFIED STATE ── --}}
            @if($school->custom_domain_status === 'verified')
                <div class="domain-status-card d-flex align-items-start gap-3" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4); border:1px solid #86efac;">
                    <div class="domain-status-icon" style="background:#10b981; color:#fff;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="fw-bold mb-0" style="color:#14532d; font-size:15px;">কাস্টম ডোমেইন সক্রিয় আছে!</h6>
                            <span class="badge bg-success" style="font-size:11px;">
                                <i class="fa-solid fa-shield-halved me-1"></i> HTTPS Active
                            </span>
                        </div>
                        <p class="mb-2" style="color:#166534; font-size:13px;">
                            আপনার স্কুল পোর্টাল এখন <strong>{{ $school->custom_domain }}</strong> থেকে সরাসরি লাইভ চলছে।
                        </p>
                        <div class="d-flex gap-2 flex-wrap mb-3">
                            <a href="https://{{ $school->custom_domain }}" target="_blank" class="btn btn-sm btn-success px-3 py-1.5 rounded-3 fw-semibold" style="font-size:12px;">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> ভিজিট করুন
                            </a>
                        </div>

                        {{-- Validity & Expiry Tracker --}}
                        <div class="p-3 rounded-3" style="background:#ffffff; border:1px solid #bbf7d0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div style="font-size:12px; color:#14532d;">
                                    <i class="fa-solid fa-calendar-check me-1 text-success"></i> 
                                    মেয়াদ শেষ হবে: 
                                    <strong>{{ $school->custom_domain_expires_at ? $school->custom_domain_expires_at->format('d M, Y') : '১ বছর পর' }}</strong>
                                </div>
                                @if($school->custom_domain_expires_at)
                                    @php $remDays = $school->customDomainDaysRemaining(); @endphp
                                    <span class="badge {{ $remDays <= 15 ? 'bg-danger' : ($remDays <= 30 ? 'bg-warning text-dark' : 'bg-success-subtle text-success') }}" style="font-size:11px;">
                                        {{ $remDays > 0 ? $remDays . ' দিন বাকি' : 'মেয়াদ শেষ' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Expiry Alert if soon --}}
                @if($school->isCustomDomainExpiringSoon())
                    <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                            <div>
                                <div class="fw-bold">বাৎসরিক সার্ভার চার্জ রিনিউয়াল সময় হয়েছে!</div>
                                <div class="small">আপনার কাস্টম ডোমেইনের মেয়াদ আর {{ $school->customDomainDaysRemaining() }} দিন বাকি আছে। নিরবচ্ছিন্ন সার্ভিসের জন্য বাৎসরিক ফি প্রদান করে রিনিউ করুন।</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Information Card --}}
                <div class="card border-0 rounded-4 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold text-dark" style="font-size:13px;">ডোমেইন পরিবর্তন বা সমস্যা?</div>
                                <div class="text-muted" style="font-size:12px;">ডোমেইন সরাতে বা পরিবর্তন করতে Super Admin সাপোর্টে যোগাযোগ করুন।</div>
                            </div>
                            <span class="badge bg-light text-muted border">Managed</span>
                        </div>
                    </div>
                </div>

            {{-- ── 2. PENDING REVIEW STATE ── --}}
            @elseif($school->custom_domain_status === 'pending')
                <div class="domain-status-card" style="background:linear-gradient(135deg,#fefce8,#fffbeb); border:1px solid #fde047;">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="domain-status-icon" style="background:#f59e0b; color:#fff;">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1" style="color:#78350f; font-size:15px;">রিকোয়েস্ট ও পেমেন্ট রিভিউ চলছে</h6>
                            <p class="mb-0" style="color:#92400e; font-size:12.5px;">
                                আপনার ডোমেইন <strong>{{ $school->custom_domain }}</strong> এবং পেমেন্ট তথ্য Super Admin-এর কাছে সফলভাবে জমা হয়েছে। পেমেন্ট যাচাই শেষে ডোমেইন সক্রিয় করা হবে।
                            </p>
                        </div>
                    </div>

                    {{-- Submitted Payment Details Box --}}
                    <div class="bg-white rounded-3 p-3 border mb-3">
                        <div class="fw-bold text-dark mb-2" style="font-size:12.5px;">
                            <i class="fa-solid fa-receipt me-1 text-primary"></i> জমা দেওয়া পেমেন্ট তথ্য:
                        </div>
                        <div class="row g-2" style="font-size:12px;">
                            <div class="col-6">
                                <span class="text-muted">পরিশোধিত ফি:</span>
                                <strong>৳ {{ number_format($school->custom_domain_payment_amount ?? $yearlyFee, 2) }}</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">পেমেন্ট মেথড:</span>
                                <strong>{{ strtoupper($school->custom_domain_payment_method ?? 'bKash') }}</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">প্রেরকের নম্বর:</span>
                                <strong>{{ $school->custom_domain_payment_sender ?? 'N/A' }}</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">TrxID:</span>
                                <strong class="text-primary font-monospace">{{ $school->custom_domain_payment_trx_id ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.school.domain.cancel', ['tenant' => request()->route('tenant')]) }}" method="POST"
                          onsubmit="return confirm('আপনি কি নিশ্চিত যে রিকোয়েস্ট বাতিল করতে চান?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                            <i class="fa-solid fa-times me-1"></i> রিকোয়েস্ট বাতিল করুন
                        </button>
                    </form>
                </div>

            {{-- ── 3. REJECTED STATE ── --}}
            @elseif($school->custom_domain_status === 'rejected')
                <div class="domain-status-card mb-4" style="background:linear-gradient(135deg,#fef2f2,#fff5f5); border:1px solid #fca5a5;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="domain-status-icon" style="background:#ef4444; color:#fff;">
                            <i class="fa-solid fa-times-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1" style="color:#b91c1c; font-size:14px;">রিকোয়েস্ট Reject হয়েছে</h6>
                            <p class="mb-1" style="color:#991b1b; font-size:13px;">
                                ডোমেইন: <strong>{{ $school->custom_domain }}</strong>
                            </p>
                            @if($school->custom_domain_reject_reason)
                                <div class="small p-2.5 rounded-3 mt-2" style="background:#fee2e2; color:#7f1d1d;">
                                    <strong>Reject এর কারণ:</strong> {{ $school->custom_domain_reject_reason }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── 4. REQUEST / SETUP FORM (When none or rejected) ── --}}
            @if(in_array($school->custom_domain_status, ['none', 'rejected']))
                <div class="domain-form-card shadow-sm">
                    <div class="domain-form-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold" style="font-size:14px;">
                            <i class="fa-solid fa-globe me-2" style="color:#6366f1;"></i>
                            কাস্টম ডোমেইন যুক্ত করুন
                        </h6>
                        @if($isFeeIncluded)
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:11px;">
                                <i class="fa-solid fa-check me-1"></i> Package Included (Free)
                            </span>
                        @else
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size:11px;">
                                বাৎসরিক চার্জ প্রযোজ্য
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        {{-- Fee Notice Banner --}}
                        @if($isFeeIncluded)
                            <div class="p-3 rounded-3 mb-4" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-gift text-success fs-5"></i>
                                    <div>
                                        <div class="fw-bold text-success" style="font-size:13px;">আপনার প্যাকেজে কাস্টম ডোমেইন অন্তর্ভুক্ত আছে!</div>
                                        <div class="small text-muted">আপনার বর্তমান প্যাকেজের জন্য কোনো আলাদা বাৎসরিক সার্ভার ফি দিতে হবে না।</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Server Fee Card --}}
                            <div class="pricing-banner-card mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="fw-bold text-dark" style="font-size:13.5px;">
                                        <i class="fa-solid fa-coins me-1 text-warning"></i> কাস্টম ডোমেইন সার্ভার ফি
                                    </div>
                                    <div class="text-primary fw-bold" style="font-size:16px;">
                                        ৳ {{ number_format($yearlyFee, 0) }} <span class="text-muted fw-normal" style="font-size:12px;">/ বছর</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-2" style="font-size:12px; line-height:1.5;">
                                    ফ্রি ও স্ট্যান্ডার্ড প্যাকেজের জন্য কাস্টম ডোমেইন পয়েন্টিং ও ডেডিকেটেড SSL সার্ভার রক্ষণাবেক্ষণ বাবদ এই বাৎসরিক ফি প্রযোজ্য। মেয়াদ <strong>১ বছর (৩৬৫ দিন)</strong> থাকবে।
                                </p>

                                {{-- Payment Channel Numbers --}}
                                <div class="p-2.5 rounded-3 bg-white border mt-2">
                                    <div class="small fw-semibold text-muted mb-1.5" style="font-size:11.5px;">
                                        <i class="fa-solid fa-money-bill-transfer me-1 text-success"></i> ফি প্রদানের অ্যাকাউন্ট সমূহ (Send Money / Payment):
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap" style="font-size:12px;">
                                        @if(!empty($setting->bkash_personal_number))
                                            <div class="badge bg-light text-dark border p-1.5 px-2.5 rounded d-flex align-items-center gap-1.5">
                                                <span class="fw-bold text-danger">bKash:</span>
                                                <span id="bkashNum">{{ $setting->bkash_personal_number }}</span>
                                                <button type="button" class="btn btn-link p-0 text-muted ms-1" onclick="copyDns('bkashNum')" title="কপি করুন">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if(!empty($setting->nagad_personal_number))
                                            <div class="badge bg-light text-dark border p-1.5 px-2.5 rounded d-flex align-items-center gap-1.5">
                                                <span class="fw-bold text-warning-emphasis" style="color:#d97706;">Nagad:</span>
                                                <span id="nagadNum">{{ $setting->nagad_personal_number }}</span>
                                                <button type="button" class="btn btn-link p-0 text-muted ms-1" onclick="copyDns('nagadNum')" title="কপি করুন">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    @if(!empty($setting->manual_payment_instructions))
                                        <div class="small text-muted mt-2 pt-1 border-top" style="font-size:11px;">
                                            {!! nl2br(e($setting->manual_payment_instructions)) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Request Form --}}
                        <form action="{{ route('admin.school.domain.request', ['tenant' => request()->route('tenant')]) }}" method="POST">
                            @csrf

                            {{-- Domain Name Input --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark" style="font-size:13px;">
                                    আপনার কাস্টম ডোমেইন <span class="text-danger">*</span>
                                </label>
                                <div class="domain-input-wrap">
                                    <div class="domain-input-prefix">
                                        <i class="fa-solid fa-lock me-1" style="font-size:10px;"></i> https://
                                    </div>
                                    <input type="text" name="custom_domain" id="customDomainInput"
                                           value="{{ old('custom_domain', $school->custom_domain_status === 'rejected' ? $school->custom_domain : '') }}"
                                           placeholder="school.yourdomain.com"
                                           autocomplete="off" spellcheck="false" required>
                                </div>
                                @error('custom_domain')
                                    <div class="text-danger mt-1" style="font-size:12px;"><i class="fa-solid fa-circle-xmark me-1"></i>{{ $message }}</div>
                                @enderror
                                <p class="text-muted mt-1.5 mb-0" style="font-size:11.5px;">
                                    উদাহরণ: <code>school.example.com</code> বা <code>myschool.edu.bd</code> (www বা http ছাড়া লিখুন)
                                </p>
                            </div>

                            {{-- Payment Inputs (if fee required) --}}
                            @if(!$isFeeIncluded && $yearlyFee > 0)
                                <div class="p-3 rounded-3 mb-3 bg-light border">
                                    <div class="fw-bold text-dark mb-2" style="font-size:13px;">
                                        <i class="fa-solid fa-credit-card me-1 text-primary"></i> ফি পরিশোধের তথ্য দিন
                                    </div>

                                    <div class="row g-3">
                                        {{-- Payment Method --}}
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">পেমেন্ট মেথড <span class="text-danger">*</span></label>
                                            <select name="payment_method" class="form-select form-select-sm @error('payment_method') is-invalid @enderror" required>
                                                <option value="bkash" {{ old('payment_method') === 'bkash' ? 'selected' : '' }}>bKash (বিকাশ)</option>
                                                <option value="nagad" {{ old('payment_method') === 'nagad' ? 'selected' : '' }}>Nagad (নগদ)</option>
                                                <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>Bank Transfer (ব্যাংক)</option>
                                            </select>
                                            @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        {{-- Sender Number --}}
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">প্রেরকের নম্বর / একাউন্ট <span class="text-danger">*</span></label>
                                            <input type="text" name="sender_number" class="form-control form-control-sm @error('sender_number') is-invalid @enderror"
                                                   value="{{ old('sender_number') }}" placeholder="017XXXXXXXX" required>
                                            @error('sender_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        {{-- TrxID --}}
                                        <div class="col-md-4">
                                            <label class="form-label small fw-semibold">TrxID / ট্রানজেকশন আইডি <span class="text-danger">*</span></label>
                                            <input type="text" name="trx_id" class="form-control form-control-sm @error('trx_id') is-invalid @enderror"
                                                   value="{{ old('trx_id') }}" placeholder="যেমন: BL728A190X" required>
                                            @error('trx_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Checklist --}}
                            <div class="p-3 rounded-3 mb-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                                <div class="fw-semibold mb-1" style="font-size:12px; color:#1e293b;">
                                    <i class="fa-solid fa-circle-check me-1 text-success"></i> নিশ্চিতকরণ:
                                </div>
                                <ul class="mb-0 ps-3" style="font-size:11.5px; color:#64748b; line-height:1.7;">
                                    <li>ডোমেইনটি আপনার বা আপনার প্রতিষ্ঠানের নিয়ন্ত্রণে রয়েছে।</li>
                                    <li>DNS Records সেটআপ করার প্রস্তুতি আছে (ডান পাশের টেবিলে দেখুন)।</li>
                                    <li>Super Admin অনুমোদন করলে স্বয়ংক্রিয়ভাবে ১ বছরের জন্য সক্রিয় হবে।</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary fw-bold px-4 py-2 rounded-3 w-100"
                                    style="background: linear-gradient(135deg, #6366f1, #818cf8); border:none; box-shadow:0 4px 14px rgba(99,102,241,0.3);">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                {{ (!$isFeeIncluded && $yearlyFee > 0) ? 'ফি পরিশোধ করেছি ও রিকোয়েস্ট জমা করুন' : 'রিকোয়েস্ট জমা করুন' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column: DNS Setup Guide --}}
        <div class="col-lg-5">
            {{-- DNS Instructions Card --}}
            <div class="card border-0 rounded-4 shadow-sm mb-4">
                <div class="card-header border-0 rounded-top-4 py-3 px-4"
                     style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:30px; height:30px; background:#334155; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-server" style="color:#94a3b8; font-size:12px;"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-white" style="font-size:13px;">DNS রেকর্ড নির্দেশনা</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3" style="font-size:12.5px;">
                        আপনার Domain Registrar (যেমন Namecheap, GoDaddy)-এ গিয়ে নিচের DNS Records যোগ করুন:
                    </p>

                    @php
                        $serverIp = config('app.server_ip') ?: '127.0.0.1';
                        $mainDomain = config('app.main_domain', 'educorexa.com');
                    @endphp

                    <div class="dns-table-wrap mb-3">
                        <table class="table table-sm table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge" style="background:#4f46e5;">A</span></td>
                                    <td>@</td>
                                    <td id="dns-ip">{{ $serverIp }}</td>
                                    <td>
                                        <button class="dns-copy-btn" onclick="copyDns('dns-ip')" title="Copy IP">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">CNAME</span></td>
                                    <td>www</td>
                                    <td id="dns-cname">{{ $mainDomain }}</td>
                                    <td>
                                        <button class="dns-copy-btn" onclick="copyDns('dns-cname')" title="Copy Domain">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Live DNS Checker Box --}}
                    <div class="p-3 rounded-3 mb-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold" style="font-size:12.5px; color:#1e293b;">
                                <i class="fa-solid fa-satellite-dish me-1 text-primary"></i> লাইভ DNS স্ট্যাটাস
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-primary py-1 px-3 rounded-pill fw-semibold" id="btnCheckSchoolDns" style="font-size:11.5px;">
                                <i class="fa-solid fa-rotate me-1" id="dnsCheckSpin"></i> টেস্ট করুন
                            </button>
                        </div>
                        <div id="schoolDnsStatusResult" style="display:none; font-size:12px;">
                            <div id="schoolDnsAlert" class="alert py-2 px-3 mb-2 rounded-2 border-0"></div>
                            <div class="text-muted" style="font-size:11px;">
                                ডিটেক্টেড IP: <strong id="schoolDnsDetectedIp" class="text-dark"></strong>
                            </div>
                        </div>
                        <p class="text-muted mb-0" style="font-size:11px;">
                            <i class="fa-solid fa-clock me-1"></i> DNS পরিবর্তন কার্যকর হতে ৫ মিনিট থেকে কয়েক ঘণ্টা সময় লাগতে পারে।
                        </p>
                    </div>
                </div>
            </div>

            {{-- Step-by-step Guide --}}
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header border-0 py-3 px-4 bg-white border-bottom">
                    <h6 class="mb-0 fw-bold" style="font-size:13px; color:#1e293b;">
                        <i class="fa-solid fa-list-check me-2 text-primary"></i> ধাপে ধাপে নির্দেশনা
                    </h6>
                </div>
                <div class="card-body px-4 py-3 steps-wrap">
                    <div class="step-item">
                        <div class="step-num">1</div>
                        <div class="step-content">
                            <h6>ডোমেইন রেজিস্ট্রেশন করুন</h6>
                            <p>আপনার স্কুল বা প্রতিষ্ঠানের জন্য পছন্দের ডোমেইন কিনুন (যেমন <code>.edu.bd</code> বা <code>.com</code>)।</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <div class="step-content">
                            <h6>ফি পরিশোধ ও ডোমেইন সাবমিট</h6>
                            <p>বিকাশ/নগদে বাৎসরিক সার্ভার চার্জ পরিশোধ করে TrxID সহ রিকোয়েস্ট জমা দিন।</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <div class="step-content">
                            <h6>DNS A Record সেট করুন</h6>
                            <p>ডোমেইনের DNS Panel-এ গিয়ে A Record-এ উপরের সার্ভার IP <code>{{ $serverIp }}</code> পয়েন্ট করুন।</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">4</div>
                        <div class="step-content">
                            <h6>অনুমোদন ও SSL সক্রিয়</h6>
                            <p>সুপার এডমিন পেমেন্ট যাচাই করে অনুমোদন দিলে ডোমেইনটি স্বয়ংক্রিয়ভাবে ১ বছরের জন্য সক্রিয় হবে।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function copyDns(id) {
        const text = document.getElementById(id).textContent.trim();
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.currentTarget;
            btn.innerHTML = '<i class="fa-solid fa-check"></i>';
            btn.style.color = '#10b981';
            setTimeout(() => {
                btn.innerHTML = '<i class="fa-regular fa-copy"></i>';
                btn.style.color = '';
            }, 1500);
        });
    }

    document.getElementById('btnCheckSchoolDns')?.addEventListener('click', function() {
        const btn = this;
        const spin = document.getElementById('dnsCheckSpin');
        const resBox = document.getElementById('schoolDnsStatusResult');
        const alertBox = document.getElementById('schoolDnsAlert');
        const ipEl = document.getElementById('schoolDnsDetectedIp');

        btn.disabled = true;
        spin.classList.add('fa-spin');
        resBox.style.display = 'none';

        fetch("{{ route('admin.school.domain.check-dns', ['tenant' => request()->route('tenant')]) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                domain: document.getElementById('customDomainInput')?.value || '{{ $school->custom_domain }}'
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            spin.classList.remove('fa-spin');
            resBox.style.display = 'block';

            if (data.is_configured) {
                alertBox.className = 'alert alert-success py-2 px-3 mb-2 rounded-2 border-0 fw-semibold';
                alertBox.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> ' + (data.message || 'DNS সঠিকভাবে পয়েন্ট করছে!');
            } else {
                alertBox.className = 'alert alert-warning py-2 px-3 mb-2 rounded-2 border-0';
                alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + (data.message || 'DNS এখনও সার্ভারে পয়েন্ট করেনি।');
            }

            if (data.resolved_ips && data.resolved_ips.length > 0) {
                ipEl.textContent = data.resolved_ips.join(', ');
            } else {
                ipEl.textContent = 'কোনো রেকর্ড পাওয়া যায়নি';
            }
        })
        .catch(err => {
            btn.disabled = false;
            spin.classList.remove('fa-spin');
            resBox.style.display = 'block';
            alertBox.className = 'alert alert-danger py-2 px-3 mb-2 rounded-2 border-0';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> DNS চেক করতে সমস্যা হয়েছে: ' + err.message;
            ipEl.textContent = 'Error';
        });
    });
</script>
@endsection
