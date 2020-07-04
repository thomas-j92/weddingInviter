<template>
	<div class="countdown">
		<vue-countdown-timer
		      :start-time="'2018-10-10 00:00:00'"
		      :end-time="1635339600"
		      :interval="1000"
		      label-position="begin"
		      :end-text="'Event ended!'"
		      :day-txt="'days'"
		      :hour-txt="'hours'"
		      :minutes-txt="'minutes'"
		      :seconds-txt="'seconds'">
		  <template slot="countdown" slot-scope="scope">
		  	<div class="countdown-element days fadeIn speed-2">
	        	<span class="number">{{scope.props.days}}</span>
	        	<span class="text">{{scope.props.dayTxt}}</span>
	        </div>

	        <div class="countdown-element hours fadeIn speed-3">
	        	<span class="number">{{scope.props.hours}}</span>
	        	<span class="text">{{scope.props.hourTxt}}</span>
	    	</div>

	    	<div class="countdown-element minutes fadeIn speed-4">
	    		<span class="number">{{scope.props.minutes}}</span>
	        	<span class="text">{{scope.props.minutesTxt}}</span>
	   		 </div>

	   		 <div class="countdown-element seconds fadeIn speed-5">
	   		 	<span class="number">{{scope.props.seconds}}</span>
	        	<span class="text">{{scope.props.secondsTxt}}</span>
	    	</div>
	      </template>
		</vue-countdown-timer>
	</div>
</template>

<script>
	export default {
		name: 'countdown',
	}
</script>