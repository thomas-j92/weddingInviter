<template>
	<div class="admin-container">

		<links></links>
		
		<div class="content-container">
			<admin-header></admin-header>
			<div class="content">
				<router-view></router-view>
			</div>
		</div>
			

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
		},
	}
</script>