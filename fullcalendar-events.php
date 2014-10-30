<script>
jQuery(document).ready(function() {
		jQuery('#full_calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			selectable: true,
			selectHelper: false,
			weekends: true,
			formatDate:'mm-dd-YY',
			monthNames: ["<?php _e("January", "stec_event"); ?>","<?php _e("February", "stec_event"); ?>","<?php _e("March", "stec_event"); ?>","<?php _e("April", "stec_event"); ?>","<?php _e("May", "stec_event"); ?>","<?php _e("June", "stec_event"); ?>","<?php _e("July", "stec_event"); ?>", "<?php _e("August", "stec_event"); ?>", "<?php _e("September", "stec_event"); ?>", "<?php _e("October", "stec_event"); ?>", "<?php _e("November", "stec_event"); ?>", "<?php _e("December", "stec_event"); ?>" ],
			monthNamesShort: ["<?php _e("Jan", "stec_event"); ?>","<?php _e("Feb", "stec_event"); ?>","<?php _e("Mar", "stec_event"); ?>","<?php _e("Apr", "stec_event"); ?>","<?php _e("May", "stec_event"); ?>","<?php _e("Jun", "stec_event"); ?>","<?php _e("Jul", "stec_event"); ?>","<?php _e("Aug", "stec_event"); ?>","<?php _e("Sept", "stec_event"); ?>","<?php _e("Oct", "stec_event"); ?>","<?php _e("nov", "stec_event"); ?>","<?php _e("Dec", "stec_event"); ?>"],
			dayNames: ["<?php _e("Sunday", "stec_event"); ?>","<?php _e("Monday", "stec_event"); ?>","<?php _e("Tuesday", "stec_event"); ?>","<?php _e("Wednesday", "stec_event"); ?>","<?php _e("Thursday", "stec_event"); ?>","<?php _e("Friday", "stec_event"); ?>","<?php _e("Saturday", "stec_event"); ?>"],
			dayNamesShort: ["<?php _e("Sun", "stec_event"); ?>","<?php _e("Mon", "stec_event"); ?>", "<?php _e("Tue", "stec_event"); ?>", "<?php _e("Wed", "stec_event"); ?>", "<?php _e("Thus", "stec_event"); ?>", "<?php _e("Fri", "stec_event"); ?>", "<?php _e("Sat", "stec_event"); ?>"],
			buttonText: {
			today: "<?php _e("Today", "stec_event"); ?>",
			day: "<?php _e("Day", "stec_event"); ?>",
			week:"<?php _e("Week", "stec_event"); ?>",
			month:"<?php _e("Month", "stec_event"); ?>"
			},
			//eventMouseover : function(event) {
			eventClick: function(event) {
                jQuery.ajax({
                    type: 'POST',
                    url : location.href,
                    data :{
					'id': event.id,
					'action':'stec_showdata'
					},
                    success: function(data) {
					   var getdiv =  jQuery(jQuery.parseHTML(data)).filter("#getdata"); 
						jQuery("#dialog").html(getdiv);
						jQuery("#dialog").dialog({
												  height:455,
												  width:560,
												  modal: true,
												  buttons: {
														"<?php _e( 'Close Dialog Box', 'stec_event' );?>": function() {
														jQuery( this ).dialog( "close" );
																		}
															}
												});
											}
							});
				return false;
			},
			events: [
				<?php echo stec_get_all_events($args); ?>
			]
		});
	});
	</script>
<?php
	// get all events 
	function stec_get_all_events($args){
				$args = array('post_type' => 'stec_custom_event');
				$res = new WP_Query($args);
				while ( $res->have_posts() )
				{ $res->the_post();
				?>
				{
					id:	'<?php echo get_the_ID();?>',
					title: '<?php echo get_post_meta(get_the_ID(), "start_time", true).'-'.get_post_meta(get_the_ID(), "end_time", true).' '.ucwords(get_the_title()); ?>',
					start:'<?php echo get_post_meta(get_the_ID(), "start_date", true); ?>',
					end:'<?php echo get_post_meta(get_the_ID(), "start_date", true); ?>'	
				},
<?php }	}?>