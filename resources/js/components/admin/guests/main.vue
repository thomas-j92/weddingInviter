<template>
	<div>
		<b-card>
			<b-card-body>
				<b-card-title>{{ formattedFilter | capitalize }} <b-button class="float-right" variant="success" v-b-modal.create-guest><i class="fas fa-plus-circle"></i> Create</b-button></b-card-title>
				<div v-if="isLoaded">
					<b-table :fields="fields" :items="people" v-if="people.length > 0">
						<template slot="options" slot-scope="data">
							<b-dropdown text="Options" class="m-md-2 guest-dropdown">
								<b-dropdown-group>
									<b-dropdown-text class="dropdown-title">Person</b-dropdown-text>
								    <b-dropdown-item v-b-modal.edit-guest @click="changeSelected(data.item)"><i class="fas fa-edit"></i> Edit</b-dropdown-item>
								    <b-dropdown-item v-b-modal.remove-guest @click="changeSelected(data.item)"><i class="fas fa-times-circle"></i> Remove</b-dropdown-item>
								</b-dropdown-group>
								
								<b-dropdown-group>
								    <b-dropdown-text class="dropdown-title">Invite</b-dropdown-text>
								    <b-dropdown-item :to="'/admin/invite/'+data.item.id"><i class="fas fa-edit"></i> Invite...</b-dropdown-item>
								</b-dropdown-group>
							  </b-dropdown>
						</template>
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>

		<b-modal 
		id="create-guest"
		title="Create Guest"
		@ok="createGuest">
			<div class="d-block text-center">
				<b-container fluid>
					<b-row class="my-1" v-for="(item_type, item_name)  in create.inputs" :key="item_name">
					  <b-col sm="3">
					    <label :for="`type-${item_name}`">{{ item_name | prettify }}:</label>
					  </b-col>
					  <b-col sm="9">
					    <b-form-input :id="`type-${item_name}`" :type="item_type" v-model="create.models[item_name]"></b-form-input>
					  </b-col>
					</b-row>
				</b-container>
			</div>
		</b-modal>

		<b-modal 
		id="edit-guest"
		title="Edit Guest"
		@ok="editGuest">
			<div class="d-block text-center">
				<b-container fluid>
					<b-row class="my-1" v-for="(item_type, item_name)  in create.inputs" :key="item_name">
					  <b-col sm="3">
					    <label :for="`type-${item_name}`">{{ item_name | prettify }}:</label>
					  </b-col>
					  <b-col sm="9">
					    <b-form-input :id="`type-${item_name}`" :type="item_type" v-model="selected[item_name]"></b-form-input>
					  </b-col>
					</b-row>
				</b-container>
			</div>
		</b-modal>

		<b-modal 
		id="remove-guest"
		title="Remove Guest"
		@ok="removeGuest">
			<p>Are you sure you want to remove <span class="confirm-element">{{ selected.first_name }} {{ selected.last_name }}</span>?</p>
		</b-modal>
	</div>
</template>

<script>
	export default {
		name: 'admin.guests.main',
		mounted() {
			this.getAll();
		},
		created() {

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
				create: {
					inputs: {
						'first_name': 'text',
						'last_name': 'text',
						'email': 'text'
					},
					models: {
						'first_name': '',
						'last_name': '',
						'email':''
					}
				},
				isLoaded: false,
				selected: false,
			}
		},
		computed: {
			filter: function() {
				return this.$route.params.filter;
			},
			formattedFilter: function() {
				// get filter
				let filter = this.$route.params.filter;
				
				// replace underscores with space
				let replacedString = filter.replace("_", " ");

				// add count to title if data is loaded
				if(this.isLoaded) {
					replacedString += ' ('+this.people.length+')';
				}

				return replacedString;
			}
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
				axios.get(this.baseUrl + '/api/people/showAll/'+this.filter)
					 .then((resp) => {
					 	if(resp.data) {
					 		self.people 	= resp.data;

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