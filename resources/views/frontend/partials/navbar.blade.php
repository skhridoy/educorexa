@php
    $topBarSection = \App\Models\FrontendSection::where('key', 'top_bar')->first();
    $topBarContent = $topBarSection ? json_decode($topBarSection->content, true) : [];

    $support_phone  = $topBarContent['phone']         ?? ($setting->phone  ?? '+01844054129');
    $support_email  = $topBarContent['email']         ?? ($setting->email  ?? 'info@educorexa.com');
    $brochure_link  = $topBarContent['brochure_link'] ?? '#';
    $demo_link      = $topBarContent['demo_link']     ?? '#';
@endphp

{{-- ======= MAIN HEADER ======= --}}
<header id="ec-header" class="ec-header">
    <div class="ec-header__inner">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="ec-header__logo">
            @if(isset($setting) && isset($setting->logo_wide) && $setting->logo_wide)
                <img src="{{ asset($setting->logo_wide) }}" alt="EduCorexa" class="ec-logo-img">
            @else
                <span class="ec-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </span>
                <span class="ec-logo-text">edu<span>corexa</span></span>
            @endif
        </a>

        {{-- Desktop nav --}}
        <nav class="ec-nav">
            <ul class="ec-nav__list">
                <li><a href="{{ url('/') }}"            class="ec-nav__link {{ Request::is('/') ? 'active' : '' }}">হোম</a></li>
                <li><a href="#features"                 class="ec-nav__link">ফিচার</a></li>
                <li><a href="#about"                    class="ec-nav__link">আমাদের সম্পর্কে</a></li>
                <li><a href="#client"                   class="ec-nav__link">ক্লায়েন্ট</a></li>
                <li><a href="{{ route('main.blogs') }}" class="ec-nav__link {{ request()->routeIs('main.blogs') ? 'active' : '' }}">ব্লগ</a></li>
                <li><a href="#contact"                  class="ec-nav__link">যোগাযোগ</a></li>
                <li>
                    @auth
                        <a href="{{ route('common.dashboard') }}" class="ec-nav__cta">ড্যাশবোর্ড</a>
                    @else
                        <a href="{{ route('login.form') }}" class="ec-nav__cta">লগইন</a>
                    @endauth
                </li>
                @guest
                <li>
                    <a href="{{ route('school.register.form') }}" class="ec-nav__cta ec-nav__cta--alt">রেজিস্ট্রেশন</a>
                </li>
                @endguest
            </ul>
        </nav>

        {{-- Mobile toggle: ieducore bi-list icon --}}
        <i class="bi bi-list ec-hamburger" id="ec-hamburger"></i>
    </div>
</header>

{{-- Mobile overlay --}}
<div id="ec-overlay" class="ec-overlay"></div>

{{-- Mobile slide-in menu --}}
    <div class="ec-drawer__head">
        <a href="{{ url('/') }}" class="ec-drawer__brand">
            @if(isset($setting) && isset($setting->logo_wide) && $setting->logo_wide)
                <img src="{{ asset($setting->logo_wide) }}" alt="{{ $setting->site_name ?? 'EduCorexa' }}" class="ec-logo-img">
            @elseif(isset($setting) && isset($setting->logo_square) && $setting->logo_square)
                <img src="{{ asset($setting->logo_square) }}" alt="{{ $setting->site_name ?? 'EduCorexa' }}" class="ec-logo-img-square">
                <span class="ec-drawer__logo">{{ $setting->site_name ?? 'edu' }}<span>corexa</span></span>
            @else
                <span class="ec-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </span>
                <span class="ec-drawer__logo">edu<span>corexa</span></span>
            @endif
        </a>
        <button id="ec-drawer-close" class="ec-drawer__close" aria-label="Close menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <nav class="ec-drawer__nav">
        <a href="{{ url('/') }}"            class="ec-drawer__link">হোম</a>
        <a href="#features"                 class="ec-drawer__link">ফিচার</a>
        <a href="#about"                    class="ec-drawer__link">আমাদের সম্পর্কে</a>
        <a href="#client"                   class="ec-drawer__link">ক্লায়েন্ট</a>
        <a href="{{ route('main.blogs') }}" class="ec-drawer__link">ব্লগ</a>
        <a href="#contact"                  class="ec-drawer__link">যোগাযোগ</a>
    </nav>
    <div class="ec-drawer__foot">
        @auth
            <a href="{{ route('common.dashboard') }}" class="ec-drawer__btn ec-drawer__btn--primary">ড্যাশবোর্ড</a>
        @else
            <a href="{{ route('login.form') }}"           class="ec-drawer__btn ec-drawer__btn--outline">লগইন</a>
            <a href="{{ route('school.register.form') }}" class="ec-drawer__btn ec-drawer__btn--primary">রেজিস্ট্রেশন</a>
        @endauth
    </div>
