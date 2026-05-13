@extends('school.website.layouts.auth')

@section('title', 'Reset Password')

@section('content')
<!-- Step Indicator -->
<div class="step-dots mb-4">
    <div class="step-dot done"></div>
    <div class="step-dot done"></div>
    <div class="step-dot active"></div>
</div>

<!-- Header Section -->
<div class="text-center mb-4">
    <div class="auth-icon-box">
        <i class="fas fa-key animate-rotate-slow"></i>
    </div>
    <h4 class="auth-heading">Set New Password</h4>
    <p class="auth-subtitle">Create a strong, secure password for your account <strong>{{ $email }}</strong></p>
</div>

@if(session('status'))
    <div class="alert-auth success animate-fade-in">
        <i class="fas fa-circle-check"></i> {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert-auth danger animate-shake">
        <i class="fas fa-triangle-exclamation"></i> {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('school.password.update', ['tenant' => $currentSchool->slug]) }}" method="POST" class="mt-2">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="f-group">
        <label class="f-label">New Password</label>
        <div class="f-input-wrap">
            <span class="f-icon"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="f-control @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="new-password">
        </div>
        @error('password')
            <small class="f-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="f-group">
        <label class="f-label">Confirm Password</label>
        <div class="f-input-wrap">
            <span class="f-icon"><i class="fas fa-shield-check"></i></span>
            <input type="password" name="password_confirmation" class="f-control @error('password_confirmation') is-invalid @enderror" placeholder="••••••••" required autocomplete="new-password">
        </div>
        @error('password_confirmation')
            <small class="f-error">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn-submit w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
        <span>Complete Reset</span>
        <i class="fas fa-circle-check"></i>
    </button>
</form>

<div class="f-divider">
    <span>final step</span>
</div>

<div class="text-center">
    <a href="{{ route('school.login.form', ['tenant' => $currentSchool->slug]) }}" class="auth-link-back">
        <i class="fas fa-arrow-left me-1"></i> Back to Sign In
    </a>
</div>
@endsection

@section('customCSS')
<style>
    .animate-rotate-slow {
        animation: rotate-slow 10s linear infinite;
    }
    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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
</style>
@endsection
