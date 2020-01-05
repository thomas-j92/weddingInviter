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
			sendInvite() {
				const self = this;

				axios.get("/api/invite/send/"+this.inviteId)
					 .then((resp) => {

					 })
			}
		},
		mounted() {
			this.getInvite();
		}
	}
</script>