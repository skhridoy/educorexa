<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($currentSchool) && $currentSchool->favicon)
        <link rel="icon" type="image/{{ pathinfo($currentSchool->favicon, PATHINFO_EXTENSION) }}" href="{{ asset($currentSchool->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
    @endif
    <title>@yield('title', 'Auth') — {{ $currentSchool->name ?? 'School Portal' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; font-family: 'Inter', sans-serif; }

        /* ── Layout ── */
        .auth-root {
            display: flex;
            min-height: 100vh;
        }

        /* ── LEFT PANEL ── */
        .auth-panel {
            width: 420px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #001830 0%, #002b5c 55%, #003d7a 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 36px;
            overflow: hidden;
        }

        /* decorative circles */
        .auth-panel::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(212,175,55,0.07);
            top: -80px; right: -80px;
        }
        .auth-panel::after {
            content: '';
            position: absolute;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: 60px; left: -60px;
        }

        .panel-top { position: relative; z-index: 2; }

        .panel-logo-box {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.12);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1.5px solid rgba(255,255,255,0.15);
        }

        .panel-logo-box img { width: 56px; height: 56px; object-fit: contain; border-radius: 10px; }

        .panel-school-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .panel-school-name span { color: #D4AF37; }

        .panel-tagline {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
        }

        /* gold divider */
        .panel-divider {
            width: 40px; height: 3px;
            background: linear-gradient(90deg, #D4AF37, #f0d060);
            border-radius: 2px;
            margin: 20px 0;
        }

        /* feature list */
        .panel-features { position: relative; z-index: 2; }

        .panel-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .panel-feature .feat-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #D4AF37;
            font-size: 14px;
            flex-shrink: 0;
        }

        .panel-feature .feat-text {
            font-size: 0.83rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.4;
        }

        .panel-feature .feat-text strong {
            display: block;
            color: rgba(255,255,255,0.95);
            font-size: 0.88rem;
            margin-bottom: 1px;
        }

        .panel-bottom { position: relative; z-index: 2; }

        .panel-nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .panel-nav a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.05);
            transition: all 0.2s;
            font-weight: 500;
        }

        .panel-nav a:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-color: rgba(255,255,255,0.25);
        }

        .panel-copyright {
            margin-top: 16px;
            font-size: 0.72rem;
            color: rgba(255,255,255,0.3);
        }

        /* ── RIGHT PANEL ── */
        .auth-form-side {
            flex: 1;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* ── Card ── */
        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow:
                0 1px 3px rgba(0,0,0,0.04),
                0 10px 30px rgba(0,33,71,0.08),
                0 30px 60px rgba(0,33,71,0.05);
            overflow: hidden;
        }

        .auth-card-stripe {
            height: 4px;
            background: linear-gradient(90deg, #002147, #D4AF37 50%, #002147);
        }

        .auth-card-body { padding: 36px; }

        /* ── Form elements ── */
        .auth-page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .auth-page-sub {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .f-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 7px;
        }

        .f-group { margin-bottom: 18px; }

        .f-input-wrap { position: relative; }

        .f-input-wrap .f-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }

        .f-control {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.93rem;
            color: #0f172a;
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s;
            outline: none;
        }

        .f-control:focus {
            border-color: #002147;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0,33,71,0.06);
        }

        .f-control.is-invalid { border-color: #ef4444; }

        .f-control.no-icon { padding-left: 14px; }

        .f-btn-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
            padding: 4px;
            line-height: 1;
        }

        .f-btn-toggle:hover { color: #002147; }

        .f-error { font-size: 0.78rem; color: #ef4444; margin-top: 5px; display: block; }

        /* ── Submit button ── */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #002147 0%, #003d7a 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 0.98rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 6px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,33,71,0.28);
        }

        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* ── Alert ── */
        .f-alert {
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.86rem;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            line-height: 1.5;
        }

        /* Typography & Icons */
.auth-heading {
    font-family: 'Outfit', sans-serif;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.auth-subtitle {
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.5;
}

/* Icon Animation & Style */
.auth-icon-box {
    width: 72px;
    height: 72px;
    border-radius: 20px;
    background: linear-gradient(135deg, #f0f7ff, #e0ebff);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    box-shadow: 0 10px 20px rgba(0, 33, 71, 0.05);
    color: #002147;
    font-size: 28px;
    transition: transform 0.3s ease;
}

.auth-icon-box:hover {
    transform: translateY(-5px);
}

/* Alert Styling */
.alert-auth {
    padding: 14px 16px;
    border-radius: 12px;
    display: flex;
    gap: 12px;
    font-size: 0.88rem;
    margin-bottom: 20px;
    border: 1px solid transparent;
}

.alert-auth.success {
    background-color: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}

.alert-auth.danger {
    background-color: #fef2f2;
    border-color: #fecaca;
    color: #991b1b;
    flex-direction: column;
}

.alert-icon-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
}

/* Input & Button Styling */
.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    color: #94a3b8;
}

.form-control {
    padding: 12px 12px 12px 45px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #002147;
    box-shadow: 0 0 0 4px rgba(0, 33, 71, 0.08);
}

.btn-auth {
    background: #002147;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-auth:hover {
    background: #003366;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 33, 71, 0.15);
}

/* Divider & Links */
.auth-divider {
    text-align: center;
    margin: 25px 0;
    position: relative;
}

.auth-divider::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e2e8f0;
    z-index: 1;
}

