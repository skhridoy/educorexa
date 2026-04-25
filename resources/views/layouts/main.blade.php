<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    
	<link href="{{ $setting && $setting->favicon ? asset('storage/' . $setting->favicon) : asset('frontend/img/favicon.ico') }}" rel="icon">
    <title>@yield('title', 'Super Admin Dashboard')</title>

    <!-- Fonts -->
    @include('layouts._css')
	<style>
		/* নোটিফিকেশন ড্রপডাউনটি ডান দিক থেকে এলাইন হবে */
		.dropdown-menu-end {
			right: 0 !important;
			left: auto !important;
		}

		/* টেক্সট যদি ২ লাইনের বেশি হয় তবে ডট ডট (...) দেখাবে */
		.text-truncate-2 {
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
			white-space: normal;
			line-height: 1.4;
			font-size: 0.9rem;
		}

		/* আইকন সার্কেল সাইজ */
		.icon-circle {
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
		}

		/* ড্রপডাউন আইটেম হোভার এফেক্ট */
		.dropdown-item:hover {
			background-color: #f8f9fc;
		}

		.notification-content {
			width: 100%;
		}

		/* রেসপনসিভ হ্যান্ডেলিং */
		@media (max-width: 576px) {
			.notification-dropdown {
				width: 300px !important;
				position: fixed !important;
				top: 60px !important;
				right: 10px !important;
			}
		}
		@media (max-width: 767.98px) {
    /* মেইন কন্টেইনার অ্যাডজাস্টমেন্ট: হালকা ধূসর ব্যাকগ্রাউন্ড */
    .table-responsive-custom {
        padding: 15px !important;
        background-color: #f6f8fb;
        border: none !important;
    }

    /* ডিফল্ট টেবিল ব্যাকগ্রাউন্ড রিমুভ */
    .custom-mobile-table {
        background-color: transparent !important;
    }

    /* কার্ড ডিজাইন: আরও ছোট উইডথ এবং মাঝখানে এলাইনমেন্ট */
    .custom-mobile-table tbody tr {
        display: block;
        width: 100%; /* কার্ড স্ক্রিনের ৯০% জায়গা নিবে */
        margin: 0 auto 15px auto; /* কার্ড মাঝখানে থাকবে এবং নিচে গ্যাপ থাকবে */
        background: #ffffff;
        border: none !important;
        border-radius: 5px; /* হালকা রাউন্ডেড কর্নার */
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04); /* একদম হালকা প্রিমিয়াম শ্যাডো */
        overflow: hidden;
    }

    /* প্রতিটি সেলের ডিজাইন */
    .custom-mobile-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px !important; /* আরও কম এবং ক্লিন প্যাডিং */
        border-bottom: 1px solid #f1f4f8 !important;
    }

    /* লেবেল ডিজাইন: আরও ছোট ও হালকা */
    .custom-mobile-table tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 10px; /* ফন্ট ছোট করা হয়েছে */
        letter-spacing: 0.5px;
        color: #adb5bd; /* হালকা কালার যেন লেবেল কম গুরুত্ব পায় */
        flex: 0 0 35%; /* লেবেল এরিয়া ফিক্সড */
        text-align: left;
    }

    /* ডেটা ডিজাইন: ফন্ট অ্যাডজাস্টমেন্ট */
    .school-name-text {
        font-size: 12px; /* ফন্ট কিছুটা ছোট */
        font-weight: 700;
        color: #6b6868;
        word-break: break-word; /* নাম বড় হলে নিচে নামবে */
        text-align: right;
        width: 100%;
    }

    /* ইমেইল ও ডোমেইন ছোট ফন্টে */
    .custom-mobile-table tbody td:nth-child(2),
    .custom-mobile-table tbody td:nth-child(3),
    .custom-mobile-table tbody td:nth-child(4) {
        font-size: 13px;
        color: #666;
    }

    /* অ্যাকশন বাটন এরিয়া */
    .custom-mobile-table tbody td:last-child {
        background: #fdfdfd;
        padding: 10px 15px !important;
        border-bottom: none !important;
    }
}
	</style>
	@yield('customCSS')
</head>
<body>
	<div class="main-wrapper">
		<!-- partial:partials/_sidebar.html -->
        @include('layouts.super.sidebar')
		<!-- partial -->
	
		<div class="page-wrapper">
					
			<!-- partial:partials/_navbar.html -->
			@include('layouts.super.header')
			<!-- partial -->

			@yield('content')

			<!-- partial:partials/_footer.html -->
			@include('layouts.footer')
			<!-- partial -->
		
		</div>
			
	</div>

    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    @stack('plugin-scripts') {{-- এখানে প্লাগইন স্ক্রিপ্টগুলো আসবে --}}
    <script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-dark.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('customJs')
	@stack('customJs')
</body>
</html>
