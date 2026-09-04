@extends('layouts.school')

@section('title', 'Subscription Payment')

@section('content')
<div class="page-content">
    <div class="container-fluid subscription-checkout" style="max-width:1080px;">
        <div class="checkout-heading mb-4">
            <div>
                <span class="checkout-kicker"><i class="fa-solid fa-shield-halved"></i> Secure subscription checkout</span>
                <h2 class="fw-bold mb-1">Complete your payment</h2>
                <p class="text-muted mb-0">Send the exact amount, add your transaction ID, and we will verify it shortly.</p>
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
            <div class="col-lg-5">
                <div class="checkout-summary card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="summary-label">ORDER SUMMARY</div>
                        <div class="d-flex justify-content-between align-items-start mt-2">
                            <div>
                                <h4 class="mb-1">{{ $subscription->package->name }}</h4>
                                <span class="text-muted small">{{ ucfirst($subscription->package->duration) }} subscription</span>
                            </div>
                            <span class="summary-check"><i class="fa-solid fa-check"></i></span>
                        </div>
                        <div class="summary-total mt-4">
                            <span>Total to pay</span>
                            <strong>৳{{ number_format($subscription->amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="checkout-steps mb-4">
                    <div class="checkout-step"><span>1</span><div><strong>Send Money</strong><small>Use the number shown below</small></div></div>
                    <div class="checkout-step"><span>2</span><div><strong>Enter details</strong><small>Add sender number and transaction ID</small></div></div>
                    <div class="checkout-step"><span>3</span><div><strong>Get verified</strong><small>Super Admin will confirm your payment</small></div></div>
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

            <div class="col-lg-7">
                <div class="payment-form-card card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                <div class="form-title mb-4"><span class="form-icon"><i class="fa-solid fa-receipt"></i></span><div><h4 class="mb-1">Payment details</h4><p class="text-muted mb-0 small">Tell us where the payment came from.</p></div></div>
                <form action="{{ route('school.subscription-payment.store', ['tenant' => $school->slug]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                    <div class="mb-3">
                        <label class="form-label">Which account did you use?</label>
                        <div class="method-options">
                            @if($paymentNumbers['bKash'])<label class="method-option"><input type="radio" name="payment_method" value="bkash" required><span><b>bKash</b><small>Personal</small></span><i class="fa-solid fa-circle-check"></i></label>@endif
                            @if($paymentNumbers['Nagad'])<label class="method-option"><input type="radio" name="payment_method" value="nagad" required><span><b>Nagad</b><small>Personal</small></span><i class="fa-solid fa-circle-check"></i></label>@endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sender Mobile Number</label>
                        <input type="text" name="sender_number" class="form-control" placeholder="01XXXXXXXXX" value="{{ old('sender_number') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" name="payment_reference" class="form-control" placeholder="Enter transaction ID" value="{{ old('payment_reference') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Payment Date and Time</label>
                        <input type="datetime-local" name="payment_submitted_at" class="form-control" value="{{ old('payment_submitted_at') }}" max="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 submit-payment"><i class="fa-solid fa-lock me-2"></i> Submit for Verification</button>
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
    .checkout-summary { background:linear-gradient(135deg,#172554,#2563eb); color:#fff; border-radius:14px; overflow:hidden; }
    .checkout-summary .summary-label { color:#bfdbfe; }
    .checkout-summary .text-muted { color:#dbeafe !important; }
    .summary-check { width:34px; height:34px; display:grid; place-items:center; border-radius:50%; background:rgba(255,255,255,.16); color:#bfdbfe; }
    .summary-total { display:flex; justify-content:space-between; align-items:end; padding-top:18px; border-top:1px solid rgba(255,255,255,.2); }
    .summary-total span { font-size:12px; color:#dbeafe; }
    .summary-total strong { font-size:28px; line-height:1; }
    .checkout-steps { padding:4px 2px; }
    .checkout-step { display:flex; gap:12px; align-items:center; padding:9px 0; }
    .checkout-step > span { width:27px; height:27px; flex:0 0 27px; display:grid; place-items:center; border-radius:50%; background:#dbeafe; color:#1d4ed8; font-weight:800; font-size:12px; }
    .checkout-step strong, .checkout-step small { display:block; }
    .checkout-step strong { font-size:13px; }
    .checkout-step small { color:#64748b; font-size:11px; margin-top:2px; }
    .payment-account-card, .payment-form-card { border-radius:14px; }
    .account-icon { color:#2563eb; font-size:19px; }
    .account-row { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:12px 0; border-top:1px solid #e5e7eb; }
    .account-row > div { display:flex; align-items:center; gap:10px; }
    .account-method { min-width:55px; color:#334155; font-size:12px; font-weight:800; }
    .account-row strong { font-size:17px; letter-spacing:.03em; }
    .copy-number { width:32px; height:32px; border:1px solid #dbeafe; border-radius:8px; background:#eff6ff; color:#2563eb; }
    .copy-number:hover { background:#dbeafe; }
    .account-instructions { padding:10px 12px; border-radius:8px; background:#eff6ff; color:#1e40af; font-size:12px; line-height:1.5; }
    .form-title { display:flex; align-items:center; gap:12px; }
    .form-icon { width:38px; height:38px; display:grid; place-items:center; border-radius:10px; background:#eff6ff; color:#2563eb; }
    .method-options { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
    .method-option { position:relative; display:flex; align-items:center; gap:10px; padding:12px 14px; border:1px solid #e2e8f0; border-radius:10px; cursor:pointer; transition:.2s; }
    .method-option:hover, .method-option:has(input:checked) { border-color:#2563eb; background:#eff6ff; }
    .method-option input { accent-color:#2563eb; }
    .method-option b, .method-option small { display:block; }
    .method-option b { font-size:14px; }
    .method-option small { color:#64748b; font-size:11px; }
    .method-option > i { margin-left:auto; color:#2563eb; opacity:0; }
    .method-option:has(input:checked) > i { opacity:1; }
    .payment-form-card .form-control { min-height:46px; border-color:#dbe3ef; border-radius:9px; }
    .payment-form-card .form-control:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
    .submit-payment { min-height:48px; border-radius:9px; font-weight:700; }
    @media (max-width: 575px) {
        .checkout-heading { display:block; }
        .checkout-heading > a { display:inline-block; margin-top:14px; }
        .method-options { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('customJs')
<script>
    document.querySelectorAll('.copy-number').forEach(function (button) {
        button.addEventListener('click', function () {
            navigator.clipboard.writeText(button.dataset.number).then(function () {
                button.innerHTML = '<i class="fa-solid fa-check"></i>';
                setTimeout(function () { button.innerHTML = '<i class="fa-regular fa-copy"></i>'; }, 1400);
            });
        });
    });
</script>
@endsection
