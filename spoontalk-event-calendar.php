<?php
/**
 * Plugin Name: SpoonTalk Event Calendar
 * Version: 0.81
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
		'menu_position' => 60,
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
	?>
	
	<p>
		 <label for="all_day">All Day :</label>
        <input type="checkbox" id="allday" name="allday" value="1" onchange="show()"/>
       
    </p>
	
	<p>
        <label for="start_date">Start Date & Time:</label>
        <input type="text" name="start_date" id="start_date" value="<?php echo $start_date; ?>" />
		@
		<select id="EventStartHours" name= "EventStartHours">
				  <option value ="12">12</option>
				  <option value ="01">01</option>
				  <option value ="02">02</option>
				  <option value ="03">03</option>
				  <option value ="04">04</option>
				  <option value ="05">05</option>
				  <option value ="06">06</option>
				  <option value ="07"> 07</option>
				  <option value ="08">08</option>
				  <option value ="09">09</option>
				  <option value ="10">10</option>
				  <option value ="11">11</option>
				  
		</select>
		<select id="EventStartMinute" name="EventStartMinute">
				  <option value ="00">00</option>
				  <option value ="05">05</option>
				  <option value ="10">10</option>
				  <option value ="15">15</option>
				  <option value ="20">20</option>
				  <option value ="25">25</option>
				  <option value ="30">30</option>
				  <option value ="35">35</option>
				  <option value ="40">40</option>
				  <option value ="45">45</option>
				  <option value ="50">50</option>
				  <option value ="50">55</option>
				  
		</select>
		<select id="EventStartMeridian" name="EventStartMeridian">
				  <option value ="am">am</option>
				  
				  <option value ="pm">pm</option>	  
		</select>
		
    </p>
	
	<p>
        <label for="end_date">End Date & Time:</label>
        <input type="text" name="end_date" id="end_date" value="<?php echo $end_date; ?>" />
		@
		<select id="EventEndHours" name= "EventEndHours">
				  <option value ="12">12</option>
				  <option value ="01">01</option>
				  <option value ="02">02</option>
				  <option value ="03">03</option>
				  <option value ="04">04</option>
				  <option value ="05">05</option>
				  <option value ="06">06</option>
				  <option value ="07"> 07</option>
				  <option value ="08">08</option>
				  <option value ="09">09</option>
				  <option value ="10">10</option>
				  <option value ="11">11</option>
				  
		</select>
		<select id="EventEndMinute" name="EventEndMinute">
				  <option value ="00">00</option>
				  <option value ="05">05</option>
				  <option value ="10">10</option>
				  <option value ="15">15</option>
				  <option value ="20">20</option>
				  <option value ="25">25</option>
				  <option value ="30">30</option>
				  <option value ="35">35</option>
				  <option value ="40">40</option>
				  <option value ="45">45</option>
				  <option value ="50">50</option>
				  <option value ="50">55</option>
				  
		</select>
		<select id="EventEndMeridian" name="EventEndMeridian">
				  <option value ="am">am</option>
				  
				  <option value ="pm">pm</option>	  
		</select>
	
    </p>
     
	
<?php }
function stec_event_save_meta_box_data( $post_id ) {
	
	

	$start_date = sanitize_text_field( $_POST['start_date'] );
	$end_date = sanitize_text_field( $_POST['end_date'] );
	
	
	if(isset($_POST["allday"]))
	{
			
            $start_time = 'All Day';
            $end_time = 'All Day';
        } else {
            
           
		   $start_Hours = sanitize_text_field( $_POST['EventStartHours'] );
           $start_minute = sanitize_text_field( $_POST['EventStartMinute'] );
		   $EventStartMeridian = sanitize_text_field( $_POST['EventStartMeridian'] );
		   $start_time = $start_Hours.":".$start_minute." ".$EventStartMeridian;
		   
		   $end_Hours = sanitize_text_field( $_POST['EventEndHours'] );
           $end_minute = sanitize_text_field( $_POST['EventEndMinute'] );
		   $EventEndMeridian = sanitize_text_field( $_POST['EventEndMeridian'] );
		   $end_time = $end_Hours.":".$end_minute." ".$EventEndMeridian;
	}
	
	update_post_meta( $post_id, 'start_date', $start_date );
	update_post_meta( $post_id, 'end_date',$end_date );
	update_post_meta( $post_id, 'start_time', $start_time );
	update_post_meta( $post_id, 'end_time', $end_time );
	
}
add_action( 'save_post', 'stec_event_save_meta_box_data' );
	function stec_create_events_functions() {
	?>
 
	<div style="width:100%;height:auto;margin-left:0px;">
	
	<div id="full_calendar" style="font-size:15px;"></div>
	<!-- ui-dialog -->
	<div id="dialog" title="<?php _e( 'Event Description', 'stec_event' );?>">
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
		
		wp_enqueue_script( 'jquery-ui-dialog');
		wp_enqueue_style('datepicker-css',plugins_url('datepicker/jquery-ui.css', __FILE__));
		wp_enqueue_style('custom-style-css',plugins_url('css/custom-style.css', __FILE__));	
	
		require_once (SPOONTALK_URL.'fullcalendar-events.php');
}}?>
<?php	}
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
?>
<?php
	if(isset($_POST['action'])){
	if($_POST['action']=='stec_showdata'){
	$id=$_POST['id'];
	$res=get_post($id);
	if($res){ ?>
	<div id="getdata">
	<table><tbody>
			<tr><td><?php _e( 'Title', 'stec_event' );?></td><td><?php echo $res->post_title;?> </td></tr>
			<tr><td><?php _e( 'Start Date', 'stec_event' );?></td><td><?php echo $start_date=get_post_meta($id, 'start_date', true);?> </td></tr>
			<tr><td><?php _e( 'End Date', 'stec_event' );?></td><td><?php echo $end_date=get_post_meta($id, 'end_date', true);?> </td></tr>			
			<tr><td><?php _e( 'Start Time', 'stec_event' );?></td><td><?php echo $start_time=get_post_meta($id, 'start_time', true);?> </td></tr>
			<tr><td><?php _e( 'End Time', 'stec_event' );?></td><td><?php echo $end_time=get_post_meta($id, 'end_time', true);?> </td></tr>
			<tr><td><?php _e( 'Description', 'stec_event' );?></td><td><?php  echo $res->post_content; ?> </td></tr>
			
			</tbody>
	</table></div>
<?php }}} ?>

<script>

function show()
{
var x = document.getElementById("allday").checked;
//alert(x);
if(x==true)
{
document.getElementById("EventStartHours").disabled = true;
document.getElementById("EventStartMinute").disabled = true;
document.getElementById("EventStartMeridian").disabled = true;
document.getElementById("EventEndHours").disabled = true;
document.getElementById("EventEndMinute").disabled = true;
document.getElementById("EventEndMeridian").disabled = true;
}
else
{
document.getElementById("EventStartHours").disabled = false;
document.getElementById("EventStartMinute").disabled = false;
document.getElementById("EventStartMeridian").disabled = false;
document.getElementById("EventEndHours").disabled = false;
document.getElementById("EventEndMinute").disabled = false;
document.getElementById("EventEndMeridian").disabled = false;
}
}

</script>
 
 

