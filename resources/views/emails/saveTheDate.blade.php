@component('mail::message')

<div class="header">
	<img src="{{ asset('/images/emails/save_the_dates/mill-barn-pink.png') }}">
	<p class="title">The Jinks Wedding</p>
</div>

<p class="subtitle">Save The Date</p>

<div class="normal-text">
	<p>{{ $greeting }},</p>
	<p>Please find attached a Save The Date to our wedding</p>
</div>

@component('mail::button', ['url' => url('save_the_date/seen/'.$code)])
Mark this as seen
@endcomponent

Thanks,<br>
The Happy Couple

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
