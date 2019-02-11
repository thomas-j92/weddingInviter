<!doctype html>
<html>
<head>
	<title>WeddingInviter - @yield('title')</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</head>

<body>
	<div id="background"></div>
	@include('admin.inc.nav')

	<div class="container main-container">
		@yield('content')
	</div>
</body>