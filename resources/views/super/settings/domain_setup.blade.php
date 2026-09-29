@extends('layouts.main')
@section('title', 'Domain & Server Setup')

@section('customCSS')
    @include('layouts._shared_styles')
    <style>
        .ds-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .ds-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ds-card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .ds-card-body { padding: 24px; }
        .info-block {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .info-block code {
            background: #e0f2fe;
            color: #0369a1;
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 13px;
        }
        .current-val-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-family: monospace;
            font-size: 13px;
            font-weight: 600;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .current-val-badge.warn {
            background: #fefce8;
            color: #92400e;
            border-color: #fde68a;
        }
        .tab-nav {
            display: flex;
            gap: 4px;
            background: #f1f5f9;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 24px;
        }
        .tab-nav a {
            flex: 1;
            text-align: center;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13.5px;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }
        .tab-nav a.active {
            background: #fff;
            color: #1e293b;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            font-weight: 600;
        }
        .tab-nav a:hover:not(.active) { color: #334155; background: rgba(255,255,255,0.5); }
        .live-check-result { display: none; margin-top: 12px; }
    </style>
@endsection

@section('content')
<div class="page-content">
    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Domain & Server Setup</li>
    </ul>

    {{-- Page Header --}}
    <div class="sch-page-hd d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-server me-2" style="color:#4f46e5;"></i> Domain & Server Setup</h2>
            <p class="edu-page-sub">সার্ভার আইপি এবং মেইন ডোমেইন কনফিগার করুন। এই তথ্যগুলো Custom Domain DNS Verification-এ ব্যবহার হয়।</p>
        </div>
        <div>
            <a href="{{ route('super.custom-domain.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-globe me-1"></i> Custom Domain Requests
            </a>
        </div>
    </div>

    {{-- Settings Navigation Tabs --}}
    <div class="tab-nav">
        <a href="{{ route('settings.edit') }}"><i class="fa-solid fa-sliders me-1"></i> General</a>
        <a href="{{ route('settings.api') }}"><i class="fa-solid fa-plug me-1"></i> API / Mail</a>
        <a href="{{ route('settings.payment') }}"><i class="fa-solid fa-credit-card me-1"></i> Payment</a>
        <a href="{{ route('settings.domain') }}" class="active"><i class="fa-solid fa-server me-1"></i> Domain & Server</a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left: Form --}}
        <div class="col-12 col-xl-7">
            <form action="{{ route('settings.domain.update') }}" method="POST" id="domainSetupForm">
                @csrf

                {{-- Server IP --}}
                <div class="ds-card">
                    <div class="ds-card-header">
                        <div class="ds-card-header-icon" style="background:#eff6ff; color:#2563eb;">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Server IP Address</div>
                            <div class="text-muted small">এই সার্ভারের Public IP যেখানে সাইটটি হোস্ট করা আছে</div>
                        </div>
                        <div class="ms-auto">
                            @if(!empty($setting->server_ip))
                                <span class="current-val-badge">
                                    <i class="fa-solid fa-circle-check text-success" style="font-size:11px;"></i>
                                    {{ $setting->server_ip }}
                                </span>
                            @else
                                <span class="current-val-badge warn">
                                    <i class="fa-solid fa-triangle-exclamation" style="font-size:11px;"></i>
                                    {{ config('app.server_ip', 'Not set') }}
                                    <span class="text-muted fw-normal" style="font-size:11px;">(from .env)</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="ds-card-body">
                        <div class="info-block mb-3">
                            <div class="fw-semibold text-dark mb-1"><i class="fa-solid fa-circle-info me-1" style="color:#3b82f6;"></i> কেন এটি দরকার?</div>
                            <div class="text-muted small">
                                স্কুল যখন তাদের কাস্টম ডোমেইন (যেমন <code>myschool.edu.bd</code>) সেটআপ করে, তখন DNS এ এই IP টি
                                <strong>A Record</strong> হিসেবে যোগ করতে হয়। Super Admin Panel থেকে DNS check করলে
                                এই IP টির বিপরীতে verify করা হয়।
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="server_ip" class="form-label fw-semibold">
                                Public Server IP <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted">
                                    <i class="fa-solid fa-network-wired"></i>
                                </span>
                                <input type="text" name="server_ip" id="server_ip"
                                    class="form-control @error('server_ip') is-invalid @enderror"
                                    value="{{ old('server_ip', $setting->server_ip ?? config('app.server_ip', '')) }}"
                                    placeholder="যেমন: 103.140.200.150" autocomplete="off" spellcheck="false">
                                <button type="button" class="btn btn-outline-secondary px-3" id="detectBtn" onclick="detectPublicIp()">
                                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto-Detect
                                </button>
                                @error('server_ip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text text-muted">
                                <i class="fa-solid fa-info-circle me-1"></i>
                                IPv4 ফরম্যাট: <code>103.140.200.150</code> — হোস্টিং কন্ট্রোল প্যানেল থেকে নিন।
                            </div>
                            <div id="detectResult" class="live-check-result"></div>
                        </div>
                    </div>
                </div>

                {{-- Main Domain --}}
                <div class="ds-card">
                    <div class="ds-card-header">
                        <div class="ds-card-header-icon" style="background:#f0fdf4; color:#16a34a;">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Main Domain</div>
                            <div class="text-muted small">প্ল্যাটফর্মের মূল ডোমেইন (subdomain routing এর base)</div>
                        </div>
                        <div class="ms-auto">
                            @if(!empty($setting->main_domain))
                                <span class="current-val-badge">
                                    <i class="fa-solid fa-circle-check text-success" style="font-size:11px;"></i>
                                    {{ $setting->main_domain }}
                                </span>
                            @else
                                <span class="current-val-badge warn">
                                    <i class="fa-solid fa-triangle-exclamation" style="font-size:11px;"></i>
                                    {{ config('app.main_domain', 'Not set') }}
                                    <span class="text-muted fw-normal" style="font-size:11px;">(from .env)</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="ds-card-body">
                        <div class="info-block mb-3">
                            <div class="fw-semibold text-dark mb-1"><i class="fa-solid fa-circle-info me-1" style="color:#3b82f6;"></i> কেন এটি দরকার?</div>
                            <div class="text-muted small">
                                এই ডোমেইনের অধীনে স্কুলের subdomain তৈরি হয় (যেমন <code>idealschool.educorexa.com</code>)।
                                Custom domain CNAME verify করার সময়ও এই মেইন ডোমেইন টার্গেট হিসেবে দেখানো হয়।
                                পরিবর্তন করলে <strong>.env ফাইলেও লেখা হবে।</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="main_domain" class="form-label fw-semibold">
                                Main Domain <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted">
                                    <i class="fa-solid fa-globe"></i>
                                </span>
                                <input type="text" name="main_domain" id="main_domain"
                                    class="form-control @error('main_domain') is-invalid @enderror"
                                    value="{{ old('main_domain', $setting->main_domain ?? config('app.main_domain', '')) }}"
                                    placeholder="যেমন: educorexa.com" autocomplete="off" spellcheck="false">
                                @error('main_domain')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text text-muted">
                                <i class="fa-solid fa-info-circle me-1"></i>
                                শুধু রুট ডোমেইন লিখুন — <code>www.</code> বা <code>http://</code> ছাড়া।
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Custom Domain Server Fee (Annual) --}}
                <div class="ds-card">
                    <div class="ds-card-header">
                        <div class="ds-card-header-icon" style="background:#fef3c7; color:#d97706;">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Custom Domain Server Fee (বাৎসরিক সার্ভার চার্জ)</div>
                            <div class="text-muted small">ফ্রি বা নন-ইনক্লুডেড প্যাকেজের স্কুলের জন্য কাস্টম ডোমেইন ফি</div>
                        </div>
                        <div class="ms-auto">
                            <span class="current-val-badge">
                                <i class="fa-solid fa-bangladeshi-taka-sign text-warning" style="font-size:11px;"></i>
                                ৳ {{ number_format($setting->custom_domain_yearly_fee ?? 1500, 2) }} / year
                            </span>
                        </div>
                    </div>
                    <div class="ds-card-body">
                        <div class="info-block mb-3">
                            <div class="fw-semibold text-dark mb-1"><i class="fa-solid fa-circle-info me-1" style="color:#3b82f6;"></i> চার্জ মডেল কীভাবে কাজ করে?</div>
                            <div class="text-muted small">
                                • যেসব স্কুল <strong>ফ্রি প্যাকেজ</strong> বা সাধারণ প্যাকেজ ব্যবহার করে, তারা কাস্টম ডোমেইন যুক্ত করতে চাইলে প্রতি বছর এই নির্ধারিত সার্ভার চার্জ প্রদান করবে।<br>
                                • যেসব প্রিমিয়াম প্যাকেজে কাস্টম ডোমেইন <strong>অন্তর্ভুক্ত (Free Included)</strong> থাকে, তাদের কোনো আলাদা ফি দিতে হবে না।<br>
                                • স্কুল এডমিন বিকাশ/নগদে ফি পরিশোধ করে TrxID দিয়ে রিকোয়েস্ট জমা দেবে। Super Admin পেমেন্ট যাচাই করে Approve করলে ১ বছরের জন্য সক্রিয় হবে।
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="custom_domain_yearly_fee" class="form-label fw-semibold">
                                বাৎসরিক সার্ভার চার্জ (টাকায় / BDT) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted fw-bold">৳</span>
                                <input type="number" step="0.01" min="0" name="custom_domain_yearly_fee" id="custom_domain_yearly_fee"
                                    class="form-control @error('custom_domain_yearly_fee') is-invalid @enderror"
                                    value="{{ old('custom_domain_yearly_fee', $setting->custom_domain_yearly_fee ?? 1500.00) }}"
                                    placeholder="1500.00">
                                <span class="input-group-text bg-light text-muted">/ বছর (Annual)</span>
                                @error('custom_domain_yearly_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text text-muted">
                                <i class="fa-solid fa-info-circle me-1"></i>
                                উদাহরণ: <code>1500</code> টাকা। কোনো চার্জ না রাখতে চাইলে <code>0</code> দিন।
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Save --}}
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('super.dashboard') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-5" id="saveBtn">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Right: Info --}}
        <div class="col-12 col-xl-5">

            {{-- Active Config --}}
            <div class="ds-card">
                <div class="ds-card-header">
                    <div class="ds-card-header-icon" style="background:#faf5ff; color:#7c3aed;">
                        <i class="fa-solid fa-circle-nodes"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Active Configuration</div>
                        <div class="text-muted small">বর্তমানে যা কার্যকর আছে</div>
                    </div>
                </div>
                <div class="ds-card-body">
                    <table class="table table-sm align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted small fw-semibold" style="width:38%">Server IP</td>
                                <td><code class="text-dark">{{ config('app.server_ip', '—') }}</code></td>
                                <td>
                                    @if(!empty($setting->server_ip))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">DB</span>
                                    @elseif(config('app.server_ip'))
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">.env</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger" style="font-size:10px;">Missing</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Main Domain</td>
                                <td><code class="text-dark">{{ config('app.main_domain', '—') }}</code></td>
                                <td>
                                    @if(!empty($setting->main_domain))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">DB</span>
                                    @elseif(config('app.main_domain'))
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">.env</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger" style="font-size:10px;">Missing</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">Custom Domain Fee</td>
                                <td><code class="text-dark">৳ {{ number_format($setting->custom_domain_yearly_fee ?? 1500, 2) }} / yr</code></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:10px;">Annual</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-semibold">APP_URL</td>
                                <td colspan="2"><code class="text-dark">{{ config('app.url') }}</code></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-3 p-3 rounded-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <div class="small text-muted">
                            <span class="badge bg-success-subtle text-success border border-success-subtle me-1" style="font-size:10px;">DB</span> Database থেকে লোড (সর্বোচ্চ অগ্রাধিকার)<br>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle me-1 mt-1" style="font-size:10px;">.env</span> .env ফাইল থেকে fallback<br>
                            <span class="badge bg-danger-subtle text-danger me-1 mt-1" style="font-size:10px;">Missing</span> কনফিগার করা নেই
                        </div>
                    </div>
                </div>
            </div>

            {{-- DNS Guide --}}
            <div class="ds-card">
                <div class="ds-card-header">
                    <div class="ds-card-header-icon" style="background:#fff7ed; color:#c2410c;">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">DNS Pointing Guide</div>
                        <div class="text-muted small">স্কুলকে কীভাবে DNS সেটআপ করতে বলবেন</div>
                    </div>
                </div>
                <div class="ds-card-body">
                    <p class="text-muted small mb-3">স্কুল যখন Custom Domain যোগ করে, তাদের ডোমেইন রেজিস্ট্রারে নিচের যেকোনো একটি রেকর্ড যোগ করতে বলুন:</p>

                    <div class="mb-3">
                        <div class="fw-semibold text-dark mb-2 small"><span class="badge bg-primary-subtle text-primary me-1">Option 1</span> A Record</div>
                        <div class="bg-dark text-white rounded-3 p-3" style="font-family:monospace; font-size:12px; line-height:2;">
                            Type: <span style="color:#fde68a;">A</span><br>
                            Name: <span style="color:#86efac;">@</span> (বা ফাঁকা রাখুন)<br>
                            Value: <span style="color:#93c5fd;">{{ config('app.server_ip', 'YOUR_SERVER_IP') }}</span><br>
                            TTL: <span style="color:#d1d5db;">3600</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="fw-semibold text-dark mb-2 small"><span class="badge bg-success-subtle text-success me-1">Option 2</span> CNAME (www)</div>
                        <div class="bg-dark text-white rounded-3 p-3" style="font-family:monospace; font-size:12px; line-height:2;">
                            Type: <span style="color:#fde68a;">CNAME</span><br>
                            Name: <span style="color:#86efac;">www</span><br>
                            Value: <span style="color:#93c5fd;">{{ config('app.main_domain', 'educorexa.com') }}</span><br>
                            TTL: <span style="color:#d1d5db;">3600</span>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 rounded-3 py-2 px-3 mb-0" style="font-size:12.5px;">
                        <i class="fa-solid fa-clock me-1"></i>
                        DNS propagation সাধারণত <strong>30 মিনিট – 48 ঘণ্টা</strong> পর্যন্ত সময় নিতে পারে।
                    </div>
                </div>
            </div>

            {{-- Quick DNS Lookup --}}
            <div class="ds-card">
                <div class="ds-card-header">
                    <div class="ds-card-header-icon" style="background:#ecfeff; color:#0891b2;">
                        <i class="fa-solid fa-satellite-dish"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Quick DNS Lookup</div>
                        <div class="text-muted small">যেকোনো ডোমেইনের DNS যাচাই করুন</div>
                    </div>
                </div>
                <div class="ds-card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="quickDnsInput" class="form-control" placeholder="myschool.edu.bd" spellcheck="false">
                        <button class="btn btn-outline-primary" type="button" id="dnsCheckBtn" onclick="quickDnsLookup()">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Check
                        </button>
                    </div>
                    <div id="quickDnsResult" style="display:none;">
                        <div class="p-3 rounded-3" style="background:#0f172a; font-family:monospace; font-size:12px; line-height:1.8; color:#e2e8f0;">
                            <div id="quickDnsOutput"></div>
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
    // Auto-detect server public IP
    function detectPublicIp() {
        const btn = document.getElementById('detectBtn');
        const result = document.getElementById('detectResult');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Detecting...';
        result.style.display = 'none';

        fetch('https://api.ipify.org?format=json')
            .then(r => r.json())
            .then(data => {
                document.getElementById('server_ip').value = data.ip;
                result.style.display = 'block';
                result.innerHTML = `<div class="alert alert-success border-0 py-2 px-3 rounded-3 mb-0 small"><i class="fa-solid fa-circle-check me-1"></i> Detected: <strong>${data.ip}</strong> — সঠিক কিনা নিশ্চিত করে Save করুন।</div>`;
            })
            .catch(() => {
                result.style.display = 'block';
                result.innerHTML = `<div class="alert alert-warning border-0 py-2 px-3 rounded-3 mb-0 small"><i class="fa-solid fa-triangle-exclamation me-1"></i> Auto-detect ব্যর্থ হয়েছে। হোস্টিং প্যানেল থেকে ম্যানুয়ালি IP নিন।</div>`;
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto-Detect';
            });
    }

    // Quick DNS lookup via dns.google
    function quickDnsLookup() {
        const domain = document.getElementById('quickDnsInput').value.trim()
            .replace(/^https?:\/\//i, '').replace(/^www\./i, '').replace(/\/.*$/, '');

        if (!domain) { alert('একটি ডোমেইন নাম লিখুন।'); return; }

        const result = document.getElementById('quickDnsResult');
        const output = document.getElementById('quickDnsOutput');
        const btn = document.getElementById('dnsCheckBtn');
        result.style.display = 'block';
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';
        output.innerHTML = `<span style="color:#94a3b8;">Checking ${domain}...</span>`;

        const serverIp = document.getElementById('server_ip').value.trim();

        fetch(`https://dns.google/resolve?name=${encodeURIComponent(domain)}&type=A`)
            .then(r => r.json())
            .then(data => {
                let lines = [`<span style="color:#818cf8;">Domain:</span> <span style="color:#f0f9ff;">${domain}</span>`];

                if (data.Answer && data.Answer.length > 0) {
                    const ips = data.Answer.filter(r => r.type === 1).map(r => r.data);
                    if (ips.length) {
                        lines.push(`<span style="color:#818cf8;">A Records:</span> ${ips.map(ip => `<span style="color:#86efac;">${ip}</span>`).join(', ')}`);
                        if (serverIp && ips.includes(serverIp)) {
                            lines.push(`<span style="color:#4ade80;">✓ Server IP (${serverIp}) matched!</span>`);
                        } else if (serverIp) {
                            lines.push(`<span style="color:#fbbf24;">✗ Server IP (${serverIp}) not found in A records</span>`);
                        }
                    }
                } else {
                    lines.push(`<span style="color:#f87171;">No A records found</span>`);
                }

                output.innerHTML = lines.join('<br>');

                // Also check CNAME
                return fetch(`https://dns.google/resolve?name=${encodeURIComponent(domain)}&type=CNAME`);
            })
            .then(r => r.json())
            .then(data => {
                if (data.Answer && data.Answer.length > 0) {
                    const targets = data.Answer.map(r => r.data);
                    output.innerHTML += `<br><span style="color:#818cf8;">CNAME:</span> ${targets.map(t => `<span style="color:#86efac;">${t}</span>`).join(', ')}`;
                }
            })
            .catch(() => {
                output.innerHTML = `<span style="color:#f87171;">DNS lookup failed — propagation pending বা ইন্টারনেট সমস্যা।</span>`;
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-magnifying-glass me-1"></i> Check';
            });
    }

    // Form submit
    document.getElementById('domainSetupForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Saving...';
    });

    // Clean inputs on blur
    document.getElementById('main_domain')?.addEventListener('blur', function () {
        let val = this.value.trim().toLowerCase()
            .replace(/^https?:\/\//i, '').replace(/^www\./i, '').replace(/\/.*$/, '');
        this.value = val;
    });
    document.getElementById('server_ip')?.addEventListener('blur', function () {
        this.value = this.value.trim();
    });

    // Enter key on DNS input
    document.getElementById('quickDnsInput')?.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); quickDnsLookup(); }
    });
</script>
@endsection
