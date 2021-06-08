<template>
	<div class="bg-white">
	  <main>
	    <div>
	      <!-- Hero card -->
	      <div class="relative">
	        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gray-100"></div>
	        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
	          <div class="relative shadow-xl sm:rounded-2xl sm:overflow-hidden">
	            <div class="absolute inset-0">
	              <img class="h-full w-full object-cover" :src="this.baseUrl + '/images/web/main-header2.jpg'" alt="The happy couple">
	              <div class="absolute inset-0 bg-pink-light" style="mix-blend-mode: multiply;"></div>
	            </div>
	            <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
	              <h1 class="text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
	                <span class="block text-gray-200 text-4xl">Jessie & Tom</span>
	                <span class="block text-gray-50">are getting married</span>
	              </h1>
	              <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">
	                
	              </p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </main>
	</div>
</template>

<script>
	export default {
		name: 'hero'
	}
</script>