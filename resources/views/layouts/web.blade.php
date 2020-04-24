<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>

	<link rel="stylesheet" href="{{ asset('/web/css/open-iconic-bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/web/css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('/admins/vendors/lobibox/Lobibox.min.css') }}">

	<link rel="stylesheet" href="{{ asset('/web/css/ionicons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/web/css/flaticon.css') }}">
	<link rel="stylesheet" href="{{ asset('/web/css/icomoon.css') }}">
	<link rel="stylesheet" href="{{ asset('/web/css/style.css') }}">

	@yield('links')
</head>
<body class="goto-here">

	@yield('content')

	@include('admin.partials.footer')
	@include('admin.partials.loader')

	<script src="{{ asset('/web/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/web/js/jquery-migrate-3.0.1.min.js') }}"></script>
	<script src="{{ asset('/web/js/popper.min.js') }}"></script>
	<script src="{{ asset('/web/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/web/vendors/lobibox/Lobibox.js') }}"></script>
	<script src="{{ asset('/web/vendors/jquery-load-scroll/jQuery.loadScroll.js') }}"></script>

	<script src="{{ asset('/web/js/jquery.easing.1.3.js') }}"></script>
	<script src="{{ asset('/web/js/jquery.waypoints.min.js') }}"></script>
	@yield('script')
	<script src="{{ asset('/web/js/main.js') }}"></script>
	@include('admin.partials.notifications')
</body>
</html>