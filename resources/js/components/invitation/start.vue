<template>
	<div class="py-4">
		<div>
			<div class="mobile-envelope d-lg-none">
				<div class="note">
					<div class="form-wrapper">
						<div class="invite-container">
							<inviteIntro :invite="invite"></inviteIntro>
							<div class="buttons">
								<router-link class="rsvp-btn" :to="{name: 'invite.rsvp', params: {'code': invite.code}}" tag="button">Click here to RSVP</router-link>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="email d-none d-lg-block">
				<div class="envelope">
					<div class="back paper"></div>
					<div class="note">
						<div class="form-wrapper">
							<div class="invite-container">

								<inviteIntro :invite="invite"></inviteIntro>
								<div class="buttons">
									<router-link class="rsvp-btn" :to="{name: 'invite.rsvp', params: {'code': invite.code}}" tag="button">Click here to RSVP</router-link>
								</div>
							</div>
						</div>
					</div>
					<div class="front paper"></div>
					<div class="seal envelope-btn">
						<div class="inner-seal">
							<span class="seal-text">T&J</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import inviteIntro from './sections/inviteIntro.vue'

	export default {
		name: 'invitation.view',
		props: ['invite'],
		components: {
			inviteIntro
		},
		data() {
			return {
			}
		},
		mounted() {
		},
		computed: {
		    isMobile() {
                if( screen.width <= 760 ) {
                    return true;
                }
                else {
                    return false;
                }
            }
		},
		methods: {
			getExistingData(sectionNo) {
				return this.formData[sectionNo];
			},
			submit() {
				const self = this;

				// structure data
				let postData = {
					'formData': self.formData,
					'code': self.invite.code,
				};

				// submit invite data
				axios.post(this.baseUrl+'/api/invite/web', postData)
					 .then((resp) => {
					 	if(resp.data) {

					 		if(resp.data.success) {
					 			self.response.success 	= true;
					 		} else {
					 			self.response.error 	= true;
					 		}
					 		self.response.message = resp.data.message;
					 	}
					 })
			}
		}
	}
</script>