
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function() {
	var alerts = $('.message_container .alert');

	if(alerts.length > 0) {
		setTimeout(function() {
			alerts.fadeOut();
		}, 3000);
	}
})

// Attempt to auto populate modal via AJAX call
$(document).on('click', '[data-target]:not([data-target=""])', function() {
	var el 			= $(this);
	var ajaxUrl 	= el.data('get');
	var modal_id 	= el.data('target');
	var modal 		= $(modal_id);

	// Only attempt to get data if URL is provided
	if(ajaxUrl !== '' && ajaxUrl !== undefined) {
		// Make an AJAX call
		$.ajax({
			url: ajaxUrl,
			type: 'get',
			success: function(data) {
				var json = $.parseJSON(data);

				// Loop through JSON 
				$.each(json, function(i, obj) {
					var input = modal.find('input[name="'+i+'"]');

					// If inputs are found with same name as index in results within the corresponding modal, update input value
					var input_val = '';
					if(input.length == 1) {
						input_val = obj;
					}
					input.val(input_val);
				})
			}

		})
	}
})

// Attempt AJAX call whenever submit button in modal is clicked
$(document).on('click', '.modal #modal-submit-btn', function() {
	var btn 		= $(this);
	var container  	= btn.closest('.modal');
	var submitUrl 	= container.find('.hidden_url').data('url');
	var inputs 		= container.find('input.update-val');
	var where 		= container.find('input.where-val').val();

	// Only attempt AJAX call if url is provided
	if(submitUrl !== '') {
		// Only attempt AJAX update if inputs were found with update class
		var input_obj = {};
		$.each(inputs, function(i) {
			var input 				= $(this);
			var input_name 			= input.attr('name');
			
			input_obj[input_name] 	= input.val();
		});

		// Setup AJAX call
		$.ajax({
			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			},
			data: {
				updates: input_obj,
				where: where
			},
			type: "POST",
			url: submitUrl,
			success: function(data) {
				var message;
				var message_type;

				// Give feedback to user (dependant on outcome of update)
				if(data.success == true) {
					message 		= 'Success! Record has been updated';
					message_type 	= 'success';
				} else {
					message 		= 'Error! Record could not be updated';
					message_type 	= 'danger';
				}
				showMessage(message, message_type);

				// Close modal 
				container.modal('toggle');
			}
		})
	}
});

/**
 * Show specific type of message on screen.
 * @param  {String} message Message to be shown on screen.
 * @param  {String} message_type Type of message - this will change the styling of message.
 */
function showMessage(message, message_type) {
	var message_container = $('.message_container');

	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: '/returnMessageCode',
		data: {
			message: message,
			type: message_type 
		},
		type: 'POST',
		success: function(data) {
			if(data != '') {
				message_container.html(data);

				// Get all alerts within message container and fade them in
				var alerts = message_container.find('.alert');
				alerts.fadeIn('slow', function() {
					// Fade out/remove alerts after a few seconds.
					setTimeout(function() {
						alerts.fadeOut('slow', function() {
							alerts.remove();
						})
					}, 3000);
				});
			}
		}
	});
}

// AJAX Person search
$(document).on('keyup', '.search-function .search-input', function() {
	// Get search string
	var input 			= $(this);
	var search_string 	= input.val();

	// Get AJAX url
	var container 		= input.closest('.search-function');
	var ajax_url 		= container.find('.ajax-url').val();

	// Results container
	var results 		= container.find('.search_results');

	// Make AJAX call
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: ajax_url,
		data: {search_string: search_string},
		type: 'POST',
		success: function(resp) {
			var json = $.parseJSON(resp);

			// Show results if any were found
			var html = '';
			if(json.length > 0) {
				html += '<table class="table">';
				$.each(json, function(i, d) {
					html += '<tr>';
						html += '<td>'+d.first_name+' '+ d.last_name + '</td>';
						html += '<td><button type="addPersonBtn" name="person_id" value="'+d.id+'" class="btn btn-secondary">Add</button></td>'
					html += '</tr>';
				});
				html += '</table>';
			} else {
				html += '<p>No results found.</p>';
			}

			results.html(html);
		}
	});
});

// Assign guest container - back button
$(document).on('click', '#assignGuest .back-btn', function() {
	var $this = $(this);
	var back 	= $this.closest('.guest-type');

	console.log(back);

	back.fadeOut("fast", function() {
		$('#guest-type-container').fadeIn("fast");
	})
});

