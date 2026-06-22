<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200/50 shadow-sm shadow-indigo-500/5 font-manrope">
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 flex justify-between items-center w-full">
        <div class="flex items-center gap-6 md:gap-12">
            <a class="text-xl md:text-2xl font-black text-indigo-600 tracking-tighter" href="{{ url('/') }}">{{ config('app.name', 'SchoolERP') }}</a>
            <div class="hidden md:flex gap-8 items-center">
                <a class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300 {{ request()->routeIs('main.features') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : '' }}" href="{{ route('main.features') }}">ফিচার</a>
                <a class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300 {{ request()->routeIs('main.why-us') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : '' }}" href="{{ route('main.why-us') }}">কেন আমরা</a>
                <a class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300 {{ request()->routeIs('main.pricing') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : '' }}" href="{{ route('main.pricing') }}">মূল্য</a>
                <a class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300 {{ request()->routeIs('main.blogs') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : '' }}" href="{{ route('main.blogs') }}">ব্লগ</a>
                <a class="text-slate-600 font-medium hover:text-indigo-500 transition-all duration-300 {{ request()->routeIs('main.contact') ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1' : '' }}" href="{{ route('main.contact') }}">যোগাযোগ</a>
            </div>
        </div>
        <div class="flex items-center gap-2 md:gap-4">
            <a href="{{ url('/login') }}" class="px-4 md:px-6 py-2 text-slate-600 font-medium hover:text-indigo-500 active:scale-95 transform transition-all duration-200">লগইন</a>
            <a href="{{ url('/register') }}" class="px-4 md:px-6 py-2 bg-primary text-on-primary font-bold rounded-lg shadow-lg shadow-indigo-500/20 active:scale-95 transform transition-all duration-200 text-sm md:text-base">শুরু করুন</a>
        </div>
    </div>
</nav>
