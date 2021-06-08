<template>
	<div class="relative bg-white">
    <div class="flex justify-between items-center max-w-7xl mx-auto px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8">
      <div class="flex justify-start lg:w-0 lg:flex-1 pl-4">
        <a href="#">
          <span class="sr-only">Workflow</span>
          <img class="h-8 w-auto sm:h-14" src="images/mill-barn-pink.png" alt="">
        </a>
      </div>
      <div class="-mr-2 -my-2 md:hidden">
        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pink" aria-expanded="false" @click="toggle">
          <span class="sr-only">Open menu</span>
          <!-- Heroicon name: outline/menu -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <nav class="hidden md:flex space-x-10 pr-4">
        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900" v-scroll-to="'#timeline'">
          Timeline
        </a>
        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900" v-scroll-to="'#faqs'">
          FAQ's
        </a>
        <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900" v-scroll-to="'#location'">
          Location
        </a>
      </nav>
    </div>

    <!--
      Mobile menu, show/hide based on mobile menu state.

      Entering: "duration-200 ease-out"
        From: "opacity-0 scale-95"
        To: "opacity-100 scale-100"
      Leaving: "duration-100 ease-in"
        From: "opacity-100 scale-100"
        To: "opacity-0 scale-95"
    -->
    <div class="absolute z-30 top-20 inset-x-0 p-2 transition transform origin-top-right md:hidden opacity-100" v-if="showMenu">
      <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
        
        <div class="py-6 px-5">
          <div class="grid grid-cols-1 gap-4">
            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700" v-scroll-to="'#timeline'">
              Timeline
            </a>

            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700" v-scroll-to="'#faqs'">
              FAQ's
            </a>

            <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700" v-scroll-to="'#location'">
              Location
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	export default {
		name: 'navbar',
    data() {
      return {
        showMenu: false,
      }
    },
    methods: {
      toggle() {
        if(this.showMenu) {
          this.showMenu = false;
        } else {
          this.showMenu = true;
        }
      }
    }
	}
</script>