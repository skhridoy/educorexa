@php
    use App\Models\FrontendSection;
    use App\Models\SubscriptionPackage;

    $pricingSec = $section ?? FrontendSection::where('key', 'pricing')->first();
    $rawContent = $pricingSec?->content;
    $content = is_array($rawContent) ? $rawContent : (is_string($rawContent) ? (json_decode($rawContent, true) ?? []) : []);
    $title       = $content['title']       ?? 'সাশ্রয়ী প্যাকেজ সমূহ';
    $description = $content['description'] ?? 'আপনার প্রতিষ্ঠানের আকার ও প্রয়োজন অনুযায়ী বেছে নিন সেরা প্যাকেজ।';

    // Load packages
    if (!isset($packages)) {
        $packages = SubscriptionPackage::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();
    }
@endphp

<section id="pricing" class="ec-pricing py-5">
    <div class="container ec-pricing__container">

        {{-- Header --}}
        <div class="ec-pricing__header text-center" data-aos="fade-up" data-aos-duration="600">
            <span class="ec-pricing__badge">
                <i class="bi bi-tags-fill me-1"></i>
                মূল্য তালিকা
            </span>
            <h2 class="ec-pricing__title">{{ $title }}</h2>
            <p class="ec-pricing__desc">{{ $description }}</p>

            {{-- Billing Toggle --}}
            <div class="ec-pricing__toggle-wrap" id="billingToggleWrap">
                <span class="ec-pricing__toggle-label" id="toggleLabelMonthly">মাসিক</span>
                <button type="button" class="ec-pricing__toggle" id="billingToggle" aria-pressed="false">
                    <span class="ec-pricing__toggle-thumb"></span>
                </button>
                <span class="ec-pricing__toggle-label" id="toggleLabelYearly">
                    বার্ষিক
                    <span class="ec-pricing__toggle-save" id="toggleSaveBadge">সেরা ছাড়!</span>
                </span>
            </div>
        </div>

        {{-- Package Cards --}}
        <div class="ec-pricing__grid" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
            @if($packages->count() > 0)
                @foreach($packages as $package)
                    @php
                        $isFree = $package->isFreePackage();
                        $monthlyPrice = (float) $package->price;
                        $discounts = $package->billing_discounts ?? [];
                        $yearlyDisc = (float)($discounts['yearly'] ?? 0);
                        $halfDisc   = (float)($discounts['half_yearly'] ?? 0);
                        $qtlyDisc   = (float)($discounts['quarterly'] ?? 0);

                        // Yearly discounted price
                        $yearlyTotal  = $yearlyDisc > 0
                            ? round($monthlyPrice * 12 * (1 - $yearlyDisc/100), 0)
                            : $monthlyPrice * 12;
                        $yearlyPerMo  = $yearlyTotal / 12;

                        // Best discount for badge
                        $bestDisc = max($yearlyDisc, $halfDisc, $qtlyDisc);
                    @endphp

                    <div class="ec-pkg {{ $package->is_popular ? 'ec-pkg--popular' : '' }}">

                        @if($package->is_popular)
                            <div class="ec-pkg__popular-badge">
                                <i class="bi bi-fire me-1"></i> সবচেয়ে জনপ্রিয়
                            </div>
                        @elseif($bestDisc > 0)
                            <div class="ec-pkg__discount-ribbon">
                                {{ number_format($bestDisc, 0) }}% পর্যন্ত ছাড়
                            </div>
                        @endif

                        {{-- Package Name & Desc --}}
                        <div class="ec-pkg__head">
                            <h3 class="ec-pkg__name">{{ $package->name }}</h3>
                            <p class="ec-pkg__desc-text">{{ $package->description }}</p>
                        </div>

                        {{-- Price Display --}}
                        <div class="ec-pkg__price-block">
                            @if($isFree)
                                @if((float)($package->service_fee ?? 0) > 0)
                                    <div class="ec-pkg__price">
                                        <span class="ec-pkg__currency">৳</span>
                                        <span class="ec-pkg__amount">{{ number_format((float)$package->service_fee) }}</span>
                                    </div>
                                    <div class="ec-pkg__period">এককালীন ফি · {{ $package->getFreeValidityMonths() === 6 ? '৬ মাস' : '১ বছর' }}</div>
                                @else
                                    <div class="ec-pkg__price">
                                        <span class="ec-pkg__amount ec-pkg__amount--free">বিনামূল্যে</span>
                                    </div>
                                    <div class="ec-pkg__period">{{ $package->getFreeValidityMonths() === 6 ? '৬ মাস বৈধ' : '১ বছর বৈধ' }}</div>
                                @endif
                            @else
                                {{-- Monthly price (shown when toggle is off) --}}
                                <div class="ec-pkg__price ec-pkg__price--monthly">
                                    <span class="ec-pkg__currency">৳</span>
                                    <span class="ec-pkg__amount">{{ number_format($monthlyPrice) }}</span>
                                </div>
                                <div class="ec-pkg__period ec-pkg__period--monthly">প্রতি মাস</div>

                                {{-- Yearly price (shown when toggle is on) --}}
                                <div class="ec-pkg__price ec-pkg__price--yearly" style="display:none;">
                                    <span class="ec-pkg__currency">৳</span>
                                    <span class="ec-pkg__amount">{{ number_format($yearlyPerMo, 0) }}</span>
                                    @if($yearlyDisc > 0)
                                        <span class="ec-pkg__orig-price">৳{{ number_format($monthlyPrice) }}</span>
                                    @endif
                                </div>
                                <div class="ec-pkg__period ec-pkg__period--yearly" style="display:none;">
                                    প্রতি মাস · বার্ষিক বিলিং (৳{{ number_format($yearlyTotal) }}/বছর)
                                    @if($yearlyDisc > 0)
                                        <span class="ec-pkg__save-tag">{{ number_format($yearlyDisc, 0) }}% ছাড়</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Divider --}}
                        <div class="ec-pkg__divider"></div>

                        {{-- Features --}}
                        <ul class="ec-pkg__features">
                            <li class="ec-pkg__feat ec-pkg__feat--on">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $package->student_limit ? number_format($package->student_limit) . ' শিক্ষার্থী' : 'আনলিমিটেড শিক্ষার্থী' }}
                            </li>
                            <li class="ec-pkg__feat ec-pkg__feat--on">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $package->teacher_limit ? number_format($package->teacher_limit) . ' শিক্ষক' : 'আনলিমিটেড শিক্ষক' }}
                            </li>

                            @if(is_array($package->features))
                                @foreach(array_slice($package->features, 0, 6) as $feature)
                                    @php $f = trim($feature); $isOff = str_starts_with($f, '-'); @endphp
                                    <li class="ec-pkg__feat {{ $isOff ? 'ec-pkg__feat--off' : 'ec-pkg__feat--on' }}">
                                        <i class="bi {{ $isOff ? 'bi-x-circle' : 'bi-check-circle-fill' }}"></i>
                                        <span>{{ ltrim($f, '+-') }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        {{-- CTA --}}
                        <a href="{{ route('school.register.form', ['package_id' => $package->id]) }}"
                           class="ec-pkg__cta {{ $package->is_popular ? 'ec-pkg__cta--primary' : 'ec-pkg__cta--outline' }}">
                            @if($isFree && (float)($package->service_fee ?? 0) <= 0)
                                <i class="bi bi-rocket-takeoff me-1"></i> বিনামূল্যে শুরু করুন
                            @else
                                <i class="bi bi-arrow-right-circle me-1"></i> শুরু করুন
                            @endif
                        </a>
                    </div>
                @endforeach
            @else
                <div class="ec-pricing__empty">
                    <p>বর্তমানে কোনো প্যাকেজ উপলব্ধ নেই।</p>
                </div>
            @endif
        </div>

        {{-- Bottom note --}}
        <div class="ec-pricing__footer-note" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150">
            <i class="bi bi-shield-fill-check text-success me-1"></i>
            কোনো লুকানো চার্জ নেই &nbsp;·&nbsp;
            <i class="bi bi-headset text-primary me-1"></i>
            ২৪/৭ সাপোর্ট &nbsp;·&nbsp;
            <i class="bi bi-arrow-repeat text-warning me-1"></i>
            যেকোনো সময় প্ল্যান পরিবর্তন করুন
        </div>
    </div>
</section>

<style>
/* ===== EC PRICING SECTION ===== */
.ec-pricing {
    background: linear-gradient(180deg, #f8faff 0%, #fff 100%);
}
.ec-pricing__container { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

/* Header */
.ec-pricing__header { margin-bottom: 48px; }
.ec-pricing__badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(70,72,212,.1); color: #4648d4;
    font-size: 12px; font-weight: 800; letter-spacing:.08em; text-transform: uppercase;
    padding: 7px 20px; border-radius: 50px; border: 1px solid rgba(70,72,212,.18);
    margin-bottom: 16px;
}
.ec-pricing__title {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 900; color: #0f172a;
    margin-bottom: 12px; line-height: 1.15;
}
.ec-pricing__desc {
    color: #64748b; font-size: 16px; max-width: 520px; margin: 0 auto 24px;
}

/* Billing Toggle */
.ec-pricing__toggle-wrap {
    display: inline-flex; align-items: center; gap: 12px;
    background: #f1f5f9; border-radius: 50px; padding: 8px 20px;
    border: 1px solid #e2e8f0;
}
.ec-pricing__toggle-label { font-size: 13px; font-weight: 700; color: #475569; }
.ec-pricing__toggle {
    position: relative; width: 46px; height: 26px;
    background: #cbd5e1; border: none; border-radius: 50px; cursor: pointer;
    transition: background .25s ease;
}
.ec-pricing__toggle[aria-pressed="true"] { background: #4648d4; }
.ec-pricing__toggle-thumb {
    position: absolute; top: 3px; left: 3px;
    width: 20px; height: 20px; border-radius: 50%;
    background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.2);
    transition: transform .25s ease;
}
.ec-pricing__toggle[aria-pressed="true"] .ec-pricing__toggle-thumb { transform: translateX(20px); }
.ec-pricing__toggle-save {
    background: linear-gradient(135deg,#16a34a,#22c55e);
    color: #fff; font-size: 10px; font-weight: 800;
    padding: 2px 8px; border-radius: 50px; margin-left: 6px;
}

/* Grid */
.ec-pricing__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
    align-items: start;
    margin-bottom: 36px;
}

/* Package Card */
.ec-pkg {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 24px;
    padding: 32px 28px;
    position: relative;
    overflow: visible;
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    display: flex; flex-direction: column; gap: 0;
}
.ec-pkg:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(70,72,212,.12);
    border-color: #c7c4ff;
}
.ec-pkg--popular {
    border-color: #4648d4;
    box-shadow: 0 8px 36px rgba(70,72,212,.18);
    transform: scale(1.02);
    background: linear-gradient(160deg, #f8f8ff 0%, #fff 100%);
}
.ec-pkg--popular:hover { transform: scale(1.02) translateY(-6px); }

/* Popular badge */
.ec-pkg__popular-badge {
    position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
    background: linear-gradient(135deg, #4648d4, #6366f1);
    color: #fff; font-size: 11px; font-weight: 800;
    padding: 5px 18px; border-radius: 50px;
    white-space: nowrap; letter-spacing: .04em;
    box-shadow: 0 4px 12px rgba(70,72,212,.35);
}
.ec-pkg__discount-ribbon {
    position: absolute; top: -12px; right: 16px;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff; font-size: 10px; font-weight: 800;
    padding: 4px 12px; border-radius: 50px;
    white-space: nowrap;
}

/* Head */
.ec-pkg__head { margin-bottom: 20px; }
.ec-pkg__name { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
.ec-pkg__desc-text { font-size: 13px; color: #64748b; line-height: 1.55; margin: 0; }

/* Price Block */
.ec-pkg__price-block { margin-bottom: 20px; }
.ec-pkg__price {
    display: flex; align-items: baseline; gap: 4px;
    margin-bottom: 4px;
}
.ec-pkg__currency { font-size: 22px; font-weight: 800; color: #4648d4; }
.ec-pkg__amount {
    font-size: clamp(2.2rem, 4vw, 3rem);
    font-weight: 900; color: #0f172a; line-height: 1;
}
.ec-pkg__amount--free { font-size: 2rem; color: #16a34a; }
.ec-pkg__orig-price {
    font-size: 16px; font-weight: 600;
    color: #94a3b8; text-decoration: line-through; margin-left: 6px;
}
.ec-pkg__period { font-size: 13px; color: #64748b; font-weight: 600; }
.ec-pkg__save-tag {
    display: inline-block;
    background: #dcfce7; color: #16a34a;
    font-size: 11px; font-weight: 800;
    padding: 2px 8px; border-radius: 50px; margin-left: 6px;
}

/* Divider */
.ec-pkg__divider { height: 1px; background: #e2e8f0; margin: 16px 0; }

/* Features */
.ec-pkg__features { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
.ec-pkg__feat { display: flex; align-items: flex-start; gap: 10px; font-size: 13.5px; font-weight: 600; color: #334155; }
.ec-pkg__feat--on i { color: #4648d4; font-size: 15px; flex-shrink: 0; }
.ec-pkg__feat--off { color: #94a3b8; }
.ec-pkg__feat--off i { color: #cbd5e1; font-size: 15px; flex-shrink: 0; }

/* CTA */
.ec-pkg__cta {
    display: block; text-align: center;
    padding: 13px 24px; border-radius: 12px;
    font-size: 14px; font-weight: 800;
    text-decoration: none; transition: all .25s ease;
    margin-top: auto;
}
.ec-pkg__cta--primary {
    background: linear-gradient(135deg, #4648d4, #6366f1);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(70,72,212,.3);
}
.ec-pkg__cta--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(70,72,212,.4);
}
.ec-pkg__cta--outline {
    border: 2px solid #e2e8f0; color: #4648d4 !important;
    background: #f8faff;
}
.ec-pkg__cta--outline:hover {
    border-color: #4648d4; background: #4648d4; color: #fff !important;
}

/* Footer note */
.ec-pricing__footer-note {
    text-align: center; color: #64748b; font-size: 13px; font-weight: 600;
}

/* Empty */
.ec-pricing__empty {
    grid-column: 1/-1; text-align: center;
    padding: 60px 20px; border: 2px dashed #e2e8f0;
    border-radius: 20px; color: #94a3b8;
}

/* Responsive */
@media (max-width: 991px) {
    .ec-pkg--popular { transform: none; }
    .ec-pkg--popular:hover { transform: translateY(-6px); }
    .ec-pricing__grid { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; }
}
@media (max-width: 575px) {
    .ec-pricing__grid { grid-template-columns: 1fr; }
    .ec-pkg { padding: 24px 20px; }
}
</style>

<script>
(function () {
    const toggle   = document.getElementById('billingToggle');
    const moPrices = document.querySelectorAll('.ec-pkg__price--monthly, .ec-pkg__period--monthly');
    const yrPrices = document.querySelectorAll('.ec-pkg__price--yearly, .ec-pkg__period--yearly');
    const moLabel  = document.getElementById('toggleLabelMonthly');
    const yrLabel  = document.getElementById('toggleLabelYearly');

    if (!toggle) return;

    function setMode(yearly) {
        toggle.setAttribute('aria-pressed', yearly ? 'true' : 'false');
        moPrices.forEach(el => el.style.display = yearly ? 'none' : '');
        yrPrices.forEach(el => el.style.display = yearly ? ''   : 'none');
        if (moLabel) moLabel.style.fontWeight = yearly ? '600' : '800';
        if (moLabel) moLabel.style.color      = yearly ? '#94a3b8' : '#0f172a';
        if (yrLabel) yrLabel.style.fontWeight = yearly ? '800' : '600';
        if (yrLabel) yrLabel.style.color      = yearly ? '#0f172a' : '#94a3b8';
    }

    toggle.addEventListener('click', function () {
        const isYearly = this.getAttribute('aria-pressed') === 'true';
        setMode(!isYearly);
    });

    setMode(false); // default: monthly
})();
</script>