<template>
	<div id="emailViewer">
		<b-breadcrumb :items="breadcrumbs"></b-breadcrumb>
		<b-card v-if="email">
			<b-card-body>
				<div v-if="isLoaded">
					<b-row>
						<b-col>
							<h2>Subject</h2> 
							<p>{{ email.subject }}</p>
						</b-col>

						<b-col>
							<h2>Sent on</h2> 
							<p>{{ email.created_at_uk }}</p>
						</b-col>

						<b-col>
							<h2>To</h2> 
							<p>{{ email.email_address }}</p>
						</b-col>

						<b-col>
							<h2>CC</h2> 
							<p v-if="email.cc">{{ email.cc }}</p>
							<p v-else>N/A</p>
						</b-col>

						<b-col>
							<h2>Invite</h2> 
							<b-link :to="{'name': 'invite.view', 'params': {'inviteId': email.invite_id}}">View Invite</b-link>
						</b-col>
					</b-row>
					<b-row>
						<b-col>
							<div v-html="email.html" id="viewer"></div>
						</b-col>
					</b-row>
				</div>
				<no-data v-else></no-data>	
			</b-card-body>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'email.view',
		data() {
			return {
				email: null,
				isLoaded: false,
				breadcrumbs: [
					{
						text: 'Emails',
						to: { name: 'emails.view' }
					},
					{
						text: 'Email',
						to: { name: 'email.view' }
					},
				]
			}
		},
		computed: {
			emailId() {
				return this.$route.params.id;
			}
		},
		methods: {
			getEmail() {
				const self = this;

				// mark as not loaded
				self.isLoaded = false;

				axios.get(this.baseUrl+'/api/email/'+this.emailId)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.email = resp.data;
					 	}

					 	self.isLoaded = true;
					 });
			}
		},
		mounted() {
			this.getEmail();
		}
	}
</script>