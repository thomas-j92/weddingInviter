<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid under_construction">
        	<div class="row">
	            <div class="col-6 left-section">
	            	<div class="couple-image"></div>
	            </div>
	            <div class="col-6 right-section">

					<h1>The Jinks Wedding</h1>

	            	<h2>Under construction</h2>

	            	<p>This website is currently under going construction.</p>

	            	<h2>FAQs</h2>

	            	<h3>When will the site go live?</h3>
	            	<p>How long is a piece of string? Seriously though, I'm hoping by the start of 2021. I know you're all sitting on the edge of your seat to see it</p>

	            	<h3>How can I RSVP?</h3>
	            	<p>This will all be done via this site. Failure to do so will ultimately lead to persistent mental torture, through the delightful process of email reminders</p>
	            </div>
            </div>
        </div>
    </body>
</html>