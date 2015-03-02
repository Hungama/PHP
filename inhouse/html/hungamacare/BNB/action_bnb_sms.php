<?php
session_start();
require_once("db.php");
$smsid=$_REQUEST['smsid'];
$smskey=$_REQUEST['smskey'];
$status=5;
$currentdate = date("Y-m-d");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$addedby=$_SESSION["logedinuser"];
$baseurl="logs/";
$logPath = $baseurl."smskeyworddelete_".$currentdate.".txt";

if($smskey=='smskey')
{
$sql="update master_db.tbl_bnb_sms set status='".$status."' WHERE smsid='".$smsid."'";
}

if(isset($sql)) 
{ 
		if (mysql_query($sql,$con))
		 { 
		$res="Keyword has been deleted.";
		$msg='100';
		 } 
		 else
		 { 
		 $res=mysql_error();
		 } 
		 $logData=$smsid."#".$bulktype."#".$remoteAdd."#".$res."#".$addedby."#".date("Y-m-d H:i:s")."\n";
		 mysql_close($con);
		 
 } 
else
 {
		$res="Invalid Request";
		$msg='101';
		$logData=$smsid."#".$bulktype."#".$remoteAdd."#".$res."#".$addedby."#".date("Y-m-d H:i:s")."\n";
 }
echo $msg;
error_log($logData,3,$logPath);
?>