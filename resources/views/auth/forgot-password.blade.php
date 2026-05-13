@extends('layouts.guest')

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
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; border-radius: 4px 0 0 4px;">
                                        @php
                                            $site = DB::table('site_settings')->first();
                                        @endphp

                                        @if($site && $site->logo_square)
                                            <img src="{{ asset($site->logo_square) }}" alt="{{ $site->site_name }}" style="max-width: 100px; border-radius: 10px; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));">
                                        @else
                                            <div class="d-inline-flex align-items-center justify-content-center shadow-lg" 
                                                style="background-color: #6571ff; width: 70px; height: 70px; border-radius: 15px;">
                                                <i class="fas fa-key text-white fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2 text-primary">Edu<span>Corexa</span></a>
                                    <h5 class="text-muted fw-normal mb-4">Forgot Password? No problem. Just let us know your email address and we will email you a password reset link.</h5>
                                    
                                    @if(session('status'))
                                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger mb-3">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="forms-sample" action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Enter your registered email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white w-100">Email Password Reset Link</button>
                                        </div>
                                        <a href="{{ route('login.form') }}" class="d-block mt-3 text-muted">Back to Login</a>
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