.auth-divider span {
    background: #fff;
    padding: 0 15px;
    position: relative;
    z-index: 2;
    color: #94a3b8;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.auth-link-back {
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.2s;
}

.auth-link-back:hover {
    color: #002147;
}

.auth-link-back i {
    transition: transform 0.2s;
}

.auth-link-back:hover i {
    transform: translateX(-3px);
}
        .f-alert.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .f-alert.danger  { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .f-alert.warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; flex-direction: column; gap: 6px; }

        /* ── Links ── */
        .f-link { color: #002147; font-weight: 600; text-decoration: none; font-size: 0.85rem; }
        .f-link:hover { text-decoration: underline; }
        .f-link.muted { color: #94a3b8; font-weight: 500; }
        .f-link.muted:hover { color: #002147; }

        .f-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            font-size: 0.78rem;
            color: #cbd5e1;
        }
        .f-divider::before, .f-divider::after {
            content: ''; flex: 1; height: 1px; background: #f1f5f9;
        }

        /* ── Checkbox ── */
        .f-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .f-check input { width: 15px; height: 15px; cursor: pointer; accent-color: #002147; }
        .f-check label { font-size: 0.85rem; color: #64748b; cursor: pointer; }

        /* ── OTP Boxes ── */
        .otp-grid {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 24px 0 18px;
        }

        .otp-box {
            flex: 1;
            max-width: 54px;
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            color: #002147;
            background: #f8fafc;
            outline: none;
            transition: all 0.2s;
            font-family: 'Outfit', sans-serif;
        }

        .otp-box:focus {
            border-color: #002147;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0,33,71,0.07);
            transform: translateY(-3px);
        }

        .otp-box.filled {
            border-color: #D4AF37;
            background: #fff;
        }

        /* ── Step dots ── */
        .step-dots {
            display: flex;
            gap: 6px;
            justify-content: center;
            margin-bottom: 24px;
        }
        .step-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #e2e8f0;
            transition: all 0.3s;
        }
        .step-dot.done { background: #D4AF37; }
        .step-dot.active { width: 22px; border-radius: 4px; background: #002147; }

        /* ── Timer ── */
        .otp-timer {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.82rem;
            color: #92400e;
            font-weight: 600;
        }

        .otp-timer #countdown { font-family: monospace; font-weight: 800; min-width: 30px; }

        /* ── Strength Bar ── */
        .strength-track {
            height: 4px;
            background: #f1f5f9;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 6px;
        }
        .strength-fill {
            height: 100%;
            width: 0;
            border-radius: 2px;
            transition: all 0.35s;
            background: #ef4444;
        }
        .strength-label { font-size: 0.75rem; color: #94a3b8; }

        /* ── Shake animation ── */
        @keyframes shake {
            0%,100%{transform:translateX(0)}
            20%{transform:translateX(-8px)}
            40%{transform:translateX(8px)}
            60%{transform:translateX(-5px)}
            80%{transform:translateX(5px)}
        }
        .shake { animation: shake 0.5s ease; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .auth-root { flex-direction: column; }

            .auth-panel {
                width: 100%;
                padding: 28px 20px;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .auth-panel::before, .auth-panel::after { display: none; }

            .panel-top {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .panel-logo-box {
                width: 52px; height: 52px;
                border-radius: 14px;
                margin-bottom: 0;
            }

            .panel-logo-box img { width: 36px; height: 36px; }

            .panel-school-name { font-size: 1.05rem; }
            .panel-tagline, .panel-divider, .panel-features { display: none; }

            .panel-bottom { display: none; }

            .panel-nav-mobile {
                display: flex !important;
                gap: 8px;
            }

            .auth-form-side { padding: 24px 16px 40px; }
            .auth-card-body { padding: 28px 22px; }
        }

        @media (min-width: 769px) {
            .panel-nav-mobile { display: none; }
        }
    </style>

    @yield('customCSS')
</head>
<body>
<div class="auth-root">

    {{-- ─── LEFT PANEL ─── --}}
    <div class="auth-panel">
        <div class="panel-top">
            <div class="panel-logo-box">
                @if($currentSchool->logo)
                    <img src="{{ asset($currentSchool->logo) }}" alt="{{ $currentSchool->name }}">
                @else
                    <i class="fas fa-school" style="color:#D4AF37; font-size:28px;"></i>
                @endif
            </div>
            <div>
                <div class="panel-school-name">{{ $currentSchool->name }}</div>
                <div class="panel-tagline">School Management Portal</div>
            </div>

            {{-- Mobile nav --}}
            <div class="panel-nav-mobile" style="display:none;">
                <a href="{{ route('school.home', ['tenant' => $currentSchool->slug]) }}" style="color:rgba(255,255,255,0.7);text-decoration:none;font-size:0.8rem;border:1px solid rgba(255,255,255,0.2);padding:6px 12px;border-radius:8px;">
                    <i class="fas fa-house"></i>
                </a>
                <a href="{{ route('school.login.form', ['tenant' => $currentSchool->slug]) }}" style="color:#D4AF37;text-decoration:none;font-size:0.8rem;border:1px solid rgba(212,175,55,0.4);padding:6px 12px;border-radius:8px;">
                    <i class="fas fa-right-to-bracket"></i>
                </a>
            </div>
        </div>

        <div class="panel-divider"></div>

        <div class="panel-features">
            <div class="panel-feature">
                <div class="feat-icon"><i class="fas fa-shield-halved"></i></div>
                <div class="feat-text">
                    <strong>Secure Access</strong>
                    Bank-grade security for your data
                </div>
            </div>
            <div class="panel-feature">
                <div class="feat-icon"><i class="fas fa-bell"></i></div>
                <div class="feat-text">
                    <strong>Smart Notifications</strong>
                    Stay updated in real time
                </div>
            </div>
            <div class="panel-feature">
                <div class="feat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="feat-text">
                    <strong>Academic Reports</strong>
                    Track progress effortlessly
                </div>
            </div>
        </div>

        <div class="panel-bottom">
            <div class="panel-nav">
                <a href="{{ route('school.home', ['tenant' => $currentSchool->slug]) }}">
                    <i class="fas fa-house"></i> Home
                </a>
                <a href="{{ route('school.login.form', ['tenant' => $currentSchool->slug]) }}">
                    <i class="fas fa-right-to-bracket"></i> Login
                </a>
            </div>
            <div class="panel-copyright">&copy; {{ date('Y') }} {{ $currentSchool->name }}. All rights reserved.</div>
        </div>
    </div>

    {{-- ─── RIGHT FORM SIDE ─── --}}
    <div class="auth-form-side">
        <div class="auth-form-wrapper">
            <div class="auth-card">
                <div class="auth-card-stripe"></div>
                <div class="auth-card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('customJs')
</body>
</html>
