@extends('app-layouts.frontend')

@section('title', 'স্কুল রেজিস্ট্রেশন')
@section('subtitle', 'EduCorexa Cloud Platform')
@section('seo_title', 'স্কুল ও মাদ্রাসা রেজিস্ট্রেশন | EduCorexa')
@section('seo_description', 'মাত্র কয়েক মিনিটে আপনার স্কুল, কলেজ বা মাদ্রাসার জন্য একটি পূর্ণাঙ্গ ক্লাউড ম্যানেজমেন্ট পোর্টাল রেজিস্ট্রেশন করুন।')

@section('content')
<div class="ec-reg-page">

    {{-- ── Background Ambient Glows ── --}}
    <div class="ec-reg-bg-glow ec-reg-bg-glow--1"></div>
    <div class="ec-reg-bg-glow ec-reg-bg-glow--2"></div>

    {{-- ── Top Hero / Breadcrumb Header ── --}}
    <section class="ec-reg-hero">
        <div class="container">
            <div class="ec-reg-hero__inner text-center">
                <div class="ec-reg-hero__badge">
                    <span class="badge-dot"></span>
                    <span>✨ দ্রুত ও সহজ রেজিস্ট্রেশন</span>
                </div>
                <h1 class="ec-reg-hero__title">
                    আপনার প্রতিষ্ঠানের <span class="text-gradient">ডিজিটাল রূপান্তর</span> শুরু করুন
                </h1>
                <p class="ec-reg-hero__subtitle">
                    মাত্র ৩টি সহজ ধাপে তথ্য পূরণ করে আপনার স্কুল বা মাদ্রাসার জন্য নিজস্ব ক্লাউড পোর্টাল তৈরি করুন।
                </p>
            </div>
        </div>
    </section>

    {{-- ── Main Registration Section ── --}}
    <section class="ec-reg-content pb-5">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start">

                {{-- ── Left Column: Live Preview & Trust Column (Desktop Sticky) ── --}}
                <div class="col-lg-5 col-xl-4 d-none d-lg-block">
                    <div class="ec-reg-sidebar sticky-top" style="top: 100px; z-index: 10;">

                        {{-- Live Portal Browser Mockup Card --}}
                        <div class="ec-reg-preview-card">
                            <div class="ec-reg-preview-card__browser-bar">
                                <span class="browser-dot browser-dot--red"></span>
                                <span class="browser-dot browser-dot--yellow"></span>
                                <span class="browser-dot browser-dot--green"></span>
                                <div class="browser-url-pill">
                                    <i class="bi bi-lock-fill text-success me-1"></i>
                                    <span class="text-muted">https://</span><span class="fw-bold text-primary" id="previewSubdomain">yourschool</span><span class="text-muted">.{{ request()->getHost() }}</span>
                                </div>
                            </div>
                            <div class="ec-reg-preview-card__body">
                                <div class="preview-school-brand">
                                    <div class="preview-school-icon">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <div class="preview-school-meta">
                                        <h6 class="preview-school-name mb-0" id="previewSchoolName">আপনার প্রতিষ্ঠানের নাম</h6>
                                        <small class="text-muted" id="previewLocation">বিভাগ, জেলা</small>
                                    </div>
                                </div>
                                <div class="preview-status-strip mt-3">
                                    <span class="badge-status">
                                        <i class="bi bi-patch-check-fill me-1"></i> পোর্টাল স্ট্যাটাস:
                                    </span>
                                    <span class="badge-online">রেডি টু লঞ্চ</span>
                                </div>
                            </div>
                        </div>

                        {{-- Selected Package Showcase Card --}}
                        <div class="ec-reg-pkg-card mt-4">
                            <div class="ec-reg-pkg-card__header">
                                <span class="ec-reg-pkg-card__tag">নির্বাচিত প্যাকেজ</span>
                                <h5 class="ec-reg-pkg-card__name mb-0" id="previewPkgName">বাছাইকৃত প্যাকেজ</h5>
                            </div>
                            <div class="ec-reg-pkg-card__price-row">
                                <span class="pkg-currency">৳</span>
                                <span class="pkg-amount" id="previewPkgPrice">০</span>
                                <span class="pkg-period" id="previewPkgPeriod">/ মেয়াদ</span>
                            </div>
                            <ul class="ec-reg-pkg-card__features" id="previewPkgFeatures">
                                <li><i class="bi bi-check2-circle text-primary"></i> <span id="previewPkgLimit">সকল মূল ফিচার অন্তর্ভুক্ত</span></li>
                                <li><i class="bi bi-check2-circle text-primary"></i> অনলাইন অ্যাডমিশন ও হাজিরা</li>
                                <li><i class="bi bi-check2-circle text-primary"></i> সার্বক্ষণিক ক্লাউড সাপোর্ট</li>
                            </ul>
                        </div>

                        {{-- Trust Highlights List --}}
                        <div class="ec-reg-trust-box mt-4">
                            <h6 class="ec-reg-trust-title">
                                <i class="bi bi-shield-check text-success me-2"></i>EduCorexa এর সাথে পাচ্ছেন:
                            </h6>
                            <div class="trust-item">
                                <div class="trust-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                                <div>
                                    <strong>দ্রুত সেটআপ:</strong>
                                    <span>কোনো জটিল কনফিগারেশন ছাড়াই ব্যবহার উপযোগী</span>
                                </div>
                            </div>
                            <div class="trust-item">
                                <div class="trust-icon"><i class="bi bi-phone"></i></div>
                                <div>
                                    <strong>মোবাইল ও পিসি ফ্রেন্ডলি:</strong>
                                    <span>যেকোনো ডিভাইস থেকে নিয়ন্ত্রণ সুবিধা</span>
                                </div>
                            </div>
                            <div class="trust-item">
                                <div class="trust-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                                <div>
                                    <strong>১০০% ডেটা নিরাপত্তা:</strong>
                                    <span>স্বয়ংক্রিয় ক্লাউড ব্যাকআপ ব্যবস্থা</span>
                                </div>
                            </div>
                        </div>

                        {{-- Helpline Callout --}}
                        <div class="ec-reg-helpline mt-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="helpline-icon">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">রেজিস্ট্রেশনে সহায়তা লাগবে?</small>
                                    <a href="tel:+01844054129" class="helpline-link fw-bold text-dark">+01844054129</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Right Column: The Registration Form ── --}}
                <div class="col-lg-7 col-xl-8">
                    <div class="ec-reg-card shadow-sm">

                        {{-- Success Notification --}}
                        @if(session('success'))
                            <div class="alert alert-success d-flex align-items-start gap-3 border-0 rounded-4 shadow-sm p-4 mb-4" role="alert">
                                <div class="alert-icon-box bg-success text-white rounded-circle p-2 flex-shrink-0">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading fw-bold mb-1">অভিনন্দন!</h5>
                                    <p class="mb-0 fs-6">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Error Notification --}}
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 shadow-sm p-4 mb-4" role="alert">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                                    <h6 class="alert-heading fw-bold mb-0">অনুগ্রহ করে তথ্যগুলো সংশোধন করুন:</h6>
                                </div>
                                <ul class="mb-0 ps-3 small">
                                    @foreach($errors->all() as $error)
                                        <li class="py-0.5">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('school.register.store') }}" id="schoolRegisterForm" class="ec-reg-form">
                            @csrf

                            {{-- ════════ STEP 1: INSTITUTION DETAILS ════════ --}}
                            <div class="form-section-card">
                                <div class="form-section-header">
                                    <div class="form-section-step">১</div>
                                    <div>
                                        <h5 class="form-section-title">প্রতিষ্ঠানের তথ্য</h5>
                                        <p class="form-section-desc">আপনার স্কুল, কলেজ বা মাদ্রাসার প্রাথমিক বিবরণ প্রদান করুন</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    {{-- School Name --}}
                                    <div class="col-12">
                                        <label for="school_name" class="ec-field-label">
                                            প্রতিষ্ঠানের পুরো নাম <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-building ec-input-icon"></i>
                                            <input type="text"
                                                   name="school_name"
                                                   id="school_name"
                                                   class="ec-input @error('school_name') is-invalid @enderror"
                                                   placeholder="উদাঃ আদর্শ মডেল উচ্চ বিদ্যালয়"
                                                   value="{{ old('school_name') }}"
                                                   required>
                                        </div>
                                        @error('school_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Division --}}
                                    <div class="col-md-4">
                                        <label for="division" class="ec-field-label">
                                            বিভাগ <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-map ec-input-icon"></i>
                                            <select name="division"
                                                    id="division"
                                                    class="ec-select @error('division') is-invalid @enderror"
                                                    required>
                                                <option value="">বিভাগ লোড হচ্ছে...</option>
                                            </select>
                                        </div>
                                        @error('division')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- District --}}
                                    <div class="col-md-4">
                                        <label for="district" class="ec-field-label">
                                            জেলা <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-geo-alt ec-input-icon"></i>
                                            <select name="district"
                                                    id="district"
                                                    class="ec-select @error('district') is-invalid @enderror"
                                                    required disabled>
                                                <option value="">জেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                        @error('district')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Upazila --}}
                                    <div class="col-md-4">
                                        <label for="upazila" class="ec-field-label">
                                            উপজেলা <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-pin-map ec-input-icon"></i>
                                            <select name="upazila"
                                                    id="upazila"
                                                    class="ec-select @error('upazila') is-invalid @enderror"
                                                    required disabled>
                                                <option value="">উপজেলা নির্বাচন করুন</option>
                                            </select>
                                        </div>
                                        @error('upazila')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Detailed Address --}}
                                    <div class="col-12">
                                        <label for="address" class="ec-field-label">
                                            বিস্তারিত ঠিকানা (গ্রাম/রোড/ওয়ার্ড) <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-geo ec-input-icon ec-input-icon--top"></i>
                                            <textarea name="address"
                                                      id="address"
                                                      class="ec-textarea @error('address') is-invalid @enderror"
                                                      placeholder="যেমন: বাড়ি নং ১২, রোড নং ৩, থানা রোড"
                                                      rows="2"
                                                      required>{{ old('address') }}</textarea>
                                        </div>
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- ════════ STEP 2: SUBDOMAIN & PACKAGE ════════ --}}
                            <div class="form-section-card mt-4">
                                <div class="form-section-header">
                                    <div class="form-section-step">২</div>
                                    <div>
                                        <h5 class="form-section-title">পোর্টাল সাবডোমেইন ও প্যাকেজ</h5>
                                        <p class="form-section-desc">আপনার পোর্টাল লিংক এবং সুবিধাজনক প্যাকেজ নির্বাচন করুন</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    {{-- Subdomain / Slug --}}
                                    <div class="col-12">
                                        <label for="slug" class="ec-field-label">
                                            লগইন সাবডোমেন (Subdomain) <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-subdomain-group">
                                            <span class="subdomain-prefix d-none d-sm-inline-flex">https://</span>
                                            <input type="text"
                                                   name="slug"
                                                   id="slug"
                                                   class="ec-subdomain-input @error('slug') is-invalid @enderror"
                                                   placeholder="abcschool"
                                                   value="{{ old('slug') }}"
                                                   required
                                                   autocomplete="off">
                                            <span class="subdomain-suffix">.{{ request()->getHost() }}</span>
                                        </div>
                                        <div class="ec-subdomain-hint mt-2 text-break">
                                            <i class="bi bi-info-circle me-1"></i>
                                            আপনার স্কুল পোর্টাল অ্যাড্রেস হবে: <strong id="preview-url" class="text-primary text-break">abcschool.{{ request()->getHost() }}</strong>
                                        </div>
                                        @error('slug')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Subscription Package --}}
                                    <div class="col-12 mt-3">
                                        <label class="ec-field-label mb-2">
                                            সাবস্ক্রিপশন প্যাকেজ নির্বাচন করুন <span class="text-danger">*</span>
                                        </label>

                                        {{-- Visual Package Selector Cards --}}
                                        <div class="row g-3 ec-pkg-selector">
                                            @if(isset($packages) && $packages->count() > 0)
                                                @php
                                                    $defaultPackageId = old('package_id', $selectedPackageId ?? ($packages->first()->id ?? null));
                                                @endphp
                                                @foreach($packages as $pkg)
                                                    @php
                                                        $isFreePkg = (bool)$pkg->is_free || (float)$pkg->price <= 0;
                                                        $isCurrent = (string)$defaultPackageId === (string)$pkg->id;
                                                    @endphp
                                                    <div class="col-md-4">
                                                        <label class="ec-pkg-radio-card {{ $isCurrent ? 'is-selected' : '' }} {{ $pkg->is_popular ? 'has-badge' : '' }}" for="pkg_{{ $pkg->id }}">
                                                            <input type="radio"
                                                                   name="package_id"
                                                                   id="pkg_{{ $pkg->id }}"
                                                                   value="{{ $pkg->id }}"
                                                                   class="ec-pkg-radio-input"
                                                                   data-name="{{ $pkg->name }}"
                                                                   data-price="{{ $isFreePkg ? '০' : number_format($pkg->price) }}"
                                                                   data-duration="{{ $pkg->duration == 'yearly' ? '/ বছর' : '/ মাস' }}"
                                                                   data-students="{{ $pkg->student_limit ? ($pkg->student_limit . ' জন শিক্ষার্থী') : 'আনলিমিটেড শিক্ষার্থী' }}"
                                                                   {{ $isCurrent ? 'checked' : '' }}
                                                                   required>
                                                            @if($pkg->is_popular)
                                                                <span class="ec-pkg-badge-popular">জনপ্রিয়</span>
                                                            @endif
                                                            <div class="ec-pkg-card-inner">
                                                                <div class="ec-pkg-card-left">
                                                                    <div class="ec-pkg-radio-circle">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </div>
                                                                    <div class="ec-pkg-info">
                                                                        <h6 class="pkg-title mb-0">{{ $pkg->name }}</h6>
                                                                        <small class="text-muted pkg-limit">{{ $pkg->student_limit ? ($pkg->student_limit . ' শিক্ষার্থী') : 'আনলিমিটেড শিক্ষার্থী' }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="ec-pkg-card-right">
                                                                    <div class="pkg-price-text">
                                                                        @if($isFreePkg)
                                                                            <span class="free-text">ফ্রি</span>
                                                                        @else
                                                                            <span class="price-val">৳{{ number_format($pkg->price) }}</span>
                                                                            <small class="price-unit">/{{ $pkg->duration == 'yearly' ? 'বছর' : 'মাস' }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @error('package_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- ════════ STEP 3: ADMIN ACCOUNT DETAILS ════════ --}}
                            <div class="form-section-card mt-4">
                                <div class="form-section-header">
                                    <div class="form-section-step">৩</div>
                                    <div>
                                        <h5 class="form-section-title">প্রধান অ্যাডমিনের তথ্য</h5>
                                        <p class="form-section-desc">এই তথ্য দিয়ে পরবর্তীতে প্রতিষ্ঠানের মূল অ্যাডমিন প্যানেলে লগইন করবেন</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    {{-- Admin Name --}}
                                    <div class="col-md-6">
                                        <label for="admin_name" class="ec-field-label">
                                            অ্যাডমিনের পুরো নাম <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-person ec-input-icon"></i>
                                            <input type="text"
                                                   name="admin_name"
                                                   id="admin_name"
                                                   class="ec-input @error('admin_name') is-invalid @enderror"
                                                   placeholder="উদাঃ মোঃ রফিকুল ইসলাম"
                                                   value="{{ old('admin_name') }}"
                                                   required>
                                        </div>
                                        @error('admin_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Admin Phone (11 Digits Validation) --}}
                                    <div class="col-md-6">
                                        <label for="admin_phone" class="ec-field-label">
                                            মোবাইল নম্বর (১১ ডিজিট) <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-telephone ec-input-icon"></i>
                                            <input type="text"
                                                   name="admin_phone"
                                                   id="admin_phone"
                                                   maxlength="11"
                                                   class="ec-input @error('admin_phone') is-invalid @enderror"
                                                   placeholder="01712345678"
                                                   value="{{ old('admin_phone') }}"
                                                   required>
                                            <span class="ec-phone-badge" id="phoneBadge" style="display: none;">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted d-block mt-1" id="phoneHint" style="font-size: 0.78rem;">
                                            সঠিক ১১ ডিজিটের মোবাইল নম্বর লিখুন (উদাঃ 017XXXXXXXX)
                                        </small>
                                        @error('admin_phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Admin Email --}}
                                    <div class="col-md-6">
                                        <label for="admin_email" class="ec-field-label">
                                            ইমেইল অ্যাড্রেস <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-envelope ec-input-icon"></i>
                                            <input type="email"
                                                   name="admin_email"
                                                   id="admin_email"
                                                   class="ec-input @error('admin_email') is-invalid @enderror"
                                                   placeholder="admin@school.com"
                                                   value="{{ old('admin_email') }}"
                                                   required>
                                        </div>
                                        @error('admin_email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Admin Password --}}
                                    <div class="col-md-6">
                                        <label for="admin_password" class="ec-field-label">
                                            লগইন পাসওয়ার্ড (কমপক্ষে ৮ অক্ষর) <span class="text-danger">*</span>
                                        </label>
                                        <div class="ec-input-wrap">
                                            <i class="bi bi-shield-lock ec-input-icon"></i>
                                            <input type="password"
                                                   name="admin_password"
                                                   id="admin_password"
                                                   class="ec-input @error('admin_password') is-invalid @enderror"
                                                   placeholder="••••••••"
                                                   minlength="8"
                                                   required>
                                            <button type="button" class="btn-toggle-pw" id="togglePassword" aria-label="Toggle password visibility">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </button>
                                        </div>
                                        @error('admin_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- ════════ TERMS & CONDITIONS ════════ --}}
                            <div class="ec-reg-terms mt-4">
                                <label class="ec-checkbox-label">
                                    <input type="checkbox" name="agree_terms" id="agree_terms" required checked>
                                    <span>
                                        আমি EduCorexa-এর <a href="#" class="text-primary fw-semibold text-decoration-none">শর্তাবলী</a> এবং <a href="#" class="text-primary fw-semibold text-decoration-none">গোপনীয়তা নীতি</a> পড়েছি এবং তা মেনে নিচ্ছি।
                                    </span>
                                </label>
                            </div>

                            {{-- ════════ SUBMIT BUTTON ════════ --}}
                            <div class="ec-reg-action mt-4">
                                <button type="submit" class="ec-reg-submit-btn" id="submitBtn">
                                    <span class="btn-text">
                                        <i class="bi bi-rocket-takeoff-fill me-2"></i>রেজিস্ট্রেশন সম্পন্ন করুন
                                    </span>
                                    <span class="btn-spinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>অপেক্ষা করুন...
                                    </span>
                                </button>
                            </div>

                            {{-- ════════ LOGIN LINK ════════ --}}
                            <div class="ec-reg-footer mt-4 pt-3 text-center">
                                <p class="text-muted mb-0">
                                    ইতিমধ্যে কি অ্যাকাউন্ট রয়েছে?
                                    <a href="{{ route('login.form') }}" class="ec-login-link">
                                        লগইন করুন <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

{{-- ════════ STYLES: Matching Home Page Design System ════════ --}}
@push('custom-css')
<style>
    /* ── Scope Variables ── */
    :root {
        --reg-primary: #4f46e5;
        --reg-primary-hover: #4338ca;
        --reg-primary-light: #eff6ff;
        --reg-gradient: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #4338ca 100%);
        --reg-surface: #ffffff;
        --reg-bg: #f8fafc;
        --reg-border: #e2e8f0;
        --reg-text-dark: #0f172a;
        --reg-text-muted: #64748b;
        --reg-radius: 18px;
        --reg-radius-sm: 12px;
        --reg-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.06), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
    }

    .ec-reg-page {
        background-color: var(--reg-bg);
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        font-family: inherit;
    }

    /* Ambient Glows */
    .ec-reg-bg-glow {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        pointer-events: none;
        z-index: 0;
    }
    .ec-reg-bg-glow--1 {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
        top: -100px;
        left: -150px;
    }
    .ec-reg-bg-glow--2 {
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
        bottom: 10%;
        right: -100px;
    }

    /* Hero Header */
    .ec-reg-hero {
        padding: 55px 0 35px;
        position: relative;
        z-index: 1;
    }
    .ec-reg-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(99, 102, 241, 0.08);
        border: 1px solid rgba(99, 102, 241, 0.2);
        color: var(--reg-primary);
        font-size: 0.85rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 18px;
    }
    .badge-dot {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .ec-reg-hero__title {
        font-size: 2.3rem;
        font-weight: 800;
        color: var(--reg-text-dark);
        line-height: 1.3;
        margin-bottom: 14px;
        letter-spacing: -0.02em;
    }
    .text-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .ec-reg-hero__subtitle {
        color: var(--reg-text-muted);
        font-size: 1.05rem;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Main Register Card */
    .ec-reg-card {
        background: var(--reg-surface);
        border: 1px solid var(--reg-border);
        border-radius: var(--reg-radius);
        padding: 38px 40px;
        box-shadow: var(--reg-shadow);
        position: relative;
        z-index: 1;
    }

    /* Form Section Cards */
    .form-section-card {
        background: #fafbfd;
        border: 1px solid #edf2f7;
        border-radius: var(--reg-radius-sm);
        padding: 24px 26px;
        transition: border-color 0.2s ease;
    }
    .form-section-card:hover {
        border-color: #e2e8f0;
    }
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid #eef2f6;
    }
    .form-section-step {
        width: 38px;
        height: 38px;
        background: var(--reg-gradient);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.05rem;
        box-shadow: 0 4px 10px -2px rgba(79, 70, 229, 0.4);
        flex-shrink: 0;
    }
    .form-section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--reg-text-dark);
        margin-bottom: 2px;
    }
    .form-section-desc {
        color: var(--reg-text-muted);
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    /* Input Styling */
    .ec-field-label {
        font-size: 0.88rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }
    .ec-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .ec-input-icon {
        position: absolute;
        left: 15px;
        color: #94a3b8;
        font-size: 1.1rem;
        pointer-events: none;
        transition: color 0.2s ease;
        z-index: 2;
    }
    .ec-input-icon--top {
        top: 14px;
    }
    .ec-input, .ec-select, .ec-textarea {
        width: 100%;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        padding: 12px 16px 12px 44px;
        font-size: 0.94rem;
        color: #1e293b;
        font-weight: 500;
        transition: all 0.25s ease;
        outline: none;
    }
    .ec-textarea {
        resize: vertical;
        min-height: 75px;
    }
    .ec-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 14px 10px;
    }
    .ec-input:focus, .ec-select:focus, .ec-textarea:focus {
        border-color: var(--reg-primary);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .ec-input:focus ~ .ec-input-icon,
    .ec-select:focus ~ .ec-input-icon {
        color: var(--reg-primary);
    }
    .ec-select:disabled {
        background-color: #f1f5f9;
        cursor: not-allowed;
        color: #94a3b8;
    }

    /* Subdomain Input Group */
    .ec-subdomain-group {
        display: flex;
        align-items: stretch;
        background-color: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        overflow: hidden;
        min-width: 0;
        width: 100%;
        transition: all 0.25s ease;
    }
    .ec-subdomain-group:focus-within {
        border-color: var(--reg-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .subdomain-prefix {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 12px 14px;
        user-select: none;
        border-right: 1px solid #edf2f7;
        align-items: center;
        flex-shrink: 0;
    }
    .ec-subdomain-input {
        flex: 1 1 auto;
        min-width: 0;
        border: none;
        padding: 12px 14px;
        font-size: 0.94rem;
        font-weight: 700;
        color: #0f172a;
        outline: none;
        letter-spacing: 0.3px;
    }
    .subdomain-suffix {
        background-color: #f8fafc;
        color: #4f46e5;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 12px 14px;
        user-select: none;
        border-left: 1px solid #edf2f7;
        flex-shrink: 0;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }
    .ec-subdomain-hint {
        font-size: 0.82rem;
        color: #64748b;
    }

    /* Visual Package Selector Cards */
    .ec-pkg-radio-card {
        display: block;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        cursor: pointer;
        position: relative;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .ec-pkg-radio-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }
    .ec-pkg-radio-card.is-selected {
        border-color: var(--reg-primary);
        background: #fafbff;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.12);
    }
    .ec-pkg-radio-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .ec-pkg-badge-popular {
        position: absolute;
        top: -10px;
        right: 12px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
        letter-spacing: 0.5px;
        z-index: 2;
    }
    .ec-pkg-card-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .ec-pkg-card-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .ec-pkg-radio-circle {
        width: 22px;
        height: 22px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: transparent;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .ec-pkg-radio-card.is-selected .ec-pkg-radio-circle {
        border-color: var(--reg-primary);
        background-color: var(--reg-primary);
        color: #ffffff;
    }
    .pkg-title {
        font-size: 0.94rem;
        font-weight: 700;
        color: #1e293b;
    }
    .pkg-limit {
        font-size: 0.76rem;
        display: block;
    }
    .pkg-price-text .free-text {
        font-size: 1.15rem;
        font-weight: 800;
        color: #059669;
    }
    .pkg-price-text .price-val {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
    }
    .pkg-price-text .price-unit {
        font-size: 0.76rem;
        color: #64748b;
    }

    @media (min-width: 992px) {
        .ec-pkg-card-inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .ec-pkg-radio-card {
            padding: 16px 14px;
            min-height: 96px;
        }
    }

    /* Password Toggle Button */
    .btn-toggle-pw {
        position: absolute;
        right: 12px;
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 1.15rem;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
        z-index: 2;
    }
    .btn-toggle-pw:hover {
        color: #475569;
    }

    /* Phone Badge */
    .ec-phone-badge {
        position: absolute;
        right: 14px;
        font-size: 1.1rem;
        z-index: 2;
    }

    /* Checkbox & Terms */
    .ec-checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.88rem;
        color: #475569;
        cursor: pointer;
    }
    .ec-checkbox-label input {
        margin-top: 3px;
        width: 17px;
        height: 17px;
        accent-color: var(--reg-primary);
        cursor: pointer;
    }

    /* Submit Button */
    .ec-reg-submit-btn {
        width: 100%;
        background: var(--reg-gradient);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 15px 24px;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.45);
    }
    .ec-reg-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -4px rgba(79, 70, 229, 0.55);
        color: white;
    }
    .ec-reg-submit-btn:active {
        transform: translateY(0);
    }

    /* Footer & Login Link */
    .ec-login-link {
        color: var(--reg-primary);
        font-weight: 700;
        text-decoration: none;
        margin-left: 4px;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s;
    }
    .ec-login-link:hover {
        color: var(--reg-primary-hover);
        text-decoration: underline;
    }

    /* ── Sidebar Cards Styling ── */
    .ec-reg-preview-card {
        background: #ffffff;
        border: 1px solid var(--reg-border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--reg-shadow);
    }
    .ec-reg-preview-card__browser-bar {
        background: #f1f5f9;
        padding: 10px 14px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .browser-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }
    .browser-dot--red { background: #ef4444; }
    .browser-dot--yellow { background: #f59e0b; }
    .browser-dot--green { background: #10b981; }
    .browser-url-pill {
        flex: 1;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.78rem;
        margin-left: 6px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .ec-reg-preview-card__body {
        padding: 18px 20px;
    }
    .preview-school-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .preview-school-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: var(--reg-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .preview-school-name {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
    }
    .preview-status-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
    }
    .badge-status {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 500;
    }
    .badge-online {
        background: #ecfdf5;
        color: #059669;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
        border: 1px solid #a7f3d0;
    }

    /* Selected Package Card */
    .ec-reg-pkg-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);
    }
    .ec-reg-pkg-card__tag {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }
    .ec-reg-pkg-card__name {
        color: #ffffff;
        font-weight: 800;
        font-size: 1.2rem;
    }
    .ec-reg-pkg-card__price-row {
        margin: 12px 0 14px;
        display: flex;
        align-items: baseline;
        gap: 3px;
    }
    .pkg-currency {
        font-size: 1.2rem;
        font-weight: 700;
        color: #f59e0b;
    }
    .pkg-amount {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
    }
    .pkg-period {
        color: #94a3b8;
        font-size: 0.85rem;
    }
    .ec-reg-pkg-card__features {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.84rem;
        color: #cbd5e1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .ec-reg-pkg-card__features li {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Trust Box */
    .ec-reg-trust-box {
        background: #ffffff;
        border: 1px solid var(--reg-border);
        border-radius: 14px;
        padding: 20px;
    }
    .ec-reg-trust-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 14px;
    }
    .trust-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.84rem;
        color: #475569;
        margin-bottom: 12px;
    }
    .trust-item:last-child { margin-bottom: 0; }
    .trust-icon {
        width: 26px;
        height: 26px;
        background: #eff6ff;
        color: var(--reg-primary);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Helpline Callout */
    .ec-reg-helpline {
        background: #ffffff;
        border: 1px solid var(--reg-border);
        border-radius: 14px;
        padding: 16px 18px;
    }
    .helpline-icon {
        width: 40px;
        height: 40px;
        background: #ecfdf5;
        color: #059669;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .helpline-link {
        font-size: 1.05rem;
        text-decoration: none;
    }
    .helpline-link:hover {
        color: var(--reg-primary) !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .ec-reg-hero {
            padding: 28px 0 16px;
        }
        .ec-reg-hero__title {
            font-size: 1.55rem;
            line-height: 1.35;
        }
        .ec-reg-hero__subtitle {
            font-size: 0.88rem;
            line-height: 1.5;
        }
        .ec-reg-card {
            padding: 20px 14px;
            border-radius: 14px;
        }
        .form-section-card {
            padding: 16px 12px;
            border-radius: 11px;
        }
        .form-section-header {
            margin-bottom: 16px;
            padding-bottom: 12px;
            gap: 10px;
        }
        .form-section-step {
            width: 32px;
            height: 32px;
            font-size: 0.95rem;
            border-radius: 8px;
        }
        .form-section-title {
            font-size: 1.05rem;
        }
        .form-section-desc {
            font-size: 0.78rem;
        }
        .ec-field-label {
            font-size: 0.84rem;
            margin-bottom: 5px;
        }
        .ec-input, .ec-select, .ec-textarea {
            padding: 10px 12px 10px 38px;
            font-size: 0.92rem;
            border-radius: 9px;
        }
        .ec-input-icon {
            left: 12px;
            font-size: 1rem;
        }
        .ec-input-icon--top {
            top: 12px;
        }
        .subdomain-suffix {
            font-size: 0.78rem;
            padding: 10px 10px;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ec-subdomain-input {
            padding: 10px 10px;
            font-size: 0.9rem;
        }
        .ec-reg-submit-btn {
            padding: 13px 20px;
            font-size: 0.98rem;
        }
    }
</style>
@endpush

{{-- ════════ JAVASCRIPT: Dynamic Interactivity & Validation ════════ --}}
@push('custom-js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const host = "{{ request()->getHost() }}";

    // ── 1. School Name & Subdomain Real-time Preview ──
    const schoolNameInput = document.getElementById('school_name');
    const previewSchoolName = document.getElementById('previewSchoolName');
    const slugInput = document.getElementById('slug');
    const previewUrl = document.getElementById('preview-url');
    const previewSubdomain = document.getElementById('previewSubdomain');

    if (schoolNameInput && previewSchoolName) {
        schoolNameInput.addEventListener('input', function () {
            previewSchoolName.textContent = this.value.trim() || 'আপনার প্রতিষ্ঠানের নাম';
        });
    }

    if (slugInput) {
        slugInput.addEventListener('input', function () {
            // Keep only a-z, 0-9
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
            const val = this.value || 'yourschool';
            if (previewUrl) previewUrl.textContent = `${val}.${host}`;
            if (previewSubdomain) previewSubdomain.textContent = val;
        });
        // Initial trigger
        if (slugInput.value) {
            slugInput.dispatchEvent(new Event('input'));
        }
    }

    // ── 2. Location Selectors (Division -> District -> Upazila) ──
    const divisionSelect = document.getElementById('division');
    const districtSelect = document.getElementById('district');
    const upazilaSelect  = document.getElementById('upazila');
    const previewLocation = document.getElementById('previewLocation');

    const oldDivision = @json(old('division'));
    const oldDistrict = @json(old('district'));
    const oldUpazila  = @json(old('upazila'));

    const updateLocationPreview = () => {
        if (!previewLocation) return;
        const dVal = districtSelect.value;
        const divVal = divisionSelect.value;
        if (dVal && divVal) {
            previewLocation.textContent = `${dVal}, ${divVal}`;
        } else if (divVal) {
            previewLocation.textContent = divVal;
        } else {
            previewLocation.textContent = 'বিভাগ, জেলা';
        }
    };

    const resetSelect = (select, placeholder) => {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    };

    const fillSelect = (select, items, key, placeholder, selected) => {
        resetSelect(select, placeholder);
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item[key];
            option.textContent = item[`${key}_bn`] || item[key];
            if (option.value === selected) {
                option.selected = true;
            }
            select.appendChild(option);
        });
        select.disabled = false;
    };

    const fetchJson = (url) => fetch(url).then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
    });

    // Load Divisions
    fetchJson(@json(route('locations.divisions'))).then(data => {
        fillSelect(divisionSelect, data, 'name', 'বিভাগ নির্বাচন করুন', oldDivision);
        if (oldDivision) {
            divisionSelect.dispatchEvent(new Event('change'));
        }
    }).catch(() => {
        divisionSelect.innerHTML = '<option value="">বিভাগ লোড করা যায়নি</option>';
    });

    // Division Changed -> Load Districts
    divisionSelect.addEventListener('change', function () {
        resetSelect(districtSelect, 'জেলা নির্বাচন করুন');
        resetSelect(upazilaSelect, 'উপজেলা নির্বাচন করুন');
        updateLocationPreview();
        if (!this.value) return;

        fetchJson(`${@json(url('/locations/districts'))}/${encodeURIComponent(this.value)}`).then(data => {
            fillSelect(districtSelect, data, 'name', 'জেলা নির্বাচন করুন', oldDistrict);
            if (oldDistrict) {
                districtSelect.dispatchEvent(new Event('change'));
            }
        });
    });

    // District Changed -> Load Upazilas
    districtSelect.addEventListener('change', function () {
        resetSelect(upazilaSelect, 'উপজেলা নির্বাচন করুন');
        updateLocationPreview();
        if (!this.value) return;

        fetchJson(`${@json(url('/locations/upazilas'))}/${encodeURIComponent(this.value)}`).then(data => {
            fillSelect(upazilaSelect, data, 'name', 'উপজেলা নির্বাচন করুন', oldUpazila);
        });
    });

    upazilaSelect.addEventListener('change', updateLocationPreview);

    // ── 3. Package Radio Selection & Live Preview ──
    const pkgRadios = document.querySelectorAll('.ec-pkg-radio-input');
    const previewPkgName   = document.getElementById('previewPkgName');
    const previewPkgPrice  = document.getElementById('previewPkgPrice');
    const previewPkgPeriod = document.getElementById('previewPkgPeriod');
    const previewPkgLimit  = document.getElementById('previewPkgLimit');

    function updatePackageCard(radio) {
        if (!radio) return;
        document.querySelectorAll('.ec-pkg-radio-card').forEach(card => card.classList.remove('is-selected'));
        const parentLabel = radio.closest('.ec-pkg-radio-card');
        if (parentLabel) parentLabel.classList.add('is-selected');

        if (previewPkgName) previewPkgName.textContent = radio.dataset.name || 'প্যাকেজ';
        if (previewPkgPrice) previewPkgPrice.textContent = radio.dataset.price || '০';
        if (previewPkgPeriod) previewPkgPeriod.textContent = radio.dataset.duration || '';
        if (previewPkgLimit) previewPkgLimit.textContent = radio.dataset.students || 'সকল মূল ফিচার';
    }

    pkgRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) updatePackageCard(this);
        });
    });

    // Initial check for selected radio
    const checkedRadio = document.querySelector('.ec-pkg-radio-input:checked') || pkgRadios[0];
    if (checkedRadio) {
        checkedRadio.checked = true;
        updatePackageCard(checkedRadio);
    }

    // ── 4. Mobile Phone (11 Digits) Live Validation ──
    const phoneInput = document.getElementById('admin_phone');
    const phoneBadge = document.getElementById('phoneBadge');
    const phoneHint  = document.getElementById('phoneHint');
    const bdPhoneRegex = /^01[3-9]\d{8}$/;

    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            // Numbers only
            this.value = this.value.replace(/[^0-9]/g, '');
            const val = this.value;

            if (val.length === 11 && bdPhoneRegex.test(val)) {
                if (phoneBadge) phoneBadge.style.display = 'block';
                if (phoneHint) {
                    phoneHint.textContent = '✓ সঠিক মোবাইল নম্বর দেওয়া হয়েছে';
                    phoneHint.className = 'text-success d-block mt-1 fw-medium';
                }
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.add('is-valid');
            } else if (val.length > 0) {
                if (phoneBadge) phoneBadge.style.display = 'none';
                if (phoneHint) {
                    phoneHint.textContent = `১১ ডিজিটের সঠিক নম্বর লিখুন (${val.length}/১১)`;
                    phoneHint.className = 'text-muted d-block mt-1';
                }
                phoneInput.classList.remove('is-valid');
            } else {
                if (phoneBadge) phoneBadge.style.display = 'none';
                if (phoneHint) {
                    phoneHint.textContent = 'সঠিক ১১ ডিজিটের মোবাইল নম্বর লিখুন (উদাঃ 017XXXXXXXX)';
                    phoneHint.className = 'text-muted d-block mt-1';
                }
                phoneInput.classList.remove('is-valid', 'is-invalid');
            }
        });

        if (phoneInput.value) {
            phoneInput.dispatchEvent(new Event('input'));
        }
    }

    // ── 5. Password Visibility Toggle ──
    const togglePwBtn = document.getElementById('togglePassword');
    const pwInput     = document.getElementById('admin_password');
    const toggleIcon  = document.getElementById('toggleIcon');

    if (togglePwBtn && pwInput && toggleIcon) {
        togglePwBtn.addEventListener('click', function () {
            const isPassword = pwInput.getAttribute('type') === 'password';
            pwInput.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    // ── 6. Form Submit Button Loading State ──
    const regForm   = document.getElementById('schoolRegisterForm');
    const submitBtn = document.getElementById('submitBtn');

    if (regForm && submitBtn) {
        regForm.addEventListener('submit', function (e) {
            // Check validity
            if (!this.checkValidity()) return;

            const btnText = submitBtn.querySelector('.btn-text');
            const btnSpinner = submitBtn.querySelector('.btn-spinner');
            if (btnText && btnSpinner) {
                btnText.style.display = 'none';
                btnSpinner.style.display = 'inline-flex';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush