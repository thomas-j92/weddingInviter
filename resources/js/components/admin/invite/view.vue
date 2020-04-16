<template>
	<section id="viewInvite">
		<b-container>
			<b-row>
				<b-col>
					<h3 class="mt-3">Invite</h3>
				</b-col>
			</b-row>
		</b-container>

		<b-card class="custom" no-body>
			<b-card-header>Guest</b-card-header>

			<b-card-body>
				<div v-if="!inviteLoading">
					<b-row>
						<b-col sm="3">
							<h5>Name</h5>
							<p>{{ main_guest.person.first_name }} {{ main_guest.person.last_name }}</p>
						</b-col>
						<b-col sm="5">
							<h5>Email</h5>
							<p>{{ main_guest.person.email }}</p>
						</b-col>
						<b-col sm="4">
							<h5>Type</h5>
							<p>{{ inviteType }}</p>
						</b-col>
					</b-row>
					<b-row>
						<b-col sm="3">
							<h5>Status</h5>
							<h4>
								<b-badge variant="success" v-if="main_guest.rsvp == 1">RSVP'ed</b-badge>
								<b-badge variant="warning" v-else>Awaiting Reply</b-badge>
							</h4>
						</b-col>
						<b-col sm="5">
							<h5>Attending Day</h5>
							<h4 class="d-inline">
								<b-badge variant="secondary" v-if="main_guest.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="main_guest.attending_day == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="main_guest.attending_day == 0">No</b-badge>
							</h4>
							<b-link @click='showRsvpModal("main", main_guest)'>Update</b-link>
						</b-col>
						<b-col sm="4">
							<h5>Attending Night</h5>
							<h4 class="d-inline">
								<b-badge variant="secondary" v-if="main_guest.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="main_guest.attending_night == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="main_guest.attending_night == 0">No</b-badge>
							</h4>
							<b-link @click='showRsvpModal("main", main_guest)'>Update</b-link>
						</b-col>
					</b-row>
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Additional Guests

				<b-button class="float-right expand" v-b-modal.add-additional-guests>Add</b-button>
			</b-card-header>

			<b-card-body>
				<div v-if="!inviteLoading">
					<b-table :items="additional_guests.data" :fields="additional_guests.fields" v-if="additional_guests.data.length > 0">
						<template v-slot:cell(guest_name)="data">
							{{ data.item.person.first_name }} {{ data.item.person.last_name }}
						</template>

						<template v-slot:cell(guest_email)="data">
							{{ data.item.person.email }}
						</template>

						<template v-slot:cell(attending_day)="data">
							<h4>
								<b-badge variant="secondary" v-if="data.item.person.invite.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="data.item.person.invite.attending_day == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="data.item.person.invite.attending_day == 0">No</b-badge>
							</h4>
						</template>

						<template v-slot:cell(attending_night)="data">
							<h4>
								<b-badge variant="secondary" v-if="data.item.person.invite.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="data.item.person.invite.attending_night == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="data.item.person.invite.attending_night == 0">No</b-badge>
							</h4>
						</template>

						<template v-slot:cell(btns)="data">
							<b-dropdown id="dropdown-1" size="sm" dropleft class="m-0">
								<template v-slot:button-content>
							      <i class="fas fa-cog"></i>
							    </template>
								
								<b-dropdown-item v-b-modal.edit-rsvp @click='showRsvpModal("secondary", data.item)'><i class="far fa-envelope"></i> RSVP</b-dropdown-item>
							    <b-dropdown-divider></b-dropdown-divider>
								<b-dropdown-item @click="deleteAdditionalGuest(data.item.id)"><i class="fas fa-trash"></i> Delete</b-dropdown-item>
							</b-dropdown>
						</template>
					</b-table>
					<no-data text="No additional guests found." v-else></no-data>
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Plus Ones

				<b-button class="float-right expand" v-b-modal.add-plus-ones>Add</b-button>
			</b-card-header>

			<b-card-body>
				<div v-if="!inviteLoading">
					<b-table :items="plus_ones.data" :fields="plus_ones.fields" v-if="plus_ones.data.length > 0">
						<template v-slot:cell(first_name)="data">
							<div v-if="data.item.first_name !== null">
								{{ data.item.first_name }}
							</div>
							<div v-else>
								Not specified
							</div>
						</template>

						<template v-slot:cell(last_name)="data">
							<div v-if="data.item.last_name !== null">
								{{ data.item.last_name }}
							</div>
							<div v-else>
								Not specified
							</div>
						</template>

						<template v-slot:cell(btns)="data">
							<b-button variant="danger" size="sm" @click="deletePlusOne(data.item.id)"><i class="fas fa-trash"></i></b-button>
						</template>
					</b-table>
					<no-data text="No plus ones found." v-else></no-data>
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Functions
			</b-card-header>

			<b-card-body>
				<b-row>
					<b-col sm="2">
						<b-button block variant="primary" @click="sendInvite">Send</b-button>
					</b-col>
				</b-row>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Emails
			</b-card-header>

			<b-card-body>
				<div v-if="!emails.loading">
					<b-table :items="emails.data" :fields="emails.fields" v-if="emails.data.length > 0">
						<template v-slot:cell(viewBtn)="data">
							<b-button :to="{name: 'email.view', params: {id: data.item.id}}">View</b-button>
						</template>
					</b-table>
					<no-data text="No emails found." v-else></no-data>
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Activity
			</b-card-header>

			<b-card-body>
				<div v-if="!activity.loading">
					<b-table :fields="activity.fields" :items="activity.data" v-if="activity.data.length > 0">
						<template v-slot:cell(type)="data">
							{{ data.item.properties.item | capitalize }}
						</template>
						<template v-slot:cell(updates)="data">
							<b-button v-b-modal.activity_updates v-if="data.item.properties.old" size="sm" @click="activity.selected = data.item" block>View</b-button>
						</template>
						<template v-slot:cell(area)="data">
							<b-badge variant="secondary" v-if="data.item.properties.area == 'admin'">{{ data.item.properties.area }}</b-badge>
							<b-badge variant="primary" v-else>{{ data.item.properties.area }}</b-badge>
						</template>
					</b-table>
					<no-data text="No activity found." v-else></no-data>
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-modal id="activity_updates" title="Activity log" ok-only>
			<b-table :items="activityUpdates">
				<template v-slot:cell(item)="data">
					{{ data.item.item | capitalize }}
				</template>
				<template v-slot:cell(from)="data">
					<p v-if="data.item.from == 1">Yes</p>
					<p v-else-if="data.item.from == 0">No</p>
					<p v-else>{{ data.item.from }}</p>
				</template>
				<template v-slot:cell(to)="data">
					<p v-if="data.item.to == 1">Yes</p>
					<p v-else-if="data.item.to == 0">No</p>
					<p v-else>{{ data.item.to }}</p>
				</template>
			</b-table>
		</b-modal>

		<b-modal id="add-additional-guests" title="Add Additional Guests" ok-title="Submit" @ok="updateAdditionalGuests">
			<div v-if="!all_additional_guests.loading">
				<b-table 
					:items="all_additional_guests.data"
					:fields="all_additional_guests.fields"
					id="additionalGuests_tbl"
					:per-page="all_additional_guests.perPage"
						:current-page="all_additional_guests.currentPage"
				>
					<template v-slot:cell(check)="data">
						<b-form-checkbox v-model="all_additional_guests.selected[data.item.id]" :value="data.item.id" switch>
					      
					    </b-form-checkbox>
					</template>
				</b-table>

				<b-pagination
			      v-model="all_additional_guests.currentPage"
			      :total-rows="all_additional_guests.data.length"
			      :per-page="all_additional_guests.perPage"
			      aria-controls="additionalGuests_tbl"
			      align="center"
			    ></b-pagination>
			</div>
			<div v-else>
				<loading></loading>
			</div>
		</b-modal>

		<b-modal id="add-plus-ones" title="Add Plus One" ok-title="Submit" @ok="addPlusOne">
			<b-row>
				<b-col>
					<b-form-group
					id="input-group-1"
					label="First name:"
					label-for="plus_one_first_name"

					>
						<b-form-input
						  id="plus_one_first_name"
						  v-model="plus_ones.form.first_name"
						  type="text"
						  required
						  placeholder="First name"
						></b-form-input>
					</b-form-group>
				</b-col>
				<b-col>
					<b-form-group
					id="input-group-2"
					label="Last name:"
					label-for="plus_one_last_name"

					>
						<b-form-input
						id="plus_one_last_name"
						v-model="plus_ones.form.last_name"
						type="text"
						required
						placeholder="Last name"
						></b-form-input>
					</b-form-group>
				</b-col>
			</b-row>
			<b-row>
				<b-col>
				     <b-form-group label="Dietary requirements">
				      <b-form-radio-group
				        id="btn-radios-1"
				        v-model="plus_ones.form.dietary_requirements"
				        :options="dietary_requirements"
				        buttons
				        button-variant="outline-primary"
				        name="radios-btn-default"
				      ></b-form-radio-group>
				    </b-form-group>
				</b-col>
			</b-row>
			<b-row v-if="plus_ones.form.dietary_requirements == 'other'">
				<b-col>
					<b-form-group
					id="input-group-3"
					label="Details:"
					label-for="plus_one_details"

					>
					<b-form-textarea
				      id="textarea"
				      v-model="plus_ones.form.details"
				      placeholder="Dietary requirements"
				      rows="3"
				      max-rows="6"
				    ></b-form-textarea>
					</b-form-group>
				</b-col>
			</b-row>
		</b-modal>

		<b-modal id="edit-rsvp" title="Edit RSVP" ok-title="Update" @ok="updateRsvp">
			<div v-if="rsvp.selected !== null">
		    	<b-form-group label="Are they attending the day?">
		    		<b-container>
		    			<b-row>
				    		<b-col>
					     		<b-form-radio v-model="rsvp.selected.attending_day" name="rsvp_day" value="1">Yes</b-form-radio>
					     	</b-col>
					     	<b-col>
					      		<b-form-radio v-model="rsvp.selected.attending_day" name="rsvp_day" value="0">No</b-form-radio>
					      	</b-col>
				      	</b-row>
	    			</b-container>
			    </b-form-group>

			    <b-form-group label="Are they attending the night?">
		    		<b-container>
		    			<b-row>
				    		<b-col>
					     		<b-form-radio v-model="rsvp.selected.attending_night" name="rsvp_night" value="1">Yes</b-form-radio>
					     	</b-col>
					     	<b-col>
					      		<b-form-radio v-model="rsvp.selected.attending_night" name="rsvp_night" value="0">No</b-form-radio>
					      	</b-col>
				      	</b-row>
	    			</b-container>
			    </b-form-group>
		    </div>
		</b-modal>
	</section>
