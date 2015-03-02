<?php

///////////////////////// File Pupose -> check msisdn subscribed or not for airtel gud life service @jyoti.porwal /////////////////////////////////////////
//include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php"); // airtel db connection @jyoti.porwal
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);

$logPath = "/var/www/html/airtel/log/checkStatus/checkStatuslog_" . date("Y-m-d") . ".txt";

$logData = $msisdn . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath); // write all getting parameter @jyoti.porwal

if ($msisdn == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
    exit;
}

///////////////////////////////////////////////////////// start function for check msisdn length @jyoti.porwal /////////////////////////////////////////////////
function checkmsisdn($msisdn, $abc) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            }
        }
    } else {
        echo "Invalid Parameter";
        exit;
    }
    return $msisdn;
}

//////////////////////////////////////////////////////// end function for check msisdn length @jyoti.porwal ///////////////////////////////////////////////
if (is_numeric($msisdn)) {
    $msisdn = checkmsisdn(trim($msisdn), $abc);
    $selectData = "select count(*) from airtel_rasoi.tbl_rasoi_subscriptionWAP nolock where status in(1,11,9) and ani=" . $msisdn;
    $result = mysql_query($selectData);
    list($count) = mysql_fetch_array($result);

    if ($count) {
        echo $response = "subscribed";
    } else {
        echo $response = "not subscribed";
    }
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn); // close db connection @jyoti.porwal
?>