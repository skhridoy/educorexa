{{-- Newsletter Section --}}
<section id="newsletter" class="ec-newsletter">
    <div class="container ec-newsletter__container">
        <div class="ec-newsletter__inner">

            {{-- Decorative orbs --}}
            <div class="ec-newsletter__orb ec-newsletter__orb--1"></div>
            <div class="ec-newsletter__orb ec-newsletter__orb--2"></div>

            <div class="ec-newsletter__content">
                <div class="ec-newsletter__icon">
                    <i class="bi bi-envelope-paper-heart-fill"></i>
                </div>
                <h2 class="ec-newsletter__title">সর্বশেষ আপডেট পেতে সাবস্ক্রাইব করুন</h2>
                <p class="ec-newsletter__desc">নতুন ফিচার, শিক্ষা প্রযুক্তির খবর এবং বিশেষ অফার সবার আগে পান আপনার ইমেইলে।</p>

                <form class="ec-newsletter__form" method="POST" action="{{ route('main.newsletter.subscribe') }}" id="ecNewsletterForm">
                    @csrf
                    <div class="ec-newsletter__input-group">
                        <i class="bi bi-envelope ec-newsletter__input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            id="newsletterEmail"
                            class="ec-newsletter__input"
                            placeholder="আপনার ইমেইল অ্যাড্রেস লিখুন..."
                            required>
                        <button type="submit" class="ec-newsletter__btn">
                            <span class="ec-newsletter__btn-text">সাবস্ক্রাইব</span>
                            <i class="bi bi-arrow-right-short ec-newsletter__btn-icon"></i>
                        </button>
                    </div>
                    @if(session('nl_success'))
                        <p class="ec-newsletter__msg" style="display:flex;">✓ &nbsp;{{ session('nl_success') }}</p>
                    @elseif(session('nl_error'))
                        <p class="ec-newsletter__msg" style="display:flex; color:rgba(255,200,100,.9);">✕ &nbsp;{{ session('nl_error') }}</p>
                    @endif
                    <p id="newsletterMsg" class="ec-newsletter__msg" style="display:none;"></p>
                </form>

                <div class="ec-newsletter__privacy">
                    <i class="bi bi-shield-lock-fill"></i>
                    আমরা কখনো স্প্যাম করি না। যেকোনো সময় আনসাবস্ক্রাইব করতে পারবেন।
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== EC NEWSLETTER ===== */
.ec-newsletter {
    padding: 64px 0 60px;
    background: #f8faff;
}
.ec-newsletter__container { max-width: 840px; margin: 0 auto; padding: 0 20px; }
.ec-newsletter__inner {
    background: linear-gradient(135deg, #4648d4 0%, #6366f1 50%, #8b5cf6 100%);
    border-radius: 32px;
    padding: 56px 48px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(70,72,212,.3);
}

/* Orbs */
.ec-newsletter__orb {
    position: absolute; border-radius: 50%; pointer-events: none;
}
.ec-newsletter__orb--1 {
    width: 220px; height: 220px;
    background: rgba(255,255,255,.08);
    top: -60px; right: -60px;
}
.ec-newsletter__orb--2 {
    width: 160px; height: 160px;
    background: rgba(255,255,255,.05);
    bottom: -50px; left: -40px;
}

.ec-newsletter__content { position: relative; z-index: 1; }

/* Icon */
.ec-newsletter__icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,.18);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px; color: #fff;
    backdrop-filter: blur(8px);
}

.ec-newsletter__title {
    font-size: clamp(1.5rem, 3vw, 2.1rem);
    font-weight: 900; color: #fff; margin-bottom: 10px; line-height: 1.25;
}
.ec-newsletter__desc {
    color: rgba(255,255,255,.82); font-size: 15px; margin-bottom: 32px; max-width: 480px; margin-left: auto; margin-right: auto;
}

/* Form */
.ec-newsletter__form { max-width: 520px; margin: 0 auto 18px; }
.ec-newsletter__input-group {
    position: relative; display: flex; align-items: center;
    background: #fff; border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,.18);
    overflow: hidden;
}
.ec-newsletter__input-icon {
    position: absolute; left: 16px;
    color: #94a3b8; font-size: 16px; pointer-events: none;
}
.ec-newsletter__input {
    flex: 1; border: none; outline: none;
    padding: 16px 16px 16px 44px;
    font-size: 14px; color: #0f172a;
    background: transparent;
}
.ec-newsletter__input::placeholder { color: #94a3b8; }
.ec-newsletter__btn {
    display: flex; align-items: center; gap: 4px;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: #fff; border: none; cursor: pointer;
    padding: 0 22px;
    font-size: 14px; font-weight: 800;
    height: 52px; white-space: nowrap;
    border-radius: 0 12px 12px 0;
    transition: all .25s ease;
}
.ec-newsletter__btn:hover { background: linear-gradient(135deg, #d97706, #ea580c); }
.ec-newsletter__btn-icon { font-size: 20px; }

.ec-newsletter__msg {
    color: rgba(255,255,255,.9); font-size: 13px; font-weight: 700; margin-top: 10px;
}

.ec-newsletter__privacy {
    font-size: 12px; color: rgba(255,255,255,.6);
    display: flex; align-items: center; justify-content: center; gap: 6px;
}

@media (max-width: 575px) {
    .ec-newsletter__inner { padding: 36px 20px; }
    .ec-newsletter__btn-text { display: none; }
    .ec-newsletter__btn { padding: 0 16px; }
}
</style>


