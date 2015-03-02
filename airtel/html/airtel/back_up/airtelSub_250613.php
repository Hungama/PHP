<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$msisdn = trim($_REQUEST['msisdn']);
$requestId = trim($_REQUEST['requestid']);
$serviceName = trim($_REQUEST['code']);
$freetext = trim($_REQUEST['freetext']);
$zoneName = trim($_REQUEST['zonename']);
$requestTime = trim($_REQUEST['requesttime']);
$batchId = $_REQUEST['batchid'];
if (!$requestTime) {
    $requestTime = date("Y-m-d H:i:s");
}

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

switch (strtolower($serviceName)) {
    case '54646': $sid = "1502";
        $sc = "546461";
        $planId = 26;
        $db = "airtel_hungama";
        $subscriptionTable = "tbl_jbox_subscription";
        $subscriptionProcedure = "JBOX_SUB";
        $unSubscriptionProcedure = "JBOX_UNSUB";
        $unSubscriptionTable = "tbl_jbox_unsub";
        $lang = '01';
        break;
    case 'mtv': $sid = "1503";
        $planId = 27;
        $sc = '546461';
        $db = "airtel_hungama";
        $subscriptionTable = "tbl_mtv_subscription";
        $subscriptionProcedure = "MTV_SUB";
        $unSubscriptionProcedure = "MTV_UNSUB";
        $unSubscriptionTable = "tbl_mtv_unsub";
        $lang = '01';
        break;
    case 'vh1': $sid = "1507";
        $sc = '55841';
        $planId = 28;
        $db = "airtel_vh1";
        $subscriptionTable = "tbl_jbox_subscription";
        $subscriptionProcedure = "JBOX_SUB";
        $unSubscriptionProcedure = "JBOX_UNSUB";
        $unSubscriptionTable = "tbl_jbox_unsub";
        $lang = '01';
        break;
    case 'riya': $sid = "1511";
        $planId = 30;
        $sc = '5500169';
        $db = "airtel_manchala";
        $subscriptionTable = "tbl_riya_subscription";
        $subscriptionProcedure = "RIYA_SUB";
        $unSubscriptionProcedure = "RIYA_UNSUB";
        $unSubscriptionTable = "tbl_riya_unsub";
        break;
    case 'goodlife': $sid = "1511";
        $planId = 29;
        $sc = '55001';
        $db = "airtel_rasoi";
        $subscriptionTable = "tbl_rasoi_subscription";
        $subscriptionProcedure = "RASOI_SUB";
        $unSubscriptionProcedure = "RASOI_UNSUB";
        $unSubscriptionTable = "tbl_rasoi_unsub";
        break;
    case 'mnd': $sid = "1513";
        $planId = 51;
        $sc = '5500196';
        $db = "airtel_mnd";
        $subscriptionTable = "tbl_character_subscription1";
        $subscriptionProcedure = "MND_SUB";
        $unSubscriptionProcedure = "MND_UNSUB";
        $unSubscriptionTable = "tbl_character_unsub1";
        $lang = '01';
        break;
    case 'pd': $sid = "1514";
        $planId = 40;
        $sc = '53222345';
        $db = "airtel_EDU";
        $subscriptionTable = "tbl_jbox_subscription";
        $subscriptionProcedure = "JBOX_SUB";
        $unSubscriptionProcedure = "JBOX_UNSUB";
        $unSubscriptionTable = "tbl_jbox_unsub";
        $lang = '01';
        break;
    case 'devo': $sid = "1515";
        $planId = 45;
        $sc = '5464611';
        $db = "airtel_devo";
        $subscriptionTable = "tbl_devo_subscription";
        $subscriptionProcedure = "DEVO_SUB";
        $unSubscriptionProcedure = "devo_unsub";
        $unSubscriptionTable = "tbl_devo_unsub";
        $lang = '01';
        break;
    case 'cmd': $sid = "1518";
        $planId = 50;
        $sc = '5464612';
        $db = "airtel_hungama";
        $subscriptionTable = "tbl_comedyportal_subscription";
        $subscriptionProcedure = "COMEDY_SUB";
        $unSubscriptionProcedure = "COMEDY_UNSUB";
        $unSubscriptionTable = "tbl_comedyportal_unsub";
        $lang = '01';
        break;
    case 'se': $sid = "1517";
        $planId = 57;
        $sc = '5464612';
        $db = "airtel_SPKENG";
        $subscriptionTable = "tbl_spkeng_subscription";
        $subscriptionProcedure = "JBOX_SUB";
        $unSubscriptionProcedure = "JBOX_UNSUB";
        $unSubscriptionTable = "tbl_spkeng_unsub";
        $lang = '01';
        break;
    case 'eu30':
        $sid = "1501";
        $planId = 24;
        $sc = '546469';
        $db = "airtel_radio";
        $subscriptionTable = "tbl_radio_subscription";
		if($batchId) $subscriptionProcedure="RADIO_SUBBULK";
			else $subscriptionProcedure="RADIO_SUB";
        //$subscriptionProcedure = "RADIO_SUBBULK";
        $unSubscriptionProcedure = "RADIO_UNSUB";
        $unSubscriptionTable = "tbl_radio_unsub";
        $lang = '01';
        break;
    case 'eu2':
        $sid = "1501";
        $planId = 20;
        $sc = '546469';
        $db = "airtel_radio";
        $subscriptionTable = "tbl_radio_subscription";
       if($batchId) $subscriptionProcedure="RADIO_SUBBULK";
			else $subscriptionProcedure="RADIO_SUB";
	   // $subscriptionProcedure = "RADIO_SUBBULK";
        $unSubscriptionProcedure = "RADIO_UNSUB";
        $unSubscriptionTable = "tbl_radio_unsub";
        $lang = '01';
        break;
}

