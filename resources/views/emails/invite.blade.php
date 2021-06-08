@component('mail::message')

<div class="header">
	<img src="{{ asset('/images/emails/save_the_dates/mill-barn-pink.png') }}">
	<p class="title">The Jinks Wedding</p>
</div>

<p class="subtitle">It's a nice day, for a... JINKS WEDDING</p>

<div class="normal-text">
	<p>Dear {{ $name }},</p>
	<p>As a person, we think you're alright. As such, please find attached an Invite to our wedding</p>
</div>

@component('mail::button', ['url' => URL('invitation/'.$code.'/view')])
Click here to RSVP
@endcomponent

<div class="normal-text">
	Thanks,<br>
	The Happy Couple
</div>

<style>
	.header img {
		margin: 0 auto;
		width: 4em;
		height: 4em;
	}
	.header .title {
		color: #db928a;
		text-align: center;
		font-size: 1.3em;
		margin-top: 0.7em;
		margin-bottom: 0;
	}
	.subtitle {
		color: #b5b5b5;
		font-size: 1.4em;
		text-align: center;
		margin-top: 1em;
	}
	.normal-text {
		text-align: center;
		padding: 1em 2em;
	}
</style>


@endcomponent