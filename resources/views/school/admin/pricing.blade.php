@extends('layouts.school')

@section('title', 'Subscription Plans')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold text-main">Choose Your Excellence Plan</h2>
                <p class="text-muted lead">Empower your institution with the right set of tools and features.</p>
                <div class="mt-3">
                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                        Current Plan: {{ $currentSchool->subscriptionPackage->name ?? 'Basic' }}
                    </span>
                    @if($pendingSubscription && $pendingSubscription->payment_reference)
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill ms-1">
                            <i data-feather="clock" class="icon-sm me-1" style="width:13px;height:13px;"></i> Payment Under Review ({{ $pendingSubscription->package->name ?? 'Package' }})
                        </span>
                    @elseif($activeSubscription)
                        @php
                            $daysLeft = $activeSubscription->daysRemaining();
                            $expDate = $activeSubscription->getExpiryDate();
                        @endphp
                        <span class="badge {{ $activeSubscription->isExpiringSoon(15) ? 'bg-warning text-dark' : 'bg-success' }} px-3 py-2 rounded-pill ms-1">
                            {{ $activeSubscription->status === 'trialing' ? '7-Day Free Trial' : 'Active' }}
                            @if($expDate)
                                · Expires {{ $expDate->format('d M Y') }}
                                @if($daysLeft !== null)
                                    ({{ $daysLeft == 0 ? 'Today' : ($daysLeft == 1 ? '1 day left' : $daysLeft . ' days left') }})
                                @endif
                            @endif
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill ms-1">Payment Required / Expired</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach($packages as $package)
            @php
                $isCurrent = ($package->id == $currentSchool->subscription_package_id);
                $isPendingThis = ($pendingSubscription && $pendingSubscription->subscription_package_id == $package->id && $pendingSubscription->payment_reference);
                $canRenewCurrent = ($activeSubscription && $activeSubscription->canRenew(15)) || !$activeSubscription;
            @endphp
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm pricing-card {{ $isCurrent ? 'current-card' : '' }} {{ $package->is_popular ? 'popular' : '' }}">
                    @if($isCurrent)
                        <div class="current-plan-tag">Current Plan</div>
                    @elseif($package->is_popular)
                        <div class="popular-tag">Most Popular</div>
                    @endif
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-4">
                            <h4 class="fw-bold mb-1">{{ $package->name }}</h4>
                            <p class="text-muted small">{{ $package->description }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <span class="h1 fw-bold">৳{{ number_format($package->price) }}</span>
                            <span class="text-muted">/{{ $package->duration }}</span>
                        </div>

                        <ul class="list-unstyled mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center">
                                <i data-feather="check-circle" class="text-success me-2 icon-sm"></i>
                                <span>{{ $package->student_limit ?? 'Unlimited' }} Students</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i data-feather="check-circle" class="text-success me-2 icon-sm"></i>
                                <span>{{ $package->teacher_limit ?? 'Unlimited' }} Teachers</span>
                            </li>
                            @if($package->features)
                                @foreach($package->features as $feature)
                                <li class="mb-3 d-flex align-items-center">
                                    <i data-feather="check-circle" class="text-success me-2 icon-sm"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            @endif
                        </ul>

                        <div class="d-grid">
                            @if($isPendingThis)
                                <button type="button" class="btn btn-warning w-100 fw-bold" disabled style="opacity: 0.9; cursor: not-allowed;">
                                    <i data-feather="clock" class="me-1 icon-sm"></i> Verification Pending
                                </button>
                            @elseif($isCurrent)
                                @if($activeSubscription && $activeSubscription->status === 'active' && !$activeSubscription->isExpiringSoon(15))
                                    {{-- Paid and Active with > 15 days left: Pay Now is DISABLED --}}
                                    <button type="button" class="btn btn-secondary w-100 fw-bold" disabled style="opacity: 0.75; cursor: not-allowed;">
                                        <i data-feather="check-circle" class="me-1 icon-sm"></i> Current Active Plan
                                    </button>
                                @else
                                    {{-- Within 15-day renewal window OR expired / trial: ENABLED to Renew / Pay --}}
                                    <form action="{{ route('school.upgrade.request', ['tenant' => $currentSchool->slug]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                        <button type="submit" class="btn {{ $activeSubscription ? 'btn-primary' : 'btn-danger' }} ripple-effect w-100 fw-bold">
                                            @if($activeSubscription && $activeSubscription->isExpiringSoon(15))
                                                <i data-feather="rotate-cw" class="me-1 icon-sm"></i> Renew Plan
                                            @else
                                                <i data-feather="credit-card" class="me-1 icon-sm"></i> Pay Now
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            @else
                                {{-- Other package: Upgrade / Switch option --}}
                                <form action="{{ route('school.upgrade.request', ['tenant' => $currentSchool->slug]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <button type="submit" class="btn {{ $package->is_popular ? 'btn-primary' : 'btn-outline-primary' }} ripple-effect w-100 fw-bold">
                                        <i data-feather="arrow-up" class="me-1 icon-sm"></i> Upgrade Now
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .pricing-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(101, 113, 255, 0.15) !important;
    }
    .pricing-card.popular {
        border: 2px solid var(--table-header) !important;
    }
    .pricing-card.current-card {
        border: 2px solid #22c55e !important;
    }
    .popular-tag {
        position: absolute;
        top: 20px;
        right: -35px;
        background: var(--table-header);
        color: white;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-size: 0.7rem;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .current-plan-tag {
        position: absolute;
        top: 20px;
        right: -35px;
        background: #16a34a;
        color: white;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-size: 0.7rem;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .bg-soft-primary {
        background-color: rgba(101, 113, 255, 0.1);
    }
    .icon-sm {
        width: 18px;
        height: 18px;
    }
</style>
@endsection
