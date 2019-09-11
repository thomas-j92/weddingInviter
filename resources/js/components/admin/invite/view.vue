<template>
	<section id="viewInvite">
		<h2>Invite</h2>

		<b-card>
			<b-card-header>Guest</b-card-header>

			<b-card-body>
				<div v-if="!inviteLoading">
					<b-row>
						<b-col sm="3">
							<h5>Name</h5>
							<p>{{ person.first_name }} {{ person.last_name }}</p>
						</b-col>
						<b-col sm="5">
							<h5>Email</h5>
							<p>{{ person.email }}</p>
						</b-col>
						<b-col sm="4">
							<h5>Type</h5>
							<b-row>
								<b-col>
									<b-form-checkbox v-model="form.type.day" name="check-button" @change="form.type.night = true" switch>
								      Day
								    </b-form-checkbox>
								</b-col>
								<b-col>
									<b-form-checkbox v-model="form.type.night" name="check-button" switch>
								      Night
								    </b-form-checkbox>
								</b-col>
							</b-row>
						</b-col>
					</b-row>
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
				person: false,
				invite: false,
			}
		},
		computed: {
			inviteId() {
				return this.$route.params.inviteId;
			},
		},
		methods: {
			getInvite() {
				const self = this;

				axios.get("/api/invite/"+this.inviteId)
					 .then((resp) => {
					 	if(resp.data) {
					 		// store main person assigned to Invite
					 		self.person = resp.data.main_guest;

					 		// store Invite details
					 		self.invite = resp.data;

					 		// stop loading gif
					 		self.inviteLoading = false;
					 	}
					 	console.log(resp);
					 })
			}
		},
		mounted() {
			this.getInvite();
		}
	}
</script>