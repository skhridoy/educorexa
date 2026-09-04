@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('super.subscription-packages.index') }}">Packages</a></li>
        <li><span>/</span></li>
        <li class="active">Create Package</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-box-open me-2" style="color:#4f46e5;"></i> New Subscription Plan</h2>
            <p class="edu-page-sub">Define a new pricing tier and resource limits for institutional clients.</p>
        </div>
        <a href="{{ route('super.subscription-packages.index') }}" class="btn-edu btn-edu-light px-4">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Packages
        </a>
    </div>

    <form action="{{ route('super.subscription-packages.store') }}" method="POST" id="createPackageForm">
        @csrf
        <div class="row g-4">

            {{-- ===== LEFT: Main Form ===== --}}
            <div class="col-lg-8">

                {{-- Section 1: Basic Info --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#4f46e5,#818cf8);">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Package Identity</h6>
                            <p class="pkg-section-sub">Name, description and billing cycle</p>
                        </div>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="edu-label">Package Name <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa-solid fa-box input-icon-left text-indigo"></i>
                                    <input type="text" name="name" id="pkgName"
                                        class="form-control edu-input ps-input-icon"
                                        placeholder="e.g. Premium Pro"
                                        value="{{ old('name') }}"
                                        oninput="updatePreview()" required>
                                </div>
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
                                <label class="edu-label">Short Description</label>
                                <textarea name="description" id="pkgDesc" class="form-control edu-input" rows="2"
                                    placeholder="Briefly describe the plan..." oninput="updatePreview()">{{ old('description') }}</textarea>
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
                            <p class="pkg-section-sub">Set price and resource quotas (leave limits blank for unlimited)</p>
                        </div>
                    </div>
                    <div class="pkg-section-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="edu-label">Price (৳) <span class="text-danger">*</span></label>
                                <div class="input-group pkg-price-group">
                                    <span class="input-group-text pkg-currency">৳</span>
                                    <input type="number" step="0.01" min="0" name="price" id="pkgPrice"
                                        class="form-control edu-input"
                                        value="{{ old('price', '0.00') }}"
                                        oninput="updatePreview()" required>
                                </div>
                                <div id="freePackageHint" class="pkg-free-hint mt-2" style="display:none;">
                                    <i class="fa-solid fa-circle-check me-1"></i>
                                    This will be a <strong>Free Package</strong> — no payment required
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="edu-label">
                                    <i class="fa-solid fa-user-graduate me-1 text-muted small"></i> Student Limit
                                </label>
                                <input type="number" name="student_limit" class="form-control edu-input"
                                    placeholder="Unlimited" value="{{ old('student_limit') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="edu-label">
                                    <i class="fa-solid fa-chalkboard-user me-1 text-muted small"></i> Teacher Limit
                                </label>
                                <input type="number" name="teacher_limit" class="form-control edu-input"
                                    placeholder="Unlimited" value="{{ old('teacher_limit') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Features --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#d97706,#fbbf24);">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Key Features</h6>
                            <p class="pkg-section-sub">Bullet points shown on the pricing page (one per line)</p>
                        </div>
                    </div>
                    <div class="pkg-section-body">
                        <textarea name="features_list" class="form-control edu-input" rows="5"
                            placeholder="Live Classes&#10;Exam Management&#10;Auto Attendance&#10;Fee Management">{{ old('features_list') }}</textarea>
                        <small class="text-muted mt-2 d-block">
                            <i class="fa-solid fa-circle-info me-1 text-primary"></i>
                            Each line will appear as a bullet point on the pricing page.
                        </small>
                    </div>
                </div>

                {{-- Section 4: Module Permissions --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Module Permissions</h6>
                            <p class="pkg-section-sub">Select which modules will be accessible with this plan</p>
                        </div>
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
                                                        <i class="fa-solid fa-lock ms-1" style="font-size:9px; opacity:0.7;"></i>
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

                {{-- Section 5: Visibility Options --}}
                <div class="pkg-section mb-4">
                    <div class="pkg-section-header">
                        <div class="pkg-section-icon" style="background:linear-gradient(135deg,#0ea5e9,#38bdf8);">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div>
                            <h6 class="pkg-section-title">Visibility & Badge</h6>
                            <p class="pkg-section-sub">Control how the package appears on the pricing page</p>
                        </div>
                    </div>
                    <div class="pkg-section-body">
                        <div class="d-flex flex-wrap gap-4">
                            <label class="pkg-toggle-card" for="isPopular">
                                <input type="checkbox" name="is_popular" id="isPopular"
                                    class="pkg-toggle-input" {{ old('is_popular') ? 'checked' : '' }}>
                                <div class="pkg-toggle-body">
                                    <div class="pkg-toggle-icon" style="background:#fef3c7; color:#d97706;">
                                        <i class="fa-solid fa-fire-flame-curved"></i>
                                    </div>
                                    <div>
                                        <div class="pkg-toggle-title">Most Popular Badge</div>
                                        <div class="pkg-toggle-sub">Highlights this plan with a "Most Popular" ribbon</div>
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
                                        <div class="pkg-toggle-sub">Make this package visible and selectable by schools</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===== RIGHT: Live Preview ===== --}}
            <div class="col-lg-4">
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
                            <li class="pkg-preview-feat-item text-muted fst-italic" id="previewFeatDefault">
                                Add features above to see them here...
                            </li>
                        </ul>

                        <button type="button" class="pkg-preview-btn" id="previewBtn">
                            <i class="fa-solid fa-arrow-up me-1"></i> Upgrade Now
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== STICKY BOTTOM ACTION BAR ===== --}}
        <div class="pkg-action-bar">
            <div class="pkg-action-inner">
                <a href="{{ route('super.subscription-packages.index') }}" class="pkg-cancel-btn">
                    <i class="fa-solid fa-xmark me-1"></i> Cancel
                </a>
                <button type="submit" class="pkg-create-btn">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Create Package
                </button>
            </div>
        </div>

    </form>
