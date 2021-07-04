<template>
	<div class="bg-white grid grid-cols-1 sm:grid-cols-2" id="location">
	  <div class="flex-1 flex flex-col justify-center py-12 sm:py-24 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
	    <div class="mx-auto w-full sm:max-w-sm lg:w-96">
	      <div>
	        <h2 class="mt-6 text-4xl font-extrabold text-gray-900">
	          So... Where is it?
	        </h2>
	        <p class="text-gray-500 mt-3">Beware! The venue is relatively new & it's in the middle of the sticks, so please allow plenty of time to find it. For every minute a guest is late, a pixie dies.</p>
	      </div>

	      <div class="mt-10">
	        <dl class="mt-2 text-base text-gray-500">
	          <div>
	            <div class="text-2xl text-black">
	              Full Address
	            </div>
	            <div class="text-xl mt-2">
	              The Mill Barns
	            </div>
	            <div class="text-xl">
	              Alveley
	            </div>
	            <div class="text-xl">
	              Bridgnorth
	            </div>
	            <div class="text-xl">
	              WV15 6HL
	            </div>
	          </div>
	        </dl>
	      </div>
	    </div>
	  </div>
	  <div class="h-96 sm:h-auto">
	   <GmapMap
		  :center="{lat: 52.46595754740831, lng: -2.3388887460223797}"
		  :zoom="12"
		  map-type-id="terrain"
		  class="map"
		>
		  <GmapMarker
		    :position="google && new google.maps.LatLng(52.46595754740831, -2.3388887460223797)"
		    :clickable="true"
		    :draggable="true"
		    @click="center=m.position"
		  />
		</GmapMap>
	  </div>
	</div>
</template>

<script>
	import {gmapApi} from 'vue2-google-maps'

	export default {
		name: 'location',
		computed: {
    		google: gmapApi
  		}
	}
</script>