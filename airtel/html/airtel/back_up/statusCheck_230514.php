<?php

header("Content-type: text/xml");
error_reporting(0);
$msisdn = trim($_REQUEST['msisdn']);
$action = $_REQUEST['action'];
$pid = $_REQUEST['pid'];

if (($msisdn == "") || ($pid == "") || ($action == "")) {
    echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    echo "<XML>\n";
    echo "<ERROR>Please provide complete parameter</ERROR>\n";
    echo "<VALUE>100</VALUE>\n";
    echo "</XML>\n";
    exit;
}

function checkmsisdn($msisdn) {
    if (strlen($msisdn) == 10 && is_numeric($msisdn)) {
        return $msisdn;
    }
}

function checkpid($pid) {
    if ((strlen($pid) <= 30) && (ctype_alnum(str_replace('_', '', $pid)))) {
        // if ((strlen($pid) <= 30) && (preg_match('/^[a-zA-Z0-9_]+$/', $pid) == 1)) {
        return $pid;
    }
}

function checkaction($action) {
//    if (ctype_alnum($action)) {
    if ($action == 'CHECK') {
        return $action;
    }
}

$msisdn = checkmsisdn($msisdn, $flag);
$pid = checkpid($pid, $flag);
$action = checkaction($action, $flag);

if (($msisdn == "") || ($pid == "") || ($action == "")) {
    echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    echo "<XML>\n";
    echo "<ERROR>Please provide valid parameter</ERROR>\n";
    echo "<VALUE>101</VALUE>\n";
    echo "</XML>\n";
    exit;
} else {
    include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
    if (!$dbConn) {
        die('could not connect: ' . mysql_error());
    }

    switch ($pid) {
        case '1513':
            $db = "airtel_mnd";
            $subscriptionTable = "tbl_character_subscription1";
            break;
        case '1515':
            $db = "airtel_devo";
            $subscriptionTable = "tbl_devo_subscription";
            break;
        case '1517':
            $db = "airtel_SPKENG";
            $subscriptionTable = "tbl_spkeng_subscription";
            break;
    }
    $query = "select * from " . $db . "." . $subscriptionTable . " where ani='" . $msisdn . "'";
    $result = mysql_query($query);
    $details = mysql_fetch_array($result);
    if (empty($details)) {
        $status = 'UNSUBSCRIBED';
    } elseif ($details['STATUS'] == 1) {
        $status = 'SUBSCRIBED';
    } else {
        $status = 'SUBSCRIPTION_PENDING';
    }

    echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    echo "<XML>\n";
    echo "<STATUS>$status</STATUS>\n";
    echo "</XML>\n";
    exit;
}
?>   