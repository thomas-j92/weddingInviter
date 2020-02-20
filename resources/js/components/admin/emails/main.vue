<template>
	<div>
		<b-card>
			<b-card-title>
				Emails
			</b-card-title>
			<b-card-body>
				<b-table :items="emails" :fields="fields">
					<template v-slot:cell(view)="data">
						<b-button>View</b-button>
					</template>
				</b-table>
			</b-card-body>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'admin.reports.main',
		data() {
			return {
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

				// get all emails
				axios.get(this.baseUrl+'/api/email/getAll')
					 .then((resp) => {
					 	if(resp.data) {
					 		this.emails = resp.data;
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