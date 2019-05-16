<template>
	<div>
		<links></links>

		<router-view></router-view>
	</div>
</template>

<script>
	import links from './inc/links';
	export default {
		name: 'admin_viewer',
		components: {
		links
		}
	}
</script>