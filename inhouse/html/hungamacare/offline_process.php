<?php

/* @author: Jyoti Porwal
 * @purpose: call servlet and procedure 
 */
include ("config/dbConnect.php"); // db connection @jyoti porwal
$msisdn = $_REQUEST['msisdn'];
$ipAddress = $_SERVER['REMOTE_ADDR'];

$logdate = date("Y-m-d");
$logPath = "/var/www/html/hungamacare/log/offline_process/offline_process_" . $logdate . "_log.txt"; // log path @jyoti porwal

$logString = $msisdn . "#" . $ipAddress . "\r\n";
error_log($logString, 3, $logPath);

if ($msisdn == '') {
    echo "Invalid Parameter";
    exit; // if msisdn not found than exit @jyoti porwal
}
//CPTID=201408068712&amp;DT=2014-08-06%2008:07:12
//////////////////////////////////////////////////// start code for servlet call @jyoti.porwal ////////////////////////////////////////////////////////
$CPTID_value = date("Ymdhis");
$DT_value = date("Y-m-d H:i:s");
$url = "http://192.168.100.227:8084/hungama/sendconsent?PATH=http://192.168.100.226:8081/promptFiles/cricket_unim/01/&LANG=HIN&SCHN=IVR&CP=HUNGAMA&MSISDN=8546048758&CPPID=HUI0000007&PRODTYPE=SUB&PMARKNAME=Uninor%20Sports%20Unlimited&PRICE=30&SE=HUNGAMA&CPTID=" . $CPTID_value . "&DT=" . $DT_value . "&PD=Sports%20Portal&SCODE=songid&RSV=rsv&RSV2=rsv2";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$returndata = curl_exec($ch);
//////////////////////////////////////////////////// end code for servlet call @jyoti.porwal ////////////////////////////////////////////////////////
//$msisdn = "8546048758";
//////////////////////////////////////////////////// start code for procedure call @jyoti.porwal ////////////////////////////////////////////////////////
$langValue = "01";
$mode = "IVR";
$dnis = "52444";
$amount = "30";
$s_id = "1408";
$planid = "114";

$qry = "call uninor_cricket.CRICKET_SUB('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $dnis . "','" . $amount . "'," . $s_id . "," . $planid . ")";
$details = mysql_query($qry, $dbConn);
//////////////////////////////////////////////////// end code for servlet call @jyoti.porwal ////////////////////////////////////////////////////////
$logString = $qry . "\r\n";
error_log($logString, 3, $logPath);

mysql_close($dbConn); // db connection close @jyoti.porwal
echo "Done";
?>