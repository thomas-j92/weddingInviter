<template>
	<div>
		Guests

		<b-card>
			<b-table :fields="fields" :items="people">
				<template slot="options" slot-scope="data">
					<b-dropdown text="Options" class="m-md-2">
					    <b-dropdown-item>First Action</b-dropdown-item>
					    <b-dropdown-item>Second Action</b-dropdown-item>
					    <b-dropdown-item>Third Action</b-dropdown-item>
					    <b-dropdown-divider></b-dropdown-divider>
					    <b-dropdown-item disabled>Disabled action</b-dropdown-item>
					  </b-dropdown>
				</template>
			</b-table>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'admin.guests.main',
		created() {
			this.getAll();
		},
		data() {
			return {
				fields: [
					'first_name',
					'last_name',
					'email',
					{key: 'options', label: ''}
				],
				people: [],
			}
		},
		computed: {
			filter: function() {
				return this.$route.params.filter;
			}
		},
		watch: {
		    '$route' (to, from) {
		    	this.getAll();
		    }
		},
		methods: {
			getAll: function() {
				const self = this;
				axios.get(this.baseUrl + '/api/people/showAll/'+this.filter)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.people = resp.data;
					 	}
					 })
			}
		}
	}
</script>