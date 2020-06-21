@extends('emails.inc.main', ['showHeader' => false, 'showFooter' => false])

@section('header')
	panel
@endsection

@section('content')
	
	<div class="container">
		<div class="email-container">

			<div class="email-body">
				
				<div class="header-image">
					<img src="{{ asset('images/emails/save_the_dates/header.png') }}" alt="Save the dates">
				</div>


				<div class="greeting-container">
					<p>{{ $greeting }}</p>
				</div>

				<div class="divider">
					<img src="{{ asset('images/emails/save_the_dates/mill-barn-pink.png') }}" alt="Divider">
				</div>

				<div class="desc-container">
					<img src="{{ asset('images/emails/save_the_dates/jess-tom.png') }}" alt="Jess and Tom">
					<p class="desc">invite you to share their celebration</p>
					<p class="desc small">on</p>
					<p class="date">Wednesday, 27th October 2021</p>
					<p class="desc small">at</p>
				</div>
				
				<table cellspacing="0" cellpadding="0" class="std-details">
					<tr>
						<td class="blue-bg">
							<div class="address">
								<p class="address_1">The Mills Barn</p>
								<p class="address_2">Alveley</p>
								<p class="address_3">
									<span id="part-1">Near Bridnorth</span><span id="part-2">Shropshire</span><span id="part-3">WV15 6HL</span>
								</p>
							</div>
						</td>
					</tr>
				</table>

				<table class="footer">
					<tr>
						<td>
							<p>The venue has limited rooms available for guests to book if they would like to spend the night after celebrating with us. Please enquire via email <a href="mailto:thehappycouple@jinkswedding.co.uk">thehappycouple@jinkswedding.co.uk</a></p>
						</td>
					</tr>
					<tr>
						<td>	
							<p>To give all our guests the opportunity to celebrate without having to worry about little eyes and little ears, we politely request no children.</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
@endsection

<style>
	.container {
		background-color: #003452;
		padding: 1em;
	}
	.email-container {
		background-image: url({{ asset('images/emails/save_the_dates/bg.png') }});
		height: 59em;
		position: relative;
	}
	.email-container .email-body {
		background-color: #003452;
		background-image: url({{ asset('images/emails/save_the_dates/confetti.png') }});
		background-repeat: no-repeat;
		position: absolute;
	    left: 0.4em;
	    right: 0.4em;
	    bottom: 0.4em;
	    top: 0.4em;
	}
	.email-container .email-body .greeting-container p {
		color: #fba198;
    	font-size: 1.5em;
	}
	.email-container .email-body .desc-container img {
		margin: 0 auto;
	    display: block;
	    padding-bottom: 1em;
	}
	.email-container .email-body .desc-container .desc.small {
		font-size: 0.8em;
		padding: 0.5em;
	}
	.email-container .email-body .date {
		font-size: 1.3em;
		color: #fba198;
	}
	.email-container .email-body .header-image img {
		margin: 0 auto;
    	display: block;
   	 	padding: 1em;
   	 	padding-top: 6em;
	}
	.email-container .divider {
		width: 2em;
	    margin: 1.5em auto;
	}
	.email-container table {
		width: 100%;
	}
	.email-container p {
		color: #fbcbc6;
		margin: 0;
		text-align: center;
		font-family: Tahoma, Geneva, sans-serif;
	}
	.email-container .email-body .std-details {
		padding-bottom: 1em;
	}
	.email-container .email-body .std-details .address {
		padding-bottom: 1em;
	}
	.email-container .email-body .std-details .address #part-1,
	.email-container .email-body .std-details .address #part-2{
		border-right: 1px solid #da928b;
		padding-right: 0.5em;
    	margin-right: 0.5em;
	}
	.email-container .email-body .footer p {
		font-size: 0.7em;
		color: #2f6782;
		padding-bottom: 0.5em;
		color: #ffbab3;
		margin: 1em 2em;
		margin-top: 0em;
	} 
</style>