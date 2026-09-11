@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.subscription-packages.index') }}">Packages</a></li>
        <li><span>/</span></li>
        <li class="active">Create Package</li>
    </ul>

    {{-- ===== HERO HEADER ===== --}}
    <div class="pkg-hero">
        <div class="pkg-hero-left">
            <div class="pkg-hero-icon">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <h2 class="pkg-hero-title">New Subscription Plan</h2>
                <p class="pkg-hero-sub">Define pricing tiers, resource limits & commission rules</p>
            </div>
        </div>
        <a href="{{ route('super.subscription-packages.index') }}" class="pkg-back-btn">
            <i class="fa-solid fa-arrow-left me-2"></i>
            <span class="d-none d-sm-inline">Back to Packages</span>
            <span class="d-sm-none">Back</span>
        </a>
    </div>

    {{-- ===== STEP INDICATOR ===== --}}
    <div class="pkg-steps">
        <div class="pkg-step active">
            <div class="pkg-step-dot">1</div>
            <span>Identity</span>
        </div>
        <div class="pkg-step-line"></div>
        <div class="pkg-step active">
            <div class="pkg-step-dot">2</div>
            <span>Pricing</span>
        </div>
        <div class="pkg-step-line"></div>
        <div class="pkg-step active">
            <div class="pkg-step-dot">3</div>
            <span>Commission</span>
        </div>
        <div class="pkg-step-line"></div>
        <div class="pkg-step active">
            <div class="pkg-step-dot">4</div>
            <span>Modules</span>
        </div>
        <div class="pkg-step-line"></div>
        <div class="pkg-step active">
            <div class="pkg-step-dot">5</div>
            <span>Publish</span>
        </div>
    </div>

    @if($errors->any())
    <div class="pkg-error-alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li style="font-size:0.82rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('super.subscription-packages.store') }}" method="POST" id="createPackageForm">
        @csrf
        <div class="row g-4">

            {{-- ===== LEFT: Main Form ===== --}}
            <div class="col-lg-8">

                {{-- Section 1: Package Identity --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#4f46e5,#818cf8);">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Package Identity</h6>
                            <p class="pkg-section-sub">Name, description and billing cycle</p>
                        </div>
                        <span class="pkg-step-badge">Step 1</span>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="edu-label">Package Name <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa-solid fa-box input-icon-left text-indigo"></i>
                                    <input type="text" name="name" id="pkgName"
                                        class="form-control edu-input ps-input-icon @error('name') is-invalid @enderror"
                                        placeholder="e.g. Premium Pro"
                                        value="{{ old('name') }}"
                                        oninput="updatePreview()" required>
                                </div>
                                @error('name')<div class="pkg-field-err">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-5">
                                <label class="edu-label">Billing Cycle <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa-solid fa-calendar-days input-icon-left text-indigo"></i>
                                    <select name="duration" id="pkgDuration" class="form-select edu-input ps-input-icon" oninput="updatePreview()" required>
                                        <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly"  {{ old('duration') == 'yearly'  ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="edu-label">Short Description <span class="text-muted fw-normal" style="font-size:0.78rem;">(optional)</span></label>
                                <textarea name="description" id="pkgDesc" class="form-control edu-input" rows="2"
                                    placeholder="Briefly describe this plan..." oninput="updatePreview()">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Pricing & Limits --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#059669,#34d399);">
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Pricing & Limits</h6>
                            <p class="pkg-section-sub">Set price and resource quotas — leave blank for unlimited</p>
                        </div>
                        <span class="pkg-step-badge" style="background:#dcfce7;color:#059669;">Step 2</span>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-sm-4">
                                <label class="edu-label">Price (৳) <span class="text-danger">*</span></label>
                                <div class="input-group pkg-price-group">
                                    <span class="input-group-text pkg-currency">৳</span>
                                    <input type="number" step="0.01" min="0" name="price" id="pkgPrice"
                                        class="form-control edu-input @error('price') is-invalid @enderror"
                                        placeholder="0.00"
                                        value="{{ old('price', '0') }}"
                                        oninput="updatePreview()" required>
                                </div>
                                <div id="freePackageHint" class="pkg-free-hint mt-2" style="display:none;">
                                    <i class="fa-solid fa-circle-check me-1"></i>
                                    <strong>Free Package</strong> — no payment required
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="edu-label">
                                    <i class="fa-solid fa-user-graduate me-1 text-muted" style="font-size:11px;"></i> Student Limit
                                </label>
                                <input type="number" name="student_limit" class="form-control edu-input"
                                    placeholder="Unlimited" value="{{ old('student_limit') }}">
                                <div class="pkg-field-hint">Leave empty for unlimited</div>
                            </div>
                            <div class="col-sm-4">
                                <label class="edu-label">
                                    <i class="fa-solid fa-chalkboard-user me-1 text-muted" style="font-size:11px;"></i> Teacher Limit
                                </label>
                                <input type="number" name="teacher_limit" class="form-control edu-input"
                                    placeholder="Unlimited" value="{{ old('teacher_limit') }}">
                                <div class="pkg-field-hint">Leave empty for unlimited</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Commission Setup --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">প্রতিনিধি কমিশন সেটিংস</h6>
                            <p class="pkg-section-sub">নতুন স্কুল রেজিস্ট্রেশন ও মাসিক রিকারিং কমিশন নির্ধারণ করুন</p>
                        </div>
                        <span class="pkg-step-badge" style="background:#ede9fe;color:#6366f1;">Step 3</span>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3">
                            {{-- 1. Registration Commission --}}
                            <div class="col-md-6">
                                <div class="pkg-comm-card">
                                    <div class="pkg-comm-badge" style="background:#4f46e5;">
                                        <i class="fa-solid fa-flag-checkered me-1"></i> রেজিস্ট্রেশন কমিশন
                                        <span class="pkg-comm-tag">এককালীন</span>
                                    </div>
                                    <p class="pkg-comm-desc">নতুন কোনো স্কুল এই প্যাকেজে নিবন্ধিত হলে প্রতিনিধিকে এই কমিশন দেওয়া হবে।</p>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="edu-label">কমিশন টাইপ</label>
                                            <select name="registration_commission_type" class="form-select edu-input">
                                                <option value="flat" {{ old('registration_commission_type', 'flat') == 'flat' ? 'selected' : '' }}>ফ্ল্যাট (৳)</option>
                                                <option value="percentage" {{ old('registration_commission_type') == 'percentage' ? 'selected' : '' }}>শতাংশ (%)</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="edu-label">রেট / পরিমাণ</label>
                                            <input type="number" step="0.01" min="0" name="registration_commission_rate"
                                                class="form-control edu-input"
                                                placeholder="500 বা 10"
                                                value="{{ old('registration_commission_rate', '0') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. Monthly Commission --}}
                            <div class="col-md-6">
                                <div class="pkg-comm-card" style="border-color:#bbf7d0;">
                                    <div class="pkg-comm-badge" style="background:#059669;">
                                        <i class="fa-solid fa-rotate me-1"></i> মাসিক রিকারিং কমিশন
                                        <span class="pkg-comm-tag" style="background:rgba(255,255,255,0.25);">প্রতি মাসে</span>
                                    </div>
                                    <p class="pkg-comm-desc">এই প্যাকেজধারী স্কুলের সাবস্ক্রিপশন সচল থাকলে প্রতিনিধি প্রতি মাসে এই কমিশন পাবেন।</p>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="edu-label">কমিশন টাইপ</label>
                                            <select name="monthly_commission_type" class="form-select edu-input">
                                                <option value="flat" {{ old('monthly_commission_type', 'flat') == 'flat' ? 'selected' : '' }}>ফ্ল্যাট (৳)</option>
                                                <option value="percentage" {{ old('monthly_commission_type') == 'percentage' ? 'selected' : '' }}>শতাংশ (%)</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="edu-label">রেট / পরিমাণ</label>
                                            <input type="number" step="0.01" min="0" name="monthly_commission_rate"
                                                class="form-control edu-input"
                                                placeholder="100 বা 5"
                                                value="{{ old('monthly_commission_rate', '0') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 4: Key Features --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#d97706,#fbbf24);">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Key Features</h6>
                            <p class="pkg-section-sub">Bullet points shown on pricing page — one feature per line</p>
                        </div>
                    </div>
                    <div class="pkg-section-body">
                        <textarea name="features_list" id="pkgFeatures" class="form-control edu-input" rows="5"
                            placeholder="Live Classes&#10;Exam Management&#10;Auto Attendance&#10;Fee Management&#10;Progress Reports"
                            oninput="updatePreview()">{{ old('features_list') }}</textarea>
                        <div class="pkg-field-hint mt-2">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                            Each line will appear as a ✓ bullet on the pricing page
                        </div>
                    </div>
                </div>

                {{-- Section 5: Module Permissions --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Module Permissions</h6>
                            <p class="pkg-section-sub">Select which modules schools on this plan can access</p>
                        </div>
                        <span class="pkg-step-badge" style="background:#ede9fe;color:#7c3aed;">Step 4</span>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3">
                            @foreach(config('permissions.permissions') as $group => $perms)
                                @if($group != 'SaaS Management (Super Admin/Employee Only)')
                                <div class="col-12">
                                    <div class="perm-group">
                                        <div class="perm-group-header">
                                            <i class="fa-solid fa-layer-group me-2"></i>{{ $group }}
                                            <button type="button" class="perm-toggle-all btn btn-xs ms-auto"
                                                onclick="toggleGroup(this)" data-state="0">
                                                Select All
                                            </button>
                                        </div>
                                        <div class="perm-group-body d-flex flex-wrap gap-2">
                                            @foreach($perms as $slug => $label)
                                            @php
                                                $isDefault = in_array($slug, ['system.settings', 'notice.manage', 'academic-year.manage', 'profile.manage']);
                                            @endphp
                                            <label class="perm-chip {{ $isDefault ? 'perm-chip-locked' : '' }}"
                                                for="perm_{{ Str::slug($slug) }}">
                                                <input class="perm-chip-input" type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $slug }}"
                                                    id="perm_{{ Str::slug($slug) }}"
                                                    {{ ($isDefault || (is_array(old('permissions')) && in_array($slug, old('permissions')))) ? 'checked' : '' }}
                                                    {{ $isDefault ? 'disabled' : '' }}>
                                                <span class="perm-chip-label">
                                                    {{ $label }}
                                                    @if($isDefault)
                                                        <i class="fa-solid fa-lock ms-1" style="font-size:9px; opacity:0.6;"></i>
                                                    @endif
                                                </span>
                                            </label>
                                            @if($isDefault)
                                                <input type="hidden" name="permissions[]" value="{{ $slug }}">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Section 6: Visibility --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#0ea5e9,#38bdf8);">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Visibility & Badge</h6>
                            <p class="pkg-section-sub">Control how the package appears on the pricing page</p>
                        </div>
                        <span class="pkg-step-badge" style="background:#e0f2fe;color:#0ea5e9;">Step 5</span>
                    </div>
                    <div class="pkg-section-body">
                        <div class="pkg-toggle-grid">
                            <label class="pkg-toggle-card" for="isPopular">
                                <input type="checkbox" name="is_popular" id="isPopular"
                                    class="pkg-toggle-input" onchange="updatePreview()" {{ old('is_popular') ? 'checked' : '' }}>
                                <div class="pkg-toggle-body">
                                    <div class="pkg-toggle-icon" style="background:#fef3c7; color:#d97706;">
                                        <i class="fa-solid fa-fire-flame-curved"></i>
                                    </div>
                                    <div>
                                        <div class="pkg-toggle-title">Most Popular Badge</div>
                                        <div class="pkg-toggle-sub">Highlights this plan with a "Most Popular" ribbon</div>
                                    </div>
                                    <div class="pkg-toggle-check ms-auto">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </label>
                            <label class="pkg-toggle-card" for="isActive">
                                <input type="checkbox" name="is_active" id="isActive"
                                    class="pkg-toggle-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                <div class="pkg-toggle-body">
                                    <div class="pkg-toggle-icon" style="background:#dcfce7; color:#16a34a;">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <div>
                                        <div class="pkg-toggle-title">Publish Package</div>
                                        <div class="pkg-toggle-sub">Make this package visible to schools</div>
                                    </div>
                                    <div class="pkg-toggle-check ms-auto">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== RIGHT: Live Preview ===== --}}
            <div class="col-lg-4 d-none d-lg-block">
                <div class="pkg-preview-sticky">
                    <div class="pkg-preview-label">
                        <i class="fa-solid fa-eye me-1"></i> Live Preview
                    </div>
                    <div class="pkg-preview-card" id="previewCard">
                        <div class="pkg-preview-popular-tag" id="previewPopularTag" style="display:none;">Most Popular</div>

                        <div class="pkg-preview-name" id="previewName">Package Name</div>
                        <div class="pkg-preview-desc" id="previewDesc">Your short description will appear here...</div>

                        <div class="pkg-preview-price-wrap">
                            <span class="pkg-preview-price" id="previewPrice">
                                <span id="previewFreeLabel" style="display:none;" class="pkg-free-badge">FREE</span>
                                <span id="previewPriceAmount">৳0</span>
                            </span>
                            <span class="pkg-preview-period" id="previewPeriod">/monthly</span>
                        </div>

                        <div class="pkg-preview-divider"></div>

                        <ul class="pkg-preview-features" id="previewFeatures">
                            <li class="pkg-preview-feat-item text-muted fst-italic">
                                Add features above to see them here...
                            </li>
                        </ul>

                        <button type="button" class="pkg-preview-btn" id="previewBtn">
                            <i class="fa-solid fa-arrow-up me-1"></i> Upgrade Now
                        </button>
                    </div>

                    {{-- Quick Tips --}}
                    <div class="pkg-tips">
                        <div class="pkg-tips-title"><i class="fa-solid fa-lightbulb me-1"></i> Quick Tips</div>
                        <ul class="pkg-tips-list">
                            <li>Set price to <strong>0</strong> for a free plan</li>
                            <li>Leave limits blank for unlimited access</li>
                            <li>Enable "Most Popular" to highlight this plan</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== STICKY BOTTOM ACTION BAR ===== --}}
        <div class="pkg-action-bar">
            <div class="pkg-action-inner">
                <a href="{{ route('super.subscription-packages.index') }}" class="pkg-cancel-btn">
                    <i class="fa-solid fa-xmark me-1"></i>
                    <span class="d-none d-sm-inline">Cancel</span>
                    <span class="d-sm-none">Cancel</span>
                </a>
                <button type="reset" class="pkg-reset-btn">
                    <i class="fa-solid fa-rotate-left me-1"></i>
                    <span class="d-none d-sm-inline">Reset</span>
                </button>
                <button type="submit" class="pkg-create-btn">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    <span>Create Package</span>
                </button>
            </div>
        </div>

    </form>
