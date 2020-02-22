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
				</div>
				<div v-else>
					<loading></loading>
				</div>
			</b-card-body>
		</b-card>

		<b-card class="custom" no-body>
			<b-card-header>
				Additional Guests

				<b-button class="float-right expand">Add</b-button>
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
			}
		},
		mounted() {
			// get invite details
			this.getInvite();

			// get emails 
			this.getEmails();
		}
	}
</script>