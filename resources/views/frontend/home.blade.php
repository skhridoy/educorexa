@extends('app-layouts.frontend')

@section('content')
@include('frontend.partials.hero');
<section id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-bold text-dark mb-2">Comprehensive Modules</h2>
            <p class="text-muted">Everything you need to manage your institution efficiently</p>
            <hr class="mx-auto bg-primary opacity-100" style="width: 60px; height: 3px;">
        </div>

        <div class="row g-4">
            @php
                $modules = [
                    ['title' => 'Admission Management', 'icon' => 'user-plus', 'desc' => 'অনলাইন ও অফলাইন অ্যাডমিশন প্রক্রিয়া।'],
                    ['title' => 'Student Attendance', 'icon' => 'calendar', 'desc' => 'অটোমেটেড উপস্থিতি ট্র্যাকিং সিস্টেম।'],
                    ['title' => 'Fees & Collection', 'icon' => 'credit-card', 'desc' => 'সহজ পেমেন্ট গেটওয়ে ও ইনভয়েস জেনারেটর।'],
                    ['title' => 'Examination & Results', 'icon' => 'award', 'desc' => 'স্মার্ট মার্কশিট ও রেজাল্ট পাবলিশিং।'],
                    ['title' => 'Payroll & HR', 'icon' => 'users', 'desc' => 'শিক্ষক ও স্টাফদের স্যালারি ম্যানেজমেন্ট।'],
                    ['title' => 'Library Management', 'icon' => 'book-open', 'desc' => 'বই আদান-প্রদান ও ডিজিটাল ক্যাটালগ।'],
                    ['title' => 'Transport & GPS', 'icon' => 'truck', 'desc' => 'স্কুল বাসের রুট ও ফি ট্র্যাকিং।'],
                    ['title' => 'Inventory System', 'icon' => 'package', 'desc' => 'স্কুল সম্পদ ও স্টোক ম্যানেজমেন্ট।']
                ];
            @endphp

            @foreach($modules as $m)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="module-item text-center p-4 border rounded-3 hover-shadow transition h-100">
                    <div class="icon-box mb-3 mx-auto">
                        <i data-feather="{{ $m['icon'] }}"></i> 
                    </div>
                    <h6 class="fw-bold text-dark mb-2">{{ $m['title'] }}</h6>
                    <p class="small text-muted mb-0 d-none d-md-block">{{ $m['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset('frontend/img/hero.jpg') }}" class="img-fluid rounded-4 shadow" alt="Features">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Why Choose <span class="text-primary">EduCorexa</span> ERP?</h2>
                <p class="text-muted mb-4">আমরা শুধুমাত্র একটি সফটওয়্যার দিই না, আমরা দিচ্ছি একটি পূর্ণাঙ্গ এডুকেশন ইকোসিস্টেম।</p>
                
                <div class="d-flex mb-3">
                    <i class="bi bi-patch-check-fill text-success fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">100% Secure & Reliable</h6>
                        <p class="small text-muted">আপনার ডাটা আমাদের কাছে একদম নিরাপদ।</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="bi bi-patch-check-fill text-success fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">User Friendly Interface</h6>
                        <p class="small text-muted">সহজ ইউজার ইন্টারফেস, যা যে কেউ ব্যবহার করতে পারবে।</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#contact" class="btn btn-primary px-4 py-2">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.partials.setup-section');
@include('frontend.partials.pricing');
@include('frontend.partials.about');
@include('frontend.partials.testimonials');
@include('frontend.partials.contact');

<style>
    .icon-box {
        width: 70px;
        height: 70px;
        background: rgba(101, 113, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6571ff;
    }

    /* এটি নিশ্চিত করবে আইকনের সাইজ ঠিক আছে কি না */
    .icon-box svg {
        width: 32px !important;
        height: 32px !important;
        stroke-width: 2;
    }


    .floating-animation {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>
@endsection