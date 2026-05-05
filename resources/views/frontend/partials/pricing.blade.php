@php
    use App\Models\FrontendSection;
    $section = FrontendSection::where('key', 'pricing')->first();
    $content = [];
    if($section) {
        $content = json_decode($section->content, true) ?? [];
    }
    $subtitle = $content['subtitle'] ?? 'সাশ্রয়ী প্যাকেজ সমূহ';
    $title = $content['title'] ?? 'সাশ্রয়ী প্যাকেজ সমূহ';
    $description = $content['description'] ?? 'আপনার প্রতিষ্ঠানের আকার ও প্রয়োজন অনুযায়ী বেছে নিন সেরা প্যাকেজ।';
@endphp

<section id="pricing" class="py-20 px-4 md:py-32 bg-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div class="text-center space-y-4 mb-12">
            <h2 class="font-headline-lg text-headline-lg text-on-background">{{ $title }}</h2>
            <p class="font-body-md text-on-surface-variant">{{ $description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($packages) && $packages->count() > 0)
                @foreach($packages as $package)
                    <div class="bg-white p-8 rounded-3xl border {{ $package->is_popular ? 'border-4 border-primary shadow-xl scale-105 relative' : 'border border-slate-200 shadow-sm' }} flex flex-col">
                        @if($package->is_popular)
                            <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-primary text-white px-6 py-1.5 rounded-full text-sm font-bold">সেরা পছন্দ</div>
                        @endif
                        <div class="mb-6">
                            <h3 class="font-headline-md text-2xl mb-2">{{ $package->name }}</h3>
                            <p class="text-on-surface-variant text-sm">{{ $package->description }}</p>
                        </div>

                        <div class="mb-8 flex items-baseline gap-1">
                            <span class="text-4xl font-bold text-primary">৳{{ number_format($package->price) }}</span>
                            <span class="text-on-surface-variant">/ {{ $package->duration == 'monthly' ? 'মাসিক' : 'বার্ষিক' }}</span>
                        </div>

                        <ul class="space-y-4 mb-10 flex-grow">
                            <li class="flex items-center gap-3 text-on-surface-variant"><span class="material-symbols-outlined text-green-500">check_circle</span> {{ $package->student_limit ? $package->student_limit . ' শিক্ষার্থী' : 'আনলিমিটেড শিক্ষার্থী' }}</li>
                            <li class="flex items-center gap-3 text-on-surface-variant"><span class="material-symbols-outlined text-green-500">check_circle</span> {{ $package->teacher_limit ? $package->teacher_limit . ' শিক্ষক' : 'আনলিমিটেড শিক্ষক' }}</li>
                            @if(is_array($package->features))
                                @foreach($package->features as $feature)
                                    @php $f = trim($feature); @endphp
                                    @if(str_starts_with($f, '-'))
                                        <li class="flex items-center gap-3 text-on-surface-variant text-muted"><span class="material-symbols-outlined text-red-500">cancel</span> {{ ltrim($f, '- ') }}</li>
                                    @else
                                        <li class="flex items-center gap-3 text-on-surface-variant"><span class="material-symbols-outlined text-green-500">check_circle</span> {{ ltrim($f, '+ ') }}</li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>

                        <a href="{{ route('school.register.form') }}" class="w-full py-4 {{ $package->is_popular ? 'bg-primary text-white font-bold rounded-xl shadow-lg' : 'border border-primary text-primary rounded-xl' }} text-center">{{ $package->is_popular ? 'শুরু করুন' : 'শুরু করুন' }}</a>
                    </div>
                @endforeach
            @else
                <div class="col-span-3 text-center text-on-surface-variant">
                    <p>No pricing plans are currently available.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .text-muted { color: rgba(99,102,241,0.6); }
</style>