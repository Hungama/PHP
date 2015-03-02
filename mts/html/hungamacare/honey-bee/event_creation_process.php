<?php
session_start();
require_once("incs/db.php");
$service = $_REQUEST['service'];
$circle = $_REQUEST['circle'];
$circle = implode(',', $circle);
$event = $_REQUEST['event'];
$perior = $_REQUEST['perevent'];
$loginid=$_SESSION['loginId'];
$insertquery = "insert into honeybee_sms_engagement.tbl_new_engagement_perior_data(service_id,added_on,
added_by,circle,event,periotize) 
values('$service',now(),'$loginid','$circle', '$event', '$perior')";
$result = mysql_query($insertquery, $dbConn);
mysql_close($dbConn);
exit;
?>