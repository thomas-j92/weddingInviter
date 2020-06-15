<template>
	<div class="person-view">
		<b-card class="custom" no-body>
			<b-card-header>
				{{ fullName }}
			</b-card-header>
			<b-card-body>
				<div v-if="isLoaded">
					<b-row>
						<b-col sm="3">
							<div class="person-image">
								<b-img :src="baseUrl+'/'+person.image" fluid></b-img>
								<div class="upload-btn" v-b-modal.upload-modal>
									Upload
								</div>
							</div>
						</b-col>
						<b-col sm="4">
							<h5>Email</h5>
							<p>{{ person.email }} </p>
						</b-col>
						<b-col sm="4">
							<h5>Created at</h5>
							<p>{{ person.created_at_format }}</p>
						</b-col>
					</b-row>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>

		<b-modal id="upload-modal" title="Upload image" ok-title="Upload" @ok="upload">
			<b-form-file
		      v-model="file"
		      :state="Boolean(file)"
		      placeholder="Choose a file or drop it here..."
		      drop-placeholder="Drop file here..."
		    ></b-form-file>
		</b-modal>
	</div>
</template>

<script>
	export default {
		name: 'person.view',
		data() {
			return {
				isLoaded: false,
				person: null,
				file: null
			}
		},
		computed: {
			personId() {
				return this.$route.params.id;
			},
			fullName() {
				let name = '';

				if(this.person) {
					name = this.person.first_name + ' ' + this.person.last_name;
				}

				return name;
			}
		},
		mounted() {
			this.get();
		},
		methods: {
			get() {
				const self = this;

				axios.get(this.baseUrl+'/api/people/'+this.personId)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.person = resp.data;

					 		// stop loading gif
					 		self.isLoaded = true;
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
			upload() {
				const self = this;

				// structure form data
				let formData = new FormData();
				formData.append('file', this.file);

				axios.post(this.baseUrl+'/api/people/avatar', formData)
					 .then((resp) => {

					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			}
		}
	}
</script>