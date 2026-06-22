@php
    $topBarSection = \App\Models\FrontendSection::where('key', 'top_bar')->first();
    $topBarContent = $topBarSection ? json_decode($topBarSection->content, true) : [];
    
    $support_phone = $topBarContent['phone'] ?? ($setting->phone ?? '+01844054129');
    $support_email = $topBarContent['email'] ?? ($setting->email ?? 'bizpoint@arenaphonebd.com');
    $brochure_text = $topBarContent['brochure_text'] ?? 'Download Brochure';
    $brochure_link = $topBarContent['brochure_link'] ?? '#';
    $demo_text = $topBarContent['demo_text'] ?? 'Request Demo';
    $demo_link = $topBarContent['demo_link'] ?? '#';
@endphp

<div class="hidden lg:block bg-[#0061A8] text-white py-2.5 px-8">
    <div class="max-w-7xl mx-auto flex justify-between items-center text-[13px] font-medium leading-none">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[17px]">call</span>
                <span class="pt-0.5">Support: {{ $support_phone }}</span>
            </div>
            <div class="flex items-center gap-2 border-l border-white/30 pl-8 h-4">
                <span class="material-symbols-outlined text-[17px]">mail</span>
                <span class="pt-0.5">Email: {{ $support_email }}</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ $brochure_link }}" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-md flex items-center gap-2 transition-all">
                <span class="material-symbols-outlined text-[17px]">download</span>
                {{ $brochure_text }}
            </a>
            <a href="{{ $demo_link }}" class="border border-white/80 hover:bg-white hover:text-[#0061A8] px-4 py-2 rounded-md transition-all">
                {{ $demo_text }}
            </a>
        </div>
    </div>
</div>

<nav class="sticky top-0 w-full z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200/50 shadow-sm font-manrope transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-8 flex items-center justify-between h-16 transition-all duration-300 nav-container">
        
        <div class="flex items-center gap-6 xl:gap-10 h-full">
            <a href="{{ url('/') }}" class="flex items-center shrink-0">
                @if(isset($setting) && isset($setting->logo_wide) && $setting->logo_wide)
                    <img src="{{ asset($setting->logo_wide) }}" alt="EduCorexa" class="h-8 md:h-10 w-auto object-contain">
                @else
                    <div class="flex items-center gap-2">
                        <span class="bg-[#0061A8] p-1.5 rounded-lg shadow-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </span>
                        <span class="text-xl font-black text-slate-900 tracking-tighter italic leading-none">edu<span class="text-[#0061A8]">corexa</span></span>
                    </div>
                @endif
            </a>

            <div class="hidden lg:flex items-center gap-4 xl:gap-7 h-full">
                <a href="{{ url('/') }}" class="nav-link whitespace-nowrap {{ Request::is('/') ? 'nav-active' : '' }} flex items-center h-full">Feature</a>
                <a href="#about" class="nav-link whitespace-nowrap flex items-center h-full">About Us</a>
                <a href="#client" class="nav-link whitespace-nowrap flex items-center h-full">Our Client</a>
                <a href="#partners" class="nav-link whitespace-nowrap flex items-center h-full">Our Partners</a> 
                <a href="{{ route('main.blogs') }}" class="nav-link whitespace-nowrap {{ request()->routeIs('main.blogs') ? 'nav-active' : '' }} flex items-center h-full">Blog</a>
                <a href="#contact" class="nav-link whitespace-nowrap flex items-center h-full">Contact Us</a>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-2 xl:gap-4 shrink-0 h-full">
            @auth
                <a href="{{ route('common.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm bg-[#0061A8] text-white rounded-lg font-bold hover:bg-[#004d85] transition-all shadow-md">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login.form') }}" class="flex items-center px-3 py-2 text-sm text-slate-600 font-semibold hover:bg-slate-100 rounded-lg transition-all h-fit">Login</a>
                <a href="{{ route('school.register.form') }}" class="flex items-center justify-center px-4 py-2 bg-[#0061A8] text-white text-[10px] font-extrabold rounded-lg hover:bg-[#004d85] hover:-translate-y-0.5 transition-all shadow-md uppercase tracking-widest whitespace-nowrap h-fit">
                    Register School
                </a>
            @endauth
        </div>

        <div class="lg:hidden flex items-center">
            <button id="mobile-menu-btn" class="p-2.5 rounded-xl text-slate-700 bg-slate-50 border border-slate-200">
                <svg id="menu-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="menu-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="lg:hidden hidden bg-white border-b border-slate-100 px-6 py-6 animate-fade-in">
        <div class="flex flex-col gap-4">
            <a href="{{ url('/') }}" class="text-indigo-600 font-bold text-lg">Feature</a>
            <a href="#about" class="text-slate-600 font-medium">About Us</a>
            <a href="#client" class="text-slate-600 font-medium">Our Client</a>
            <a href="{{ route('main.blogs') }}" class="text-slate-600 font-medium {{ request()->routeIs('main.blogs') ? 'text-indigo-600 font-bold' : '' }}">Blog</a>
            <a href="#contact" class="text-slate-600 font-medium">Contact Us</a>
            <hr class="border-slate-100">
            @auth
                <a href="{{ route('common.dashboard') }}" class="w-full py-3 bg-indigo-600 text-white text-center rounded-xl font-bold">Dashboard</a>
            @else
                <a href="{{ route('login.form') }}" class="w-full py-3 border border-slate-200 text-slate-700 text-center rounded-xl font-bold">Login</a>
                <a href="{{ route('school.register.form') }}" class="w-full py-3 bg-slate-900 text-white text-center rounded-xl font-bold">Get Started</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    .navbar .container-fluid {
        height: 70px; /* লোগোর উচ্চতার সমান করুন */
    }


    .nav-link {
        @apply text-[15px] font-semibold text-slate-600 hover:text-indigo-600 transition-all duration-300;
    }
    .nav-active {
        @apply text-indigo-600;
    }
    /* স্ক্রল করলে নেভবার ছোট হবে */
    nav.scrolled {
        @apply py-0 bg-white/95 shadow-lg;
    }
    nav.scrolled .nav-container {
        @apply h-14 md:h-16;
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }
    @media (max-width: 768px) {
        .navbar .container-fluid {
            height: 64px; /* মোবাইলের লোগোর উচ্চতার সমান করুন */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open');
        const closeIcon = document.getElementById('menu-close');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>