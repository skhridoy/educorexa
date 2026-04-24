<section id="pricing" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase mb-2 small" style="letter-spacing: 2px;">Flexible Plans</h6>
            <h2 class="fw-bold text-dark">Choose the Right Plan for Your School</h2>
            <p class="text-muted small mx-auto" style="max-width: 600px;">আপনার প্রতিষ্ঠানের আকার অনুযায়ী সেরা প্যাকেজটি বেছে নিন। কোনো লুকানো চার্জ নেই।</p>
        </div>

        <div class="row g-4 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="pricing-card p-4 p-lg-5 bg-white border-0 shadow-sm rounded-4 text-center">
                    <h5 class="fw-bold mb-1">Starter</h5>
                    <p class="text-muted small mb-4">For Small Institutions</p>
                    <div class="price mb-4">
                        <span class="currency fs-4 fw-bold">৳</span>
                        <span class="amount display-5 fw-bold text-dark">২,৫০০</span>
                        <span class="duration text-muted">/মাস</span>
                    </div>
                    <ul class="list-unstyled mb-4 text-start small mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ৩০০ জন শিক্ষার্থী</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ১০ জন শিক্ষক</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> উপস্থিতি ট্র্যাকিং</li>
                        <li class="mb-2 text-muted"><i class="bi bi-x-circle text-danger me-2"></i> ফি কালেকশন পোর্টাল</li>
                    </ul>
                    <a href="{{ route('school.register.form') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 w-100 fw-bold">Get Started</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="pricing-card p-4 p-lg-5 bg-white border-primary border-top border-5 shadow-lg rounded-4 text-center position-relative active-plan">
                    <div class="popular-badge px-3 py-1 bg-primary text-white small rounded-pill position-absolute top-0 start-50 translate-middle">Most Popular</div>
                    <h5 class="fw-bold mb-1">Standard</h5>
                    <p class="text-muted small mb-4">Perfect for Growing Schools</p>
                    <div class="price mb-4">
                        <span class="currency fs-4 fw-bold">৳</span>
                        <span class="amount display-5 fw-bold text-dark">৫,০০০</span>
                        <span class="duration text-muted">/মাস</span>
                    </div>
                    <ul class="list-unstyled mb-4 text-start small mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ১,০০০ জন শিক্ষার্থী</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> আনলিমিটেড শিক্ষক</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> অনলাইন ফি পেমেন্ট</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> অটোমেটেড রেজাল্ট</li>
                    </ul>
                    <a href="{{ route('school.register.form') }}" class="btn btn-primary rounded-pill px-4 py-3 w-100 fw-bold shadow-sm">Choose Standard</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mx-md-auto">
                <div class="pricing-card p-4 p-lg-5 bg-white border-0 shadow-sm rounded-4 text-center">
                    <h5 class="fw-bold mb-1">Premium</h5>
                    <p class="text-muted small mb-4">Full Control & Features</p>
                    <div class="price mb-4">
                        <span class="currency fs-4 fw-bold">৳</span>
                        <span class="amount display-5 fw-bold text-dark">৮,৫০০</span>
                        <span class="duration text-muted">/মাস</span>
                    </div>
                    <ul class="list-unstyled mb-4 text-start small mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> আনলিমিটেড শিক্ষার্থী</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> কাস্টম ডোমেইন সাপোর্ট</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ট্রান্সপোর্ট ও জিপিএস</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> ৫,০০০ ফ্রি SMS/মাস</li>
                    </ul>
                    <a href="{{ route('school.register.form') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 w-100 fw-bold">Get Premium</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* প্রাইসিং কার্ড স্টাইল */
    .pricing-card {
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .pricing-card:hover {
        transform: translateY(-10px);
    }

    .active-plan {
        transform: scale(1.05);
        z-index: 10;
    }

    @media (max-width: 991px) {
        .active-plan {
            transform: scale(1);
        }
    }

    .popular-badge {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .pricing-card .bi-check-circle-fill {
        font-size: 0.9rem;
    }

    .price .amount {
        letter-spacing: -1px;
    }

    /* বাটন ট্রানজিশন */
    .pricing-card .btn {
        transition: 0.3s;
    }
</style>