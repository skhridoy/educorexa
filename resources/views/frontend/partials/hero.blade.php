@php
    use App\Models\FrontendSection;
    use Illuminate\Support\Str;

    $heroSection = $section ?? FrontendSection::where('key', 'hero')->first();
    $heroContent = [];
    if ($heroSection) {
        $heroContent = json_decode($heroSection->content, true) ?? [];
    }

    $title       = $heroContent['title']       ?? 'সবচেয়ে আধুনিক<br><span class="hero-title-highlight">শিক্ষা ব্যবস্থাপনা সফটওয়্যার</span>';
    $description = $heroContent['description'] ?? 'EduCorexa হলো স্কুল, কলেজ ও মাদ্রাসার জন্য সম্পূর্ণ ক্লাউড-ভিত্তিক শিক্ষা ব্যবস্থাপনা সিস্টেম — ভর্তি, হাজিরা, পরীক্ষা, ফি ও অভিভাবক যোগাযোগ এক জায়গায়।';

    // Dynamic button text & links — fully editable from admin panel
    $btn1_text   = $heroContent['btn1_text']   ?? 'বিনামূল্যে শুরু করুন';
    $btn1_link   = $heroContent['btn1_link']   ?? route('school.register.form');
    $btn2_text   = $heroContent['btn2_text']   ?? 'ডেমো দেখুন';
    $btn2_link   = $heroContent['btn2_link']   ?? '#';

    // Dynamic image — panel saves to uploads/frontend/, fallback = hero-dashboard.jpg
    $rawImage = $heroContent['image'] ?? null;
    if (!$rawImage) {
        // No image set in panel → use default
        $image = asset('frontend/images/hero-dashboard.jpg');
    } elseif (Str::startsWith($rawImage, ['http://', 'https://'])) {
        // Already a full URL (external)
        $image = $rawImage;
    } elseif (Str::startsWith($rawImage, 'data:')) {
        // Base64 data URI (rare, but guard against it)
        $image = $rawImage;
    } else {
        // Relative path saved by controller e.g. "uploads/frontend/hero_xxx.png"
        $image = asset($rawImage);
    }
@endphp

