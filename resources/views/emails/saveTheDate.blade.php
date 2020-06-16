@extends('emails.inc.main', ['showHeader' => false, 'showFooter' => false])

@section('header')
	panel
@endsection

@section('content')
	
	<div class="email-container">

		<div class="email-body">

			<p class="std-desc">Would like you to save our date, Wednesday 27th of October, 2021.</p>
			
			<table cellspacing="0" cellpadding="0" class="std-details">
				<tr>
					<td class="blue-bg">
						<p class="date">Wednesday 27th | October 2021</p>

						<div class="address">
							<p class="address_1">The Mills Barn</p>
							<p class="address_2">Alveley</p>
							<p class="address_3">Near Bridnorth</p>
							<p class="county">Shropshire</p>
							<p class="postcode">WV15 6HL</p>
						</div>
					</td>
				</tr>
			</table>
		</div>
		
	</div>
	{{-- <div class="email-container">
		<table cellspacing="0" cellpadding="0" class="std-heading">
			<tr>
				<td class="blue-bg" width="80%">
					<p>We're getting married</p>
					<p>Jessica & Thomas</p>
				</td>
				<td width="20%">
					<img src="{{ asset('images/mill-logo.png') }}">
				</td>
			</tr>
		</table>

		<table cellspacing="0" cellpadding="0" class="std-wording">
			<tr>
				<td width="25%" class="img">
					<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
				</td>
				<td width="75%" class="blue-bg">
					<p>Save our date</p>
				</td>
			</tr>
		</table>

		<table cellspacing="0" cellpadding="0" class="std-details">
			<tr>
				<td width="90%" class="blue-bg">
					<p class="date">Wednesday 27th | October 2021</p>

					<div class="address">
						<p class="address_1">The Mills Barn</p>
						<p class="address_2">Alveley</p>
						<p class="address_3">Near Bridnorth</p>
						<p class="county">Shropshire</p>
						<p class="postcode">WV15 6HL</p>
					</div>
				</td>
				<td width="10%" class="img">
					<img src="{{ asset('images/emails/rose-gold.jpeg') }}">
				</td>
			</tr>
		</table>
	</div> --}}

@endsection

<style>
	.email-container {
		background-image: url({{ asset('images/emails/rose-gold.jpeg') }});
		height: 20em;
		position: relative;
	}
	.email-container .email-body {
		background-color: rgb(15, 21, 33);
		position: absolute;
	    left: 1em;
	    right: 1em;
	    bottom: 1em;
	    top: 1em;
	}
	.email-container table {
		width: 100%;
	}
	.email-container p {
		margin: 0;
		text-align: center;
	}
	.std-desc {
		padding-bottom: 2em;
	}
	/*.email-container p {
		margin: 0;
		color: #FFF;
		font-family: "Trebuchet MS", Helvetica, sans-serif;
	}
	/*.email-container p {
		margin: 0;
		color: #FFF;
		font-family: "Trebuchet MS", Helvetica, sans-serif;
	}
	.email-container table {
		border: 0;
		width: 100%;
		margin-bottom: 1em;
	}
	.email-container .blue-bg {
		background-color: #121828;
	}
	.email-container .std-heading p {
		text-align: center;
		padding: 0.5em 0em;
	}
	.email-container .std-wording p {
		text-align: center;
	}
	.email-container .std-details p {
		text-align: center;
	}
	.email-container .std-wording .img {
		padding-right: 1em;
	}
	.email-container .std-wording img {
		height: auto;
	}
	.email-container .std-details .img {
		padding-left: 1em;
	}
	.email-container .std-details img {
		height: 15em;
	}*/
</style>