@extends('school.website.layouts.auth')

@section('title', 'Login')

@section('content')
<!-- Header Section -->
<div class="text-center mb-4">
    <div class="auth-icon-box">
        <i class="fas fa-user-shield animate-float"></i>
    </div>
    <h4 class="auth-heading">Welcome Back</h4>
    <p class="auth-subtitle">Please sign in to access your administrative dashboard.</p>
</div>

@if(session('error'))
    <div class="alert-auth danger animate-shake">
        <div class="alert-icon-title">
            <i class="fas fa-triangle-exclamation"></i>
            <strong>Login Failed</strong>
        </div>
        <div class="alert-message mt-1">
            {{ session('error') }}
        </div>
    </div>
@endif

<form action="{{ route('school.login', ['tenant' => $currentSchool->slug]) }}" method="POST" class="mt-2">
    @csrf
    
    <div class="f-group">
        <label class="f-label">Email Address</label>
        <div class="f-input-wrap">
            <span class="f-icon"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="f-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" placeholder="name@school.edu" required autofocus>
        </div>
        @error('email')
            <small class="f-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="f-group">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="f-label mb-0">Password</label>
            <a href="{{ route('school.password.request', ['tenant' => $currentSchool->slug]) }}" class="f-link muted">Forgot?</a>
        </div>
        <div class="f-input-wrap">
            <span class="f-icon"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="f-control @error('password') is-invalid @enderror" 
                   placeholder="••••••••" required>
        </div>
        @error('password')
            <small class="f-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="f-check mb-4">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Keep me logged in for 30 days</label>
    </div>

    <button type="submit" class="btn-submit w-100 d-flex align-items-center justify-content-center gap-2">
        <span>Sign In to Portal</span>
        <i class="fas fa-arrow-right-to-bracket"></i>
    </button>
</form>

<div class="f-divider">
    <span>new to the portal?</span>
</div>

<div class="text-center">
    <p class="text-muted small">
        Need an account? <a href="{{ route('school.register.form') }}" class="f-link">Request Enrollment</a>
    </p>
</div>
@endsection

@section('customCSS')
<style>
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
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