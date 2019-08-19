<template>
	<section>
		<div v-if="inviteId">
			<h2>Invite</h2>
		</div>
		<div v-else>
			<b-card>
				<b-breadcrumb :items="breadcrumbs"></b-breadcrumb>
				<b-card-title>Setup Invite</b-card-title>
				<b-card-text>
					Setup a new invite. You can assign multiple guests to the same invite using the 'Additional Guests' section. Only the main guest will be able to RSVP for everyone assigned to the invite.
				</b-card-text>
			</b-card>

			<b-card>
				<b-card-header>Guest</b-card-header>

				<b-card-body>
					<div v-if="!personLoading">
						<b-row>
							<b-col sm="3">
								<h5>Name</h5>
								<p>{{ person.first_name }} {{ person.last_name }}</p>
							</b-col>
							<b-col sm="5">
								<h5>Email</h5>
								<p>{{ person.email }}</p>
							</b-col>
							<b-col sm="4">
								<h5>Type</h5>
								<b-row>
									<b-col>
										<b-form-checkbox v-model="form.type.day" name="check-button" @change="form.type.night = true" switch>
									      Day
									    </b-form-checkbox>
									</b-col>
									<b-col>
										<b-form-checkbox v-model="form.type.night" name="check-button" switch>
									      Night
									    </b-form-checkbox>
									</b-col>
								</b-row>
							</b-col>
						</b-row>
					</div>
					<div v-else>
						<loading></loading>
					</div>
				</b-card-body>
			</b-card>

			<b-card>
				<b-card-header>
					Additional Guests
				</b-card-header>

				<b-card-body>
					<div v-if="!additional.loading">
						<b-table 
							:items="additional.data"
							:fields="additional.fields"
							id="additionalGuests_tbl"
							:per-page="additional.perPage"
      						:current-page="additional.currentPage"
						>
							<template slot="check" slot-scope="data">
								<b-form-checkbox v-model="form.additionalGuest[data.item.id]" :value="data.item.id" switch>
							      
							    </b-form-checkbox>
							</template>
						</b-table>

						<b-pagination
					      v-model="additional.currentPage"
					      :total-rows="rows"
					      :per-page="additional.perPage"
					      aria-controls="additionalGuests_tbl"
					      align="center"
					    ></b-pagination>
					</div>
					<div v-else>
						<loading></loading>
					</div>
				</b-card-body>
			</b-card>

			<b-card>
				<b-card-header>
					Plus Ones
				</b-card-header>

				<b-card-body>
					<div class="plus-ones">
						<b-row v-for="plus in form.plus_ones">
							<b-col>
								<b-form-input v-model="plus.first_name" placeholder="First Name..."></b-form-input>
							</b-col>
							<b-col>
								<b-form-input v-model="plus.last_name" placeholder="Last Name..."></b-form-input>
							</b-col>
							<b-col>
								<b-row>
									<b-col>
										<b-form-checkbox
										  class="hide-checkbox"
									      v-model="plus.vegetarian"
									      value="true"
									      unchecked-value="false"
									    >
											<i class="fas fa-carrot selected-icon" v-if="plus.vegetarian == 'true'"></i>
											<i class="fas fa-carrot unselected-icon" v-else></i>
									    </b-form-checkbox>
									</b-col>
									
									<b-col>
									    <b-form-checkbox
										  class="hide-checkbox"
									      v-model="plus.vegan"
									      value="true"
									      unchecked-value="false"
									    >
											<i class="fab fa-vimeo-square selected-icon" v-if="plus.vegan == 'true'"></i>
											<i class="fab fa-vimeo-square unselected-icon" v-else></i>
									    </b-form-checkbox>
									</b-col>

									<b-col>
									    <b-form-checkbox
										  class="hide-checkbox"
									      
									      value="true"
									      unchecked-value="false"
									      v-b-modal.addRequirements_mdl
									      @click="selectedPlusOne = plus"
									    >
											<i class="fas fa-utensils selected-icon" v-if="plus.requirements == 'true'"></i>
											<i class="fas fa-utensils unselected-icon" v-else></i>
									    </b-form-checkbox>
									</b-col>
								</b-row>
							</b-col>
						</b-row>
					</div>
					<b-button block variant="outline-primary" @click="addPlusOne"><i class="fas fa-plus-circle"></i> Plus One</b-button>
					<!-- <b-form-input id="range-1" v-model="form.plus_ones" type="range" min="0" max="2"></b-form-input>

					<div class="mt-2">Value: {{ form.plus_ones }}</div> -->
				</b-card-body>
			</b-card>

			<b-card>
				<b-button block variant="primary" @click="makeInvite">Make Invite</b-button>
			</b-card>
		</div>

		<b-modal
		id="addRequirements_mdl"
		title="Add Dietary Requirements">
		<textarea v-model="selectedPlusOne.requirements"></textarea>
		</b-modal>
	</section>
