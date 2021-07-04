
	{{-- <div class="std"> --}}
		<div class="parent-container">
			<div class="email-container">

				<div class="email-body">

					<div class="confetti">
						{{-- <img src="{{ asset('images/emails/save_the_dates/confetti.png') }}" alt="Save the dates"> --}}
					</div>
					
					<div class="header-image">
						{{-- <img src="{{ asset('images/emails/save_the_dates/header.png') }}" alt="Confetti"> --}}
					</div>


					<div class="greeting-container">
						<p>{{ $greeting }}</p>
					</div>

					<div class="divider">
						<img src="{{ asset('images/emails/save_the_dates/mill-barn-pink.png') }}" alt="Divider">
					</div>

					<div class="desc-container">
						<div class="tom-jess">
							<img src="{{ asset('images/emails/save_the_dates/jess-tom.png') }}" alt="Jess and Tom">
						</div>
						<p class="desc">invite you to share their celebration</p>
						<p class="desc small">on</p>
						<p class="date">Wednesday, 27th October 2021</p>
						<p class="desc small at">at</p>

						<div class="address">
							<p class="address_1">The Mill Barns</p>
							<p class="address_2">Alveley</p>
							<p class="address_3">
								Near Bridnorth - Shropshire - WV15 6HL
							</p>
						</div>

						<div class="mark-as-seen">
							<p><a href="{{ url('invitation/'.$code.'/view') }} ">Click here</a> to RSVP and let us know of any dietary requirements</p>
						</div>

						<div class="footer">
							<p>The venue has limited rooms available for guests to book if they would like to spend the night after celebrating with us. Please enquire via email <a href="mailto:thehappycouple@jinkswedding.co.uk">thehappycouple@jinkswedding.co.uk</a></p>

							<p>To give all our guests the opportunity to celebrate without having to worry about little eyes and little ears, we politely request no children.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	{{-- </div> --}}

<style>
	@page {
    	margin: 0;
  	}
	.parent-container {
		background-color: #003452;
		padding: 1em;
		background-image: url({{ asset('images/invite/invite-bg.jpg') }});
		background-size: cover;
		/*background-repeat: no-repeat;*/
		height: 100%;
		width: 100%;
	}
	.email-container {
		margin: 12em 6em;
		position: relative;
	}
	.email-container .email-body {
		background-color: #003452;
		width: 35em;
		margin: 0 auto;
	}
	.email-container .email-body .confetti {
		width: 45em;
		height: 12em;
		background-image: url({{ asset('images/emails/save_the_dates/confetti.png') }});
		background-repeat: no-repeat;
	}
	.email-container .email-body .greeting-container p {
		color: #fba198;
    	font-size: 1.5em;
	}
	.email-container .email-body .desc-container {
		text-align: center;
	}
	.email-container .email-body .desc-container .tom-jess {
		margin-bottom: 2em;
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
	.email-container .email-body .desc-container .desc.at {
		margin: 2em;
	}
	.email-container .email-body .date {
		font-size: 1.3em;
		color: #fba198;
	}
	.email-container .email-body .header-image {
		width: 100%;
		text-align: center;
		margin-bottom: 1.5em;
	}
	.email-container .email-body .header-image img {
		margin: 0 auto;
    	display: block;
   	 	padding: 1em;
	}
	.email-container .divider {
		width: 3em;
	    margin: 3em auto;
	    padding-top: 1em;
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
	.email-container .email-body .address .address_3 {
		font-size: 1.3em;
		margin-bottom: 1em;
	}
	.email-container .email-body .std-details .address #part-1,
	.email-container .email-body .std-details .address #part-2{
		border-right: 1px solid #da928b;
		padding-right: 0.5em;
    	margin-right: 0.5em;
	}
	.email-container .email-body .mark-as-seen p {
		font-size: 0.7em;
		padding-bottom: 1em;
		padding-top: 1em;
	}
	.email-container .email-body .footer {
		margin-bottom: 1em;
	}
	.email-container .email-body .footer p {
		font-size: 0.7em;
		color: #2f6782;
		padding-bottom: 0.3em;
		color: #ffbab3;
		margin: 1em 2em;
		margin-top: 0em;
	}
	.email-container a {
		color: #FFF;
	}
</style>