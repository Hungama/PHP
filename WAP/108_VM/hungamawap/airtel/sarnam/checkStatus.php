<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
include "/var/www/html/hungamawap/airtel/db.php";
include "/var/www/html/hungamawap/airtel/sarnam/baseConfig.php";

if($_REQUEST['msisdn']!='')
$msisdn=trim($_REQUEST['msisdn']);

if (is_numeric($msisdn)) {

     if (strlen($msisdn) == 12)
    $msisdn = substr($msisdn, -10);

    $selectData = "select count(*) from $subtable nolock where status in(1,11,9) and ani=" . $msisdn;
    $result = mysql_query($selectData,$con);
    list($count) = mysql_fetch_array($result);

    if ($count) {
        echo $response = "subscribed";
    } else {
        echo $response = "not subscribed";
    }
    
} else {
    echo $response = "Invalid Parameter";
    
}

$logPath = "logs/statusChecklog_" . date("Ymd") . ".txt";
$logData = $msisdn ."#".$response."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>