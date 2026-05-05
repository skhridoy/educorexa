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
    </div>

    <form action="{{ route('super.subscription-packages.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="edu-panel">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl">Package Configuration</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="edu-label">Package Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control edu-input" placeholder="e.g. Premium Pro" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="edu-label">Billing Cycle <span class="text-danger">*</span></label>
                                <select name="duration" class="form-select edu-input" required>
                                    <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('duration') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="edu-label">Price (৳) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background:#f1f5f9; border:1px solid #e2e8f0; border-radius:10px 0 0 10px;">৳</span>
                                    <input type="number" step="0.01" name="price" class="form-control edu-input" style="border-radius:0 10px 10px 0 !important;" value="{{ old('price', '0.00') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="edu-label">Student Limit</label>
                                <input type="number" name="student_limit" class="form-control edu-input" placeholder="Unlimited" value="{{ old('student_limit') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="edu-label">Teacher Limit</label>
                                <input type="number" name="teacher_limit" class="form-control edu-input" placeholder="Unlimited" value="{{ old('teacher_limit') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="edu-label">Short Description</label>
                            <textarea name="description" class="form-control edu-input" rows="2" placeholder="Briefly describe the plan...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="edu-label">Key Features (One per line)</label>
                            <textarea name="features_list" class="form-control edu-input" rows="6" placeholder="Live Classes&#10;Exam Management&#10;Auto Attendance">{{ old('features_list') }}</textarea>
                            <small class="text-muted mt-2 d-block"><i class="fa-solid fa-circle-info me-1"></i> These will appear as bullet points on the pricing page.</small>
                        </div>

                        <div class="edu-divider"></div>

                        <div class="d-flex flex-wrap gap-4">
                            <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                                <input class="form-check-input" type="checkbox" name="is_popular" id="isPopular" style="width:40px; height:20px; cursor:pointer;" {{ old('is_popular') ? 'checked' : '' }}>
                                <label class="form-check-label" for="isPopular" style="font-weight:700; color:#1e293b; cursor:pointer;">Most Popular Badge</label>
                            </div>
                            <div class="form-check form-switch" style="display:flex; align-items:center; gap:10px;">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" style="width:40px; height:20px; cursor:pointer;" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive" style="font-weight:700; color:#1e293b; cursor:pointer;">Publish Package</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div style="background:#fafbff; border:1px dashed #cbd5e1; border-radius:20px; padding:30px; height:100%; display:flex; flex-direction:column; justify-content:center; text-align:center;">
                    <div style="width:60px; height:60px; border-radius:50%; background:#eef2ff; color:#4f46e5; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                        <i data-feather="shopping-bag" style="width:24px;"></i>
                    </div>
                    <h5 style="font-family:'Outfit',sans-serif; font-weight:700; color:#1e293b; margin-bottom:10px;">Pricing Strategy</h5>
                    <p style="color:#64748b; font-size:0.875rem; line-height:1.6;">
                        Ensure the pricing is competitive and the limits (students/teachers) align with the target school size.
                    </p>
                    <div class="mt-4">
                        <button type="submit" class="btn-edu btn-edu-primary w-100" style="padding:15px;">
                            <i data-feather="save" style="width:16px; margin-right:8px;"></i> Create Plan
                        </button>
                        <a href="{{ route('super.subscription-packages.index') }}" class="btn-edu btn-edu-light w-100 mt-2" style="padding:12px;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
