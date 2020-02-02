<template>
	<div>
		<h2>{{ guestDetails.first_name }} {{ guestDetails.last_name }}</h2>

		<transition-group name="list" tag="p">
		<b-form-group label="Will you be attending the day?" key="question_1">
		  <b-form-radio-group
		    id="attending-day"
		    v-model="form.rsvp.day"
		    :options="rsvpOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>

		<b-form-group label="Will you be attending the night?" v-if="form.rsvp.day" key="question_2">
		  <b-form-radio-group
		    id="attending-night"
		    v-model="form.rsvp.night"
		    :options="rsvpOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>

		<b-form-group label="Do you have any dietary requirements?" v-if="form.rsvp.night && (form.rsvp.day == 'true' || form.rsvp.night == 'true')" key="question_3">
		  <b-form-radio-group
		    id="dietary-requirements"
		    v-model="form.diet.requirement"
		    :options="dietOptions"
		    buttons
		    button-variant="outline-primary"
		    name="radios-btn-default"
		  ></b-form-radio-group>
		</b-form-group>
		
		<b-form-group label="What dietary requirements do you have?" v-if="form.diet.requirement == 'other'" key="question_4">
			<b-form-textarea
		      id="dietary-requirements-details"
		      v-model="form.diet.details"
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
		name: 'invite.section.rsvp',
		props: ['guest', 'sectionNum', 'existingData'],
		data() {
			return {
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
				form: {
					rsvp: {
						day: "",
						night: "",
					},
					diet: {
						requirement: '',
						details: ''
					},
				},
			}
		},
		computed: {
			guestDetails() {
				return this.guest.person;
			},
			isCompleted() {
				let complete = false;

				if(this.form.diet.requirement != '') {
					if(this.form.diet.requirement == 'other') {
						if(this.form.diet.details != '') {
							complete = true;
						}
					} else {
						complete = true;
					}
				} else {
					if(this.form.rsvp.day == 'false' && this.form.rsvp.night == 'false') {
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
			}

			// push values when first mounted 
			this.pushValues();
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