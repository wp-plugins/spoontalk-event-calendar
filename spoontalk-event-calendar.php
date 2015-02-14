<?php
/**
 * Plugin Name: SpoonTalk Event Calendar
 * Version: 0.82
 * Description: SpoonTalk Event Calendar is a simple yet powerful plugin for accepting online events on your WordPress blog site.
 * Author: Naresh, ANkit
 */
add_shortcode( 'st_event', 'stec_create_events_functions' );
define('SPOONTALK_URL',dirname(__FILE__).'/');
add_action( 'init', 'stec_custom_post_type' );
 function stec_custom_post_type() {
	register_post_type( 'stec_custom_event',
		array(
			'labels' => array(
				'name' => __('Events','stec_event'),
				'singular_name' => 'Event',
				'edit_item' => 'Edit Event'
			),
		'menu_icon' => 'dashicons-calendar',
		'menu_position' => 50,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'event'),
		'supports' => array( 'title','editor' ),
		'show_ui' => true,
		)
	);
}

add_action("admin_menu",'stec_admin_menu'); 
function stec_admin_menu() { 
add_submenu_page('edit.php?post_type=stec_custom_event', 'FAQ', 'FAQ', 'manage_options', SPOONTALK_URL.'faq.php' );
}  

function stec_event_themes_taxonomy() {  
    register_taxonomy(  
        'stec_event_category',
        'stec_custom_event',  
        array(  
            'hierarchical' => true,  
            'label' => __('Event Categories','stec_event'), 
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'stec_event_cat', 
                'with_front' => false 
            )
        )  
    );  
}  
add_action( 'init', 'stec_event_themes_taxonomy');
function stec_custom_add_meta_box() {
		add_meta_box(
			'myplugin_sectionid',
			__( 'Fill Events' ),
			
			'stec_start_meta_box_callback',
			'stec_custom_event'
		);
	}
add_action( 'add_meta_boxes', 'stec_custom_add_meta_box' );

