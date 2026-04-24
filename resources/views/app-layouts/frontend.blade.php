<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>{{ $setting->meta_title ?? ($setting->site_name ?? 'EduCorexa') }}</title>
    
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather-icons/feather.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #ffffff; }
        .frontend-content { min-height: 70vh; }
        
        /* আইকন বক্স স্টাইল (educorerp.in এর মতো) */
        .icon-circle {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px;
            background: rgba(101, 113, 255, 0.1);
            color: #6571ff;
        }
        .icon-circle i { font-size: 24px; }
    </style>
</head>

<body>
    @include('frontend.partials.navbar')

    <main class="frontend-content">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // এই কমান্ডটি ছাড়া আইকন কখনোই আসবে না
        feather.replace();
    </script>
    <script>
        // আইকন দেখানোর জন্য এই ফাংশনটি বাধ্যতামূলক
        function initIcons() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        // পেজ লোড হওয়ার পর আইকন রেন্ডার হবে
        window.addEventListener('load', function() {
            initIcons();
        });

        // ডকুমেন্ট রেডি হওয়ার পর আইকন রেন্ডার হবে (সেফটি চেক)
        document.addEventListener("DOMContentLoaded", function() {
            initIcons();
        });
    </script>
</body>
</html>