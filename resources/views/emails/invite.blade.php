@extends('emails.inc.main')

@section('content')
<h2>Hi {{ $name }}</h2>
<p>Please find attached your invitation</p>
@component('mail::button', ['url' => URL('invitation/view/'.$code)])
View Invite
@endcomponent
@endsection