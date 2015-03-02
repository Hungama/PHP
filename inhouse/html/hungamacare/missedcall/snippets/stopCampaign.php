<?php
ob_start();
session_start();
require_once("../../db.php");
$cpgid=$_REQUEST['cpgid'];
$value=$_REQUEST['value'];
if($value==1)
{
$msg="Campaign has been start successfully.";
}
else
{
$msg="Campaign has been stoped successfully.";
}
$logPath="logs/CampaignStopRequest_".date('Ymd').".txt";
$sql="Update Inhouse_IVR.tbl_missedcall_cpginfo set modified_on=now(),status='".$value."' where cpgid='".$cpgid."'";
			if(mysql_query($sql,$con))
			echo $msg;
			else
			echo 'Server Error.Please try again.';
			
$logData=$cpgid."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
mysql_close($dbConn);
?>