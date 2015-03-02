<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$service_info=$_REQUEST['service_info'];
$kcitype=$_REQUEST['kcitype'];
$msg_type=$_REQUEST['msg_type'];
$msg_desc=$_REQUEST['msg_desc'];

//$sinfo=explode("|",$service_info);
$operator='Uninor';
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$SaveMsgquery="insert into Inhouse_IVR.tbl_smskci_serviceinfo(S_id, msg_type, msg_desc, added_on, added_by,status,operator,kci_type)
 values('$service_info', '$msg_type', '$msg_desc', now(), '$user_id', '1', '$operator','$kcitype')";
$queryIns = mysql_query($SaveMsgquery, $dbConn);
mysql_close($dbConn);
$msg = "Keyword has been created successfully.";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
?>