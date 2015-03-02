<?php

session_start();
require_once("db.php");

$msisdn = $_REQUEST['msisdn'];
$dtmf = $_REQUEST['dtmf'];
$ussd_string = $_REQUEST['ussd_string'];
$ussd_string = $ussd_string . "#";
$select_query = "select contentid from USSD.tbl_songname_dtmf where DTMF='" . $dtmf . "' and ussd_string='" . $ussd_string . "'";
$result = mysql_query($select_query, $con);
$details = mysql_fetch_array($result);
//$msg = "test message for ussd";

//$url = "http://202.87.41.147/waphung/voiceContentServe/1310880/pin";
$url = "http://202.87.41.147/waphung/voiceContentServe/" . $details[0] . "/pin";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$fileResponse = curl_exec($ch);

$procedureCall = "call master_db.SENDSMS_NEW(" . $msisdn . ",'" . $url . "',52444,'UNIM','NO_CALL_PROMO',5)";
$procedure_query = mysql_query($procedureCall);

echo "Done";
?>