$(document).on('click', '[data-click-show]', function() {
	var el 					= $(this);

	// Show element - element that will be shown
	var show_element_class 	= el.data('click-show');
	var show_element 		= $('#'+show_element_class);

	// Hide element - element that will be shown
	var hide_element_class 	= el.data('click-hide');

	if(hide_element_class !== undefined) {
		var hide_element 		= $('#'+hide_element_class);

		hide_element.fadeOut("fast", function() {
			show_element.fadeIn("fast");
		});
	} else {
		show_element.fadeIn("fast");
	}


	// console.log(show_element_class);
	// console.log(hide_element_class);
});

// Vue
// import Vue from 'vue';
// import VueRouter from 'vue-router';
// Vue.use(VueRouter);

// import VueAxios from 'vue-axios';
// import axios from 'axios';
// Vue.use(VueAxios, axios);

// window.Vue = require('vue');
// 


// Load Vue JS
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import BootstrapVue from 'bootstrap-vue'
import VueCountdownTimer from 'vuejs-countdown-timer'
Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(VueCountdownTimer)

// Sidebar
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
Vue.use(VueSidebarMenu)

// Loading gif
import loading from './components/useful/loading'

// No data text
import no_data from './components/useful/no-data'

// Countdown
import countdown from './components/admin/dashboard/countdown'

// Mixin
if(document.head.querySelector('meta[name="api-base-url"]')) {
	Vue.axios.defaults.baseURL = document.head.querySelector('meta[name="api-base-url"]').content;
	Vue.mixin({
	  data: function() {
	    return {
	      baseUrl:Vue.axios.defaults.baseURL,

	    }
	  },
	  components: {
	  	countdown,
	  	loading,
	  	'no-data': no_data
	  },
	  methods: {
	  	toast(title, message = '', overrideClass = null) {  
	      let toastClass = 'success'; 

	      if(title == 'error'){
	        toastClass = 'danger';

	        // Get http errors
	        if(typeof message === 'object'){
	          if(message.hasOwnProperty('response') && message.response.data.hasOwnProperty('message')){
	            message = message.response.data.message;
	          }else if(message.hasOwnProperty('message')){
	            message = message.message;
	          }

	        }

	      }

	      if(overrideClass) {
	        toastClass = overrideClass;
	      }

	      this.$bvToast.toast(message, {
	        title: title,
	        autoHideDelay: 6000,
	        appendToast: true,
	        toastClass:toastClass
	      })
	    },
	  }
	});
}

const router = new VueRouter({
	mode: 'history',
	routes: [
		// dynamic segments start with a colon
		{
			path: '/admin', 
			component: require('./components/admin/viewer'),
			name: 'admin',
			redirect: {name: 'people.all'},
			children: [
		        {
		         	path: 'dashboard',
		         	name: 'admin.dashboard',
		        	component: require('./components/admin/dashboard/main'),
		        },
		        {
		        	path: 'people/all',
		        	name: 'people.all',
		        	component: require('./components/admin/people/all')
		        },
		        {
		        	path: 'people/upload/:id',
		        	name: 'upload.process',
		        	component: require('./components/admin/people/upload')
		        },
		        {
		        	path: 'people/view/:id',
		        	name: 'person.view',
		        	component: require('./components/admin/people/view')
		        },
		        {
		        	path: 'saveTheDates/all',
		        	name: 'saveTheDates.all',
		        	component: require('./components/admin/saveTheDates/all')
		        },
		        {
		        	path: 'saveTheDates/bulk/:id',
		        	name: 'saveTheDates.bulk',
		        	component: require('./components/admin/saveTheDates/bulkUpload')
		        },
		        {
		         	path: 'invites/all',
		         	name: 'invites.all',
		        	component: require('./components/admin/invites/all')
		        },
		        {
		        	path: 'invite/create/:personId?/',
		        	component: require('./components/admin/invite/main'),
		        },
		        {
		        	path: 'invite/view/:inviteId/',
		        	component: require('./components/admin/invite/view'),
		        	name: 'invite.view'
		        },
		        {
		        	path: 'reports',
		        	component: require('./components/admin/reports/main')
		        },
		        {
		        	path: 'emails',
		        	name: 'emails.view',
		        	component: require('./components/admin/emails/main'),
		        },
		        {
	    			path: 'emails/view/:id',
	    			name: 'email.view',
	    			component: require('./components/admin/emails/view')
	    		}
	        ]
		},
		{
			path: '/invitation/view/:code',
			component: require('./components/invitation/view')
		}
	]
})

const app = new Vue({
	el:'#app',
    router: router,
});