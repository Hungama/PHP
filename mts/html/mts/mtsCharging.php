<?php

$msisdn = trim($_GET['msisdn']);
$serviceid = ($_GET['serviceid']);
$reqType = ($_GET['reqType']);
$usu = ($_GET['usu']);
$RPid = trim($_GET['RPid']);

$date = date("dmY H:i:s");

$logDir = "/var/www/html/MTS/logs/Charging/";
$logFile = date('dmY') . "_log";
$logFilePath = $logDir . $logFile . ".txt";

$urltopost = "http://10.130.14.40:8080//cvp/chargingServlet";

$data1 = "<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
$data1.="<SERVICE_ID>$serviceid</SERVICE_ID>";
$data1.="<ISV_ID>4</ISV_ID>";
$data1.="<REQUEST_NAME>Browsing</REQUEST_NAME>";
$data1.="<REQUEST_TYPE>$reqType</REQUEST_TYPE>";
$data1.="<USED_SERVICE_UNITS>$usu</USED_SERVICE_UNITS>";
if ($reqType == '3') {
    $data1.="<TERMINATE_CAUSE>Logout</TERMINATE_CAUSE>";
}
$data1.="<MSISDN>$msisdn</MSISDN>";
$data1.="<RATE_PLAN_ID>$RPid</RATE_PLAN_ID>";
$data1.="</RealTimeOperationRequest >";

$resultData = postData($urltopost, $data1);
//print_r($resultData);die('here');

$xml = simplexml_load_string($resultData);
$RESULT_CODE = $xml->RESULT_CODE;
$RESULT_DESC = $xml->RESULT_DESC;
$MSISDN = $xml->MSISDN;
$REQUEST_NAME = $xml->REQUEST_NAME;
$REQUEST_TYPE = $xml->REQUEST_TYPE;
$GRANTED_SERVICE_UNITS = $xml->GRANTED_SERVICE_UNITS;

error_log($RESULT_CODE . "#" . $RESULT_DESC . "#" . $MSISDN . "#" . $REQUEST_NAME . "#" . $REQUEST_TYPE. "#" . $GRANTED_SERVICE_UNITS. "#" . $date."\n", '3', $logFilePath);

echo $RESULT_CODE . "," . $RESULT_DESC . "," . $MSISDN . "," . $REQUEST_NAME . "," . $REQUEST_TYPE . "," . $GRANTED_SERVICE_UNITS;

if ($REQUEST_TYPE == 1 || $REQUEST_TYPE == 2) {
    if ($RESULT_CODE == '2001') {
        return $GRANTED_SERVICE_UNITS;
    } else {
        return 0;
    }
}
exit;
function postData($urltopost, $data1) {
    $ch = curl_init($urltopost);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $returndata = curl_exec($ch);
    return $returndata;
    exit;
}

?>
