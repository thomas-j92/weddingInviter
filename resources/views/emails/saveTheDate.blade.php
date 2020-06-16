@extends('emails.inc.main', ['showHeader' => false, 'showFooter' => false])

@section('header')
	panel
@endsection

@section('content')

	<div class="email-container">
		<div class="email-row blue-bg" id="std-header">
			<div class="email-col email-col-6">
				<p>We're getting married</p>

			</div>
			<div class="email-col email-col-6">
				<p>Jessica & Thomas</p>
			</div>
		</div>

		<div class="email-row" id="std-subheading">
			<div class="email-col email-col-3 mr-1 rose-gold" >
				<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
			</div>
			<div class="email-col email-col-9 blue-bg">
				<p>Save our date</p>
			</div>
		</div>

		<div class="email-row address_container" id="std-details">
			<div class="email-col email-col-11 mr-1 blue-bg">
				<p class="date">Wednesday 27th | October 2021</p>

				<div class="address">
					<p class="address_1">The Mills Barn</p>
					<p class="address_2">Alveley</p>
					<p class="address_3">Near Bridnorth</p>
					<p class="county">Shropshire</p>
					<p class="postcode">WV15 6HL</p>
				</div>
			</div>
			<div class="email-col email-col-1">
				<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
			</div>
		</div>
	</div>


@endsection

<style>
	.email-container {
		color: #FFF;
	}
	.email-row {
		display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    -ms-flex-wrap: wrap;
	    flex-wrap: wrap;
		width: 100%;
		margin-bottom: 1em;
	}
	.email-col {
		position: relative;
		-ms-flex-preferred-size: 0;
    flex-basis: 0;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
	}
	.mr-1 {
		margin-right: 1em;
	}
	.email-col-1 {
		width: 8.333333%;
	}
	.email-col-3 {
		width: 25%;
	}
	.email-col-6 {
		width: 50%;
		float:left;
	}
	.email-col-9 {
		width: 75%;
	}
	.email-col-11 {
		width: 91.666667%;
	}
	.blue-bg {
		background-color: #121828;
	}
	.rose-gold img {
		width: 100%;
		height: 6em;
	}
	.address_container img {
		height: 100%;
	}
	#std-header .email-col p,
	#std-subheading .email-col p {
		padding: 1em;
		margin: 0;
		text-align: center;
	}
	#std-subheading .email-col p {
		width: 100%;
	    position: absolute;
	    top: 50%;
	    transform: translate(0, -50%);
	}
</style>