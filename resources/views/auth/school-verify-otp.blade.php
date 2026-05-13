@extends('school.website.layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<!-- Step Indicator -->
<div class="step-dots mb-4">
    <div class="step-dot done"></div>
    <div class="step-dot active"></div>
    <div class="step-dot"></div>
</div>

<!-- Header Section -->
<div class="text-center mb-4">
    <div class="auth-icon-box position-relative">
        <i class="fas fa-shield-halved animate-pulse-slow"></i>
    </div>
    <h4 class="auth-heading">Verify Your Identity</h4>
    <p class="auth-subtitle mb-2">We've sent a 6-digit verification code to:</p>
    <div class="email-display-badge">
        <i class="fas fa-envelope me-2"></i> {{ $email }}
    </div>
</div>

@if($errors->any())
    <div class="alert-auth danger mb-4 animate-shake">
        <i class="fas fa-circle-exclamation me-2"></i> {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('school.password.verify', ['tenant' => $currentSchool->slug]) }}" method="POST" id="otpForm">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="otp" id="otp-hidden">

    <!-- OTP Input Boxes -->
    <div id="otpBoxes" class="otp-grid mb-4">
        @for($i = 0; $i < 6; $i++)
            <input type="text" class="otp-box" maxlength="1" inputmode="numeric" 
                   pattern="[0-9]" autocomplete="one-time-code" data-index="{{ $i }}">
        @endfor
    </div>

    <!-- Timer Section -->
    <div class="text-center mb-4">
        <div id="timer-badge" class="otp-timer">
            <i class="fas fa-clock"></i> 
            <span>Code expires in: <b id="countdown">10:00</b></span>
        </div>
    </div>

    <button type="submit" class="btn-submit w-100" id="verifyBtn">
        <span>Verify Code</span>
        <i class="fas fa-check-double ms-2"></i>
    </button>
</form>

<div class="f-divider">
    <span>verification help</span>
</div>

<div class="auth-footer-links text-center">
    <a href="{{ route('school.password.request', ['tenant' => $currentSchool->slug]) }}" class="f-link">
        <i class="fas fa-rotate-right me-1"></i> Didn't get the code? Resend
    </a>
    <div class="mt-3">
        <a href="{{ route('school.login.form', ['tenant' => $currentSchool->slug]) }}" class="auth-link-back">
            <i class="fas fa-arrow-left me-1"></i> Back to Login
        </a>
    </div>
</div>
@endsection

@section('customJs')
<script>
    const digits = document.querySelectorAll('.otp-box');
    const hidden = document.getElementById('otp-hidden');
    const form = document.getElementById('otpForm');

    function syncHidden() {
        hidden.value = [...digits].map(d => d.value).join('');
    }

    digits.forEach((input, idx) => {
        input.addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/\D/g, '').slice(-1);
            this.classList.toggle('filled', !!this.value);
            
            // Auto focus next
            if (this.value && idx < 5) {
                digits[idx + 1].focus();
            }
            syncHidden();
        });

        input.addEventListener('keydown', function(e) {
            // Handle backspace
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                digits[idx - 1].classList.remove('filled');
                syncHidden();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => {
                if (digits[i]) {
                    digits[i].value = ch;
                    digits[i].classList.add('filled');
                }
            });
            const nextIdx = pasted.length < 6 ? pasted.length : 5;
            digits[nextIdx].focus();
            syncHidden();
        });
    });

    form.addEventListener('submit', function(e) {
        syncHidden();
        if (hidden.value.length < 6) {
            e.preventDefault();
            const boxes = document.getElementById('otpBoxes');
            boxes.classList.add('shake');
            setTimeout(() => boxes.classList.remove('shake'), 500);
        }
    });

    // Auto focus first input on load
    window.addEventListener('DOMContentLoaded', () => {
        if(digits[0]) digits[0].focus();
    });

    // Timer Logic
    let timeLeft = 600; // 10 Minutes
    const countdownEl = document.getElementById('countdown');
    const timerBadge = document.getElementById('timer-badge');
    const verifyBtn = document.getElementById('verifyBtn');

    const timer = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timer);
            countdownEl.textContent = 'Expired';
            timerBadge.classList.add('danger');
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<span>OTP Expired</span><i class="fas fa-circle-xmark ms-2"></i>';
            return;
        }
        timeLeft--;
        const mins = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const secs = String(timeLeft % 60).padStart(2, '0');
        countdownEl.textContent = `${mins}:${secs}`;
        
        if (timeLeft <= 60) {
            countdownEl.style.color = '#ef4444';
        }
    }, 1000);
</script>

<style>
    .animate-pulse-slow {
        animation: pulse-slow 3s infinite;
    }
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }
    .email-display-badge {
        display: inline-flex;
        align-items: center;
        background: #f0f7ff;
        border: 1px solid #cce0ff;
        border-radius: 50px;
        padding: 6px 16px;
        font-size: 0.85rem;
        color: #002147;
        font-weight: 600;
    }
    .otp-timer.danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }
</style>
@endsection