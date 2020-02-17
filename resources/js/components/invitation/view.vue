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
		  	<div class="alert-container" v-if="response.message">
		  		<b-alert show variant="success" v-if="response.success">{{ response.message }}</b-alert>
		  		<b-alert show variant="danger" v-if="response.error">{{ response.message }}</b-alert>
		  	</div>
		  	<component v-bind:is="c.component" v-bind="c.props" @updated="update" :existing-data="existingData"></component>
		  </div>
		</transition>
		
		<div class="buttons">
			<button @click="step.number--" :disabled="step.number == 0">Previous</button>

			<button v-if="(step.number+1) == components.length" @click="submit">Finish</button>
			<button @click="step.number++" :disabled="!step.complete" v-else>Next</button>
		</div>
	</div>
</template>

<script>
	import inviteIntro from './sections/inviteIntro.vue'
	import rsvpSection from './sections/rsvp.vue' 
	import confirmSection from './sections/confirm.vue'

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
				response: {
					error: false,
					success: false,
					message: false
				}
			}
		},
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
			});

			sectionNum++;

			// add confirmation component
			this.components.push({
				component:confirmSection,
				props: {
					'formData': self.formData,
					'sectionNum': sectionNum,
				}
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
			},
			submit() {
				const self = this;

				// structure data
				let postData = {
					'formData': self.formData,
					'code': self.invite.code,
				};

				// submit invite data
				axios.post(this.baseUrl+'/api/invite/web', postData)
					 .then((resp) => {
					 	if(resp.data) {

					 		if(resp.data.success) {
					 			self.response.success 	= true;
					 		} else {
					 			self.response.error 	= true;
					 		}
					 		self.response.message = resp.data.message;

					 		setTimeout(function() {
					 			self.response.success 	= false;
					 			self.response.error 	= false;
					 			self.response.message 	= false;
					 		}, 5000)
					 	}
					 })
			}
		}
	}
</script>