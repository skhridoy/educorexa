<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site->site_name ?? 'EduCorexa' }} - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
    
    @php $site = DB::table('site_settings')->first(); @endphp
    <link rel="shortcut icon" href="{{ asset($site->favicon ?? 'assets/images/favicon.png') }}" />
    
    <style>
        /* Font fallback for Bengali using Noto Sans Bengali (web font) */
        body, p, span, div, a, li, td, th, label, input, button {
            font-family: 'Roboto', 'Noto Sans Bengali', sans-serif !important;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
</body>
</html>