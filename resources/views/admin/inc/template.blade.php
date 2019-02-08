<!doctype html>
<html>
<head>
	<title>WeddingInviter - @yield('title')</title>

	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</head>

<body>
	@include('admin.inc.nav')

	<div class="container">
		@yield('content')
	</div>
</body>