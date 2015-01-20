<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";
include "/var/www/html/hungamawap/airtel/db.php";
include "/var/www/html/hungamawap/airtel/sarnam/baseConfig.php";

$ani=trim($_REQUEST['msisdn']);

if (is_numeric($ani)) {

     if (strlen($ani) == 12)
    $ani = substr($ani, -10);

    $selectData = "select count(1) from $subtable nolock where status!=0 and ani=" . $ani;
    $result = mysql_query($selectData,$con);
    list($count) = mysql_fetch_array($result);

    if ($count) {
        $response = "CGNOK";
    } else {
        $response = "CGOK";
    }
    
} else {
    $response = "CGNOK";
    
}
if(isset($response)) { 
$resp=$response;
}
else
{
$resp = "CGNOK";
}
echo $resp;
$logPath = "logs/allstatusChecklog_" . date("Ymd") . ".txt";
$logData = $ani ."#".$resp."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
mysql_close($con);
?>