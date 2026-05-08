<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200/50 shadow-sm font-manrope transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-8 py-3 flex items-center justify-between h-16 md:h-20 transition-all duration-300 nav-container">
        
        <div class="flex items-center gap-12">
            <a href="{{ url('/') }}" class="flex items-center group">
                @if(isset($setting) && $setting->logo_wide)
                    {{-- লোগো সাইজ এখানে কন্ট্রোল করা হয়েছে --}}
                    <img src="{{ asset($setting->logo_wide) }}" alt="EduCorexa" class="h-8 md:h-11 w-auto object-contain transition-transform group-hover:scale-105">
                @else
                    <div class="flex items-center gap-2">
                        <span class="bg-indigo-600 p-1.5 rounded-lg shadow-indigo-200 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </span>
                        <span class="text-2xl font-black text-slate-900 tracking-tighter italic">edu<span class="text-indigo-600">corexa</span></span>
                    </div>
                @endif
            </a>

            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'nav-active' : '' }}">Home</a>
                
                {{-- Dropdown Example for Solutions --}}
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1">
                        Solutions <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white border border-slate-100 shadow-xl rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-2">
                        <a href="#features" class="block px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg">School Management</a>
                        <a href="#features" class="block px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg">Online Admission</a>
                        <a href="#features" class="block px-4 py-2 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg">Exam & Results</a>
                    </div>
                </div>

                <a href="#pricing" class="nav-link">Pricing</a>
                <a href="#about" class="nav-link">About Us</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-3">
            @auth
                <a href="{{ route('common.dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login.form') }}" class="px-5 py-2.5 text-sm text-slate-600 font-semibold hover:bg-slate-100 rounded-xl transition-all">Login</a>
                <a href="{{ route('school.register.form') }}" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 hover:-translate-y-0.5 transition-all shadow-md">
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
            <a href="{{ url('/') }}" class="text-indigo-600 font-bold text-lg">Home</a>
            <a href="#features" class="text-slate-600 font-medium">Solutions</a>
            <a href="#pricing" class="text-slate-600 font-medium">Pricing</a>
            <a href="#contact" class="text-slate-600 font-medium">Contact</a>
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