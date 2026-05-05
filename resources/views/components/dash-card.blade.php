{{-- resources/views/components/dash-card.blade.php --}}
<div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card border-0 shadow-sm h-100 dash-stats-card overflow-hidden" style="border-radius: 16px; transition: transform 0.3s ease;">
        <div class="card-body p-4 position-relative">
            <!-- Decorative background icon -->
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fa-solid {{ $icon }} display-4 text-{{ $color }}"></i>
            </div>
            
            <div class="d-flex align-items-center mb-3">
                <div class="stats-icon-box rounded-3 d-flex align-items-center justify-content-center" 
                     style="width: 48px; height: 48px; background-color: rgba(var(--bs-{{ $color }}-rgb), 0.15);">
                    <i class="fa-solid {{ $icon }} fs-4 text-{{ $color }}"></i>
                </div>
            </div>
            
            <div>
                <p class="text-secondary fw-medium mb-1 small text-uppercase tracking-wider" style="letter-spacing: 0.5px; font-size: 0.7rem;">{{ $title }}</p>
                <h3 class="mb-0 fw-bolder text-dark d-flex align-items-baseline">
                    @if(isset($currency))
                        <span class="fs-6 fw-normal text-muted me-1">{{ $currency }}</span>
                    @endif
                    {{ is_numeric($value) ? number_format($value) : $value }}
                </h3>
            </div>
        </div>
    </div>
</div>

<style>
    .dash-stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>