{{-- ======= HERO SECTION (ieducore.net inspired) ======= --}}
<section id="hero-section" class="ec-hero d-flex align-items-center">

    {{-- Dark-to-transparent top overlay so transparent navbar text stays visible --}}
    <div class="ec-hero__nav-overlay"></div>

    {{-- Decorative dashed ring ornaments --}}
    <div class="ec-hero__ring ec-hero__ring--1"></div>
    <div class="ec-hero__ring ec-hero__ring--2"></div>
    <div class="ec-hero__ring ec-hero__ring--3"></div>

    {{-- Floating accent dots --}}
    <div class="ec-hero__dot ec-hero__dot--a"></div>
    <div class="ec-hero__dot ec-hero__dot--b"></div>
    <div class="ec-hero__dot ec-hero__dot--c"></div>

    <div class="container ec-hero__container">
        <div class="row align-items-center g-4 g-lg-5">

            {{-- LEFT: Text Content --}}
            <div class="col-lg-6 ec-hero__content" data-aos="fade-right" data-aos-duration="900">

                {{-- Animated badge --}}
                <div class="ec-hero__badge">
                    <span class="ec-hero__badge-dot"></span>
                    বাংলাদেশের #১ স্কুল ম্যানেজমেন্ট সফটওয়্যার
                </div>

                {{-- Main heading --}}
                <h1 class="ec-hero__title">
                    {!! $title !!}
                </h1>

                {{-- Description --}}
                <p class="ec-hero__description">{{ $description }}</p>

                {{-- CTA Buttons --}}
                <div class="ec-hero__actions">
                    <a href="{{ $btn1_link }}" class="ec-btn ec-btn--primary">
                        <span>{{ $btn1_text }}</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ $btn2_link }}" class="ec-btn ec-btn--outline">
                        <span class="ec-btn__play-icon">
                            <i class="bi bi-play-fill"></i>
                        </span>
                        <span>{{ $btn2_text }}</span>
                    </a>
                </div>

                {{-- Stats row --}}
                <div class="ec-hero__stats">
                    <div class="ec-hero__stat">
                        <span class="ec-hero__stat-num">২৫০০+</span>
                        <span class="ec-hero__stat-label">শিক্ষার্থী</span>
                    </div>
                    <div class="ec-hero__stat-divider"></div>
                    <div class="ec-hero__stat">
                        <span class="ec-hero__stat-num">৫০+</span>
                        <span class="ec-hero__stat-label">ফিচার</span>
                    </div>
                    <div class="ec-hero__stat-divider"></div>
                    <div class="ec-hero__stat">
                        <span class="ec-hero__stat-num">২০+</span>
                        <span class="ec-hero__stat-label">প্রতিষ্ঠান</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Dashboard Image + Floating Cards --}}
            <div class="col-lg-6 ec-hero__graphic" data-aos="zoom-out" data-aos-duration="1000" data-aos-delay="200">
                <div class="ec-hero__img-wrapper">

                    {{-- Blue glow behind image --}}
                    <div class="ec-hero__img-glow"></div>

                    {{-- Main dashboard screenshot --}}
                    <img src="{{ $image }}" alt="EduCorexa School Management Dashboard" class="ec-hero__img">

                    {{-- Floating Card: Students --}}
                    <div class="ec-float-card ec-float-card--students">
                        <div class="ec-float-card__icon ec-float-card__icon--blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ec-float-card__content">
                            <span class="ec-float-card__num">২৫০০+</span>
                            <span class="ec-float-card__label">শিক্ষার্থী</span>
                        </div>
                    </div>

                    {{-- Floating Card: Attendance --}}
                    <div class="ec-float-card ec-float-card--attendance">
                        <div class="ec-float-card__icon ec-float-card__icon--green">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div class="ec-float-card__content">
                            <span class="ec-float-card__num">৯৮%</span>
                            <span class="ec-float-card__label">উপস্থিতি হার</span>
                        </div>
                    </div>

                    {{-- Floating Card: Schools --}}
                    <div class="ec-float-card ec-float-card--schools">
                        <div class="ec-float-card__icon ec-float-card__icon--orange">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="ec-float-card__content">
                            <span class="ec-float-card__num">২০+</span>
                            <span class="ec-float-card__label">প্রতিষ্ঠান</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* =====================================================
   EDUCOREXA HERO — ieducore.net inspired design
   ===================================================== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

/* CSS Variables */
.ec-hero {
    --ec-primary:       #0061A8;
    --ec-primary-dark:  #004c84;
    --ec-primary-light: #e8f3fb;
    --ec-accent:        #FF5722;
    --ec-green:         #22c55e;
    --ec-text:          #1e293b;
    --ec-muted:         #64748b;
    --ec-white:         #ffffff;
}

