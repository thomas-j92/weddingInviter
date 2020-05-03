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

						<template v-slot:cell(solution)="data">
							
						</template>
						
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>
	</section>
</template>

<script>
	export default {
		name: 'upload.process',
		data() {
			return {
				isLoaded: false,
				upload: false,
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
			}
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
						key: 'solution',
						label: ''
					}
				];
			}
		},
	}
</script>