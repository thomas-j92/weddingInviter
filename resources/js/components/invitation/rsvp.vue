<template>
	<div class="invite-container w-3/4 sm:w-1/2 mx-auto paper-header rsvp-invite">
			
			<div class="invite-header"></div>

			<transition name="component-fade" mode="out-in">
			  <div v-for="(c, i) in components" v-if="step.number == i" :key="'key_'+i">
			  	<div class="alert-container" v-if="response.message">
			  		<b-alert show variant="success" v-if="response.success">{{ response.message }}</b-alert>
			  		<b-alert show variant="danger" v-if="response.error">{{ response.message }}</b-alert>
			  	</div>
			  	<component v-bind:is="c.component" v-bind="c.props" @updated="update" :existing-data="existingData"></component>
			  </div>
			</transition>
			
			<div class="buttons" v-if="!response.success && editable" :class="{'all-buttons': step.number > 0}">
				<button class="secondary" @click="step.number--" v-if="step.number > 0">Previous</button>

				<!-- <button v-if="(step.number+1) == components.length" @click="submit">Finish</button> -->
				<button @click="nextSlide" v-else-if="step.complete">Next</button>
			</div>
		</div>
</template>

<script>
	import rsvpSection from './sections/rsvp.vue'
	import plusOneSection from './sections/plusOne.vue'
	import confirmSection from './sections/confirm.vue'

	export default {
		name: 'invitation.rsvp',
		props: ['invite'],
		data() {
			return {
				step: {
					number: 0,
					complete: false,
				},
				components:[],
				response: {
					error: false,
					success: false,
					message: false
				},
				editable: true,
				formData: [],
			}
		},
		computed: {
			existingData() {
				return this.formData[this.step.number];
			}
		},
		mounted() {
			const self = this;

			// let isEditable = false;
			// this.invite.guests.forEach(guest => {
			// 	if(guest.rsvp == 0) {
			// 		isEditable = true;
			// 	}
			// })
			// this.editable = isEditable;

			let sectionNum = 0;
			// add rsvp component for each guest
			this.invite.guests.forEach(guest => {
				if(guest.rsvp == 0) {
					this.components.push({
						component: rsvpSection,
						props: {
							'guest': guest,
							'sectionNum': sectionNum,
							'invite': self.invite,
						}
					});

					sectionNum++;
				}
			});

			// add plus one component for each guest
			this.invite.plus_ones.forEach(plusOne => {
				if(plusOne.rsvp == 0) {
					this.components.push({
						component: plusOneSection,
						props: {
							'sectionNum': sectionNum,
							'plusOne': plusOne
						}
					});

					sectionNum++;
				}
			});

			// sectionNum++;

			// add confirmation component
			this.components.push({
				component:confirmSection,
				props: {
					// 'formData': self.formData,
					'sectionNum': sectionNum,
					'invite': self.invite
				}
			})
		},
		methods: {
			update(data) {
				console.log(data);

				// use complete value from component to check if component step is complete
				this.step.complete = data.complete;

				// store all form data pieces in array, indexed by section number so they can be easily pulled
				this.formData[data.sectionNum] = data.formData;
			},
			nextSlide() {
				let currData = this.formData[this.step.number];

				const self = this;
				if(currData) {
					axios.post(this.baseUrl+'/api/invite/rsvp/' + currData.id, currData)
						 .then((resp) => {
						 	if(resp.data.success) {
						 		self.step.number++;
						 	}
						 })
				}
			}
		}
	}
</script>