<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
include "/var/www/html/hungamawap/config/wapVisitorLogs.php";
if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);
$contentID = trim($_REQUEST['content_id']);
$type='SUB';
$amount='';
$chrgingurl='';
$operator='AIRM';
$serviceid=1515;
$affid='';
$conset_url = "http://117.239.178.108/hungamawap/airtel/sarnam/CCG/doubleConsentLDR.php";
$conset_url = $conset_url . "?msisdn=" . $msisdn . "&contentID=" . $contentID;
$logPath = "logs/Sublog_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$contentID."#". $conset_url."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
header("Location:" . $conset_url);
?>