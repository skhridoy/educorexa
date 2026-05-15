@php
    use App\Models\FrontendSection;

    // Load from passed $section (when home renders dynamic sections) otherwise fetch from DB
    $heroSection = $section ?? FrontendSection::where('key', 'hero')->first();
    $heroContent = [];
    if($heroSection) {
        $heroContent = json_decode($heroSection->content, true) ?? [];
    }

    // Defaults matching the reference image
    $title = $heroContent['title'] ?? 'The Most Reliable ERP <br><span class="text-slate-800">Software</span>';
    $description = $heroContent['description'] ?? 'We make learning engaging & effective, so that you are ready to achieve your goals';
    $btn1_text = $heroContent['btn1_text'] ?? 'Get Started Free';
    $btn1_link = $heroContent['btn1_link'] ?? '#';
    $btn2_text = $heroContent['btn2_text'] ?? 'View Demo';
    $btn2_link = $heroContent['btn2_link'] ?? '#';
    
    // Using a high-quality girl pointing image from Unsplash as fallback
    $image = isset($heroContent['image']) ? (Str::startsWith($heroContent['image'], ['http://','https://']) ? $heroContent['image'] : asset($heroContent['image'])) : 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop';
@endphp

<!-- Reference-Matched Hero Section -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden px-6 lg:px-20 bg-gradient-to-br from-[#FFFBEB] to-[#FFF1F2]">
    
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center relative z-10 py-12 md:py-20">
        
        <!-- Left Content -->
        <div class="space-y-8 animate-fade-in-left">
            <div class="space-y-5">
                <h1 class="font-display-xl text-[40px] md:text-[50px] lg:text-[60px] text-[#2D2D2D] font-extrabold leading-[1.1] tracking-tight">
                    {!! $title !!}
                </h1>
                <p class="font-body-lg text-base md:text-lg text-slate-600 max-w-lg leading-relaxed">
                    {{ $description }}
                </p>
            </div>

            <div class="flex flex-row items-center flex-wrap gap-4">
                <!-- Action Button -->
                <a href="{{ $btn1_link }}" class="flex items-center gap-2 bg-[#0061A8] text-white px-6 py-3 rounded-lg shadow-md hover:bg-[#004d85] transition-all transform hover:-translate-y-1">
                    <span class="font-bold text-sm">{{ $btn1_text }}</span>
                </a>
                
                <!-- View Demo Button -->
                <a href="{{ $btn2_link }}" class="flex items-center gap-2 bg-white border border-slate-200 text-[#2D2D2D] px-6 py-3 rounded-lg hover:border-red-500 hover:text-red-500 transition-all transform hover:-translate-y-1">
                    <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-[14px]">language</span>
                    </div>
                    <span class="font-bold text-sm">{{ $btn2_text }}</span>
                </a>
            </div>
        </div>

        <!-- Right Side: Image with Floating Cards -->
        <div class="relative animate-fade-in-right flex justify-center lg:justify-end mt-12 lg:mt-0">
            <!-- Background Dotted Circle -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] border-2 border-dashed border-red-300 rounded-full opacity-40 animate-[spin_20s_linear_infinite]"></div>
            
            <!-- Main Image Container with Red/Pink Circle -->
            <div class="relative w-[350px] h-[350px] md:w-[450px] md:h-[450px] lg:w-[500px] lg:h-[500px] rounded-full overflow-hidden border-[15px] border-white shadow-2xl z-20">
                <div class="absolute inset-0 bg-[#FF5A79]"></div>
                <img src="{{ $image }}" alt="Education Potential" class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-[110%] object-cover object-top scale-110">
            </div>

            <!-- Floating Info Cards -->
            <!-- 15+ Districts -->
            <div class="absolute -left-4 top-[20%] bg-white p-4 rounded-2xl shadow-xl z-30 border border-slate-50 flex items-center gap-3 animate-float" style="animation-delay: 0.2s;">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-[#FF5A79]">
                    <span class="material-symbols-outlined">map</span>
                </div>
                <div>
                    <p class="text-xl font-black text-[#2D2D2D]">15+</p>
                    <p class="text-[10px] uppercase font-bold text-slate-400">Districts</p>
                </div>
            </div>

            <!-- 25K Students -->
            <div class="absolute -right-4 top-[10%] bg-white p-4 rounded-2xl shadow-xl z-30 border border-slate-50 flex flex-col items-center gap-1 animate-float" style="animation-delay: 1s;">
                <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center text-[#FF5A79]">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <p class="text-xl font-black text-[#2D2D2D]">25K</p>
                <p class="text-[10px] uppercase font-bold text-slate-400">Students</p>
            </div>

            <!-- 20+ School -->
            <div class="absolute right-4 bottom-[5%] bg-white p-4 rounded-2xl shadow-xl z-30 border border-slate-50 flex items-center gap-3 animate-float" style="animation-delay: 1.8s;">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-[#FF5A79]">
                    <span class="material-symbols-outlined">apartment</span>
                </div>
                <div>
                    <p class="text-xl font-black text-[#2D2D2D]">20+</p>
                    <p class="text-[10px] uppercase font-bold text-slate-400">School</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }
    @keyframes fade-in-left {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-left {
        animation: fade-in-left 1s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    @keyframes fade-in-right {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-right {
        animation: fade-in-right 1s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
</style>