</div>

<style>
/* ========== INPUT ICON WRAPPERS ========== */
.input-icon-wrap { position: relative; }
.input-icon-left  { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; z-index:5; }
.ps-input-icon    { padding-left: 36px !important; }
.text-indigo { color: #4f46e5; }

/* ========== SECTION CARDS ========== */
.pkg-section {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
    transition: box-shadow .2s;
}
.pkg-section:hover { box-shadow: 0 4px 16px rgba(79,70,229,.07); }

.pkg-section-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbff;
}
.pkg-section-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.pkg-section-title { font-weight: 700; color: #1e293b; margin: 0; font-size: 14px; }
.pkg-section-sub   { color: #64748b; margin: 0; font-size: 12px; }
.pkg-section-body  { padding: 22px 24px; }

/* ========== PRICE INPUT ========== */
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

/* ========== FREE HINT ========== */
.pkg-free-hint {
    background: #dcfce7;
    color: #15803d;
    border-radius: 8px;
    padding: 7px 12px;
    font-size: 12px;
    font-weight: 600;
    border-left: 3px solid #22c55e;
}

/* ========== PERMISSIONS ========== */
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
.perm-chip-input:checked + .perm-chip-label::before {
    content: "✓ ";
    font-weight: 700;
}
.perm-chip-locked .perm-chip-label {
    background: #fef3c7;
    border-color: #fbbf24;
    color: #92400e;
    cursor: not-allowed;
}

/* ========== TOGGLE CARDS ========== */
.pkg-toggle-card { cursor: pointer; flex: 1; min-width: 220px; }
.pkg-toggle-input { display: none; }
.pkg-toggle-body {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
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

/* ========== LIVE PREVIEW ========== */
.pkg-preview-sticky {
    position: sticky;
    top: 90px;
}
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
    padding: 28px;
    box-shadow: 0 8px 32px rgba(79,70,229,.10);
    position: relative;
    overflow: hidden;
    transition: box-shadow .3s;
}
.pkg-preview-card:hover { box-shadow: 0 12px 40px rgba(79,70,229,.15); }

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
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
}
.pkg-preview-name {
    font-size: 20px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 4px;
    font-family: 'Outfit', sans-serif;
}
.pkg-preview-desc {
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 18px;
    min-height: 34px;
}
.pkg-preview-price-wrap {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-bottom: 6px;
}
.pkg-preview-price {
    font-size: 32px;
    font-weight: 800;
    color: #4f46e5;
    line-height: 1;
}
.pkg-free-badge {
    display: inline-block;
    background: linear-gradient(135deg,#059669,#34d399);
    color: #fff;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 1px;
}
.pkg-preview-period {
    font-size: 13px;
    color: #94a3b8;
    margin-bottom: 4px;
}
.pkg-preview-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 16px 0;
}
.pkg-preview-features { list-style: none; padding: 0; margin: 0 0 20px; }
.pkg-preview-feat-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    color: #475569;
    margin-bottom: 8px;
}
.pkg-preview-feat-item::before {
    content: '✓';
    width: 18px; height: 18px;
    background: #dcfce7;
    color: #16a34a;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    font-weight: 800;
    flex-shrink: 0;
    margin-top: 1px;
}
.pkg-preview-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg,#4f46e5,#818cf8);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    cursor: default;
    letter-spacing: .3px;
}

