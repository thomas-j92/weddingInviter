
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Attempt to auto populate modal via AJAX call
$(document).on('click', '[data-target]:not([data-target=""])', function() {
	var el 			= $(this);
	var ajaxUrl 	= el.data('get');
	var modal_id 	= el.data('target');
	var modal 		= $(modal_id);

	// Only attempt to get data if URL is provided
	if(ajaxUrl !== '') {
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