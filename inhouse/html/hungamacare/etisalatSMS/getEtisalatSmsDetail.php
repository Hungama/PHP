<?php
$dbConn_224 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$dbConn_224)
 {
 echo '224- Could not connect';
 die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 $smsid=$_REQUEST['smsid'];
 $type=$_REQUEST['type'];
 if($type==1)
 {
$select_query="select message,service from etislat_hsep.tbl_sms_service where msg_id=$smsid";
$result = mysql_query($select_query,$dbConn_224) or die(mysql_error());
$message= mysql_fetch_array($result);
echo $message['service'].'@@'.$message['message'];
}
else if($type==2)
{
$select_query="select service from etislat_hsep.tbl_sms_service where msg_id=$smsid";
$result = mysql_query($select_query,$dbConn_224) or die(mysql_error());
$message= mysql_fetch_array($result);
echo $message['service'];
}
else
{
echo "Invalid Request.";
}
mysql_close($dbConn_224);
?>