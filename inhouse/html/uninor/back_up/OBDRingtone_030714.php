<?php

error_reporting(0);
include ("../hungamacare/config/dbConnect.php");
if (!$dbConn) {
    die('could not connect to database: ' . mysql_error());
}
$msisdn = $_REQUEST['msisdn'];
$mode = $_REQUEST['mode'];
$dnis = $_REQUEST['dnis'];
$amnt = $_REQUEST['amnt'];
$servicid = trim($_REQUEST['servicid']);
$planid = $_REQUEST['planid'];
$ringid = $_REQUEST['rngid'];
$songid = $_REQUEST['songid'];
$reqtype = $_REQUEST['reqtype'];
$cptid = $_REQUEST['cptid'];
$rcode = $_REQUEST['rcode'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
$curdate = date("Y-m-d");

$logDir = "/var/www/html/Uninor/logs/obd/";
$logFile = "OBDRingtone_" . date('dmY') . ".txt";
$logFilePath = $logDir . $logFile;
error_log($msisdn . "#" . $mode . "#" . $dnis . "#" . $amnt . "#" . $servicid . "#" . $planid . "#" . $ringid . "#" . $songid . "#" . $reqtype . "#" . $cptid . "#" . $remoteAdd . "#" . date('H:i:s') . "\n", '3', $logFilePath);

//$msisdn,$mode,$dnis,$amnt,$servicid,$planid,$ringid,$songid,$reqtype,$cptid

if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE,FAILURE";
}
$abc = explode(',', $rcode);

function checkmsisdn($msisdn, $abc, $logFilePath) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                echo $abc[1];
                error_log($msisdn . "#" . $abc[1] . "#" . $remoteAdd . "#" . date('H:i:s') . "\n", '3', $logFilePath);
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        error_log($msisdn . "#" . $abc[1] . "#" . $remoteAdd . "#" . date('H:i:s') . "\n", '3', $logFilePath);
        exit;
    }
    return $msisdn;
}

$msisdn = checkmsisdn(trim($msisdn), $abc, $logFilePath);
if (($msisdn == "") || ($mode == "") || ($dnis == "") || ($amnt == "") || ($servicid == "") || ($planid == "") || ($ringid == "") || ($songid == "") || ($reqtype == "") || ($cptid == "")) {
    echo "Please provide the complete parameter";
} else {
    switch ($reqtype) {
        case 'mt':
            $planid = '70';
            break;
        case 'pt':
            $planid = '69';
            break;
        case 'tt':
            $planid = '71';
            break;
        default:
            echo "Invalid reqtype.";
            exit;
    }
    $lang = '01';
    $mode = 'OBD';
    $call = "call uninor_myringtone .RADOI_SUBRINGTONE_DOUBLE('$msisdn','$lang','$mode','$dnis','$amnt','$servicid','$planid','$ringid','$songid','$reqtype','$cptid')";
    echo $abc[0];
//$qry1 = mysql_query($call, $dbConn) or die(mysql_error());
//    if (mysql_query($call, $dbConn)) {
//        $rcode = $abc[0];
//        error_log($msisdn . "#" . $mode . "#" . $dnis . "#" . $amnt . "#" . $servicid . "#" . $planid . "#" . $ringid . "#" . $songid . "#" . $reqtype . "#" . $cptid . "#" . $rcode . "#" . $call . "#" . $remoteAdd . "#" . date('H:i:s') . "\n", '3', $logFilePath);
//        exit;
//    } else {
//        $rcode = $abc[1];
//        error_log($msisdn . "#" . $mode . "#" . $dnis . "#" . $amnt . "#" . $servicid . "#" . $planid . "#" . $ringid . "#" . $songid . "#" . $reqtype . "#" . $cptid . "#" . $rcode . "#" . $call . "#" . $remoteAdd . "#" . date('H:i:s') . "\n", '3', $logFilePath);
//        exit;
//    }
}
?>   