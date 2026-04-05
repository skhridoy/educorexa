
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php $school = app('currentSchool'); @endphp

    @if($school && $school->favicon)
        <link rel="icon" type="image/{{ pathinfo($school->favicon, PATHINFO_EXTENSION) }}" href="{{ asset($school->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
    @endif

    <title>{{ $school->name ?? 'EduOrbit School ERP' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts._css')
    <style>
        /* ১. সাইডবার ক্যাটাগরি/টাইটেল কালার (যেমন: MAIN, SCHOOL MANAGEMENT) */
        body.dark-mode .sidebar .sidebar-body .nav .nav-category {
            color: #8b949e !important; /* হালকা ধূসর রঙ যাতে ডার্ক ব্যাকগ্রাউন্ডে ফুটে ওঠে */
            margin-top: 15px;
        }

        /* ২. সার্চ বক্স ব্যাকগ্রাউন্ড এবং টেক্সট কালার */
        body.dark-mode .navbar .navbar-content .search-form .input-group .form-control {
            background-color: #1a253b !important; /* সাইডবারের চেয়ে সামান্য হালকা ডার্ক */
            color: #ffffff !important;
            border: 1px solid #2d3a54 !important;
        }

        /* ৩. সার্চ বক্সের আইকন কন্টেইনার */
        body.dark-mode .navbar .navbar-content .search-form .input-group .input-group-text {
            background-color: #1a253b !important;
            border: 1px solid #2d3a54 !important;
            color: #8b949e !important;
        }

        /* ৪. প্লেসহোল্ডার টেক্সট কালার (Search here...) */
        body.dark-mode .form-control::placeholder {
            color: #8b949e !important;
            opacity: 0.8;
        }

        /* ৫. সাইডবার লোগো/ব্র্যান্ড এরিয়া (Demo লেখাটি) */
        body.dark-mode .sidebar .sidebar-header .sidebar-brand {
            color: #ffffff !important;
        }
        
        /* ৬. সাইডবার মেনু আইকন কালার */
        body.dark-mode .sidebar .sidebar-body .nav .nav-item .nav-link i {
            color: #ced4da !important;
        }
        /* প্রফেশনাল থিম সুইচ */
        .theme-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }
        .theme-switch input { opacity: 0; width: 0; height: 0; }
        .slider-round {
            position: absolute; cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ddd; transition: .4s; border-radius: 34px;
            display: flex; align-items: center; justify-content: space-between; padding: 0 6px;
        }
        .slider-round:before {
            position: absolute; content: "";
            height: 20px; width: 20px; left: 3px; bottom: 3px;
            background-color: white; transition: .4s; border-radius: 50%; shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        input:checked + .slider-round { background-color: #6571ff; }
        input:checked + .slider-round:before { transform: translateX(24px); }

        /* ডার্ক মোড গ্লোবাল স্টাইল */
        body.dark-mode {
            background-color: #060c18 !important;
            color: #ced4da !important;
        }

        /* সাইডবার এবং হেডার ফিক্স */
        body.dark-mode .sidebar, 
        body.dark-mode .sidebar .sidebar-header,
        body.dark-mode .sidebar .sidebar-body,
        body.dark-mode .navbar,
        body.dark-mode .footer {
            background: #0c1427 !important;
            border-color: #1a253b !important;
            color: #ced4da !important;
        }

        body.dark-mode .sidebar .sidebar-body .nav .nav-item .nav-link,
        body.dark-mode .sidebar .sidebar-body .nav .nav-item.active .nav-link {
            color: #ced4da !important;
        }

        body.dark-mode .page-content,
        body.dark-mode .main-wrapper .page-wrapper {
            background: #060c18 !important;
        }

        body.dark-mode .card {
            background: #0c1427 !important;
            border: 1px solid #1a253b !important;
            color: #ffffff !important;
        }
        
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, 
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
        body.dark-mode .text-dark {
            color: #ffffff !important;
        }

        body.dark-mode .table, body.dark-mode .table td, body.dark-mode .table th {
            color: #ced4da !important;
            border-color: #1a253b !important;
        }
    </style>

    <script>
        // পেজ লোড হওয়ার আগেই থিম অ্যাপ্লাই (অ্যান্টি-ফ্ল্যাশ)
        if (localStorage.getItem("theme") === "dark") {
            document.documentElement.classList.add("dark-mode");
        }
    </script>
    @yield('customCSS')
</head>
<body class="{{ (isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') ? 'dark-mode' : '' }}">
    
    <div class="main-wrapper">
        @include('layouts.school.sidebar')
        <div class="page-wrapper">
            @include('layouts.school.header')
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>

     <!-- core:js -->
    <script src="{{ asset('../assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="{{ asset('../assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
	<script src="{{ asset('../assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{ asset('../assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('../assets/js/template.js') }}"></script>
	<!-- endinject -->

    <!-- Cropper Js  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
	<!-- Custom js for this page -->
	<script src="{{ asset('../assets/js/dashboard-dark.js') }}"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<!-- End custom js for this page -->
	 <!-- JS Files -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        // থিম টগল করার মেইন স্ক্রিপ্ট
        function toggleTheme() {
            const body = document.body;
            const themeSwitcher = document.getElementById('theme-switcher');
            
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                document.cookie = "theme=light; path=/";
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                document.cookie = "theme=dark; path=/";
            }
        }

        $(document).ready(function() {
            // পেজ লোড হওয়ার পর সুইচের পজিশন ঠিক করা
            if (localStorage.getItem('theme') === 'dark' || $('body').hasClass('dark-mode')) {
                $('#theme-switcher').prop('checked', true);
                $('body').addClass('dark-mode');
            }
        });
    </script>
    @yield('customJs')
</body>
</html>
