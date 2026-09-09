@php
    use App\Models\FrontendSection;
    use Illuminate\Support\Str;

    $section = FrontendSection::where('key', 'features')->first();
    $featuresContent = [];
    if($section) {
        $featuresContent = json_decode($section->content, true) ?? [];
    }

    $title       = $featuresContent['title']       ?? 'আমাদের শক্তিশালী ফিচারসমূহ';
    $description = $featuresContent['description'] ?? 'একটি আধুনিক শিক্ষাপ্রতিষ্ঠানের জন্য প্রয়োজনীয় সকল সমাধান এক প্ল্যাটফর্মে।';

    $items = !empty($featuresContent['items']) ? $featuresContent['items'] : [
        ['icon' => 'language',                'title' => 'ডায়নামিক ওয়েবসাইট',          'desc' => 'আপনার প্রতিষ্ঠানের জন্য প্রফেশনাল ও আধুনিক ওয়েবসাইট যা অটোমেটিক আপডেট হবে আপনার প্যানেল থেকে।'],
        ['icon' => 'person_add',              'title' => 'অনলাইন ভর্তি',                 'desc' => 'বাসায় বসেই অভিভাবকরা ভর্তি আবেদন এবং অনলাইনে পেমেন্ট সম্পন্ন করতে পারবেন।'],
        ['icon' => 'fact_check',              'title' => 'ডিজিটাল হাজিরা',              'desc' => 'স্মার্ট হাজিরা ব্যবস্থা এবং অটোমেটিক এসএমএস নোটিফিকেশন অভিভাবকের কাছে পাঠানো হবে।'],
        ['icon' => 'analytics',               'title' => 'ফলাফল ও মার্কশিট',            'desc' => 'দ্রুত ও নির্ভুলভাবে ফলাফল তৈরি করুন এবং অ্যাপের মাধ্যমে মার্কশিট ডাউনলোড করুন।'],
        ['icon' => 'account_balance_wallet',  'title' => 'অটোমেটেড একাউন্টস',          'desc' => 'বেতন আদায়, খরচ ও সকল আর্থিক রিপোর্ট এখন হাতের মুঠোয়। ম্যানুয়াল হিসেবের ঝামেলা নেই।'],
        ['icon' => 'sms',                     'title' => 'এসএমএস অ্যালার্ট',             'desc' => 'হাজিরা, ফলাফল ও নোটিশের জন্য অটোমেটেড বাল্ক এসএমএস সার্ভিস।'],
        ['icon' => 'groups',                  'title' => 'শিক্ষক ও স্টাফ ম্যানেজমেন্ট', 'desc' => 'প্রোফাইল, দায়িত্ব, উপস্থিতি ও যোগাযোগের তথ্য এক জায়গা থেকে পরিচালনা করুন।'],
        ['icon' => 'campaign',                'title' => 'নোটিশ ও ঘোষণা',               'desc' => 'গুরুত্বপূর্ণ নোটিশ, ইভেন্ট ও আপডেট দ্রুত প্রকাশ করুন এবং অভিভাবকদের সাথে যোগাযোগ রাখুন।'],
        ['icon' => 'insights',                'title' => 'স্মার্ট রিপোর্টিং',            'desc' => 'ড্যাশবোর্ডে গুরুত্বপূর্ণ তথ্য দেখুন এবং সিদ্ধান্ত নেওয়ার জন্য পরিষ্কার রিপোর্ট তৈরি করুন।'],
    ];

    // Color palette matching hero section (blue/orange)
    $colorSets = [
        ['bg' => '#dbeafe', 'color' => '#2563eb', 'accent' => '#2563eb'],
        ['bg' => '#ffedd5', 'color' => '#ea580c', 'accent' => '#ea580c'],
        ['bg' => '#dcfce7', 'color' => '#16a34a', 'accent' => '#16a34a'],
        ['bg' => '#e0f2fe', 'color' => '#0284c7', 'accent' => '#0284c7'],
        ['bg' => '#f3e8ff', 'color' => '#9333ea', 'accent' => '#9333ea'],
        ['bg' => '#fef9c3', 'color' => '#ca8a04', 'accent' => '#ca8a04'],
    ];
