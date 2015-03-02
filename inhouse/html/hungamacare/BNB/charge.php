<?php
session_start();
require_once("db.php");
$msisdn = $_REQUEST['msisdn'];
$dtmf = $_REQUEST['dtmf'];
$ussd_string = $_REQUEST['ussd_string'];
$ussd_string = $ussd_string . "#";
$logpath= "/var/www/html/hungamacare/ussd/logs/dtmf/";
$curdate = date("Ymd");
$logpath_dtmf = $logpath . "log_" . $curdate . ".txt";

$select_query = "select contentid from USSD.tbl_songname_dtmf where DTMF='" . $dtmf . "' and ussd_string='" . $ussd_string . "' and status=1";
$result = mysql_query($select_query, $con);
$details = mysql_fetch_array($result);

$pinResponse=file_get_contents("http://202.87.41.147/waphung/voiceContentServe/PIN_generate.php");
$pushurl = "http://202.87.41.147/waphung/voiceContentServe/" .$details[0] . "/".$pinResponse;


$url="http://119.82.69.210/billing/uninor_billing/UninorWapUpdated.php?msisdn=".$msisdn."&amt=10&cpId=HUI0003712&sid=1412&mode=wap";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$fileResponse = curl_exec($ch);

$procedureCall = "call master_db.SENDSMS_NEW(" . $msisdn . ",'" . $pushurl . "',52888,'UNIM','NO_CALL_PROMO',5)";
if(trim($fileResponse)=='charged')
	{
		$procedure_query = mysql_query($procedureCall);
		if(mysql_query($procedureCall))
			$query='#query#'.$procedureCall."#SQLResult#SUCCESS";
		else
			$error= mysql_error();
			$query='#query#'.$procedureCall."#SQLResult#".$error;
	echo "Done"; 
	}
else{
echo "Charging Failed";}

$logdata="Msisdn#".$msisdn."#UssdString#".$ussd_string."#DTMF#".$dtmf."#ChargingUrl#".$url."#ChargingResponse#".$fileResponse."#query#".$procedureCall."#".$query."#ProcessTime#".date("Y-m-d H:i:s"). "\n";
error_log($logdata, 3, $logpath_dtmf);

?>