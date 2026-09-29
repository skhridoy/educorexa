@extends('layouts.school')

@section('title', __('Custom Domain Setup'))

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .domain-page-wrap { max-width: 900px; margin: 0 auto; }

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

        /* ── Steps Card ── */
        .steps-wrap { counter-reset: step; }
        .step-item {
            display: flex; gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .step-item:last-child { border-bottom: none; }
        .step-num {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 800;
            flex-shrink: 0;
        }
        .step-content h6 { font-size: 13.5px; font-weight: 700; margin-bottom: 4px; color: #1e293b; }
        .step-content p { font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5; }
        .step-content code {
            background: #f1f5f9;
            color: #4f46e5;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 12px;
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

        /* ── Locked Overlay ── */
        .locked-overlay {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 16px;
            padding: 48px 32px;
            text-align: center;
            color: #fff;
        }
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
                    {{ __('আপনার নিজস্ব ডোমেইন দিয়ে স্কুল পোর্টাল চালু করুন') }}
                </p>
            </div>
            <div class="ms-auto">
                @if($school->custom_domain_status === 'verified')
                    <span class="badge" style="background:#10b981; font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-circle-check me-1"></i> Active
                    </span>
                @elseif($school->custom_domain_status === 'pending')
                    <span class="badge bg-warning text-dark" style="font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-clock me-1"></i> Under Review
                    </span>
                @elseif($school->custom_domain_status === 'rejected')
                    <span class="badge bg-danger" style="font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-times-circle me-1"></i> Rejected
                    </span>
                @else
                    <span class="badge" style="background:rgba(255,255,255,0.12); font-size:11px; padding:6px 12px; border-radius:20px;">
                        <i class="fa-solid fa-circle me-1 text-muted"></i> Not Set
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php $locked = $locked ?? false; @endphp

    @if($locked)
        {{-- LOCKED STATE --}}
        <div class="locked-overlay">
            <div style="width:64px; height:64px; background:rgba(99,102,241,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto 16px;">
                <i class="fa-solid fa-lock" style="font-size:24px; color:#818cf8;"></i>
            </div>
            <h4 style="font-weight:800; margin-bottom:8px;">Custom Domain — Premium Feature</h4>
            <p style="color:#94a3b8; font-size:14px; max-width:400px; margin:0 auto 24px; line-height:1.6;">
                আপনার নিজস্ব ডোমেইন (যেমন <code style="background:#1e293b; color:#818cf8; padding:2px 8px; border-radius:6px;">school.example.com</code>) ব্যবহার করতে Premium প্যাকেজে আপগ্রেড করুন।
            </p>
            <a href="{{ route('school.pricing', ['tenant' => request()->route('tenant')]) }}" 
               class="btn btn-lg px-5 py-2 fw-bold rounded-pill"
               style="background: linear-gradient(135deg, #6366f1, #818cf8); color:#fff; border:none; box-shadow: 0 4px 20px rgba(99,102,241,0.4);">
                <i class="fa-solid fa-rocket me-2"></i> Upgrade Now
            </a>
        </div>
    @else
        <div class="row g-4">
            {{-- Left Column: Status + Form --}}
            <div class="col-lg-7">

                {{-- ── Current Status Banner ── --}}
                @if($school->custom_domain_status === 'verified')
                    <div class="domain-status-card d-flex align-items-start gap-3" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4); border:1px solid #86efac;">
                        <div class="domain-status-icon" style="background:#10b981; color:#fff;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1" style="color:#14532d; font-size:14px;">ডোমেইন সক্রিয় আছে!</h6>
                            <p class="mb-2" style="color:#166534; font-size:13px;">
                                আপনার স্কুল পোর্টাল এখন <strong>{{ $school->custom_domain }}</strong> থেকে অ্যাক্সেস করা যাচ্ছে।
                            </p>
                            <a href="https://{{ $school->custom_domain }}" target="_blank" class="btn btn-sm" style="background:#10b981; color:#fff; border-radius:8px; font-size:12px;">
                                <i class="fa-solid fa-external-link me-1"></i> Visit Site
                            </a>
                            <div class="mt-2" style="font-size:11.5px; color:#15803d;">
                                <i class="fa-solid fa-shield-halved me-1"></i> SSL: 
                                <strong>{{ $school->custom_domain_ssl_status === 'active' ? 'Active (HTTPS)' : 'Pending...' }}</strong>
                                &nbsp;·&nbsp;
                                <i class="fa-regular fa-clock me-1"></i> Verified {{ optional($school->custom_domain_verified_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    {{-- Danger Zone: Cancel (goes to super admin) --}}
                    <div class="card border-0 rounded-4 mb-4" style="background:#fff8f8; border:1px solid #fecaca !important;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between gap-3">
                            <div>
                                <div class="fw-bold" style="font-size:13px; color:#b91c1c;">Danger Zone</div>
                                <div style="font-size:12px; color:#ef4444;">ডোমেইন সরাতে চাইলে Super Admin-এর সাথে যোগাযোগ করুন।</div>
                            </div>
                        </div>
                    </div>

                @elseif($school->custom_domain_status === 'pending')
                    <div class="domain-status-card d-flex align-items-start gap-3" style="background:linear-gradient(135deg,#fefce8,#fffbeb); border:1px solid #fde047;">
                        <div class="domain-status-icon" style="background:#f59e0b; color:#fff;">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1" style="color:#78350f; font-size:14px;">রিভিউ চলছে...</h6>
                            <p class="mb-0" style="color:#92400e; font-size:13px;">
                                আপনার ডোমেইন <strong>{{ $school->custom_domain }}</strong> Super Admin-এর কাছে পর্যালোচনার জন্য পাঠানো হয়েছে।
                                সাধারণত ১-৩ কর্মদিবসের মধ্যে সম্পন্ন হয়।
                            </p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <form action="{{ route('admin.school.domain.cancel', ['tenant' => request()->route('tenant')]) }}" method="POST"
                              onsubmit="return confirm('রিকোয়েস্ট বাতিল করতে চান?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                                <i class="fa-solid fa-times me-1"></i> রিকোয়েস্ট বাতিল করুন
                            </button>
                        </form>
                    </div>

                @elseif($school->custom_domain_status === 'rejected')
                    <div class="domain-status-card d-flex align-items-start gap-3 mb-4" style="background:linear-gradient(135deg,#fef2f2,#fff5f5); border:1px solid #fca5a5;">
                        <div class="domain-status-icon" style="background:#ef4444; color:#fff;">
                            <i class="fa-solid fa-times-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1" style="color:#b91c1c; font-size:14px;">রিকোয়েস্ট Reject হয়েছে</h6>
                            <p class="mb-1" style="color:#991b1b; font-size:13px;">
                                ডোমেইন: <strong>{{ $school->custom_domain }}</strong>
                            </p>
                            @if($school->custom_domain_reject_reason)
                                <p class="mb-0" style="font-size:12.5px; color:#7f1d1d; background:#fee2e2; border-radius:8px; padding:8px 12px;">
                                    <i class="fa-solid fa-circle-info me-1"></i>
                                    <strong>কারণ:</strong> {{ $school->custom_domain_reject_reason }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {{-- Cancel rejected so can re-submit --}}
                    <form action="{{ route('admin.school.domain.cancel', ['tenant' => request()->route('tenant')]) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="fa-solid fa-redo me-1"></i> নতুন ডোমেইন দিয়ে আবার চেষ্টা করুন
                        </button>
                    </form>
                @endif

                {{-- ── Request Form (only when none or can re-submit) ── --}}
                @if(in_array($school->custom_domain_status, ['none', 'rejected']))
                    <div class="domain-form-card">
                        <div class="domain-form-header">
                            <h6 class="mb-0 fw-bold" style="font-size:14px;">
                                <i class="fa-solid fa-globe me-2 text-indigo-600" style="color:#6366f1;"></i>
                                কাস্টম ডোমেইন যুক্ত করুন
                            </h6>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('admin.school.domain.request', ['tenant' => request()->route('tenant')]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:13px;">আপনার ডোমেইন লিখুন</label>
                                    <div class="domain-input-wrap">
                                        <div class="domain-input-prefix">
                                            <i class="fa-solid fa-lock me-1" style="font-size:10px;"></i> https://
                                        </div>
                                        <input type="text" name="custom_domain" id="customDomainInput"
                                               value="{{ old('custom_domain', $school->custom_domain_status === 'rejected' ? $school->custom_domain : '') }}"
                                               placeholder="school.yourdomain.com"
                                               autocomplete="off" spellcheck="false">
                                    </div>
                                    @error('custom_domain')
                                        <div class="text-danger mt-1" style="font-size:12px;"><i class="fa-solid fa-circle-xmark me-1"></i>{{ $message }}</div>
                                    @enderror
                                    <p class="text-muted mt-2 mb-0" style="font-size:12px;">
                                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                                        উদাহরণ: <code>school.example.com</code> বা <code>portal.myschool.edu.bd</code>
                                    </p>
                                </div>

                                <div class="p-3 rounded-3 mb-3" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                                    <div class="fw-semibold mb-1" style="font-size:12.5px; color:#166534;">
                                        <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                                        সাবমিট করার আগে নিশ্চিত করুন:
                                    </div>
                                    <ul class="mb-0 ps-3" style="font-size:12px; color:#15803d; line-height:1.8;">
                                        <li>ডোমেইনটি আপনার নিজস্ব এবং আপনি এটির DNS নিয়ন্ত্রণ করেন।</li>
                                        <li>DNS Records সেটআপ করার প্রস্তুতি আছে (নির্দেশনা ডানে দেওয়া আছে)।</li>
                                        <li>Approval-এর পর ডোমেইনটি স্বয়ংক্রিয়ভাবে সক্রিয় হবে।</li>
                                    </ul>
                                </div>

                                <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3"
                                        style="background: linear-gradient(135deg, #6366f1, #818cf8); border:none;">
                                    <i class="fa-solid fa-paper-plane me-2"></i>রিকোয়েস্ট জমা করুন
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
                            <h6 class="mb-0 fw-bold text-white" style="font-size:13px;">DNS সেটআপ নির্দেশনা</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3" style="font-size:12.5px;">
                            আপনার ডোমেইন Approved হওয়ার পর নিচের DNS Records আপনার Domain Registrar-এ যোগ করুন:
                        </p>

                        @php
                            $serverIp = config('app.server_ip') ?: '127.0.0.1'; // আপনার সার্ভার IP
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
                                            <button class="dns-copy-btn" onclick="copyDns('dns-ip')">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-success">CNAME</span></td>
                                        <td>www</td>
                                        <td id="dns-cname">{{ $mainDomain }}</td>
                                        <td>
                                            <button class="dns-copy-btn" onclick="copyDns('dns-cname')">
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
                                <i class="fa-solid fa-clock me-1"></i> DNS রেকর্ড যোগ করার পর বিশ্বব্যাপী প্রপাগেশনে সাধারণত ৫ মিনিট থেকে ২৪ ঘণ্টা লাগতে পারে।
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Step-by-step Guide --}}
                <div class="card border-0 rounded-4 shadow-sm">
                    <div class="card-header border-0 py-3 px-4 bg-white border-bottom">
                        <h6 class="mb-0 fw-bold" style="font-size:13px; color:#1e293b;">
                            <i class="fa-solid fa-list-check me-2 text-primary"></i> ধাপে ধাপে গাইড
                        </h6>
                    </div>
                    <div class="card-body px-4 py-3 steps-wrap">
                        <div class="step-item">
                            <div class="step-num">1</div>
                            <div class="step-content">
                                <h6>ডোমেইন কিনুন / প্রস্তুত করুন</h6>
                                <p>আপনার পছন্দের Domain Registrar (যেমন Namecheap, GoDaddy, HostingBD) থেকে ডোমেইন রেজিস্ট্রেশন করুন।</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">2</div>
                            <div class="step-content">
                                <h6>ডোমেইন সাবমিট করুন</h6>
                                <p>বাম পাশের ফর্মে আপনার ডোমেইন লিখে রিকোয়েস্ট জমা করুন। সুপার এডমিন রিভিউ করবেন।</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">3</div>
                            <div class="step-content">
                                <h6>DNS Records সেটআপ করুন</h6>
                                <p>Approval পেলে উপরে দেওয়া <code>A Record</code> এবং <code>CNAME</code> আপনার DNS Panel-এ যোগ করুন।</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-num">4</div>
                            <div class="step-content">
                                <h6>Propagation সম্পন্ন হলে সক্রিয়</h6>
                                <p>DNS Propagation শেষ হলে আপনার ডোমেইনটি স্বয়ংক্রিয়ভাবে SSL সহ কার্যকর হবে।</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
                domain: document.getElementById('domainInput')?.value || '{{ $school->custom_domain }}'
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
