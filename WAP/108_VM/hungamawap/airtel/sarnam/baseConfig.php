<?php
$logdate = date("Ymd");
$logPath_MIS218_Airtel="/var/www/html/hungamawap/airtel/sarnam/CCG/logs/AllAirtelVisitorRequestMISNew_".$logdate.".txt";
$dbname='airtel_devo';
$subtable=$dbname.'.tbl_sarnam_subscriptionWAP';
$unsubtable=$dbname.'.tbl_sarnam_unsubWAP';
$dwntable=$dbname.'.tbl_wap_download';
$unsubProcedure=$dbname.".SARNAM_UNSUBWAP";
?>