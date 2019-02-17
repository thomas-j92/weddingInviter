
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

	// Only attempt AJAX call if url is provided
	if(submitUrl !== '') {
		// Only attempt AJAX update if inputs were found with update class
		var update_arr = [];
		$.each(inputs, function(i) {
			var input 				= $(this);
			console.log(input);
			var input_name 			= input.attr('name');
			var input_obj 			= {};			
			input_obj[input_name] 	= input.val();

			update_arr.push(input_obj);
		})
		console.log(update_arr);
	}

})