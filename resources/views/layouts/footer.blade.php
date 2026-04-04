<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">
        Copyright © 2025 {{ date('Y') > 2025 ? '- ' . date('Y') : '' }} 
        <a href="{{ $main_domain ?? url('/') }}" target="_blank" class="fw-bold">
            {{ config('app.name', 'EduCorexa') }}
        </a>. All rights reserved.
    </p>
    <p class="text-muted">
        <span>Hand-crafted With</span> 
        <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i> 
        <span class="ms-1">v{{ config('app.version', '2.0.0') }}</span>
    </p>
</footer>