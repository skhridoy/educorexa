<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $school->name ?? 'EduCorexa' }} — Domain Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #f8fafc;
        }
        .status-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            max-width: 580px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }
        .status-card::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .icon-box {
            width: 76px;
            height: 76px;
            margin: 0 auto 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        .icon-box.pending {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .icon-box.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .icon-box.disabled {
            background: rgba(148, 163, 184, 0.15);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }
        .domain-chip {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px 16px;
            display: inline-block;
            font-family: monospace;
            font-size: 15px;
            color: #818cf8;
            margin-bottom: 20px;
        }
        .subdomain-fallback {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 16px;
            margin-top: 24px;
            font-size: 13.5px;
            color: #cbd5e1;
        }
        .btn-portal {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff;
            font-weight: 700;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-portal:hover {
            opacity: 0.95;
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="status-card">
        @if($status === 'pending')
            <div class="icon-box pending">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <h3 class="fw-bold mb-2">Domain Verification in Progress</h3>
            <div class="domain-chip">
                <i class="fa-solid fa-globe me-2"></i>{{ $school->custom_domain }}
            </div>
            <p class="text-secondary mb-3" style="font-size: 14px; line-height: 1.6;">
                This custom domain has been configured for <strong>{{ $school->name }}</strong> and is currently awaiting administrator verification or DNS propagation.
            </p>
        @elseif($status === 'rejected')
            <div class="icon-box rejected">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <h3 class="fw-bold mb-2">Domain Request Notice</h3>
            <div class="domain-chip">
                <i class="fa-solid fa-globe me-2"></i>{{ $school->custom_domain }}
            </div>
            <p class="text-secondary mb-3" style="font-size: 14px; line-height: 1.6;">
                {{ $message }}
            </p>
        @else
            <div class="icon-box disabled">
                <i class="fa-solid fa-ban"></i>
            </div>
            <h3 class="fw-bold mb-2">Domain Currently Inactive</h3>
            <div class="domain-chip">
                <i class="fa-solid fa-globe me-2"></i>{{ $school->custom_domain }}
            </div>
            <p class="text-secondary mb-3" style="font-size: 14px; line-height: 1.6;">
                This custom domain is currently disabled. Please contact the school administration for assistance.
            </p>
        @endif

        @if(!empty($school->slug))
            @php
                $fallbackUrl = (request()->isSecure() ? 'https://' : 'http://') . $school->slug . '.' . config('app.main_domain');
            @endphp
            <div class="subdomain-fallback">
                <div class="mb-2 text-muted" style="font-size: 12.5px;">You can still access the school portal via:</div>
                <a href="{{ $fallbackUrl }}" class="btn-portal">
                    <span>Visit via Subdomain</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</body>
</html>
