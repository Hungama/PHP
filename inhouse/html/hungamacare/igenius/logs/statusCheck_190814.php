<?php

/* @author: Jyoti Porwal
 * @File prupose: return child 1 subscription date, child 1 update date, child 2 subscription date, child 2 update date
 */
error_reporting(1);
include ("../config/dbConnect.php"); // db connection @jyoti.porwal
$logDir = "/var/www/html/hungamacare/igenius/logs/statuscheck/"; // log path @jyoti.porwal
$logFile_dump = "logs_" . date('Ymd');
$logPath = $logDir . $logFile_dump . ".txt";

$ipAddress = $_SERVER['REMOTE_ADDR'];

$msisdn = $_REQUEST['msisdn'];

$logString = $msisdn . "#" . $ipAddress . "\r\n";
error_log($logString, 3, $logPath);

if ($msisdn == '') {
    echo "Invalid Parameter";
    exit; // if msisdn not found than exit @jyoti porwal
}

/* * ************************************************************************* satrt database intraction @jyoti.porwal ********************************* */

/* * ************************************************************************* end database intraction @jyoti.porwal ********************************* */

$logString = "NA#NA#NA#NA"; // return string @jyoti.porwal
error_log($logString, 3, $logPath);
echo $logString;
return $logString;
exit;
?>