@extends('admin.inc.template')

@section('content')
<h2>Edit</h2>


<div class="row">
	<div class="col-sm-12">
		<h3>General Information</h3>
	</div>
	<div class="col-sm-6">
		<form action="{{ url('/People/edit_submit') }}" method="post">
			@csrf
			<input type="hidden" name="person_id" value="{{ $person_id }}">
			<div class="row">
				<div class="col-sm-4">
					First Name
				</div>
				<div class="col-sm-8">
					<input type="text" name="first_name" value="{{ $person->first_name }}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					Last Name
				</div>
				<div class="col-sm-8">
					<input type="text" name="last_name" value="{{ $person->last_name }}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					Email
				</div>
				<div class="col-sm-8">
					<input type="text" name="email" value="{{ $person->email }}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<input type="submit" class="button" name="Update Details">
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h3>Invite</h3>
	</div>
	<div class="col-sm-12">
		@isset($invite)
			<table>
				<thead>
					<tr>
						<th>Created</th>
						<th>Sent on</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $invite->created_at }}</td>
						<td><a href="{{ url('/Invite/view/'.$invite->id) }}">View</a></td>
					</tr>
				</tbody>
			</table>
		<p>invite found</p>
		@else:
		<p>No invite has been setup for this person. But don't worry, child. You can <a href="{{ url('/Invite/create/'.$person_id) }}">setup an invite</a> here.</p>
		@endisset
	</div>
</div>

@endsection