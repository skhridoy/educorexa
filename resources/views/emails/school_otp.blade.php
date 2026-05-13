<!DOCTYPE html>
<html>
<head>
    <title>OTP for Password Reset - {{ $school->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #002147;
            margin: 0;
            font-size: 24px;
        }
        .content {
            color: #4a4a4a;
            line-height: 1.6;
            text-align: center;
        }
        .otp-container {
            margin: 30px 0;
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #e2e8f0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #002147;
            letter-spacing: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($school->logo)
                <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}" style="max-width: 150px; margin-bottom: 10px;">
            @endif
            <h1>{{ $school->name }}</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account at {{ $school->name }}.</p>
            <p>Please use the following One-Time Password (OTP) to proceed with your password reset:</p>
            
            <div class="otp-container">
                <span class="otp-code">{{ $otp }}</span>
            </div>
            
            <p>This OTP is valid for 10 minutes only.</p>
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>Regards,<br>{{ $school->name }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $school->name }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