$mode = "AIRTEL_NOW";

$logPath = "/var/www/html/airtel/logs/airtelSub/" . $sid . "/sublog_" . date("Y-m-d") . ".txt";

if (checkmsisdn($msisdn) && $serviceName) {
    $msisdn = checkmsisdn($msisdn);
    $amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id=" . $planId . " and S_id=" . $sid;
    $amt = mysql_query($amtquery);
    List($amount) = mysql_fetch_row($amt);

    $sub = "select count(*) from " . $db . "." . $subscriptionTable . " where ANI='" . $msisdn . "'";
    $qry1 = mysql_query($sub);
    $rows1 = mysql_fetch_row($qry1);

    if ($rows1[0] <= 0) {
        $qry = "CALL " . $db . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $lang . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $sid . "," . $planId . ")";
        $qry1 = mysql_query($qry) or mysql_error();
        $query2 = "select count(*) from " . $db . "." . $subscriptionTable . " where ANI='$msisdn'";
        $qry2 = mysql_query($query2);
        $result2 = mysql_fetch_row($qry2);

        sleep(10);
        if ($result2 >= 1) {
            $newQuery = $query2 . " and status=1";
            $resultData = mysql_query($newQuery);
            list($status) = mysql_fetch_row($resultData);
            $response = 0;
            if ($status >= 1) {
                $response1 = "Successfully Subscribed";
            } else {
                $response1 = "Billing Pending";
            }

            $logData = $msisdn . "#" . $requestId . "#" . $serviceName . "#" . $freetext . "#" . $zoneName . "#" . $requestTime . "#" . $qry . "#" . $response . ":" . $response1 . "#" . date("Y-m-d H:i:s") . "\n";
        } else {
            $response = 1;

            $failQuery = "SELECT count(*) FROM master_db.tbl_billing_failure nolock WHERE msisdn='" . $msisdn . "' and date(date_time)='" . date("Y-m-d") . "'";
            $resultData1 = mysql_query($failQuery);
            list($failStatus) = mysql_fetch_row($resultData1);

            if ($failStatus >= 0) {
                $response1 = "Billing Fail";
            } else {
                $response1 = "Do not send any response to the user";
            }
            $logData = $msisdn . "#" . $requestId . "#" . $serviceName . "#" . $freetext . "#" . $zoneName . "#" . $requestTime . "#" . $qry . "#" . $response . ": " . $response1 . "#" . date("Y-m-d H:i:s") . "\n";
        }
    } else {
        $response = 2;
        $response1 = "MSISDN is Already Subscribed";
        $logData = $msisdn . "#" . $requestId . "#" . $serviceName . "#" . $freetext . "#" . $zoneName . "#" . $requestTime . "#" . $response . ": " . $response1 . "#" . date("Y-m-d H:i:s") . "\n";
    }
    $appId = "";
    error_log($logData, 3, $logPath);

    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    //echo "<ROOT>\n";
    echo "<TUNNELING>\n";
    echo "<STATUS>" . $response . "</STATUS>\n";
    echo "<MSISDN>" . $msisdn . "</MSISDN>\n";
    echo "<LARGEACOUNT>58236</LARGEACOUNT>\n";
    echo "<APPLICATIONID>" . $sid . "</APPLICATIONID>\n";
    echo "<REQUESTID>" . $requestId . "</REQUESTID>\n";
    echo "<MESSAGE>\n";
    echo "<CONTENT>" . $response1 . "</CONTENT>\n";
    echo "<MENU>\n";
    echo "<ITEM>\n";
    echo "<INDEX></INDEX>\n";
    echo "<TEXT></TEXT>\n";
    echo "<ADDRESS></ADDRESS>\n";
    echo "<CODE></CODE>\n";
    echo "</ITEM>\n";
    echo "</MENU>\n";
    echo "</MESSAGE>\n";
    echo "</TUNNELING>\n";
    //echo "</ROOT>\n"; 
} else {
    echo "Invalid Parameter";
}

mysql_close($dbAirtelConn);
?>