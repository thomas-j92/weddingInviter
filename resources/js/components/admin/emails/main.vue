<template>
	<div>
		<b-card>
			<b-card-title>
				Emails
			</b-card-title>
			<b-card-body>
				<div v-if="hasLoaded">
					<b-table :items="emails" :fields="fields" v-if="emails.length > 0">
						<template v-slot:cell(view)="data">
							<b-button :to="{name: 'email.view', params: {id: data.item.id}}">View</b-button>
						</template>
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'admin.reports.main',
		data() {
			return {
				hasLoaded: false,
				emails: [],
				fields: [
					{
						key: 'email_address',
						label: 'Email Address'
					},
					'subject',
					{
						key: 'created_at_uk',
						label: 'Created At',
					},
					'view'
				]
			}
		},
		methods: {
			getEmails() {
				const self = this;

				self.hasLoaded = false;

				// get all emails
				axios.get(this.baseUrl+'/api/email/getAll')
					 .then((resp) => {
					 	if(resp.data) {
					 		// store emails
					 		this.emails = resp.data;

					 		// mark as loaded
					 		self.hasLoaded = true;
					 	}
					 })
			}
		},
		mounted() {
			// get all emails 
			this.getEmails();
		}
	}
</script>