</template>

<script>
	export default {
		name: 'admin.invite.view',
		data() {
			return {
				inviteLoading: true,
				main_guest: false,
				additional_guests: {
					data: false,
					fields: [
						{
							key: 'guest_name',
							label: 'Name'
						},
						{
							key: 'guest_email',
							label: 'Email'
						},
						{
							key: 'attending_day',
							label: 'Day'
						},
						{
							key: 'attending_night',
							label: 'Night'
						},
						{
							key: 'btns',
							label: ''
						}
					]
				},
				all_additional_guests: {
					loading: true,
					data: false,
					perPage: 5,
        			currentPage: 1,
        			fields: [
						{
							key: 'check',
							label: ''
						},
						{
							key: 'name',
							label: 'Name',
							sortable: true
						},
						{
							key: 'email',
							label: 'Email',
							sortable: true
						},
			        ],
			        selected: [],
				},
				invite: false,
				emails: {
					loading: true,
					data: false,
					fields: [
						{
							key: 'subject',
							label: 'Subject'
						},
						{
							key: 'email_address',
							label: 'Email'
						},
						{
							key: 'created_at_uk',
							label: 'Created At'
						},
						{
							key: 'viewBtn',
							label: ''
						}
					]
				}, 
				emailsLoading: true,
				dietary_requirements: [
					'none',
					'vegan',
					'vegetarian',
					'other'
				],
				plus_ones: {
					form: {
						first_name: null,
						last_name: null,
						dietary_requirements: 'none',
						details: null,
					},
					data: false,
					fields: [
						{
							key: 'first_name',
							label: 'First name'
						},
						{
							key: 'last_name',
							label: 'Last name'
						},
						{
							key: 'btns',
							label: ''
						}
					]
				},
				rsvp: {
					guestType: null,
					selected: null,
				},
				activity: {
					data: [],
					fields: [
						{
							key: 'description',
							label: 'Description'
						},
						{
							key: 'area',
							label: 'Area'
						},
						{
							key: 'type',
							label: 'Type'
						},
						{
							key: 'updates',
							label: 'Updates'
						},
						{
							key: 'created_at_format',
							label: 'Date'
						}
					],
					loading: false,
					selected: false,
				}
			}
		},
		computed: {
			inviteId() {
				return this.$route.params.inviteId;
			},
			inviteType() {
				let inviteType = '';

				if(this.invite) {
					if(this.invite.day && this.invite.night) {
						inviteType = 'Day & Night';
					} else if(this.invite.day) {
						inviteType = 'Day';
					} else if(this.invite.night) {
						inviteType = 'Night';
					}
				}
				
				return inviteType;
			},
			activityUpdates() {
				let updates = [];

				if(this.activity.selected) {
					let newAttributes 	= this.activity.selected.properties.attributes;
					let oldAttributes 	= this.activity.selected.properties.old;

					Object.keys(newAttributes).forEach(function(key) {
						let oldVal = oldAttributes[key];
						let newVal = newAttributes[key];

						if(oldVal != newVal) {
							updates.push({
								item: key.replace("_", " "),
								from: oldVal,
								to: newVal
							});
						}
					})
				}

				return updates;
			}
		},
		methods: {
			getInvite() {
				const self = this;

				axios.get("/api/invite/"+this.inviteId)
					 .then((resp) => {
					 	if(resp.data) {
					 		// store main person assigned to Invite
					 		self.main_guest = resp.data.main_guest;

					 		// store additional guests assigned to Invite
					 		self.additional_guests.data = resp.data.additional_guests;

					 		// store Plus One details
					 		self.plus_ones.data = resp.data.plus_ones;

					 		// store Invite details
					 		self.invite = resp.data;

					 		// stop loading gif
					 		self.inviteLoading = false;

					 		// get activity 
							self.getActivity();
					 	}
					 })
			},
			getEmails() {
				const self = this;

				self.emails.loading = true;

				// get all emails assigned to Invite
				axios.get(this.baseUrl+'/api/invite/getEmails/'+this.inviteId)
					 .then((resp) => {

					 	if(resp.data) {
					 		self.emails.data = resp.data;
					 	}

					 	self.emails.loading = false
					 });
			},
			sendInvite() {
				const self = this;

				axios.get("/api/invite/send/"+this.inviteId)
					 .then((resp) => {
					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Sent', 'Email has been sent to main guest');

					 			// refresh additional data
					 			self.getEmails();
					 		}
					 	}
					 })
			},
			getAdditional: function() {
				const self = this;

				// start loading
				this.all_additional_guests.loading = true;

				// get list of additional guests that can be assigned to invite
				axios.get(this.baseUrl+"/api/people/showAll/not_invited")
					 .then((resp) => {
					 	if(resp.data) {
						 	// filter all not invited guests
						 	let additionalArr = [];
						 	$.each(resp.data, function(i, guest) {
						 		if(guest.id !== self.main_guest.id) {
						 			// add full name
						 			guest.name = guest.first_name + " " + guest.last_name;

						 			// add column for radio button
						 			guest.check = '';

						 			// add to array
						 			additionalArr.push(guest);
						 		}
						 	});
						 	self.all_additional_guests.data = additionalArr;
					 	}

					 	// stop loading
					 	self.all_additional_guests.loading = false;
					 });
			},
			updateAdditionalGuests() {

				const self = this;

				// add additional guests
				let additionalGuestArr = {
					inviteId: self.invite.id,
					guests: self.all_additional_guests.selected
				}
				axios.put(this.baseUrl+"/api/invite/addAdditionalGuests", additionalGuestArr)
					 .then((resp) => {
					 	if(resp.data) {
					 		if(resp.data.numAdded > 0) {
					 			self.toast('Additional guest(s) added', resp.data.numAdded + ' record(s) added');
					 		} else {
					 			self.toast('Error', 'No data added', 'danger');
					 		}
					 		
					 		// refresh additional data
					 		self.getInvite();
					 	}
					 })
			},
			deleteAdditionalGuest(id) {

				const self = this;

				axios.delete(this.baseUrl+"/api/invite/deleteAdditionalGuest/"+id)
					 .then((resp) => {

					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Removed', 'Additional guest has been deleted', 'danger');

					 			// refresh additional data
					 			self.getInvite();
					 		}
					 	}
					 });
			},
			addPlusOne() {

				const self = this;

				// structure data that will be sent via ajax
				let plusOneData = {
					data: self.plus_ones.form,
					inviteId: this.inviteId
				};	

				axios.post(this.baseUrl+"/api/invite/addPlusOne", plusOneData)
					 .then((resp) => {

					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Added', 'Plus one added to Invite', 'danger');

					 			// refresh additional data
					 			self.getInvite();
					 		}
					 	}

					 })
			},
			deletePlusOne(id) {

				const self = this;

				axios.delete(this.baseUrl+"/api/invite/deletePlusOne/"+id)
					 .then((resp) => {

					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Removed', 'Plus one has been deleted', 'danger');

					 			// refresh additional data
					 			self.getInvite();
					 		}
					 	}
					 });
			},
			updateRsvp() {

				const self = this;

				// update RSVP data
				axios.put(this.baseUrl+'/api/invite/updateRsvp', self.rsvp)
					 .then((resp) => {
					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Updated', resp.data.message);
					 		} else {
					 			self.toast('Error', resp.data.message, 'danger');
					 		}
					 	}

					 	// refresh data
					 	self.getInvite();
					 });
			},
			showRsvpModal(guest_type, guest) {
				this.rsvp.guestType = guest_type;
				this.rsvp.selected	= guest;

				this.$bvModal.show('edit-rsvp');
			},
			getActivity() {

				const self = this;

				// mark as loading
				self.activity.loading = true;

				// get activity
				axios.get(this.baseUrl+"/api/invite/activity/"+self.inviteId)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.activity.data = resp.data;
					 	}

					 	// marked as loaded
					 	self.activity.loading = false;
					 });
			}
		},
		mounted() {
			// get invite details
			this.getInvite();

			// get emails 
			this.getEmails();

			// get all available additional guests
			this.getAdditional();
		},
		filters: {
		  capitalize: function (value) {
		    if (!value) return ''
		    value = value.toString()
		    return value.charAt(0).toUpperCase() + value.slice(1)
		  }
		}
	}
</script>