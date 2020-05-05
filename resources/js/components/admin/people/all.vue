<template>
	<div>
		<b-card>
			<div v-if="uploads && uploads.length > 0">
				<b-alert :show="uploads.length > 0">Pending upload found. <b-link :to="{name: 'upload.process', params: {id: uploads[0].id}}" >Click here</b-link> to view it.</b-alert>
			</div>
			<b-card-body>
				<b-card-title>People ({{ people.length }})
					<b-button class="float-right" variant="success" v-b-modal.create-guest><i class="fas fa-plus-circle mr-1"></i> Create</b-button>
					<b-button class="float-right mr-1" variant="outline-primary" v-b-modal.bulk-upload-modal><i class="fas fa-upload mr-1"></i> Bulk Upload</b-button>
				</b-card-title>
				<div v-if="isLoaded">
					<b-table :fields="fields" :items="people" v-if="people.length > 0">
						<template v-slot:cell(invite_status)="data">
							<b-badge :variant="getBadgeVariant(data.item.invite_status)">{{  data.item.invite_status | capitalize }}</b-badge>
						</template>
						<template v-slot:cell(invite_type)="data">
							<b-badge v-if="data.item.invite" :variant="getBadgeVariant(data.item.invite.type)">{{  data.item.invite.type | capitalize }}</b-badge>
							<p class="text-secondary" v-else>-</p>
						</template>
						<template v-slot:cell(btns)="data">
							<b-dropdown class="person-dropdown">
								<b-dropdown-group>
									<b-dropdown-text class="dropdown-title">Person</b-dropdown-text>
							    	<b-dropdown-item @click="showModal('delete-person-modal', data.item)"><i class="fas fa-trash mr-1"></i> Delete</b-dropdown-item>
							    </b-dropdown-group>

							    <b-dropdown-group>
									<b-dropdown-text class="dropdown-title">Invite</b-dropdown-text>
								    <b-dropdown-item :to="'/admin/invite/create/'+data.item.id" v-if="!data.item.invite"><i class="fas fa-edit mr-1"></i> Create</b-dropdown-item>
								    <b-dropdown-item :to="'/admin/invite/view/'+data.item.invite.invite_id" v-else><i class="fas fa-eye mr-1"></i> View</b-dropdown-item>
								</b-dropdown-group>
							</b-dropdown>
						</template>
					</b-table>
					<no-data v-else></no-data>
				</div>
				<loading v-else></loading>
			</b-card-body>
		</b-card>

		<b-modal id='delete-person-modal' :title="'Delete ' + selected.first_name + ' ' + selected.last_name" @ok="deletePerson()" ok-title="Delete" ok-variant="danger">
		
			<b-alert v-if="selected.invite && selected.invite.type == 'main'" show>
				This person is the main guest of <b-link :to="{name: 'invite.view', params: {'inviteId': selected.invite.id}}" target="_blank">an invite</b-link>. Deleting this person will also delete the invite.
			</b-alert>

			<b-row v-if="selected.invite && selected.invite.type == 'additional'">
				<b-col>
					<b-alert show>Person is an additional guest on <b-link :to="{name: 'invite.view', params: {'inviteId': selected.invite.id}}" target="_blank">an invite</b-link>.</b-alert>
					<b-form-group label="What action should be taken concerning the Invite?">
				      <b-form-radio v-model="deleteOption" name="deleteOption" value="unassign_guest">Unassign person from invite</b-form-radio>
				      <b-form-radio v-model="deleteOption" name="deleteOption" value="delete_invite">Delete invite</b-form-radio>
				    </b-form-group>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col>
					<p>Are you sure you still want to delete {{ selected.first_name }} {{ selected.last_name }}?</p>
				</b-col>
			</b-row>
		</b-modal>

		<b-modal 
		id="create-guest"
		title="Create Guest"
		@ok="createGuest"
		ok-title="Create">
			<div class="d-block text-center">
				<b-container fluid>
					<b-row class="my-1" v-for="(item_type, item_name) in create.inputs" :key="item_name">
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
		id="bulk-upload-modal"
		title="Bulk Upload"
		@ok="bulkUpload"
		ok-title="Upload">
			<p>Used to bulk upload people into the system via CSV</p>
			<p>You can download the template by <a href="/storage/uploadTemplate.csv" download>clicking here</a></p>
			<b-container>
				<b-row>
					<b-col>
						<b-form-file
					      v-model="uploadFile"
					      :state="Boolean(uploadFile)"
					      placeholder="Choose a file or drop it here..."
					      drop-placeholder="Drop file here..."
					    ></b-form-file>
					</b-col>
				</b-row>
			</b-container>
		</b-modal>
	</div>
</template>

<script>
	export default {
		name: 'people.all',
		data() {
			return {
				people: [],
				fields: [
					{
						key: 'first_name',
						label: 'First name'
					},
					{
						key: 'last_name',
						label: 'Last name'
					},
					{
						key: 'invite_type',
						label: 'Guest type'
					},
					{
						key: 'invite_status',
						label: 'Invite status'
					},
					{
						key: 'btns',
						label: ''
					}
				],
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
				deleteOption: 'unassign_guest',
				uploadFile: null,
				uploads: null,
			}
		},
		methods: {
			get(){
				const self = this;

				axios.get(this.baseUrl+'/api/people/get_all')
					 .then((resp) => {
					 	if(resp.data) {
					 		self.people 	= resp.data;

					 		self.isLoaded 	= true;
					 	}
					 })
			},
			getCsvUploads() {
				const self = this;

				axios.get(this.baseUrl+'/api/csv_upload/getAll')
					 .then((resp) => {
					 	if(resp.data) {
					 		self.uploads = resp.data;
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
			getBadgeVariant(value) {
				let variant = '';

				if(value == 'awaiting_reply' || value == 'additional') {
					variant = 'warning';
				}

				if(value == 'not attending') {
					variant = 'danger';
				}

				if(value == 'attending' || value == 'main') {
					variant = 'success';
				}

				return variant;
			},
			deletePerson() {
				const self = this;

				let postData = {
					type: (self.selected.invite) ? self.selected.invite.type : null,
					option: self.deleteOption
				};

				// attempt to delete Person
				axios.put(this.baseUrl+'/api/people/deletePerson/'+self.selected.id, postData)
					 .then((resp) => {
					 	if(resp.data) {
					 		if(resp.data.success) {
					 			self.toast('Removed', resp.data.message, 'danger');
					 		}

					 		// refresh data
					 		self.get();
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
			showModal(modal, item) {
				// mark item as selected item
				this.selected = item;

				// show modal
				this.$bvModal.show(modal);
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
					 	self.get();
					 });
			},
			bulkUpload() {
				const self = this;

				// form data
				let formData = new FormData();
				formData.append('file', this.uploadFile);

				axios.post(this.baseUrl+'/api/people/upload', formData)
					 .then((resp) => {
					 	if(resp.data && resp.data.success) {
					 		self.$router.push({name: 'upload.process', params: {id: resp.data.id}});
					 	} else {
					 		self.toast('Error', resp.data.message, 'error');
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'error');
					 })
			}
		},
		filters: {
		  capitalize: function (value) {
		    if(!value) {
		    	return '';
		    }

		    value = value.toString().replace('_', ' ');

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
		mounted() {
			this.get();
			this.getCsvUploads();
		}
	}
</script>