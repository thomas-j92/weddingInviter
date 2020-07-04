<template>
	<div class="send-std">
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
	    <b-form-group>
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
    </div>
</template>

<script>
	export default {
		name: 'saveTheDates.send',
		props: ['inviteId'],
		data() {
			return {
				
			}
		},
	}
</script>