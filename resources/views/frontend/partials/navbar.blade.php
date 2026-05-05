<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200/50 shadow-sm font-manrope">
    <div class="max-w-7xl mx-auto px-6 md:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                @if(isset($setting) && $setting->logo_wide)
                    <img src="{{ asset($setting->logo_wide) }}" alt="{{ $setting->site_name }}" class="h-10 md:h-12 object-contain">
                @else
                    <span class="text-2xl font-black text-indigo-600 tracking-tighter">educorexa</span>
                @endif
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1 transition-all duration-300 {{ Request::is('/') ? 'active' : '' }}">Website</a>
                <a href="#features" class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300">Online Admission</a>
                <a href="#features" class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300">Attendance</a>
                <a href="#features" class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300">Results</a>
                <a href="#pricing" class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300">Fees</a>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-4">
            @auth
                <a href="{{ route('common.dashboard') }}" class="px-5 py-2 text-sm border border-indigo-600 text-indigo-600 rounded-lg font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login.form') }}" class="px-5 py-2 text-sm text-slate-600 hover:text-indigo-500 transition-all">Login</a>
                <a href="{{ route('school.register.form') }}" class="px-5 py-2 bg-primary text-on-primary font-bold rounded-lg shadow-lg">Get Started</a>
            @endauth
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
            <button id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-menu" class="p-2 rounded-md text-slate-700 bg-white/60 border border-slate-200">
                <svg id="menu-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="menu-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-4">
        <div class="flex flex-col gap-3 pt-2">
            <a href="{{ url('/') }}" class="py-2 text-indigo-600 font-semibold border-b border-slate-100">Website</a>
            <a href="#features" class="py-2 text-slate-700">Online Admission</a>
            <a href="#features" class="py-2 text-slate-700">Attendance</a>
            <a href="#features" class="py-2 text-slate-700">Results</a>
            <a href="#pricing" class="py-2 text-slate-700">Fees</a>
        </div>
        <div class="mt-3 flex flex-col gap-2">
            @auth
                <a href="{{ route('common.dashboard') }}" class="w-full text-center px-4 py-3 border border-indigo-600 rounded-lg text-indigo-600">Dashboard</a>
            @else
                <a href="{{ route('login.form') }}" class="w-full text-center px-4 py-3 rounded-lg border border-slate-200">Login</a>
                <a href="{{ route('school.register.form') }}" class="w-full text-center px-4 py-3 rounded-lg bg-primary text-white font-bold">Get Started</a>
            @endauth
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const menuOpenIcon = document.getElementById('menu-open');
            const menuCloseIcon = document.getElementById('menu-close');

            btn.addEventListener('click', function() {
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', String(!expanded));
                menu.classList.toggle('hidden');
                menuOpenIcon.classList.toggle('hidden');
                menuCloseIcon.classList.toggle('hidden');
            });

            // Close mobile menu when clicking a link
            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        menuOpenIcon.classList.remove('hidden');
                        menuCloseIcon.classList.add('hidden');
                        btn.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            // Add scroll effect
            const navbar = document.querySelector('nav');
            window.addEventListener('scroll', () => {
                navbar.classList.toggle('scrolled', window.scrollY > 20);
            });
        });
    </script>

    <style>
        nav.scrolled {
            padding-top: 6px;
            padding-bottom: 6px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 30px rgba(37,38,69,0.06);
        }
        .hero-gradient { background: linear-gradient(135deg, #4648d4 0%, #8127cf 100%); }
    </style>
</nav>