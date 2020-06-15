<template>
	<b-card>
		<b-card-body>
			<b-card-title>
				Save the dates ({{ saveTheDates.length }})
			</b-card-title>
			<div v-if="isLoaded">
				<!-- <b-table :fields="fields" :items="invites" v-if="invites.length > 0">
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
						<b-card no-body>
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

						<b-card no-body>
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
				<no-data v-else></no-data> -->
			</div>
			<loading v-else></loading>
		</b-card-body>
	</b-card>
</template>

<script>
	export default {
		name: 'saveTheDates.all',
		data() {
			return {
				saveTheDates: false,
				isLoaded: false,
			}
		},
		mounted() {
			this.getAll();
		},
		methods: {
			getAll() {
				const self = this;

				axios.get(this.baseUrl+'/api/saveTheDates/getAll')
					 .then((resp) => {

					 })
					 .catch((error) => {
					 	self.toast('An error occurred', error, 'danger');
					 })
			}
		}
	}
</script>