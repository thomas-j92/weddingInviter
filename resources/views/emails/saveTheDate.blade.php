@extends('emails.inc.main', ['showHeader' => false, 'showFooter' => false])

@section('header')
	panel
@endsection

@section('content')

	<div class="container">
		<div class="row blue-bg">
			<div class="col col-6" id="">
				<p>We're getting married</p>

			</div>
			<div class="col col-6">
				<p>Jessica & Thomas</p>
			</div>
		</div>

		<div class="row">
			<div class="col col-3 mr-1 rose-gold" >
				{{-- <img src="{{ $message->embed('images/emails/rose-gold.jpg') }}"> --}}
				<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
			</div>
			<div class="col col-9 blue-bg">
				<p>Save our date</p>
			</div>
		</div>

		<div class="row address_container">
			<div class="col col-11 mr-1 blue-bg">
				<p class="date">Wednesday 27th | October 2021</p>

				<div class="address">
					<p class="address_1">The Mills Barn</p>
					<p class="address_2">Alveley</p>
					<p class="address_3">Near Bridnorth</p>
					<p class="county">Shropshire</p>
					<p class="postcode">WV15 6HL</p>
				</div>
			</div>
			<div class="col col-1">
				<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
			</div>
		</div>
	</div>


@endsection

<style>
	@font-face {
	    font-family: 'Aphrodite';
	    src: url('{{ public_path('fonts/save_the_dates/aphrodite-text.otf') }}');
	    /*src: url('/fonts/save_the_dates/aphrodite-text.otf');*/
	}
	p {
		font-family: Aphrodite;
	}
	.row {
		display: flex;
		wdith: 100%;
		margin-bottom: 1em;
	}
	.mr-1 {
		margin-right: 1em;
	}
	.col-1 {
		width: 8.333333%;
	}
	.col-3 {
		width: 25%;
	}
	.col-6 {
		width: 50%;
		float:left;
	}
	.col-9 {
		width: 75%;
	}
	.col-11 {
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
</style>