/* Hero base */
.ec-hero {
    position: relative;
    min-height: 100vh;
    /* Deeper blue gradient — makes white navbar text visible on transparent bg */
    background: linear-gradient(135deg, #004f8a 0%, #0061A8 25%, #e8f3fb 65%, #fff8f6 100%);
    overflow: hidden;
    padding: 140px 0 80px;
    font-family: 'Poppins', sans-serif;
}

/* Dark-to-transparent overlay at the very top — keeps navbar legible */
.ec-hero__nav-overlay {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 160px;
    background: linear-gradient(
        to bottom,
        rgba(0, 40, 80, 0.38) 0%,
        rgba(0, 40, 80, 0.10) 70%,
        transparent 100%
    );
    pointer-events: none;
    z-index: 1;
}

@media (max-width: 991px) {
    .ec-hero { min-height: auto; padding: 90px 0 60px; }
    .ec-hero__nav-overlay { height: 100px; }
}

/* Container z-index above decorations */
.ec-hero__container { position: relative; z-index: 5; }

/* ---- Decorative Dashed Rings (ieducore signature) ---- */
.ec-hero__ring {
    position: absolute;
    border-radius: 50%;
    border: 2.5px dashed;
    pointer-events: none;
}
.ec-hero__ring--1 {
    width: 520px; height: 520px;
    border-color: #0061A8;
    opacity: 0.14;
    top: -200px; right: -140px;
    animation: ec-ring-spin 25s linear infinite;
}
.ec-hero__ring--2 {
    width: 360px; height: 360px;
    border-color: #FF5722;
    opacity: 0.14;
    bottom: -110px; left: -110px;
    animation: ec-ring-spin 18s linear infinite reverse;
}
.ec-hero__ring--3 {
    width: 230px; height: 230px;
    border-color: #0061A8;
    opacity: 0.09;
    top: 38%; right: 4%;
    animation: ec-ring-spin 32s linear infinite;
}
@keyframes ec-ring-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

/* ---- Floating Dots ---- */
.ec-hero__dot {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.ec-hero__dot--a {
    width: 18px; height: 18px;
    background: #0061A8; opacity: 0.22;
    top: 16%; left: 7%;
    animation: ec-float 6s ease-in-out infinite;
}
.ec-hero__dot--b {
    width: 12px; height: 12px;
    background: #FF5722; opacity: 0.28;
    bottom: 24%; right: 9%;
    animation: ec-float 8s ease-in-out infinite 1s;
}
.ec-hero__dot--c {
    width: 30px; height: 30px;
    background: #e8f3fb;
    border: 3px solid #0061A8; opacity: 0.38;
    top: 64%; left: 4%;
    animation: ec-float 10s ease-in-out infinite 2s;
}
@keyframes ec-float {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-20px); }
}

/* ---- Badge ---- */
.ec-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 7px 18px;
    border-radius: 50px;
    margin-bottom: 22px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    letter-spacing: 0.2px;
    backdrop-filter: blur(4px);
}
.ec-hero__badge-dot {
    display: inline-block;
    width: 8px; height: 8px;
    background: #fff;
    border-radius: 50%;
    animation: ec-pulse 2s ease-in-out infinite;
    box-shadow: 0 0 6px rgba(255,255,255,0.7);
}
@keyframes ec-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.45); opacity: 0.55; }
}

