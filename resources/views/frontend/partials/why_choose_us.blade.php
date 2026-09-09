@php
    use Illuminate\Support\Str;

    $section = \App\Models\FrontendSection::where('key', 'why_choose_us')->first();
    $content = json_decode($section->content ?? '{}', true);

    $title       = $content['title']       ?? 'কেন EduCorexa বেছে নেবেন?';
    $description = $content['description'] ?? 'আমরা শুধু একটি সফটওয়্যার দিই না — দিচ্ছি একটি পূর্ণাঙ্গ শিক্ষা ব্যবস্থাপনা ইকোসিস্টেম, যা আপনার প্রতিষ্ঠানকে ডিজিটাল যুগে নিয়ে যাবে।';
    $btn_text    = $content['btn_text']    ?? 'আরও জানুন';
    $btn_link    = $content['btn_link']    ?? '#contact';

    // Dynamic image — panel saves as uploads/frontend/*, fallback = hero-dashboard.jpg
    $rawImage = $content['image'] ?? null;
    if (!$rawImage) {
        $image = asset('frontend/images/hero-dashboard.jpg');
    } elseif (Str::startsWith($rawImage, ['http://', 'https://'])) {
        $image = $rawImage;
    } elseif (Str::startsWith($rawImage, 'data:')) {
        $image = $rawImage;          // base64 (edge case)
    } else {
        $image = asset($rawImage);   // e.g. uploads/frontend/hero_xxx.png
    }

    $points = [
        [
            'icon'  => 'bi-shield-check',
            'color' => '#22c55e',
            'bg'    => '#dcfce7',
            'title' => $content['point1_title'] ?? '১০০% নিরাপদ ও নির্ভরযোগ্য',
            'desc'  => $content['point1_desc']  ?? 'আপনার প্রতিষ্ঠানের সকল ডেটা এনক্রিপ্টেড ও সুরক্ষিত। নিয়মিত ব্যাকআপ নিশ্চিত করা হয়।',
        ],
        [
            'icon'  => 'bi-laptop',
            'color' => '#0061A8',
            'bg'    => '#dbeafe',
            'title' => $content['point2_title'] ?? 'সহজ ও স্বজ্ঞাত ইন্টারফেস',
            'desc'  => $content['point2_desc']  ?? 'যেকোনো বয়সের শিক্ষক বা কর্মকর্তা সহজেই ব্যবহার করতে পারবেন — কোনো প্রশিক্ষণ ছাড়াই।',
        ],
        [
            'icon'  => 'bi-headset',
            'color' => '#9333ea',
            'bg'    => '#f3e8ff',
            'title' => $content['point3_title'] ?? '২৪/৭ ডেডিকেটেড সাপোর্ট',
            'desc'  => $content['point3_desc']  ?? 'আমাদের সাপোর্ট টিম সবসময় আপনার পাশে। ফোন, ইমেইল ও লাইভ চ্যাটে সহায়তা পাবেন।',
        ],
        [
            'icon'  => 'bi-graph-up-arrow',
            'color' => '#ea580c',
            'bg'    => '#ffedd5',
            'title' => $content['point4_title'] ?? 'রিয়েল-টাইম রিপোর্ট ও বিশ্লেষণ',
            'desc'  => $content['point4_desc']  ?? 'স্মার্ট ড্যাশবোর্ডে তাৎক্ষণিক রিপোর্ট দেখুন এবং তথ্যভিত্তিক সিদ্ধান্ত নিন।',
        ],
    ];

@endphp

