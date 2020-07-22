<!doctype html>
<html>
<head>
	<title>WeddingInviter - @yield('title')</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="api-base-url" content="{{ url('') }}" />
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!-- End of Font Awesome -->
</head>

<body>
	<div id="background"></div>

	<div class="container-fluid p-0">
		
		<div id="app">
			<router-view></router-view>
		</div>
	
	</div>

	<div class="container main-container" style="display: none;">
		<div class="message_container">
			@if(session('success'))
				@component('components.messages')
					@slot('type', 'success')
					@slot('message', session('success'))
				@endcomponent
			@endif
			@if(session('error'))
				@component('components.messages')
					@slot('type', 'danger')
					@slot('message', session('error'))
				@endcomponent
			@endif
		</div>
		<div class="content-container">
			@if(isset($breadcrumbs))
				@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				@endcomponent
			@endif
			<div id="app2">
				@yield('content')
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
	<!-- End of Datatables -->
</body>