/* ---- Heading ---- */
.ec-hero__title {
    font-size: clamp(28px, 3.8vw, 52px);
    font-weight: 800;
    color: #fff;            /* white on dark blue left bg */
    line-height: 1.18;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 2px 12px rgba(0,0,0,0.18);
}
.hero-title-highlight {
    /* lighter cyan-white gradient — visible on dark bg */
    background: linear-gradient(135deg, #7dd3fc 0%, #e0f2fe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ---- Description ---- */
.ec-hero__description {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.82);  /* white 82% on dark bg */
    line-height: 1.82;
    max-width: 520px;
    margin-bottom: 34px;
    font-weight: 400;
}

/* ---- CTA Buttons ---- */
.ec-hero__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 38px;
}
.ec-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    white-space: nowrap;
    letter-spacing: 0.2px;
    font-family: 'Poppins', sans-serif;
}
.ec-btn--primary {
    background: linear-gradient(135deg, #0061A8 0%, #0080d4 100%);
    color: #fff !important;
    border: none;
    box-shadow: 0 6px 22px rgba(0, 97, 168, 0.36);
}
.ec-btn--primary:hover {
    background: linear-gradient(135deg, #004c84 0%, #0061A8 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0, 97, 168, 0.46);
    color: #fff !important;
}
.ec-btn--primary i { transition: transform 0.3s; }
.ec-btn--primary:hover i { transform: translateX(4px); }

.ec-btn--outline {
    background: rgba(255, 255, 255, 0.95);
    color: #1e293b !important;
    border: 2px solid rgba(255,255,255,0.8);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.ec-btn--outline:hover {
    background: #fff;
    border-color: #fff;
    color: #0061A8 !important;
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.18);
}
.ec-btn__play-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px; height: 26px;
    background: linear-gradient(135deg, #0061A8 0%, #0080d4 100%);
    border-radius: 50%;
    color: #fff;
    font-size: 12px;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(0,97,168,0.4);
}

/* ---- Stats ---- */
.ec-hero__stats {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}
.ec-hero__stat {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.ec-hero__stat-num {
    font-size: 22px;
    font-weight: 800;
    color: #fff;            /* white on dark bg */
    line-height: 1.1;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 1px 6px rgba(0,0,0,0.15);
}
.ec-hero__stat-label {
    font-size: 12px;
    color: rgba(255,255,255,0.70);  /* white 70% */
    font-weight: 500;
    letter-spacing: 0.3px;
}
.ec-hero__stat-divider {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.3);
}

/* ---- Right Graphic ---- */
.ec-hero__graphic { position: relative; }

.ec-hero__img-wrapper {
    position: relative;
    max-width: 590px;
    margin-left: auto;
}
.ec-hero__img-glow {
    position: absolute;
    inset: 10%;
    background: radial-gradient(ellipse at center, rgba(0, 97, 168, 0.26) 0%, transparent 70%);
    filter: blur(45px);
    z-index: 0;
    border-radius: 50%;
}
.ec-hero__img {
    position: relative;
    z-index: 2;
    width: 100%;
    height: auto;
    border-radius: 20px;
    box-shadow:
        0 30px 80px rgba(0, 97, 168, 0.22),
        0 0 0 1px rgba(0, 97, 168, 0.08);
    display: block;
    transform: perspective(1000px) rotateY(-4deg) rotateX(2deg);
    transition: transform 0.6s ease;
}
.ec-hero__img-wrapper:hover .ec-hero__img {
    transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
}

/* ---- Floating Info Cards ---- */
.ec-float-card {
    position: absolute;
    background: #fff;
    border-radius: 14px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.13);
    z-index: 10;
    min-width: 150px;
    border: 1px solid rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    animation: ec-card-float 5s ease-in-out infinite;
}
.ec-float-card--students  { top: 12%;  left: -4%;  animation-delay: 0s; }
.ec-float-card--attendance { top: 55%; right: -2%; animation-delay: 1.5s; }
.ec-float-card--schools   { bottom: 8%; left: 6%; animation-delay: 3s; }

@keyframes ec-card-float {
    0%, 100% { transform: translateY(0px); }
    50%      { transform: translateY(-10px); }
}

.ec-float-card__icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.ec-float-card__icon--blue   { background: #dbeafe; color: #2563eb; }
.ec-float-card__icon--green  { background: #dcfce7; color: #16a34a; }
.ec-float-card__icon--orange { background: #ffedd5; color: #ea580c; }

.ec-float-card__content {
    display: flex;
    flex-direction: column;
    gap: 1px;
}
.ec-float-card__num {
    font-size: 18px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.1;
    font-family: 'Poppins', sans-serif;
}
.ec-float-card__label {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
    white-space: nowrap;
}

/* ---- Responsive ---- */
@media (max-width: 991px) {
    .ec-hero__content { text-align: center; }
    .ec-hero__description { margin-left: auto; margin-right: auto; }
    .ec-hero__actions { justify-content: center; }
    .ec-hero__stats { justify-content: center; }
    .ec-hero__badge { display: inline-flex; }
    .ec-float-card--students  { left: 0; top: 4%; }
    .ec-float-card--attendance { right: 0; }
    .ec-float-card--schools   { left: 2%; }
}
@media (max-width: 575px) {
    .ec-hero { padding: 70px 0 40px; }
    .ec-hero__title { font-size: clamp(22px, 7vw, 34px); }
    .ec-float-card { min-width: 120px; padding: 8px 12px; }
    .ec-float-card__num  { font-size: 14px; }
    .ec-float-card__icon { width: 34px; height: 34px; font-size: 16px; }
    .ec-hero__stats { gap: 14px; }
    .ec-hero__stat-num { font-size: 18px; }
    .ec-hero__ring--1 { width: 300px; height: 300px; }
    .ec-hero__ring--2 { width: 200px; height: 200px; }
}
</style>
