<template>
	<div>
		<h2 class="text-white mt-5">Thank you for letting us know</h2>

		<div class="mt-4 mb-8 text-white">
			<div v-if="attending.length > 0">
				<p>We look forward to seeing you on the big day!</p>

				<p>Please checkout our website on additional information you might want to know (I'm assuming you'd like to know where you're driving to!)</p>
			</div>
			<div v-else>
				<p class="text-white">We're sorry you are unable to attend. You are now dead to us! </p>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.confirm',
		props: ['invite'],
		computed: {
			attending() {
				return this.invite.guests.filter((guest) => guest.attending_day || guest.attending_night);
			},
			not_attending() {
				return this.invite.guests.filter((guest) => !guest.attending_day && !guest.attending_night);
			}
		}
	}
</script>