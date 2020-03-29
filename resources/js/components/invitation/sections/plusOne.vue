<template>
	<div>
		<p>You have been assigned a plus one.</p>

		<transition-group name="list" tag="p">
			<b-form-group label="Will they be attending the day?" key="question_1">
			  <b-form-radio-group
			    id="attending-day"
			    v-model="form.day"
			    :options="rsvpOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>

			<b-form-group label="Will they be attending the night?" v-if="form.day" key="question_2">
			  <b-form-radio-group
			    id="attending-night"
			    v-model="form.night"
			    :options="rsvpOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>

			<b-form-group label="What is their name?"" key="question_3" v-if="form.day == 'true' || form.night == 'true'">
				<b-row>
					<b-col offset-sm="1" sm="5">
						<b-form-input
							id="first_name_input"
							v-model="form.first_name"
							button-variant="outline-primary"
							placeholder="First Name"
						></b-form-input>
					</b-col>
					<b-col sm="5">
						<b-form-input
							id="last_name_input"
							v-model="form.last_name"
							button-variant="outline-primary"
							placeholder="Last Name"
						></b-form-input>
					</b-col>
				</b-row>
			</b-form-group>

			<b-form-group label="Do you have any dietary requirements?" v-if="form.night && (form.day == 'true' || form.night == 'true')" key="question_4">
			  <b-form-radio-group
			    id="dietary-requirements"
			    v-model="form.dietary_requirement"
			    :options="dietOptions"
			    buttons
			    button-variant="outline-primary"
			    name="radios-btn-default"
			  ></b-form-radio-group>
			</b-form-group>
			
			<b-form-group label="What dietary requirements do you have?" v-if="form.dietary_requirement == 'other'" key="question_5">
				<b-form-textarea
			      id="dietary-requirements-details"
			      v-model="form.dietary_details"
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
		props: ['sectionNum', 'plusOne', 'existingData'],
		data() {
			return {
				form: {
					id: null,
					first_name: null,
					last_name: null,
					day: null,
					night: null,
					dietary_requirement: '',
					dietary_details: '',
					type: 'plus_one',
				},
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
		},
		computed: {
			isCompleted() {
				let complete = false;

				if(this.form.dietary_requirement != '') {
					if(this.form.dietary_requirement == 'other') {
						if(this.form.dietary_details != '') {
							complete = true;
						}
					} else {
						complete = true;
					}
				} else {
					if(this.form.day == 'false' && this.form.night == 'false') {
						complete = true;
					}
				}

				return complete;
			}
		},
		watch: {
			form: {
				handler: function (newForm, oldForm) {
			        this.pushValues(newForm);
		        },
		        deep: true
			}
		},
		mounted() {
			// show existing data if any present
			if(this.existingData !== undefined) {
				this.form = this.existingData;
			} else {
				// push values when first mounted 
				this.pushValues();

				this.form.id 			= this.plusOne.id;
				this.form.first_name 	= this.plusOne.first_name;
				this.form.last_name 	= this.plusOne.last_name;
				this.form.day 			= this.plusOne.day;
				this.form.night 		= this.plusOne.night;
			}
		},
		methods: {
			pushValues(form) {
				// push values back to parent
				this.$emit('updated', {
					'sectionNum': this.sectionNum,
					'formData': form,
					'complete': this.isCompleted,
				});
			}
		}
	}
</script>