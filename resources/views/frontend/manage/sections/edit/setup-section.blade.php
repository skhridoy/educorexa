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
        <li class="active">Setup Section</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#059669,#10b981);">
                <i class="bi bi-diagram-3-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Setup Process Section — Edit</h2>
                <p class="se-header__sub">স্কুল অনবোর্ডিং ও ৩টি ধাপের বিবরণ কাস্টমাইজ করুন</p>
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
                
                {{-- Section Header Details --}}
                <div class="se-card mb-4">
                    <div class="se-card__head">
                        <span class="se-card__head-dot" style="background:linear-gradient(135deg,#059669,#10b981);"></span>
                        <h6 class="se-card__head-title">Section Header</h6>
                        <span class="se-card__head-badge" style="background:#d1fae5;color:#059669;border-color:rgba(5,150,105,0.2);">Header</span>
                    </div>
                    <div class="se-card__body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="se-label">Badge Text</label>
                                <input type="text" name="subtitle" class="se-input" value="{{ $content['subtitle'] ?? 'Easy Onboarding' }}" placeholder="e.g. Easy Onboarding">
                            </div>
                            <div class="col-md-8">
                                <label class="se-label">Main Title <span>*</span></label>
                                <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? 'Get Started in 3 Simple Steps' }}" placeholder="সেকশনের প্রধান শিরোনাম">
                            </div>
                            <div class="col-md-12">
                                <label class="se-label">Description</label>
                                <textarea name="description" class="se-textarea" rows="2" placeholder="সেকশনের সংক্ষিপ্ত বিবরণ...">{{ $content['description'] ?? 'মাত্র কয়েক মিনিটেই আপনার স্কুলকে ডিজিটালাইজ করুন। কোনো টেকনিক্যাল নলেজের প্রয়োজন নেই।' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3 Onboarding Steps --}}
                <div class="se-card">
                    <div class="se-card__head">
                        <span class="se-card__head-dot" style="background:linear-gradient(135deg,#059669,#10b981);"></span>
                        <h6 class="se-card__head-title">Onboarding Steps (3 Simple Steps)</h6>
                        <span class="se-card__head-badge" style="background:#d1fae5;color:#059669;border-color:rgba(5,150,105,0.2);">3 Steps</span>
                    </div>
                    <div class="se-card__body">
                        
                        {{-- Step 1 --}}
                        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:18px;margin-bottom:18px;position:relative;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                                <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;">1</span>
                                <h6 style="margin:0;font-weight:700;color:#1e293b;font-size:14px;">Step 1: Registration</h6>
                                <span style="margin-left:auto;font-size:12px;color:#64748b;"><i class="bi bi-pencil-square me-1"></i>Icon: Registration</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="se-label">Step 1 Title</label>
                                    <input type="text" name="step1_title" class="se-input" value="{{ $content['step1_title'] ?? 'Register School' }}" placeholder="e.g. Register School">
                                </div>
                                <div class="col-md-7">
                                    <label class="se-label">Step 1 Description</label>
                                    <textarea name="step1_desc" class="se-textarea" rows="2" placeholder="Step 1 এর বিবরণ...">{{ $content['step1_desc'] ?? 'আপনার প্রতিষ্ঠানের নাম, ইমেইল এবং মোবাইল নাম্বার দিয়ে রেজিস্ট্রেশন সম্পন্ন করুন।' }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:18px;margin-bottom:18px;position:relative;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                                <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;">2</span>
                                <h6 style="margin:0;font-weight:700;color:#1e293b;font-size:14px;">Step 2: Basic Setup</h6>
                                <span style="margin-left:auto;font-size:12px;color:#64748b;"><i class="bi bi-gear-wide-connected me-1"></i>Icon: Settings</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="se-label">Step 2 Title</label>
                                    <input type="text" name="step2_title" class="se-input" value="{{ $content['step2_title'] ?? 'Basic Setup' }}" placeholder="e.g. Basic Setup">
                                </div>
                                <div class="col-md-7">
                                    <label class="se-label">Step 2 Description</label>
                                    <textarea name="step2_desc" class="se-textarea" rows="2" placeholder="Step 2 এর বিবরণ...">{{ $content['step2_desc'] ?? 'ক্লাস, সেকশন এবং ফি স্ট্রাকচার সেটআপ করে আপনার প্যানেলটি প্রস্তুত করুন।' }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:18px;position:relative;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                                <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;">3</span>
                                <h6 style="margin:0;font-weight:700;color:#1e293b;font-size:14px;">Step 3: Go Live</h6>
                                <span style="margin-left:auto;font-size:12px;color:#64748b;"><i class="bi bi-rocket-takeoff me-1"></i>Icon: Launch</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="se-label">Step 3 Title</label>
                                    <input type="text" name="step3_title" class="se-input" value="{{ $content['step3_title'] ?? 'Go Live' }}" placeholder="e.g. Go Live">
                                </div>
                                <div class="col-md-7">
                                    <label class="se-label">Step 3 Description</label>
                                    <textarea name="step3_desc" class="se-textarea" rows="2" placeholder="Step 3 এর বিবরণ...">{{ $content['step3_desc'] ?? 'স্টুডেন্ট ডাটা আপলোড করুন এবং আপনার স্মার্ট স্কুল ম্যানেজমেন্ট এনজয় করুন।' }}</textarea>
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

        <div class="col-lg-4">
            <div class="se-card" style="border-color:rgba(5,150,105,0.15);background:#f0fdf4;">
                <div class="se-card__body" style="padding:22px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                        <i class="bi bi-info-circle-fill" style="color:#059669;font-size:22px;"></i>
                        <span style="font-size:13.5px;font-weight:700;color:#065f46;">সেটআপ গাইড নির্দেশিকা</span>
                    </div>
                    <p style="font-size:12.5px;color:#047857;margin-bottom:14px;line-height:1.6;">
                        এই সেকশনটি নতুন স্কুল গ্রাহকদের কীভাবে সহজে ৩টি ধাপে যুক্ত হতে হবে তা বোঝাতে হোমপেজে দেখানো হয়।
                    </p>
                    <ul style="font-size:12px;color:#065f46;padding-left:18px;margin-bottom:0;line-height:1.7;">
                        <li><strong>Step 1:</strong> রেজিস্ট্রেশন ফর্ম পূরণের নির্দেশনা।</li>
                        <li><strong>Step 2:</strong> বেসিক প্যানেল কনফিগারেশন।</li>
                        <li><strong>Step 3:</strong> সরাসরি ব্যবহার ও শিক্ষার্থীদের অ্যাক্সেস শুরু।</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
