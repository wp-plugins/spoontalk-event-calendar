/************************
Custom JS , included on the Edit Screen

************************/

jQuery(document).ready(function() {
		jQuery('#start_date').datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd'
										});	
		jQuery("#start_time").timepicker({'timeFormat': 'h:i A','step': 15});
		jQuery("#end_time").timepicker({'timeFormat': 'h:i A','step': 15});	
	});
	