<template>
	<div class="std-bulk-upload">
		<b-card>
			<b-breadcrumb :items="breadcrumbs"></b-breadcrumb>

			<h2>Bulk upload</h2>

			<save-std></save-std>
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
					 	}
					 })
			}
		}
	}
</script>