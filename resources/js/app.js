
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
				<person v-for="user in users" v-bind:name="user.name" v-if="user.attending" v-bind:key="user.id">{{ user.name }}</person>
			</tbody>
		</table>
	</div>
	`,

	data() {
		return {
			users: [
	            {id: 1, name: "Tommy", rsvp: true, attending: true},
	            {id: 2, name: "Jessie", rsvp: true, attending: true},
	            {id: 3, name: "Aaron", rsvp: false, attending: false},
	            {id: 4, name: "Yasmin", rsvp: false, attending: false},
	        ]
		}
	}
});

Vue.component('person-awaiting-response', {
	template: `
	<div id="attending">
		<h2>Awaiting Response</h2>
		<table class="table">
			<tbody>
				<person v-for="user in users" v-bind:name="user.name" v-if="! user.rsvp" v-bind:key="user.id">{{ user.name }}</person>
			</tbody>
		</table>
	</div>
	`,

	data() {
		return {
			users: [
	            {id: 1, name: "Tommy", rsvp: true, attending: true},
	            {id: 2, name: "Jessie", rsvp: true, attending: true},
	            {id: 3, name: "Aaron", rsvp: false, attending: false},
	            {id: 4, name: "Yasmin", rsvp: false, attending: false},
	        ]
		}
	}
});

Vue.component('person-not-attending', {
	template: `
	<div id="attending">
		<h2>Not Attending</h2>
		<table class="table">
			<tbody>
				<person v-for="user in users" v-bind:name="user.name" v-if="user.rsvp && ! user.attending" v-bind:key="user.id">{{ user.name }}</person>
			</tbody>
		</table>
	</div>
	`,

	data() {
		return {
			users: [
	            {id: 1, name: "Tommy", rsvp: true, attending: true},
	            {id: 2, name: "Jessie", rsvp: true, attending: true},
	            {id: 3, name: "Aaron", rsvp: false, attending: false},
	            {id: 4, name: "Yasmin", rsvp: false, attending: false},
	        ]
		}
	}
});

Vue.component('person', {
	props: ['name'],
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
					<a class="dropdown-item" href="#" data-toggle="modal" data-target="#editPersonModal">Edit</a>
				</div>
			</div>
		</td>
	</tr>`
})

Vue.component('toggle-menu', {
	template: ``
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
	        <p>Modal body text goes here.</p>
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
    //     reversedMessage: function() {
    //         return this.title.split("").reverse().join('');
    //     },
    //     attending: function() {
    //         return this.users.filter(user => user.attending);
    //     }
    // },
    // mounted() {
    //     document.querySelector('#add_user_btn').addEventListener('click', () => {
    //         var input = document.querySelector('#add_user_input');

    //         root.users.push(input.value);

    //         input.value = '';
    //     })
    // }
})