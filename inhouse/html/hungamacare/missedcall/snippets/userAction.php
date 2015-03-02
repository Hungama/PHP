<?php
ob_start();
session_start();
require_once("../../db.php");
$id=$_REQUEST['id'];
$msg="Account has been deleted successfully.";
$sqluser_log="INSERT INTO Inhouse_IVR.tbl_missedcall_signup_log (id, firstname, lastname, email,passwd,city,company,noofemp,website,coupancode,mobileno,registed_on,status,uid,ip,last_login) 
SELECT id, firstname, lastname, email,passwd,city,company,noofemp,website,coupancode,mobileno,registed_on,status,uid,ip,last_login from Inhouse_IVR.tbl_missedcall_signup where uid='".$id."'";
if(mysql_query($sqluser_log,$con))
{
	$logPath="logs/UserProfileRequest_".date('Ymd').".txt";
		echo $sql="Update Inhouse_IVR.tbl_missedcall_signup_log set status='0' where uid='".$id."'";
			if(mysql_query($sql,$con))
			{
			$getcpgid="select cpgid from Inhouse_IVR.tbl_missedcall_cpginfo where uid='".$id."'";
			$check_cpgid_query = mysql_query($getcpgid,$con);
			list($cpgid)=mysql_fetch_array($check_cpgid_query);
			mysql_query("Update Inhouse_IVR.tbl_missedcall_config set cpgid='0' where cpgid='".$cpgid."'",$con);
			mysql_query("Update Inhouse_IVR.tbl_missedcall_cpginfo set status='0' where uid='".$id."'",$con);
			mysql_query("delete from Inhouse_IVR.tbl_missedcall_signup where uid='".$id."'",$con);
			echo $msg;
			}
			else
			{
			echo 'Server Error.Please try again.';
			}
}
else
{
			echo 'Server Error.Please try again1.';
}
$logData=$cpgid."#".date("Y-m-d H:i:s")."\n";
error_log($logData,3,$logPath);
mysql_close($con);
?>