function stec_start_meta_box_callback( $post ) 
{
	wp_nonce_field( 'event_meta_box', 'stec_event_meta_box_nonce' );
	$recurring = get_post_meta( $post->ID, 'recurring', true );
	$start_date = get_post_meta( $post->ID, 'start_date', true );
	$end_date = get_post_meta( $post->ID, 'end_date', true );
	$start_time = get_post_meta( $post->ID, 'start_time', true );
	$end_time = get_post_meta( $post->ID, 'end_time', true );
	$venue = get_post_meta( $post->ID,'venue',true);
	$event_day = get_post_meta( $post->ID,'events_days',true);
	
	// explode start and end time
	$pieces_start_time = preg_split('/[:," "]/', $start_time);
	
	$pieces_end_time = preg_split('/[:," "]/', $end_time);
	
	// //days count
	// $now = strtotime($end_date); // or your date as well
     // $your_date = strtotime($start_date);
     // $datediff = $now - $your_date;
     // echo floor($datediff/(60*60*24));
	?>
	<p>
		<label for="all_day">All Day :</label>
        <input type="checkbox" id="allday" name="allday" value="1" onchange="show()"<?php if($start_time =='All Day'){echo 'checked';}  ?>/>   
    </p>
	<p>
        <label for="start_date">Start Date</label>
        <input type="text" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />

	</p>
	<p>
		<label for="Start Time">Start Time:</label>
		<select id="EventStartHours" name= "EventStartHours">
				  <option value ="12"<?php selected ($pieces_start_time[0],'12') ?>>12</option>
				  <option value ="01"<?php selected ($pieces_start_time[0],'01') ?>>01</option>
				  <option value ="02"<?php selected ($pieces_start_time[0],'02') ?>>02</option>
				  <option value ="03"<?php selected ($pieces_start_time[0],'03') ?>>03</option>
				  <option value ="04"<?php selected ($pieces_start_time[0],'04') ?>>04</option>
				  <option value ="05"<?php selected ($pieces_start_time[0],'05') ?>>05</option>
				  <option value ="06"<?php selected ($pieces_start_time[0],'06') ?>>06</option>
				  <option value ="07"<?php selected ($pieces_start_time[0],'07') ?>>07</option>
				  <option value ="08"<?php selected ($pieces_start_time[0],'08') ?>>08</option>
				  <option value ="09"<?php selected ($pieces_start_time[0],'09') ?>>09</option>
				  <option value ="10"<?php selected ($pieces_start_time[0],'10') ?>>10</option>
				  <option value ="11"<?php selected ($pieces_start_time[0],'11') ?>>11</option>		  
		</select>
		<select id="EventStartMinute" name="EventStartMinute">
				  <option value ="00"<?php selected ( $pieces_start_time[1],'00') ?>>00</option>
				  <option value ="05"<?php selected ( $pieces_start_time[1],'05') ?>>05</option>
				  <option value ="10"<?php selected ( $pieces_start_time[1],'10') ?>>10</option>
				  <option value ="15"<?php selected ( $pieces_start_time[1],'15') ?>>15</option>
				  <option value ="20"<?php selected ( $pieces_start_time[1],'20') ?>>20</option>
				  <option value ="25"<?php selected ( $pieces_start_time[1],'25') ?>>25</option>
				  <option value ="30"<?php selected ( $pieces_start_time[1],'30') ?>>30</option>
				  <option value ="35"<?php selected ( $pieces_start_time[1],'35') ?>>35</option>
				  <option value ="40"<?php selected ( $pieces_start_time[1],'40') ?>>40</option>
				  <option value ="45"<?php selected ( $pieces_start_time[1],'45') ?>>45</option>
				  <option value ="50"<?php selected ( $pieces_start_time[1],'50') ?>>50</option>
				  <option value ="50"<?php selected ( $pieces_start_time[1],'55') ?>>55</option>		  
		</select>
		<select id="EventStartMeridian" name="EventStartMeridian">
				  <option value ="am"<?php selected ( $pieces_start_time[3],'am')?>>am</option>	  
				  <option value ="pm"<?php selected ( $pieces_start_time[3],'pm')?>>pm</option>	  
		</select>	
    </p>
	<p>
        <label for="end time">End Time:</label>
		<select id="EventEndHours" name= "EventEndHours">
				  <option value ="12"<?php selected ($pieces_end_time[0],'12') ?>>12</option>
				  <option value ="01"<?php selected ($pieces_end_time[0],'01') ?>>01</option>
				  <option value ="02"<?php selected ($pieces_end_time[0],'02') ?>>02</option>
				  <option value ="03"<?php selected ($pieces_end_time[0],'03') ?>>03</option>
				  <option value ="04"<?php selected ($pieces_end_time[0],'04') ?>>04</option>
				  <option value ="05"<?php selected ($pieces_end_time[0],'05') ?>>05</option>
				  <option value ="06"<?php selected ($pieces_end_time[0],'06') ?>>06</option>
				  <option value ="07"<?php selected ($pieces_end_time[0],'07') ?>>07</option>
				  <option value ="08"<?php selected ($pieces_end_time[0],'08') ?>>08</option>
				  <option value ="09"<?php selected ($pieces_end_time[0],'09') ?>>09</option>
				  <option value ="10"<?php selected ($pieces_end_time[0],'10') ?>>10</option>
				  <option value ="11"<?php selected ($pieces_end_time[0],'11') ?>>11</option>		  
		</select>
		<select id="EventEndMinute" name="EventEndMinute">
				  <option value ="00"<?php selected ($pieces_end_time[1],'00') ?>>00</option>
				  <option value ="05"<?php selected ($pieces_end_time[1],'05') ?>>05</option>
				  <option value ="10"<?php selected ($pieces_end_time[1],'10') ?>>10</option>
				  <option value ="15"<?php selected ($pieces_end_time[1],'15') ?>>15</option>
				  <option value ="20"<?php selected ($pieces_end_time[1],'20') ?>>20</option>
				  <option value ="25"<?php selected ($pieces_end_time[1],'25') ?>>25</option>
				  <option value ="30"<?php selected ($pieces_end_time[1],'30') ?>>30</option>
				  <option value ="35"<?php selected ($pieces_end_time[1],'35') ?>>35</option>
				  <option value ="40"<?php selected ($pieces_end_time[1],'40') ?>>40</option>
				  <option value ="45"<?php selected ($pieces_end_time[1],'45') ?>>45</option>
				  <option value ="50"<?php selected ($pieces_end_time[1],'50') ?>>50</option>
				  <option value ="50"<?php selected ($pieces_end_time[1],'55') ?>>55</option>			  
		</select>
		<select id="EventEndMeridian" name="EventEndMeridian">
				  <option value ="am"<?php selected ($pieces_end_time[2],'am') ?>>am</option>	  
				  <option value ="pm"<?php selected ($pieces_end_time[2],'pm') ?>>pm</option>	  
		</select>
    </p>
	
     <p>
		<label for="recurring_event">Recurring Events</label>
		<input type="checkbox" id="recurring" name="recurring" value="" onchange="recurring_show()" <?php if($recurring != 'SD') {echo 'checked';} ?> />
		<select id="recurring_events" name="recurring_events" disabled="disabled">
			<option value="N"><?php _e('....Please Select...','stec_event');?></option>
			 <option value="PD" <?php selected( $recurring, 'PD' ); ?>>PerDay</option>
			 <option value="W" <?php selected( $recurring, 'W' ); ?>>Weekly</option>
			 <option value="M" <?php selected( $recurring, 'M' ); ?>>Monthly</option>
			 <option value="Y" <?php selected( $recurring, 'Y' ); ?>>Yearly</option> 
		</select>
	 </p>
	 
	 <p>
		<label for="events-days">Events Days</label>
		<input type="number" id="events_days" disabled="disabled" name="events_days" min="1" max="31" value="<?php echo $event_day;?>">
	 </p>
	
<?php }
function stec_event_save_meta_box_data( $post_id ) {
	
	// Start and End time
	if(isset($_POST["allday"]))
		{
            $start_time = 'All Day';
            $end_time = 'All Day';
        } else 
		{
		   $start_Hours = sanitize_text_field( $_POST['EventStartHours'] );
           $start_minute = sanitize_text_field( $_POST['EventStartMinute'] );
		   $EventStartMeridian = sanitize_text_field( $_POST['EventStartMeridian'] );
		   $start_time = $start_Hours.":".$start_minute." ".$EventStartMeridian;
		   
		   $end_Hours = sanitize_text_field( $_POST['EventEndHours'] );
           $end_minute = sanitize_text_field( $_POST['EventEndMinute'] );
		   $EventEndMeridian = sanitize_text_field( $_POST['EventEndMeridian'] );
		   $end_time = $end_Hours.":".$end_minute." ".$EventEndMeridian;
		}
		
	$start_date = sanitize_text_field( $_POST['start_date'] );
	// Recurring Events
	if(isset($_POST["recurring"]))
	{
		$recurring_events = $_POST["recurring_events"];
		$events_days  = $_POST['events_days'];
		$event_days  = $events_days - 1;
		//update_option('day',$event_days);
		
		
		if($recurring_events == 'PD')
		{
			
			$recurringSdate = strtotime($start_date);
			$end_date  = date("Y-m-d", strtotime("+$event_days day",$recurringSdate));
			
		}
		if($recurring_events == 'W')
		{
			$recurringSdate = strtotime($start_date);
			$end_date = date("Y-m-d",strtotime("+$event_days week",$recurringSdate));	
		}
		if($recurring_events == 'M')
		{
			$recurringSdate = strtotime($start_date);
			$end_date = date("Y-m-d",strtotime("+$event_days month",$recurringSdate));
		}
		if($recurring_events == 'Y')
		{
			$recurringSdate  = strtotime($start_date);
			$end_date = date("Y-m-d",strtotime("+$event_days year",$recurringSdate));
		}
	}
	else
	{
		$recurring_events = "SD";
		$end_date = $start_date;
		update_option("recuring",$recurring_events);
	}
	
	update_post_meta( $post_id, 'start_date', $start_date );
	update_post_meta( $post_id, 'end_date',$end_date );
	update_post_meta( $post_id, 'start_time', $start_time );
	update_post_meta( $post_id, 'end_time', $end_time );
	update_post_meta( $post_id, 'recurring', $recurring_events);
	update_post_meta( $post_id, 'events_days',$events_days);
	
	
}
add_action( 'save_post', 'stec_event_save_meta_box_data' );
	function stec_create_events_functions() {
	?>
	<div style="width:100%;height:auto;margin-left:0px;">
	
	<div id="full_calendar" style="font-size:15px;"></div>
	<!-- ui-dialog -->
	<div id="dialog">
	</div>
	<!-- ui-dialog-->
 </div>
 
 <?php
 
    global $wp_query;
    $posts = $wp_query->posts;
    $pattern = get_shortcode_regex();    
    foreach ($posts as $post) {
        if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'st_event', $matches[2] )) {
		
		// fullcalendar supported js and css files
		wp_enqueue_style('fullcalendar-css',plugins_url('fullcalendar/fullcalendar.css', __FILE__));
		wp_enqueue_style('fullcalendar-print-css',plugins_url('fullcalendar/fullcalendar.print.css', __FILE__),'','','print');
		wp_enqueue_script('moment-min-js',plugins_url('fullcalendar/lib/moment.min.js', __FILE__),array('jquery'));
		wp_enqueue_script('fullcalendar-min-js',plugins_url('fullcalendar/fullcalendar.min.js', __FILE__));
	
		//jquery dialog box
		/*wp_enqueue_script( 'jquery-ui-dialog');
		wp_enqueue_style('datepicker-css',plugins_url('datepicker/jquery-ui.css', __FILE__));
		wp_enqueue_style('custom-style-css',plugins_url('css/custom-style.css', __FILE__));	
		*/
		
		// new jquery dialog box
		wp_enqueue_style('dialogbox-css',plugins_url('style/stylemodal.css', __FILE__));
		wp_enqueue_script('jquery-dialog-js-leanmodal',plugins_url('js/jquery-popup.min.js',  __FILE__));
		// End jquery dialog box
		
		require_once (SPOONTALK_URL.'fullcalendar-events.php');
}}?><?php	}
add_action( 'admin_print_scripts-post-new.php', 'stec_add_edit_page_script', 10 );
add_action( 'admin_print_scripts-post.php', 'stec_add_edit_page_script', 10 );
function stec_add_edit_page_script() {
    global $post_type;
    if( 'stec_custom_event' == $post_type )
	{	
	wp_enqueue_script( 'jquery-ui-datepicker');
	wp_enqueue_style('datepicker-css',plugins_url('datepicker/jquery-ui.css', __FILE__));
	wp_enqueue_style('custom-style-css',plugins_url('css/custom-style.css', __FILE__));		
	wp_enqueue_script('timepicker-js',plugins_url('timepicker/jquery.timepicker.js', __FILE__), array('jquery'));
	wp_enqueue_style('timepicker-css',plugins_url('timepicker/jquery.timepicker.css', __FILE__));
	wp_enqueue_script('my-custom-js',plugins_url('js/custom.js', __FILE__), array('jquery'));
 } }
