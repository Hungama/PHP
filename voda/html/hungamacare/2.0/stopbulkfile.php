<?php
session_start();
$user_id=$_SESSION['loginId'];
require_once("incs/db.php");
$batch_id=$_REQUEST['batchid'];
$bulktype=$_REQUEST['bulktype'];
$status=5;
$currentdate = date("Y-m-d");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$baseurl="logs/bulkfilestop/";
$logPath = $baseurl."bulkfilestop_".$currentdate.".txt";


if($bulktype=='bulk_history')
{
$sql="update vodafone_hungama.bulk_upload_history set status='".$status."' WHERE batch_id='".$batch_id."'";
}

if(isset($sql)) 
{ 
		if (mysql_query($sql,$dbConn))
		 { 
		$res="File has been stopped.";
		 } 
		 else
		 { 
		 $res=mysql_error();
		 } 
		 echo $res;
		 $logData=$batch_id."#".$bulktype."#".$remoteAdd."#".$res."#".$user_id."#".date("Y-m-d H:i:s")."\n";
		 mysql_close($dbConn);
 } 
else
 {
		$res="Invalid Request";
		echo $res;
		$logData=$batch_id."#".$bulktype."#".$remoteAdd."#".$res."#".$user_id."#".date("Y-m-d H:i:s")."\n";
 }
 
error_log($logData,3,$logPath);

?>