@extends('school.website.layouts.app')

@section('customCSS')
<style>
    :root {
        --primary-navy: #002147;
        --accent-gold: #ffcc00;
        --soft-bg: #f8fafc;
    }

    body {
        background-color: var(--soft-bg);
    }

    .hero-header-wrapper {
        margin-top: 0 !important;
    }
    
    .hero-header {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #003366 100%);
        padding: 80px 0;
        margin-bottom: -100px;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
    }

    .login-card {
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .logo-box {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 20px;
        padding: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    .logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .input-group {
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 4px rgba(0, 33, 71, 0.05);
    }

    .input-group-text {
        background: #f8fafc;
        border: none;
        color: #94a3b8;
        padding-left: 16px;
    }

    .form-control {
        border: none;
        padding: 12px 16px;
        font-size: 0.95rem;
        background: transparent;
    }

    .form-control:focus {
        box-shadow: none;
        background: transparent;
    }

    .btn-login {
        background: var(--primary-navy);
        border: none;
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin-top: 12px;
    }

    .btn-login:hover {
        background: #003366;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 33, 71, 0.2);
        color: white;
    }

    .auth-link {
        color: var(--primary-navy);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .auth-link:hover {
        color: #003366;
    }

    .brand-text {
        font-family: 'Outfit', sans-serif;
        color: white;
        font-weight: 800;
    }
</style>
@endsection

@section('content')
<div class="hero-header-wrapper">
    <div class="hero-header text-center">
        <div class="container">
            <h1 class="brand-text display-4 mb-2">{{ $school->name ?? 'School Name' }}</h1>
            <p class="text-white opacity-75 fs-5">Academic Elite ERP Portal</p>
        </div>
    </div>
</div>

<div class="container py-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8 px-4 px-md-0">
            <div class="card login-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center">
                        <div class="logo-box">
                            @if($school->logo)
                                <img src="{{ asset($school->logo) }}" alt="Logo">
                            @else
                                <i class="fas fa-university fa-2x text-primary"></i>
                            @endif
                        </div>
                        <h2 class="fw-bolder text-dark mb-1">Welcome Back!</h2>
                        <p class="text-muted mb-4">Please enter your credentials to access your dashboard.</p>
                    </div>

                    <form action="{{ route('school.login', ['tenant' => $school->slug]) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@school.edu" required autofocus>
                            </div>
                            @error('email')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Password</label>
                                <a href="#" class="auth-link small">Forgot Password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            @error('password')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted small" for="remember">Keep me logged in</label>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            Sign In to Portal <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-muted small">
                            Looking to join? <a href="{{ route('school.register.form') }}" class="auth-link">Request Enrollment</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection