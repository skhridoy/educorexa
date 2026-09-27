@extends('layouts.school')

@section('title', 'Subscription Payment')

@section('content')
@php
    $isFree = $package->isFreePackage();
    $monthlyPrice = (float) $package->price;
    $serviceFee = (float) ($package->service_fee ?? 0.0);
    $selectedPeriod = old('billing_period', $subscription->billing_period ?: ($isFree ? $package->free_validity_period : 'monthly'));
    $baseDateCarbon = $baseDate ? \Illuminate\Support\Carbon::parse($baseDate) : now();
    $baseIso = $baseDateCarbon->toIso8601String();

    // Billing period discount config
    $discounts = $package->billing_discounts ?? [];
    $periodDiscount = fn(string $p) => (float)($discounts[$p] ?? 0);
    $discountedPrice = fn(float $base, float $pct) => $pct > 0 ? round($base * (1 - $pct / 100), 2) : $base;
@endphp

<div class="page-content">
    <div class="container-fluid subscription-checkout" style="max-width:1100px;">
        <div class="checkout-heading mb-4">
            <div>
                <span class="checkout-kicker"><i class="fa-solid fa-shield-halved"></i> Secure subscription checkout</span>
                <h2 class="fw-bold mb-1">Complete your payment</h2>
                <p class="text-muted mb-0">Select your preferred billing period, send the exact amount, and submit your transaction ID for instant Super Admin verification.</p>
            </div>
            <a href="{{ route('school.pricing', ['tenant' => $school->slug]) }}" class="btn btn-light border"><i class="fa-solid fa-arrow-left me-1"></i> Back to plans</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="row g-4 align-items-start">
            {{-- Left Column: Summary & Payment Accounts --}}
            <div class="col-lg-5">
                <div class="checkout-summary card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="summary-label">ORDER SUMMARY</span>
                            <span class="badge bg-white text-primary rounded-pill px-2.5 py-1 font-monospace" id="summaryActionBadge" style="font-size:0.72rem;">
                                {{ $actionType }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <div>
                                <h4 class="mb-1 text-white fw-bold">{{ $package->name }}</h4>
                                <span class="text-white-50 small" id="summaryPeriodSubtitle">
                                    @if($isFree)
                                        One-Time Service Fee ({{ $package->getFreeValidityMonths() === 6 ? '6 Months' : '1 Year' }})
                                    @else
                                        {{ ucfirst($selectedPeriod) }} Plan · ৳{{ number_format($monthlyPrice) }}/month
                                    @endif
                                </span>
                            </div>
                            <span class="summary-check"><i class="fa-solid fa-check"></i></span>
                        </div>

                        {{-- Calculation Details --}}
                        <div class="summary-meta-box mt-3 p-3 rounded-3" style="background:rgba(255,255,255,0.1); font-size:0.83rem;">
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-white-50">Duration:</span>
                                <strong class="text-white" id="summaryDurationText">
                                    {{ $isFree ? ($package->getFreeValidityMonths() . ' Months') : '1 Month' }}
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-white-50">Start Date:</span>
                                <strong class="text-white" id="summaryStartDate">
                                    {{ $baseDateCarbon->format('d M Y') }}
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-white-50">Valid Until:</span>
                                <strong class="text-warning fw-bold" id="summaryExpiryDate">
                                    Calculating...
                                </strong>
                            </div>
                        </div>

                        <div class="summary-total mt-4">
                            <div>
                                <span class="d-block text-white-50" style="font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">Total to pay</span>
                                <small class="text-white-50" id="summaryRateNote">
                                    {{ $isFree ? 'One-Time Fee' : ('৳' . number_format($monthlyPrice) . ' × 1 mo') }}
                                </small>
                            </div>
                            <strong id="summaryTotalAmount">
                                ৳{{ number_format($subscription->amount, 2) }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="checkout-steps mb-4">
                    <div class="checkout-step"><span>1</span><div><strong>Select Period & Send Money</strong><small>Choose duration and pay via bKash/Nagad</small></div></div>
                    <div class="checkout-step"><span>2</span><div><strong>Enter Details</strong><small>Add sender number and Transaction ID (TrxID)</small></div></div>
                    <div class="checkout-step"><span>3</span><div><strong>Get Verified</strong><small>Super Admin will review and activate your plan</small></div></div>
                </div>

                <div class="payment-account-card card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div><div class="summary-label">PAYMENT ACCOUNT</div><h5 class="mb-0 mt-1">Send Money to</h5></div>
                            <i class="fa-solid fa-wallet account-icon"></i>
                        </div>
                        @foreach($paymentNumbers as $method => $number)
                            @if($number)
                                <div class="account-row">
                                    <div><span class="account-method">{{ $method }}</span><strong>{{ $number }}</strong></div>
                                    <button type="button" class="copy-number" data-number="{{ $number }}" title="Copy number"><i class="fa-regular fa-copy"></i></button>
                                </div>
                            @endif
                        @endforeach
                        @if(!$paymentNumbers['bKash'] && !$paymentNumbers['Nagad'])
                            <div class="alert alert-warning mt-3 mb-0">Payment numbers are not configured yet. Please contact the Super Admin.</div>
                        @endif
                        @if($paymentInstructions = optional(\App\Models\SiteSetting::first())->manual_payment_instructions)
                            <div class="account-instructions mt-3"><i class="fa-solid fa-circle-info me-1"></i> {{ $paymentInstructions }}</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Billing Period Selector & Payment Form --}}
            <div class="col-lg-7">
                <div class="payment-form-card card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <div class="form-title mb-4">
                            <span class="form-icon"><i class="fa-solid fa-receipt"></i></span>
                            <div>
                                <h4 class="mb-1">Payment Submission</h4>
                                <p class="text-muted mb-0 small">Choose your billing duration and submit your transaction info.</p>
                            </div>
                        </div>

                        <form action="{{ route('school.subscription-payment.store', ['tenant' => $school->slug]) }}" method="POST" id="checkoutPaymentForm">
                            @csrf
                            <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">

                            {{-- 1. Billing Period Selector (For Paid Packages) --}}
                            @if(!$isFree)
                                <div class="mb-4">
                                    <label class="form-label fw-bold d-flex justify-content-between align-items-center">
                                        <span>Select Billing Period <span class="text-danger">*</span></span>
                                        <span class="text-primary small fw-semibold" id="billingDiscountNote">Base: ৳{{ number_format($monthlyPrice) }}/month</span>
                                    </label>
                                    <div class="billing-period-grid">
                                        {{-- Monthly --}}
                                        @php $mDisc = $periodDiscount('monthly'); $mOrig = $monthlyPrice * 1; $mFinal = $discountedPrice($mOrig, $mDisc); @endphp
                                        <label class="period-card {{ $selectedPeriod === 'monthly' ? 'selected' : '' }}">
                                            <input type="radio" name="billing_period" value="monthly" class="d-none period-radio"
                                                data-months="1"
                                                data-total="{{ $mFinal }}"
                                                data-original="{{ $mOrig }}"
                                                data-discount="{{ $mDisc }}"
                                                data-label="Monthly"
                                                {{ $selectedPeriod === 'monthly' ? 'checked' : '' }}>
                                            <div class="period-card-inner">
                                                <div class="period-title">Monthly</div>
                                                <div class="period-duration">1 Month</div>
                                                <div class="period-price">৳{{ number_format($mFinal) }}</div>
                                            </div>
                                        </label>

                                        {{-- Quarterly --}}
                                        @php $qDisc = $periodDiscount('quarterly'); $qOrig = $monthlyPrice * 3; $qFinal = $discountedPrice($qOrig, $qDisc); @endphp
                                        <label class="period-card {{ $selectedPeriod === 'quarterly' ? 'selected' : '' }}">
                                            <input type="radio" name="billing_period" value="quarterly" class="d-none period-radio"
                                                data-months="3"
                                                data-total="{{ $qFinal }}"
                                                data-original="{{ $qOrig }}"
                                                data-discount="{{ $qDisc }}"
                                                data-label="Quarterly"
                                                {{ $selectedPeriod === 'quarterly' ? 'checked' : '' }}>
                                            <div class="period-card-inner">
                                                @if($qDisc > 0)<span class="period-save-badge">Save {{ $qDisc }}%</span>@endif
                                                <div class="period-title">Quarterly</div>
                                                <div class="period-duration">3 Months</div>
                                                @if($qDisc > 0)<div class="period-original-price">৳{{ number_format($qOrig) }}</div>@endif
                                                <div class="period-price">৳{{ number_format($qFinal) }}</div>
                                            </div>
                                        </label>

                                        {{-- Half-Yearly --}}
                                        @php $hDisc = $periodDiscount('half_yearly'); $hOrig = $monthlyPrice * 6; $hFinal = $discountedPrice($hOrig, $hDisc); @endphp
                                        <label class="period-card {{ $selectedPeriod === 'half_yearly' ? 'selected' : '' }}">
                                            <input type="radio" name="billing_period" value="half_yearly" class="d-none period-radio"
                                                data-months="6"
                                                data-total="{{ $hFinal }}"
                                                data-original="{{ $hOrig }}"
                                                data-discount="{{ $hDisc }}"
                                                data-label="Half-Yearly"
                                                {{ $selectedPeriod === 'half_yearly' ? 'checked' : '' }}>
                                            <div class="period-card-inner">
                                                @if($hDisc > 0)<span class="period-save-badge">Save {{ $hDisc }}%</span>@endif
                                                <div class="period-title">Half-Yearly</div>
                                                <div class="period-duration">6 Months</div>
                                                @if($hDisc > 0)<div class="period-original-price">৳{{ number_format($hOrig) }}</div>@endif
                                                <div class="period-price">৳{{ number_format($hFinal) }}</div>
                                            </div>
                                        </label>

                                        {{-- Yearly --}}
                                        @php $yDisc = $periodDiscount('yearly'); $yOrig = $monthlyPrice * 12; $yFinal = $discountedPrice($yOrig, $yDisc); @endphp
                                        <label class="period-card {{ $selectedPeriod === 'yearly' ? 'selected' : '' }}">
                                            <input type="radio" name="billing_period" value="yearly" class="d-none period-radio"
                                                data-months="12"
                                                data-total="{{ $yFinal }}"
                                                data-original="{{ $yOrig }}"
                                                data-discount="{{ $yDisc }}"
                                                data-label="Yearly"
                                                {{ $selectedPeriod === 'yearly' ? 'checked' : '' }}>
                                            <div class="period-card-inner">
                                                @if($yDisc > 0)
                                                    <span class="period-save-badge best-value-badge">Best Value · Save {{ $yDisc }}%</span>
                                                @else
                                                    <span class="period-badge">Best Value</span>
                                                @endif
                                                <div class="period-title">Yearly</div>
                                                <div class="period-duration">12 Months</div>
                                                @if($yDisc > 0)<div class="period-original-price">৳{{ number_format($yOrig) }}</div>@endif
                                                <div class="period-price">৳{{ number_format($yFinal) }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @else
                                {{-- Free Package Service Fee Notice --}}
                                <input type="hidden" name="billing_period" value="{{ $package->free_validity_period ?: '1_year' }}">
                                <div class="alert alert-info border-0 rounded-3 mb-4 d-flex align-items-center gap-3" style="background:#f0fdf4; border-left:4px solid #16a34a !important; color:#14532d;">
                                    <i class="fa-solid fa-circle-check fa-xl text-success"></i>
                                    <div>
                                        <strong class="d-block" style="font-size:0.92rem;">One-Time Service Fee Plan</strong>
                                        <span style="font-size:0.83rem;">
                                            This Free plan is valid for <strong>{{ $package->getFreeValidityMonths() === 6 ? '6 Months' : '1 Year' }}</strong> without any recurring monthly charges. Pay the one-time service fee to activate.
                                        </span>
                                    </div>
                                </div>
                            @endif

                            {{-- 2. Payment Method Options --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Which payment gateway did you send to? <span class="text-danger">*</span></label>
                                <div class="method-options">
                                    @if($paymentNumbers['bKash'])
                                        <label class="method-option">
                                            <input type="radio" name="payment_method" value="bkash" required {{ old('payment_method') === 'bkash' ? 'checked' : '' }}>
                                            <span><b>bKash</b><small>{{ ucfirst($paymentMode) }} Account</small></span>
                                            <i class="fa-solid fa-circle-check"></i>
                                        </label>
                                    @endif
                                    @if($paymentNumbers['Nagad'])
                                        <label class="method-option">
                                            <input type="radio" name="payment_method" value="nagad" required {{ old('payment_method') === 'nagad' ? 'checked' : '' }}>
                                            <span><b>Nagad</b><small>{{ ucfirst($paymentMode) }} Account</small></span>
                                            <i class="fa-solid fa-circle-check"></i>
                                        </label>
                                    @endif
                                </div>
                            </div>

                            {{-- 3. Sender Number --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sender Mobile Number <span class="text-danger">*</span></label>
                                <div class="phone-input-wrap">
                                    <span class="phone-prefix">+88</span>
                                    <input type="text" name="sender_number" id="senderNumberInput"
                                        class="form-control phone-input-field"
                                        placeholder="01XXXXXXXXX"
                                        value="{{ old('sender_number') }}"
                                        maxlength="11"
                                        inputmode="numeric"
                                        autocomplete="tel"
                                        required>
                                    <span class="phone-status-icon" id="phoneStatusIcon"></span>
                                </div>
                                <div id="phoneValidationMsg" class="phone-validation-msg" style="display:none;"></div>
                                <div class="form-text" style="font-size:11px;">বাংলাদেশের ১১ সংখ্যার মোবাইল নম্বর দিন (যে নম্বর থেকে পেমেন্ট পাঠানো হয়েছে)।</div>
                            </div>

                            {{-- 4. Transaction Reference --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Transaction ID (TrxID) <span class="text-danger">*</span></label>
                                <input type="text" name="payment_reference" class="form-control" placeholder="e.g. 9B54A78XYZ" value="{{ old('payment_reference') }}" required>
                                <div class="form-text" style="font-size:11px;">The SMS transaction identifier received after sending money.</div>
                            </div>

                            {{-- 5. Payment Date/Time --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Payment Date and Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="payment_submitted_at" class="form-control" value="{{ old('payment_submitted_at', now()->format('Y-m-d\TH:i')) }}" max="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 submit-payment" style="font-size:1rem;">
                                <i class="fa-solid fa-lock me-2"></i> Submit for Super Admin Verification
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customCSS')
<style>
    .subscription-checkout { color: #172033; }
    .checkout-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; }
    .checkout-kicker, .summary-label { color:#64748b; font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
    .checkout-kicker { color:#2563eb; display:inline-flex; gap:7px; align-items:center; margin-bottom:8px; }
    .checkout-summary { background:linear-gradient(135deg,#172554,#2563eb); color:#fff; border-radius:16px; overflow:hidden; }
    .checkout-summary .summary-label { color:#bfdbfe; }
    .summary-check { width:34px; height:34px; display:grid; place-items:center; border-radius:50%; background:rgba(255,255,255,.16); color:#bfdbfe; }
    .summary-total { display:flex; justify-content:space-between; align-items:end; padding-top:16px; border-top:1px solid rgba(255,255,255,.2); }
    .summary-total strong { font-size:26px; line-height:1; }
    .checkout-steps { padding:4px 2px; }
    .checkout-step { display:flex; gap:12px; align-items:center; padding:9px 0; }
    .checkout-step > span { width:27px; height:27px; flex:0 0 27px; display:grid; place-items:center; border-radius:50%; background:#dbeafe; color:#1d4ed8; font-weight:800; font-size:12px; }
    .checkout-step strong { font-size:13px; display:block; }
    .checkout-step small { color:#64748b; font-size:11px; display:block; margin-top:2px; }
    .payment-account-card, .payment-form-card { border-radius:16px; }
    .account-icon { color:#2563eb; font-size:19px; }
    .account-row { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:12px 0; border-top:1px solid #e5e7eb; }
    .account-row > div { display:flex; align-items:center; gap:10px; }
    .account-method { min-width:55px; color:#334155; font-size:12px; font-weight:800; }
    .account-row strong { font-size:17px; letter-spacing:.03em; }
    .copy-number { width:32px; height:32px; border:1px solid #dbeafe; border-radius:8px; background:#eff6ff; color:#2563eb; }
    .copy-number:hover { background:#dbeafe; }
    .account-instructions { padding:10px 12px; border-radius:8px; background:#eff6ff; color:#1e40af; font-size:12px; line-height:1.5; }
    .form-title { display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; display:grid; place-items:center; border-radius:12px; background:#eff6ff; color:#2563eb; font-size:18px; }
    
    /* Billing Period Cards */
    .billing-period-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
    .period-card { border:2px solid #e2e8f0; border-radius:12px; padding:12px 10px; cursor:pointer; text-align:center; transition:all 0.2s ease; position:relative; background:#f8fafc; }
    .period-card:hover { border-color:#93c5fd; background:#fff; transform:translateY(-2px); }
    .period-card.selected { border-color:#2563eb; background:#eff6ff; box-shadow:0 4px 12px rgba(37,99,235,0.12); }
    .period-title { font-size:11px; font-weight:700; text-transform:uppercase; color:#64748b; letter-spacing:0.04em; }
    .period-card.selected .period-title { color:#1d4ed8; }
    .period-duration { font-size:12px; font-weight:600; color:#1e293b; margin:2px 0; }
    .period-price { font-size:15px; font-weight:800; color:#1d4ed8; }
    .period-original-price { font-size:11px; color:#94a3b8; text-decoration:line-through; margin-bottom:1px; }
    .period-badge { position:absolute; top:-9px; left:50%; transform:translateX(-50%); background:#f59e0b; color:#fff; font-size:9px; font-weight:800; text-transform:uppercase; padding:2px 6px; border-radius:10px; letter-spacing:0.03em; white-space:nowrap; }
    .period-save-badge { position:absolute; top:-9px; left:50%; transform:translateX(-50%); background:#16a34a; color:#fff; font-size:9px; font-weight:800; text-transform:uppercase; padding:2px 7px; border-radius:10px; letter-spacing:0.03em; white-space:nowrap; }
    .best-value-badge { background: linear-gradient(135deg,#f59e0b,#d97706) !important; }
    .period-card.selected .period-save-badge { box-shadow:0 2px 6px rgba(22,163,74,.4); }

    /* Phone Number Input */
    .phone-input-wrap { position:relative; display:flex; align-items:center; }
    .phone-prefix { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; font-weight:700; color:#64748b; pointer-events:none; z-index:2; }
    .phone-input-field { padding-left:42px !important; padding-right:36px !important; letter-spacing:0.04em; font-size:15px; font-weight:600; }
    .phone-status-icon { position:absolute; right:11px; top:50%; transform:translateY(-50%); font-size:16px; transition:all .2s; }
    .phone-status-icon.valid   { color:#16a34a; }
    .phone-status-icon.invalid { color:#dc2626; }
    .phone-input-field.phone-valid   { border-color:#16a34a !important; background:#f0fdf4 !important; }
    .phone-input-field.phone-invalid { border-color:#dc2626 !important; background:#fef2f2 !important; }
    .phone-validation-msg { font-size:11.5px; font-weight:600; margin-top:5px; padding:6px 10px; border-radius:7px; display:flex; align-items:center; gap:6px; }
    .phone-validation-msg.valid   { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
    .phone-validation-msg.invalid { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }

    .method-options { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
    .method-option { position:relative; display:flex; align-items:center; gap:10px; padding:12px 14px; border:1px solid #e2e8f0; border-radius:10px; cursor:pointer; transition:.2s; }
    .method-option:hover, .method-option:has(input:checked) { border-color:#2563eb; background:#eff6ff; }
    .method-option input { accent-color:#2563eb; }
    .method-option b { font-size:14px; display:block; }
    .method-option small { color:#64748b; font-size:11px; display:block; }
    .method-option > i { margin-left:auto; color:#2563eb; opacity:0; }
    .method-option:has(input:checked) > i { opacity:1; }
    .payment-form-card .form-control { min-height:46px; border-color:#dbe3ef; border-radius:9px; }
    .payment-form-card .form-control:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .submit-payment { min-height:48px; border-radius:9px; font-weight:700; }
    @media (max-width: 768px) {
        .billing-period-grid { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width: 575px) {
        .checkout-heading { display:block; }
        .checkout-heading > a { display:inline-block; margin-top:14px; }
        .method-options { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('customJs')
<script>
    const isFree = {{ $isFree ? 'true' : 'false' }};
    const baseDate = new Date("{{ $baseIso }}");
    const monthlyPrice = {{ $monthlyPrice }};
    const freeServiceFee = {{ $serviceFee }};
    const freeValidityMonths = {{ $package->getFreeValidityMonths() }};

    function addMonthsCalendarAware(date, months) {
        const d = new Date(date.getTime());
        const expectedMonth = (d.getMonth() + months) % 12;
        d.setMonth(d.getMonth() + months);
        // If overflow occurred (e.g. Jan 31 -> March), rollback to last day of expected month
        if (d.getMonth() !== expectedMonth) {
            d.setDate(0);
        }
        return d;
    }

    function formatDate(date) {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const day = String(date.getDate()).padStart(2, '0');
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }

    function updateCalculations() {
        if (isFree) {
            const expiry = addMonthsCalendarAware(baseDate, freeValidityMonths);
            document.getElementById('summaryExpiryDate').innerText = formatDate(expiry);
            document.getElementById('summaryTotalAmount').innerText = '৳' + freeServiceFee.toLocaleString('en-US', { minimumFractionDigits: 2 });
            document.getElementById('summaryDurationText').innerText = freeValidityMonths + ' Months';
            return;
        }

        const selectedRadio = document.querySelector('input.period-radio:checked');
        if (!selectedRadio) return;

        const months = parseInt(selectedRadio.dataset.months, 10);
        const total = parseFloat(selectedRadio.dataset.total);
        const label = selectedRadio.dataset.label;

        // Calendar-aware expiry preview
        const expiry = addMonthsCalendarAware(baseDate, months);

        document.getElementById('summaryExpiryDate').innerText = formatDate(expiry);
        document.getElementById('summaryTotalAmount').innerText = '৳' + total.toLocaleString('en-US', { minimumFractionDigits: 2 });
        document.getElementById('summaryDurationText').innerText = months === 1 ? '1 Month' : `${months} Months`;
        document.getElementById('summaryPeriodSubtitle').innerText = `${label} Plan · ৳${monthlyPrice.toLocaleString()}/month`;
        const discountPct = parseFloat(selectedRadio.dataset.discount) || 0;
        if (discountPct > 0) {
            document.getElementById('summaryRateNote').innerText = `৳${monthlyPrice.toLocaleString()} × ${months} mo (${discountPct}% off)`;
        } else {
            document.getElementById('summaryRateNote').innerText = `৳${monthlyPrice.toLocaleString()} × ${months} mo`;
        }
    }

    document.querySelectorAll('.period-card').forEach(function (card) {
        card.addEventListener('click', function () {
            document.querySelectorAll('.period-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                updateCalculations();
            }
        });
    });

    // ── Phone number validation ──────────────────────────────────────────
    const phoneInput  = document.getElementById('senderNumberInput');
    const phoneIcon   = document.getElementById('phoneStatusIcon');
    const phoneMsg    = document.getElementById('phoneValidationMsg');
    const submitBtn   = document.querySelector('.submit-payment');
    const BD_PHONE    = /^01[3-9]\d{8}$/;

    function validatePhone() {
        if (!phoneInput) return true;
        const val = phoneInput.value.replace(/\s/g, '');
        const isValid = BD_PHONE.test(val);
        const isEmpty = val.length === 0;

        phoneInput.classList.toggle('phone-valid',   isValid);
        phoneInput.classList.toggle('phone-invalid', !isValid && !isEmpty);

        if (isValid) {
            phoneIcon.className = 'phone-status-icon valid';
            phoneIcon.innerHTML = '✓';
            phoneMsg.style.display = 'flex';
            phoneMsg.className = 'phone-validation-msg valid';
            phoneMsg.innerHTML = '✓ &nbsp;বৈধ বাংলাদেশী মোবাইল নম্বর';
            if (submitBtn) submitBtn.disabled = false;
        } else if (!isEmpty) {
            phoneIcon.className = 'phone-status-icon invalid';
            phoneIcon.innerHTML = '✕';
            phoneMsg.style.display = 'flex';
            phoneMsg.className = 'phone-validation-msg invalid';
            if (val.length < 11) {
                phoneMsg.innerHTML = '✕ &nbsp;নম্বরটি ' + val.length + ' ডিজিট — পূর্ণ ১১ ডিজিট দিন (01XXXXXXXXX)';
            } else if (!val.startsWith('01')) {
                phoneMsg.innerHTML = '✕ &nbsp;বাংলাদেশী নম্বর অবশ্যই 01 দিয়ে শুরু হতে হবে';
            } else {
                phoneMsg.innerHTML = '✕ &nbsp;সঠিক ফরম্যাট: 013, 014, 015, 016, 017, 018, 019 দিয়ে শুরু';
            }
            if (submitBtn) submitBtn.disabled = true;
        } else {
            phoneIcon.className = 'phone-status-icon';
            phoneIcon.innerHTML = '';
            phoneMsg.style.display = 'none';
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');
            validatePhone();
        });
        phoneInput.addEventListener('blur', validatePhone);
        validatePhone(); // initial check if old() value present
    }

    // Block form submit if phone invalid
    const checkoutForm = document.getElementById('checkoutPaymentForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            if (phoneInput) {
                const val = phoneInput.value.replace(/\s/g, '');
                if (!BD_PHONE.test(val)) {
                    e.preventDefault();
                    validatePhone();
                    phoneInput.focus();
                    phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
            }
        });
    }

    document.querySelectorAll('.copy-number').forEach(function (button) {
        button.addEventListener('click', function () {
            navigator.clipboard.writeText(button.dataset.number).then(function () {
                button.innerHTML = '<i class="fa-solid fa-check"></i>';
                setTimeout(function () { button.innerHTML = '<i class="fa-regular fa-copy"></i>'; }, 1400);
            });
        });
    });

    // Run on initial page load
    document.addEventListener('DOMContentLoaded', function () {
        updateCalculations();
    });
</script>
@endsection
