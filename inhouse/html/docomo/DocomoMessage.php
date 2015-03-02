<?php
$con = mysql_connect("database.master","weburl","weburl");
if(!$con)
	die('could not connect1: ' . mysql_error());

$messaheUrl="http://202.87.41.148/sms/4646/services/manageSmsSub_dev/fetch_msg.php?op=voice&keyword=BGoss";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$messaheUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);
$msg="<table border=1><tr><td>Sr. No.</td><td>Message</td></tr><tr><td>1 </td><td>";
$ResponseText=str_replace($msg,"",$response);
$ResponseText1=str_replace("</td></tr></table>","",$ResponseText);
$sc=59090;

$fetchMsisdn="Select ani from docomo_radio.tbl_radio_smspack_sub";
$FetchRecord = mysql_query($fetchMsisdn);
while(list($msisdn)=mysql_fetch_row($FetchRecord))
{
	$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$msisdn."','".$ResponseText1."','$sc','TATM','TATMSMS',1)";
	$sndMsg = mysql_query($sndMsgQuery);
	$updateQuery="update docomo_radio.tbl_radio_smspack_sub set sms_status=1 where ani=$msisdn";
	$updateMsg = mysql_query($updateQuery);
}
?>  