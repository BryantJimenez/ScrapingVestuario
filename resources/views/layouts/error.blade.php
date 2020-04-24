<!DOCTYPE html>
<html lang="es" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link rel="icon" href="{{ asset('/auth/images/icons/favicon.ico') }}" type="image/x-icon" />
	<title>@yield('title')</title>
	<meta name="author" content="">

	<link href="{{ asset('/admins/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/admins/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('/admins/css/error-pages.css') }}" rel="stylesheet">
	<link href="{{ asset('/admins/css/colors/default-dark.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="fix-header card-no-border fix-sidebar">

	<section id="wrapper" class="error-page">
		<div class="error-box">

			@yield('content')

		</div>
	</section>

	<script src="{{ asset('/admins/js/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/popper.min.js') }}"></script>
	<script src="{{ asset('/admins/js/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/admins/js/waves.js') }}"></script>
</body>
</html>