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
        <li class="active">Testimonials</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#9333ea,#7c3aed);">
                <i class="bi bi-chat-quote-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Testimonials Section — Edit</h2>
                <p class="se-header__sub">গ্রাহকদের রিভিউ সেকশনের শিরোনাম ও বিবরণ কাস্টমাইজ করুন</p>
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
                        <span class="se-card__head-dot" style="background:linear-gradient(135deg,#9333ea,#7c3aed);"></span>
                        <h6 class="se-card__head-title">Section Header</h6>
                        <span class="se-card__head-badge" style="background:#f3e8ff;color:#9333ea;border-color:rgba(147,51,234,0.2);">Testimonials</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="se-label">Badge Text</label>
                                <input type="text" name="subtitle" class="se-input" value="{{ $content['subtitle'] ?? 'Testimonials' }}" placeholder="e.g. Testimonials">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Main Title <span>*</span></label>
                                <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? 'What School Leaders Say' }}" placeholder="টেস্টিমোনিয়াল সেকশনের শিরোনাম">
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="3" placeholder="টেস্টিমোনিয়াল সেকশনের বিবরণ...">{{ $content['description'] ?? 'আমাদের ওপর আস্থা রেখেছেন দেশের অসংখ্য শিক্ষা প্রতিষ্ঠান।' }}</textarea>
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
            <div class="se-card" style="border-color:rgba(147,51,234,0.15);background:#faf5ff;">
                <div class="se-card__body" style="padding:22px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                        <i class="bi bi-chat-heart-fill" style="color:#9333ea;font-size:22px;"></i>
                        <span style="font-size:13.5px;font-weight:700;color:#6b21a8;">টেস্টিমোনিয়াল ম্যানেজমেন্ট</span>
                    </div>
                    <p style="font-size:12.5px;color:#7e22ce;margin-bottom:16px;line-height:1.6;">
                        এই পেজটি শুধুমাত্র <strong>Testimonials সেকশনের শিরোনাম ও বিবরণ</strong> এডিট করার জন্য।
                    </p>
                    <p style="font-size:12.5px;color:#7e22ce;margin-bottom:16px;line-height:1.6;">
                        নতুন টেস্টমোনিয়াল বা রিভিউ যোগ ও এডিট করতে সংশ্লিষ্ট ম্যানেজমেন্ট মেনু ব্যবহার করুন।
                    </p>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b21a8;font-weight:600;background:rgba(147,51,234,0.08);padding:8px 12px;border-radius:8px;">
                        <i class="bi bi-info-circle"></i>
                        Individual testimonials are managed separately
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
