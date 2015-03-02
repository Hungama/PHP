<?php
$logDir="/var/www/html/docomo/logs/docomo/dc/";
$curdate = date("Ymd");
$logPath2 = $logDir."ccg_".$curdate.".txt";
$transId=date('YmdHis');
$msisdn=$_REQUEST['ani'];
sleep(5);
$url="http://182.156.191.80:8091/API/CCG?MSISDN=$msisdn&productID=GSMENDLESSDAILY2&pName=Endlessmusic&reqMode=USSD&reqType=SUBSCRIPTION&ismID=16&transID=$transId&pPrice=200&pVal=2&CpId=hug&CpName=Hungama&CpPwd=hug@8910";
$logurl="Response:100#url#".$url."#".date("Y-m-d H:i:s")."\n";
error_log($logurl,3,$logPath2);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	$logresponse="#Response#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logresponse,3,$logPath2);
	exit;
?>