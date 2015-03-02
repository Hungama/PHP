<?php

///////////////////////// File Pupose -> send sms on user's mobile no  for airtel gud life service @jyoti.porwal /////////////////////////////////////////
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php"); // airtel db connection @jyoti.porwal
$msisdn = trim($_REQUEST['msisdn']);
$message = trim($_REQUEST['message']);

$logPath = "/var/www/html/airtel/log/sendSMS/sendSMSlog_" . date("Y-m-d") . ".txt";

$logData = $msisdn . "#" . $message . "#" . date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath); // write all getting parameter @jyoti.porwal

if ($msisdn == '' || $message == '') {
    echo $response = "Incomplete Parameter";
    $logData = $msisdn . "#" . $message . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
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
//////////////////////////////////////////////////////////// start code to send sms @jyoti.porwal //////////////////////////////////////////////////////////    
    $msisdn = checkmsisdn(trim($msisdn), $abc);
    $sndMsg = "call master_db.SENDSMS('" . trim($msisdn) . "','" . $message . "','HMLIFE',3,'55001','sub');";
    if (mysql_query($sndMsg)) {
        $response = "success";
    } else {
        $response = "error";
    }
    echo $response;
    $logData = $msisdn . "#" . $message . "#" . $sndMsg . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
////////////////////////////////////////////////////////////// end code to send sms @jyoti.porwal //////////////////////////////////////////////////////////
} else {
    echo $response = "Invalid Parameter";
    $logData = $msisdn . "#" . $message . "#" . $response . "#" . date('Y-m-d H:i:s') . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbAirtelConn); // close db connection @jyoti.porwal
?>