</div>

<style>
/* ============================================================
   EDUCOREXA NAVBAR  —  ieducore.net style
   transparent on hero  →  white + shadow on scroll
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

/* ---------- Header shell ---------- */
.ec-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 999;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    /* start transparent */
    background: transparent;
    border-bottom: 1px solid transparent;
    box-shadow: none;
    transition:
        background 0.35s ease,
        border-color 0.35s ease,
        box-shadow 0.35s ease;
}

/* Scrolled → solid white */
.ec-header.is-scrolled {
    background: rgba(255, 255, 255, 0.97);
    border-bottom-color: rgba(0, 97, 168, 0.12);
    box-shadow: 0 4px 28px rgba(0, 97, 168, 0.10);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

.ec-header__inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 36px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

/* ---------- Logo ---------- */
.ec-header__logo {
    display: flex;
    align-items: center;
    gap: 9px;
    text-decoration: none;
    flex-shrink: 0;
}
.ec-logo-img {
    height: 36px; width: auto;
}
.ec-logo-icon {
    display: flex; align-items: center; justify-content: center;
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.18);
    border: 1.5px solid rgba(255,255,255,0.55);
    border-radius: 10px;
    padding: 8px;
    transition: background 0.35s, border-color 0.35s, box-shadow 0.35s;
    flex-shrink: 0;
}
.ec-logo-icon svg { stroke: #fff; transition: stroke 0.35s; }

/* scrolled logo icon → blue gradient */
.ec-header.is-scrolled .ec-logo-icon {
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(0,97,168,0.32);
}

.ec-logo-text {
    font-size: 20px;
    font-weight: 900;
    font-style: italic;
    letter-spacing: -0.5px;
    line-height: 1;
    color: #fff;                /* white on transparent */
    transition: color 0.35s;
}
.ec-logo-text span { color: rgba(255,255,255,0.72); transition: color 0.35s; }

/* scrolled logo text → dark */
.ec-header.is-scrolled .ec-logo-text { color: #1e293b; }
.ec-header.is-scrolled .ec-logo-text span { color: #0061A8; }

/* ---------- Desktop nav ---------- */
.ec-nav { display: flex; align-items: center; flex: 1; justify-content: flex-end; }

.ec-nav__list {
    list-style: none;
    margin: 0; padding: 0;
    display: flex;
    align-items: center;
    gap: 2px;
}

/* nav links — white on transparent */
.ec-nav__link {
    display: inline-flex; align-items: center;
    padding: 7px 13px;
    font-size: 14.5px; font-weight: 600;
    color: rgba(255,255,255,0.9);       /* white */
    text-decoration: none;
    border-radius: 6px;
    position: relative;
    white-space: nowrap;
    transition: color 0.25s, background 0.25s;
}
.ec-nav__link::after {
    content: '';
    position: absolute;
    bottom: 3px; left: 13px; right: 13px;
    height: 2px;
    background: #fff;
    border-radius: 4px;
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.28s ease, background 0.28s;
}
.ec-nav__link:hover,
.ec-nav__link.active {
    color: #fff;
    background: rgba(255,255,255,0.13);
    text-decoration: none;
}
.ec-nav__link:hover::after,
.ec-nav__link.active::after { transform: scaleX(1); }

/* scrolled → dark links */
.ec-header.is-scrolled .ec-nav__link { color: #475569; background: transparent; }
.ec-header.is-scrolled .ec-nav__link::after { background: #0061A8; }
.ec-header.is-scrolled .ec-nav__link:hover,
.ec-header.is-scrolled .ec-nav__link.active { color: #0061A8; background: rgba(0,97,168,0.06); }

/* CTA buttons */
.ec-nav__cta {
    display: inline-flex; align-items: center; gap: 6px;
    margin-left: 8px;
    padding: 9px 22px;
    font-size: 14px; font-weight: 700;
    border-radius: 5px;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.28s ease;
    /* transparent state */
    background: rgba(255,255,255,0.14);
    color: #fff !important;
    border: 1.5px solid rgba(255,255,255,0.65);
}
.ec-nav__cta:hover {
    background: #fff;
    color: #0061A8 !important;
    border-color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    text-decoration: none;
}
/* scrolled cta → blue */
.ec-header.is-scrolled .ec-nav__cta {
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-color: transparent;
    box-shadow: 0 4px 16px rgba(0,97,168,0.28);
}
.ec-header.is-scrolled .ec-nav__cta:hover {
    background: linear-gradient(135deg, #004c84, #0061A8);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,97,168,0.38);
}
/* alternate (register) cta */
.ec-nav__cta--alt {
    background: #fff;
    color: #0061A8 !important;
    border-color: #fff;
}
.ec-nav__cta--alt:hover {
    background: #0061A8;
    color: #fff !important;
    border-color: #0061A8;
}
.ec-header.is-scrolled .ec-nav__cta--alt {
    background: transparent;
    color: #0061A8 !important;
    border-color: #0061A8;
    box-shadow: none;
}
.ec-header.is-scrolled .ec-nav__cta--alt:hover {
    background: #0061A8;
    color: #fff !important;
}

/* ---------- Hamburger — ieducore bi-list ---------- */
.ec-hamburger {
    display: none;           /* hidden on desktop */
    font-size: 30px;
    color: #fff;             /* white on transparent */
    cursor: pointer;
    line-height: 1;
    padding: 2px 4px;
    flex-shrink: 0;
    transition: color 0.3s, opacity 0.2s;
    user-select: none;
}
.ec-hamburger:hover { opacity: 0.8; }

/* scrolled → blue hamburger */
.ec-header.is-scrolled .ec-hamburger { color: #0061A8; }

/* ============================================================
   MOBILE DRAWER
   ============================================================ */
.ec-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.46);
    z-index: 1099;
    opacity: 0;
    pointer-events: none;   /* NOT display:none so JS can toggle easily */
    transition: opacity 0.32s ease;
}
.ec-overlay.is-open {
    opacity: 1;
    pointer-events: auto;
}

.ec-drawer {
    position: fixed;
    top: 0; right: 0;
    width: 290px;
    max-width: 86vw;
    height: 100dvh;
    background: #fff;
    z-index: 1100;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.38s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
    font-family: 'Poppins', sans-serif;
    box-shadow: -8px 0 40px rgba(0, 0, 0, 0.16);
}
.ec-drawer.is-open { transform: translateX(0); }

/* drawer head */
.ec-drawer__head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
    gap: 12px;
}
.ec-drawer__brand {
    display: flex;
    align-items: center;
    gap: 9px;
    text-decoration: none !important;
    max-width: calc(100% - 46px);
}
.ec-drawer__brand .ec-logo-img {
    height: 36px;
    max-width: 170px;
    object-fit: contain;
}
.ec-drawer__brand .ec-logo-img-square {
    height: 36px;
    width: 36px;
    border-radius: 8px;
    object-fit: cover;
}
.ec-drawer__brand .ec-logo-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #0061A8, #0080d4) !important;
    border-color: transparent !important;
    box-shadow: 0 4px 12px rgba(0, 97, 168, 0.25);
    padding: 7px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ec-drawer__brand .ec-logo-icon svg {
    stroke: #fff !important;
    width: 100%;
    height: 100%;
}
.ec-drawer__logo {
    font-size: 19px; font-weight: 900; font-style: italic;
    letter-spacing: -0.4px; color: #1e293b;
    line-height: 1;
}
.ec-drawer__logo span { color: #0061A8; }
.ec-drawer__close {
    display: flex; align-items: center; justify-content: center;
    width: 34px; height: 34px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 15px; color: #475569;
    cursor: pointer; transition: all 0.2s;
}
.ec-drawer__close:hover { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }

/* drawer nav links */
.ec-drawer__nav {
    flex: 1;
    display: flex; flex-direction: column;
    padding: 8px 0;
    overflow-y: auto;
}
.ec-drawer__link {
    display: flex; align-items: center;
    padding: 13px 22px;
    font-size: 15px; font-weight: 600;
    color: #374151;
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all 0.2s;
}
.ec-drawer__link:hover {
    background: rgba(0, 97, 168, 0.055);
    color: #0061A8;
    border-left-color: #0061A8;
    text-decoration: none;
}

/* drawer footer buttons */
.ec-drawer__foot {
    display: flex; flex-direction: column; gap: 10px;
    padding: 14px 20px 28px;
    border-top: 1px solid #f1f5f9;
    flex-shrink: 0;
}
.ec-drawer__btn {
    display: block; text-align: center;
    padding: 13px 20px; border-radius: 50px;
    font-size: 14.5px; font-weight: 700;
    text-decoration: none; transition: all 0.25s;
    font-family: 'Poppins', sans-serif;
}
.ec-drawer__btn--outline {
    border: 1.5px solid #e2e8f0; color: #475569;
}
.ec-drawer__btn--outline:hover { border-color: #0061A8; color: #0061A8; text-decoration: none; }
.ec-drawer__btn--primary {
    background: linear-gradient(135deg, #0061A8, #0080d4);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(0,97,168,0.3);
}
.ec-drawer__btn--primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,97,168,0.42);
    color: #fff !important; text-decoration: none;
}

/* ============================================================
   RESPONSIVE BREAKPOINTS
   ============================================================ */
@media (max-width: 991px) {
    .ec-nav       { display: none; }   /* hide desktop nav */
    .ec-hamburger { display: block; }  /* show hamburger */
}

@media (max-width: 575px) {
    .ec-header__inner { padding: 0 16px; height: 62px; }
    .ec-logo-text     { font-size: 17px; }
    .ec-logo-icon     { width: 32px; height: 32px; }
    .ec-hamburger     { font-size: 28px; }
}

/* ============================================================
   HERO OFFSET  (fixed header → hero needs top padding)
   ============================================================ */
#hero-section {
    padding-top: 140px !important;   /* 70px header + 70px breathing */
}
@media (max-width: 991px) {
    #hero-section { padding-top: 90px !important; }
}
@media (max-width: 575px) {
    #hero-section { padding-top: 80px !important; }
}
</style>

<script>
(function () {
    var header  = document.getElementById('ec-header');
    var burger  = document.getElementById('ec-hamburger');
    var overlay = document.getElementById('ec-overlay');
    var drawer  = document.getElementById('ec-drawer');
    var closeBtn= document.getElementById('ec-drawer-close');

    /* ── Scroll: add/remove is-scrolled class ── */
    function handleScroll() {
        if (!header) return;
        header.classList.toggle('is-scrolled', window.scrollY > 50);
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // run once on page load

    /* ── Open / close drawer ── */
    function openDrawer() {
        if (!drawer || !overlay) return;
        drawer.classList.add('is-open');
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        if (burger) burger.classList.replace('bi-list', 'bi-x-lg');
    }
    function closeDrawer() {
        if (!drawer || !overlay) return;
        drawer.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
        if (burger) burger.classList.replace('bi-x-lg', 'bi-list');
    }

    if (burger)   burger.addEventListener('click', function() {
        drawer && drawer.classList.contains('is-open') ? closeDrawer() : openDrawer();
    });
    if (overlay)  overlay.addEventListener('click', closeDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

    /* Close on any drawer nav link click */
    if (drawer) {
        drawer.querySelectorAll('a').forEach(function(a) {
            a.addEventListener('click', closeDrawer);
        });
    }
})();
</script>