{{-- ======= WHY CHOOSE US SECTION ======= --}}
<section id="why-choose-us" class="wcu-section">

    {{-- Decorative bg rings (matching hero/features style) --}}
    <div class="wcu-ring wcu-ring--1"></div>
    <div class="wcu-ring wcu-ring--2"></div>

    <div class="container wcu-container">
        <div class="row align-items-center g-5">

            {{-- ===== LEFT: Image side ===== --}}
            <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right" data-aos-duration="900">
                <div class="wcu-img-wrapper">

                    {{-- Blue glow --}}
                    <div class="wcu-img-glow"></div>

                    {{-- Main image --}}
                    <img src="{{ $image }}"
                         alt="EduCorexa — কেন বেছে নেবেন"
                         class="wcu-img">

                    {{-- Floating badge: Top Rated --}}
                    <div class="wcu-badge wcu-badge--star">
                        <div class="wcu-badge__icon" style="background:#fef9c3; color:#ca8a04;">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="wcu-badge__text">
                            <span class="wcu-badge__title">Top Rated</span>
                            <span class="wcu-badge__sub">ERP Solution</span>
                        </div>
                    </div>

                    {{-- Floating badge: Trusted --}}
                    <div class="wcu-badge wcu-badge--trust">
                        <div class="wcu-badge__icon" style="background:#dcfce7; color:#16a34a;">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div class="wcu-badge__text">
                            <span class="wcu-badge__title">বিশ্বস্ত</span>
                            <span class="wcu-badge__sub">২০+ প্রতিষ্ঠান</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== RIGHT: Content side ===== --}}
            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-duration="900">

                {{-- Badge --}}
                <div class="wcu-eyebrow">
                    <span class="wcu-eyebrow__dot"></span>
                    কেন আমরা আলাদা
                </div>

                {{-- Heading --}}
                <h2 class="wcu-title">{{ $title }}</h2>

                {{-- Description --}}
                <p class="wcu-desc">{{ $description }}</p>

                {{-- Points list --}}
                <div class="wcu-points">
                    @foreach($points as $i => $point)
                    <div class="wcu-point"
                         data-aos="fade-up"
                         data-aos-duration="600"
                         data-aos-delay="{{ 80 + $i * 80 }}">
                        <div class="wcu-point__icon"
                             style="background: {{ $point['bg'] }}; color: {{ $point['color'] }};">
                            <i class="bi {{ $point['icon'] }}"></i>
                        </div>
                        <div class="wcu-point__body">
                            <h4 class="wcu-point__title">{{ $point['title'] }}</h4>
                            <p class="wcu-point__desc">{{ $point['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <a href="{{ $btn_link }}" class="wcu-cta">
                    <span>{{ $btn_text }}</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>
        </div>
    </div>
</section>

<style>
/* ============================================================
   WHY CHOOSE US — matched to hero/navbar design system
   Poppins • #0061A8 primary • dashed rings • floating cards
   ============================================================ */

/* ---- Section base ---- */
.wcu-section {
    position: relative;
    padding: 90px 0 80px;
    background: #fff;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

/* Decorative dashed rings */
.wcu-ring {
    position: absolute;
    border-radius: 50%;
    border: 2px dashed;
    pointer-events: none;
}
.wcu-ring--1 {
    width: 460px; height: 460px;
    border-color: #0061A8;
    opacity: 0.06;
    top: -160px; right: -120px;
    animation: wcu-spin 30s linear infinite;
}
.wcu-ring--2 {
    width: 300px; height: 300px;
    border-color: #FF5722;
    opacity: 0.06;
    bottom: -100px; left: -80px;
    animation: wcu-spin 22s linear infinite reverse;
}
@keyframes wcu-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.wcu-container { position: relative; z-index: 2; }

/* ---- Image wrapper ---- */
.wcu-img-wrapper {
    position: relative;
    max-width: 520px;
    margin: 0 auto;
}
.wcu-img-glow {
    position: absolute;
    inset: 8%;
    background: radial-gradient(ellipse at center,
        rgba(0, 97, 168, 0.18) 0%, transparent 70%);
    filter: blur(40px);
    z-index: 0;
    border-radius: 50%;
}
.wcu-img {
    position: relative;
    z-index: 2;
    width: 100%;
    border-radius: 22px;
    box-shadow:
        0 24px 70px rgba(0, 97, 168, 0.16),
        0 0 0 1px rgba(0, 97, 168, 0.07);
    display: block;
    transform: perspective(900px) rotateY(4deg) rotateX(-2deg);
    transition: transform 0.6s ease;
}
.wcu-img-wrapper:hover .wcu-img {
    transform: perspective(900px) rotateY(0deg) rotateX(0deg);
}

/* ---- Floating badges ---- */
.wcu-badge {
    position: absolute;
    background: #fff;
    border-radius: 14px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 36px rgba(0,0,0,0.12);
    z-index: 10;
    border: 1px solid rgba(255,255,255,0.9);
    animation: wcu-float 5s ease-in-out infinite;
}
.wcu-badge--star  { bottom: 10%; left: -4%; animation-delay: 0s; }
.wcu-badge--trust { top: 12%;  right: -4%; animation-delay: 2s; }
@keyframes wcu-float {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
}
.wcu-badge__icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.wcu-badge__text {
    display: flex; flex-direction: column; gap: 1px;
}
.wcu-badge__title {
    font-size: 13px; font-weight: 800;
    color: #1e293b; line-height: 1.1;
    white-space: nowrap;
}
.wcu-badge__sub {
    font-size: 10.5px; font-weight: 500;
    color: #64748b; white-space: nowrap;
}

/* ---- Eyebrow badge ---- */
.wcu-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #e8f3fb;
    color: #0061A8;
    font-size: 12.5px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 50px;
    margin-bottom: 18px;
    border: 1px solid rgba(0, 97, 168, 0.2);
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.wcu-eyebrow__dot {
    display: inline-block;
    width: 7px; height: 7px;
    background: #0061A8;
    border-radius: 50%;
    animation: wcu-pulse 2s ease-in-out infinite;
}
@keyframes wcu-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.5); opacity: 0.55; }
}

/* ---- Heading ---- */
.wcu-title {
    font-size: clamp(24px, 3.2vw, 40px);
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
    letter-spacing: -0.5px;
    margin-bottom: 14px;
    font-family: 'Poppins', sans-serif;
}

/* ---- Description ---- */
.wcu-desc {
    font-size: 15.5px;
    color: #64748b;
    line-height: 1.82;
    margin-bottom: 32px;
    font-weight: 400;
    max-width: 520px;
}

/* ---- Points list ---- */
.wcu-points {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 34px;
}

.wcu-point {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px 20px;
    background: #fff;
    border: 1.5px solid rgba(0, 97, 168, 0.08);
    border-radius: 16px;
    box-shadow: 0 2px 14px rgba(0, 97, 168, 0.05);
    cursor: default;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
/* Left accent line */
.wcu-point::before {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 3px;
    background: linear-gradient(180deg, #0061A8, #0080d4);
    border-radius: 0 4px 4px 0;
    transform: scaleY(0);
    transform-origin: center;
    transition: transform 0.3s ease;
}
.wcu-point:hover::before { transform: scaleY(1); }
.wcu-point:hover {
    transform: translateX(6px);
    border-color: rgba(0, 97, 168, 0.2);
    box-shadow: 0 8px 28px rgba(0, 97, 168, 0.10);
}

.wcu-point__icon {
    width: 46px; height: 46px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}
.wcu-point:hover .wcu-point__icon {
    transform: scale(1.1) rotate(-5deg);
}

.wcu-point__body { flex: 1; }

.wcu-point__title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 5px;
    line-height: 1.3;
    font-family: 'Poppins', sans-serif;
}
.wcu-point__desc {
    font-size: 13px;
    color: #64748b;
    line-height: 1.65;
    margin: 0;
    font-weight: 400;
}

/* ---- CTA Button ---- */
.wcu-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 26px;
    background: linear-gradient(135deg, #0061A8 0%, #0080d4 100%);
    color: #fff !important;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 22px rgba(0, 97, 168, 0.32);
    font-family: 'Poppins', sans-serif;
}
.wcu-cta:hover {
    background: linear-gradient(135deg, #004c84 0%, #0061A8 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0, 97, 168, 0.42);
    color: #fff !important;
    text-decoration: none;
}
.wcu-cta i { transition: transform 0.3s; }
.wcu-cta:hover i { transform: translateX(4px); }

/* ---- Responsive ---- */
@media (max-width: 991px) {
    .wcu-section { padding: 60px 0 50px; }
    .wcu-badge--trust { right: 0; }
    .wcu-badge--star  { left: 0; }
}
@media (max-width: 575px) {
    .wcu-title { font-size: clamp(20px, 6vw, 28px); }
    .wcu-point { padding: 14px 16px; gap: 12px; }
    .wcu-point__icon { width: 40px; height: 40px; font-size: 17px; }
    .wcu-point__title { font-size: 14px; }
    .wcu-point__desc  { font-size: 12.5px; }
    .wcu-badge { padding: 8px 10px; gap: 7px; }
    .wcu-ring--1 { width: 280px; height: 280px; }
    .wcu-ring--2 { width: 180px; height: 180px; }
}
</style>