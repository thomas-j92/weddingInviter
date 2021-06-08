<template>
	<div class="web-invite-container">
		<div v-if="!isLoading">
			<router-view :invite="invite"></router-view>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'invitation.layout',
		data() {
			return {
				invite: false,
				isLoading: true,
			}
		},
		computed: {
			code() {
				return this.$route.params.code;
			}
		},
		mounted() {
			this.load();
		},
		methods: {
			load() {
				const self = this;

				self.isLoading = true;

				axios.get(this.baseUrl+'/api/invite/getByCode/'+this.code)
						 .then((resp) => {
						 	if(resp.data) {
						 		self.invite = resp.data;
						 	}

						 	self.isLoading = false;
						 })
			}
		}
	}
</script>