/* ========== STICKY ACTION BAR ========== */
.pkg-action-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-top: 1px solid #e2e8f0;
    z-index: 1050;
    padding: 14px 24px;
    box-shadow: 0 -4px 24px rgba(79,70,229,.08);
}
.pkg-action-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
}
.pkg-cancel-btn {
    padding: 10px 24px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    background: #fff;
    transition: all .2s;
}
.pkg-cancel-btn:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

.pkg-create-btn {
    padding: 12px 32px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 16px rgba(79,70,229,.35);
    letter-spacing: .3px;
}
.pkg-create-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(79,70,229,.45);
}
.pkg-create-btn:active { transform: translateY(0); }

/* Spacer so content isn't hidden behind sticky bar */
.page-content { padding-bottom: 90px !important; }
</style>

<script>
function updatePreview() {
    const name     = document.getElementById('pkgName')?.value || '';
    const desc     = document.getElementById('pkgDesc')?.value || '';
    const price    = parseFloat(document.getElementById('pkgPrice')?.value) || 0;
    const duration = document.getElementById('pkgDuration')?.value || 'monthly';

    document.getElementById('previewName').textContent    = name || 'Package Name';
    document.getElementById('previewDesc').textContent    = desc || 'Your short description will appear here...';
    document.getElementById('previewPeriod').textContent  = '/' + duration;

    const freeLabel     = document.getElementById('previewFreeLabel');
    const priceAmount   = document.getElementById('previewPriceAmount');
    const freeHint      = document.getElementById('freePackageHint');
    const previewBtn    = document.getElementById('previewBtn');

    if (price === 0) {
        freeLabel.style.display  = 'inline-block';
        priceAmount.style.display = 'none';
        freeHint.style.display   = 'block';
        previewBtn.style.background = 'linear-gradient(135deg,#059669,#34d399)';
        previewBtn.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> Activate Free';
    } else {
        freeLabel.style.display  = 'none';
        priceAmount.style.display = 'inline';
        priceAmount.textContent  = '৳' + price.toLocaleString('en-BD');
        freeHint.style.display   = 'none';
        previewBtn.style.background = 'linear-gradient(135deg,#4f46e5,#818cf8)';
        previewBtn.innerHTML = '<i class="fa-solid fa-arrow-up me-1"></i> Upgrade Now';
    }
}

// Toggle all checkboxes in a group
function toggleGroup(btn) {
    const groupBody = btn.closest('.perm-group').querySelector('.perm-group-body');
    const checkboxes = groupBody.querySelectorAll('.perm-chip-input:not(:disabled)');
    const state = parseInt(btn.dataset.state);
    checkboxes.forEach(cb => cb.checked = !state);
    btn.dataset.state = state ? 0 : 1;
    btn.textContent   = state ? 'Select All' : 'Deselect All';
}

// Init preview on page load
document.addEventListener('DOMContentLoaded', () => {
    updatePreview();
    // Watch price input for free hint
    document.getElementById('pkgPrice').addEventListener('input', updatePreview);
});
</script>
@endsection
