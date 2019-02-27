<!doctype html>
<html>
<head>
	<title>WeddingInviter - @yield('title')</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
	
	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
	<!-- End of Datatables -->

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!-- End of Font Awesome -->

</head>

<body>
	<div id="background"></div>
	@include('admin.inc.nav')

	<div class="container main-container">
		<div class="message_container"></div>
		@yield('content')
	</div>
</body>