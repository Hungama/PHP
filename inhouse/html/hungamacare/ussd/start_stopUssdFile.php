<?php
session_start();
require_once("db.php");
$type = $_GET['type'];
$batchid = $_GET['batchid'];
$curdate = date("Y-m-d");
$logPath = "ussdbulkfile/logs/user_action_taken_".$curdate.".txt";
if($type=='start')
{
$update_status = "UPDATE USSD.tbl_uninor_ussd_bulkpush set status='0' where batchid='".$batchid."'";
$logData="#batchid#".$batchid."#action#Start"."#user#".$_SESSION["logedinuser"]."#datetime#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
}
else if($type=='kill')
{
$update_status = "UPDATE master_db.bulk_ussd_history set status='3' where batch_id='".$batchid."'";
$logData="#batchid#".$batchid."#action#End".$service."#user#".$_SESSION["logedinuser"]."#datetime#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
}
else if($type=='ussd')
{
//$update_status = "UPDATE master_db.bulk_ussd_history set status='3' where batch_id='".$batchid."'";
$update_status = "delete from USSD.tbl_uninor_ussd_bulkpush where batchid='".$batchid."'";
$logData="#batchid#".$batchid."#action#Terminate the campaign".$service."#user#".$_SESSION["logedinuser"].'#query#'.$update_status."#datetime#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
}
else
{
$update_status = "UPDATE USSD.tbl_uninor_ussd_bulkpush set status='1' where batchid='".$batchid."'";
$logData="#batchid#".$batchid."#action#Stop"."#user#".$_SESSION["logedinuser"]."#datetime#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
}
if(mysql_query($update_status,$con))
{
echo '100';
}
else
{
echo '101';
}
mysql_close($dbConn);
?>