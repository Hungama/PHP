<?php

ini_set('display_error', 1);
include ("/var/www/html/hungamacare/config/dbConnect.php");
if (!$dbConn) {
    echo '224- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}
$msisdn = $_REQUEST['msisdn'];
if (strlen($msisdn) == 12) {
    if (substr($msisdn, 0, 2) == 91) {
        $msisdn = substr($msisdn, -10);
    }
}

$operator = $_REQUEST['operator'];
$operator = 'UNINOR';
$req_received = date("Y-m-d H:i:s");


$logFile = "/var/www/html/hungamacare/contest/API/logs/checkSubscribedStatus_" . date('Ymd') . ".txt";

$logData = $msisdn . "#" . $operator . "#" . date("Y-m-d H:i:s") . "\n";
error_log($logData, 3, $logFile);

//log all request parameter end here
switch ($operator) {
    case 'UNINOR':
        $subscription_db = "uninor_summer_contest";
        $subscription_table = "tbl_contest_subscription_wapcontest";
        //$con = mysql_connect("192.168.100.224", "webcc", "webcc"); //UNINOR
        break;
}

$query = "select ANI from " . $subscription_db . "." . $subscription_table . " where STATUS=1 and ANI='" . $msisdn . "'";
$result = mysql_query($query, $dbConn) or die(mysql_error());
$details = mysql_fetch_array($result);
$ANI = $details['ANI'];
if ($ANI != '') {
    $response = "OK#" . $ANI;
} else {
    $response = "Not OK#" . 'msisdn not subscribed.';
}
echo $response;
$logData = $msisdn . "#" . $query . "#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
error_log($logData, 3, $logFile);

mysql_close($dbConn_224);
mysql_close($con);
?>