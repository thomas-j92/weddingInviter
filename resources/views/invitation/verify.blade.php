@extends('invitation.inc.template')

@section('title', 'Invitation - Verify')

@section('content')

	<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ]
  }
  ```
-->
<div class="w-1/2 mx-auto">
	<div class="py-16 sm:py-24">
	  <div class="relative sm:py-16">

	  	

	    <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
	    	@if(Session::has('status'))
		    	<!-- This example requires Tailwind CSS v2.0+ -->
				<div class="rounded-md bg-red-50 p-4 mb-3">
				  <div class="flex">
				    <div class="flex-shrink-0">
				      <!-- Heroicon name: solid/x-circle -->
				      <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
				        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
				      </svg>
				    </div>
				    <div class="ml-3">
				      <h3 class="text-sm font-medium text-red-800 mb-0">
				        {{ Session::get('status') }}
				      </h3>
				    </div>
				  </div>
				</div>
		 	@endif
	      <div class="relative rounded-2xl px-6 py-10 bg-pink overflow-hidden shadow-xl sm:px-12 sm:py-20">
	        <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
	          <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
	            <path class="text-pink-light text-opacity-40" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
	            <path class="text-gray-300 text-opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
	          </svg>
	        </div>
	        <div class="relative">
	          <div class="sm:text-center">
	            <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
	              Please verify who you are.
	            </h2>
	            <p class="mt-6 mx-auto max-w-2xl text-lg text-gray-100">
	              We don't want any Tom, Dick or Harry's at the wedding (although - Tom, Dick & Harry are all invited) so please confirm your email address.
	            </p>
	          </div>
	          <form action="{{ url('invitation/verification')}}" class="mt-12 sm:mx-auto sm:max-w-lg sm:flex" method="post">
	          	@csrf
	          	<input type="hidden" name="code" value="{{ $code }}">
	            <div class="min-w-0 flex-1">
	              <label for="cta_email" class="sr-only">Email address</label>
	              <input id="cta_email" name="email" type="email" class="block w-full border border-transparent rounded-md px-3 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" placeholder="Enter your email">
	            </div>
	            <div class="sm:mt-0 sm:ml-3">
	              <button type="submit" class="block w-full rounded-md border border-transparent px-5 py-3 bg-pink text-base font-medium text-white shadow hover:underline focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 sm:px-10">Notify me</button>
	            </div>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>

        
@stop