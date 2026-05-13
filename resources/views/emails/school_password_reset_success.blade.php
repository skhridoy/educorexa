<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Successful - {{ $school->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            padding: 30px 0;
        }
        .wrapper {
            max-width: 580px;
            margin: 0 auto;
        }
        .card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #002147 0%, #003d7a 100%);
            padding: 40px 40px 30px;
            text-align: center;
        }
        .school-logo {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 28px;
        }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 800; }
        .header .subtitle { color: rgba(255,255,255,0.65); font-size: 13px; margin-top: 4px; }
        .gold-bar { height: 4px; background: linear-gradient(90deg, #D4AF37, #f0d060, #D4AF37); }
        .body { padding: 40px; }
        .success-badge {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .success-badge .title {
            color: #166534;
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 6px;
        }
        .success-badge .desc {
            color: #15803d;
            font-size: 13px;
            line-height: 1.6;
        }
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 12px 16px;
            font-size: 13px;
            background: #f8fafc;
            border-radius: 8px;
        }
        .info-table td:first-child { color: #64748b; width: 40%; border-radius: 8px 0 0 8px; }
        .info-table td:last-child { color: #0f172a; font-weight: 600; border-radius: 0 8px 8px 0; }
        .divider { height: 1px; background: #f1f5f9; margin: 24px 0; }
        .warning-text { font-size: 13px; color: #64748b; line-height: 1.7; }
        .warning-text a { color: #002147; font-weight: 600; text-decoration: none; }
        .footer {
            background: #f8fafc;
            padding: 22px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p { color: #94a3b8; font-size: 12px; line-height: 1.7; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                @if($school->logo)
                    <div class="school-logo">
                        <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}" style="max-width: 50px; max-height: 50px; object-fit: contain; border-radius: 8px;">
                    </div>
                @else
                    <div class="school-logo">🏫</div>
                @endif
                <h1>{{ $school->name }}</h1>
                <p class="subtitle">Password Reset Confirmation</p>
            </div>
            <div class="gold-bar"></div>

            <div class="body">
                <p style="color: #0f172a; font-size: 15px; margin-bottom: 20px;">Hello <strong>{{ $user->name }}</strong>,</p>

                <div class="success-badge">
                    <div class="title">✅ Password Reset Successful!</div>
                    <div class="desc">
                        Your account password for <strong>{{ $school->name }}</strong> has been successfully updated.
                        You can now log in using your new password.
                    </div>
                </div>

                <table class="info-table">
                    <tr>
                        <td>Account Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>School</td>
                        <td>{{ $school->name }}</td>
                    </tr>
                    <tr>
                        <td>Date & Time</td>
                        <td>{{ now()->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>

                <div class="divider"></div>

                <p class="warning-text">
                    ⚠️ If you did <strong>not</strong> reset your password, please contact your school administrator immediately.
                </p>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} {{ $school->name }}. All rights reserved.<br>
                    This is an automated security notification. Please do not reply to this email.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
