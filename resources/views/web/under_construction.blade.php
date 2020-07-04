<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="api-base-url" content="{{ url('') }}" />

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
    	<div id="app">
	        <div class="container-fluid under_construction">
	        	<div class="row">
		            <div class="col-sm-12 col-md-6 left-section">
		            	<div class="couple-image">
		            		<countdown></countdown>

		            		<div id="cover"></div>
		            	</div>
		            </div>
		            <div class="col-sm-12 col-md-6 right-section">
						<h1 class="big-title fadeIn speed-1">The Jinks Wedding</h1>
						
						<img src="{{ url('images/web/under_construction/mill-barn-pink.png') }}" alt="The Mill Barns" id="mills-barns-logo" class="fadeIn speed-2">
						
						<div id="under-construction-text" class="fadeIn speed-3">
		            		<h2 class="sub-title">Under construction</h2>
		            		<p>This website is currently under going construction.</p>
		            	</div>
						
						<div id="faqs">
		            		<h2 class="sub-title fadeIn speed-4">FAQs</h2>
		            		<div class="faq fadeIn speed-5">
				            	<h3 class="mini-title">When will the site go live?</h3>
				            	<p>How long is a piece of string? Seriously though, I am hoping by the start of 2021. I know you are all sitting on the edge of your seat to see it</p>
				            </div>
							
							<div class="faq fadeIn speed-6">
				            	<h3 class="mini-title">How can I RSVP?</h3>
				            	<p>This will all be done via this site. Failure to do so will ultimately lead to persistent mental torture, through the delightful process of email reminders</p>
			            	</div>
		            	</div>
		            </div>
	            </div>
	        </div>
    	</div>
    </body>
</html>