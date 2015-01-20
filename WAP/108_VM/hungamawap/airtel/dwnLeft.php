<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
$starttime=date('Y-m-d H:i:s');
include "/var/www/html/hungamawap/airtel/db.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);


if (is_numeric($msisdn)) {

if (strlen($msisdn) == 12)
$msisdn = substr($msisdn, -10);

    $selectData = "select total_no_downloads from airtel_rasoi.tbl_rasoi_subscriptionWAP nolock where ani=" . $msisdn;
    $result = mysql_query($selectData,$con);
    list($total_no_downloads) = mysql_fetch_array($result);

    if ($total_no_downloads == '' || $total_no_downloads == '-1') {
        $total_no_downloads = 0;
    }
    $response=$total_no_downloads;
	echo $response;
    
} else {
    echo $response = "Invalid Parameter";
   }

$logPath = "logs/dwnLeftlog_" . date("Ymd") . ".txt";
$logData = $msisdn ."#".$response."#".$starttime."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>
