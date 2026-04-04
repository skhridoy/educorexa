@extends('app-layouts.frontend')

@section('content')
<style>
    /* নেভিগেশন বারের টেক্সট কালার পরিবর্তন (সাদা ব্যাকগ্রাউন্ডের জন্য) */
    .navbar-light .navbar-nav .nav-link {
        color: #333 !important; /* কালচে রঙ */
        font-weight: 500;
    }
    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #00B9FF !important; /* থিম ব্লু কালার */
    }
    .navbar-brand h1 {
        color: #00B9FF !important; /* লোগোর কালার */
    }
    /* রেজিস্ট্রেশন বাটন স্টাইল */
    .btn-register-nav {
        background-color: #00B9FF !important;
        color: #fff !important;
    }
    /* মেইন কন্টেইনার গ্যাপ অ্যাডজাস্ট */
    .registration-section {
        background-color: #f8f9fa; /* হালকা গ্রে ব্যাকগ্রাউন্ড পেজের জন্য */
        padding-top: 120px;
        padding-bottom: 80px;
        min-height: 100vh;
    }
</style>

<div class="registration-section">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 shadow-lg" style="border-radius: 1.5rem;">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="text-center mb-5">
                            <h2 class="fw-bold" style="color: #00B9FF;">Create Your Workspace</h2>
                            <p class="text-muted">স্কুল ম্যানেজমেন্ট সিস্টেম শুরু করতে নিচের তথ্যগুলো দিন</p>
                        </div>

                        <form method="POST" action="{{ route('school.register.store') }}">
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <h6 class="text-uppercase fw-bold mb-3" style="color: #00B9FF; letter-spacing: 1px;">১. স্কুলের সাধারণ তথ্য</h6>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="school_name" class="form-control border-0 bg-light" id="school_name" placeholder="ABC High School" value="{{ old('school_name') }}" required>
                                        <label for="school_name">স্কুলের নাম (School Name)</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label text-muted small ms-2">সাবডোমেইন (এটি আপনার লগইন URL হবে)</label>
                                    <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                        <input type="text" name="slug" id="slug" class="form-control border-0 bg-light py-3" placeholder="abcschool" value="{{ old('slug') }}" required>
                                        <span class="input-group-text border-0 text-white fw-bold" style="background-color: #00B9FF;">.{{ config('app.main_domain') ?? request()->getHost() }}</span>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <h6 class="text-uppercase fw-bold mb-3" style="color: #00B9FF; letter-spacing: 1px;">২. এডমিন প্রোফাইল সেটআপ</h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="admin_name" class="form-control border-0 bg-light" id="admin_name" placeholder="John Doe" value="{{ old('admin_name') }}" required>
                                        <label for="admin_name">এডমিনের নাম</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="admin_email" class="form-control border-0 bg-light" id="admin_email" placeholder="admin@school.com" value="{{ old('admin_email') }}" required>
                                        <label for="admin_email">ইমেইল ঠিকানা</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="password" name="admin_password" class="form-control border-0 bg-light" id="admin_password" placeholder="Password" required>
                                        <label for="admin_password">পাসওয়ার্ড (ন্যূনতম ৮ অক্ষর)</label>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button class="btn w-100 py-3 rounded-pill shadow-sm fw-bold text-white" type="submit" style="background-color: #00B9FF;">
                                        রেজিস্ট্রেশন সম্পন্ন করুন <i class="fa fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('school_name').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase()
                       .replace(/ /g, '-')
                       .replace(/[^\w-]+/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection