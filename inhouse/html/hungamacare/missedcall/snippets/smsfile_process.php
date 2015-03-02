<?php
ob_start();
session_start();
require_once("../../2.0/incs/db.php");
$user_id=$_SESSION['loginId'];
$S_id=$_REQUEST['S_id'];
$remoteAdd=trim($_SERVER['REMOTE_ADDR']);
$orgfilename=$_FILES['upfile']['name'];
$SafeFile = explode(".", $_FILES['upfile']['name']);
$makFileName = str_replace(" ","_",$SafeFile[0])."_".date("YmdHis").".".$SafeFile[1];
	$uploaddir = "msgfile/";
	$path = $uploaddir.$makFileName;
if(move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
  $msg='Message uploded Successfully.';
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
			}
/*
$SaveMsgquery="insert into Inhouse_IVR.tbl_smskci_serviceMsgDetails_tmp(S_id, msg_type, msg_desc, added_on, added_by, circle, ip, lastModifyOn,kci_type,priority)
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
*/
?>