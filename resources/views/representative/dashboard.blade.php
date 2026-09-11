@extends('layouts.main')

@section('title', 'Representative Dashboard')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Greeting Logic --}}
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12)      { $greeting = "শুভ সকাল"; $faIcon = "fa-sun"; $greetColor = "#f59e0b"; }
            elseif ($hour >= 12 && $hour < 17) { $greeting = "শুভ দুপুর"; $faIcon = "fa-cloud-sun"; $greetColor = "#f97316"; }
            elseif ($hour >= 17 && $hour < 21) { $greeting = "শুভ বিকাল"; $faIcon = "fa-sunset"; $greetColor = "#8b5cf6"; }
            else                               { $greeting = "শুভ রাত্রি"; $faIcon = "fa-moon"; $greetColor = "#38bdf8"; }
        @endphp

        {{-- Session Flash Alerts --}}
        @if(session('success'))
        <div class="alert border-0 mb-4 px-4 py-3 d-flex align-items-center gap-3 shadow-sm"
             style="background:#ecfdf5;color:#065f46;border-radius:16px;border-left:5px solid #10b981 !important;">
            <i class="fa-solid fa-circle-check fa-lg text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif
        @if(session('error'))
        <div class="alert border-0 mb-4 px-4 py-3 d-flex align-items-center gap-3 shadow-sm"
             style="background:#fef2f2;color:#991b1b;border-radius:16px;border-left:5px solid #ef4444 !important;">
            <i class="fa-solid fa-circle-exclamation fa-lg text-danger"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        {{-- ===== HERO BANNER CARD ===== --}}
        <div class="mb-4 p-4 p-md-5 position-relative overflow-hidden"
             style="border-radius:24px; background:linear-gradient(135deg, #0f172a, #1e293b, #334155); color:white; box-shadow:0 15px 40px rgba(15,23,42,0.25);">

            {{-- Decorative Backdrops --}}
            <div style="position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(99,102,241,0.2);border-radius:50%;filter:blur(50px);"></div>
            <div style="position:absolute;bottom:-60px;left:8%;width:200px;height:200px;background:rgba(16,185,129,0.15);border-radius:50%;filter:blur(40px);"></div>

            <div class="row align-items-center position-relative" style="z-index:2;">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:58px;height:58px;background:rgba(255,255,255,0.12);border-radius:18px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.15);">
                            <i class="fa-solid {{ $faIcon }} fa-xl" style="color:{{ $greetColor }}"></i>
                        </div>
                        <div>
                            <div class="text-white-50 small fw-semibold">{{ $greeting }}, স্বাগতম!</div>
                            <h2 class="mb-0 fw-bold text-white" style="font-family:'Outfit',sans-serif;letter-spacing:-0.02em;">
                                {{ $user->name }}
                            </h2>
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="badge px-3 py-2 text-white" style="background:rgba(255,255,255,0.12);border-radius:10px;font-size:0.83rem;backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);">
                            <i class="fa-solid fa-id-badge me-1 text-info"></i>আইডি: {{ $employee->employee_id ?? 'N/A' }}
                        </span>
                        <span class="badge px-3 py-2 text-white" style="background:rgba(16,185,129,0.25);border-radius:10px;font-size:0.83rem;border:1px solid rgba(16,185,129,0.4);">
                            <i class="fa-solid fa-user-tie me-1 text-success"></i>School Representative
                        </span>
                        <span class="badge px-3 py-2 text-white" style="background:rgba(99,102,241,0.25);border-radius:10px;font-size:0.83rem;border:1px solid rgba(99,102,241,0.4);">
                            <i class="fa-solid fa-hand-holding-dollar me-1" style="color:#a5b4fc;"></i>
                            কমিশন: {{ $employee->commission_label ?? '০.০০' }}
                            @if($employee && $employee->commission_type === 'percentage') (সাবস্ক্রিপশনের উপর) @else (প্রতি স্কুলে) @endif
                        </span>
                        @if($employee->joining_date)
                        <span class="badge px-3 py-2 text-white-50" style="background:rgba(255,255,255,0.08);border-radius:10px;font-size:0.83rem;">
                            <i class="fa-solid fa-calendar-check me-1"></i>যোগদান: {{ date('d M Y', strtotime($employee->joining_date)) }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Action CTA --}}
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('manage.schools.create') }}" class="btn px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow"
                           style="background:linear-gradient(135deg,#10b981,#059669);color:white;border-radius:14px;border:none;font-size:0.92rem;">
                            <i class="fa-solid fa-circle-plus"></i>নতুন স্কুল নিবন্ধন
                        </a>
                        <a href="{{ route('rep.schools.index') }}" class="btn px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 text-white"
                           style="background:rgba(255,255,255,0.15);border-radius:14px;border:1px solid rgba(255,255,255,0.25);font-size:0.92rem;backdrop-filter:blur(8px);">
                            <i class="fa-solid fa-list-check"></i>আমার স্কুলসমূহ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== 6 KEY METRICS ROW ===== --}}
        <div class="row g-3 mb-4">
            {{-- 1. Total Schools --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #6366f1 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-school text-primary"></i>
                        </div>
                        @if($thisMonthSchools > 0)
                        <span class="badge bg-primary-subtle text-primary fw-semibold" style="font-size:0.7rem;">+{{ $thisMonthSchools }} নতুন</span>
                        @endif
                    </div>
                    <div class="text-muted small fw-semibold">মোট স্কুল</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $totalMySchools }}</div>
                </div>
            </div>

            {{-- 2. Approved Schools --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #10b981 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#ecfdf5;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-circle-check text-success"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success fw-semibold" style="font-size:0.7rem;">
                            {{ $totalMySchools > 0 ? round(($approvedSchools / $totalMySchools) * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="text-muted small fw-semibold">অনুমোদিত</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $approvedSchools }}</div>
                </div>
            </div>

            {{-- 3. Pending Schools --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #f59e0b !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-hourglass-half text-warning"></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">অপেক্ষারত</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $pendingSchools }}</div>
                </div>
            </div>

            {{-- 4. Active Subscriptions --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #06b6d4 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#ecfeff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-cubes text-info"></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">সক্রিয় সাবস্ক্রিপশন</div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ $activeSubscriptionsCount }}</div>
                </div>
            </div>

            {{-- 5. Monthly Commission --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #14b8a6 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#f0fdfa;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-arrow-trend-up text-teal" style="color:#0d9488;"></i>
                        </div>
                        <span class="badge bg-teal-subtle text-teal fw-semibold" style="font-size:0.7rem;color:#0d9488;background:#ccfbf1;">চলতি মাস</span>
                    </div>
                    <div class="text-muted small fw-semibold">এই মাসের কমিশন</div>
                    <div class="h4 mb-0 fw-bold text-dark">৳{{ number_format($monthlyCommission, 0) }}</div>
                </div>
            </div>

            {{-- 6. Total Commission --}}
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm p-3 h-100 position-relative overflow-hidden"
                     style="border-radius:18px;border-top:4px solid #8b5cf6 !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="width:42px;height:42px;background:#f5f3ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-coins" style="color:#8b5cf6;"></i>
                        </div>
                        <span class="badge bg-purple-subtle fw-semibold" style="font-size:0.7rem;color:#7c3aed;background:#ede9fe;">সর্বমোট</span>
                    </div>
                    <div class="text-muted small fw-semibold">মোট কমিশন</div>
                    <div class="h4 mb-1 fw-bold" style="color:#7c3aed;">৳{{ number_format($totalCommission, 0) }}</div>
                    <div class="text-muted" style="font-size:0.68rem;line-height:1.2;">
                        রেজি: <strong>৳{{ number_format($totalRegCommission, 0) }}</strong> | মাসিক: <strong>৳{{ number_format($totalMonthlyCommission, 0) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== CHARTS & SUMMARY ROW ===== --}}
        <div class="row g-4 mb-4">
            {{-- Monthly Growth Chart --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100" style="border-radius:20px;overflow:hidden;">
                    <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fa-solid fa-chart-area me-2" style="color:#6366f1;"></i>বিগত ৬ মাসের বৃদ্ধি ও কমিশন অ্যানালিটিক্স
                            </h6>
                            <span class="text-muted small">প্রতি মাসে নিবন্ধিত স্কুল সংখ্যা ও অর্জিত কমিশনের ট্রেন্ড</span>
                        </div>
                        <span class="badge px-3 py-2" style="background:#eef2ff;color:#6366f1;border-radius:10px;font-size:0.78rem;">
                            <i class="fa-solid fa-calendar-days me-1"></i>লাস্ট ৬ মাস
                        </span>
                    </div>
                    <div class="p-4">
                        <div style="position:relative; height:270px; width:100%;">
                            <canvas id="repPerformanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Commission & Policy Card --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 h-100 position-relative overflow-hidden"
                     style="border-radius:20px; background:linear-gradient(135deg, #4f46e5, #7c3aed); color:white;">

                    <div style="position:absolute;top:-40px;right:-40px;width:150px;height:150px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-sack-dollar fa-lg text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-white">কমিশন হিসাব বিবরণী</h6>
                            <span class="text-white-50 small">উপার্জন নীতি ও বিবরণ</span>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded-3" style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-white border-opacity-10">
                            <div>
                                <div class="text-white fw-semibold small">১. রেজিস্ট্রেশন কমিশন</div>
                                <div class="text-white-50" style="font-size:0.72rem;">নতুন স্কুল নিবন্ধনে প্যাকেজভিত্তিক</div>
                            </div>
                            <span class="fw-bold fs-6 text-warning">
                                {{ $employee->commission_type === 'percentage' ? $employee->commission_rate.'%' : '৳'.number_format($employee->commission_rate, 0) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="text-white fw-semibold small">২. মাসিক এক্সট্রা কমিশন</div>
                                <div class="text-white-50" style="font-size:0.72rem;">সক্রিয় স্কুলের জন্য প্রতি মাসে</div>
                            </div>
                            <span class="fw-bold fs-6 text-warning">
                                @if(($employee->monthly_commission_rate ?? 0) > 0)
                                    {{ $employee->monthly_commission_type === 'percentage' ? $employee->monthly_commission_rate.'%' : '৳'.number_format($employee->monthly_commission_rate, 0) }}
                                @else
                                    প্যাকেজ রেট
                                @endif
                            </span>
                        </div>
                        <div class="text-white-50 small mt-2 pt-2 border-top border-white border-opacity-10" style="font-size:0.72rem;">
                            <i class="fa-solid fa-circle-check me-1 text-info"></i>
                            নতুন স্কুল যুক্ত হলে এককালীন প্যাকেজ কমিশন এবং সচল থাকলে প্রতি মাসে এক্সট্রা রিকারিং কমিশন স্বয়ংক্রিয়ভাবে যোগ হয়।
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-2 rounded-3 text-center" style="background:rgba(255,255,255,0.1);">
                                <div class="text-white-50 small" style="font-size:0.72rem;">চলতি মাসের আয়</div>
                                <div class="fw-bold fs-6 mt-1">৳{{ number_format($monthlyCommission, 0) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3 text-center" style="background:rgba(255,255,255,0.1);">
                                <div class="text-white-50 small" style="font-size:0.72rem;">পেন্ডিং ডিলিট</div>
                                <div class="fw-bold fs-6 mt-1 text-warning">{{ $pendingDeleteRequests }}টি</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-2">
                        <a href="{{ route('rep.commissions') }}" class="btn w-100 fw-semibold py-2 text-white"
                           style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);border-radius:12px;backdrop-filter:blur(10px);">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>বিস্তারিত কমিশন রিপোর্ট দেখুন
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== RECENT SCHOOLS & DELETE TRACKER ROW ===== --}}
        <div class="row g-4 mb-4">

            {{-- 1. Recent Registered Schools --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius:20px;overflow:hidden;">
                    <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fa-solid fa-school me-2" style="color:#6366f1;"></i>আমার সাম্প্রতিক স্কুলসমূহ
                        </h6>
                        <a href="{{ route('rep.schools.index') }}" class="btn btn-sm px-3 fw-semibold"
                           style="background:#eef2ff;color:#6366f1;border-radius:10px;font-size:0.82rem;">
                            সকল স্কুল ({{ $totalMySchools }}) <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="p-0">
                        @if($mySchools->isEmpty())
                        <div class="text-center py-5">
                            <div style="width:70px;height:70px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                <i class="fa-solid fa-school fa-2x text-muted opacity-40"></i>
                            </div>
                            <h6 class="text-muted fw-semibold">এখনো কোনো স্কুল নিবন্ধন করেননি</h6>
                            <p class="text-muted small">আপনার প্রথম স্কুল নিবন্ধন করে কমিশন উপার্জন শুরু করুন</p>
                            <a href="{{ route('manage.schools.create') }}" class="btn btn-sm px-4 py-2"
                               style="background:linear-gradient(135deg,#10b981,#059669);color:white;border-radius:12px;border:none;">
                                <i class="fa-solid fa-plus me-1"></i>প্রথম স্কুল নিবন্ধন করুন
                            </a>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:0.9rem;">
                                <thead>
                                    <tr style="background:#f8fafc;color:#64748b;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                        <th class="px-4 py-3 border-0">স্কুল</th>
                                        <th class="py-3 border-0">প্যাকেজ</th>
                                        <th class="py-3 border-0 text-center">স্ট্যাটাস</th>
                                        <th class="py-3 border-0 text-end">কমিশন</th>
                                        <th class="px-4 py-3 border-0 text-center">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mySchools as $school)
                                    <tr style="border-bottom:1px solid #f8fafc;">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div style="width:40px;height:40px;background:#eef2ff;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    @if($school->logo)
                                                        <img src="{{ asset($school->logo) }}" style="width:34px;height:34px;object-fit:contain;border-radius:8px;">
                                                    @else
                                                        <i class="fa-solid fa-school" style="color:#6366f1;"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $school->name ?? '—' }}</div>
                                                    <div class="text-muted small" style="font-size:0.75rem;">
                                                        <code>{{ $school->app_code ?? 'N/A' }}</code>
                                                        @if($school->district) &bull; {{ $school->district }} @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge px-2 py-1" style="background:#f0f9ff;color:#0369a1;border-radius:8px;font-size:0.75rem;">
                                                {{ $school->subscriptionPackage?->name ?? 'বেসিক' }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-center">
                                            @if($school->status === 'approved')
                                                <span class="badge px-2 py-1" style="background:#ecfdf5;color:#065f46;border-radius:8px;font-size:0.75rem;">
                                                    <i class="fa-solid fa-circle-check me-1 text-success"></i>অনুমোদিত
                                                </span>
                                            @elseif($school->status === 'pending')
                                                <span class="badge px-2 py-1" style="background:#fffbeb;color:#92400e;border-radius:8px;font-size:0.75rem;">
                                                    <i class="fa-solid fa-clock me-1 text-warning"></i>অপেক্ষারত
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background:#fef2f2;color:#991b1b;border-radius:8px;font-size:0.75rem;">
                                                    <i class="fa-solid fa-circle-xmark me-1 text-danger"></i>বাতিল
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-end">
                                            <span class="fw-bold" style="color:#7c3aed;font-size:0.92rem;">
                                                ৳{{ number_format($school->earned_commission, 0) }}
                                            </span>
                                            @if(($school->registration_commission ?? 0) > 0 || ($school->monthly_commission ?? 0) > 0)
                                            <div class="text-muted" style="font-size:0.68rem;">
                                                রেজি: ৳{{ number_format($school->registration_commission ?? 0, 0) }} | মাসিক: ৳{{ number_format($school->monthly_commission ?? 0, 0) }}
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                @if($school->status === 'approved' && $school->slug)
                                                <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank"
                                                   class="btn btn-sm px-2 py-1" title="স্কুল পোর্টাল ভিজিট করুন"
                                                   style="background:#f1f5f9;color:#475569;border-radius:8px;font-size:0.75rem;">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                                @endif

                                                @if(in_array($school->id, $pendingDeleteSchoolIds))
                                                    <span class="badge px-2 py-1" style="background:#fef3c7;color:#92400e;border-radius:8px;font-size:0.72rem;">
                                                        <i class="fa-solid fa-hourglass-start me-1"></i>ডিলিট পেন্ডিং
                                                    </span>
                                                @elseif($school->status === 'approved')
                                                    <button type="button" class="btn btn-sm px-2 py-1"
                                                            onclick="openDeleteModal({{ $school->id }}, '{{ addslashes($school->name) }}')"
                                                            title="ডিলিট রিকোয়েস্ট পাঠান"
                                                            style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;font-size:0.75rem;">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. Delete Request Tracker (ডিলিট রিকোয়েস্ট লাইভ ট্র্যাকার) --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:20px;overflow:hidden;">
                    <div class="px-4 py-3 bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #f1f5f9;">
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fa-solid fa-triangle-exclamation me-2" style="color:#ef4444;"></i>ডিলিট রিকোয়েস্ট ট্র্যাকার
                            </h6>
                            <span class="text-muted small">আপনার পাঠানো অনুরোধ ও এডমিনের সিদ্ধান্ত</span>
                        </div>
                        @if($pendingDeleteRequests > 0)
                        <span class="badge px-2 py-1" style="background:#fef3c7;color:#92400e;border-radius:8px;font-size:0.75rem;">
                            {{ $pendingDeleteRequests }}টি অপেক্ষারত
                        </span>
                        @endif
                    </div>
                    <div class="p-3">
                        @if($myDeleteRequests->isEmpty())
                        <div class="text-center py-5">
                            <div style="width:60px;height:60px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                <i class="fa-solid fa-shield-check fa-2x text-muted opacity-40"></i>
                            </div>
                            <h6 class="text-muted fw-semibold">কোনো ডিলিট রিকোয়েস্ট নেই</h6>
                            <p class="text-muted small">আপনি কোনো স্কুল ডিলিটের অনুরোধ করেননি</p>
                        </div>
                        @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($myDeleteRequests as $req)
                            <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="fw-semibold text-dark" style="font-size:0.92rem;">
                                        <i class="fa-solid fa-school me-1 text-muted"></i>
                                        {{ $req->school?->name ?? 'স্কুল ডিলিট হয়েছে' }}
                                    </div>
                                    @if($req->status === 'pending')
                                        <span class="badge px-2 py-1" style="background:#fef3c7;color:#92400e;border-radius:8px;font-size:0.72rem;">
                                            <i class="fa-solid fa-clock me-1"></i>পেন্ডিং
                                        </span>
                                    @elseif($req->status === 'approved')
                                        <span class="badge px-2 py-1" style="background:#ecfdf5;color:#065f46;border-radius:8px;font-size:0.72rem;">
                                            <i class="fa-solid fa-circle-check me-1"></i>অনুমোদিত
                                        </span>
                                    @else
                                        <span class="badge px-2 py-1" style="background:#fef2f2;color:#991b1b;border-radius:8px;font-size:0.72rem;">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>বাতিল
                                        </span>
                                    @endif
                                </div>

                                <div class="text-muted small mb-2" style="font-size:0.8rem;">
                                    <span class="fw-semibold text-secondary">কারণ:</span> {{ Str::limit($req->reason, 90) }}
                                </div>

                                {{-- Admin feedback / note if rejected or reviewed --}}
                                @if($req->admin_note)
                                <div class="p-2 rounded-2 mb-2" style="background:{{ $req->status === 'rejected' ? '#fef2f2' : '#f0fdf4' }};border:1px solid {{ $req->status === 'rejected' ? '#fecaca' : '#bbf7d0' }};font-size:0.78rem;">
                                    <div class="fw-bold {{ $req->status === 'rejected' ? 'text-danger' : 'text-success' }}">
                                        <i class="fa-solid fa-comment-dots me-1"></i>এডমিনের মন্তব্য:
                                    </div>
                                    <div class="text-dark">{{ $req->admin_note }}</div>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size:0.72rem;">
                                    <span>অনুরোধ: {{ $req->created_at->format('d M, Y h:i A') }}</span>
                                    @if($req->reviewed_at)
                                        <span>পর্যালোচনা: {{ $req->reviewed_at->format('d M, Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== QUICK SHORTCUTS ROW ===== --}}
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:20px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-bolt me-2 text-warning"></i>দ্রুত শর্টকাট টুলস
                </h6>
                <span class="text-muted small">কাজের সুবিধার জন্য কুইক নেভিগেশন</span>
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('manage.schools.create') }}" class="card border-0 p-3 text-center text-decoration-none h-100 quick-card"
                       style="background:#f0fdf4;border-radius:16px;border:1px solid #bbf7d0 !important;">
                        <div style="width:46px;height:46px;background:#22c55e;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;color:white;">
                            <i class="fa-solid fa-school-circle-check fa-lg"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:0.92rem;">নতুন স্কুল তৈরি</div>
                        <div class="text-muted small" style="font-size:0.75rem;">নতুন ক্লায়েন্ট স্কুল যুক্ত করুন</div>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('rep.schools.index') }}" class="card border-0 p-3 text-center text-decoration-none h-100 quick-card"
                       style="background:#eef2ff;border-radius:16px;border:1px solid #c7d2fe !important;">
                        <div style="width:46px;height:46px;background:#6366f1;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;color:white;">
                            <i class="fa-solid fa-list-check fa-lg"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:0.92rem;">আমার স্কুলসমূহ</div>
                        <div class="text-muted small" style="font-size:0.75rem;">সকল স্কুলের তালিকা ও স্ট্যাটাস</div>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('rep.commissions') }}" class="card border-0 p-3 text-center text-decoration-none h-100 quick-card"
                       style="background:#f5f3ff;border-radius:16px;border:1px solid #ddd6fe !important;">
                        <div style="width:46px;height:46px;background:#7c3aed;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;color:white;">
                            <i class="fa-solid fa-file-invoice-dollar fa-lg"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:0.92rem;">কমিশন রিপোর্ট</div>
                        <div class="text-muted small" style="font-size:0.75rem;">বিস্তারিত উপার্জনের হিসাব</div>
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="{{ route('profile') }}" class="card border-0 p-3 text-center text-decoration-none h-100 quick-card"
                       style="background:#f8fafc;border-radius:16px;border:1px solid #e2e8f0 !important;">
                        <div style="width:46px;height:46px;background:#475569;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;color:white;">
                            <i class="fa-solid fa-user-gear fa-lg"></i>
                        </div>
                        <div class="fw-bold text-dark" style="font-size:0.92rem;">আমার প্রোফাইল</div>
                        <div class="text-muted small" style="font-size:0.75rem;">ব্যক্তিগত তথ্য ও নিরাপত্তা</div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Delete Request Modal --}}
<div class="modal fade" id="deleteRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px;overflow:hidden;">
            <div class="modal-header px-4 py-3" style="background:#fef2f2;border-bottom:1px solid #fecaca;">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>স্কুল ডিলিট রিকোয়েস্ট
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteRequestForm" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="p-3 mb-3 rounded-3" style="background:#fffbeb;border:1px solid #fed7aa;">
                        <p class="mb-0 text-sm" style="color:#92400e;font-size:0.88rem;">
                            <i class="fa-solid fa-info-circle me-1"></i>
                            আপনি <strong id="deleteSchoolName"></strong> স্কুলটি ডিলিট করার অনুরোধ পাঠাচ্ছেন।
                            এই অনুরোধটি সুপার এডমিন বা HR পর্যালোচনার পর অনুমোদন দিলে স্কুলটি অপসারিত হবে।
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark" for="delete_reason">
                            ডিলিট করার কারণ <span class="text-danger">*</span>
                        </label>
                        <textarea name="reason" id="delete_reason" class="form-control" rows="4"
                                  placeholder="কেন এই স্কুলটি ডিলিট করা প্রয়োজন তা সুস্পষ্টভাবে উল্লেখ করুন (কমপক্ষে ১০ অক্ষর)..."
                                  style="border-radius:12px;border-color:#e2e8f0;font-size:0.9rem;" required minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3 bg-light" style="border-top:1px solid #f1f5f9;">
                    <button type="button" class="btn px-4 py-2 fw-semibold" data-bs-dismiss="modal"
                            style="background:#e2e8f0;color:#475569;border-radius:12px;border:none;">বাতিল</button>
                    <button type="submit" class="btn px-4 py-2 fw-semibold"
                            style="background:linear-gradient(135deg,#dc2626,#b91c1c);color:white;border-radius:12px;border:none;">
                        <i class="fa-solid fa-paper-plane me-1"></i>রিকোয়েস্ট পাঠান
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts: Chart.js and Modal Trigger --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Handler
    window.openDeleteModal = function(schoolId, schoolName) {
        document.getElementById('deleteSchoolName').textContent = schoolName;
        document.getElementById('deleteRequestForm').action = '/representative/request-delete/' + schoolId;
        new bootstrap.Modal(document.getElementById('deleteRequestModal')).show();
    };

    // Chart.js Configuration
    const chartData = @json($chartData);
    const ctx = document.getElementById('repPerformanceChart');

    if (ctx && chartData) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'অর্জিত কমিশন (৳)',
                        data: chartData.commissions,
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124, 58, 237, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'y1',
                        pointBackgroundColor: '#7c3aed',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'নিবন্ধিত স্কুল',
                        data: chartData.schools,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.35,
                        yAxisID: 'y',
                        pointBackgroundColor: '#10b981',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: "'Outfit', sans-serif", size: 12 },
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 10,
                        titleFont: { size: 13, family: "'Outfit', sans-serif" },
                        bodyFont: { size: 12, family: "'Outfit', sans-serif" },
                        callbacks: {
                            label: function(context) {
                                if (context.dataset.yAxisID === 'y1') {
                                    return 'কমিশন: ৳' + Number(context.raw).toLocaleString();
                                }
                                return 'স্কুল: ' + context.raw + 'টি';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Outfit', sans-serif", size: 11 }, color: '#64748b' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { display: false },
                        ticks: {
                            precision: 0,
                            font: { family: "'Outfit', sans-serif", size: 11 },
                            color: '#10b981'
                        },
                        title: {
                            display: true,
                            text: 'স্কুল সংখ্যা',
                            color: '#10b981',
                            font: { size: 11 }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) { return '৳' + Number(value).toLocaleString(); },
                            font: { family: "'Outfit', sans-serif", size: 11 },
                            color: '#7c3aed'
                        },
                        title: {
                            display: true,
                            text: 'কমিশন (টাকা)',
                            color: '#7c3aed',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }
});
</script>

<style>
.quick-card {
    transition: all 0.25s ease;
}
.quick-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}
</style>
@endsection
