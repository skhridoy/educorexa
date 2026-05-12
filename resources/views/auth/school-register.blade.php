@extends('app-layouts.frontend')

@section('content')
<section class="py-5 bg-white" style="margin-top: 80px; min-height: 90vh;">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">Create Your Workspace</h2>
                    <p class="text-muted">স্কুল ম্যানেজমেন্ট সিস্টেম শুরু করতে নিচের তথ্যগুলো দিয়ে ফর্মটি পূরণ করুন।</p>
                </div>

                <!-- সাকসেস মেসেজ দেখানোর জন্য -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- ভ্যালিডেশন এরর মেসেজ দেখানোর জন্য -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="row g-0 shadow-sm border rounded-4 overflow-hidden bg-white">
                    <div class="col-lg-4 bg-light p-4 p-md-5 border-end d-none d-lg-block">
                        <h6 class="fw-bold text-primary mb-4 text-uppercase ls-1">Why EduCorexa?</h6>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex small text-muted">
                                <i class="bi bi-check2-circle text-primary me-2"></i>
                                সম্পূর্ণ অটোমেটেড রেজাল্ট সিস্টেম।
                            </li>
                            <li class="mb-3 d-flex small text-muted">
                                <i class="bi bi-check2-circle text-primary me-2"></i>
                                নিরাপদ ক্লাউড ডাটাবেস।
                            </li>
                            <li class="mb-3 d-flex small text-muted">
                                <i class="bi bi-check2-circle text-primary me-2"></i>
                                মোবাইল ফ্রেন্ডলি ইন্টারফেস।
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-8 p-4 p-md-5">
                        <form method="POST" action="{{ route('school.register.store') }}">
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary">স্কুলের নাম</label>
                                    <input type="text" name="school_name" class="form-control custom-input" id="school_name" placeholder="ABC High School" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary">লগইন সাবডোমেইন</label>
                                    <div class="input-group custom-input-group">
                                        <input type="text" name="slug" id="slug" class="form-control border-end-0" placeholder="abcschool" required>
                                        <span class="input-group-text bg-white text-muted">.{{ request()->getHost() }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">এডমিনের নাম</label>
                                    <input type="text" name="admin_name" class="form-control custom-input" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">ইমেইল</label>
                                    <input type="email" name="admin_email" class="form-control custom-input" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary">পাসওয়ার্ড</label>
                                    <input type="password" name="admin_password" class="form-control custom-input" required>
                                </div>

                                <div class="col-12 mt-4 pt-2">
                                    <button class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-none" type="submit" style="background-color: #6571ff; border: none;">
                                        রেজিস্ট্রেশন সম্পন্ন করুন
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</section>

<style>
    /* ক্লিন ইনপুট স্টাইল */
    .custom-input, .custom-input-group .form-control {
        padding: 12px 15px;
        border: 1px solid #e1e5eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .custom-input:focus, .custom-input-group .form-control:focus {
        border-color: #6571ff;
        box-shadow: none;
        background-color: #fcfcff;
    }

    .custom-input-group .input-group-text {
        border: 1px solid #e1e5eb;
        border-left: 0;
        border-radius: 0 8px 8px 0;
        font-size: 14px;
    }

    .ls-1 { letter-spacing: 1px; }

    /* বাটন হোভার */
    .btn-primary:hover {
        background-color: #525ee5 !important;
    }
</style>
@endsection