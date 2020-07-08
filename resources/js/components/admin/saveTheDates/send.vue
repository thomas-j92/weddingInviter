<template>
	<div class="send-std" v-if="invite">
		<h2>Main guest</h2>
		<p>The main guest will always be sent this email.</p>
		<b-form-group v-if="invite.main_guest">
			<b-container>
				<b-row>
					<b-col>
						{{ invite.main_guest.person.first_name }} {{ invite.main_guest.person.last_name }}
					</b-col>
		      	</b-row>
				<b-row>
		    		<b-col>
			     		<b-form-radio v-model="save_the_dates.form.main_guest" name="std-main-guest" :disabled="true" value="1">Yes</b-form-radio>
			     	</b-col>
			     	<b-col>
			      		<b-form-radio v-model="save_the_dates.form.main_guest" name="std-main-guest" :disabled="true" value="0">No</b-form-radio>
			      	</b-col>
		      	</b-row>
			</b-container>
	    </b-form-group>
		
		<h2>Additional guest(s)</h2>
	    <b-form-group v-if="invite.additional_guests">
			<b-container v-for="(additional, index) in invite.additional_guests" :key="'additional_'+index">
				<b-row>
					<b-col>
						{{ additional.person.first_name }} {{ additional.person.last_name }}
					</b-col>
		      	</b-row>
				<b-row>
		    		<b-col>
			     		<b-form-radio v-model="save_the_dates.form.additional_guest[additional.person_id]" :name="'std-main-guest-'+index" value="1">Yes</b-form-radio>
			     	</b-col>
			     	<b-col>
			      		<b-form-radio v-model="save_the_dates.form.additional_guest[additional.person_id]" :name="'std-main-guest-'+index" value="0">No</b-form-radio>
			      	</b-col>
		      	</b-row>
			</b-container>
	    </b-form-group>

	    <b-button @click="sendSaveTheDate">Send</b-button>
    </div>
</template>

<script>
	export default {
		name: 'saveTheDates.send',
		props: ['inviteId'],
		data() {
			return {
				invite: null,
				save_the_dates: {
					form: {
						main_guest: "1",
						additional_guest: [],
					}
				},
				additional_guests: {}
			}
		},
		mounted() {
			this.getInvite();
		},
		methods: {
			getInvite() {
				const self = this;

				axios.get("/api/invite/"+this.inviteId)
					 .then((resp) => {
					 	if(resp.data) {
					 		// store Invite details
					 		self.invite = resp.data;

					 		// store main person assigned to Invite
					 		self.invite.main_guest = resp.data.main_guest;

					 		// update invite type details
					 		// self.updateInviteType.day = (resp.data.day == 1) ? 'true' : 'false';
					 		// self.updateInviteType.night = (resp.data.night == 1) ? 'true' : 'false';

					 		// store additional guests assigned to Invite
					 		// self.additional_guests.data = resp.data.additional_guests;

					 		// store Plus One details
					 		// self.plus_ones.data = resp.data.plus_ones;

					 		

					 		// set default additional guest values for save the date modal
					 		if(self.invite.additional_guests.length > 0) {
						 		self.invite.additional_guests.forEach((additional) => {
						 			self.save_the_dates.form.additional_guest[additional.person_id] = "0";
						 		});
					 		}

					 		// stop loading gif
					 		// self.inviteLoading = false;

					 		// get activity 
							// self.getActivity();
					 	}
					 })
			},
			sendSaveTheDate() {
				const self = this;

				// structure data
				let saveTheDateData = {
					inviteId: this.inviteId,
					additional: this.save_the_dates.form.additional_guest
				};

				// send save the date
				axios.post(this.baseUrl+'/api/save_the_date', saveTheDateData)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.toast('Email sent', resp.data.message);

					 		// refresh additional data
					 		self.$emit('sent', true);
					 	} else {
					 		self.toast('Error', resp.data.message, 'danger');
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			}
		}
	}
</script>