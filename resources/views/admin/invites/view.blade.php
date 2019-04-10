@extends('admin.inc.template')

@section('title', 'Invite')

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
		{{-- @slot('form_url', url('/Invite/assignGuestToInvite')) --}}
		

		<div class="row text-center" id="guest-type-container">
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-lg" data-click-show="existing-guest-container" data-click-hide="guest-type-container">Existing Guest</button>
			</div>
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-lg" data-click-show="new-guest-container" data-click-hide="guest-type-container">New Guest</button>
			</div>
		</div>

		<form action="{{ url('/Invite/assignGuestToInvite') }}" method="POST">
			@csrf
			<input type="hidden" name="invite_id" value="{{ $invite->id }}">
			<div class="row hidden guest-type" id="existing-guest-container">
				<div class="col-sm-12">
					<a class="back-btn">Back</a>
				</div>

				<div class="col-sm-12">
					<h5>Existing Guest</h5>
				</div>
				
				<div class="col-sm-12">
					@component('components.person-search')
					@endcomponent
				</div>
			</div>
		</form>
	
		<div class="row hidden guest-type" id="new-guest-container">
			<div class="col-sm-12">
				<a class="back-btn">Back</a>
			</div>

			<div class="col-sm-12">
				<h5>New Guest</h5>
			</div>

			<div class="col-sm-12">
				<form action="{{ url('Invite/AssignNewPerson') }}" method="POST">
					@csrf
					<input type="hidden" name="invite_id" value="{{ $invite->id }}">
					
					@component('components.person-new')
					@endcomponent

					<input type="submit" value="Add & Assign">
				</form>
			</div>
		</div>
		
		<input type="hidden" class="where-val" name="id">
	@endcomponent
@endsection