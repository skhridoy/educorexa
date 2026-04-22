<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 10px; }
        .header { background: #0d6efd; color: #fff; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .credentials { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 5px solid #0d6efd; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
        .btn { display: inline-block; padding: 10px 20px; background: #0d6efd; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h3>Hello {{ $details['name'] }},</h3>
            <p>Your employee account has been successfully created. You can now log in to the system using the credentials below:</p>
            
            <div class="credentials">
                <p><strong>Login URL:</strong> <a href="{{ $details['url'] }}">{{ $details['url'] }}</a></p>
                <p><strong>Email ID:</strong> {{ $details['email'] }}</p>
                <p><strong>Password:</strong> {{ $details['password'] }}</p>
            </div>

            <p>For security reasons, we recommend you change your password after your first login.</p>
            <a href="{{ $details['url'] }}" class="btn" style="color: white;">Login Now</a>
        </div>
        <div class="footer">
            <p>This is an automated email from {{ config('app.name') }}. Please do not reply.</p>
        </div>
    </div>
</body>
</html>