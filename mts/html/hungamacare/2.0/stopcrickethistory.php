<?php
session_start();
$user_id=$_SESSION['loginId'];
require_once("incs/db.php");
$batch_id=$_REQUEST['batchid'];
$status=5;
$currentdate = date("Y-m-d");
$remoteAdd=$_SERVER['REMOTE_ADDR'];
$sql="update MTS_cricket.tbl_msg_history set status='".$status."' WHERE id='".$batch_id."'";

if(isset($sql)) 
{ 
		if (mysql_query($sql,$dbConn))
		 { 
		$res="Selected data deleted successfully.";
		 } 
		 else
		 { 
		 $res=mysql_error();
		 } 
		 echo $res;
		 mysql_close($dbConn);
 } 
else
 {
		$res="Invalid Request";
		echo $res;

 }

?>