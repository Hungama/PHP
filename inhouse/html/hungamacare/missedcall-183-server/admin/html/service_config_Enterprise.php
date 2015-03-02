<?php
##############################service configuration code start By Rahul Tripathi########################################
$Service_Config["EnterpriseMcDw"] = array(
    "dashboard_name"=>"McDowell's - Missed call Campaign",
    "service_name"=>'EnterpriseMcDw',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true);
$Service_Config["EnterpriseTiscon"] = array(
    "dashboard_name"=>"Tata Tiscon Dashboard",
    "service_name"=>'EnterpriseTiscon',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true);
$Service_Config["HUL"] = array(
    "dashboard_name"=>"Good Life Club",
    "service_name"=>'HUL',
    "total_missed_call"=>true,
    "total_unique_visitor"=>true,
    "average_missed_call"=>true,
    "total_minute_consumed"=>true,
    "average_duration_listen"=>true,
    "maximum_duration_listen"=>true,
    "no_of_obd_pushed"=>true,
    "new_visitor"=>true,
    "content_consumption_split"=>true,
    "pie_chart_map"=>true);



function check_services($service_name)
{
global $Service_Config;
if($Service_Config[$service_name]["service_name"]==$service_name)
{
  
$section_dashboard_name=$Service_Config[$service_name]['dashboard_name'];
$section_total_missed_call=$Service_Config[$service_name]['total_missed_call'];
$section_total_unique_visitor=$Service_Config[$service_name]['total_unique_visitor'];
$section_average_missed_call=$Service_Config[$service_name]['average_missed_call'];
$section_total_minute_consumed=$Service_Config[$service_name]['total_minute_consumed'];
$section_average_duration_listen=$Service_Config[$service_name]['average_duration_listen'];
$section_maximum_duration_listen=$Service_Config[$service_name]['maximum_duration_listen'];
$section_no_of_obd_pushed=$Service_Config[$service_name]['no_of_obd_pushed'];
$section_new_visitor=$Service_Config[$service_name]['new_visitor'];
$section_content_consumption=$Service_Config[$service_name]['content_consumption_split'];
$section_chart_map=$Service_Config[$service_name]['pie_chart_map'];


return array($section_dashboard_name,$section_total_missed_call,$section_total_unique_visitor,$section_average_missed_call,
$section_total_minute_consumed,$section_average_duration_listen,$section_maximum_duration_listen,$section_no_of_obd_pushed,
    $section_new_visitor,$section_content_consumption,$section_chart_map);
} 
else{
    return "Not Found";
    exit;
    
}

}
##############################service configuration code end########################################


?>
