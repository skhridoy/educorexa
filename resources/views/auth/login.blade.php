@extends('school.website.layouts.app')

@section('customCSS')
<style>
    .school-logo {
            height: 50px;
            width: auto;
        }
        .school-name {
            font-size: 1.75rem;
            font-weight: 700;
            white-space: normal; 
            line-height: 1.2;
        }
    /* ১. হিরো হেডার ডিজাইন ঠিক করা (আগের সমস্যা সমাধানের জন্য) */
    .hero-header-wrapper {
        margin-top: 0 !important; /* হেডার ওভারল্যাপ সমস্যা সমাধান */
    }
    
    .hero-header {
        background: linear-gradient(rgba(101, 113, 255, .9), rgba(101, 113, 255, .9));
        margin-bottom: 50px;
    }

    /* ২. লোগো এবং আইকন কন্টেইনার */
    .logo-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        position: relative;
    }

    .school-logo-img {
        width: 100px;
        height: 100px;
        object-fit: contain; /* লোগো পুরো দেখানোর জন্য */
        border-radius: 15px; /* হালকা গোল করার জন্য */
        padding: 10px;
        background: white; /* লোগো হাইলাইট করার জন্য সাদা ব্যাকগ্রাউন্ড */
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); /* সুন্দর শ্যাডো */
    }

    /* ৩. ইনপুট আইকন ডিজাইন ঠিক করা */
    .login-form .input-group-text {
        background-color: #f8f9fa; /* হালকা গ্রে ব্যাকগ্রাউন্ড */
        border-right: none;
        color: #7c85ff; /* আপনার প্রাইমারি কালারের হালকা শেড */
        padding-left: 15px;
    }

    .login-form .form-control {
        border-left: none;
        padding-left: 5px;
    }

    .login-form .form-control:focus {
        border-color: #ced4da; /* ডিফল্ট বর্ডার রাখা */
        box-shadow: none; /* ফোকাস শ্যাডো সরানো */
    }
    
    .login-form .input-group:focus-within {
        border-radius: 5px;
        border: 2px solid #6571ff; /* ফোকাস করলে পুরো গ্রুপ বর্ডার হবে */
    }
    
    .login-form .input-group:focus-within .input-group-text {
        border-color: transparent;
    }

    /* ৪. বাটন এনিমেশন */
    .btn-submit {
        background-color: #6571ff;
        border-color: #6571ff;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background-color: #4e59d4 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(101, 113, 255, 0.3);
    }

    @media (max-width: 991.98px) {
            .school-name {
                font-size: 1.1rem; /* মোবাইলে নাম ছোট দেখাবে */
                max-width: 200px;  /* টেক্সট র‍্যাপ করার জন্য একটি নির্দিষ্ট উইডথ */
            }
        .school-logo {
                height: 40px; /* মোবাইলে লোগো সামান্য ছোট */
            }
        }

        /* আরও ছোট স্ক্রিন (যেমন: iPhone SE বা ছোট ফোন) */
        @media (max-width: 575.98px) {
            .school-name {
                font-size: 0.95rem;
                max-width: 150px;
            }
        }
</style>
@endsection

@section('content')
<div class="container-xxl position-relative p-0 hero-header-wrapper">
    

    {{-- হিরো সেকশন --}}
    <div class="container-xxl bg-primary hero-header">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="text-center">
                    <h2 class="display-6 fw-bold text-white animated slideInDown">
                        {{ $school->name ?? 'School Name' }}
                    </h2>
                    <p class="text-white small animated slideInDown">নিরাপদ ড্যাশবোর্ডে লগইন করুন</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- লগইন কার্ড সেকশন --}}
<div class="container-fluid bg-light me-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5 login-form">
                        <div class="text-center mb-4">
                            {{-- ৪. ডাইনামিক স্কুল লোগো সেকশন --}}
                            <div class="logo-container">
                                @if($school->logo)
                                    <img src="{{ asset($school->logo) }}" alt="{{ $school->name }} Logo" class="school-logo-img">
                                @else
                                    {{-- লোগো না থাকলে ডিফল্ট লোকো (Blue Box with Icon) --}}
                                    <div class="d-inline-flex align-items-center justify-content-center" 
                                         style="background-color: #6571ff; width: 80px; height: 80px; border-radius: 20px;">
                                        <i class="fas fa-university text-white fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <h2 class="fw-bold text-dark mb-1">Welcome Back</h2>
                            <p class="text-muted small">লগইন করতে আপনার ইমেইল ও পাসওয়ার্ড দিন</p>
                        </div>

                        {{-- লগইন ফর্ম --}}
                        <form action="{{ route('school.login', ['tenant' => $school->slug]) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        {{-- ২. FontAwesome আইকন ব্যবহার --}}
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}"
                                           placeholder="admin@school.com" required autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label fw-semibold text-muted small">Password</label>
                                    <a href="#" class="text-decoration-none small text-primary fw-medium">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="••••••••" required>
                                </div>
                                @error('password')
                                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted small" for="remember">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-white shadow-sm btn-submit">
                                Sign In <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-2">
                            <p class="text-muted small">Don't have a school account? 
                                <a href="{{ route('school.register.form') }}" class="fw-bold text-decoration-none text-primary">Request Registration</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
{{-- Feater Icon কাজ না করলে, FontAwesome ব্যবহার করা নিরাপদ --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection