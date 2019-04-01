@extends('admin.inc.template')

@section('content')
	<h2>Invite</h2>

	<h3>Assigned Guests</h3>
	@if($invite->assignedGuests()->count() > 0)
		<table class="table">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Added On</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($invite->assignedGuests as $g)
					<tr>
						<td>{{ $g->person->first_name }}</td>
						<td>{{ $g->person->last_name }}</td>
						<td>{{ $g->created_at }} </td>
						<td>
							@if($invite->assignedGuests()->count() > 1)
								<a href="{{ URL('Invite/removeGuest/'.$g->person_id) }}">Remove</a>
							@endif
						</td>
					</tr>
				@endforeach
				<tr>
					<td class="text-center" colspan="4">
						<a href="" data-target="#assignGuest" data-toggle="modal">Assign Guest</a>
					</td>
				</tr>
			</tbody>
		</table>
	@endif

	@component('components.modal')
		@slot('id', 'assignGuest')
		@slot('title', 'Assign Guest to Invite')
		@slot('form_url', url('/Invite/assignGuestToInvite'))
		
		<div class="row text-center">
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-lg">Existing Guest</button>
			</div>
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-lg">New Guest</button>
			</div>
		</div>

		<div class="row" id="existing-guest-container">
			<div class="col-sm-12">
				<h5>Existing Guest</h5>
			</div>
			
			<div class="col-sm-12">
			<input type="text" name="guest-search">
			<div class="search_results"></div>
			</div>
		</div>
	
		<div id="new-guest-container">
			
		</div>
		
		<input type="hidden" class="where-val" name="id">
	@endcomponent
@endsection