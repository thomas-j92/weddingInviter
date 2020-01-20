<template>
	<div>
		<b-form-group label="Will you be attending the day?">
		  <b-form-radio-group
		    id="btn-radios-1"
		    v-model="form.rsvp.day"
		    :options="rsvpOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>

		<b-form-group label="Will you be attending the night?">
		  <b-form-radio-group
		    id="btn-radios-1"
		    v-model="form.rsvp.night"
		    :options="rsvpOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>

		<b-form-group label="Do you have any dietary requirements?">
		  <b-form-radio-group
		    id="btn-radios-1"
		    v-model="form.diet.requirement"
		    :options="dietOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.rsvp',
		data() {
			return {
				rsvpOptions: [
					{'text': 'Yes', 'value': 'true'},
					{'text': 'No', 'value': 'false'}
				],
				dietOptions: [
					{'text': 'No', 'value': 'false'},
					{'text': 'Vegetarian', 'value': 'vegetarian'},
					{'text': 'Vegan', 'value': 'vegan'},
					{'text': 'Other', 'value': 'other'},
				],
				form: {
					rsvp: {
						day: "false",
						night: "false",
					},
					diet: {
						requirement: 'false',
						details: 'false'
					},
				}
			}
		}
	}
</script>