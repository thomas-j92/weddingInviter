@extends('admin.inc.template')

@section('content')
	<h2>Create Invite</h2>

	<h3>Guests</h3>
	<div class="row">
		<div class="col-sm-12 invite-guest">
			<p>{{ $person->first_name }} {{ $person->last_name }}</p>
		</div>
		<div class="col-sm-12">
			<button type="button" data-target="#addGuest" data-toggle="modal" class="btn btn-primary">Add Guest +</button>
		</div>
	</div>

	@component('components.modal')
		@slot('id', 'addGuest')
		@slot('title', 'Add Guest')
		@slot('form_url', url('/Invite/add_guest'))
		
		<input type="hidden" class="where-val" name="id">
	@endcomponent
@endsection