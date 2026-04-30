<section id="pricing" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase mb-2 small" style="letter-spacing: 2px;">{{ $content['subtitle'] ?? 'Flexible Plans' }}</h6>
            <h2 class="fw-bold text-dark">{{ $content['title'] ?? 'Choose the Right Plan for Your School' }}</h2>
            <p class="text-muted small mx-auto" style="max-width: 600px;">{{ $content['description'] ?? 'আপনার প্রতিষ্ঠানের আকার অনুযায়ী সেরা প্যাকেজটি বেছে নিন। কোনো লুকানো চার্জ নেই।' }}</p>
        </div>

        <div class="row g-4 justify-content-center">
            @if(isset($packages) && $packages->count() > 0)
                @foreach($packages as $package)
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card p-4 p-lg-5 bg-white shadow-sm rounded-4 text-center position-relative {{ $package->is_popular ? 'border-primary border-top border-5 shadow-lg active-plan' : 'border-0' }}">
                        @if($package->is_popular)
                        <div class="popular-badge px-3 py-1 bg-primary text-white small rounded-pill position-absolute top-0 start-50 translate-middle">Most Popular</div>
                        @endif
                        <h5 class="fw-bold mb-1">{{ $package->name }}</h5>
                        <p class="text-muted small mb-4">{{ $package->description }}</p>
                        <div class="price mb-4">
                            <span class="currency fs-4 fw-bold">৳</span>
                            <span class="amount display-5 fw-bold text-dark">{{ number_format($package->price) }}</span>
                            <span class="duration text-muted">/{{ $package->duration == 'monthly' ? 'মাস' : 'বছর' }}</span>
                        </div>
                        <ul class="list-unstyled mb-4 text-start small mx-auto" style="max-width: 250px;">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> {{ $package->student_limit ? $package->student_limit . ' জন শিক্ষার্থী' : 'আনলিমিটেড শিক্ষার্থী' }}</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> {{ $package->teacher_limit ? $package->teacher_limit . ' জন শিক্ষক' : 'আনলিমিটেড শিক্ষক' }}</li>
                            @if(is_array($package->features))
                                @foreach($package->features as $feature)
                                    @if(str_starts_with(trim($feature), '-'))
                                        <li class="mb-2 text-muted"><i class="bi bi-x-circle text-danger me-2"></i> {{ ltrim(trim($feature), '- ') }}</li>
                                    @else
                                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> {{ ltrim(trim($feature), '+ ') }}</li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <a href="{{ route('school.register.form') }}" class="btn {{ $package->is_popular ? 'btn-primary py-3 shadow-sm' : 'btn-outline-primary py-2' }} rounded-pill px-4 w-100 fw-bold">
                            {{ $package->is_popular ? 'Choose ' . $package->name : 'Get ' . $package->name }}
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center text-muted">
                    <p>No pricing plans are currently available.</p>
                </div>
            @endif
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