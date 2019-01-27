
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('person-attending', {
	template: `
	<div id="attending">
		<h2>Attending</h2>
		<table class="table">
			<tbody>
				<person v-for="p in people" v-bind:name="p.first_name" v-if="p.attending" v-bind:uid="p.id" v-bind:key="p.id">{{ p.first_name }}</person>
			</tbody>
		</table>
	</div>
	`,
	mounted: function() {
		var self = this;
		$.ajax({
				url: '/people',
				type: 'get',
				success: function(data) {
					self.people = data;
				}
			});
	},
	data() {
		return {
			people: []
		}
	}
});

Vue.component('person-awaiting-response', {
	template: `
	<div id="attending">
		<h2>Awaiting Response</h2>
		<table class="table">
			<tbody>
				<person v-for="p in people" v-bind:name="p.first_name" v-if="!p.rsvp" v-bind:uid="p.id" v-bind:key="p.id">{{ p.first_name }}</person>
			</tbody>
		</table>
	</div>
	`,
	mounted: function() {
		var self = this;
		$.ajax({
				url: '/people',
				type: 'get',
				success: function(data) {
					self.people = data;
				}
			});
	},
	data() {
		return {
			people: []
		}
	}
});

Vue.component('person-not-attending', {
	template: `
	<div id="attending">
		<h2>Not Attending</h2>
		<table class="table">
			<tbody>
				<person v-for="p in people" v-bind:name="p.first_name" v-if="p.rsvp && !p.attending" v-bind:uid="p.id" v-bind:key="p.id">{{ p.first_name }}</person>
			</tbody>
		</table>
	</div>
	`,
	mounted: function() {
		var self = this;
		$.ajax({
				url: '/people',
				type: 'get',
				success: function(data) {
					self.people = data;
				}
			});
	},
	data() {
		return {
			people: []
		}
	}
});

Vue.component('person', {
	props: ['name', 'uid'],
	template: `
	<tr>
		<td>
			<slot></slot>
		</td>
		<td>
			<div class="dropdown show">
				<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="oi oi-cog" title="icon name" aria-hidden="true"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="#" data-toggle="modal" v-on:click="updateUserModal(uid)" data-target="#editPersonModal">Edit</a>
				</div>
			</div>
		</td>
	</tr>`,
	methods: {
		updateUserModal: function(id) {
			var self = this;
			var test = this.$root;
			console.log(test);
			$.ajax({
				url: '/people/'+id,
				type: 'get',
				success: function(data) {
					self.$root.userMdlFirstName = data.first_name;
				}
			});
		}
	},
})

Vue.component('tabs', {
	template: `
		<div>
			<ul class="nav nav-tabs">
			  <li class="nav-item" v-for="tab in tabs">
			  	<a class="nav-link" :href="tab.href" @click="selectTab(tab)" :class="{ 'active' : tab.isActive }" data-toggle="tab">{{ tab.title }}</a>
			  </li>
			</ul>

			<div class="tab-content">
			  <slot></slot>
			</div>
		</div>
	`,
	data() {
		return {
			tabs: []
		}
	},
	created() {
		this.tabs = this.$children;
	}, 
	methods: {
		selectTab(selectedTab) {
			this.tabs.forEach(tab => {
				tab.isActive = (tab.tabId == selectedTab.tabId);
			})
		}
	}
})

Vue.component('tab', {
	props: {
		title: {required: true},
		tabId: {},
		selected: {default: false}
	},
	data() {
		return {
			isActive: true
		}
	},
	computed: {
		href() {
			return '#' + this.tabId;
		}
 	},
	template: `
		 <div class="tab-pane fade" :class="{ 'active show' : this.isActive }" :id="tabId">
			<slot></slot>
		 </div>
	`,
	mounted() {
		this.isActive = this.selected;
	}
})

Vue.component('modal', {
	props: ['modal_id', 'title'],
	template: `
	<div class="modal" v-bind:id="modal_id" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">{{ title }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <slot></slot>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary">Save changes</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>`
})

// Vue.component('modal', {
// 	template: 
// })
// 

// define a mixin object
Vue.mixin({
	methods: {
		getPeople: function () {
			$.ajax({
				url: '/people',
				type: 'get',
				success: function(data) {
					// console.log(data);
					return data;
				}
			});
		}
	}
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var root = new Vue({
    el: '#root',
    // data: {
    //     user_name: '',
    //     users: [
    //         {name: "Tommy", rsvp: true, attending: true},
    //         {name: "Jessie", rsvp: true, attending: true},
    //         {name: "Aaron", rsvp: false, attending: false},
    //         {name: "Yasmin", rsvp: false, attending: false},
    //     ],
    //     className: "red",
    //     isLoading: false
    // },
    // methods: {
    //     addNames: function() {
    //         this.users.push({
    //             name: this.user_name,
    //             rsvp: false,
    //             attending: false
    //         });

    //         this.user_name = '';
    //     },
    //     markAsAttending: function(index) {
    //         this.users[index].attending = true;
    //     }
    // },
    // computed: {
    //     getPeople: function() {
        	
    //         // return this.title.split("").reverse().join('');
    //     },
    //     attending: function() {
    //         return this.users.filter(user => user.attending);
    //     }
    // },
    // created: function() {
        
    // }
    data: {
    	userMdlFirstName: ''
    }
})