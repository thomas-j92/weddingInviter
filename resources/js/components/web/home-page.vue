<template>
	<div>
		<div v-if="!isLoading">
			<hero-section></hero-section>

			<div class="home-countdown">
				<div class="max-w-7xl mx-auto sm:px-8 lg:px-16">
					<div class="grid grid-cols-1 sm:grid-cols-2">
						<div class="flex">
							<h2 class="w-full text-center self-center text-3xl font-extrabold">Days until the big day</h2>
						</div>
						<countdown></countdown>
					</div>
				</div>
			</div>

			<timeline></timeline>


			<faqs></faqs>

			<location></location>
		</div>
		<div class="loading-container" v-else>
			<loading></loading>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'homePage',
		data() {
			return {
				isLoading: true,
			}
		},
		mounted() {
			this.isLoading = false;
		}
	}
</script>