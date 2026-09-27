@php
    if (!isset($testimonials)) {
        $testimonials = \App\Models\Testimonial::where('is_active', true)->latest()->get();
    }
@endphp

<section id="testimonials" class="ec-testimonials">
    <div class="container ec-testimonials__container">

        {{-- Header --}}
        <div class="ec-testimonials__header text-center" data-aos="fade-up" data-aos-duration="600">
            <span class="ec-testimonials__badge">
                <i class="bi bi-chat-quote-fill me-1"></i>
                প্রতিষ্ঠান প্রধানদের মতামত
            </span>
            <h2 class="ec-testimonials__title">স্কুল পরিচালকরা কী বলছেন?</h2>
            <p class="ec-testimonials__desc">আমাদের ওপর আস্থা রেখেছেন দেশের অসংখ্য শিক্ষা প্রতিষ্ঠান।</p>

            {{-- Rating summary bar --}}
            <div class="ec-testimonials__rating-bar">
                <div class="ec-testimonials__stars">
                    @for($i=1; $i<=5; $i++)
                        <i class="bi bi-star-fill"></i>
                    @endfor
                </div>
                <span class="ec-testimonials__rating-text">৪.৯/৫ গড় রেটিং &nbsp;·&nbsp; ৫০০+ রিভিউ</span>
            </div>
        </div>

        {{-- Swiper --}}
        <div class="swiper ec-testimonials__swiper" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
            <div class="swiper-wrapper pb-4">
                @if(isset($testimonials) && $testimonials->count() > 0)
                    @foreach($testimonials as $testimonial)
                        @php
                            $imageUrl = null;
                            if ($testimonial->user_id && $testimonial->user && $testimonial->user->photo) {
                                $imageUrl = asset($testimonial->user->photo);
                            } elseif ($testimonial->image) {
                                $imageUrl = asset($testimonial->image);
                            } else {
                                $imageUrl = asset('assets/images/profile.webp');
                            }
                        @endphp
                        <div class="swiper-slide">
                            <div class="ec-tcard">
                                {{-- Quote icon --}}
                                <div class="ec-tcard__quote">
                                    <i class="bi bi-quote"></i>
                                </div>

                                {{-- Stars --}}
                                <div class="ec-tcard__stars">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>

                                {{-- Message --}}
                                <p class="ec-tcard__message">"{{ $testimonial->message }}"</p>

                                {{-- Author --}}
                                <div class="ec-tcard__author">
                                    <img src="{{ $imageUrl }}"
                                         onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                                         alt="{{ $testimonial->name }}"
                                         class="ec-tcard__avatar">
                                    <div class="ec-tcard__author-info">
                                        <strong class="ec-tcard__name">{{ $testimonial->name }}</strong>
                                        <span class="ec-tcard__role">
                                            {{ $testimonial->designation }}
                                            @if($testimonial->designation && $testimonial->institution_name) &nbsp;·&nbsp; @endif
                                            {{ $testimonial->institution_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <div class="ec-tcard ec-tcard--empty text-center py-5">
                            <i class="bi bi-chat-dots text-muted" style="font-size:3rem;"></i>
                            <p class="text-muted mt-3 fst-italic">এখনও কোনো রিভিউ নেই।</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>
</section>

<style>
/* ===== EC TESTIMONIALS ===== */
.ec-testimonials {
    padding: 72px 0 64px;
    background: linear-gradient(180deg, #fff 0%, #f8faff 100%);
    position: relative;
    overflow: hidden;
}
.ec-testimonials::before {
    content: '"';
    position: absolute; top: 20px; left: 5%;
    font-size: 280px; font-weight: 900; line-height: 1;
    color: rgba(70,72,212,.04);
    pointer-events: none; user-select: none;
}

.ec-testimonials__container { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

/* Header */
.ec-testimonials__header { margin-bottom: 44px; }
.ec-testimonials__badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(70,72,212,.1); color: #4648d4;
    font-size: 12px; font-weight: 800; letter-spacing:.08em; text-transform: uppercase;
    padding: 7px 20px; border-radius: 50px; border: 1px solid rgba(70,72,212,.18);
    margin-bottom: 14px;
}
.ec-testimonials__title {
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 900; color: #0f172a; margin-bottom: 10px;
}
.ec-testimonials__desc { color: #64748b; font-size: 15px; margin-bottom: 20px; }
.ec-testimonials__rating-bar {
    display: inline-flex; align-items: center; gap: 10px;
    background: #fffbeb; border: 1px solid #fde68a;
    padding: 8px 18px; border-radius: 50px;
}
.ec-testimonials__stars { color: #f59e0b; font-size: 14px; letter-spacing: 2px; }
.ec-testimonials__rating-text { font-size: 12.5px; font-weight: 700; color: #92400e; }

/* Testimonial Card */
.ec-tcard {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 28px 24px;
    height: 100%;
    position: relative;
    transition: transform .3s ease, box-shadow .3s ease;
    display: flex; flex-direction: column; gap: 14px;
}
.ec-tcard:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(70,72,212,.12);
    border-color: #c7c4ff;
}

.ec-tcard__quote {
    position: absolute; top: -12px; left: 24px;
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #4648d4, #6366f1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px;
    box-shadow: 0 4px 12px rgba(70,72,212,.3);
}

.ec-tcard__stars { font-size: 13px; letter-spacing: 1px; }

.ec-tcard__message {
    font-size: 14px; color: #475569;
    line-height: 1.7; font-style: italic;
    flex-grow: 1; margin: 0;
}

.ec-tcard__author {
    display: flex; align-items: center; gap: 12px;
    padding-top: 14px; border-top: 1px solid #f1f5f9;
}
.ec-tcard__avatar {
    width: 46px; height: 46px; border-radius: 50%;
    object-fit: cover; flex-shrink: 0;
    border: 2px solid #e0e7ff;
}
.ec-tcard__name { display: block; font-size: 14px; font-weight: 800; color: #0f172a; }
.ec-tcard__role { font-size: 11.5px; color: #94a3b8; font-weight: 600; }

/* Pagination */
.ec-testimonials__swiper .swiper-pagination-bullet { background: #c7c4ff; opacity: 1; }
.ec-testimonials__swiper .swiper-pagination-bullet-active { background: #4648d4; }

@media (max-width: 575px) {
    .ec-testimonials { padding: 48px 0 44px; }
    .ec-tcard { padding: 24px 18px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper(".ec-testimonials__swiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: {
            640:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
});
</script>