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
        <li class="active">{{ $section->title }}</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <h2 class="se-header__title">Editor Not Found</h2>
                <p class="se-header__sub">এই সেকশনের জন্য কাস্টম এডিটর তৈরি হয়নি</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="se-card" style="max-width:640px;">
        <div class="se-card__body" style="text-align:center; padding: 48px 36px;">
            <div style="width:72px;height:72px;background:#fffbeb;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;border:2px solid #fde68a;">
                <i class="bi bi-tools" style="font-size:32px;color:#d97706;"></i>
            </div>
            <h4 style="font-family:'Poppins',sans-serif;font-weight:800;color:#1e293b;margin-bottom:10px;">
                Custom Editor পাওয়া যায়নি
            </h4>
            <p style="color:#64748b;font-size:14px;margin-bottom:20px;">
                <strong>{{ $section->title }}</strong> সেকশনের জন্য কোনো কাস্টম এডিট ফর্ম তৈরি করা হয়নি।
            </p>
            <div style="background:#f0f7ff;border:1px solid rgba(0,97,168,0.15);border-radius:12px;padding:16px;text-align:left;margin-bottom:24px;">
                <p style="font-size:12px;font-weight:700;color:#0061A8;margin-bottom:8px;">
                    <i class="bi bi-code-slash me-1"></i> Developer Guide:
                </p>
                <p style="font-size:12px;color:#475569;margin:0;">
                    নিচের পাথে একটি ফাইল তৈরি করুন:
                </p>
                <code style="display:block;background:#1e293b;color:#7dd3fc;padding:10px 14px;border-radius:8px;font-size:12px;margin-top:8px;overflow-x:auto;word-break:break-all;">
                    resources/views/frontend/manage/sections/edit/<strong style="color:#86efac;">{{ $section->key }}</strong>.blade.php
                </code>
            </div>
            <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--primary" style="display:inline-flex;">
                <i class="bi bi-arrow-left"></i> Sections List এ ফিরুন
            </a>
        </div>
    </div>

</div>
@endsection