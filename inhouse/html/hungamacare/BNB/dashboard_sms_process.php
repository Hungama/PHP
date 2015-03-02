<?php
session_start();
require_once("db.php");
$masterkeyword=$_REQUEST['form_sms_keyword'];
$keyword=$_REQUEST['form_sms_subkeyword'];
$response=$_REQUEST['form_sms_resp'];
$addedby=$_SESSION["logedinuser"];
$remoteAdd = $_SERVER['REMOTE_ADDR'];
/*
$update_song_status = "update USSD.tbl_songname set status=0 where ussd_string='".$ussd_str."'";
mysql_query($update_song_status,$con);
*/
$sql_song1="INSERT INTO master_db.tbl_bnb_sms (sms_keyword,response,added_on,added_by,ip,lastmodify,master_keywordId)
VALUES ('".$keyword."','".$response."',now(),'".$addedby."','".$remoteAdd."',now(),'".$masterkeyword."')";
if(mysql_query($sql_song1,$con))
{
$msg='Keyword saved Successfully.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
}
else
{
$msg='Server Error.Please try again.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">$msg</div></div>";
}
mysql_close($con);
exit;
?>