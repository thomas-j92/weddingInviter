<template>
	<div>
		<div class="ribbon">
			<h2 class="inner-ribbon">{{ guestDetails.first_name }} {{ guestDetails.last_name }}</h2>
		</div>
		<div class="clear-both"></div>

		<div class="px-3 rsvp-slides">

			<div class="back-btn-container">
				<button @click="back" class="bg-pink px-4 rounded-md" v-if="showBackBtn">Back</button>
			</div>
			<div class="slides relative">

				<transition-group name="slide" tag="p">
					<b-form-group label="Will you be attending the day?" key="question_1" v-show="step == 1">
					  <b-form-radio-group
					    id="attending-day"
					    v-model="form.rsvp.day"
					    :options="rsvpOptions"
					    buttons
					    button-variant="outline-primary"
					    name="radios-btn-default"
					  ></b-form-radio-group>
					</b-form-group>

					<b-form-group label="Will you be attending the night?" v-show="step == 2" key="question_2">
					  <b-form-radio-group
					    id="attending-night"
					    v-model="form.rsvp.night"
					    :options="rsvpOptions"
					    buttons
					    button-variant="outline-primary"
					    name="radios-btn-default"
					  ></b-form-radio-group>
					</b-form-group>

					<b-form-group label="Do you have any dietary requirements?" v-show="step == 3" key="question_3">
					  <b-form-radio-group
					    id="dietary-requirements"
					    v-model="form.diet.requirement"
					    :options="dietOptions"
					    buttons
					    button-variant="outline-primary"
					    name="radios-btn-default"
					  ></b-form-radio-group>
					</b-form-group>
					
					<b-form-group label="What dietary requirements do you have?" v-show="step == 4" key="question_4">
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
		</div>
	</div>
</template>

<script>
	export default {
		name: 'invite.section.rsvp',
		props: ['guest', 'sectionNum', 'existingData', 'invite'],
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
					id: null,
					rsvp: {
						day: "",
						night: "",
					},
					diet: {
						requirement: '',
						details: ''
					},
					type: 'guest',
					guest_type: '',
				},
				step: 0,
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
					if((!this.invite.day || (this.invite.day && this.form.rsvp.day == 'false')) && (!this.invite.night || (this.invite.night && this.form.rsvp.night == 'false'))) {
						complete = true;
					}
				}

				return complete;
			},
			showBackBtn() {
				let show = false;

				switch(this.step) {
					case 2:
						if(this.invite.day) {
							show = true;
						}
					break;
					case 3:
					case 4:
						show = true;
					break;
				}

				return show;
			}
		},
		watch: {
			'form.rsvp.day':function (newForm, oldForm) {
				if(this.invite.night == 1) {
					this.step = 2;
				} else if(this.form.rsvp.day == 'true') {
					this.step = 3;
				}
				
		        this.pushValues(this.form);
			},
			'form.rsvp.night':function (newForm, oldForm) {
				if(this.form.rsvp.day == 'true' || this.form.rsvp.night == 'true') {
					this.step = 3;
				}
				
		        this.pushValues(this.form);
			},
			'form.diet.requirement':function (newForm, oldForm) {
				if(this.form.diet.requirement == 'other') {
					this.step = 4;
				}
		        this.pushValues(this.form);
			},
			'form.diet.details':function (newForm, oldForm) {
		        this.pushValues(this.form);
			}
		},
		mounted() {
			// calculate step
			if(this.invite.day == 1) {
				this.step = 1;
			} else if(this.invite.night == 1) {
				this.step = 2;
			}

			// show existing data if any present
			if(this.existingData !== undefined) {
				this.form = this.existingData;
			}

			// store if guest is main guest or additional
			this.form.guest_type = this.guest.type;

			// push values when first mounted 
			this.pushValues();

			// store guest ID's in array - makes it easier to identify when saving Invite responses
			this.form.id = this.guestDetails.id;
		},
		methods: {
			back() {
				switch(this.step) {
					case 3:
						if(this.invite.night == 1) {
							this.step = 2;
						} else {
							this.step = 1;
						}
					break;
					default:
						this.step--;
				}

				this.pushValues();
			},
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