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

		  <div v-for="(c, i) in components" v-if="step == i" :key="'key_'+i">
		  	<component v-bind:is="c.component" v-bind="c.props"></component>
		  </div>
		</transition>
		
		<button @click="step--" :disabled="step == 0">Previous</button>
		<button @click="step++">Next</button>

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
				step: 1,
				components: [],
			}
		},
		// components: {
			// 'invite-intro': inviteIntro,
			// 'rsvp': rsvp,
		// },
		mounted() {

			const self = this;

			// add invite intro
			this.components.push({
				component:inviteIntro,
				props: {
					'invite': self.invite
				}
			});


			// add rsvp component for each guest
			this.invite.guests.forEach(guest => {
				this.components.push({
					component: rsvpSection
				});
			})
		}
	}
</script>