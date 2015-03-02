<?php
//include database connection file
require_once("../incs/db.php");
//servicetype -- DIGI | HUL
$processlog = "/var/www/html/hungamacare/v3/Script/logs/processlog_".date(Ymd).".txt";
//check for status ready to upload  
//$nowtime=date('H');
$nowtime='19';
$checkrule=mysql_query("select rule_id,time_slot from master_db.tbl_rule_engagement_action where status=1 and time_slot='".$nowtime."'",$dbConn);
$noofrows=mysql_num_rows($checkrule);
if($noofrows==0)
{
$logData='No Rule to process'."\n\r";
echo $logData;
//close database connection
mysql_close($con);
exit;
}
else
{
while($rows = mysql_fetch_array($checkrule))
{	
$data="ruleid#"$rows['rule_id']."#timeslot#".$rows['time_slot'];
error_log($data,3,$processlog);
}
}
mysql_close($con);
exit;
?>