@extends('admin.inc.template')

@section('title', "Guests - $title")

@section('content')
	<h1 class="main-title">{{ $title }}</h1>
	@if(isset($guests))
		@foreach($guests as $guest)
			<ul>
				<li>{{ $guest->first_name }}</li>
			</ul>
		@endforeach
	@else
		<div class="error-container">
			<h2>I sense a disturbance in the force!</h2>
			<p>Sorry buddy, an error occurred.</p>
		</div>
	@endif
@stop