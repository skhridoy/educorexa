@extends('school.website.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<!-- Step Indicator -->
<div class="step-dots mb-4">
    <div class="step-dot active"></div>
    <div class="step-dot"></div>
    <div class="step-dot"></div>
</div>

<!-- Header Section -->
<div class="text-center mb-4">
    <div class="auth-icon-box">
        <i class="fas fa-lock-open animate-bounce-slow"></i>
    </div>
    <h4 class="auth-heading">Forgot Password?</h4>
    <p class="auth-subtitle">No worries! Enter your registered email below and we'll send you a secure OTP to verify your identity.</p>
</div>

<!-- Alert Messages -->
@if(session('status'))
    <div class="alert-auth success animate-fade-in">
        <i class="fas fa-circle-check"></i> 
        <span>{{ session('status') }}</span>
    </div>
@endif

@if($errors->any() || session('school_mismatch'))
    <div class="alert-auth danger animate-shake">
        <div class="alert-icon-title">
            <i class="fas fa-triangle-exclamation"></i>
            <strong>{{ session('school_mismatch') ? 'Access Restricted' : 'Attention Required' }}</strong>
        </div>
        <div class="alert-message mt-1">
            {!! session('school_mismatch') ?? $errors->first() !!}
        </div>
    </div>
@endif

<!-- Form Section -->
<form action="{{ route('school.password.otp', ['tenant' => $currentSchool->slug]) }}" method="POST" class="mt-2">
    @csrf
    <div class="f-group">
        <label class="f-label">Registered Email Address</label>
        <div class="f-input-wrap">
            <span class="f-icon"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" 
                   class="f-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" 
                   placeholder="e.g. admin@school.edu" required autofocus>
        </div>
        @error('email')
            <small class="f-error">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-submit w-100 d-flex align-items-center justify-content-center gap-2">
        <span>Request Verification Code</span>
        <i class="fas fa-paper-plane"></i>
    </button>
</form>

<div class="f-divider">
    <span>secure recovery</span>
</div>

<div class="text-center">
    <a href="{{ route('school.login.form', ['tenant' => $currentSchool->slug]) }}" class="auth-link-back">
        <i class="fas fa-arrow-left me-1"></i> Return to Login
    </a>
</div>
@endsection

@section('customCSS')
<style>
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-shake {
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }
    
    /* Overriding layout styles for specific refinements */
    .auth-icon-box {
        background: linear-gradient(135deg, #fffcf0 0%, #fff4d1 100%);
        border: 1px solid rgba(212,175,55,0.2);
        color: #D4AF37;
    }
    
    .f-divider span {
        background: #fff;
        padding: 0 10px;
        color: #94a3b8;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
@endsection