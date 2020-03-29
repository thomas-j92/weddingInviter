<template>
	<div>
		<div class="invite-details" v-if="editable">
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
		<div v-else>
			<h2 class="m-4">Thank you for letting us know</h2>

			<b-list-group class="pb-4">
			  <b-list-group-item v-if="attendingBoth.length > 0">
			  	<h4>
			  		<span v-for="(g, index) in attendingBoth">
						{{ g.person.first_name }}<span v-if="(index+2) < attendingBoth.length">,</span><span v-else-if="(index+2) == attendingBoth.length"> and</span>
					</span>
			  	</h4>
			  	Thank you for deciding to spend the entire day with us, you may regret this.
			  </b-list-group-item>
			  <b-list-group-item v-if="attendingDay.length > 0">
			  	<h4>
			  		<span v-for="(g, index) in attendingDay">
						{{ g.person.first_name }}<span v-if="(index+2) < attendingDay.length">,</span><span v-else-if="(index+2) == attendingDay.length"> and</span>
					</span>
			  	</h4>
			  	We are looking forward to seeing for the day.
			  </b-list-group-item>
			  <b-list-group-item v-if="attendingNight.length > 0">
			  	<h4>
			  		<span v-for="(g, index) in attendingNight">
						{{ g.person.first_name }}<span v-if="(index+2) < attendingNight.length">,</span><span v-else-if="(index+2) == attendingNight.length"> and</span>
					</span>
			  	</h4>
			  	We are looking forward to seeing for the night do. Hopefully everyone will still be standing by then!
			  </b-list-group-item>
			  <b-list-group-item>
			  	If you need to make amendments, please contact us directly and we will make any the changes according. Admin fee's can be payable by beer or curry.
			  </b-list-group-item>
			</b-list-group>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.intro',
		props: ['invite', 'editable'],
		data() {
			return {

			}
		},
		computed: {
			mainGuest() {
				return this.invite.main_guest.person;
			},
			attendingBoth() {
				let attendingArr = [];

				this.invite.guests.forEach(guest => {
					if(guest.attending_day && guest.attending_night) {
						attendingArr.push(guest);
					}
				});

				return attendingArr;
			},
			attendingDay() {
				let attendingDayArr = [];

				this.invite.guests.forEach(guest => {
					if(guest.attending_day && !guest.attending_night) {
						attendingDayArr.push(guest);
					}
				});

				return attendingDayArr;
			},
			attendingNight() {
				let attendingNightArr = [];

				this.invite.guests.forEach(guest => {
					if(!guest.attending_day && guest.attending_night) {
						attendingNightArr.push(guest);
					}
				});

				return attendingNightArr;
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