{{-- resources/views/components/dash-card.blade.php --}}
<div class="col-md-3 col-6 mb-3">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                <div style="width: 50px; height: 50px; background-color: rgba(var(--bs-{{ $color }}-rgb), 0.1);" 
                     class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                    <i class="fa-solid {{ $icon }} fs-4 text-{{ $color }}"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">{{ $title }}</p>
                    <h4 class="mb-0 fw-bold">
                        {{ $currency ?? '' }} {{ is_numeric($value) ? number_format($value) : $value }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>