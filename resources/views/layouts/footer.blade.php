<footer class="footer border-top py-4 px-4 mt-auto" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start gap-2">
                    <span class="text-muted text-center text-md-start" style="font-size: 0.85rem;">
                        Copyright © 2025 {{ date('Y') > 2025 ? '- ' . date('Y') : '' }} 
                        <a href="{{ $main_domain ?? url('/') }}" target="_blank" class="fw-bold text-primary text-decoration-none">
                            {{ config('app.name', 'EduCorexa') }}
                        </a>
                    </span>
                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.7rem;">v{{ config('app.version', '2.0.0') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-end gap-3">
                    <p class="text-muted mb-0 small text-center text-md-end" style="font-family: 'Inter', sans-serif;">
                        Hand-crafted with 
                        <i class="fa-solid fa-heart text-danger mx-1" style="font-size: 0.75rem; animation: pulse 1.5s infinite;"></i> 
                        by Elite Solutions
                    </p>
                    <div class="footer-divider d-none d-md-block" style="width: 1px; height: 16px; background: #e2e8f0;"></div>
                    <div class="d-flex gap-2 mt-2 mt-md-0">
                        <a href="#" class="btn btn-sm btn-light border-0" style="width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            <i class="fa-brands fa-facebook-f" style="font-size: 0.8rem;"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light border-0" style="width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            <i class="fa-brands fa-twitter" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>