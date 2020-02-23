<template>
	<section id="viewInvite">
		<h2>Invite</h2>

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
							<h4>
								<b-badge variant="secondary" v-if="main_guest.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="main_guest.attending_day == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="main_guest.attending_day == 0">No</b-badge>
							</h4>
						</b-col>
						<b-col sm="4">
							<h5>Attending Night</h5>
							<h4>
								<b-badge variant="secondary" v-if="main_guest.rsvp == 0">N/A</b-badge>
								<b-badge variant="success" v-else-if="main_guest.attending_night == 1">Yes</b-badge>
								<b-badge variant="danger" v-else="main_guest.attending_night == 0">No</b-badge>
							</h4>
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
					<b-table :items="additional_guests" v-if="additional_guests.length > 0">
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
	</section>
</template>

<script>
	export default {
		name: 'admin.invite.view',
		data() {
			return {
				inviteLoading: true,
				main_guest: false,
				additional_guests: false,
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
					 		self.additional_guests = resp.data.additional_guests;

					 		// store Invite details
					 		self.invite = resp.data;

					 		// stop loading gif
					 		self.inviteLoading = false;
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

					 })
			},
			getAdditional: function() {
				const self = this;

				// start loading
				this.all_additional_guests.loading = true;

				console.log('updated');

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
			}
		},
		mounted() {
			// get invite details
			this.getInvite();

			// get emails 
			this.getEmails();

			// get all available additional guests
			this.getAdditional();
		}
	}
</script>