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
        <li class="active">Pricing</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#ea580c,#f97316);">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Pricing Section — Edit</h2>
                <p class="se-header__sub">মূল্য পরিকল্পনা সেকশনের শিরোনাম কাস্টমাইজ করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                @csrf
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot"></span>
                        <h6 class="se-card__head-title">Section Header</h6>
                        <span class="se-card__head-badge">Pricing</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="se-label">Badge Text</label>
                                <input type="text" name="subtitle" class="se-input" value="{{ $content['subtitle'] ?? 'Flexible Plans' }}" placeholder="e.g. Flexible Plans">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Main Title <span>*</span></label>
                                <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? 'Choose the Right Plan' }}" placeholder="Pricing section শিরোনাম">
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="3" placeholder="মূল্য সেকশনের বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
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

        <div class="col-lg-4">
            <div class="se-card" style="border-color:rgba(234,88,12,0.15);background:#fff7ed;">
                <div class="se-card__body" style="padding:20px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                        <i class="bi bi-info-circle-fill" style="color:#ea580c;font-size:20px;"></i>
                        <span style="font-size:13px;font-weight:700;color:#9a3412;">প্যাকেজ নির্দেশিকা</span>
                    </div>
                    <p style="font-size:12.5px;color:#c2410c;margin-bottom:14px;line-height:1.6;">
                        এই পেজটি শুধু <strong>section এর শিরোনাম ও বিবরণ</strong> পরিবর্তনের জন্য।
                        নতুন প্যাকেজ তৈরি বা পরিবর্তন করতে Subscriptions মেনু ব্যবহার করুন।
                    </p>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#9a3412;font-weight:600;">
                        <i class="bi bi-box-arrow-up-right"></i>
                        Subscriptions → Packages
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
