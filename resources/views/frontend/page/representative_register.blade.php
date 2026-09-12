@extends('app-layouts.frontend')

@section('title', 'প্রতিনিধি রেজিস্ট্রেশন')
@section('subtitle', 'Join as a Representative')
@section('seo_title', 'EduCorexa | প্রতিনিধি হিসেবে যোগ দিন')
@section('seo_description', 'EduCorexa-তে সেলস রিপ্রেজেন্টেটিভ হিসেবে যোগ দিন এবং আকর্ষণীয় কমিশনে ক্যারিয়ার শুরু করুন।')

{{-- Force the transparent fixed navbar into solid/scrolled state on this page --}}
@push('custom-css')
<style>
    .ec-header {
        background: rgba(255,255,255,0.97) !important;
        border-bottom-color: rgba(0,97,168,0.12) !important;
        box-shadow: 0 4px 28px rgba(0,97,168,0.10) !important;
    }
    .ec-logo-text           { color: #1e293b !important; }
    .ec-logo-text span      { color: #0061A8 !important; }
    .ec-logo-icon           { background: linear-gradient(135deg,#0061A8,#0080d4) !important; border-color: transparent !important; }
    .ec-logo-icon svg       { stroke: #fff !important; }
    .ec-nav__link           { color: #475569 !important; }
    .ec-nav__link:hover,
    .ec-nav__link.active    { color: #0061A8 !important; background: rgba(0,97,168,0.06) !important; }
    .ec-nav__cta            { background: linear-gradient(135deg,#0061A8,#0080d4) !important; border-color: transparent !important; color:#fff !important; }
    .ec-hamburger           { color: #0061A8 !important; }
</style>
@endpush

@section('content')
<div style="min-height:100vh;background:#f8fafc;padding-top:90px;padding-bottom:60px;font-family:'Poppins',sans-serif;">

<div class="container">

    {{-- Page Header --}}
    <div class="text-center mb-5">
        <div style="display:inline-flex;align-items:center;gap:8px;background:#e8f3fb;color:#0061A8;font-size:12px;font-weight:700;padding:6px 16px;border-radius:50px;margin-bottom:16px;">
            <i class="bi bi-briefcase-fill"></i> Representative Program
        </div>
        <h1 style="font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:#1e293b;margin-bottom:10px;">প্রতিনিধি হিসেবে আবেদন করুন</h1>
        <p style="color:#64748b;font-size:15px;max-width:500px;margin:0 auto;">ফর্মটি পূরণ করুন — সফল রেজিস্ট্রেশনের পর আপনার ইমেইলে লগইন তথ্য পাঠানো হবে।</p>
    </div>

    <div class="row justify-content-center g-4">

        {{-- Form --}}
        <div class="col-lg-7">
            <div style="background:#fff;border-radius:20px;border:1.5px solid #e2e8f0;box-shadow:0 8px 32px rgba(0,97,168,0.08);overflow:hidden;">

                {{-- Card Top Bar --}}
                <div style="height:4px;background:linear-gradient(90deg,#0061A8,#6366f1);"></div>

                <div style="padding:36px;">

                    {{-- Alerts --}}
                    @if(session('success'))
                    <div style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:600;margin-bottom:24px;">
                        <i class="bi bi-check-circle-fill" style="font-size:18px;flex-shrink:0;"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div style="display:flex;align-items:flex-start;gap:10px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:600;margin-bottom:24px;">
                        <i class="bi bi-x-circle-fill" style="font-size:18px;flex-shrink:0;margin-top:1px;"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div style="display:flex;align-items:flex-start;gap:10px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:14px 18px;border-radius:12px;font-size:13.5px;font-weight:600;margin-bottom:24px;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size:18px;flex-shrink:0;margin-top:1px;"></i>
                        <ul style="margin:0;padding-left:16px;">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('representative.register.store') }}" method="POST" id="repForm">
                        @csrf

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-12">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    পূর্ণ নাম <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-person" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;"></i>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           placeholder="আপনার পূর্ণ নাম"
                                           style="width:100%;border:1.5px solid {{ $errors->has('name') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;color:#1e293b;outline:none;transition:border-color 0.2s;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('name') ? '#ef4444' : '#e2e8f0' }}'">
                                </div>
                                @error('name')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    ইমেইল <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-envelope" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                           placeholder="example@email.com"
                                           style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;color:#1e293b;outline:none;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#e2e8f0' }}'">
                                </div>
                                @error('email')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    মোবাইল নম্বর <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-phone" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;"></i>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required
                                           placeholder="01XXXXXXXXX"
                                           style="width:100%;border:1.5px solid {{ $errors->has('phone') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;color:#1e293b;outline:none;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('phone') ? '#ef4444' : '#e2e8f0' }}'">
                                </div>
                                @error('phone')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- District --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    জেলা <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-geo-alt" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;"></i>
                                    <input type="text" name="district" value="{{ old('district') }}" required
                                           placeholder="আপনার জেলা"
                                           style="width:100%;border:1.5px solid {{ $errors->has('district') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;color:#1e293b;outline:none;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('district') ? '#ef4444' : '#e2e8f0' }}'">
                                </div>
                                @error('district')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- Experience --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    অভিজ্ঞতা
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-star" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;"></i>
                                    <select name="experience"
                                            style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 14px 11px 38px;font-size:14px;color:#1e293b;outline:none;appearance:none;background:#fff;"
                                            onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='#e2e8f0'">
                                        <option value="">--- অভিজ্ঞতা নির্বাচন করুন ---</option>
                                        <option value="fresher" {{ old('experience')=='fresher' ? 'selected' : '' }}>ফ্রেশার</option>
                                        <option value="1_year" {{ old('experience')=='1_year' ? 'selected' : '' }}>১ বছরের কম</option>
                                        <option value="2_3_year" {{ old('experience')=='2_3_year' ? 'selected' : '' }}>১–৩ বছর</option>
                                        <option value="3_plus" {{ old('experience')=='3_plus' ? 'selected' : '' }}>৩+ বছর</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="col-12">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">সম্পূর্ণ ঠিকানা</label>
                                <textarea name="address" rows="3" placeholder="গ্রাম, উপজেলা, জেলা..."
                                          style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 14px;font-size:14px;color:#1e293b;outline:none;resize:vertical;"
                                          onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='#e2e8f0'">{{ old('address') }}</textarea>
                            </div>

                            {{-- Why Join --}}
                            <div class="col-12">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">কেন প্রতিনিধি হতে চান? <span style="color:#94a3b8;font-weight:400;">(ঐচ্ছিক)</span></label>
                                <textarea name="why_join" rows="3" placeholder="সংক্ষেপে লিখুন..."
                                          style="width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 14px;font-size:14px;color:#1e293b;outline:none;resize:vertical;"
                                          onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='#e2e8f0'">{{ old('why_join') }}</textarea>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    পাসওয়ার্ড <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-lock" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;pointer-events:none;"></i>
                                    <input type="password" name="password" id="repPassword" required
                                           placeholder="••••••••"
                                           style="width:100%;border:1.5px solid {{ $errors->has('password') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 42px 11px 38px;font-size:14px;color:#1e293b;outline:none;transition:border-color 0.2s;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : '#e2e8f0' }}'">
                                    <button type="button" onclick="togglePassword('repPassword','repPassIcon')"
                                            style="position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;font-size:16px;padding:2px 4px;line-height:1;">
                                        <i class="bi bi-eye" id="repPassIcon"></i>
                                    </button>
                                </div>
                                @error('password')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6">
                                <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:6px;">
                                    পাসওয়ার্ড নিশ্চিত করুন <span style="color:#ef4444;">*</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="bi bi-lock-fill" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:15px;pointer-events:none;"></i>
                                    <input type="password" name="password_confirmation" id="repPasswordConfirm" required
                                           placeholder="••••••••"
                                           style="width:100%;border:1.5px solid {{ $errors->has('password_confirmation') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;padding:11px 42px 11px 38px;font-size:14px;color:#1e293b;outline:none;transition:border-color 0.2s;"
                                           onfocus="this.style.borderColor='#0061A8'" onblur="this.style.borderColor='{{ $errors->has('password_confirmation') ? '#ef4444' : '#e2e8f0' }}'"
                                           oninput="checkPasswordMatch()">
                                    <button type="button" onclick="togglePassword('repPasswordConfirm','repConfirmIcon')"
                                            style="position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;font-size:16px;padding:2px 4px;line-height:1;">
                                        <i class="bi bi-eye" id="repConfirmIcon"></i>
                                    </button>
                                </div>
                                <span id="passMatchMsg" style="font-size:11.5px;margin-top:4px;display:none;"></span>
                                @error('password_confirmation')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                            {{-- Terms --}}
                            <div class="col-12">
                                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;font-size:13px;color:#475569;line-height:1.5;">
                                    <input type="checkbox" name="agree" required style="margin-top:3px;accent-color:#0061A8;width:16px;height:16px;flex-shrink:0;">
                                    <span>আমি EduCorexa-এর <a href="#" style="color:#0061A8;font-weight:600;">শর্তাবলী ও গোপনীয়তা নীতি</a> পড়েছি এবং সম্মত আছি।</span>
                                </label>
                                @error('agree')<span style="font-size:11.5px;color:#ef4444;margin-top:4px;display:block;">{{ $message }}</span>@enderror
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div style="display:flex;align-items:center;gap:14px;margin-top:28px;padding-top:24px;border-top:1px solid #f1f5f9;flex-wrap:wrap;">
                            <button type="submit" id="repSubmit"
                                    style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#0061A8,#0080d4);color:#fff;border:none;font-size:14.5px;font-weight:700;padding:13px 30px;border-radius:12px;cursor:pointer;box-shadow:0 6px 20px rgba(0,97,168,0.35);transition:all 0.25s;font-family:'Poppins',sans-serif;"
                                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 28px rgba(0,97,168,0.45)'"
                                    onmouseout="this.style.transform='none';this.style.boxShadow='0 6px 20px rgba(0,97,168,0.35)'">
                                <i class="bi bi-send-fill"></i>
                                রেজিস্ট্রেশন সম্পন্ন করুন
                            </button>
                            <a href="{{ url()->previous() }}" style="font-size:13.5px;font-weight:600;color:#64748b;text-decoration:none;">
                                <i class="bi bi-arrow-left me-1"></i> ফিরে যান
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- What you get --}}
            <div style="background:#fff;border-radius:18px;border:1.5px solid #e2e8f0;box-shadow:0 6px 24px rgba(0,97,168,0.07);padding:24px;margin-bottom:18px;">
                <h6 style="font-size:14px;font-weight:800;color:#1e293b;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-gift-fill" style="color:#0061A8;font-size:17px;"></i>
                    রেজিস্ট্রেশনের পর পাবেন
                </h6>
                @foreach([
                    'ইমেইলে ওয়েলকাম ও লগইন তথ্য',
                    'নিজস্ব রিপ্রেজেন্টেটিভ ড্যাশবোর্ড',
                    'রেফারেল ট্র্যাকিং সিস্টেম',
                    'আকর্ষণীয় কমিশন কাঠামো',
                    'মার্কেটিং ম্যাটেরিয়াল ও সাপোর্ট',
                ] as $item)
                <div style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f8fafc;font-size:13px;color:#475569;">
                    <i class="bi bi-check-circle-fill" style="color:#22c55e;font-size:15px;flex-shrink:0;"></i>
                    {{ $item }}
                </div>
                @endforeach
            </div>

            {{-- Help --}}
            <div style="background:linear-gradient(135deg,#f0f7ff,#faf5ff);border-radius:18px;border:1.5px solid rgba(0,97,168,0.12);padding:22px;">
                <h6 style="font-size:14px;font-weight:800;color:#1e293b;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-headset" style="color:#9333ea;font-size:17px;"></i> সাহায্য দরকার?
                </h6>
                <p style="font-size:13px;color:#64748b;margin-bottom:16px;">কোনো প্রশ্ন থাকলে আমাদের সাথে যোগাযোগ করুন।</p>
                <a href="{{ route('main.contact') }}"
                   style="display:block;text-align:center;background:linear-gradient(135deg,#9333ea,#7c3aed);color:#fff;font-size:13.5px;font-weight:700;padding:11px 20px;border-radius:11px;text-decoration:none;box-shadow:0 4px 14px rgba(147,51,234,0.3);">
                    <i class="bi bi-envelope-fill me-2"></i> যোগাযোগ করুন
                </a>
            </div>

        </div>

    </div>
</div>
</div>

<script>
document.getElementById('repForm').addEventListener('submit', function() {
    const btn = document.getElementById('repSubmit');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat" style="animation:spin 1s linear infinite;display:inline-block;"></i> প্রক্রিয়াকরণ হচ্ছে...';
});

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function checkPasswordMatch() {
    const pass    = document.getElementById('repPassword').value;
    const confirm = document.getElementById('repPasswordConfirm').value;
    const msg     = document.getElementById('passMatchMsg');
    if (confirm === '') { msg.style.display = 'none'; return; }
    if (pass === confirm) {
        msg.style.display = 'block';
        msg.style.color   = '#16a34a';
        msg.textContent   = '✓ পাসওয়ার্ড মিলেছে';
    } else {
        msg.style.display = 'block';
        msg.style.color   = '#ef4444';
        msg.textContent   = '✗ পাসওয়ার্ড মিলছে না';
    }
}
</script>
<style>
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
@media(max-width:576px){
    [style*="display:flex"][style*="align-items:center"][style*="gap:14px"] { flex-direction:column; }
    [style*="display:flex"][style*="align-items:center"][style*="gap:14px"] button { width:100%; justify-content:center; }
}
</style>
@endsection
