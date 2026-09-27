@php
    $section = \App\Models\FrontendSection::where('key', 'setup-section')->first();
    $content = $section ? (json_decode($section->content, true) ?? []) : [];
    $title = $content['title'] ?? 'মাত্র ৩টি ধাপে শুরু করুন';
    $desc  = $content['description'] ?? 'কোনো টেকনিক্যাল নলেজ ছাড়াই মাত্র কয়েক মিনিটে আপনার স্কুলকে ডিজিটালাইজ করুন।';
@endphp

<section id="setup-process" class="ec-steps">
    <div class="container ec-steps__container">

        {{-- Header --}}
        <div class="ec-steps__header text-center" data-aos="fade-up" data-aos-duration="600">
            <span class="ec-steps__badge">
                <i class="bi bi-lightning-charge-fill me-1"></i>
                দ্রুত সেটআপ
            </span>
            <h2 class="ec-steps__title">{{ $title }}</h2>
            <p class="ec-steps__desc">{{ $desc }}</p>
        </div>

        {{-- Steps --}}
        <div class="ec-steps__grid" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">

            {{-- Connector line --}}
            <div class="ec-steps__connector d-none d-lg-block"></div>

            {{-- Step 1 --}}
            <div class="ec-step">
                <div class="ec-step__num">১</div>
                <div class="ec-step__icon-wrap" style="background:#dbeafe; color:#2563eb;">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h5 class="ec-step__title">{{ $content['step1_title'] ?? 'রেজিস্ট্রেশন করুন' }}</h5>
                <p class="ec-step__desc">{{ $content['step1_desc'] ?? 'আপনার প্রতিষ্ঠানের নাম, ইমেইল ও মোবাইল নম্বর দিয়ে রেজিস্ট্রেশন সম্পন্ন করুন।' }}</p>
            </div>

            {{-- Step 2 --}}
            <div class="ec-step">
                <div class="ec-step__num">২</div>
                <div class="ec-step__icon-wrap" style="background:#fef9c3; color:#ca8a04;">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <h5 class="ec-step__title">{{ $content['step2_title'] ?? 'বেসিক সেটআপ' }}</h5>
                <p class="ec-step__desc">{{ $content['step2_desc'] ?? 'ক্লাস, সেকশন ও ফি স্ট্রাকচার সেটআপ করে আপনার প্যানেল প্রস্তুত করুন।' }}</p>
            </div>

            {{-- Step 3 --}}
            <div class="ec-step">
                <div class="ec-step__num">৩</div>
                <div class="ec-step__icon-wrap" style="background:#dcfce7; color:#16a34a;">
                    <i class="bi bi-rocket-takeoff"></i>
                </div>
                <h5 class="ec-step__title">{{ $content['step3_title'] ?? 'পরিচালনা শুরু করুন' }}</h5>
                <p class="ec-step__desc">{{ $content['step3_desc'] ?? 'শিক্ষার্থীর ডেটা আপলোড করুন এবং স্মার্ট স্কুল ম্যানেজমেন্ট উপভোগ করুন।' }}</p>
            </div>
        </div>

        {{-- CTA --}}
        <div class="ec-steps__cta text-center" data-aos="fade-up" data-aos-duration="600" data-aos-delay="150">
            <a href="{{ route('school.register.form') }}" class="ec-steps__cta-btn">
                <i class="bi bi-rocket-takeoff-fill me-2"></i>
                বিনামূল্যে শুরু করুন
            </a>
            <p class="ec-steps__cta-note">
                <i class="bi bi-shield-check text-success me-1"></i>
                কোনো ক্রেডিট কার্ড প্রয়োজন নেই
            </p>
        </div>
    </div>
</section>

<style>
/* ===== EC STEPS SECTION ===== */
.ec-steps {
    padding: 72px 0 64px;
    background: #fff;
}
.ec-steps__container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

/* Header */
.ec-steps__header { margin-bottom: 52px; }
.ec-steps__badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(250,173,20,.12); color: #b45309;
    font-size: 12px; font-weight: 800; letter-spacing:.08em; text-transform: uppercase;
    padding: 7px 20px; border-radius: 50px; border: 1px solid rgba(250,173,20,.25);
    margin-bottom: 14px;
}
.ec-steps__title {
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 900; color: #0f172a; margin-bottom: 10px;
}
.ec-steps__desc { color: #64748b; font-size: 15.5px; max-width: 500px; margin: 0 auto; }

/* Grid */
.ec-steps__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    position: relative;
    margin-bottom: 48px;
}

/* Connector */
.ec-steps__connector {
    position: absolute;
    top: 48px; left: calc(50%/3 + 10px); right: calc(50%/3 + 10px);
    height: 2px;
    background: repeating-linear-gradient(
        to right,
        #c7d2fe 0, #c7d2fe 6px, transparent 6px, transparent 14px
    );
    z-index: 0;
}

/* Step Card */
.ec-step {
    background: #f8faff;
    border: 1.5px solid #e2e8f0;
    border-radius: 24px;
    padding: 36px 28px;
    text-align: center;
    position: relative;
    z-index: 1;
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
}
.ec-step:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(70,72,212,.10);
    border-color: #c7c4ff;
    background: #fff;
}

/* Step Number */
.ec-step__num {
    position: absolute;
    top: -16px; right: 24px;
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #4648d4, #6366f1);
    color: #fff; font-size: 16px; font-weight: 900;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 3px solid #fff;
    box-shadow: 0 4px 12px rgba(70,72,212,.3);
}

/* Icon */
.ec-step__icon-wrap {
    width: 72px; height: 72px; border-radius: 20px;
    margin: 0 auto 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 30px;
    transition: transform .3s ease, box-shadow .3s ease;
}
.ec-step:hover .ec-step__icon-wrap {
    transform: scale(1.12) rotate(-5deg);
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
}

.ec-step__title { font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
.ec-step__desc { font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0; }

/* CTA */
.ec-steps__cta-btn {
    display: inline-flex; align-items: center;
    background: linear-gradient(135deg, #4648d4, #6366f1);
    color: #fff !important; text-decoration: none;
    font-size: 15px; font-weight: 800;
    padding: 16px 40px; border-radius: 14px;
    box-shadow: 0 6px 24px rgba(70,72,212,.35);
    transition: all .25s ease;
    margin-bottom: 14px;
}
.ec-steps__cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(70,72,212,.4);
}
.ec-steps__cta-note { font-size: 12.5px; color: #94a3b8; font-weight: 600; margin: 0; }

/* Responsive */
@media (max-width: 767px) {
    .ec-steps__grid { grid-template-columns: 1fr; gap: 20px; }
    .ec-step { padding: 28px 20px; }
}
</style>