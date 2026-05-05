@php
    use App\Models\FrontendSection;

    // Load from passed $section (when home renders dynamic sections) otherwise fetch from DB
    $heroSection = $section ?? FrontendSection::where('key', 'hero')->first();
    $heroContent = [];
    if($heroSection) {
        $heroContent = json_decode($heroSection->content, true) ?? [];
    }

    // Defaults
    $title = $heroContent['title'] ?? 'আপনার স্কুল ম্যানেজমেন্টকে <span class="text-primary italic">সহজ, দ্রুত ও স্মার্ট</span> করুন';
    $subtitle = $heroContent['subtitle'] ?? 'স্মার্ট এডুকেশন সলিউশন';
    $description = $heroContent['description'] ?? 'আধুনিক প্রযুক্তির সমন্বয়ে আপনার শিক্ষা প্রতিষ্ঠান পরিচালনা করুন আরও দক্ষতার সাথে।';
    $btn1_text = $heroContent['btn1_text'] ?? 'ফ্রি ট্রায়াল শুরু করুন';
    $btn1_link = $heroContent['btn1_link'] ?? url('/register');
    $btn2_text = $heroContent['btn2_text'] ?? 'ডেমো দেখুন';
    $btn2_link = $heroContent['btn2_link'] ?? '#';
    $image = isset($heroContent['image']) ? (Str::startsWith($heroContent['image'], ['http://','https://']) ? $heroContent['image'] : asset($heroContent['image'])) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCWHbHoBM_EQblc-eWrh802ya615yE3r6UQDgwqVE-6aMBLYLbQv6i5N5y7bC5SajqSjHPzt8UJUqbZ8a-4hK92pD6RG1C6yBdifB-cmZYhS3mjX9nmgVhRgkhSK3a2YX2ZEILIV36FFlwTL9pzFalpXRP1lTOUcY6_ohEFBix6X2uvS1gpAkK6uukxTCMakDZn-8tJdm5YHTqqvRTh35U0nA5CK-tYPPTaLEcdU7t8aze4qApZHi-qCYEPMdwHFsx96UsebHp_dqo';
@endphp

<!-- Hero Section -->
<section class="relative overflow-hidden pt-48 pb-32 px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-24 relative z-10">
        <div class="md:w-1/2 space-y-12">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-container/10 border border-primary-container/20 rounded-full text-primary font-label-sm">
                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                    {{ $subtitle }}
                </div>
                <h1 class="font-display-xl text-display-xl text-on-background leading-tight">
                    {!! $title !!}
                </h1>
            </div>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                {{ $description }}
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ $btn1_link }}" class="px-8 py-4 hero-gradient text-white font-bold rounded-xl shadow-xl shadow-indigo-500/30 flex items-center gap-2 hover:scale-[1.02] transition-transform">
                    {{ $btn1_text }}
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
                <a href="{{ $btn2_link }}" class="px-8 py-4 bg-white border border-outline-variant text-on-surface font-bold rounded-xl flex items-center gap-2 hover:bg-slate-50 transition-colors">
                    {{ $btn2_text }}
                </a>
            </div>
        </div>
        <div class="md:w-1/2 relative">
            <div class="absolute -top-12 -left-12 w-64 h-64 bg-primary/20 rounded-full blur-[100px] opacity-50"></div>
            <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-tertiary/20 rounded-full blur-[100px] opacity-50"></div>
            <div class="relative glass-card p-6 rounded-[2.5rem] shadow-2xl border-white/40 bg-white/40">
                <img alt="app.bd Dashboard Preview" class="rounded-[2rem] w-full h-auto object-cover shadow-lg" src="{{ $image }}"/>
            </div>
        </div>
    </div>
</section>
