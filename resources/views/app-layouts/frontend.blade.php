<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="eoLqsNruvR1AE3AKJLgPKIemPNHHjhwn8OLrGHyvQyk" />
    <meta name="description" content="{{ $setting->meta_description ?? 'EduCorexa - The Most Reliable ERP Software for Schools' }}">
    <meta name="keywords" content="{{ $setting->meta_keywords ?? 'School ERP, Education Management Software, Smart School Solution' }}">
    <meta name="author" content="{{ $setting->site_name ?? 'EduCorexa' }}">
    <link rel="icon" type="image/x-icon" href="{{ asset($setting->favicon ?? 'frontend/img/favicon.ico') }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
    {{-- টাইটেল সেকশন, যদি $setting না থাকে তবে ডিফল্ট নাম দেখাবে --}}    
    {{-- $setting ভেরিয়েবল না থাকলে ডিফল্ট নাম দেখাবে --}}
    <title>@yield('title', $setting->site_name ?? 'EduCorexa') - @yield('subtitle', $setting->meta_title ?? 'EduCorexa')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;600&amp;family=Noto+Sans+Bengali:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "surface-container": "#eaedff",
                "on-tertiary": "#ffffff",
                "outline-variant": "#c7c4d7",
                "on-secondary-fixed-variant": "#004395",
                "surface-tint": "#494bd6",
                "on-error-container": "#93000a",
                "secondary": "#0058be",
                "outline": "#767586",
                "primary-container": "#6063ee",
                "on-primary-fixed": "#07006c",
                "inverse-surface": "#283044",
                "tertiary": "#8127cf",
                "surface-container-highest": "#dae2fd",
                "secondary-container": "#2170e4",
                "background": "#faf8ff",
                "on-tertiary-container": "#fffbff",
                "surface": "#faf8ff",
                "tertiary-fixed-dim": "#ddb7ff",
                "secondary-fixed": "#d8e2ff",
                "error": "#ba1a1a",
                "on-error": "#ffffff",
                "on-primary-fixed-variant": "#2f2ebe",
                "surface-variant": "#dae2fd",
                "primary-fixed-dim": "#c0c1ff",
                "on-secondary": "#ffffff",
                "on-tertiary-fixed-variant": "#6900b3",
                "surface-dim": "#d2d9f4",
                "on-primary-container": "#fffbff",
                "tertiary-fixed": "#f0dbff",
                "primary-fixed": "#e1e0ff",
                "inverse-on-surface": "#eef0ff",
                "error-container": "#ffdad6",
                "primary": "#4648d4",
                "tertiary-container": "#9c48ea",
                "surface-bright": "#faf8ff",
                "secondary-fixed-dim": "#adc6ff",
                "on-background": "#131b2e",
                "on-tertiary-fixed": "#2c0051",
                "on-surface-variant": "#464554",
                "on-secondary-fixed": "#001a42",
                "on-surface": "#131b2e",
                "on-secondary-container": "#fefcff",
                "inverse-primary": "#c0c1ff",
                "surface-container-lowest": "#ffffff",
                "surface-container-high": "#e2e7ff",
                "on-primary": "#ffffff",
                "surface-container-low": "#f2f3ff"
            },
            "borderRadius": {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            "spacing": {
                "gutter": "24px",
                "section-gap": "120px",
                "margin-desktop": "64px",
                "container-max": "1280px",
                "unit": "8px"
            },
            "fontFamily": {
                "label-sm": ["Inter", "Noto Sans Bengali", "sans-serif"],
                "headline-lg": ["Manrope", "Noto Sans Bengali", "sans-serif"],
                "headline-md": ["Manrope", "Noto Sans Bengali", "sans-serif"],
                "body-lg": ["Inter", "Noto Sans Bengali", "sans-serif"],
                "display-xl": ["Manrope", "Noto Sans Bengali", "sans-serif"],
                "body-md": ["Inter", "Noto Sans Bengali", "sans-serif"],
                "sans": ["Inter", "Noto Sans Bengali", "sans-serif"]
            },
            "fontSize": {
                "label-sm": ["14px", {"lineHeight": "20px", "fontWeight": "600"}],
                "headline-lg": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                "display-xl": ["60px", {"lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "800"}],
                "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
        /* Font fallback for Bengali using Noto Sans Bengali (web font) */
        body, p, span:not(.material-symbols-outlined), div, a, li, td, th, label, input, button {
            font-family: 'Inter', 'Noto Sans Bengali', sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Manrope', 'Noto Sans Bengali', sans-serif !important;
        }
        
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid #E2E8F0;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #4648d4 0%, #8127cf 100%);
        }
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