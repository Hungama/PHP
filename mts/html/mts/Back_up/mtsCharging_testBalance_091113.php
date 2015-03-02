<?php

$msisdn = trim($_REQUEST['msisdn']);
$serviceid = ($_REQUEST['serviceid']);
$reqType = ($_REQUEST['reqType']);
$usu = ($_REQUEST['usu']);
$RPid = trim($_REQUEST['RPid']);

$date = date("dmY H:i:s");

$logDir = "/var/www/html/mts/logs/Charging/";
$logTerDir = "/var/www/html/mts/logs/Terminate/";
$logFailDir = "/var/www/html/mts/logs/Charging/Fail/";
$logBalDir = "/var/www/html/mts/logs/Charging/Balance/";
$logFile = date('dmY') . "_log";
$logFilePath = $logDir . $logFile . ".txt";
$logTerFilePath = $logTerDir . $logFile . ".txt";
$logFailFilePath = $logFailDir . $logFile . ".txt";
$logBalFilePath = $logBalDir . $logFile . ".txt";

$logFile_req = date('dmY') . "_reqlog";
$logFilePath_reqs = $logDir . $logFile_req . ".txt";
error_log($msisdn . "#" . $serviceid . "#" . $reqType . "#" . $usu . "#" . $RPid . "#" . $date . "\n", '3', $logFilePath_reqs);

$urltopost = "http://10.130.14.40:8080//cvp/chargingServlet";
//echo $msisdn."**".$serviceid."***".$reqType."***".$usu."***".$RPid;

$msisdn = substr($msisdn, -10);

if ($reqType != '3') {
    $dataBalance = "<RealTimeOperationRequest xmlns='xmltypes.cs.cvp.hp.com'>";
    $dataBalance.="<REQUEST_NAME>QB</REQUEST_NAME>";
    $dataBalance.="<MSISDN>$msisdn</MSISDN>";
    $dataBalance.="</RealTimeOperationRequest >";
    $resultBalanceData = postData($urltopost, $dataBalance);
    
    $xml = simplexml_load_string($resultBalanceData);
    $BALANCE_RESULT_CODE = $xml->RESULT_CODE;
    $BALANCE_RESULT_DESC = $xml->RESULT_DESC;
    $BALANCE_MSISDN = $xml->MSISDN;
    $BALANCE = $xml->CUSTOMER_BALANCE;
    error_log($BALANCE_RESULT_CODE . "#" . $BALANCE_RESULT_DESC . "#" . $BALANCE_MSISDN . "#" . $BALANCE . "\n", '3', $logBalFilePath);
    
    if (($serviceid == '61' && $RPid == '80' && $BALANCE >= 3) || ($serviceid == '61' && $RPid == '81' && $BALANCE >= 1) || ($serviceid == '62' && $RPid == '82' && $BALANCE >= 3) || ($serviceid == '62' && $RPid == '83' && $BALANCE >= 1) || $BALANCE_RESULT_CODE == '3106' || $BALANCE_RESULT_CODE == '5030') {
        
    }else{
        $resp = 'sessionvalidity=0';
        echo $resp;
        exit();
    }
}
exit();
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

error_log($RESULT_CODE . "#" . $RESULT_DESC . "#" . $MSISDN . "#" . $REQUEST_NAME . "#" . $REQUEST_TYPE . "#" . $GRANTED_SERVICE_UNITS . "#" . $date . "\n", '3', $logFilePath);

//echo $RESULT_CODE . "," . $RESULT_DESC . "," . $MSISDN . "," . $REQUEST_NAME . "," . $REQUEST_TYPE . "," . $GRANTED_SERVICE_UNITS;
header('Content-type: application/x-www-form-urlencoded');

if ($REQUEST_TYPE == 1 || $REQUEST_TYPE == 2) {
    if ($RESULT_CODE == '2001') {
        $resp = 'sessionvalidity=' . $GRANTED_SERVICE_UNITS;
    } else {
        $resp = 'sessionvalidity=0';
    }
    echo $resp;
} else if ($REQUEST_TYPE == 3 && $RESULT_CODE != '2001') {
    error_log($RESULT_CODE . "#" . $RESULT_DESC . "#" . $MSISDN . "#" . $REQUEST_NAME . "#" . $REQUEST_TYPE . "#" . $GRANTED_SERVICE_UNITS . "#" . $date . "\n", '3', $logFailFilePath);
    for ($i = 1; $i <= 5; $i++) {
        $resultData = postData($urltopost, $data1);
        $xml = simplexml_load_string($resultData);
        $RESULT_CODE = $xml->RESULT_CODE;
        $RESULT_DESC = $xml->RESULT_DESC;
        $MSISDN = $xml->MSISDN;
        $REQUEST_NAME = $xml->REQUEST_NAME;
        $REQUEST_TYPE = $xml->REQUEST_TYPE;
        $GRANTED_SERVICE_UNITS = $xml->GRANTED_SERVICE_UNITS;
        if ($RESULT_CODE == '2001') {
            error_log($RESULT_CODE . "#" . $RESULT_DESC . "#" . $MSISDN . "#" . $REQUEST_NAME . "#" . $REQUEST_TYPE . "#" . $GRANTED_SERVICE_UNITS . "#" . $date . "\n", '3', $logFilePath);
            $resp = 'sessionvalidity=' . $GRANTED_SERVICE_UNITS;
            echo $resp;
            exit();
        }
    }

    //error_log($RESULT_CODE . "#" . $RESULT_DESC . "#" . $MSISDN . "#" . $REQUEST_NAME . "#" . $REQUEST_TYPE . "#" . $GRANTED_SERVICE_UNITS . "#" . $date . "\n", '3', $logTerFilePath);
}
session_destroy();

function postData($urltopost, $data1) {
    $ch = curl_init($urltopost);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $returndata = curl_exec($ch);
    return $returndata;
    exit;
}

exit;
?>
