<!DOCTYPE html>
<html>
<head>
    <title>{{ $subject }}</title>
</head>
<body>
    <h2>{{ $school->name }}</h2>
    <p>{!! nl2br(e($message)) !!}</p>
    <br>
    <hr>
    <h1 style="font-size: 14px; color: #1af658; text-align: center;">Thanks For Subscribing Our Newsletter</h1>
    <p style="font-size: 12px; color: #777;">
        You are receiving this email because you subscribed to our newsletter at {{ $school->name }}.
    </p>
</body>
</html>