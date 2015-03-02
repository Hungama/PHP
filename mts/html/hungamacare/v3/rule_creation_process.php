<?php
session_start();
require_once("incs/db.php");
//echo "<pre>";print_r($_REQUEST);die('here');
$rule_name = $_REQUEST['rule_name'];
$service = $_REQUEST['service'];
$circle = $_REQUEST['circle'];
$service_base = $_REQUEST['service_base'];
$filter_base = $_REQUEST['filter_base'];
$scenarios = $_REQUEST['scenarios'];
$dnd_scrubbing = $_REQUEST['dnd_scrubbing'];
$loginid=$_SESSION['loginId'];
$circle = implode(',', $circle);

$tagsinput=$_REQUEST['tagsinput'];
$logPath="logs/Request_".date('Ymd').".txt";
$logData=$rule_name."#".$tagsinput."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);


//$update_query = "update master_db.tbl_rule_engagement set status=0 where circle='" . $circle . "' and service_id='" . $service . "' and service_base='" . $service_base . "' and filter_base='" . $filter_base . "' and scenerios='" . $scenarios . "'";
//mysql_query($update_query, $dbConn);
$insertquery = "insert into master_db.tbl_rule_engagement(rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,status,added_on,added_by,circle) 
     values('$rule_name', '$service','$service_base', '$filter_base', '$scenarios', '$dnd_scrubbing',11,now(),'$loginid','$circle')";
$result = mysql_query($insertquery, $dbConn);

mysql_close($dbConn);
exit;
?>