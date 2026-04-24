@extends('layouts.guest') {{-- অথবা আপনার মেইন গেস্ট লেআউট --}}

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card shadow-lg">
                        <div class="row">
                            <div class="col-md-4 pe-md-0">
                                <div class="auth-side-wrapper" style="background-image: url({{ asset('assets/images/login-side.jpg') }}); background-size: cover; position: relative;">
                                    {{-- লোগোটিকে ইমেজের মাঝখানে দেখানোর জন্য ওভারলে --}}
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; border-radius: 4px 0 0 4px;">
                                        @php
                                            $site = DB::table('site_settings')->first();
                                        @endphp

                                        @if($site && $site->logo_square)
                                            <img src="{{ asset($site->logo_square) }}" alt="{{ $site->site_name }}" style="max-width: 100px; border-radius: 10px; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));">
                                        @else
                                            <div class="d-inline-flex align-items-center justify-content-center shadow-lg" 
                                                style="background-color: #6571ff; width: 70px; height: 70px; border-radius: 15px;">
                                                <i class="fas fa-user-tie text-white fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2 text-primary">Edu<span>Corexa</span></a>
                                    <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your employee account.</h5>
                                    
                                    @if(session('error'))
                                        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                                    @endif

                                    <form class="forms-sample" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password" required>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="authCheck" name="remember">
                                            <label class="form-check-row" for="authCheck">Remember me</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white w-100">Login</button>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="d-block mt-3 text-muted">Forgot password?</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection