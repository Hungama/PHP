<?php
##############################service configuration code start By Rahul Tripathi########################################
$Service_Config["EnterpriseMcDw"] = array(
    "dashboard_name"=>"McDowell's - Missed call Campaign",
    "service_name"=>'EnterpriseMcDw',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
    "average_unique_visitor"=>false,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true,
    "total_pulshes"=>true,
    "avg_call"=>true,
    "ad_impression"=>true,
    "subscriber_connected"=>false,
    "subscriber_failure"=>false,
    "logo"=>"<a class='navbar-brand' href='#'>McDowell's<span class='slogan'> Missed call Campaign</span></a>"
    );
$Service_Config["EnterpriseMcDwOBD"] = array(
    "dashboard_name"=>"Enterprise - McDowells (OBD)",
    "service_name"=>'EnterpriseMcDwOBD',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
    "average_unique_visitor"=>false,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true,
    "total_pulshes"=>true,
    "avg_call"=>true,
    "ad_impression"=>false,
    "subscriber_connected"=>true,
    "subscriber_failure"=>true,
    "logo"=>"<a class='navbar-brand' href='#'>Enterprise<span class='slogan'>McDowells (OBD)</span></a>"
    );
$Service_Config["EnterpriseTiscon"] = array(
    "dashboard_name"=>"Tata Tiscon Dashboard",
    "service_name"=>'EnterpriseTiscon',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
	"average_unique_visitor"=>true,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true,
    "total_pulshes"=>false,
    "avg_call"=>true,
    "ad_impression"=>true,
    "subscriber_connected"=>false,
    "subscriber_failure"=>false,
    "logo"=>"<a class='navbar-brand' href='#'>Tata Tiscon<span class='slogan'> Campaign</span></a>"
    );
$Service_Config["HUL"] = array(
    "dashboard_name"=>"Good Life Club",
    "service_name"=>'HUL',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
	"average_unique_visitor"=>true,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true,
    "total_pulshes"=>true,
    "avg_call"=>true,
    "ad_impression"=>true,
    "subscriber_connected"=>false,
    "subscriber_failure"=>false,
    "logo"=>"");



function check_services($service_name)
{
global $Service_Config;
if($Service_Config[$service_name]["service_name"]==$service_name)
{
  
$section_dashboard_name=$Service_Config[$service_name]['dashboard_name'];
$section_total_missed_call=$Service_Config[$service_name]['total_missed_call'];
$section_total_unique_visitor=$Service_Config[$service_name]['total_unique_visitor'];
$section_average_unique_visitor=$Service_Config[$service_name]['average_unique_visitor'];
$section_average_missed_call=$Service_Config[$service_name]['average_missed_call'];
$section_total_minute_consumed=$Service_Config[$service_name]['total_minute_consumed'];
$section_average_duration_listen=$Service_Config[$service_name]['average_duration_listen'];
$section_maximum_duration_listen=$Service_Config[$service_name]['maximum_duration_listen'];
$section_no_of_obd_pushed=$Service_Config[$service_name]['no_of_obd_pushed'];
$section_new_visitor=$Service_Config[$service_name]['new_visitor'];
$section_content_consumption=$Service_Config[$service_name]['content_consumption_split'];
$section_chart_map=$Service_Config[$service_name]['pie_chart_map'];
$section_total_pulshes=$Service_Config[$service_name]['total_pulshes'];
$section_avg_call=$Service_Config[$service_name]['avg_call'];
$section_ad_impression=$Service_Config[$service_name]['ad_impression'];
$section_subscriber_connected=$Service_Config[$service_name]['subscriber_connected'];
$section_subscriber_failure=$Service_Config[$service_name]['subscriber_failure'];
$section_logo=$Service_Config[$service_name]['logo'];

return array($section_dashboard_name,$section_total_missed_call,$section_total_unique_visitor,$section_average_missed_call,
$section_total_minute_consumed,$section_average_duration_listen,$section_maximum_duration_listen,$section_no_of_obd_pushed,
    $section_new_visitor,$section_content_consumption,$section_chart_map,$section_average_unique_visitor,$section_total_pulshes,$section_avg_call,$section_ad_impression,$section_subscriber_connected,$section_subscriber_failure,$section_logo);
} 
else{
    return "Not Found";
    exit;
    
}

}
##############################service configuration code end########################################
?>