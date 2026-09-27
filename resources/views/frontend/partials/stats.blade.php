{{-- ===== STATS / TRUST COUNTER SECTION ===== --}}
@php
    use App\Models\FrontendSection;
    $statsSection = $section ?? FrontendSection::where('key', 'stats')->first();
    $rawContent = $statsSection?->content;
    $statsContent = is_array($rawContent) ? $rawContent : (is_string($rawContent) ? (json_decode($rawContent, true) ?? []) : []);

    // Counter values — editable from admin panel or fallback defaults
    $counters = [
        [
            'icon'    => 'bi-building',
            'color'   => '#2563eb',
            'bg'      => '#eff6ff',
            'value'   => $statsContent['schools_count'] ?? '৫০০+',
            'label'   => $statsContent['schools_label'] ?? 'স্কুল ও মাদ্রাসা',
            'suffix'  => '',
        ],
        [
            'icon'    => 'bi-person-graduation',
            'color'   => '#059669',
            'bg'      => '#ecfdf5',
            'value'   => $statsContent['students_count'] ?? '১,০০,০০০+',
            'label'   => $statsContent['students_label'] ?? 'সক্রিয় শিক্ষার্থী',
            'suffix'  => '',
        ],
        [
            'icon'    => 'bi-geo-alt-fill',
            'color'   => '#d97706',
            'bg'      => '#fffbeb',
            'value'   => $statsContent['districts_count'] ?? '৬৪',
            'label'   => $statsContent['districts_label'] ?? 'জেলায় ব্যবহৃত',
            'suffix'  => '',
        ],
        [
            'icon'    => 'bi-headset',
            'color'   => '#7c3aed',
            'bg'      => '#f5f3ff',
            'value'   => $statsContent['support_value'] ?? '২৪/৭',
            'label'   => $statsContent['support_label'] ?? 'লাইভ সাপোর্ট',
            'suffix'  => '',
        ],
    ];
@endphp

<section id="stats-section" class="ec-stats">
    <div class="container ec-stats__container">

        {{-- Section Label --}}
        <div class="ec-stats__label-row" data-aos="fade-up" data-aos-duration="500">
            <span class="ec-stats__label-pill">
                <i class="bi bi-bar-chart-fill me-1"></i>
                আমাদের পরিসংখ্যান
            </span>
        </div>

        <div class="ec-stats__grid" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
            @foreach($counters as $i => $counter)
                <div class="ec-stats__card" style="--card-delay: {{ $i * 80 }}ms;">
                    <div class="ec-stats__icon-wrap" style="background:{{ $counter['bg'] }}; color:{{ $counter['color'] }};">
                        <i class="{{ $counter['icon'] }}"></i>
                    </div>
                    <div class="ec-stats__value" style="color:{{ $counter['color'] }};">
                        {{ $counter['value'] }}
                    </div>
                    <div class="ec-stats__label">{{ $counter['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Trust badges --}}
        <div class="ec-stats__trust-row" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
            <span class="ec-stats__trust-item">
                <i class="bi bi-patch-check-fill text-success"></i>
                SSL সুরক্ষিত
            </span>
            <span class="ec-stats__trust-sep">·</span>
            <span class="ec-stats__trust-item">
                <i class="bi bi-cloud-check-fill text-primary"></i>
                ১০০% ক্লাউড-ভিত্তিক
            </span>
            <span class="ec-stats__trust-sep">·</span>
            <span class="ec-stats__trust-item">
                <i class="bi bi-shield-fill-check text-warning"></i>
                ডেটা নিরাপদ
            </span>
            <span class="ec-stats__trust-sep">·</span>
            <span class="ec-stats__trust-item">
                <i class="bi bi-phone-fill text-danger"></i>
                মোবাইল ফ্রেন্ডলি
            </span>
        </div>
    </div>
</section>

<style>
/* ===== EC STATS SECTION ===== */
.ec-stats {
    padding: 64px 0 56px;
    background: linear-gradient(135deg, #f8faff 0%, #eef2ff 50%, #f0fdf4 100%);
    position: relative;
    overflow: hidden;
}

.ec-stats::before {
    content: '';
    position: absolute;
    top: -60px; right: -80px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,.08) 0%, transparent 70%);
    pointer-events: none;
}
.ec-stats::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(5,150,105,.07) 0%, transparent 70%);
    pointer-events: none;
}

.ec-stats__container { position: relative; z-index: 1; }

/* Label pill */
.ec-stats__label-row { text-align: center; margin-bottom: 32px; }
.ec-stats__label-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(37,99,235,.1); color: #1d4ed8;
    font-size: 12px; font-weight: 800;
    letter-spacing: .08em; text-transform: uppercase;
    padding: 7px 20px; border-radius: 50px;
    border: 1px solid rgba(37,99,235,.18);
}

/* Grid */
.ec-stats__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 36px;
}

/* Card */
.ec-stats__card {
    background: #fff;
    border-radius: 20px;
    padding: 32px 24px;
    text-align: center;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,.05);
    transition: transform .3s ease, box-shadow .3s ease;
    animation: statsCardIn .5s ease both;
    animation-delay: var(--card-delay, 0ms);
}
.ec-stats__card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 36px rgba(0,0,0,.10);
}

@keyframes statsCardIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Icon */
.ec-stats__icon-wrap {
    width: 60px; height: 60px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 26px;
    transition: transform .3s ease;
}
.ec-stats__card:hover .ec-stats__icon-wrap { transform: scale(1.1) rotate(-5deg); }

/* Value */
.ec-stats__value {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 8px;
    letter-spacing: -.01em;
}

/* Label */
.ec-stats__label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

/* Trust row */
.ec-stats__trust-row {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px 20px;
}
.ec-stats__trust-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: #475569;
}
.ec-stats__trust-sep { color: #cbd5e1; font-weight: 300; }

/* Responsive */
@media (max-width: 991px) {
    .ec-stats__grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 575px) {
    .ec-stats {  padding: 44px 0 40px; }
    .ec-stats__grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .ec-stats__card { padding: 22px 14px; border-radius: 14px; }
    .ec-stats__value { font-size: 1.5rem; }
    .ec-stats__trust-row { gap: 6px 12px; }
}
</style>
