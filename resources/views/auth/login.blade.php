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

@if(session('status'))
    <div class="alert-auth success animate-fade-in">
        <div class="alert-icon-title">
            <i class="fas fa-circle-check"></i>
            <strong>Success</strong>
        </div>
        <div class="alert-message mt-1">
            {{ session('status') }}
        </div>
    </div>
@endif

<form action="{{ route('school.login', ['tenant' => $currentSchool->slug]) }}" method="POST">
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
            <a href="{{ route('school.password.request', ['tenant' => $currentSchool->slug]) }}" class="f-link" style="font-size: 0.8rem; font-weight: 500;">Forgot?</a>
        </div>
        <div class="f-input-wrap position-relative">
            <span class="f-icon"><i class="fas fa-lock"></i></span>
            <input type="password" id="passwordInput" name="password" class="f-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
            <button type="button" class="f-btn-toggle" onclick="togglePassword()"><i class="far fa-eye" id="toggleIcon"></i></button>
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
    <span>OR</span>
</div>

<div class="text-center">
    <p class="text-muted small mb-0">
        Return to <a href="{{ route('school.home', ['tenant' => $currentSchool->slug]) }}" class="f-link">School Homepage</a>
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
        50% { transform: translateY(-8px); }
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

@section('customJs')
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection