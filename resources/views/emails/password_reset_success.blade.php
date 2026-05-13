<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Successful - EduCorexa</title>
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
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header h1 span { color: #D4AF37; }
        .success-icon {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 32px;
        }
        .body {
            padding: 40px;
        }
        .alert-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .alert-box .icon { font-size: 20px; margin-top: 2px; }
        .alert-box .text { color: #166534; font-size: 14px; line-height: 1.6; }
        .alert-box .text strong { display: block; font-size: 15px; margin-bottom: 4px; }
        .info-row {
            background: #f8fafc;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        .info-row .label { color: #64748b; }
        .info-row .value { color: #0f172a; font-weight: 600; }
        .divider {
            height: 1px;
            background: #f1f5f9;
            margin: 24px 0;
        }
        .warning-text {
            font-size: 13px;
            color: #64748b;
            line-height: 1.7;
        }
        .warning-text a {
            color: #002147;
            font-weight: 600;
            text-decoration: none;
        }
        .footer {
            background: #f8fafc;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
        }
        .footer strong { color: #64748b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <div class="success-icon">✅</div>
                <h1>Edu<span>Corexa</span></h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-top: 6px;">Password Reset Confirmation</p>
            </div>

            <div class="body">
                <p style="color: #0f172a; font-size: 15px; margin-bottom: 20px;">Hello <strong>{{ $user->name }}</strong>,</p>

                <div class="alert-box">
                    <div class="icon">🔐</div>
                    <div class="text">
                        <strong>Your password has been reset successfully!</strong>
                        Your EduCorexa account password was changed. You can now log in with your new password.
                    </div>
                </div>

                <div class="info-row">
                    <span class="label">Account Email</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Reset Date & Time</span>
                    <span class="value">{{ now()->format('d M Y, h:i A') }}</span>
                </div>

                <div class="divider"></div>

                <p class="warning-text">
                    ⚠️ If you did <strong>not</strong> make this change, your account may be compromised.
                    Please contact our support team immediately at
                    <a href="mailto:support@educorexa.com">support@educorexa.com</a>.
                </p>
            </div>

            <div class="footer">
                <p>
                    <strong>EduCorexa</strong> &mdash; Smart School Management Platform<br>
                    &copy; {{ date('Y') }} EduCorexa. All rights reserved.<br>
                    This is an automated email, please do not reply.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
