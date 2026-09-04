@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Payment Setup</li>
    </ul>

    <div class="mb-4">
        <h2 class="edu-page-title"><i class="fa-solid fa-credit-card me-2" style="color:#4f46e5;"></i> Payment Setup</h2>
        <p class="edu-page-sub">Configure the payment account shown to schools and keep merchant credentials ready for future gateway activation.</p>
    </div>

    @if(session('success'))
        <div class="edu-alert-success"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="edu-panel">
        <div class="edu-panel-bd">
            <form action="{{ route('settings.payment.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="edu-label">Payment Account Mode</label>
                    <select name="payment_mode" id="payment_mode" class="form-select edu-input" required>
                        <option value="personal" {{ old('payment_mode', $setting->payment_mode ?? 'personal') === 'personal' ? 'selected' : '' }}>Personal Account</option>
                        <option value="merchant" {{ old('payment_mode', $setting->payment_mode ?? 'personal') === 'merchant' ? 'selected' : '' }}>Merchant Account</option>
                    </select>
                    <small class="text-muted">Personal mode displays Send Money instructions. Merchant mode is reserved for future automatic gateway integration.</small>
                </div>

                <div id="personal-fields" class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="edu-label">bKash Personal Number</label>
                        <input type="text" name="bkash_personal_number" class="form-control edu-input" value="{{ old('bkash_personal_number', $setting->bkash_personal_number ?? '') }}" placeholder="01XXXXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Nagad Personal Number</label>
                        <input type="text" name="nagad_personal_number" class="form-control edu-input" value="{{ old('nagad_personal_number', $setting->nagad_personal_number ?? '') }}" placeholder="01XXXXXXXXX">
                    </div>
                </div>

                <div id="merchant-fields" class="row g-3 mb-4 d-none">
                    <div class="col-md-6">
                        <label class="edu-label">bKash Merchant Number</label>
                        <input type="text" name="bkash_merchant_number" class="form-control edu-input" value="{{ old('bkash_merchant_number', $setting->bkash_merchant_number ?? '') }}" placeholder="01XXXXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">bKash Merchant ID</label>
                        <input type="text" name="bkash_merchant_id" class="form-control edu-input" value="{{ old('bkash_merchant_id', $setting->bkash_merchant_id ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Nagad Merchant Number</label>
                        <input type="text" name="nagad_merchant_number" class="form-control edu-input" value="{{ old('nagad_merchant_number', $setting->nagad_merchant_number ?? '') }}" placeholder="01XXXXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Nagad Merchant ID</label>
                        <input type="text" name="nagad_merchant_id" class="form-control edu-input" value="{{ old('nagad_merchant_id', $setting->nagad_merchant_id ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">bKash API Key</label>
                        <input type="password" name="bkash_api_key" class="form-control edu-input" placeholder="Leave empty to keep current key">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">bKash API Secret</label>
                        <input type="password" name="bkash_api_secret" class="form-control edu-input" placeholder="Leave empty to keep current secret">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Nagad API Key</label>
                        <input type="password" name="nagad_api_key" class="form-control edu-input" placeholder="Leave empty to keep current key">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Nagad API Secret</label>
                        <input type="password" name="nagad_api_secret" class="form-control edu-input" placeholder="Leave empty to keep current secret">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="edu-label">Payment Instructions</label>
                    <textarea name="manual_payment_instructions" class="form-control edu-input" rows="4" placeholder="Example: Send Money to the number above and submit your transaction ID.">{{ old('manual_payment_instructions', $setting->manual_payment_instructions ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn-edu btn-edu-primary"><i class="fa-solid fa-save me-1"></i> Save Payment Setup</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    const mode = document.getElementById('payment_mode');
    const personalFields = document.getElementById('personal-fields');
    const merchantFields = document.getElementById('merchant-fields');
    function togglePaymentFields() {
        const merchant = mode.value === 'merchant';
        personalFields.classList.toggle('d-none', merchant);
        merchantFields.classList.toggle('d-none', !merchant);
    }
    mode.addEventListener('change', togglePaymentFields);
    togglePaymentFields();
</script>
@endsection
