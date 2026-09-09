@extends('layouts.main')
@section('customCSS')
    @include('layouts._shared_styles')
    @include('layouts._section_edit_styles')
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.frontend.index') }}">Frontend Sections</a></li>
        <li><span>/</span></li>
        <li class="active">Contact Us</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#0891b2,#06b6d4);">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Contact Us — Edit</h2>
                <p class="se-header__sub">যোগাযোগ সেকশনের কন্টেন্ট ও তথ্য আপডেট করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
        @csrf
        <div class="se-card">
            <div class="se-card__head">
                <span class="se-card__head-dot"></span>
                <h6 class="se-card__head-title">Section Content</h6>
                <span class="se-card__head-badge">Contact</span>
            </div>
            <div class="se-card__body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="se-label">Subtitle (Badge)</label>
                        <input type="text" name="subtitle" class="se-input" value="{{ $content['subtitle'] ?? 'Contact Us' }}" placeholder="e.g. যোগাযোগ করুন">
                    </div>
                    <div class="col-md-8">
                        <label class="se-label">Main Title <span>*</span></label>
                        <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? '' }}" placeholder="Contact section শিরোনাম">
                        <span class="se-hint">কালার করতে: <code style="font-size:10.5px;">&lt;span class="text-primary"&gt;Text&lt;/span&gt;</code></span>
                    </div>
                    <div class="col-md-12">
                        <label class="se-label">Description</label>
                        <textarea name="description" class="se-textarea" rows="3" placeholder="যোগাযোগ সেকশনের বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="se-section-label">
                    <span class="se-section-label__text">Contact Information</span>
                    <div class="se-section-label__line"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="se-label">Office Address</label>
                        <div style="position:relative;">
                            <i class="bi bi-geo-alt-fill" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#0061A8;font-size:15px;pointer-events:none;"></i>
                            <input type="text" name="address" class="se-input" value="{{ $content['address'] ?? '' }}" placeholder="Dhaka, Bangladesh" style="padding-left:36px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="se-label">Phone Number</label>
                        <div style="position:relative;">
                            <i class="bi bi-telephone-fill" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#0061A8;font-size:14px;pointer-events:none;"></i>
                            <input type="text" name="phone" class="se-input" value="{{ $content['phone'] ?? '' }}" placeholder="+880 1234 567890" style="padding-left:36px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="se-label">Email Address</label>
                        <div style="position:relative;">
                            <i class="bi bi-envelope-fill" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#0061A8;font-size:14px;pointer-events:none;"></i>
                            <input type="email" name="email" class="se-input" value="{{ $content['email'] ?? '' }}" placeholder="support@educorexa.com" style="padding-left:36px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="se-action-bar">
                <button type="submit" class="se-btn se-btn--primary"><i class="bi bi-floppy-fill"></i> Save Changes</button>
                <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary"><i class="bi bi-x-lg"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection