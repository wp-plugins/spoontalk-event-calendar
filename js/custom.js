/************************
Custom JS , included on the Edit Screen

************************/

jQuery(document).ready(function() {
		jQuery('#start_date').datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd'
										});	
		jQuery('#end_date').datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd'
										});									
		jQuery("#start_time").timepicker({'timeFormat': 'h:i A','step': 15});
		jQuery("#end_time").timepicker({'timeFormat': 'h:i A','step': 15});	
	});

function show()
{
var x = document.getElementById("allday").checked;
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
function recurring_show()
{
var z = document.getElementById("recurring").checked;
if(z==true)
{
//alert("Hello");
document.getElementById("recurring_events").disabled= false;
document.getElementById("events_days").disabled = false;
}
else
{
//alert("Error");
document.getElementById("recurring_events").disabled = true;
document.getElementById("events_days").disabled = true;
}
}