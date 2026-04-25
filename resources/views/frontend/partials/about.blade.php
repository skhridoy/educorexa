@php
    $section = \App\Models\FrontendSection::where('key', 'about')->first();
    $content = json_decode($section->content ?? '{}', true);
@endphp

<section id="about" class="py-5 bg-white overflow-hidden">
    <div class="container py-lg-5">
        <div class="row align-items-center g-5">
            {{-- ভিজ্যুয়াল কন্টেইনার --}}
            <div class="col-lg-6">
                <div class="about-visual-container position-relative">
                    {{-- মেইন ইমেজ বক্স --}}
                    <div class="main-img-box shadow-lg rounded-4 overflow-hidden">
                        <img src="{{ asset($content['image'] ?? 'frontend/img/about-vision.jpg') }}" class="img-fluid w-100" alt="About EduCorexa">
                    </div>
                    
                    {{-- উপরের সাদা ফ্লোটিং কার্ড --}}
                    <div class="floating-badge bg-white shadow-lg p-3 rounded-3 d-flex align-items-center gap-3 animate-up-down">
                        <div class="icon-circle bg-primary-soft text-primary">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ $content['exp_year'] ?? '5+' }} Years</h5>
                            <p class="x-small text-muted mb-0">{{ $content['exp_text'] ?? 'Industry Success' }}</p>
                        </div>
                    </div>

                    {{-- নিচের কালো ফ্লোটিং কার্ড --}}
                    <div class="floating-badge-bottom bg-dark text-white shadow-lg p-3 rounded-3 d-flex align-items-center gap-3 animate-down-up">
                        <div class="icon-circle bg-white-soft text-white">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">{{ $content['support_time'] ?? '24/7' }}</h5>
                            <p class="x-small text-white-50 mb-0">{{ $content['support_text'] ?? 'Expert Support' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- টেক্সট কন্টেন্ট --}}
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 small fw-bold">
                        WHO WE ARE
                    </div>
                    <h2 class="display-6 fw-bold text-dark mb-4 lh-base">
                        Revolutionizing School Management with <span class="text-primary border-bottom border-primary border-3">Modern ERP</span>
                    </h2>
                    
                    <p class="text-muted mb-5">
                        {{ $content['description'] ?? 'EduCorexa একটি আধুনিক শিক্ষা প্রতিষ্ঠানের ডিজিটাল মেরুদণ্ড।' }}
                    </p>

                    {{-- ফিচার লিস্ট --}}
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6">
                            <div class="feature-item p-3 rounded-3 border-start border-primary border-4 shadow-sm bg-light">
                                <h6 class="fw-bold mb-1 small"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Secure</h6>
                                <p class="x-small text-muted mb-0">এন্টারপ্রাইজ লেভেল সিকিউরিটি।</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-item p-3 rounded-3 border-start border-dark border-4 shadow-sm bg-light">
                                <h6 class="fw-bold mb-1 small"><i class="bi bi-cpu-fill text-dark me-2"></i>Automated</h6>
                                <p class="x-small text-muted mb-0">সবই এখন অটোমেটেড।</p>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg-hover">
                        More About Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-primary-soft { background-color: rgba(101, 113, 255, 0.1); }
    .bg-white-soft { background-color: rgba(255, 255, 255, 0.2); }
    .x-small { font-size: 0.75rem; }

    /* আগের সেই স্টাইলিশ ইমেজ রোটেশন */
    .about-visual-container { padding: 40px; }
    .main-img-box { 
        transform: rotate(-2deg); 
        transition: 0.5s; 
        border: 8px solid #fff;
    }
    .main-img-box:hover { transform: rotate(0deg); }

    /* ফ্লোটিং কার্ড পজিশন */
    .floating-badge {
        position: absolute; top: 0; right: 0; z-index: 2; min-width: 180px;
    }
    .floating-badge-bottom {
        position: absolute; bottom: 0; left: 0; z-index: 2; min-width: 180px;
    }
    .icon-circle {
        width: 45px; height: 45px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    /* অ্যানিমেশন */
    .animate-up-down { animation: upDown 4s ease-in-out infinite; }
    .animate-down-up { animation: downUp 4s ease-in-out infinite; }

    @keyframes upDown { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    @keyframes downUp { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(15px); } }

    @media (max-width: 991px) {
        .about-visual-container { padding: 20px 0; }
        .main-img-box { transform: rotate(0); }
    }
</style>