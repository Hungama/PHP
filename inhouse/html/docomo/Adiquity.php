<?php 

$adequityUrl="http://tracker.adiquity.com/mtrack";
$adequityUrl .="?v1=".$_REQUEST['v1']."&v2=".$_REQUEST['v2']."&v3=".$_REQUEST['v3']."&v4=".urlencode($_REQUEST['v4']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$adequityUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);

$logdate=date("Ymd");
$logPath="/var/www/html/docomo/logs/adequityVoice/".$logdate."_log1.log";
$logString=$_REQUEST['v1']."|".date('d-m-Y h:i:s')."|".$_REQUEST['v2']."|".$_REQUEST['v3']."|".$_REQUEST['v4']."|".$p1."|".$adequityUrl."|".$chargingResponse."\r\n";
error_log($logString,3,$logPath);

?>