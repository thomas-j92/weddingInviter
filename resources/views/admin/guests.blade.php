@extends('admin.inc.template')

@section('title', "Guests - $title")

@section('content')
	<h1 class="main-title">{{ $title }}</h1>
	@if(isset($guests))
		<table class="table">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<td></td>
				</tr>
			</thead>
			<tbody>
				@foreach($guests as $guest)
					<tr>
						<td>{{ $guest->first_name }}</td>
						<td>{{ $guest->last_name }}</td>
						<td>
							<div class="dropdown">
							  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <i class="fas fa-cog"></i>
							  </button>
							  <div class="dropdown-menu extra-options" aria-labelledby="dropdownMenuButton">
							    <a class="dropdown-item" data-toggle="modal" data-get='{{ url("People/get_ajax/$guest->id") }}' data-target="#editGuest"><i class="fas fa-edit"></i> Quick Edit</a>
							    <a class="dropdown-item" href='{{ url("People/edit/$guest->id") }}' target="_blank"><i class="fas fa-edit"></i> Edit</a>
							  </div>
							</div>
						</td>
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

	@component('components.modal')
		@slot('id', 'editGuest')
		@slot('title', 'Quick Edit')
		@slot('form_url', url('/People/quick_edit'))
		
		<input type="hidden" class="where-val" name="id">
		<div class="row">
			<div class="col-sm-4">
				<p>First Name</p>
			</div>
			<div class="col-sm-8">
				<input type="text" class="full-width update-val" name="first_name" placeholder="First name...">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<p>Last Name</p>
			</div>
			<div class="col-sm-8">
				<input type="text" class="full-width update-val" name="last_name" placeholder="Last name...">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<p>Email</p>
			</div>
			<div class="col-sm-8">
				<input type="text" class="full-width update-val" name="email" placeholder="Email...">
			</div>
		</div>
	@endcomponent

	<script>
		$(document).ready( function () {
	    	$('table').DataTable();
		});
	</script>
@stop