@endphp

{{-- ======= FEATURES SECTION — ieducore-matched ======= --}}
<section id="features" class="ecf-section">

    {{-- Decorative background rings (matching hero) --}}
    <div class="ecf-bg-ring ecf-bg-ring--1"></div>
    <div class="ecf-bg-ring ecf-bg-ring--2"></div>

    <div class="container ecf-container">

        {{-- Section Header --}}
        <div class="ecf-header" data-aos="fade-up" data-aos-duration="700">
            <div class="ecf-header__badge">
                <span class="ecf-header__badge-dot"></span>
                EduCorexa Platform
            </div>
            <h2 class="ecf-header__title">{{ $title }}</h2>
            <p class="ecf-header__desc">{{ $description }}</p>

            {{-- Divider --}}
            <div class="ecf-header__divider">
                <span class="ecf-header__divider-line"></span>
                <span class="ecf-header__divider-icon"><i class="bi bi-mortarboard-fill"></i></span>
                <span class="ecf-header__divider-line"></span>
            </div>
        </div>

        {{-- Feature Cards Grid --}}
        <div class="ecf-grid" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
            @foreach($items as $index => $item)
                @php
                    $cs   = $colorSets[$index % count($colorSets)];
                    $desc = $item['short_desc'] ?? Str::limit(strip_tags($item['desc'] ?? ''), 95);
                    $num  = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $hidden = $index >= 8 ? 'ecf-card--hidden' : '';
                @endphp
                <article class="ecf-card {{ $hidden }}"
                    style="--card-accent: {{ $cs['accent'] }};"
                    data-aos="fade-up"
                    data-aos-duration="600"
                    data-aos-delay="{{ 80 + ($index % 4) * 80 }}">

                    {{-- Top bar accent line --}}
                    <div class="ecf-card__topline"></div>

                    {{-- Header row --}}
                    <div class="ecf-card__head">
                        <div class="ecf-card__icon" style="background: {{ $cs['bg'] }}; color: {{ $cs['color'] }};">
                            <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                        </div>
                        <span class="ecf-card__num">{{ $num }}</span>
                    </div>

                    {{-- Content --}}
                    <h3 class="ecf-card__title">{{ $item['title'] }}</h3>
                    <p class="ecf-card__desc">{{ $desc }}</p>

                    {{-- Arrow on hover --}}
                    <div class="ecf-card__arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Show More --}}
        @if(count($items) > 8)
        <div class="ecf-showmore-wrap">
            <button id="ecf-show-more" class="ecf-showmore-btn">
                <span>আরও দেখুন</span>
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        @endif

        {{-- Bottom CTA strip --}}
        <div class="ecf-cta-strip" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
            <div class="ecf-cta-strip__left">
                <i class="bi bi-check-circle-fill ecf-cta-strip__check"></i>
                <span>একটি প্ল্যাটফর্ম, প্রতিটি গুরুত্বপূর্ণ কাজের জন্য।</span>
            </div>
            <a href="{{ route('school.register.form') }}" class="ecf-cta-strip__btn">
                বিনামূল্যে শুরু করুন <i class="bi bi-arrow-right"></i>
            </a>
        </div>

    </div>
</section>

<style>
/* ============================================================
   EDUCOREXA FEATURES SECTION — ieducore-matched design
   ============================================================ */

