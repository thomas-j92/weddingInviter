<template>
	<div>
		<b-card no-body>
				<b-card-title>
					Invites ({{ invites.length }})
				</b-card-title>
			<b-card-body>
				<div v-if="isLoaded">
					<b-table :fields="fields" :items="invites" v-if="invites.length > 0">
						<template v-slot:cell(main_guest)="data">
							{{ data.item.main_guest.person.first_name }} {{ data.item.main_guest.person.last_name }}
						</template>

						<template v-slot:cell(invite_type)="data">
							<span v-if="data.item.day == 1 && data.item.night == 1">Day & Night</span>
							<span v-else-if="data.item.day == 1">Day</span>
							<span v-else-if="data.item.night == 1">Night</span>
							<span v-else>N/A</span>
						</template>

						<template v-slot:cell(invite_status)="data">
							<span v-if="data.item.rsvp" class="badge badge-success">
								RSVP'd
							</span>
							<span class="badge badge-warning" v-else>
								Awaiting reply
							</span>
						</template>

						<template v-slot:cell(rsvp_day)="data">
							<span v-if="data.item.main_guest.rsvp">
								<span v-if="data.item.main_guest.attending_day" class="badge badge-success"></span>
								<span v-else class="badge badge-danger"></span>
							</span>
							<span class="badge badge-secondary" v-else>
								N/A
							</span>
						</template>

						<template v-slot:cell(rsvp_night)="data">
							<span v-if="data.item.main_guest.rsvp">
								<span v-if="data.item.main_guest.attending_night" class="badge badge-success"></span>
								<span v-else class="badge badge-danger"></span>
							</span>
							<span class="badge badge-secondary" v-else>
								N/A
							</span>
						</template>

						<template v-slot:cell(num_additionals)="data">
							<b-link v-if="(data.item.additional_guests.length + data.item.plus_ones.length) > 0" @click="data.toggleDetails">
								{{ data.item.additional_guests.length + data.item.plus_ones.length}}
								({{ data.detailsShowing ? 'hide' : 'show'}})
							</b-link>
							<span v-else>
								{{ data.item.additional_guests.length + data.item.plus_ones.length}}
							</span>
						</template>

						<template v-slot:cell(options)="data">
							<b-dropdown text="Options" class="guest-dropdown" size="sm">
								<b-dropdown-group>
									<b-dropdown-text class="dropdown-title">Invite</b-dropdown-text>
								    <b-dropdown-item :to="'/admin/invite/view/'+data.item.id"><i class="fas fa-eye mr-1"></i> View</b-dropdown-item>
								</b-dropdown-group>
							  </b-dropdown>
						</template>

						<template v-slot:row-details="data">
							<b-card v-if="data.item.additional_guests.length > 0" no-body>
								<b-card-header>
									Additional guests
								</b-card-header>
								<b-table :items="data.item.additional_guests" :fields="additionalFields">
									<template v-slot:cell(name)="row">
										{{ row.item.person.first_name }} {{ row.item.person.first_name}}
									</template>

									<template v-slot:cell(attending_day)="row">
										<span v-if="row.item.rsvp">
											<span v-if="row.item.attending_day" class="badge badge-success">Yes</span>
											<span v-else class="badge badge-danger">No</span>
										</span>
										<span class="badge badge-secondary" v-else>
											N/A
										</span>
									</template>

									<template v-slot:cell(attending_night)="row">
										<span v-if="row.item.rsvp">
											<span v-if="row.item.attending_night" class="badge badge-success">Yes</span>
											<span v-else class="badge badge-danger">No</span>
										</span>
										<span class="badge badge-secondary" v-else>
											N/A
										</span>
									</template>
								</b-table>
							</b-card>

							<b-card v-if="data.item.plus_ones.length > 0" no-body>
								<b-card-header>
									Plus ones
								</b-card-header>
								<b-table :items="data.item.plus_ones" :fields="additionalFields">
									<template v-slot:cell(name)="row">
										<span v-if="row.item.first_name || row.item.last_name">
											{{ row.item.first_name }} {{ row.item.last_name }}
										</span>
										<span v-else>Not specified</span>
									</template>

									<template v-slot:cell(attending_day)="row">
										<span v-if="row.item.rsvp">
											<span v-if="row.item.attending_day" class="badge badge-success">Yes</span>
											<span v-else class="badge badge-danger">No</span>
										</span>
										<span class="badge badge-secondary" v-else>
											N/A
										</span>
									</template>

									<template v-slot:cell(attending_night)="row">
										<span v-if="row.item.rsvp">
											<span v-if="row.item.attending_night" class="badge badge-success">Yes</span>
											<span v-else class="badge badge-danger">No</span>
										</span>
										<span class="badge badge-secondary" v-else>
											N/A
										</span>
									</template>
								</b-table>
							</b-card>
						</template>
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'admin.invites.all',
		mounted() {
			this.getAll();
		},
		created() {

		},
		data() {
			return {
				invites: [],
				fields: [
					{key: 'main_guest', label: 'Main guest'},
					{key: 'invite_type', label: 'Invite type'},
					{key: 'invite_status', label: 'Invite status'},
					{key: 'rsvp_day', label: "Day"},
					{key: 'rsvp_night', label: "Night"},
					{key: 'num_additionals', label: 'Additional guests'},
					{key: 'options', label: ''}
				],
				additionalFields: [
					{key: 'name', label: 'Name'},
					{key: 'attending_day', label: 'Attending day'},
					{key: 'attending_night', label: 'Attending night'}
				],
				isLoaded: false,
				selected: false,
			}
		},
		computed: {
			filter: function() {
				return this.$route.params.filter;
			},
			// formattedFilter: function() {
			// 	// get filter
			// 	let filter = this.$route.params.filter;
				
			// 	// replace underscores with space
			// 	let replacedString = filter.replace("_", " ");

			// 	// add count to title if data is loaded
			// 	if(this.isLoaded) {
			// 		replacedString += ' ('+this.people.length+')';
			// 	}

			// 	return replacedString;
			// }
		},
		filters: {
			capitalize: function (value) {
				if (!value) return ''
				value = value.toString()
				return value.charAt(0).toUpperCase() + value.slice(1)
			},
			prettify: function(value) {
				if (!value) return ''

				// replace underscores with space
				let replacedString = value.replace("_", " ");

				// capitalise 
				let tempVal 	= replacedString.toString();
				let capitalize 	= tempVal.charAt(0).toUpperCase() + tempVal.slice(1);
				
				return capitalize;
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

				this.isLoaded = false;
				axios.get(this.baseUrl + '/api/invite/getAll')
					 .then((resp) => {
					 	if(resp.data) {
					 		self.invites = resp.data;

					 		// mark component as loaded - will stop loading gif
					 		self.isLoaded 	= true;
					 	}
					 })
			},
			createGuest: function() {
				const self = this;

				let insertObj = {
					firstName: self.create.models.first_name,
					lastName: self.create.models.last_name,
					email: self.create.models.email
				};

				axios.post(this.baseUrl+'/api/people/', insertObj)
					 .then((resp) => {
					 	if(resp.data.response) {
					 		self.toast('Added', resp.data.message, 'success');
					 	} else {
					 		self.toast('Error', resp.data.message, 'error');
					 	}

					 	// refresh list
					 	self.getAll();
					 });
			},
			changeSelected: function(newEl) {
				this.selected = Object.assign({}, newEl);
			},
			removeGuest: function() {
				const self = this;

				axios.delete(this.baseUrl+'/api/people/'+this.selected.id)
					 .then((resp) => {
					 	if(resp.data.response) {
					 		self.toast('Removed', resp.data.message, 'error');
					 	} else {
					 		self.toast('Error', resp.data.message, 'error');
					 	}
						
						// reload data					 	
					 	self.getAll();
					 })
			},
			editGuest: function() {
				let self = this;
				let editArr = {
					first_name: this.selected.first_name,
					last_name: this.selected.last_name,
					email: this.selected.email
				}
				axios.patch(this.baseUrl+"/api/people/"+this.selected.id, editArr)
					 .then((resp) => {
					 	if(resp.data.response) {
					 		self.toast('Updated', resp.data.message, 'success');
					 	} else {
					 		self.toast('Error', resp.data.message, 'error');
					 	}
						
						// reload data					 	
					 	self.getAll();
					 })
			}
		}
	}
</script>