?><?php
	if(isset($_POST['action'])){
	if($_POST['action']=='stec_showdata'){
	$id=$_POST['id'];
	$res=get_post($id);
	if($res){ ?>
	<div id="getdata" style="width:400px;">
	<span class='modal-cls'><?php _e( 'Event Description', 'stec_event' );?></span>
	<table><tbody>
			<tr><td><?php _e( 'Title', 'stec_event' );?></td><td><?php echo $res->post_title;?> </td></tr>
			<tr><td><?php _e( 'Start Date', 'stec_event' );?></td><td><?php echo $start_date=get_post_meta($id, 'start_date', true);?> </td></tr>
			<tr><td><?php _e( 'End Date', 'stec_event' );?></td><td><?php echo $end_date=get_post_meta($id, 'end_date', true);?> </td></tr>			
			<tr><td><?php _e( 'Start Time', 'stec_event' );?></td><td><?php echo $start_time=get_post_meta($id, 'start_time', true);?> </td></tr>
			<tr><td><?php _e( 'End Time', 'stec_event' );?></td><td><?php echo $end_time=get_post_meta($id, 'end_time', true);?> </td></tr>
			<tr><td><?php _e( 'Description', 'stec_event' );?></td><td><?php  echo $res->post_content; ?> </td></tr>
			<!--<button class="b-close">close</button>-->
			<img src='<?php echo plugins_url()."/spoontalk-event-calendar/images/Delete-icon.png"; ?>' class='b-close' width="20px",height="20px">
			</tbody>
	</table></div>
<?php }}} ?>