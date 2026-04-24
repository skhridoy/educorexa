@extends('app-layouts.frontend')

@section('content')
<section class="py-5 text-white position-relative overflow-hidden" style="margin-top: 70px; background: linear-gradient(135deg, #0b1324 0%, #1a233a 100%);">
    <div class="container py-5 position-relative z-index-2">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 fw-bold animate-fade-in">LEARN MORE ABOUT US</div>
                <h1 class="display-3 fw-bolder mb-3 tracking-tight">About <span class="text-primary">EduCorexa</span></h1>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 600px;">আমরা শুধু একটি সফটওয়্যার কোম্পানি নই, আমরা ডিজিটাল শিক্ষার নতুন দিগন্ত উন্মোচনে কাজ করা একঝাঁক স্বপ্নদ্রষ্টা।</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none hover-white">Home</a></li>
                        <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">About Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="position-absolute top-0 start-0 bg-primary opacity-10 rounded-circle blur-3xl" style="width: 400px; height: 400px; transform: translate(-30%, -30%);"></div>
    <div class="position-absolute bottom-0 end-0 bg-info opacity-10 rounded-circle blur-3xl" style="width: 300px; height: 300px; transform: translate(30%, 30%);"></div>
</section>

<section class="py-5 bg-white">
    <div class="container py-lg-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="pe-lg-4">
                    <h6 class="text-primary fw-bold text-uppercase small mb-3 ls-2">Our Story</h6>
                    <h2 class="fw-bold text-dark mb-4 display-6">আমাদের চলার পথ এবং <span class="text-primary">লক্ষ্য</span></h2>
                    <p class="text-muted mb-4 fs-6 lh-lg">
                        EduCorexa যাত্রা শুরু করেছিল বাংলাদেশের শিক্ষা ব্যবস্থার প্রশাসনিক জটিলতা দূর করার একটি স্বপ্ন নিয়ে। আমরা শুধু একটি সফটওয়্যার তৈরি করিনি, আমরা তৈরি করেছি একটি ইকোসিস্টেম যা শিক্ষা প্রতিষ্ঠানের শিক্ষক, শিক্ষার্থী এবং অভিভাবকদের একই প্ল্যাটফর্মে নিয়ে আসে।
                    </p>
                    
                    <div class="p-4 bg-light rounded-4 border-start border-primary border-5 mb-4 shadow-sm">
                        <p class="fst-italic text-dark fw-medium mb-0">
                            <i class="bi bi-quote fs-2 text-primary opacity-25 d-block mb-1"></i>
                            "প্রযুক্তি যখন শিক্ষার সাথে মিশে, তখন উজ্জ্বল ভবিষ্যতের সৃষ্টি হয়। আমরা সেই ভবিষ্যত গড়তে প্রতিশ্রুতিবদ্ধ।"
                        </p>
                    </div>
                    
                    <p class="text-muted mb-0 fs-6 lh-lg">
                        আমরা আমাদের ইনফ্রাস্ট্রাকচারে লেটেস্ট Laravel এবং ক্লাউড টেকনোলজি ব্যবহার করি, যা আপনার প্রতিষ্ঠানের ডাটার সর্বোচ্চ নিরাপত্তা নিশ্চিত করে। আমাদের প্রতিটি মডিউল এমনভাবে ডিজাইন করা হয়েছে যেন একজন সাধারণ ব্যবহারকারীও খুব সহজে এটি পরিচালনা করতে পারেন।
                    </p>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="about-image-stack position-relative ps-lg-4">
                    <div class="main-img-box shadow-2xl rounded-5 overflow-hidden border border-5 border-white">
                        <img src="{{ asset('frontend/img/hero.png') }}" class="img-fluid w-100" alt="EduCorexa Mission">
                    </div>
                    <div class="floating-status bg-white p-3 rounded-4 shadow-lg position-absolute top-50 start-0 translate-middle-x d-none d-md-flex align-items-center gap-3">
                        <div class="status-icon bg-success-soft text-success rounded-circle">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <p class="small fw-bold mb-0 text-dark">Data Secured</p>
                            <p class="x-small text-muted mb-0">ISO Certified Cloud</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-5 pt-lg-5">
            <div class="col-md-4">
                <div class="about-card p-4 text-center h-100">
                    <div class="card-icon bg-primary-soft text-primary mx-auto mb-4">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Our Mission</h5>
                    <p class="text-muted small">প্রতিটি শিক্ষা প্রতিষ্ঠানকে একটি সমন্বিত এবং স্বচ্ছ ডিজিটাল ম্যানেজমেন্ট সিস্টেমের আওতায় নিয়ে আসা।</p>
                    <div class="card-hover-line"></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="about-card p-4 text-center h-100 active">
                    <div class="card-icon bg-primary text-white mx-auto mb-4 shadow-primary">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Our Vision</h5>
                    <p class="text-muted small">বাংলাদেশের শীর্ষস্থানীয় এডু-টেক সলিউশন হিসেবে নিজেদের প্রতিষ্ঠিত করা এবং শিক্ষা ব্যবস্থা সহজ করা।</p>
                    <div class="card-hover-line"></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="about-card p-4 text-center h-100">
                    <div class="card-icon bg-primary-soft text-primary mx-auto mb-4">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">Core Values</h5>
                    <p class="text-muted small">সততা, স্বচ্ছতা এবং ব্যবহারকারীর গোপনীয়তা রক্ষা করা আমাদের প্রতিটি পদক্ষেপের মূল ভিত্তি।</p>
                    <div class="card-hover-line"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
    /* ১. ইউটিলিটি ভেরিয়েবল ও হেল্পার */
    .bg-primary-soft { background-color: rgba(101, 113, 255, 0.1); }
    .bg-success-soft { background-color: rgba(16, 183, 89, 0.1); }
    .text-primary { color: #6571ff !important; }
    .ls-2 { letter-spacing: 2px; }
    .x-small { font-size: 0.7rem; }
    .blur-3xl { filter: blur(60px); }
    .z-index-2 { z-index: 2; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    .shadow-primary { box-shadow: 0 10px 20px rgba(101, 113, 255, 0.3); }

    /* ২. হিরো সেকশন ইফেক্ট */
    .hover-white:hover { color: #fff !important; }
    .animate-fade-in { animation: fadeIn 1s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    /* ৩. ইমেজ স্ট্যাক ও ফ্লোটিং কার্ড */
    .about-image-stack { z-index: 1; }
    .status-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .floating-status { min-width: 200px; border: 1px solid rgba(0,0,0,0.05); animation: float 3s ease-in-out infinite; }
    @keyframes float { 0% { transform: translate(-50%, -40%); } 50% { transform: translate(-50%, -60%); } 100% { transform: translate(-50%, -40%); } }

    /* ৪. মডার্ন অ্যাবাউট কার্ড */
    .about-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 24px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    .about-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border-color: #6571ff;
    }
    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        transition: 0.3s;
    }
    .card-hover-line {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 4px;
        background: #6571ff;
        transition: 0.4s ease;
    }
    .about-card:hover .card-hover-line { width: 100%; }
    
    /* ৫. রেসপন্সিভ */
    @media (max-width: 991px) {
        .about-image-stack { margin-top: 50px; }
    }
</style>