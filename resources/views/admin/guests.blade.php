@extends('admin.inc.template')

@section('title', "Guests - $title")

@section('content')
	<h1 class="main-title">{{ $title }}</h1>
	@if(isset($guests))
		<table>
			<thead>
				<tr>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				@foreach($guests as $guest)
					<tr>
						<td>{{ $guest->first_name }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="error-container">
			<h2>I sense a disturbance in the force!</h2>
			<p>Sorry buddy, an error occurred.</p>
		</div>
	@endif

	<script>
		$(document).ready( function () {
	    	$('table').DataTable();
		});
	</script>
@stop