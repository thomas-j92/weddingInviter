<p class="breadcrumbs">
	@foreach($breadcrumbs as $title => $link)
		<span class="{{ $loop->last ? 'last-crumb' : '' }}">
			<a href="{{ $link }}">{{ $title }}</a>
			@if (!$loop->last)
			/
			@endif
		</span>
	@endforeach
</p>