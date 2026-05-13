<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .school-name { color: #4f46e5; font-size: 24px; font-weight: bold; }
        .notice-title { font-size: 20px; font-weight: bold; margin-bottom: 10px; color: #1e293b; }
        .notice-date { color: #64748b; font-size: 14px; margin-bottom: 20px; }
        .content { margin-bottom: 30px; }
        .footer { text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #eee; padding-top: 10px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="school-name">{{ $school->name }}</div>
        </div>
        <div class="notice-title">{{ $notice->title }}</div>
        <div class="notice-date">Date: {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }}</div>
        
        <div class="content">
            {!! nl2br(e($notice->description)) !!}
        </div>

        @if($notice->file)
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ url($notice->file) }}" class="btn">View Attached Document</a>
            </div>
        @endif

        <div class="footer">
            &copy; {{ date('Y') }} {{ $school->name }}. All rights reserved.
        </div>
    </div>
</body>
</html>