</template>

<script>
	export default {
		name: 'admin.invite.main',
		computed: {
			personId() {
				return this.$route.params.personId;
			},
			inviteId() {
				return this.$route.params.inviteId;
			},
			rows() {
				return this.additional.data.length;
			},
			breadcrumbs() {
				let crumbs = [];

				if(this.person) {
					crumbs = [
						{
							text: 'Admin',
							to: { name: 'admin.dashboard' }
						},
						{
							text: "Guests",
							to: { name: 'admin.guests', params: { 'filter': this.person.invite_status }}
						},
						{
							text: 'Invite',
							href: '#'
						}
					];
				}

				return crumbs;
			}
		},
		filters: {
			capitalize: function (value) {
				if (!value) return ''
				value = value.toString()
				return value.charAt(0).toUpperCase() + value.slice(1)
			}
		},
		data() {
			return {
				person: null,
				personLoading: true,
				additional: {
					data: null,
					loading: true,
					perPage: 3,
        			currentPage: 1,
        			fields: [
						{
							key: 'check',
							label: ''
						},
						{
							key: 'name',
							label: 'Name',
							sortable: true
						},
						{
							key: 'email',
							label: 'Email',
							sortable: true
						},
			        ],
				},
				form: {
					type: {
						day: true,
						night: true
					},
					plus_ones: [],
					additionalGuest: [],
				},
				selectedPlusOne: [],
			}
		},
		mounted() {
			// get person that will be assigned to invite
			this.getPerson();
		},
		methods: {
			getPerson: function() {
				const self = this;

				// start loading
				this.personLoading = true;

				// get person details
				axios.get(this.baseUrl+"/api/people/"+this.personId)
						 .then((resp) => {
						 	if(resp.data) {
						 		self.person = resp.data;

						 		// stop loading
						 		self.personLoading = false;

						 		// get additional guests that can be assigned to invite
								this.getAdditional();
						 	}	
						 })
			},
			getAdditional: function() {
				const self = this;

				// start loading
				this.additional.loading = true;

				// get list of additional guests that can be assigned to invite
				axios.get(this.baseUrl+"/api/people/showAll/not_invited")
					 .then((resp) => {
					 	if(resp.data) {
						 	// filter all not invited guests
						 	let additionalArr = [];
						 	$.each(resp.data, function(i, guest) {
						 		if(guest.id !== self.person.id) {
						 			// add full name
						 			guest.name = guest.first_name + " " + guest.last_name;

						 			// add column for radio button
						 			guest.check = '';

						 			// add to array
						 			additionalArr.push(guest);
						 		}
						 	});
						 	self.additional.data = additionalArr;
					 	}

					 	// stop loading
					 	self.additional.loading = false;
					 });
			},
			makeInvite: function() {
				const self = this;

				// collect data to be stored
				let inviteArr = {
					type: self.form.type,
					additionalGuests: self.form.additionalGuest
				}

				// Create Invite
				axios.post(this.baseUrl+"/api/invite", inviteArr)
					 .then((resp) => {
					 	console.log(resp);
					 })
			},
			addPlusOne: function() {
				this.form.plus_ones.push({});
			}
		}
	}
</script>