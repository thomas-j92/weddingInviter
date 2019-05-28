<template>
	<div class="row">
		<div class="col-md-2 d-none d-md-block bg-light sidebar">
			<b-nav vertical class="w-25">
				<b-nav-item to="dashboard">Dashboard</b-nav-item>
				<b-nav-item to="guests">Guests</b-nav-item>
				<b-nav-item to="reports">Reports</b-nav-item>
				<b-nav-item to="emails">Emails</b-nav-item>
			</b-nav>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'admin.links',
	}
</script>