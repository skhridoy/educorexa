<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 30px; border-radius: 10px; background-color: #f9f9f9; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #4f46e5; margin: 0; }
        .details-box { background: white; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-row { display: flex; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 5px; }
        .label { font-weight: bold; width: 150px; color: #64748b; }
        .value { color: #1e293b; font-family: monospace; font-size: 1.1em; }
        .footer { text-align: center; margin-top: 40px; color: #94a3b8; font-size: 0.9em; }
        .btn { display: inline-block; padding: 10px 25px; background-color: #4f46e5; color: white !important; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Professional Email Setup</h1>
            <p>Congratulations! Your professional email account is ready.</p>
        </div>

        <p>Dear {{ $school->name }} Administrator,</p>
        <p>Your request for a professional email address has been approved. You can now use these credentials to configure your school's automated notifications in the API Setup menu.</p>

        <div class="details-box">
            <h3 style="margin-top: 0; color: #334155;">SMTP Configuration Details:</h3>
            
            <div class="detail-row">
                <div class="label">Email Address:</div>
                <div class="value">{{ $emailAddress }}</div>
            </div>
            
            <div class="detail-row">
                <div class="label">Password:</div>
                <div class="value">{{ $password }}</div>
            </div>
            
            <div class="detail-row">
                <div class="label">SMTP Host:</div>
                <div class="value">{{ $smtpDetails['host'] }}</div>
            </div>
            
            <div class="detail-row">
                <div class="label">Port:</div>
                <div class="value">{{ $smtpDetails['port'] }} (Use SSL)</div>
            </div>
            
            <div class="detail-row">
                <div class="label">Encryption:</div>
                <div class="value">{{ $smtpDetails['encryption'] }}</div>
            </div>
            
            <div class="detail-row">
                <div class="label">Mail Mailer:</div>
                <div class="value">{{ $smtpDetails['mailer'] }}</div>
            </div>
        </div>

        <p>To apply these settings, please log in to your dashboard and navigate to <strong>Settings > API Setup</strong>.</p>
        
        <div style="text-align: center;">
            <a href="https://{{ $school->slug }}.{{ config('app.main_domain') }}/login" class="btn">Login to Your Dashboard</a>
        </div>

        <div class="footer">
            <p>Thank you for using our School ERP system.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
