<section id="about" class="py-5 bg-white overflow-hidden">
    <div class="container py-lg-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="about-visual-container position-relative">
                    <div class="main-img-box shadow-lg rounded-4 overflow-hidden">
                        <img src="{{ asset('frontend/img/about-vision.jpg') }}" class="img-fluid w-100" alt="About EduCorexa">
                    </div>
                    
                    <div class="floating-badge bg-white shadow-lg p-3 rounded-3 d-flex align-items-center gap-3 animate-up-down">
                        <div class="icon-circle bg-primary-soft text-primary">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">5+ Years</h5>
                            <p class="x-small text-muted mb-0">Industry Success</p>
                        </div>
                    </div>

                    <div class="floating-badge-bottom bg-dark text-white shadow-lg p-3 rounded-3 d-flex align-items-center gap-3 animate-down-up">
                        <div class="icon-circle bg-white-soft text-white">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">24/7</h5>
                            <p class="x-small text-white-50 mb-0">Expert Support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ps-lg-5 text-center text-lg-start">
                    <div class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 small fw-bold">
                        WHO WE ARE
                    </div>
                    <h2 class="display-6 fw-bold text-dark mb-4 lh-base">
                        Revolutionizing School Management with <span class="text-primary border-bottom border-primary border-3">Modern ERP</span>
                    </h2>
                    
                    <p class="text-muted mb-5 lead-small">
                        EduCorexa কোনো সাধারণ সফটওয়্যার নয়, এটি একটি আধুনিক শিক্ষা প্রতিষ্ঠানের ডিজিটাল মেরুদণ্ড। আমরা শিক্ষকদের প্রশাসনিক চাপ কমিয়ে মূল শিক্ষাদানে ফোকাস করার সুযোগ করে দিই।
                    </p>

                    <div class="row g-4 mb-5">
                        <div class="col-sm-6">
                            <div class="feature-item p-3 rounded-3 h-100 border-start border-primary border-4 shadow-sm bg-light">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-shield-lock-fill text-primary me-2"></i>
                                    <h6 class="fw-bold mb-0 small">Secure Infrastructure</h6>
                                </div>
                                <p class="x-small text-muted mb-0">এন্টারপ্রাইজ লেভেল সিকিউরিটি ও ক্লাউড ডাটা এনক্রিপশন।</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-item p-3 rounded-3 h-100 border-start border-dark border-4 shadow-sm bg-light">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-cpu-fill text-dark me-2"></i>
                                    <h6 class="fw-bold mb-0 small">Automated Workflow</h6>
                                </div>
                                <p class="x-small text-muted mb-0">রেজাল্ট জেনারেশন থেকে ফি কালেকশন—সবই এখন অটোমেটেড।</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                        <a href="{{ route('about.details') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg-hover">
                            More About Us
                        </a>
                        <div class="d-flex align-items-center">
                            <div class="avatar-group me-2">
                                <i class="bi bi-telephone-outbound-fill text-primary fs-4"></i>
                            </div>
                            <div class="small">
                                <p class="text-muted mb-0 x-small">Call for Info</p>
                                <p class="fw-bold mb-0">+880 1234 56789</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ১. কালার ভেরিয়েবল */
    .bg-primary-soft { background-color: rgba(101, 113, 255, 0.1); }
    .bg-white-soft { background-color: rgba(255, 255, 255, 0.2); }
    .x-small { font-size: 0.75rem; }
    .lead-small { font-size: 1rem; line-height: 1.8; }

    /* ২. ইমেজ ও ফ্লোটিং কার্ড */
    .about-visual-container {
        padding: 40px;
    }
    .main-img-box {
        transform: rotate(-2deg);
        transition: 0.5s;
    }
    .main-img-box:hover { transform: rotate(0deg); }

    .floating-badge {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        min-width: 180px;
    }
    .floating-badge-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 2;
        min-width: 180px;
    }
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* ৩. অ্যানিমেশন */
    .animate-up-down { animation: upDown 4s ease-in-out infinite; }
    .animate-down-up { animation: downUp 4s ease-in-out infinite; }

    @keyframes upDown {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    @keyframes downUp {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(15px); }
    }

    /* ৪. বাটন হোভার */
    .shadow-lg-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 3rem rgba(101, 113, 255, 0.3) !important;
    }

    /* রেসপন্সিভ ফিক্স */
    @media (max-width: 991px) {
        .about-visual-container { padding: 20px 0; margin-bottom: 30px; }
        .floating-badge, .floating-badge-bottom {
            min-width: 150px;
            padding: 10px !important;
        }
        .main-img-box { transform: rotate(0deg); }
    }
</style>