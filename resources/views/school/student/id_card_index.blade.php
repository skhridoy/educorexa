@extends('layouts.school')

@section('title', __('স্টুডেন্ট আইডি কার্ড জেনারেটর'))

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ── Metric & Stat Cards ── */
        .stat-card-modern {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #eef2f6;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        .stat-card-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }
        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .stat-card-modern:hover::before {
            opacity: 1;
        }
        .stat-icon-wrap {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        /* ── Premium Locked Banner ── */
        .premium-locked-banner {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1.5px dashed #f59e0b;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.08);
        }
        .premium-badge-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #d97706, #fbbf24);
            display: flex; align-items: center; justify-content: center;
            color: #ffffff;
            font-size: 22px;
            box-shadow: 0 4px 14px rgba(217, 119, 6, 0.3);
            flex-shrink: 0;
        }

        /* ── Realistic Card Mockup ── */
        .idcard-mockup-wrapper {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 24px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .mockup-card {
            width: 175px;
            height: 275px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
            border: 0.5px solid #cbd5e1;
            font-size: 8px;
            flex-shrink: 0;
        }
        .mockup-header-shape {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 110px;
            background: linear-gradient(135deg, #6a1b9a 0%, #ad1457 100%);
            clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%);
            z-index: 1;
        }
        .mockup-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #ffffff;
            padding-top: 8px;
            padding-left: 6px;
            padding-right: 6px;
        }
        .mockup-school-logo {
            max-height: 24px;
            max-width: 40px;
            object-fit: contain;
            display: inline-block;
        }
        .mockup-school-name {
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.1;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mockup-photo-box {
            position: absolute;
            top: 65px; left: 50%;
            transform: translateX(-50%);
            width: 54px; height: 54px;
            border-radius: 50%;
            background: #ffffff;
            padding: 2px;
            border: 2px solid #6a1b9a;
            z-index: 3;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .mockup-photo-box img {
            width: 100%; height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .mockup-details {
            position: absolute;
            top: 125px;
            width: 100%;
            padding: 0 10px;
            box-sizing: border-box;
            z-index: 2;
        }
        .mockup-name-badge {
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mockup-row {
            display: flex;
            justify-content: space-between;
            font-size: 7px;
            line-height: 1.25;
            color: #334155;
            margin-bottom: 1px;
        }
        .mockup-row strong {
            color: #6a1b9a;
        }
        .mockup-signature {
            position: absolute;
            bottom: 12px;
            right: 10px;
            text-align: center;
            z-index: 2;
        }
        .mockup-signature img {
            max-height: 20px;
            max-width: 45px;
            display: block;
            margin: 0 auto;
        }
        .mockup-signature p {
            margin: 0;
            font-size: 5.5px;
            font-weight: bold;
            border-top: 0.5px solid #333;
            color: #1e293b;
        }
        .mockup-bottom-bar {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 7px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }

        /* ── Back Card Mockup ── */
        .mockup-back-top {
            width: 100%;
            height: 18px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }
        .mockup-back-header {
            margin: 8px auto 4px auto;
            width: 85%;
            background: rgba(106, 27, 154, 0.12);
            color: #6a1b9a;
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            padding: 2px 0;
            border-radius: 3px;
        }
        .mockup-terms {
            padding: 0 10px;
            font-size: 6.5px;
            color: #475569;
            line-height: 1.2;
        }
        .mockup-qr-box {
            text-align: center;
            margin-top: 8px;
        }
        .mockup-qr-box img, .mockup-qr-box svg {
            width: 38px; height: 38px;
            background: white;
            padding: 2px;
            border: 0.5px solid #cbd5e1;
        }

        /* Dark mode overrides */
        [data-bs-theme="dark"] .stat-card-modern,
        body.dark-mode .stat-card-modern {
            background: #111c34 !important;
            border-color: #1e2d45 !important;
        }
        [data-bs-theme="dark"] .idcard-mockup-wrapper,
        body.dark-mode .idcard-mockup-wrapper {
            background: #0c1427 !important;
            border-color: #1e2d45 !important;
        }
    </style>
@endsection

@php
    $school = auth()->user()?->school ?? (app()->bound('currentSchool') ? app('currentSchool') : null);
    $canGenerateIdCard = $school ? $school->hasPackagePermission('student.idcard') : false;
    $pricingUrl = route('school.pricing', ['tenant' => $school?->slug ?? request()->route('tenant')]);
    $signaturePath = $school?->signature ?? auth()->user()?->signature;
    $hasSignature = !empty($signaturePath) && file_exists(public_path($signaturePath));
@endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid px-3 px-md-4">

            {{-- ── Breadcrumb & Title Bar ── --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                            <i class="fa-solid fa-id-card-clip me-1"></i>{{ __('Institutional Standard') }}
                        </span>
                        @if($canGenerateIdCard)
                            <span class="badge bg-success-subtle text-success fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                <i class="fa-solid fa-check-circle me-1"></i>{{ __('সক্রিয় প্যাকেজ') }}
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                <i class="fa-solid fa-crown me-1"></i>{{ __('প্রিমিয়াম ফিচার') }}
                            </span>
                        @endif
                    </div>
                    <h4 class="fw-bold text-dark mb-1">
                        {{ __('স্টুডেন্ট আইডি কার্ড জেনারেটর (Student ID Card Generator)') }}
                    </h4>
                    <p class="text-muted small mb-0">{{ __('প্রতিটি ক্লাসের শিক্ষার্থীদের আন্তর্জাতিক স্ট্যান্ডার্ড অনুযায়ী ডিজিটাল কিউআর কোড ও প্রধান শিক্ষকের স্বাক্ষরসহ বাল্ক আইডি কার্ড তৈরি ও PDF ডাউনলোড করুন।') }}</p>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-pill fw-semibold shadow-sm">
                        <i class="fa-solid fa-signature text-primary me-1"></i> {{ __('স্বাক্ষর সেটিংস (Signature)') }}
                    </a>
                    @if(!$canGenerateIdCard)
                        <a href="{{ $pricingUrl }}" class="btn btn-warning fw-bold px-3.5 py-2 rounded-pill shadow-sm">
                            <i class="fa-solid fa-crown me-1"></i> {{ __('Upgrade Plan') }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- ── Premium Locked Alert Banner (Free Package) ── --}}
            @if(!$canGenerateIdCard)
                <div class="premium-locked-banner">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="premium-badge-icon">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">
                                    {{ __('প্রিমিয়াম সুবিধা: বাল্ক স্টুডেন্ট আইডি কার্ড ডাউনলোড') }}
                                </h5>
                                <p class="text-muted mb-0 small" style="max-width: 680px;">
                                    {{ __('আপনার বর্তমান প্যাকেজে স্টুডেন্ট আইডি কার্ড জেনারেট সুবিধাটি বন্ধ রয়েছে। ডাইনামিক প্রধান শিক্ষকের স্বাক্ষর ও কিউআর কোডসহ আনলিমিটেড কার্ড ডাউনলোড করতে এখনই প্রিমিয়াম প্যাকেজ চালু করুন।') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ $pricingUrl }}" class="btn btn-warning fw-bold px-4 py-2.5 rounded-pill shadow-sm text-dark" style="font-size: 14px;">
                            <i class="fa-solid fa-gem me-1"></i> {{ __('প্রিমিয়াম প্যাকেজ চালু করুন (Upgrade Now)') }}
                        </a>
                    </div>
                </div>
            @endif

            {{-- ── 4 Quick Stats & Status Cards ── --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-card-modern d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap bg-primary-subtle text-primary">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">{{ __('মোট শিক্ষার্থী') }}</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $totalStudents ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-modern d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap bg-info-subtle text-info">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">{{ __('মোট ক্লাস') }}</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $classes->count() }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-modern d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap {{ $hasSignature ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                            <i class="fa-solid fa-signature"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <span class="text-muted small d-block">{{ __('প্রধান শিক্ষকের স্বাক্ষর') }}</span>
                            @if($hasSignature)
                                <div class="d-flex align-items-center gap-1.5 text-success fw-bold small text-nowrap">
                                    <i class="fa-solid fa-circle-check"></i> {{ __('সক্রিয় রয়েছে') }}
                                </div>
                            @else
                                <a href="{{ route('user.profile') }}" class="d-inline-flex align-items-center gap-1 text-warning fw-bold small text-decoration-none">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ __('আপলোড করুন') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat-card-modern d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap bg-purple-subtle text-purple" style="background: rgba(168, 85, 247, 0.12); color: #9333ea;">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">{{ __('প্রিন্ট সাইজ') }}</span>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">CR80 (Landscape A4)</h6>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Main Form & Live Card Preview Section ── --}}
            <div class="row g-4 mb-4">
                
                {{-- Form Column --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 18px; background: #ffffff;">
                        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-sliders"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ __('কার্ড তৈরি ও ডাউনলোড সেটআপ') }}</h5>
                                    <small class="text-muted">{{ __('ক্লাস নির্বাচন করে আইডি কার্ডের প্রিভিউ দেখুন') }}</small>
                                </div>
                            </div>
                            @if(!$canGenerateIdCard)
                                <span class="badge bg-warning-subtle text-warning fw-bold px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                    <i class="fa-solid fa-lock me-1"></i>{{ __('Locked') }}
                                </span>
                            @endif
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('students.idcard.preview', ['tenant' => auth()->user()->school->slug]) }}" method="GET">
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark small mb-2">
                                        {{ __('ক্লাস নির্বাচন করুন (Select Class)') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="class_id" class="form-select form-select-lg" required style="border-radius: 12px; font-size: 15px;" {{ !$canGenerateIdCard ? 'disabled' : '' }}>
                                        <option value="">{{ __('--- যে কোনো একটি ক্লাস নির্বাচন করুন ---') }}</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">
                                                {{ $class->name }} 
                                                @if(isset($class->students_count))
                                                    ({{ $class->students_count }} {{ __('জন শিক্ষার্থী') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                        {{ __('নির্বাচিত ক্লাসের সকল সক্রিয় শিক্ষার্থীর কার্ড একসঙ্গে প্রিভিউ ও PDF ডাউনলোড হবে।') }}
                                    </small>
                                </div>

                                {{-- Included Features Checklist --}}
                                <div class="p-3.5 rounded-3 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <h6 class="fw-bold text-dark mb-2.5 small">
                                        <i class="fa-solid fa-circle-check text-success me-1"></i>
                                        {{ __('কার্ডে যা যা অন্তর্ভুক্ত থাকবে:') }}
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                                <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                                                {{ __('উভয় পাশ (Front & Back)') }}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                                <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                                                {{ __('ডাইনামিক প্রধান শিক্ষকের স্বাক্ষর') }}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                                <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                                                {{ __('স্কুল লোগো ও ব্র্যান্ড কালার') }}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                                <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                                                {{ __('স্টুডেন্ট কিউআর কোড (QR Code)') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-flex align-items-center gap-2 pt-2">
                                    @if($canGenerateIdCard)
                                        <button type="submit" class="btn btn-primary px-4 py-2.5 fw-bold shadow-sm flex-grow-1" style="border-radius: 12px;">
                                            <i class="fa-solid fa-eye me-1.5"></i> {{ __('আইডি কার্ড প্রিভিউ ও ডাউনলোড করুন') }}
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary px-4 py-2.5 fw-bold disabled flex-grow-1" style="border-radius: 12px;">
                                            <i class="fa-solid fa-lock me-1.5"></i> {{ __('প্রিভিউ লক করা রয়েছে') }}
                                        </button>
                                        <a href="{{ $pricingUrl }}" class="btn btn-warning px-4 py-2.5 fw-bold text-dark shadow-sm" style="border-radius: 12px;">
                                            <i class="fa-solid fa-crown me-1"></i> {{ __('প্রিমিয়াম প্যাকেজ চালু করুন') }}
                                        </a>
                                    @endif
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- Live Mockup Preview Column --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 18px; background: #ffffff;">
                        <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-purple-subtle text-purple d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: rgba(168,85,247,0.12); color: #9333ea;">
                                    <i class="fa-solid fa-id-badge"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ __('লাইভ আইডি কার্ড ডিজাইন প্রিভিউ') }}</h5>
                                    <small class="text-muted">{{ __('স্ট্যান্ডার্ড প্রাতিষ্ঠানিক ফরম্যাট (সামনের ও পেছনের পাশ)') }}</small>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                {{ __('CR80 300 DPI') }}
                            </span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column justify-content-center">
                            
                            {{-- Mockup Visual Cards --}}
                            <div class="idcard-mockup-wrapper mb-3">
                                
                                {{-- Front Side Mockup --}}
                                <div class="mockup-card">
                                    <div class="mockup-header-shape"></div>
                                    <div class="mockup-header-content">
                                        @if($school && $school->logo && file_exists(public_path($school->logo)))
                                            <img src="{{ asset($school->logo) }}" class="mockup-school-logo" alt="Logo">
                                        @else
                                            <div class="mockup-school-logo d-inline-flex align-items-center justify-content-center text-white fw-bold" style="font-size: 10px;">
                                                <i class="fa-solid fa-school"></i>
                                            </div>
                                        @endif
                                        <div class="mockup-school-name">{{ $school->name ?? 'SCHOOL / COLLEGE NAME' }}</div>
                                    </div>

                                    <div class="mockup-photo-box">
                                        <img src="{{ asset('assets/images/profile.webp') }}" alt="Student">
                                    </div>

                                    <div class="mockup-details">
                                        <div class="mockup-name-badge">STUDENT NAME</div>
                                        <div class="mockup-row">
                                            <strong>Class:</strong> <span>Six</span>
                                            <strong>Roll:</strong> <span>01</span>
                                        </div>
                                        <div class="mockup-row">
                                            <strong>ID:</strong> <span>STU-2026-001</span>
                                        </div>
                                        <div class="mockup-row">
                                            <strong>Blood:</strong> <span>A+</span>
                                            <strong>Phone:</strong> <span>01700-000000</span>
                                        </div>
                                    </div>

                                    <div class="mockup-signature">
                                        @if($hasSignature)
                                            <img src="{{ asset($signaturePath) }}" alt="Sign">
                                        @else
                                            <img src="{{ asset('assets/images/signature.png') }}" alt="Sign">
                                        @endif
                                        <p>{{ __('Principal') }}</p>
                                    </div>

                                    <div class="mockup-bottom-bar"></div>
                                </div>

                                {{-- Back Side Mockup --}}
                                <div class="mockup-card">
                                    <div class="mockup-back-top"></div>
                                    <div class="mockup-back-header">TERMS AND CONDITIONS</div>

                                    <div class="mockup-terms">
                                        <p class="mb-1">• This card is the property of {{ $school->name ?? 'the school' }}.</p>
                                        <p class="mb-1">• If found, please return to the school office immediately.</p>
                                        <p class="mb-1"><strong>Phone:</strong> {{ $school->phone ?? '01XXX-XXXXXX' }}</p>
                                        <p class="mb-1"><strong>Session:</strong> 2026</p>
                                    </div>

                                    <div class="mockup-qr-box">
                                        <div style="display: inline-block; padding: 2px; border: 0.5px solid #cbd5e1; background: white;">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(38)->color(106, 27, 154)->generate("Sample ID Card - Educore") !!}
                                        </div>
                                        <div style="font-size: 6px; font-weight: bold; color: #6a1b9a; margin-top: 2px;">
                                            VERIFIED DIGITAL ID
                                        </div>
                                    </div>

                                    <div class="mockup-bottom-bar"></div>
                                </div>

                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3 text-center">
                                <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill small">
                                    <i class="fa-solid fa-layer-group text-primary me-1"></i> {{ __('Front: ছবি ও বিস্তারিত') }}
                                </span>
                                <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill small">
                                    <i class="fa-solid fa-qrcode text-purple me-1"></i> {{ __('Back: শর্তাবলী ও কিউআর') }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Institutional Printing Guide Card ── --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: #ffffff;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-lightbulb text-warning me-2"></i>{{ __('প্রিন্টিং গাইডলাইন ও জরুরি পরামর্শ (Printing Recommendations):') }}
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: #f8fafc; border-left: 3px solid #6366f1;">
                                <h6 class="fw-bold text-dark mb-1 small">{{ __('১. কাগজের সাইজ ও টাইপ') }}</h6>
                                <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">
                                    {{ __('A4 Landscape সাইজে প্রতি পাতায় ৪ জন শিক্ষার্থীর কার্ড (Front & Back পাশাপাশি) কাটার গাইডলাইনসহ সুবিন্যস্তভাবে সাজানো রয়েছে। ২৫০-৩০০ GSM আর্ট কার্ড বা পিভিসি পেপারে প্রিন্ট করুন।') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: #f8fafc; border-left: 3px solid #10b981;">
                                <h6 class="fw-bold text-dark mb-1 small">{{ __('২. প্রধান শিক্ষকের স্বাক্ষর') }}</h6>
                                <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">
                                    {{ __('স্বাক্ষর আপলোড না করা থাকলে ডিফল্ট স্বাক্ষর দেখাবে। প্রোফাইল থেকে ট্রান্সপারেন্ট ব্যাকগ্রাউন্ডের আসল স্বাক্ষর আপলোড করলে তা স্বয়ংক্রিয়ভাবে কার্ডে যুক্ত হয়ে যাবে।') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 h-100" style="background: #f8fafc; border-left: 3px solid #f59e0b;">
                                <h6 class="fw-bold text-dark mb-1 small">{{ __('৩. প্রিন্টার সেটিংস') }}</h6>
                                <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">
                                    {{ __('ব্রাউজার প্রিন্ট ডায়ালগে "Margins: None" বা "Default" এবং "Background graphics" অপশনটি টিক দিয়ে রাখুন যাতে কার্ডের সব রঙ নিখুঁতভাবে প্রিন্ট হয়।') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
