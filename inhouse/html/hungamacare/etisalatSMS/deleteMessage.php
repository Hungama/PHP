<?php
session_start();
	include ("config/dbConnect.php");
	$msgid=$_REQUEST['msgid'];
	$selectData = "delete FROM etislat_hsep.tbl_sms_service WHERE msg_id='".$msgid."'";
	if(mysql_query($selectData))
	{
	echo "Deleted Successfully";
	}
	else
	{
	echo "Please try again";
	}
?>