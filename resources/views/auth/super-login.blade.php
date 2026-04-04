<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMS - Super Admin Log In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <style>
        /* বাম পাশের ইমেজের জন্য স্টাইল */
        .auth-side-wrapper {
            width: 100%;
            background-size: cover;
            background-position: center;
        }
        .noble-ui-logo {
            font-size: 24px;
            font-weight: 700;
        }

        .password-wrapper .input-group-text {
        border-left: none; /* ইনপুট এবং বাটনের মাঝের বর্ডার সরানো */
        padding-right: 15px;
        cursor: pointer;
    }

    .password-wrapper .form-control:focus {
        border-color: #e8ebf1; /* ফোকাস করলে বর্ডার কালার ঠিক রাখা */
        box-shadow: none;
    }

    .password-wrapper .form-control:focus + .input-group-text {
        border-color: #6571ff; /* ইনপুট ফোকাস হলে আইকন বক্সের বর্ডার কালার চেঞ্জ হবে */
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* আইকন সাইজ ঠিক করা */
    .password-wrapper i {
        width: 18px;
        height: 18px;
    }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-8 mx-auto">
                        <div class="card shadow-lg">
                            <div class="row">
                                <div class="col-md-5 pe-md-0">
                                    <div class="auth-side-wrapper h-100" style="width: 40%; align-items: left;">
                                        <img src="{{ asset('frontend/img/hero.png') }}" alt="School Boy" style="">
                                    </div>
                                </div>
                                <div class="col-md-7 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo d-block mb-2 text-primary">Edu<span>Corexa</span></a>
                                        <h5 class="text-muted fw-normal mb-4">স্বাগতম! সুপার এডমিন প্যানেলে লগইন করুন।</h5>
                                        
                                        {{-- সেশন মেসেজ --}}
                                        @if (Session::has('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (Session::has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ Session::get('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <form class="forms-sample" action="{{ route('super.login') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="userEmail" class="form-label">ইমেইল এড্রেস</label>
                                                <input type="email" name="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="userEmail" placeholder="Email" 
                                                       value="{{ old('email') }}" required autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="userPassword" class="form-label">পাসওয়ার্ড</label>
                                                <div class="input-group password-wrapper">
                                                    <input type="password" name="password" 
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror" 
                                                        id="userPassword" placeholder="Password" required>
                                                    <span class="input-group-text bg-transparent cursor-pointer border-start-0" id="togglePassword">
                                                        <i class="link-icon text-muted" data-feather="eye"></i>
                                                    </span>
                                                </div>
                                                @error('password')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-check mb-3">
                                                <input type="checkbox" name="remember" class="form-check-input" id="authCheck">
                                                <label class="form-check-label" for="authCheck">আমাকে মনে রাখুন</label>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white w-100">
                                                    <i class="btn-icon-prepend" data-feather="log-in"></i> লগইন করুন
                                                </button>
                                            </div>
                                            
                                            <div class="mt-4 text-center">
                                                <a href="#" class="text-muted small">পাসওয়ার্ড ভুলে গেছেন?</a>
                                            </div>
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

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector("#togglePassword");
            const passwordInput = document.querySelector("#userPassword");

            togglePassword.addEventListener("click", function() {
                // টাইপ চেঞ্জ
                const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);
                
                // ফেদার আইকন চেঞ্জ
                const icon = this.querySelector('i');
                const iconName = type === "password" ? "eye" : "eye-off";
                icon.setAttribute("data-feather", iconName);
                
                // পুনরায় আইকন রেন্ডার করা (লারাভেল বা NobleUI এর জন্য জরুরি)
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });
        });
    </script>
</body>
</html>