<template>
	<div class="invite-details">
		<div class="guests">
			<h2 class="main-guests">{{ mainGuest.first_name }} {{ mainGuest.last_name }}</h2>
		</div>

		<div class="invited-by">
			<p>Are invited to celebrate the marriage of</p>
		</div>

		<div class="bride-and-groom">
			<p class="bride">Jessica King</p>
			<p class="and">&</p>
			<p class="groom">Thomas Jinks</p>
		</div>

		<div class="wedding-details">
			<p>Wednesday, October 27, 2021</p>
			<p>At halfpast 1 o'clock in the afternoon</p>
			<p>The mill barns</p>
			<p>Allum Bridge</p>
			<p>Alveley</p>
			<p>Bridgnorth</p>
			<p>WV15 6HL</p>
		</div>

		<div class="reception-to-follow">
			<p>Reception to follow</p>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.intro',
		props: ['invite'],
		data() {
			return {

			}
		},
		computed: {
			mainGuest() {
				return this.invite.main_guest.person;
			}
		},
		mounted() {
			// push values back to parent
			this.$emit('updated', {
				'sectionNum': 0,
				'formData': [],
				'complete': true,
			});
		},
		methods: {
		}
	}
</script>