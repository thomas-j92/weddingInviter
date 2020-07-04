<template>
	<div>

		<b-card>
			<b-card-body>
				<b-tabs content-class="mt-3">
					<b-tab :title="'Sent'+ ((isLoaded) ? ' ('+saveTheDates.length+')' : '')" active>
						<h3 class="pb-3 pt-1">Sent <span v-if="isLoaded">({{ saveTheDates.length }})</span></h3>
						<div v-if="isLoaded">
							<b-table :items="saveTheDates" :fields="fields" v-if="saveTheDates.length > 0">
								<template v-slot:cell(options)="data">
									<b-dropdown text="Options" class="guest-dropdown" size="sm">
										<b-dropdown-group>
											<b-dropdown-text class="dropdown-title">Invite</b-dropdown-text>
										    <b-dropdown-item :to="'/admin/invite/view/'+data.item.invite_id"><i class="fas fa-eye mr-1"></i> View</b-dropdown-item>
										</b-dropdown-group>
									  </b-dropdown>
								</template>

								<template v-slot:cell(email)="data">
									<b-link :to="{'name': 'email.view', 'params': {'id': data.item.email_id}}">View Email</b-link>
								</template>

								<template v-slot:cell(CC_format)="data">
									<div class="cc-container">
										<div class="cc" v-for="e in data.item.CC_format">{{ e }}</div>
									</div>
								</template>
							</b-table>
							<no-data v-else></no-data>
						</div>
						<loading v-else></loading>
					</b-tab>
					<b-tab :title="'Not Sent'+ ((isLoaded) ? ' ('+noSaveTheDate.length+')' : '')">
						<b-row>
							<b-col offset="3" cols="6">
								<b-card v-if="isLoaded && bulkRequests && bulkRequests.length > 0" no-body>
									<b-card-header>You having pending bulk uploads</b-card-header>
									<b-table :items="bulkRequests" :fields="bulkRequestFields">
										<template v-slot:cell(link)="data">
											<b-link :to="{'name': 'saveTheDates.bulk', params: {'id': data.item.id}}">Complete</b-link>
										</template>
									</b-table>
								</b-card>
							</b-col>
						</b-row>

						<h3 class="pb-3 pt-1">
							Not Sent 
							<span v-if="isLoaded">({{ noSaveTheDate.length }})</span>
							<b-button class="float-right" @click="toggleSelect">{{ bulkText }}</b-button>
							<b-button class="float-right mr-2" @click="saveBulkUpload" v-if="bulkSend && bulkSendElements.length > 0">Bulk Send</b-button>
						</h3>
						
						<div v-if="isLoaded">
							<b-table :items="noSaveTheDate" :fields="noSaveTheDateFields" v-if="noSaveTheDate.length > 0">
								<template v-slot:cell(bulkUpload)="data">
									<b-form-checkbox
								      :id="'checkbox-'+data.item.id"
								      v-model="bulkSendElements"
								      name="bulkSendElements"
								      :value="data.item.id"
								    >
								    </b-form-checkbox>
								</template>

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
					</b-tab>
				</b-tabs>
			</b-card-body>
		</b-card>
	</div>
</template>

<script>
	export default {
		name: 'saveTheDates.all',
		data() {
			return {
				allSaveTheDates: false,
				isLoaded: false,
				fields: [
					{
						key: 'created_at_format',
						label: 'Sent on'
					},
					{
						key: 'to',
					},
					{
						key: 'CC_format',
						label: 'CC'
					},
					{
						key: 'Email'
					},
					{
						key: 'options'
					}
				],
				bulkRequestFields: [
					{
						key: 'status',
						label: 'Status'
					},
					{
						key: 'created_at_format',
						label: 'Created At',
					},
					{
						key: 'link',
						label: ''
					}
				],
				bulkText: 'Show Select',
				bulkSend: false,
				bulkSendElements: [],
				bulkRequests: false,
			}
		},
		mounted() {
			// get STD data
			this.getAll();

			// get STD bulk upload data
			this.getBulkRequests();
		},
		computed: {
			saveTheDates() {
				var stds = false;

				if(this.allSaveTheDates) {
					stds = this.allSaveTheDates.sent;
				}

				return stds;
			},
			noSaveTheDate() {
				var stds = false;

				if(this.allSaveTheDates) {
					stds = this.allSaveTheDates.not_sent;
				}

				return stds;
			},
			noSaveTheDateFields() {
				var fieldArr1 = [];

				if(this.bulkSend) {
					fieldArr1.push({
						key: 'bulkUpload',
						label: 'Bulk upload?'
					})
				}

				var fieldArr2 = [
					{key: 'main_guest', label: 'Main guest'},
					{key: 'invite_type', label: 'Invite type'},
					{key: 'invite_status', label: 'Invite status'},
					{key: 'rsvp_day', label: "Day"},
					{key: 'rsvp_night', label: "Night"},
					{key: 'options', label: ''}
				];

				return fieldArr1.concat(fieldArr2);
			},
		},
		methods: {
			getAll() {
				const self = this;

				axios.get(this.baseUrl+'/api/save_the_date/getAll')
					 .then((resp) => {
					 	if(resp.data) {
					 		// store saveTheDates
					 		self.allSaveTheDates = resp.data;

					 		// stop loading
					 		self.isLoaded = true;
					 	} else {
					 		self.toast('An error occurred', error, 'danger');
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			},
			getBulkRequests() {
				const self = this;

				axios.get(this.baseUrl+'/api/save_the_date/getBulkRequests')
					 .then((resp) => {
					 	if(resp.data) {
					 		// store saveTheDates
					 		self.bulkRequests = resp.data;
					 	} else {
					 		self.toast('An error occurred', error, 'danger');
					 	}
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
					},
			toggleSelect() {
				if(this.bulkSend) {
					this.bulkSend = false;
					this.bulkText = 'Show Select';
				} else {
					this.bulkSend = true;
					this.bulkText = 'Hide Select';
				}
			},
			saveBulkUpload() {
				const self = this;

				axios.post(this.baseUrl+'/api/save_the_date/saveBulkSend', this.bulkSendElements)
					 .then((resp) => {
					 	// if(resp.data) {
					 	// 	// store saveTheDates
					 	// 	self.allSaveTheDates = resp.data;

					 	// 	// stop loading
					 	// 	self.isLoaded = true;
					 	// } else {
					 	// 	self.toast('An error occurred', error, 'danger');
					 	// }
					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			}
		}
	}
</script>