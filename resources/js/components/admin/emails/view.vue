<template>
	<div id="emailViewer">
		<b-card>
			<b-card-title>
				{{ email.subject }}
			</b-card-title>
			<b-card-body>
				<div v-if="isLoaded">
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