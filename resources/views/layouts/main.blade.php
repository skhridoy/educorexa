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

    <!-- core:js -->
    <script src="{{ asset('../assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="{{ asset('../assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
	<script src="{{ asset('../assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
	<!-- End plugin js for this page -->

	<!-- Cropper Js  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

	<!-- inject:js -->
	<script src="{{ asset('../assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('../assets/js/template.js') }}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<script src="{{ asset('../assets/js/dashboard-dark.js') }}"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<!-- End custom js for this page -->
	 <!-- JS Files -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('customJs')
</body>
</html>
