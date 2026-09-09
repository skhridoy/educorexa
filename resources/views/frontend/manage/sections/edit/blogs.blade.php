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
        <li class="active">Blog Slider</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#db2777,#ec4899);">
                <i class="bi bi-newspaper"></i>
            </div>
            <div>
                <h2 class="se-header__title">Blog Slider — Edit</h2>
                <p class="se-header__sub">হোমপেজের ব্লগ সেকশনের শিরোনাম ও বিবরণ পরিবর্তন করুন</p>
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
                        <h6 class="se-card__head-title">Section Content</h6>
                        <span class="se-card__head-badge">Blog Slider</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="se-label">Badge Text</label>
                                <input type="text" name="badge_text" class="se-input" value="{{ $content['badge_text'] ?? 'আমাদের ব্লগ ও খবর' }}" placeholder="e.g. আমাদের ব্লগ">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Section Title <span>*</span></label>
                                <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? 'সর্বশেষ আপডেট ও শিক্ষামূলক প্রবন্ধ' }}" placeholder="ব্লগ সেকশন শিরোনাম">
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="3" placeholder="ছোট বিবরণ...">{{ $content['description'] ?? '' }}</textarea>
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
            <div class="se-card" style="border-color:rgba(219,39,119,0.15);background:#fdf2f8;">
                <div class="se-card__body" style="padding:20px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                        <i class="bi bi-info-circle-fill" style="color:#db2777;font-size:20px;"></i>
                        <span style="font-size:13px;font-weight:700;color:#831843;">ব্লগ পোস্ট নির্দেশিকা</span>
                    </div>
                    <p style="font-size:12.5px;color:#9d174d;margin-bottom:14px;line-height:1.6;">
                        এই পেজটি শুধুমাত্র হোমপেজে ব্লগ সেকশনের <strong>শিরোনাম ও বিবরণ</strong> পরিবর্তনের জন্য।
                        নতুন ব্লগ পোস্ট তৈরি, এডিট বা ডিলিট করতে Manage Blogs এ যান।
                    </p>
                    <a href="{{ route('super.blogs.index') }}"
                       style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,#db2777,#ec4899);color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(219,39,119,0.3);">
                        <i class="bi bi-file-text"></i> Manage Blogs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
