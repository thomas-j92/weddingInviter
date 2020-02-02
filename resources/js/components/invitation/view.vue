<template>
	<div class="invite-container col-sm-6 offset-sm-3">
		
		<div class="invite-header">
			<img src="/images/invite/header.png" alt="">
		</div>

		<transition name="component-fade" mode="out-in">

		  <!-- p v-if="step == 1" key="step_1">
		  	Step 1
		  </p>
		  <p v-else-if="step == 2" key="step_2">
		  	Step 2
		  </p> -->

		  <div v-for="(c, i) in components" v-if="step.number == i" :key="'key_'+i">
		  	<component v-bind:is="c.component" v-bind="c.props" @updated="update" :existing-data="existingData"></component>
		  </div>
		</transition>
		
		<div class="buttons">
			<button @click="step.number--" :disabled="step.number == 0">Previous</button>
			<button @click="step.number++" :disabled="!step.complete">Next</button>
		</div>
	</div>
</template>

<script>
	import inviteIntro from './sections/inviteIntro.vue'
	import rsvpSection from './sections/rsvp.vue' 

	export default {
		name: 'invitation.view',
		props: ['invite'],
		data() {
			return {
				step: {
					number: 0,
					complete: false,
				},
				formData: [],
				components: [],
			}
		},
		// components: {
			// 'invite-intro': inviteIntro,
			// 'rsvp': rsvp,
		// },
		mounted() {

			const self = this;

			let sectionNum = 0;

			// add invite intro
			this.components.push({
				component:inviteIntro,
				props: {
					'invite': self.invite,
					'sectionNum': sectionNum,
				}
			});


			// add rsvp component for each guest
			this.invite.guests.forEach(guest => {
				sectionNum++;

				this.components.push({
					component: rsvpSection,
					props: {
						'guest': guest,
						'sectionNum': sectionNum,
					}
				});
			})
		},
		computed: {
			existingData() {
				return this.formData[this.step.number];
			}
		},
		methods: {
			update(data) {
				console.log(data);

				// use complete value from component to check if component step is complete
				this.step.complete = data.complete;

				// store all form data pieces in array, indexed by section number so they can be easily pulled
				this.formData[data.sectionNum] = data.formData;
			},
			getExistingData(sectionNo) {
				return this.formData[sectionNo];
			}
		}
	}
</script>