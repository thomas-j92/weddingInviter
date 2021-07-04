@component('mail::message')

<div class="header">
	<img src="{{ asset('/images/emails/save_the_dates/mill-barn-pink.png') }}">
	<p class="title">The Jinks Wedding</p>
</div>

<p class="subtitle">Thanks for letting us know</p>

@component('mail::table')
| Guest | Day | Night |
| -- |:----:| -----:|
@foreach($guests as $guest)
  | {{ $guest->person->first_name }} {{ $guest->person->last_name }} | {{ ($guest->rsvp && $guest->attending_day) ? 'Attending' : 'Not Attending' }} | {{ ($guest->rsvp && $guest->attending_night) ? 'Attending' : 'Not Attending' }}  |
@endforeach
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