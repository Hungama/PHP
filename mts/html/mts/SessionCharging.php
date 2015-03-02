<?php

$msisdn = trim($_GET['msisdn']);
$serviceid = ($_GET['serviceid']);
$reqType = ($_GET['reqType']);
$usu = ($_GET['usu']);
$RPid = trim($_GET['RPid']);

$date = date("dmY H:i:s");

$logDir = "/var/www/html/MTS/logs/SessionCharging/";
$logFile = date('dmY') . "_log";
$logFilePath = $logDir . $logFile . ".txt";

error_log($msisdn . "#" . $serviceid . "#" . $reqType . "#" . $usu . "#" . $RPid. "#".$date."\n", '3', $logFilePath);

//echo "sessionvalidity=60";
//
////$return_array = array();
////$return_array['sessionvalidity'] = '60';
////return $return_array['sessionvalidity'];
//return "sessionvalidity=60";

header('Content-type: application/x-www-form-urlencoded');
echo "sessionvalidity=60";

?>
