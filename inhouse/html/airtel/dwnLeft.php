<?php

//////////////// File Pupose -> return total no of downloads left for particular user subscription for airtel gud life service @jyoti.porwal //////////////////////
//include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php"); // airtel db connection @jyoti.porwal
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
$msisdn = trim($_REQUEST['msisdn']);

$logPath = "/var/www/html/airtel/log/returnDwnldLeft/returnDwnldLeftlog_" . date("Y-m-d") . ".txt";

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
//////////////////////////////////// start code for total no of downloads left here @jyoti.porwal ///////////////////////////////////////////////////////    
    $msisdn = checkmsisdn(trim($msisdn), $abc);
    $selectData = "select total_no_downloads from airtel_rasoi.tbl_rasoi_subscriptionWAP nolock where ani=" . $msisdn;
    $result = mysql_query($selectData);
    list($total_no_downloads) = mysql_fetch_array($result);

    if ($total_no_downloads == '' || $total_no_downloads == '-1') {
        $total_no_downloads = 0;
    }
    echo $total_no_downloads;
    $logData = $msisdn . "#" . $total_no_downloads . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
//////////////////////////////////// end code for total no of downloads left here @jyoti.porwal ///////////////////////////////////////////////////////    
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn); // close db connection @jyoti.porwal
?>