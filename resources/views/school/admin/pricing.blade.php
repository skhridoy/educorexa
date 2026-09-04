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
                    @if($activeSubscription)
                        <span class="badge bg-success px-3 py-2 rounded-pill ms-1">
                            {{ $activeSubscription->status === 'trialing' ? '7-Day Free Trial' : 'Active' }}
                            @if($activeSubscription->status === 'trialing')
                                · {{ $activeSubscription->trial_ends_at->format('d M Y') }}
                            @elseif($activeSubscription->ends_at)
                                · {{ $activeSubscription->ends_at->format('d M Y') }}
                            @endif
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill ms-1">Payment Required</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach($packages as $package)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm pricing-card {{ $package->is_popular ? 'popular' : '' }}">
                    @if($package->is_popular)
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
                                <span>{{ $package->student_limit }} Students</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i data-feather="check-circle" class="text-success me-2 icon-sm"></i>
                                <span>{{ $package->teacher_limit }} Teachers</span>
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
                            <form action="{{ route('school.upgrade.request', ['tenant' => $currentSchool->slug]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                <button type="submit" class="btn {{ $package->id == $currentSchool->subscription_package_id ? 'btn-primary' : ($package->is_popular ? 'btn-primary' : 'btn-outline-primary') }} ripple-effect w-100">
                                    @if($package->id == $currentSchool->subscription_package_id)
                                        <i data-feather="credit-card" class="me-1 icon-sm"></i> Pay Now
                                    @else
                                        <i data-feather="arrow-up" class="me-1 icon-sm"></i> Upgrade Now
                                    @endif
                                </button>
                            </form>
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
    .bg-soft-primary {
        background-color: rgba(101, 113, 255, 0.1);
    }
    .icon-sm {
        width: 18px;
        height: 18px;
    }
</style>
@endsection
