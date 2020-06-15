@component('mail::message', [
	'showHeader' => (isset($showHeader)) ? $showHeader : true,
	'showFooter' => (isset($showFooter)) ? $showFooter : true
])

	@yield('content')

@endcomponent