
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
		<ul><person v-for="user in users" v-bind:name="user.name" v-if="user.attending" v-bind:key="user.id">{{ user.name }}</person></ul>
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
	template: `<li><slot></slot> {{ name }} <button>Edit</button></li>`
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