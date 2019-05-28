<template>
	<div>
		<!-- <admin-header></admin-header> -->
		<links></links>

		<router-view></router-view>
	</div>
</template>

<script>
	import links from './inc/links';
	import adminHeader from './inc/adminHeader';
	export default {
		name: 'admin_viewer',
		components: {
			links,
			adminHeader
		}
	}
</script>