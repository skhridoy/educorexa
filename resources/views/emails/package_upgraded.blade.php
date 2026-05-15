<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
        .content { margin-bottom: 30px; }
        .package-card { background: #f8fafc; padding: 20px; border-radius: 10px; border-left: 5px solid #4f46e5; }
        .footer { text-align: center; font-size: 12px; color: #64748b; }
        .btn { display: inline-block; padding: 12px 25px; background: #4f46e5; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">EduCorexa</div>
            <h2>Subscription Upgraded!</h2>
        </div>
        <div class="content">
            <p>Dear Administrator,</p>
            <p>We are pleased to inform you that your school, <strong>{{ $school->name }}</strong>, has been upgraded to a new subscription plan.</p>
            
            <div class="package-card">
                <h3 style="margin-top: 0; color: #1e293b;">{{ $package->name }} Plan</h3>
                <p><strong>Price:</strong> ৳{{ number_format($package->price, 2) }} / {{ ucfirst($package->duration) }}</p>
                <p><strong>Student Limit:</strong> {{ $package->student_limit ?: 'Unlimited' }}</p>
                <p><strong>Teacher Limit:</strong> {{ $package->teacher_limit ?: 'Unlimited' }}</p>
            </div>

            <p style="margin-top: 20px;">You can now access all the features and modules included in this plan. Log in to your school portal to see the changes.</p>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('school.login.form', ['tenant' => $school->slug]) }}" class="btn">Login to Portal</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} EduCorexa. All rights reserved.</p>
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>
