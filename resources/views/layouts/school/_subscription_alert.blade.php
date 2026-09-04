@php
    $alertUser = auth()->user();
    $alertSchool = app('currentSchool') ?? $alertUser?->school;
    $tenant = $alertSchool?->slug ?? request()->route('tenant') ?? '';
    $isSchoolStaffOrAdmin = $alertUser && in_array($alertUser->role, ['school_admin', 'school_staff', 'admin'], true);
@endphp

@if($alertSchool && $isSchoolStaffOrAdmin)
    @php
        $activeSub = $alertSchool->activeSubscription();
        $pendingSub = $alertSchool->pendingSubscription();
        $currentPkg = $alertSchool->subscriptionPackage;
        $expiryDate = $activeSub?->getExpiryDate();
        $daysLeft = $activeSub?->daysRemaining();
    @endphp

    {{-- 1. Pending Payment Verification Alert --}}
    @if($pendingSub && $pendingSub->payment_reference)
        <div class="container-fluid pt-3 px-4 pb-0">
            <div class="alert alert-warning border-0 shadow-sm d-flex flex-wrap align-items-center justify-content-between p-3 rounded-4 mb-0"
                 style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 5px solid #f59e0b !important; color: #92400e;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.2); color: #d97706; flex-shrink: 0;">
                        <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 0.95rem;">
                            {{ __('প্যাকেজ পেমেন্ট ভেরিফিকেশন অপেক্ষমান') }} ({{ $pendingSub->package->name ?? 'Package' }})
                        </div>
                        <div style="font-size: 0.83rem; color: #78350f;">
                            {{ __('আপনার জমাকৃত পেমেন্ট রেফারেন্স / TrxID') }}: <strong>{{ $pendingSub->payment_reference }}</strong> (৳{{ number_format($pendingSub->amount, 2) }})। {{ __('সুপার অ্যাডমিন অতি শীঘ্রই এটি যাচাই করে প্যাকেজ সচল করবেন।') }}
                        </div>
                    </div>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" class="btn btn-sm btn-warning rounded-pill px-3 py-1.5 fw-bold shadow-sm" style="color: #78350f;">
                        <i class="fa-solid fa-eye me-1"></i> {{ __('বিস্তারিত দেখুন') }}
                    </a>
                </div>
            </div>
        </div>

    {{-- 2. Renewal Notice (15 days before expiration) --}}
    @elseif($activeSub && $activeSub->isExpiringSoon(15))
        <div class="container-fluid pt-3 px-4 pb-0">
            <div class="alert alert-warning border-0 shadow-sm d-flex flex-wrap align-items-center justify-content-between p-3 rounded-4 mb-0"
                 style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 5px solid #f59e0b !important; color: #92400e;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.25); color: #d97706; flex-shrink: 0;">
                        <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                    </div>
                    <div>
                        <div class="fw-bold d-flex align-items-center gap-2" style="font-size: 0.95rem;">
                            <span>{{ __('প্যাকেজ রিনিউ নোটিশ') }}</span>
                            <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">
                                {{ $daysLeft == 0 ? __('আজ মেয়াদ শেষ') : ($daysLeft == 1 ? __('আর ১ দিন বাকি') : __('আর ' . $daysLeft . ' দিন বাকি')) }}
                            </span>
                        </div>
                        <div style="font-size: 0.83rem; color: #78350f;">
                            {{ __('আপনার বর্তমান') }} <strong>{{ $currentPkg->name ?? 'Current' }}</strong> {{ __('প্যাকেজের মেয়াদ') }} <strong>{{ $expiryDate ? $expiryDate->format('d M, Y') : '' }}</strong> {{ __('তারিখে শেষ হবে। নিরবচ্ছিন্ন সার্ভিস বজায় রাখতে এখনই রিনিউ সম্পন্ন করুন।') }}
                        </div>
                    </div>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-bold shadow-sm" style="background: #4f46e5; border-color: #4f46e5;">
                        <i class="fa-solid fa-arrows-rotate me-1.5"></i> {{ __('প্যাকেজ রিনিউ করুন') }}
                    </a>
                </div>
            </div>
        </div>

    {{-- 3. Expired / Inactive Subscription Alert --}}
    @elseif(!$activeSub)
        <div class="container-fluid pt-3 px-4 pb-0">
            <div class="alert alert-danger border-0 shadow-sm d-flex flex-wrap align-items-center justify-content-between p-3 rounded-4 mb-0"
                 style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left: 5px solid #ef4444 !important; color: #991b1b;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 42px; height: 42px; background: rgba(239, 68, 68, 0.2); color: #dc2626; flex-shrink: 0;">
                        <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 0.95rem;">
                            {{ __('প্যাকেজের মেয়াদ শেষ / পেমেন্ট প্রয়োজন') }}
                        </div>
                        <div style="font-size: 0.83rem; color: #7f1d1d;">
                            {{ __('আপনার প্রতিষ্ঠানের সাবস্ক্রিপশন মেয়াদ উত্তীর্ণ হয়েছে। সফটওয়্যারের সকল ফিচার ব্যবহারের জন্য এখনই প্যাকেজ রিনিউ বা পে নাউ সম্পন্ন করুন।') }}
                        </div>
                    </div>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" class="btn btn-sm btn-danger rounded-pill px-3.5 py-1.5 fw-bold shadow-sm" style="background: #dc2626; border-color: #dc2626;">
                        <i class="fa-solid fa-credit-card me-1.5"></i> {{ __('পে নাউ / রিনিউ করুন') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
@endif
