@php
    use App\Models\FrontendSection;
    $section = FrontendSection::where('key', 'pricing')->first();
    $content = [];
    if($section) {
        $content = json_decode($section->content, true) ?? [];
    }
    $title = $content['title'] ?? 'সাশ্রয়ী প্যাকেজ সমূহ';
    $description = $content['description'] ?? 'আপনার প্রতিষ্ঠানের আকার ও প্রয়োজন অনুযায়ী বেছে নিন সেরা প্যাকেজ।';
@endphp

<section id="pricing" class="py-20 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $title }}</h2>
            <p class="text-slate-600 text-lg">{{ $description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
            @if(isset($packages) && $packages->count() > 0)
                @foreach($packages as $package)
                    <div class="bg-white rounded-2xl transition-all duration-300 hover:-translate-y-2 
                        {{ $package->is_popular 
                            ? 'border-2 border-indigo-600 shadow-[0_20px_50px_rgba(79,70,229,0.15)] relative z-10 py-12 px-8' 
                            : 'border border-slate-200 shadow-xl shadow-slate-200/50 p-8' 
                        }} flex flex-col h-full">
                        
                        @if($package->is_popular)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white px-5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                মোস্ট পপুলার
                            </div>
                        @endif

                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $package->name }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $package->description }}</p>
                        </div>

                        <div class="mb-8 flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-900">৳{{ number_format($package->price) }}</span>
                            <span class="text-slate-500 font-medium">/ {{ $package->duration == 'monthly' ? 'মাস' : 'বছর' }}</span>
                        </div>

                        <div class="space-y-4 mb-10 flex-grow">
                            <div class="flex items-center gap-3 text-slate-700 font-medium">
                                <i class="fas fa-check-circle text-indigo-500"></i>
                                <span>{{ $package->student_limit ? $package->student_limit . ' শিক্ষার্থী' : 'আনলিমিটেড শিক্ষার্থী' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700 font-medium">
                                <i class="fas fa-check-circle text-indigo-500"></i>
                                <span>{{ $package->teacher_limit ? $package->teacher_limit . ' শিক্ষক' : 'আনলিমিটেড শিক্ষক' }}</span>
                            </div>

                            @if(is_array($package->features))
                                @foreach($package->features as $feature)
                                    @php $f = trim($feature); @endphp
                                    @if(str_starts_with($f, '-'))
                                        <div class="flex items-center gap-3 text-slate-400">
                                            <i class="fas fa-times-circle text-slate-300"></i>
                                            <span class="line-through">{{ ltrim($f, '- ') }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3 text-slate-700">
                                            <i class="fas fa-check-circle text-indigo-500"></i>
                                            <span>{{ ltrim($f, '+ ') }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <a href="{{ route('school.register.form') }}" 
                            class="w-full py-4 rounded-xl text-center font-bold transition-all duration-300
                            {{ $package->is_popular 
                                ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200' 
                                : 'bg-slate-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-600 hover:text-white' 
                            }}">
                            শুরু করুন
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                    <p class="text-slate-500">বর্তমানে কোনো প্যাকেজ উপলব্ধ নেই।</p>
                </div>
            @endif
        </div>
    </div>
</section>