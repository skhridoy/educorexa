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
    $items = $featuresContent['items'] ?? [
        ['icon'=>'language','title'=>'ডায়নামিক ওয়েবসাইট','desc'=>'আপনার প্রতিষ্ঠানের জন্য একটি প্রফেশনাল ও আধুনিক ওয়েবসাইট যা অটোমেটিক আপডেট হবে আপনার প্যানেল থেকে।', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCTzSWRG2MA_xeVwjduVsCaiMkf_Tg_5U0jwf2YLDaCTW5HG1tLTrALzceAlT4z917d6Org-tOI_r_PTDJii8A0rQyTu_16sbTPXHmZ8RwUjCI2lRfoH_FMgxI0Q6ZTwN82yBYHMI9Bhbn5_JqPSBUeU2upacyWwOryTdA55NEPmzshD2denDgg2m4lhyQkLOkkXdDpFqReH-u9A5hkFHjmNAtY7k3OCmwA4Nd1PD22a7U2DhhpBkdjHw9FshJi3jEImfuk-DelbyU'],
        ['icon'=>'person_add','title'=>'অনলাইন ভর্তি','desc'=>'বাসায় বসেই অভিভাবকরা ভর্তি আবেদন করতে পারবেন এবং অনলাইনে পেমেন্ট সম্পন্ন করতে পারবেন।'],
        ['icon'=>'fact_check','title'=>'ডিজিটাল হাজিরা','desc'=>'আরএফআইডি কার্ড বা ফিঙ্গারপ্রিন্টের মাধ্যমে স্মার্ট হাজিরা ব্যবস্থা এবং অটোমেটিক এসএমএস নোটিফিকেশন।'],
        ['icon'=>'analytics','title'=>'ফলাফল ও মার্কশিট','desc'=>'দ্রুত ও নির্ভুলভাবে ফলাফল তৈরি করুন এবং অ্যাপের মাধ্যমেই মার্কশিট ডাউনলোড করার সুবিধা।'],
        ['icon'=>'account_balance_wallet','title'=>'অটোমেটেড একাউন্টস','desc'=>'বেতন আদায়, খরচ এবং সকল আর্থিক রিপোর্ট এখন হাতের মুঠোয়। ম্যানুয়াল হিসেবের ঝামেলা নেই।', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfwoI_JIkxS_kA1T1TpJrglOsHZhecqmEQQFBTnRCOJTDVM2rwfYGLhzc8sfh12EvA3zSBZ76lcZRi_gg7z4O6pfdNyJFWEw5C-1ybPmIL34x_un6j1KkDHij5dEr2sbkROFvewFiGpavAYgTQo9_aaj5LhD8BWDYfcYGH_xQXG0WUHitfif1NGXpftV4dO6Fy-GUx6h1U9FD3HMfjF4Ea5q9DpDctTGV-1K7z2PUzeTAaWihpCmg2kWj4ipxArEttoAeIwz_Yumc'],
        ['icon'=>'sms','title'=>'এসএমএস অ্যালার্ট','desc'=>'হাজিরা, ফলাফল এবং নোটিশের জন্য অটোমেটেড বাল্ক এসএমএস সার্ভিস যা অভিভাবকের যোগাযোগ নিশ্চিত করবে।']
    ];
@endphp

<!-- Features Bento Grid -->
<section id="features" class="py-20 md:py-32 px-4 md:px-8 bg-surface-container-low">
    <div class="max-w-7xl mx-auto space-y-16">
        <div class="text-center space-y-4 max-w-2xl mx-auto">
            <h2 class="font-headline-lg text-headline-lg text-on-background">{{ $title }}</h2>
            <p class="font-body-md text-on-surface-variant">{{ $description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($items as $index => $item)
                @php
                    // ইমেজ ইউআরএল প্রসেসিং
                    $imageUrl = isset($item['image']) ? (Str::startsWith($item['image'], ['http://','https://']) ? $item['image'] : asset($item['image'])) : null;
                    
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
                @endphp

                {{-- Feature 1 & 5 (Wide Cards) --}}
                @if($index === 0 || $index === 4)
                    <div class="md:col-span-2 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="{{ $index === 4 ? 'flex items-start justify-between' : '' }}">
                            <div class="{{ $index === 4 ? 'space-y-4 max-w-xs' : '' }}">
                                <div class="w-12 h-12 {{ $currentTheme }} rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">{{ $item['icon'] }}</span>
                                </div>
                                <h3 class="font-headline-md text-headline-md mb-3">{{ $item['title'] }}</h3>
                                <p class="text-on-surface-variant font-body-md {{ $index === 0 ? 'mb-6' : '' }}">{{ $item['desc'] }}</p>
                            </div>
                            
                            @if($imageUrl && $index === 4)
                                <div class="hidden lg:block">
                                    <img alt="{{ $item['title'] }}" class="w-48 h-48 rounded-xl object-cover shadow-lg" src="{{ $imageUrl }}"/>
                                </div>
                            @endif
                        </div>

                        @if($imageUrl && $index === 0)
                            <img alt="{{ $item['title'] }}" class="rounded-lg border border-slate-100 w-full h-48 object-cover" src="{{ $imageUrl }}"/>
                        @endif
                    </div>

                {{-- Feature 2, 3, 4, 6 (Small Cards) --}}
                @else
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="w-12 h-12 {{ $currentTheme }} rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">{{ $item['icon'] }}</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-3 text-lg">{{ $item['title'] }}</h3>
                        <p class="text-on-surface-variant font-body-md">{{ $item['desc'] }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>