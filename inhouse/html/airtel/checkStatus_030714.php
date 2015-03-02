<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$msisdn = trim($_REQUEST['msisdn']);
$service = trim($_REQUEST['service']);

$logPath = "/var/www/html/airtel/log/checkStatus/checkStatuslog_" . date("Y-m-d") . ".txt";

$logData = $msisdn . "#" . $service . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);

if ($msisdn == '' || $service == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $service . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
    exit;
}

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

switch ($service) {
    case '1511':
        $db = "airtel_rasoi";
        $tbl = "tbl_rasoi_subscription";
}

if (is_numeric($msisdn)) {
    $msisdn = checkmsisdn(trim($msisdn), $abc);
    $selectData = "select count(*) from " . $db . "." . $tbl . " where ani=" . $msisdn;
    $result = mysql_query($selectData);
    list($count) = mysql_fetch_array($result);

    if ($count) {
        $selectDwnldCount = "select totaldownldcount from " . $db . "." . $tbl . " where ani=" . $msisdn;
        $resultDwnldCount = mysql_query($selectDwnldCount);
        list($totaldownldcount) = mysql_fetch_array($resultDwnldCount);
        if ($totaldownldcount == '') {
            $totaldownldcount = 0;
        }
        echo $response = "Success#" . $totaldownldcount;
    } else {
        echo $response = "Fail#0";
    }
    $logData = $msisdn . "#" . $service . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $service . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn);
?>