/* ---- Section Base ---- */
.ecf-section {
    position: relative;
    padding: 90px 0 80px;
    background: linear-gradient(160deg, #f8fbff 0%, #eef6ff 40%, #fff8f5 100%);
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

/* Matching bg rings from hero */
.ecf-bg-ring {
    position: absolute;
    border-radius: 50%;
    border: 2px dashed;
    pointer-events: none;
}
.ecf-bg-ring--1 {
    width: 420px; height: 420px;
    border-color: #0061A8;
    opacity: 0.07;
    top: -160px; right: -100px;
    animation: ecf-spin 35s linear infinite;
}
.ecf-bg-ring--2 {
    width: 280px; height: 280px;
    border-color: #FF5722;
    opacity: 0.07;
    bottom: -80px; left: -80px;
    animation: ecf-spin 25s linear infinite reverse;
}
@keyframes ecf-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.ecf-container { position: relative; z-index: 2; }

/* ---- Section Header ---- */
.ecf-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 56px;
}

.ecf-header__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #e8f3fb;
    color: #0061A8;
    font-size: 12.5px;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 50px;
    margin-bottom: 20px;
    border: 1px solid rgba(0, 97, 168, 0.2);
    letter-spacing: 0.8px;
    text-transform: uppercase;
}
.ecf-header__badge-dot {
    display: inline-block;
    width: 8px; height: 8px;
    background: #0061A8;
    border-radius: 50%;
    animation: ecf-pulse 2s ease-in-out infinite;
}
@keyframes ecf-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.45); opacity: 0.55; }
}

.ecf-header__title {
    font-size: clamp(24px, 3.5vw, 40px);
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
    letter-spacing: -0.5px;
    margin-bottom: 14px;
}

.ecf-header__desc {
    font-size: 16px;
    color: #64748b;
    line-height: 1.8;
    font-weight: 400;
}

.ecf-header__divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 28px;
}
.ecf-header__divider-line {
    flex: 0 0 60px; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(0,97,168,0.25));
    border-radius: 4px;
}
.ecf-header__divider-line:last-child {
    background: linear-gradient(90deg, rgba(0,97,168,0.25), transparent);
}
.ecf-header__divider-icon {
    width: 32px; height: 32px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(0,97,168,0.3);
}

/* ---- Feature Cards Grid ---- */
.ecf-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    margin-bottom: 40px;
}

.ecf-card--hidden { display: none !important; }

/* ---- Feature Card ---- */
.ecf-card {
    position: relative;
    background: #fff;
    border-radius: 18px;
    padding: 28px 24px 24px;
    border: 1.5px solid rgba(0, 97, 168, 0.08);
    box-shadow: 0 4px 20px rgba(0, 97, 168, 0.06);
    display: flex;
    flex-direction: column;
    gap: 0;
    min-height: 220px;
    cursor: pointer;
    transition: all 0.32s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

/* Accent top line (colored per card) */
.ecf-card__topline {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3.5px;
    background: var(--card-accent, #0061A8);
    border-radius: 18px 18px 0 0;
    transform: scaleX(0.3);
    transform-origin: left;
    transition: transform 0.4s ease;
    opacity: 0.7;
}

.ecf-card:hover {
    transform: translateY(-7px);
    border-color: rgba(0, 97, 168, 0.2);
    box-shadow:
        0 20px 50px rgba(0, 97, 168, 0.14),
        0 4px 12px rgba(0,0,0,0.06);
}
.ecf-card:hover .ecf-card__topline {
    transform: scaleX(1);
    opacity: 1;
}

/* Head: icon + number */
.ecf-card__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

.ecf-card__icon {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}
.ecf-card__icon .material-symbols-outlined {
    font-size: 26px;
}
.ecf-card:hover .ecf-card__icon {
    transform: scale(1.1) rotate(-4deg);
}

.ecf-card__num {
    font-size: 11.5px;
    font-weight: 800;
    color: #cbd5e1;
    letter-spacing: 1.5px;
    line-height: 1;
}

/* Title */
.ecf-card__title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 10px;
    font-family: 'Poppins', sans-serif;
}

/* Description */
.ecf-card__desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.7;
    flex: 1;
    font-weight: 400;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
}

