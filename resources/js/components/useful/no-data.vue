<template>
	<div>
		<b-alert show variant="secondary" class="no-data">{{ message }}</b-alert>
	</div>
</template>
<script>
	export default {
		name: "no-data",
		props: ['text'],
		computed: {
			message() {
				let m = 'No data found';

				if(this.text) {
					m = this.text;
				}

				return m;
			}
		}
	}
</script>