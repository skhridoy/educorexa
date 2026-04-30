<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="{{ $setting->meta_description ?? 'EduCorexa - The Most Reliable ERP Software for Schools' }}">
    <meta name="keywords" content="{{ $setting->meta_keywords ?? 'School ERP, Education Management Software, Smart School Solution' }}">
    <meta name="author" content="{{ $setting->site_name ?? 'EduCorexa' }}">
    <link rel="icon" type="image/x-icon" href="{{ asset($setting->favicon ?? 'frontend/img/favicon.ico') }}">
    
    {{-- টাইটেল সেকশন, যদি $setting না থাকে তবে ডিফল্ট নাম দেখাবে --}}    
    {{-- $setting ভেরিয়েবল না থাকলে ডিফল্ট নাম দেখাবে --}}
    <title>@yield('title', $setting->site_name ?? 'EduCorexa') - @yield('subtitle', $setting->meta_title ?? 'EduCorexa')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --primary-color: #4F46E5;
            --primary-light: #818CF8;
            --primary-dark: #3730A3;
            --secondary-color: #06B6D4;
            --bg-color: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #64748B;
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-color); 
            color: var(--text-main);
            overflow-x: hidden; 
        }
        h1, h2, h3, h4, h5, h6, .display-4, .display-6 {
            font-family: 'Outfit', sans-serif;
        }
        .frontend-content { min-height: 70vh; }
        
        /* Glassmorphism Classes */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }
        
        .shadow-lg-hover {
            transition: all 0.3s ease;
        }
        .shadow-lg-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.2) !important;
        }
        
        /* আইকন বক্স স্টাইল */
        .icon-circle {
            width: 60px; height: 60px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; margin: 0 auto 15px;
            background: rgba(101, 113, 255, 0.1);
            color: #6571ff;
            transition: all 0.3s ease;
        }
        .icon-circle:hover { background: #6571ff; color: #fff; }
        .icon-circle i { font-size: 24px; }
    </style>
    @stack('custom-css')
</head>

<body>
    @include('frontend.partials.navbar')

    <main class="frontend-content">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // আইকন রেন্ডার করার জন্য সেন্ট্রাল ফাংশন
        function initFeather() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            initFeather();
        });

        // যদি AJAX দিয়ে কন্টেন্ট লোড হয়, তবে এটি কাজে লাগবে
        window.addEventListener('load', initFeather);
    </script>
    @stack('custom-js')
</body>
</html>