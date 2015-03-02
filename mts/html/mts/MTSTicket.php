<?php

error_reporting(1);

///////////////////////////////////////////////// DB connection code start here @jyoti.porwal ////////////////////////////////////////////////////////
$con = mysql_pconnect("database.master_mts", "billing", "billing");
if (!$con) {
    die('could not connect1: ' . mysql_error());
}
/////////////////////////////////////////////////// DB connection code end here @jyoti.porwal ////////////////////////////////////////////////////////
/////////////////////////////////////// Getting parameter value code start here @jyoti.porwal ////////////////////////////////////////////////////////
$rcode = $_REQUEST['rcode'];
$msisdn = $_GET['msisdn'];
$planid = $_GET['planid'];
$mode = $_REQUEST['mode'];
$reqtype = $_REQUEST['reqtype'];
$seviceId = $_REQUEST['serviceid'];
/////////////////////////////////////// Getting parameter value code end here @jyoti.porwal ////////////////////////////////////////////////////////
$StartTime = date("H:i:s");

$remoteAdd = trim($_SERVER['REMOTE_ADDR']);

$log_file_path = "logs/MTS/Ticket/1102/ticket" . $curdate . ".txt";
$file = fopen($log_file_path, "a+");
if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE,FAILURE";
}
$abc = explode(',', $rcode);
/////////////////////////////////////// Check Plan id value code start here @jyoti.porwal ////////////////////////////////////////////////////////
if (!is_numeric("$planid")) {
    echo $abc[1];
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $seviceId . "#" . $lang . "#" . $dnis . "#" . "#" . date('H:i:s') . $abc[1] . "#" . $remoteAdd . "\r\n");
    exit;
}

/////////////////////////////////////// check Plan id value code start end @jyoti.porwal ////////////////////////////////////////////////////////
/////////////////////////////////////// Check msisdn value code start here @jyoti.porwal ////////////////////////////////////////////////////////
function checkmsisdn($msisdn, $abc, $seviceId) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                echo $abc[1];
                $rcode = $abc[1];
                if ($reqtype == 1) {
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $seviceId . "#" . $lang . "#" . $dnis . "#" . "#" . date('H:i:s') . $abc[1] . "#" . $remoteAdd . "\r\n");
                    fclose($file);
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        if ($reqtype == 1) {
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $seviceId . "#" . $lang . "#" . $dnis . "#" . "#" . date('H:i:s') . $abc[1] . "#" . $remoteAdd . "\r\n");
            fclose($file);
        }
        exit;
    }
    return $msisdn;
}

/////////////////////////////////////// Check msisdn value code end here @jyoti.porwal ////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////// ticket code start here @jyoti.porwal ////////////////////////////////////////////////////////
$msisdn = checkmsisdn(trim($msisdn), $abc, $seviceId);
if (($msisdn == "") || ($mode == "") || ($reqtype == "") || ($planid == "") || ($seviceId == "")) {
    echo "Please provide the complete parameter";
} else {
    switch ($seviceId) {
        case '1102':
            $sc = '54646';
            $s_id = '1102';
            $DB = 'Hungama_RaginiMMS';
            $ticketTable = "tbl_celebchat_subscription";
            $ticketProcedure = "CHAT_SUB_BULK";
            $lang = '01';
            break;
        default:
            echo "Invalid Service name";
            exit;
            break;
    }
    if (!is_numeric($_REQUEST['lang'])) {
        $lang = $_REQUEST['lang'];
        $langValue = $langArray[strtoupper($lang)];
    } elseif (is_numeric($_REQUEST['lang'])) {
        $langValue = $_REQUEST['lang'];
    } else {
        $langValue = "01";
    }
    if (!$langValue)
        $langValue = "01";

    if ($reqtype == 1) {
        if (!$amount) {
            $amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
            $amt = mysql_query($amtquery);
            List($row1) = mysql_fetch_row($amt);
            $amount = $row1;
        }

        if ($amount == '') {
            echo "Plan Id is Wrong";
            exit;
        }
        mysql_select_db($DB, $con);

        $qry = "call " . $DB . "." . $ticketProcedure . " ('$msisdn','$langValue','$mode','$sc','$amount',$seviceId,$planid,'MTSM','0')";
        $qry1 = mysql_query($qry) or die(mysql_error());

        $query3 = "select ani,chrg_amount,sub_date,renew_date from " . $DB . "." . $ticketTable . " where ANI='$msisdn'";

        $qry3 = mysql_query($query3);
        $result3 = mysql_fetch_row($qry3);
        if ($result3[0] >= 1)
            $result = 4;
        else
            $result = 1;

        if ($result == 0) {
            echo $rcode = $abc[0];
        } elseif (($result == 1 || $result == 4)) {
            if ($result == 1)
                echo $rcode = $abc[1];
            elseif ($result == 4)
                echo $rcode = $abc[0];
        }
        elseif ($result == 2) {
            echo $rcode = $abc[2];
        }

        fwrite($file, $msisdn . "#" . $StartTime . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $qry . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "\r\n");
    }
}
//////////////////////////////////////////////////////////// Ticket code end here @jyoti.porwal ////////////////////////////////////////////////////////
?>