</div>

<style>
/* ===== HERO HEADER ===== */
.pkg-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.pkg-hero-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pkg-hero-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    box-shadow: 0 6px 16px rgba(79,70,229,0.3);
    flex-shrink: 0;
}
.pkg-hero-title {
    font-family: 'Outfit', sans-serif;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    font-size: 1.4rem;
}
.pkg-hero-sub { color: #64748b; font-size: 0.85rem; margin: 2px 0 0; }
.pkg-back-btn {
    display: inline-flex;
    align-items: center;
    background: transparent;
    border: 2px solid #e2e8f0;
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
}
.pkg-back-btn:hover { border-color: #4f46e5; color: #4f46e5; }

/* ===== STEP INDICATOR ===== */
.pkg-steps {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 24px;
    overflow-x: auto;
    padding-bottom: 4px;
}
.pkg-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}
.pkg-step-dot {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.pkg-step.active .pkg-step-dot {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    box-shadow: 0 3px 8px rgba(79,70,229,0.3);
}
.pkg-step span {
    font-size: 0.68rem;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.pkg-step.active span { color: #4f46e5; }
.pkg-step-line {
    height: 2px;
    width: 32px;
    background: linear-gradient(90deg, #4f46e5, #c7d2fe);
    margin-bottom: 16px;
    flex-shrink: 0;
}
@media (max-width: 480px) {
    .pkg-step span { display: none; }
    .pkg-step-line { width: 20px; }
}

/* ===== ERROR ALERT ===== */
.pkg-error-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 14px 16px;
    color: #b91c1c;
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

/* ===== SECTION CARDS ===== */
.pkg-section {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
    transition: box-shadow .25s, transform .25s;
}
.pkg-section:hover { box-shadow: 0 6px 20px rgba(79,70,229,.08); }

.pkg-section-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #fafbff, #f8fafc);
}
.pkg-section-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
    box-shadow: 0 3px 8px rgba(0,0,0,0.12);
}
.pkg-section-title { font-weight: 700; color: #1e293b; margin: 0; font-size: 14px; }
.pkg-section-sub   { color: #64748b; margin: 0; font-size: 12px; }
.pkg-section-body  { padding: 20px; }
.pkg-step-badge {
    margin-left: auto;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
    background: #eef2ff;
    color: #4f46e5;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ===== FIELD HELPERS ===== */
.pkg-field-hint {
    font-size: 0.72rem;
    color: #94a3b8;
    margin-top: 4px;
}
.pkg-field-err {
    font-size: 0.75rem;
    color: #ef4444;
    margin-top: 4px;
}

/* ===== INPUT ICON ===== */
.input-icon-wrap { position: relative; }
.input-icon-left  { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; z-index:5; }
.ps-input-icon    { padding-left: 36px !important; }
.text-indigo { color: #4f46e5; }

/* ===== PRICE INPUT ===== */
.pkg-price-group .input-group-text.pkg-currency {
    background: linear-gradient(135deg,#4f46e5,#818cf8);
    color: #fff;
    font-weight: 700;
    border: none;
    border-radius: 10px 0 0 10px;
    font-size: 1rem;
}
.pkg-price-group .form-control {
    border-radius: 0 10px 10px 0 !important;
    font-size: 1.1rem;
    font-weight: 600;
}

/* ===== FREE HINT ===== */
.pkg-free-hint {
    background: #dcfce7;
    color: #15803d;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-left: 3px solid #22c55e;
}

/* ===== COMMISSION CARDS ===== */
.pkg-comm-card {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.pkg-comm-card:hover { border-color: #c7d2fe; box-shadow: 0 4px 12px rgba(79,70,229,0.08); }
.pkg-comm-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 8px;
}
.pkg-comm-tag {
    background: rgba(255,255,255,0.2);
    padding: 1px 6px;
    border-radius: 10px;
    font-size: 0.65rem;
}
.pkg-comm-desc {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 12px;
    line-height: 1.5;
}

/* ===== PERMISSIONS ===== */
.perm-group {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}
.perm-group-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 10px 16px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #475569;
    display: flex;
    align-items: center;
}
.perm-toggle-all {
    font-size: 10px;
    padding: 2px 10px;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    background: #fff;
    color: #475569;
    cursor: pointer;
    transition: all .15s;
}
.perm-toggle-all:hover { background: #4f46e5; color: #fff; border-color: #4f46e5; }
.perm-group-body { padding: 12px 16px; gap: 8px !important; }
.perm-chip { cursor: pointer; }
.perm-chip-input { display: none; }
.perm-chip-label {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    font-size: 12px;
    color: #475569;
    background: #f8fafc;
    transition: all .15s;
    user-select: none;
    cursor: pointer;
}
.perm-chip-input:checked + .perm-chip-label {
    background: #eef2ff;
    border-color: #4f46e5;
    color: #4f46e5;
    font-weight: 600;
}
.perm-chip-input:checked + .perm-chip-label::before { content: "✓ "; font-weight: 700; }
.perm-chip-locked .perm-chip-label {
    background: #fef3c7;
    border-color: #fbbf24;
    color: #92400e;
    cursor: not-allowed;
}

/* ===== TOGGLE GRID ===== */
.pkg-toggle-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 576px) { .pkg-toggle-grid { grid-template-columns: 1fr; } }
.pkg-toggle-card { cursor: pointer; }
.pkg-toggle-input { display: none; }
.pkg-toggle-body {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: #f8fafc;
    transition: all .2s;
}
.pkg-toggle-input:checked ~ .pkg-toggle-body {
    border-color: #4f46e5;
    background: #eef2ff;
    box-shadow: 0 0 0 3px rgba(79,70,229,.08);
}
.pkg-toggle-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.pkg-toggle-title { font-size: 13px; font-weight: 700; color: #1e293b; }
.pkg-toggle-sub   { font-size: 11px; color: #64748b; }
.pkg-toggle-check {
    width: 20px; height: 20px;
    border-radius: 50%;
    border: 2px solid #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px;
    color: transparent;
    transition: all .2s;
}
.pkg-toggle-input:checked ~ .pkg-toggle-body .pkg-toggle-check {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
}

/* ===== LIVE PREVIEW ===== */
.pkg-preview-sticky { position: sticky; top: 90px; }
.pkg-preview-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #94a3b8;
    margin-bottom: 10px;
    padding-left: 2px;
}
.pkg-preview-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 8px 32px rgba(79,70,229,.10);
    position: relative;
    overflow: hidden;
    margin-bottom: 16px;
}
.pkg-preview-popular-tag {
    position: absolute;
    top: 18px; right: -32px;
    background: linear-gradient(135deg,#4f46e5,#818cf8);
    color: #fff;
    padding: 4px 40px;
    transform: rotate(45deg);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .5px;
}
.pkg-preview-name { font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 4px; font-family: 'Outfit', sans-serif; }
.pkg-preview-desc { font-size: 12px; color: #94a3b8; margin-bottom: 16px; min-height: 30px; }
.pkg-preview-price-wrap { display: flex; align-items: baseline; gap: 4px; margin-bottom: 6px; }
.pkg-preview-price { font-size: 28px; font-weight: 800; color: #4f46e5; line-height: 1; }
.pkg-free-badge {
    background: linear-gradient(135deg,#059669,#34d399);
    color: #fff;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 16px;
    font-weight: 800;
}
.pkg-preview-period { font-size: 12px; color: #94a3b8; }
.pkg-preview-divider { height: 1px; background: #f1f5f9; margin: 14px 0; }
.pkg-preview-features { list-style: none; padding: 0; margin: 0 0 16px; }
.pkg-preview-feat-item {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12px; color: #475569; margin-bottom: 7px;
}
.pkg-preview-feat-item::before {
    content: '✓';
    width: 16px; height: 16px;
    background: #dcfce7; color: #16a34a;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; font-weight: 800; flex-shrink: 0; margin-top: 1px;
}
.pkg-preview-btn {
    width: 100%; padding: 11px;
    background: linear-gradient(135deg,#4f46e5,#818cf8);
    color: #fff; border: none; border-radius: 10px;
    font-weight: 700; font-size: 13px; cursor: default;
}

/* ===== TIPS BOX ===== */
.pkg-tips {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 14px 16px;
}
.pkg-tips-title {
    font-size: 12px;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 8px;
}
.pkg-tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.pkg-tips-list li {
    font-size: 11px;
    color: #78350f;
    padding: 3px 0;
    display: flex;
    align-items: flex-start;
    gap: 6px;
}
.pkg-tips-list li::before {
    content: '→';
    font-weight: 700;
    color: #d97706;
    flex-shrink: 0;
}

/* ===== STICKY ACTION BAR ===== */
.pkg-action-bar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-top: 1px solid #e2e8f0;
    z-index: 1050;
    padding: 10px 16px;
    box-shadow: 0 -4px 24px rgba(79,70,229,.08);
}
.pkg-action-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
}

/* Cancel */
.pkg-cancel-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 8px 16px;
    border: 2px solid #cbd5e1;
    border-radius: 10px;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    background: transparent;
    transition: all .2s;
    white-space: nowrap;
}
.pkg-cancel-btn:hover { border-color: #94a3b8; color: #1e293b; }

/* Reset */
.pkg-reset-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 8px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    color: #94a3b8;
    font-size: 12px;
    font-weight: 600;
    background: transparent;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
}
.pkg-reset-btn:hover { border-color: #94a3b8; color: #64748b; }

/* Create / Submit */
.pkg-create-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 22px;
    background: transparent;
    color: #4f46e5;
    border: 2px solid #4f46e5;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all .2s;
    letter-spacing: .2px;
    white-space: nowrap;
}
.pkg-create-btn:hover {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    border-color: transparent;
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(79,70,229,.3);
}
.pkg-create-btn:active { transform: translateY(0); }

/* Mobile action bar */
@media (max-width: 575px) {
    .pkg-action-bar { padding: 8px 12px; }
    .pkg-action-inner { gap: 6px; width: 100%; }
    .pkg-cancel-btn { flex: 1; justify-content: center; padding: 8px 8px; font-size: 12px; }
    .pkg-reset-btn  { padding: 8px 10px; font-size: 11px; }
    .pkg-create-btn { flex: 2; justify-content: center; padding: 8px 8px; font-size: 12px; }
}

/* Spacer */
.page-content { padding-bottom: 80px !important; }
</style>

<script>
function updatePreview() {
    const name     = document.getElementById('pkgName')?.value || '';
    const desc     = document.getElementById('pkgDesc')?.value || '';
    const price    = parseFloat(document.getElementById('pkgPrice')?.value) || 0;
    const duration = document.getElementById('pkgDuration')?.value || 'monthly';
    const isPop    = document.getElementById('isPopular')?.checked || false;

    const previewName = document.getElementById('previewName');
    const previewDesc = document.getElementById('previewDesc');
    const previewPeriod = document.getElementById('previewPeriod');
    if (previewName) previewName.textContent = name || 'Package Name';
    if (previewDesc) previewDesc.textContent = desc || 'Your short description will appear here...';
    if (previewPeriod) previewPeriod.textContent = '/' + duration;

    const popTag = document.getElementById('previewPopularTag');
    if (popTag) popTag.style.display = isPop ? 'block' : 'none';

    const freeLabel   = document.getElementById('previewFreeLabel');
    const priceAmount = document.getElementById('previewPriceAmount');
    const freeHint    = document.getElementById('freePackageHint');
    const previewBtn  = document.getElementById('previewBtn');

    if (price === 0) {
        if (freeLabel) freeLabel.style.display = 'inline-block';
        if (priceAmount) priceAmount.style.display = 'none';
        if (freeHint) freeHint.style.display = 'block';
        if (previewBtn) {
            previewBtn.style.background = 'linear-gradient(135deg,#059669,#34d399)';
            previewBtn.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> Activate Free';
        }
    } else {
        if (freeLabel) freeLabel.style.display = 'none';
        if (priceAmount) { priceAmount.style.display = 'inline'; priceAmount.textContent = '৳' + price.toLocaleString('en-BD'); }
        if (freeHint) freeHint.style.display = 'none';
        if (previewBtn) {
            previewBtn.style.background = 'linear-gradient(135deg,#4f46e5,#818cf8)';
            previewBtn.innerHTML = '<i class="fa-solid fa-arrow-up me-1"></i> Upgrade Now';
        }
    }

    // Features
    const featInput = document.getElementById('pkgFeatures')?.value || '';
    const featContainer = document.getElementById('previewFeatures');
    if (featContainer) {
        const lines = featInput.split('\n').map(l => l.trim()).filter(l => l.length > 0);
        featContainer.innerHTML = lines.length > 0
            ? lines.map(line => `<li class="pkg-preview-feat-item">${escapeHtml(line)}</li>`).join('')
            : '<li class="pkg-preview-feat-item text-muted fst-italic">Add features above to see them here...</li>';
    }
}

function escapeHtml(text) {
    return text.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
}

function toggleGroup(btn) {
    const groupBody = btn.closest('.perm-group').querySelector('.perm-group-body');
    const checkboxes = groupBody.querySelectorAll('.perm-chip-input:not(:disabled)');
    const state = parseInt(btn.dataset.state);
    checkboxes.forEach(cb => cb.checked = !state);
    btn.dataset.state = state ? 0 : 1;
    btn.textContent = state ? 'Select All' : 'Deselect All';
}

document.addEventListener('DOMContentLoaded', () => {
    updatePreview();
    document.getElementById('pkgPrice')?.addEventListener('input', updatePreview);
    document.getElementById('isPopular')?.addEventListener('change', updatePreview);
});
</script>
@endsection
