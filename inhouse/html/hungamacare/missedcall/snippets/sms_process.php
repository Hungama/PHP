<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$msg_type=$_REQUEST['msg_type'];
$circle=$_REQUEST['circle'];
$msg=trim($_REQUEST['msg']);
$S_id=$_REQUEST['S_id'];
$msg_type=explode("|",$msg_type);
$mainkeyword=$msg_type[0];
$subkeyword=$msg_type[1];
if (isset($_REQUEST['priority'])) {
$priority=$_REQUEST['priority'];
}
else
{
$priority=5;
}
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$SaveMsgquery="insert into Inhouse_IVR.tbl_smskci_serviceMsgDetails(S_id, msg_type, msg_desc, added_on, added_by, circle, ip, lastModifyOn,kci_type,priority)
 values('$S_id', '$mainkeyword', '$msg', now(), '$user_id', '$circle', '$remoteAdd', now(),'$subkeyword','$priority')";
if(mysql_query($SaveMsgquery, $dbConn))
{
echo trim($subkeyword);
}
else
{
echo 'NOK';
}
mysql_close($dbConn);
/*$msg = "Message has been saved successfully.";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
*/
?>