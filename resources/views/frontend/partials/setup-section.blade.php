<section id="setup-process" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase mb-2 small" style="letter-spacing: 2px;">Easy Onboarding</h6>
            <h2 class="fw-bold text-dark">Get Started in 3 Simple Steps</h2>
            <p class="text-muted small mx-auto" style="max-width: 500px;">মাত্র কয়েক মিনিটেই আপনার স্কুলকে ডিজিটালাইজ করুন। কোনো টেকনিক্যাল নলেজের প্রয়োজন নেই।</p>
        </div>

        <div class="row g-4 position-relative">
            <div class="d-none d-lg-block position-absolute top-50 start-50 translate-middle w-75" style="height: 2px; background: repeating-linear-gradient(to right, #6571ff 0, #6571ff 5px, transparent 5px, transparent 10px); z-index: 0; opacity: 0.2;"></div>

            <div class="col-md-4">
                <div class="setup-card text-center p-4 position-relative bg-white" style="z-index: 1;">
                    <div class="step-number shadow-sm">1</div>
                    <div class="setup-icon-box mb-4 mx-auto">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Register School</h5>
                    <p class="text-muted small px-lg-3">আপনার প্রতিষ্ঠানের নাম, ইমেইল এবং মোবাইল নাম্বার দিয়ে রেজিস্ট্রেশন সম্পন্ন করুন।</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="setup-card text-center p-4 position-relative bg-white" style="z-index: 1;">
                    <div class="step-number shadow-sm">2</div>
                    <div class="setup-icon-box mb-4 mx-auto">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Basic Setup</h5>
                    <p class="text-muted small px-lg-3">ক্লাস, সেকশন এবং ফি স্ট্রাকচার সেটআপ করে আপনার প্যানেলটি প্রস্তুত করুন।</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="setup-card text-center p-4 position-relative bg-white" style="z-index: 1;">
                    <div class="step-number shadow-sm">3</div>
                    <div class="setup-icon-box mb-4 mx-auto">
                        <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Go Live</h5>
                    <p class="text-muted small px-lg-3">স্টুডেন্ট ডাটা আপলোড করুন এবং আপনার স্মার্ট স্কুল ম্যানেজমেন্ট এনজয় করুন।</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('school.register.form') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow">
                Start Your 14-Day Free Trial
            </a>
            <p class="mt-3 small text-muted"><i class="bi bi-shield-check me-1 text-success"></i> No credit card required</p>
        </div>
    </div>
</section>

<style>
    /* সেটআপ সেকশন কাস্টম স্টাইল */
    .setup-card {
        transition: all 0.3s ease;
        border-radius: 20px;
    }

    .setup-icon-box {
        width: 80px;
        height: 80px;
        background: #f8faff;
        color: #6571ff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border: 1px solid rgba(101, 113, 255, 0.1);
        transition: all 0.3s ease;
    }

    .setup-card:hover .setup-icon-box {
        background: #6571ff;
        color: #ffffff;
        transform: rotate(-10deg) scale(1.1);
    }

    .step-number {
        position: absolute;
        top: -10px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: #6571ff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        border: 4px solid white;
    }

    /* রেসপন্সিভ ফিক্স */
    @media (max-width: 767px) {
        .setup-card {
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 30px !important;
        }
        .step-number {
            right: auto;
            left: 50%;
            transform: translateX(-50%);
            top: -20px;
        }
    }
</style>