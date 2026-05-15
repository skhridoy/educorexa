@extends('layouts.school.main')

@section('content')
<div class="page-content">
    <div class="text-center mb-5">
        <h2 class="edu-page-title d-block mb-2">Elevate Your School Management</h2>
        <p class="edu-page-sub">Choose a plan that fits your growth. Scale features as you grow.</p>
    </div>

    <div class="row g-4 justify-content-center">
        @foreach($packages as $package)
        <div class="col-lg-4 col-md-6">
            <div class="edu-panel h-100 {{ $currentSchool->subscription_package_id == $package->id ? 'border-primary shadow-lg' : '' }}" style="position: relative; transition: all 0.3s ease;">
                @if($package->is_popular)
                <span class="badge bg-indigo-600 text-white position-absolute px-3 py-2 rounded-pill shadow-sm" style="top: -15px; left: 50%; transform: translateX(-50%); font-size: 11px; letter-spacing: 1px; font-weight: 800; z-index: 2;">MOST POPULAR</span>
                @endif

                <div class="edu-panel-bd p-5 text-center">
                    <h5 class="fw-bold text-slate-800 mb-1">{{ $package->name }}</h5>
                    <p class="text-muted small mb-4">{{ $package->description }}</p>
                    
                    <div class="mb-4">
                        <span class="h1 fw-bold text-indigo-600">৳{{ number_format($package->price) }}</span>
                        <span class="text-muted">/{{ $package->duration == 'monthly' ? 'mo' : 'yr' }}</span>
                    </div>

                    <ul class="list-unstyled text-start mb-5" style="font-size: 14px;">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-green-500 me-2"></i>
                            <span>{{ $package->student_limit ?: 'Unlimited' }} Students</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-green-500 me-2"></i>
                            <span>{{ $package->teacher_limit ?: 'Unlimited' }} Teachers</span>
                        </li>
                        @if($package->features)
                            @foreach($package->features as $feature)
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fa-solid fa-circle-check text-green-500 me-2"></i>
                                <span>{{ $feature }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>

                    @if($currentSchool->subscription_package_id == $package->id)
                    <button class="btn btn-secondary w-100 py-3 rounded-4 fw-bold disabled" style="cursor: not-allowed;">Current Plan</button>
                    @else
                    <button class="btn btn-edu-primary w-100 py-3 rounded-4 fw-bold shadow-sm" onclick="showContactModal('{{ $package->name }}')">Upgrade Now</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-5 text-center">
        <p class="text-muted small">Need a custom plan for your institution? <a href="#" class="text-indigo-600 fw-bold">Contact our support team</a></p>
    </div>
</div>

<!-- Simple Contact Modal Placeholder -->
<div class="modal fade" id="upgradeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden">
            <div class="modal-body p-5 text-center">
                <div class="mb-4">
                    <div class="bg-indigo-50 text-indigo-600 d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-headset fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-slate-800">Ready to Upgrade?</h4>
                    <p class="text-muted">Our team will assist you with the manual upgrade process and billing details for the <span id="selectedPkgName" class="fw-bold text-indigo-600"></span> plan.</p>
                </div>
                <div class="d-grid gap-2">
                    <a href="https://wa.me/+8801700000000" class="btn btn-success py-3 rounded-4 fw-bold mb-2">
                        <i class="fa-brands fa-whatsapp me-2"></i> Chat on WhatsApp
                    </a>
                    <button type="button" class="btn btn-light py-3 rounded-4 fw-bold" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showContactModal(pkgName) {
        document.getElementById('selectedPkgName').innerText = pkgName;
        new bootstrap.Modal(document.getElementById('upgradeModal')).show();
    }
</script>
@endsection
