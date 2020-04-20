<template>
	<div>
		<b-card>
			<b-card-body>
				<b-card-title>People ({{ people.length }})<b-button class="float-right" variant="success" v-b-modal.create-guest><i class="fas fa-plus-circle"></i> Create</b-button></b-card-title>
				<div v-if="isLoaded">
					<b-table :fields="fields" :items="people" v-if="people.length > 0">
						<template v-slot:cell(invite_status)="data">
							<b-badge :variant="getBadgeVariant(data.item.invite_status)">{{  data.item.invite_status | capitalize }}</b-badge>
						</template>
						<!-- 		
								<b-dropdown-group>
								    <b-dropdown-text class="dropdown-title">Invite</b-dropdown-text>
								    <b-dropdown-item :to="'/admin/invite/create/'+data.item.id" v-if="!data.item.invite"><i class="fas fa-edit"></i> Create</b-dropdown-item>
								    <b-dropdown-item :to="'/admin/invite/view/'+data.item.invite.invite_id" v-else><i class="fas fa-eye"></i> View</b-dropdown-item>
								</b-dropdown-group>
							  </b-dropdown>
						</template> -->
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
						key: 'invite_status',
						label: 'Invite status'
					}
				],
				isLoaded: false,
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
			getBadgeVariant(inviteStatus) {
				let variant = '';

				if(inviteStatus == 'awaiting_reply') {
					variant = 'warning';
				}

				if(inviteStatus == 'not attending') {
					variant = 'danger';
				}

				if(inviteStatus == 'attending') {
					variant = 'success';
				}

				return variant;
			}
		},
		filters: {
		  capitalize: function (value) {
		    if(!value) {
		    	return '';
		    }

		    value = value.toString().replace('_', ' ');

		    return value.charAt(0).toUpperCase() + value.slice(1)
		  }
		},
		mounted() {
			this.get();
		}
	}
</script>