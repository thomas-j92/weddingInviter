<template>
	<section>
		<b-card>
			<b-card-body>
				<b-breadcrumb :items="breadcrumbs"></b-breadcrumb>
				
				<b-card-title>Bulk Upload</b-card-title>

				<div v-if="isLoaded">
					<b-table :fields="fields" :items="upload.uploads" v-if="upload.uploads.length > 0">
						<template v-slot:cell(guest_type)="data">
							<span v-if="data.item.day_guest && data.item.night_guest">Day & Night</span>
							<span v-else-if="data.item.day_guest">Day</span>
							<span v-else-if="data.item.night_guest">Night</span>
							<span v-else>N/A</span>
						</template>

						<template v-slot:cell(rsvp_day)="data">
							<span v-if="data.item.rsvp_day">Yes</span>
							<span v-else>No</span>
						</template>

						<template v-slot:cell(rsvp_night)="data">
							<span v-if="data.item.rsvp_night">Yes</span>
							<span v-else>No</span>
						</template>

						<template v-slot:cell(status)="data">
							<div class="upload-status" >
								<i class="fas fa-check" v-if="data.item.status == 'success'"></i>
								<i class="fas fa-times" v-else></i>
							</div>
						</template>

						<template v-slot:cell(solution)="data">
							<div v-if="data.item.status !== 'success'">
								<b-button size="sm" variant="success" @click="updateSelected(data.item)" v-b-modal.fix-modal>Fix</b-button>
							</div>
						</template>
						
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>

		<b-modal id="fix-modal" title="Fix upload" size="md" ok-variant="success" ok-title="Fix Upload" @ok="fix">
			<b-row>
				<b-col>
					<b-form-group
						id="firstName-fieldset"
						label="First name"
						label-for="firstName-input"
					>
						<b-form-input id="firstName-input" v-model="form.first_name" trim></b-form-input>
					</b-form-group>
				</b-col>
				
				<b-col>
					<b-form-group
						id="lastName-fieldset"
						label="Last name"
						label-for="lastName-input"
					>
						<b-form-input id="lastName-1" v-model="form.last_name" trim></b-form-input>
					</b-form-group>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col>
					<b-form-group
						id="email-fieldset"
						label="Email"
						label-for="email-input"
					>
						<b-form-input id="email-1" v-model="form.email" trim></b-form-input>
					</b-form-group>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col>
					<b-form-group label="Day guest?">
				      <b-form-radio-group
				        id="dayGuest-input"
				        v-model="form.day_guest"
				        :options="rsvpOptions"
				        plain
				        name="dayGuest"
				      ></b-form-radio-group>
				    </b-form-group>
				</b-col>
				
				<b-col>
				    <b-form-group label="Night guest?">
				      <b-form-radio-group
				        id="nightGuest-input"
				        v-model="form.night_guest"
				        :options="rsvpOptions"
				        plain
				        name="nightGuest"
				      ></b-form-radio-group>
				    </b-form-group>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col>
				    <b-form-group label="Rsvp day?">
				      <b-form-radio-group
				        id="rsvpDay-input"
				        v-model="form.rsvp_day"
				        :options="rsvpOptions"
				        plain
				        name="rsvpDay"
				      ></b-form-radio-group>
				    </b-form-group>
				</b-col>
				
				<b-col>
				    <b-form-group label="Rsvp night?">
				      <b-form-radio-group
				        id="rsvpNight-input"
				        v-model="form.rsvp_night"
				        :options="rsvpOptions"
				        plain
				        name="rsvpNight"
				      ></b-form-radio-group>
				    </b-form-group>
				</b-col>
			</b-row>
		</b-modal>
	</section>
</template>

<script>
	export default {
		name: 'upload.process',
		data() {
			return {
				isLoaded: false,
				upload: false,
				form: {
					id: null,
					first_name: null,
					last_name: null,
					email: null,
					day_guest: null,
					night_guest: null,
					rsvp_day: null,
					rsvp_night: null,
				}
			}
		}, 
		mounted() {
			this.get();
		},
		methods: {
			get() {
				const self = this;

				axios.get(this.baseUrl+'/api/csv_upload/'+this.uploadId)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.upload = resp.data;

					 		// stop loading gif
					 		self.isLoaded = true;
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
			updateSelected(data) {
				this.form.id 			= data.id;
				this.form.first_name 	= data.first_name;
				this.form.last_name 	= data.last_name;
				this.form.email 		= data.email;
				this.form.day_guest 	= data.day_guest;
				this.form.night_guest 	= data.night_guest;
				this.form.first_name = data.first_name;
			},
			fix(bvModalEvt) {
				bvModalEvt.preventDefault();

				const self = this;

				axios.put(this.baseUrl+'/api/csv_upload/'+this.form.id, this.form)
					 .then((resp) => {
					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Fixed', 'Person has been uploaded');

					 			// hide modal
					 			self.$bvModal.hide('fix-modal');

					 			// reload data
					 			self.get();

					 			// redirect
					 			self.$router.push({'name': 'people.all'});
					 		} else {
					 			let errors = '';
					 			resp.data.errors.forEach(error => {
					 				errors += error + '\n';
					 			})
					 			self.toast('Errors', errors, 'danger')
					 		}
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
		},
		computed: {
			uploadId() {
				return this.$route.params.id;
			},
			breadcrumbs() {
				let crumbs = [
					{
						text: 'People',
						to: { name: 'people.all' }
					},
					{
						text: 'Upload',
					}
				];

				return crumbs;
			}, 
			fields() {
				return [
					{
						key: 'first_name',
						label: 'First name'
					},
					{
						key: 'last_name',
						label: 'Last name'
					},
					{
						key: 'email',
						label: 'Email'
					},
					{
						key: 'guest_type',
						label: 'Guest Type'
					},
					{
						key: 'rsvp_day',
						label: 'Day'
					},
					{
						key: 'rsvp_night',
						label: 'Night'
					},
					{
						key: 'status',
						label: 'Uploaded?'
					},
					{
						key: 'solution',
						label: ''
					}
				];
			},
			rsvpOptions() {
				return [
					{ text: 'Yes', value: '1' },
					{ text: 'No', value: '0' },
				];
			}
		},
	}
</script>