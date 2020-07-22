<template>
	<div class="nav" id="admin-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-8" id="title-container">
					<img src="/images/mill-barn-pink.png" class="logo" alt="Logo">
					<p class="main-title">The Jinks Wedding</p>
				</div>
				
				<div class="col-sm-4">
					<div id="sign-out">
						<div class="row">
							<div class="col-sm-6 offset-sm-2">
								<p class="item text-right">{{ user.name }}</p>
							</div>
							<div class="col-sm-4">
								<a class="item text-left" href="/logout">Sign out</a>
							</div>
						</div>
					</div>
				</div>
		    </div>
	    </div>
	</div>
</template>

<script>
	export default {
		name: 'adminHeader',
		data() {
			return {
				user: false,
			}
		},
		methods: {
			getUser: function() {
				axios.get(this.baseUrl + '/user/get')
					 .then((resp) => {
					 		this.user = resp.data;
					 })
			}
		},
		mounted() {
			this.getUser();
		}
	}
</script>