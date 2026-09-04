@php
    use App\Models\FrontendSection;
    $section = FrontendSection::where('key', 'features')->first();
    $featuresContent = [];
    if($section) {
        $featuresContent = json_decode($section->content, true) ?? [];
    }

    $title = $featuresContent['title'] ?? 'আমাদের শক্তিশালী ফিচারের মাধ্যমে প্রতিষ্ঠান পরিচালনা করুন';
    $description = $featuresContent['description'] ?? 'একটি আধুনিক শিক্ষা প্রতিষ্ঠানের জন্য প্রয়োজনীয় সকল প্রযুক্তিগত সমাধান এখন এক জায়গায়।';
    
    // ডিফল্ট আইটেম সেটআপ (যদি ডাটাবেসে না থাকে)
    $items = !empty($featuresContent['items']) ? $featuresContent['items'] : [
        ['icon'=>'language','title'=>'ডায়নামিক ওয়েবসাইট','desc'=>'আপনার প্রতিষ্ঠানের জন্য একটি প্রফেশনাল ও আধুনিক ওয়েবসাইট যা অটোমেটিক আপডেট হবে আপনার প্যানেল থেকে।', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCTzSWRG2MA_xeVwjduVsCaiMkf_Tg_5U0jwf2YLDaCTW5HG1tLTrALzceAlT4z917d6Org-tOI_r_PTDJii8A0rQyTu_16sbTPXHmZ8RwUjCI2lRfoH_FMgxI0Q6ZTwN82yBYHMI9Bhbn5_JqPSBUeU2upacyWwOryTdA55NEPmzshD2denDgg2m4lhyQkLOkkXdDpFqReH-u9A5hkFHjmNAtY7k3OCmwA4Nd1PD22a7U2DhhpBkdjHw9FshJi3jEImfuk-DelbyU'],
        ['icon'=>'person_add','title'=>'অনলাইন ভর্তি','desc'=>'বাসায় বসেই অভিভাবকরা ভর্তি আবেদন করতে পারবেন এবং অনলাইনে পেমেন্ট সম্পন্ন করতে পারবেন।'],
        ['icon'=>'fact_check','title'=>'ডিজিটাল হাজিরা','desc'=>'আরএফআইডি কার্ড বা ফিঙ্গারপ্রিন্টের মাধ্যমে স্মার্ট হাজিরা ব্যবস্থা এবং অটোমেটিক এসএমএস নোটিফিকেশন।'],
        ['icon'=>'analytics','title'=>'ফলাফল ও মার্কশিট','desc'=>'দ্রুত ও নির্ভুলভাবে ফলাফল তৈরি করুন এবং অ্যাপের মাধ্যমেই মার্কশিট ডাউনলোড করার সুবিধা।'],
        ['icon'=>'account_balance_wallet','title'=>'অটোমেটেড একাউন্টস','desc'=>'বেতন আদায়, খরচ এবং সকল আর্থিক রিপোর্ট এখন হাতের মুঠোয়। ম্যানুয়াল হিসেবের ঝামেলা নেই।', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfwoI_JIkxS_kA1T1TpJrglOsHZhecqmEQQFBTnRCOJTDVM2rwfYGLhzc8sfh12EvA3zSBZ76lcZRi_gg7z4O6pfdNyJFWEw5C-1ybPmIL34x_un6j1KkDHij5dEr2sbkROFvewFiGpavAYgTQo9_aaj5LhD8BWDYfcYGH_xQXG0WUHitfif1NGXpftV4dO6Fy-GUx6h1U9FD3HMfjF4Ea5q9DpDctTGV-1K7z2PUzeTAaWihpCmg2kWj4ipxArEttoAeIwz_Yumc'],
        ['icon'=>'sms','title'=>'এসএমএস অ্যালার্ট','desc'=>'হাজিরা, ফলাফল এবং নোটিশের জন্য অটোমেটেড বাল্ক এসএমএস সার্ভিস যা অভিভাবকের যোগাযোগ নিশ্চিত করবে।'],
        ['icon'=>'groups','title'=>'শিক্ষক ও স্টাফ ম্যানেজমেন্ট','desc'=>'প্রোফাইল, দায়িত্ব, উপস্থিতি ও যোগাযোগের তথ্য এক জায়গা থেকে সহজে পরিচালনা করুন।'],
        ['icon'=>'campaign','title'=>'নোটিশ ও ঘোষণা','desc'=>'গুরুত্বপূর্ণ নোটিশ, ইভেন্ট ও আপডেট দ্রুত প্রকাশ করুন এবং অভিভাবকদের সঙ্গে যোগাযোগ রাখুন.'],
        ['icon'=>'insights','title'=>'স্মার্ট রিপোর্টিং','desc'=>'ড্যাশবোর্ডে গুরুত্বপূর্ণ তথ্য দেখুন এবং সিদ্ধান্ত নেওয়ার জন্য পরিষ্কার রিপোর্ট তৈরি করুন।']
    ];
@endphp

<!-- Features Bento Grid -->
<section id="features" class="feature-showcase py-20 md:py-32 px-4 md:px-8 bg-surface-container-low">
    <div class="max-w-7xl mx-auto">
        <div class="feature-heading">
            <span class="feature-eyebrow"><i class="material-symbols-outlined">auto_awesome</i> EduCorexa platform</span>
            <h2 class="font-headline-lg text-headline-lg text-on-background">{{ $title }}</h2>
            <p class="font-body-md text-on-surface-variant">{{ $description }}</p>
            <div class="feature-heading-rule"><span></span><i class="material-symbols-outlined">school</i></div>
            <div class="feature-heading-note"><i class="material-symbols-outlined">verified</i><span>একটি প্ল্যাটফর্ম, প্রতিটি গুরুত্বপূর্ণ কাজের জন্য।</span></div>
        </div>

        <div class="feature-grid grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-6">
            @foreach($items as $index => $item)
                @php
                    // ইনডেক্স অনুযায়ী কালার থিম সেটআপ
                    $themes = [
                        0 => 'bg-primary/10 text-primary',
                        1 => 'bg-tertiary/10 text-tertiary',
                        2 => 'bg-secondary/10 text-secondary',
                        3 => 'bg-error/10 text-error',
                        4 => 'bg-primary/10 text-primary',
                        5 => 'bg-primary-container/10 text-primary-container'
                    ];
                    $currentTheme = $themes[$index] ?? 'bg-primary/10 text-primary';
                    $shortDescription = $item['short_desc'] ?? Str::limit(strip_tags($item['desc'] ?? ''), 88);
                @endphp

                <article class="feature-card feature-card-item bg-white p-6 md:p-7 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group {{ $index >= 8 ? 'feature-card-hidden' : '' }}">
                    <div class="feature-card-top">
                        <div class="feature-icon {{ $currentTheme }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">{{ $item['icon'] }}</span>
                        </div>
                        <span class="feature-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-3">{{ $item['title'] }}</h3>
                    <p class="feature-card-description text-on-surface-variant font-body-md">{{ $shortDescription }}</p>
                </article>
            @endforeach
        </div>

        @if(count($items) > 8)
            <div class="text-center mt-8">
                <button type="button" class="feature-show-more" id="featureShowMore">
                    <span>Show More</span><i class="material-symbols-outlined">expand_more</i>
                </button>
            </div>
        @endif
    </div>
</section>

<style>
    .feature-showcase {
        position: relative;
        overflow: hidden;
        background-color: #fffbeb !important;
        background-image: linear-gradient(135deg, rgba(255,251,235,.96), rgba(255,241,242,.96)), linear-gradient(rgba(16,42,67,.035) 1px, transparent 1px), linear-gradient(90deg, rgba(16,42,67,.035) 1px, transparent 1px) !important;
        background-size: cover, 34px 34px, 34px 34px !important;
        background-position: center, 0 0, 0 0;
        background-repeat: no-repeat, repeat, repeat;
    }
    .feature-heading { position:relative; max-width:760px; margin:0 auto 48px; text-align:center; }
    .feature-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 14px;
        color: #0f766e;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }
    .feature-eyebrow .material-symbols-outlined { font-size: 17px; }
    .feature-heading h2 {
        max-width: 760px;
        margin: 0 auto;
        color: #102a43 !important;
        line-height: 1.12;
        letter-spacing: -.02em;
    }
    .feature-heading p { max-width:620px; margin:16px auto 0; color:#52606d !important; line-height:1.8; }
    .feature-heading-rule { display:flex; align-items:center; gap:10px; margin:22px auto 0; max-width:180px; color:#c68b2c; }
    .feature-heading-rule span { height:1px; flex:1; background:#cbd5d8; }
    .feature-heading-rule i { font-size:16px; }
    .feature-heading-note { display:flex; align-items:flex-start; justify-content:center; gap:8px; max-width:300px; margin:28px auto 0; color:#0f766e; font-size:.82rem; font-weight:700; line-height:1.5; }
    .feature-heading-note i { flex:0 0 auto; font-size:19px; }
    .feature-grid { position:relative; grid-template-columns:repeat(4,minmax(0,1fr)); }
    .feature-card-hidden { display:none !important; }
    .feature-card {
        position:relative;
        min-height:220px;
        display:flex;
        flex-direction:column;
        padding:24px !important;
        border-color:#dce5e7 !important;
        border-radius:12px !important;
        box-shadow:0 8px 24px rgba(16,42,67,.06) !important;
        transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .feature-card::after { content:''; position:absolute; top:0; left:24px; right:24px; height:3px; border-radius:0 0 4px 4px; background:#0f766e; opacity:.85; }
    .feature-card:nth-child(2)::after, .feature-card:nth-child(6)::after { background:#d65a43; }
    .feature-card:nth-child(3)::after { background:#c68b2c; }
    .feature-card:nth-child(4)::after { background:#3b82f6; }
    .feature-card:hover { transform:translateY(-5px); border-color:#9fb9bd !important; box-shadow:0 16px 32px rgba(16,42,67,.12) !important; }
    .feature-card h3 { color:#102a43 !important; line-height:1.25; }
    .feature-card p { color:#52606d !important; line-height:1.65; }
    .feature-card-description { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; }
    .feature-card .material-symbols-outlined { color:inherit; }
    .feature-card-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
    .feature-icon { width:46px; height:46px; }
    .feature-index { color:#9fb3b8; font-size:.72rem; font-weight:800; letter-spacing:.12em; }
    .feature-card h3 { margin-bottom:10px !important; }
    .feature-card p { margin-bottom:20px; }
    .feature-show-more { display:inline-flex; align-items:center; gap:6px; padding:11px 20px; border:1px solid #b7d1d0; border-radius:8px; background:#fff; color:#0f766e; font-size:.82rem; font-weight:800; cursor:pointer; transition:all .2s ease; }
    .feature-show-more:hover { background:#0f766e; color:#fff; border-color:#0f766e; box-shadow:0 8px 18px rgba(15,118,110,.18); }
    .feature-show-more i { font-size:18px; }
    @media (max-width: 767px) {
        .feature-heading { margin-bottom:32px; }
        .feature-card { min-height:190px; padding:18px !important; }
        .feature-heading h2 { font-size:2rem; }
        .feature-grid { grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; }
        .feature-card-top { margin-bottom:14px; }
        .feature-icon { width:38px; height:38px; }
        .feature-icon .material-symbols-outlined { font-size:22px; }
        .feature-card h3 { font-size:1rem; }
        .feature-card p { font-size:.78rem; line-height:1.55; }
        .feature-index { font-size:.62rem; }
    }
</style>

@if(count($items) > 8)
<script>
    document.getElementById('featureShowMore')?.addEventListener('click', function () {
        document.querySelectorAll('.feature-card-hidden').forEach(function (card) {
            card.classList.remove('feature-card-hidden');
        });
        this.remove();
    });
</script>
@endif