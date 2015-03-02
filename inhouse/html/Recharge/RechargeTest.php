<?php

//include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

//$msisdn=8860149332;
echo urldecode("20%7C+Repeated+Transaction+with-in+5+minutes%2C+please+try+after+some+time+in+case+transaction+is+unsuccessful.+OxiTransID+-+03384580011209261324%7C6DYMM7T4JKCTB9DMQDS2");
//exit;
$msisdn=8081646010;
$amount=20;
function chargedMsisdn($msisdn,$amount)
{
	$rechargeUrl="http://202.87.41.148/sms/4646/mo6_mkt/Rechaged/rechaged.php?msisdn=".$msisdn."&amount=".$amount."&client_id=4";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$rechargeUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	return $response;
}
//$getMsisdn="select Msisdn,amount,transactionid,id from master_db.tbl_recharged where status=0 limit 100";
//$result=mysql_query($getMsisdn,$dbConn);

//while(list($msisdn,$amount,$transactionid,$id)=mysql_fetch_array($result))
//{
	//echo $chrgedResponse12=chargedMsisdn($msisdn,$amount);

	//$chrgedResponse12="<table border='1'><th>SR NO</th><th>DATE</th><th>MSISDN</th><th>OPERATOR</th><th>AREA</th><th>AMOUNT</th><th>RESPONSE</th>";
	//$chrgedResponse12 .="<tr><td>1</td><td>20120731:16:04:29</td><td>918860149334</td><td>VODA</td><td>DEL</td><td>10</td>";
	//$chrgedResponse12 .="<td>0|Transaction Successful OxiTransID - 19692180011207311627|69E7EBSZ4VLGUPQG3GAJ</td></tr></table>";

	$chrgedResponse12="<table border='1'><th>SR NO</th><th>DATE</th><th>MSISDN</th><th>OPERATOR</th><th>AREA</th><th>AMOUNT</th><th>RESPONSE</th>";
	$chrgedResponse12 .="<tr><td>1</td><td>20120926:10:28:44</td><td>918081646010</td><td>RELIANCE</td><td>UP EAST</td><td>20</td>";
	$chrgedResponse12 .="<td>0|Transaction Successful OxiTransID - 98497720011209261052|6DYCXHC78RAJVZ4L6QL2</td></tr></table>";
	
	$explodedResult=explode("<td>",$chrgedResponse12);
	echo "<pre>";	print_r($explodedResult);
	
	echo $ResponseText=str_replace("</td></tr></table>","",$explodedResult[7]);
	
	
	exit;


	$message=$msisdn."|".date("H:i:s")."|";
	$reponseLog="/var/www/html/Recharge/log/Response_".date("Ymd").".txt";

	$responseTime=substr($chrgedResponse12,140,17);
	
	$Msisdn=substr($chrgedResponse12,157,21);
	$Msisdn=str_replace("</td><td>","",$Msisdn);

	$Operator=substr($chrgedResponse12,187,5);
	$Operator=str_replace("<","",$Operator);

	$Area=substr($chrgedResponse12,200,4);
	$Area=str_replace("<","",$Area);

	$Amount=substr($chrgedResponse12,212,3);
	$Amount=str_replace("<","",$Amount);

	$Response123=substr($chrgedResponse12,223);
	$ResponseText=str_replace("</td></tr></table>","",$Response123);
	$ResponseText=str_replace("td>","",$ResponseText);
	
	$oxigenIdPos=strpos($ResponseText,"OxiTransID - ");
	$oxigenId=substr($ResponseText,$oxigenIdPos+13);
	$oxigenId=trim($oxigenId);
	$transactionid=trim($transactionid);
	$pos = strrpos($ResponseText,"Transaction Successful");
	$ResponseText=urlencode(trim($ResponseText));
	
	if($pos)
		$status='Success';
	else
		$status='Failed';

	$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
	$callBackUrl .="?status=".$status."&response=".$oxigenId."&tid=".$transactionid."&responseText=".$ResponseText;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$callBackUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$CallBackResponse = curl_exec($ch);
	

	$message .=$responseTime."|".$Msisdn."|".$Operator."|".$Area."|".$Amount."|".$ResponseText."|".$callBackUrl."|".$CallBackResponse."\r\n";
	
	echo $updateRecord="update master_db.tbl_recharged set status=1,response_time=now(),response='".$ResponseText."' where id=".$id;
	$updateResult=mysql_query($updateRecord,$dbConn);
	error_log($message,3,$reponseLog);
//}
//exit;
?>