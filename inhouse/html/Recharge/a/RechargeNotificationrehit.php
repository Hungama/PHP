<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$reponseLog="/var/www/html/Recharge/log/RehitResponse_17OCT.txt";

$getMsisdnRecord="select msisdn,response,transactionId from master_db.tbl_recharged where date(request_time)='2012-11-21' and msisdn in(7276012082)";

echo $result=mysql_query($getMsisdnRecord,$dbConn);

//$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
//$callBackUrl .="?status=".$status."&response=".$oxigenId."&tid=".$transactionid."&responseText=".$ResponseText;

while(list($msisdn,$response,$transaction_id)=mysql_fetch_array($result))
{
	$pos = strrpos($response,"Successful");

	if($pos)
		$status='Success';
	else
		$status='Failed';

	$decodeResponse=urldecode($response);
	$exploded=explode("|",$decodeResponse);
	
	$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
	$callBackUrl .="?status=".$status."&response=".$exploded[2]."&tid=".$transaction_id."&responseText=".$response;
	echo $callBackUrl."<br>";

	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL,$callBackUrl);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//$CallBackResponse = curl_exec($ch);
		
	$message .=$record['response_time']."|".$record['msisdn']."|".$Operator."|".$Area."|".$Amount."|".$ResponseText."|".$callBackUrl."|".$CallBackResponse."\r\n";
	error_log($message,3,$reponseLog);
}
//exit;
?>
