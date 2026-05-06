<footer class="footer main-footer border-top py-4 px-4 mt-auto">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start gap-2">
                    <span class="text-muted-custom text-center text-md-start" style="font-size: 0.85rem;">
                        Copyright © 2025 {{ date('Y') > 2025 ? '- ' . date('Y') : '' }} 
                        <a href="{{ $main_domain ?? url('/') }}" target="_blank" class="fw-bold text-primary text-decoration-none">
                            {{ config('app.name', 'EduCorexa') }}
                        </a>
                    </span>
                    <span class="badge badge-version border px-2 py-1" style="font-size: 0.7rem;">v{{ config('app.version', '2.0.0') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-end gap-3">
                    <p class="text-muted-custom mb-0 small text-center text-md-end" style="font-family: 'Inter', sans-serif;">
                        Hand-crafted with 
                        <i class="fa-solid fa-heart text-danger mx-1 heart-pulse" style="font-size: 0.75rem;"></i> 
                        by Kajol Ray
                    </p>
                    <div class="footer-divider d-none d-md-block"></div>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <a href="#" class="btn-social">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn-social">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* ১. ফুটার ভ্যারিয়েবল */
:root {
    --footer-bg: rgba(255, 255, 255, 0.8);
    --footer-border: #e2e8f0;
    --footer-text: #64748b;
    --version-badge-bg: #f8fafc;
    --social-btn-bg: #f1f5f9;
}

body.dark-mode {
    --footer-bg: rgba(12, 20, 39, 0.9);
    --footer-border: #1a253b;
    --footer-text: #ced4da;
    --version-badge-bg: #111b2d;
    --social-btn-bg: #111b2d;
}

/* ২. ফুটার স্টাইল */
.main-footer {
    background: var(--footer-bg) !important;
    backdrop-filter: blur(10px);
    border-color: var(--footer-border) !important;
}

.text-muted-custom {
    color: var(--footer-text) !important;
}

.badge-version {
    background: var(--version-badge-bg) !important;
    color: var(--footer-text) !important;
    border-color: var(--footer-border) !important;
}

.footer-divider {
    width: 1px;
    height: 16px;
    background: var(--footer-border);
}

/* ৩. সোশ্যাল বাটন */
.btn-social {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--social-btn-bg);
    color: var(--footer-text);
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-social:hover {
    background: #6571ff;
    color: #fff;
    transform: translateY(-2px);
}

/* ৪. এনিমেশন */
.heart-pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>