/* Arrow (shows on hover) */
.ecf-card__arrow {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-top: 16px;
    font-size: 16px;
    color: var(--card-accent, #0061A8);
    opacity: 0;
    transform: translateX(-8px);
    transition: all 0.3s ease;
}
.ecf-card:hover .ecf-card__arrow {
    opacity: 1;
    transform: translateX(0);
}

/* ---- Show More Button ---- */
.ecf-showmore-wrap {
    text-align: center;
    margin-bottom: 40px;
}
.ecf-showmore-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: #fff;
    border: 1.5px solid rgba(0, 97, 168, 0.25);
    border-radius: 50px;
    color: #0061A8;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.28s ease;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 16px rgba(0,97,168,0.08);
}
.ecf-showmore-btn:hover {
    background: linear-gradient(135deg, #0061A8, #0080d4);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 8px 24px rgba(0,97,168,0.3);
    transform: translateY(-2px);
}
.ecf-showmore-btn i { font-size: 18px; transition: transform 0.3s; }
.ecf-showmore-btn:hover i { transform: translateY(3px); }

/* ---- Bottom CTA Strip ---- */
.ecf-cta-strip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: linear-gradient(135deg, #0061A8 0%, #0080d4 100%);
    border-radius: 20px;
    padding: 24px 36px;
    color: #fff;
    flex-wrap: wrap;
    box-shadow: 0 16px 50px rgba(0, 97, 168, 0.28);
    position: relative;
    overflow: hidden;
}
.ecf-cta-strip::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 200px; height: 200px;
    border: 2px dashed rgba(255,255,255,0.2);
    border-radius: 50%;
}
.ecf-cta-strip::after {
    content: '';
    position: absolute;
    bottom: -40px; right: 80px;
    width: 130px; height: 130px;
    border: 2px dashed rgba(255,255,255,0.12);
    border-radius: 50%;
}
.ecf-cta-strip__left {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    position: relative;
    z-index: 2;
}
.ecf-cta-strip__check {
    font-size: 22px;
    color: #86efac;
    flex-shrink: 0;
}
.ecf-cta-strip__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: #0061A8 !important;
    padding: 12px 28px;
    border-radius: 50px;
    font-size: 14.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.28s ease;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
    white-space: nowrap;
}
.ecf-cta-strip__btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    color: #0061A8 !important;
    text-decoration: none;
}
.ecf-cta-strip__btn i { transition: transform 0.3s; }
.ecf-cta-strip__btn:hover i { transform: translateX(4px); }

/* ---- Responsive ---- */
@media (max-width: 1199px) {
    .ecf-grid { grid-template-columns: repeat(3, 1fr); gap: 18px; }
}
@media (max-width: 767px) {
    .ecf-section { padding: 60px 0 50px; }
    /* Always 2 columns on mobile — never 1 */
    .ecf-grid {
        grid-template-columns: repeat(2, minmax(140px, 1fr));
        gap: 12px;
    }
    .ecf-card { padding: 18px 14px; min-height: 170px; border-radius: 14px; }
    .ecf-card__head { margin-bottom: 12px; }
    .ecf-card__icon { width: 40px; height: 40px; border-radius: 11px; }
    .ecf-card__icon .material-symbols-outlined { font-size: 21px; }
    .ecf-card__title { font-size: 13.5px; margin-bottom: 7px; }
    .ecf-card__desc  { font-size: 12px; -webkit-line-clamp: 3; }
    .ecf-card__num   { font-size: 10px; }
    .ecf-card__arrow { display: none; }  /* hide arrow on mobile to save space */
    .ecf-header { margin-bottom: 32px; }
    .ecf-header__title { font-size: clamp(20px, 5vw, 30px); }
    .ecf-header__desc { font-size: 14px; }
    .ecf-cta-strip { padding: 18px 20px; gap: 14px; }
    .ecf-cta-strip__left { font-size: 14px; }
}
@media (max-width: 400px) {
    /* Very small screens — still keep 2 columns, just tighter */
    .ecf-grid { gap: 8px; }
    .ecf-card { padding: 14px 12px; min-height: 150px; }
    .ecf-card__title { font-size: 12.5px; }
    .ecf-card__desc  { font-size: 11.5px; }
    .ecf-cta-strip { flex-direction: column; text-align: center; }
    .ecf-cta-strip__btn { width: 100%; justify-content: center; }
}
</style>

@if(count($items) > 8)
<script>
    document.getElementById('ecf-show-more')?.addEventListener('click', function () {
        document.querySelectorAll('.ecf-card--hidden').forEach(c => c.classList.remove('ecf-card--hidden'));
        this.closest('.ecf-showmore-wrap').remove();
    });
</script>
@endif