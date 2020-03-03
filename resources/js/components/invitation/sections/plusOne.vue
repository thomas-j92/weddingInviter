<template>
	<div>
		<p>You have been assigned a plus one.</p>

		<transition-group name="list" tag="p">
			<b-form-group label="Will they be attending the day?" key="question_1">
			  <b-form-radio-group
			    id="attending-day"
			    v-model="day"
			    :options="rsvpOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>

			<b-form-group label="Will they be attending the night?" v-if="day" key="question_2">
			  <b-form-radio-group
			    id="attending-night"
			    v-model="night"
			    :options="rsvpOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>

			<b-form-group label="What is their name?"" key="question_3" v-if="day == 'true' || night == 'true'">
				<b-row>
					<b-col offset-sm="1" sm="5">
						<b-form-input
							id="first_name_input"
							v-model="first_name"
							button-variant="outline-primary"
							placeholder="First Name"
						></b-form-input>
					</b-col>
					<b-col sm="5">
						<b-form-input
							id="last_name_input"
							v-model="last_name"
							button-variant="outline-primary"
							placeholder="Last Name"
						></b-form-input>
					</b-col>
				</b-row>
			</b-form-group>

			<b-form-group label="Do you have any dietary requirements?" v-if="night && (day == 'true' || night == 'true')" key="question_4">
			  <b-form-radio-group
			    id="dietary-requirements"
			    v-model="dietary_requirement"
			    :options="dietOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>
			
			<b-form-group label="What dietary requirements do you have?" v-if="dietary_requirement == 'other'" key="question_5">
				<b-form-textarea
			      id="dietary-requirements-details"
			      v-model="dietary_details"
			      placeholder="Enter something..."
			      rows="3"
			      max-rows="6"
			    ></b-form-textarea>
			</b-form-group>
		</transition-group>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.plusOne',
		data() {
			return {
				first_name: null,
				last_name: null,
				day: null,
				night: null,
				dietary_requirement: null,
				dietary_details: null,
				rsvpOptions: [
					{'text': 'Yes', 'value': 'true'},
					{'text': 'No', 'value': 'false'}
				],
				dietOptions: [
					{'text': 'No', 'value': 'no'},
					{'text': 'Vegetarian', 'value': 'vegetarian'},
					{'text': 'Vegan', 'value': 'vegan'},
					{'text': 'Other', 'value': 'other'},
				],
			}
		}
	}
</script>