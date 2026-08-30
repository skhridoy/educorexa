<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Account Credentials</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding: 40px 0;
        }
        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 36px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 8px 0 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
        }
        .school-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .content {
            padding: 32px 30px;
        }
        .greeting {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .credentials-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
        }
        .cred-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .cred-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .cred-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .cred-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            font-family: 'Courier New', Courier, monospace;
            background: #ffffff;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }
        .btn-login {
            display: block;
            width: 100%;
            box-sizing: border-box;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff !important;
            text-align: center;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            margin: 28px 0 16px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
        }
        .security-notice {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.5;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer strong {
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-card">
            {{-- Header --}}
            <div class="header">
                <div class="school-badge">{{ $school->name }}</div>
                <h1>Welcome to Teacher Portal</h1>
                <p>Your official instructor account has been created successfully</p>
            </div>

            {{-- Content --}}
            <div class="content">
                <div class="greeting">
                    Dear <strong>{{ $teacher->name }}</strong>,<br>
                    You have been registered as an instructor at <strong>{{ $school->name }}</strong>. Below are your account login credentials to access the teacher management dashboard:
                </div>

                {{-- Credentials Table --}}
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;padding:16px 20px;margin:20px 0;">
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;">Teacher ID:</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;text-align:right;font-size:14px;font-weight:700;color:#4f46e5;">{{ $teacher->teacher_id }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;">Login Email:</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;text-align:right;font-size:14px;font-weight:700;color:#1e293b;">{{ $teacher->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;">Default Password:</td>
                        <td style="padding:8px 0;border-bottom:1px solid #e2e8f0;text-align:right;font-size:14px;font-weight:700;color:#ef4444;font-family:monospace;">{{ $password }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;">Assigned Role:</td>
                        <td style="padding:8px 0;text-align:right;font-size:14px;font-weight:700;color:#10b981;">Teacher</td>
                    </tr>
                </table>

                {{-- Action Button --}}
                <div style="text-align:center;">
                    <a href="{{ $loginUrl }}" class="btn-login">
                        Log In to Teacher Dashboard &rarr;
                    </a>
                </div>

                {{-- Security Alert --}}
                <div class="security-notice">
                    <strong>🔒 Security Recommendation:</strong> Please change your default password immediately after your first login by navigating to your Profile Settings.
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p style="margin: 0 0 6px 0;">This email was sent automatically from <strong>{{ $school->name }}</strong>.</p>
                @if($school->pro_email_address || $school->email)
                    <p style="margin: 0 0 4px 0;">Official Email: {{ $school->pro_email_address ?: $school->email }}</p>
                @endif
                @if($school->phone)
                    <p style="margin: 0 0 4px 0;">Phone: {{ $school->phone }}</p>
                @endif
                @if($school->address)
                    <p style="margin: 0 0 10px 0;">Address: {{ $school->address }}</p>
                @endif
                <p style="margin: 10px 0 0 0; font-size: 11px; color: #cbd5e1;">&copy; {{ date('Y') }} {{ $school->name }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
