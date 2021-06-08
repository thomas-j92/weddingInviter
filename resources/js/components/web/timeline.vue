<template>
	<div class="bg-white py-14" id="timeline">
		<div class="max-w-3xl mx-auto px-3 sm:px-8 lg:px-16">
			<h1>
				<span class="block text-base text-center text-pink font-semibold tracking-wide uppercase">So here's the story</span>
				<span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">From A to Z</span>
			</h1>

			<div class="flow-root pt-5">
			  <ul class="-mb-8">
			    <li v-for="(record, index) in records">
			      <div class="relative pb-8">
			        <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-pink-light" aria-hidden="true" v-if="(index+1) < records.length"></span>
			        <div class="relative flex space-x-3">
			          <div>
			            <span class="h-10 w-10 rounded-full bg-pink flex items-center justify-center ring-8 ring-white text-center">
			              <i class="h-5 w-5 text-white text-lg" :class="record.icon"></i>
			            </span>
			          </div>
			          <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
			            <div class="text-gray-500">
			              <p class="text-lg text-gray-500">{{ record.title }}</p>
			              <p class="text-sm text-gray-400" >{{ record.description }}</p>
			            </div>
			            <div class="text-right text-sm whitespace-nowrap text-gray-500">
			              <time :datetime="record.date">{{ record.date | moment}}</time>
			            </div>
			          </div>
			        </div>
			      </div>
			    </li>
			  </ul>
			</div>
		</div>
	</div>
</template>

<script>
	import moment from 'moment'
	export default {
		name: 'timeline',
		filters: {
			moment: function (date) {
				return moment(date).format('MMM YYYY');
			}
		},
		computed: {
			records() {
				return [
					{
						title: 'Jessie and Tommy first met',
						description: "Picture this - a rainy winters day, the cobbles of Nantwich filled with the elderly in raincoats. A man (who shall remain nameless) dressed in bright white shorts & a t-shirt meets a girl for the first time - bullying commenced and hasn't stopped since.",
						date: '2013-10',
						icon: 'far fa-handshake',
					},
					{
						title: 'Jessie and Tommy moved into their first flat',
						description: "T'was new years eve, whilst hundreds gather on the streets, two individuals embark on an epic conquest which ultimately led to the discovery of OCD tendencies & the constant need for properly cooked eggs.",
						date: '2014-12',
						icon: 'fas fa-building'
					},
					{
						title: 'Jessie and Tommy bought their first house',
						description: "Having grown tired of living in a shoe box, they decided to move on to bigger things.",
						date: '2016-05',
						icon: 'fas fa-home-heart'
					},
					{
						title: 'Jessie and Tommy brought home a fluffy cloud',
						description: "Due to subtle hints and the need to never again have a hair-free piece of clothing, the couple embarked on an epic quest to Durham. Returning with a fluffy cloud, that was armed with the ability to bring down entire civilisations with the wag of a tail.",
						date: '2017-07',
						icon: 'fas fa-paw'
					},
					{
						title: 'Jessie and Tommy got engaged',
						description: "Cornwall was the setting, a 15 mile walk round the coast of Exmouth was the journey & spending the rest of their lives together was their destination!",
						date: '2018-06',
						icon: 'far fa-rings-wedding'
					},
					{
						title: 'Jessie and Tommy got married',
						date: '2021-10',
						icon: 'far fa-ring'
					},
				]


			}
		}
	}
</script>