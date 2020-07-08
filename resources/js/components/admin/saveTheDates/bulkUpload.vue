<template>
	<div class="std-bulk-upload">
		<b-card>
			<b-breadcrumb :items="breadcrumbs"></b-breadcrumb>

			<h2>Bulk upload</h2>
			
			<div class="std" v-for="(std, index) in stds.elements">
				<save-std :invite-id="std.invite_id" v-if="showing == index" @sent="updateBulkUpload"></save-std>
			</div>

			<b-button @click="next">Next</b-button>
		</b-card>
	</div>
</template>

<script>
	import saveStd from '../saveTheDates/send.vue';
	export default {
		name: 'saveTheDates.bulk',
		data() {
			return {
				breadcrumbs: [
					{
						text: 'Save The Dates',
						to: { name: 'saveTheDates.all' }
					},
					{
						text: 'Bulk Send',
					},
				],
				stds: [],
				showing: null,
			}
		},
		components: {
			saveStd
		},
		mounted() {
			this.getAll();
		},
		computed: {
			id() {
				return this.$route.params.id;
			},
		},
		methods: {
			getAll() {
				const self = this;

				axios.get(this.baseUrl+'/api/save_the_date/getBulkSend/'+this.id)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.stds = resp.data;

					 		self.showing = 0;
					 	}
					 })
			},
			next() {
				this.showing++;
			},
			updateBulkUpload() {
				const self = this;

				// update status
				var element = self.stds.elements[this.showing];
				axios.get(this.baseUrl+'/api/save_the_date/bulkElementSent/'+element.id)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.toast('Success', 'Save the date has been sent');

					 		self.next();
					 	}
					 })
			}
		}
	}
</script>