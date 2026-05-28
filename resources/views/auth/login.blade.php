@extends('school.website.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="container">
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
    <label class="f-label mb-0">Password</label>
    <div class="f-input-wrap position-relative">
        <span class="f-icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="password" class="f-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
        <a href="{{ route('school.password.request', ['tenant' => $currentSchool->slug]) }}" class="f-link forgot-link">Forgot?</a>
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
    .container {
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    padding: 30px;
    max-width: 500px;
    margin: 40px auto;
}
    .f-group {
        margin-bottom: 1rem;
    }
    .f-label {
        font-weight: 600;
        color: #002147;
        margin-bottom: 0.25rem;
        display: block;
    }
    .f-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 4rem; /* extra space for link */
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .f-control:focus {
        outline: none;
        border-color: #1e3a8a;
        box-shadow: 0 0 8px rgba(30,58,138,0.3);
    }
    .btn-submit {
        background: linear-gradient(90deg, #1e3a8a, #2563eb);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        font-weight: 600;
        transition: opacity 0.2s;
    }
    .btn-submit:hover {
        opacity: 0.9;
    }
    .f-link {
        color: #2563eb;
        text-decoration: underline;
    }
    .f-link:hover {
        color: #1e40af;
    }
</style>
@endsection