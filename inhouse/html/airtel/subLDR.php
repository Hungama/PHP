<?php
//LDR WAP Subscriptio request-
$msisdn = trim($_REQUEST['msisdn']);
$contentID = trim($_REQUEST['content_id']);
$conset_url = "http://202.87.41.147/hungamawap/airtel/dconsent/doubleConsentLDR.php";
$conset_url = $conset_url . "?msisdn=" . $msisdn . "&contentID=" . $contentID;
$logPath = "/var/www/html/airtel/log/notification/log_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$contentID."#". $conset_url."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath); // write all getting parameter @jyoti.porwal
header("Location:" . $conset_url);
?>