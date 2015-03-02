<?php

header("Content-type: text/xml");
error_reporting(0);
$msisdn = trim($_REQUEST['msisdn']);
$action = $_REQUEST['action'];
$pid = $_REQUEST['pid'];
$plan = $_REQUEST['plan'];
$transid = $_REQUEST['transid'];
$mode = 'USSD';
$curtime = date(YmdHis);
$response_id = $msisdn . "_" . $curtime;



if (($msisdn == "") || ($pid == "") || ($action == "") || ($plan == "") || ($transid == "")) {
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

function checkaction($action) {
//    if (ctype_alnum($action)) {
    if ($action == 'SUBSCRIBE') {
        return $action;
    }
}

function checkpid($pid) {
    if ((strlen($pid) <= 30) && (ctype_alnum(str_replace('_', '', $pid)))) {
        // if ((strlen($pid) <= 30) && (preg_match('/^[a-zA-Z0-9_]+$/', $pid) == 1)) {
        return $pid;
    }
}

function checkplan($plan) {
    if ((strlen($plan) <= 30) && (ctype_alnum(str_replace('_', '', $plan)))) {
        return $plan;
    }
}

function checktransid($transid) {
    if ((strlen($transid) <= 35) && is_numeric($transid)) {
        // if ((strlen($pid) <= 30) && (preg_match('/^[a-zA-Z0-9_]+$/', $pid) == 1)) {
        return $transid;
    }
}

$msisdn = checkmsisdn($msisdn);
$pid = checkpid($pid);
$action = checkaction($action);
$plan = checkplan($plan);
$transid = checktransid($transid);


if (($msisdn == "") || ($pid == "") || ($action == "") || ($plan == "") || ($transid == "")) {
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
            $sc = '5500196';
            $s_id = '1513';
            $db = "airtel_mnd";
            $subscriptionTable = "tbl_character_subscription1";
            $subscriptionProcedure = "MND_SUBBULK";
            $unSubscriptionProcedure = "MND_UNSUB";
            $unSubscriptionTable = "tbl_character_unsub1";
            $lang = '01';
            break;
        case '1515':
            $sc = '51050';
            $s_id = '1515';
            $db = "airtel_devo";
            $subscriptionTable = "tbl_devo_subscription";
            $subscriptionProcedure = "DEVO_SUBBULK";
            $unSubscriptionProcedure = "devo_unsub";
            $unSubscriptionTable = "tbl_devo_unsub";
            $lang = '01';
            break;
        case '1517':
            $sc = '571811';
            $s_id = '1517';
            $db = "airtel_SPKENG";
            $subscriptionTable = "tbl_spkeng_subscription";
            $subscriptionProcedure = "JBOX_SUB_BULK";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_spkeng_unsub";
            $lang = '01';
            break;
    }

    $langValue = $langArray[strtoupper($lang)];
    if (!$langValue)
        $langValue = "01";

    $amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id='$plan' and S_id=$pid";

    $amt = mysql_query($amtquery);
    List($row1) = mysql_fetch_row($amt);
    $amount = $row1;

    $sub = "select count(*) from " . $db . "." . $subscriptionTable . " where ANI='$msisdn'";
    $qry1 = mysql_query($sub);
    $rows1 = mysql_fetch_row($qry1);

    if ($rows1[0] <= 0) {

        $insertQry = "INSERT INTO master_db.tbl_ussd_logs (msisdn,action,pid,plan,transid,response_id,datetime) 
                      VALUES ('" . $msisdn . "','" . $action . "', '" . $pid . "', '" . $plan . "', '" . $transid . "', '" . $response_id . "',now())";
        mysql_query($insertQry);

        $qry = "call " . $db . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $plan . ",'0')";

        $qry1 = mysql_query($qry) or die(mysql_error());

        $query2 = "select count(*) from " . $db . "." . $subscriptionTable . " where ANI='$msisdn'";
        $qry2 = mysql_query($query2);
        $result2 = mysql_fetch_row($qry2);
        if ($result2[0] >= 1)
            $result = 0;
        else
            $result = 102;
    }
    else
        $result = 103;

    if ($result == 0) {
        echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
        echo "<XML>\n";
        echo "<STATUS>SUCCESS</STATUS>\n";
        echo "<TID></TID>\n";
        echo "</XML>\n";
        exit;
    } elseif ($result == 102) {
        echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
        echo "<XML>\n";
        echo "<ERROR>Some Techincal Issue</ERROR>\n";
        echo "<STATUS>$result</STATUS>\n";
        echo "</XML>\n";
        exit;
    } else {
        echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
        echo "<XML>\n";
        echo "<ERROR>Already Subscribed</ERROR>\n";
        echo "<STATUS>$result</STATUS>\n";
        echo "</XML>\n";
        exit;
    }
}
?>   