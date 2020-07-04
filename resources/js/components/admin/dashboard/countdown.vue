<template>
	<div class="countdown">
		<b-card>
			<h2>Countdown</h2>
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
			</vue-countdown-timer>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'countdown',
	}
</script>