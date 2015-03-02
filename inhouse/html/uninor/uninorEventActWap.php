<?php
error_reporting(0);
$msisdn = $_REQUEST['msisdn'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
$mode = $_REQUEST['mode'];
$ringid = $_REQUEST['rngid'];
$reqtype = $_REQUEST['reqtype'];
$planid = $_REQUEST['planid'];
$servicename = trim($_REQUEST['servicename']);
$rcode = $_REQUEST['rcode'];
$curdate = date("Y-m-d");
//added for dynamic planid-amount format
$con = mysql_connect("database.master", "weburl", "weburl");
if (!$con) {
    die('could not connect1: ' . mysql_error());
}
$planid = trim($_REQUEST['planid']);
$planData = explode("-", $planid);
if (count($planData) == 2) {
    $planid = $planData[0];
    $getAmount = $planData[1];
}
if (!$getAmount) {
    $amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'");
    List($getAmount) = mysql_fetch_row($amt);
}
mysql_close($con);
//end here

if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE1,Already Subscribed";
}
$abc = explode(',', $rcode);


if (!is_numeric("$planid")) {
    echo $abc[1];
    $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
    $file = fopen($log_file_path, "a");
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "\r\n");
    fclose($file);
    exit;
}

function checkmsisdn($msisdn, $abc) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                echo $abc[1];
                $rcode = $abc[1];
                if ($reqtype == 1) {
                    $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n");
                    fclose($file);
                }
                if ($reqtype == 2) {
                    $log_file_path = "logs/uninor/unsubscription/" . $servicename . "/unsubscriptionWap_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n");
                    fclose($file);
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        if ($reqtype == 1) {
            $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n");
            fclose($file);
        }
        if ($reqtype == 2) {
            $log_file_path = "logs/uninor/unsubscription/" . $servicename . "/unsubscriptionWap__" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n");
            fclose($file);
        }
        exit;
    }
    return $msisdn;
}

$msisdn = checkmsisdn(trim($msisdn), $abc);
if (($msisdn == "") || ($mode == "") || ($reqtype == "") || ($planid == "")) {
    echo "Please provide the complete parameter";
} else {
    switch ($servicename) {
        case 'uninor_54646':
            $sc = '54646';
            $s_id = '1402';
            $dbname = "uninor_hungama";
            $subscriptionTable = "tbl_jbox_subscription";
            $subscriptionProcedure = "UNIM54646_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_jbox_unsub";
			$subredirectUrl="http://202.87.41.147/hungamawap/uninor/183917/index.php3";
			$alsubredirectUrl="http://202.87.41.147/hungamawap/uninor/183916/index.php3";
            $lang = '01';
        break;
        case 'uninor_RED':
            $sc = '55935';
            $s_id = '1410';
            $dbname = "uninor_redfm";
            $subscriptionTable = "tbl_jbox_subscription";
            $subscriptionProcedure = "REDFM_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
        case 'uninor_RIYA':
            $sc = '5646428';
            $s_id = '1409';
            $dbname = "uninor_manchala";
            $subscriptionTable = "tbl_riya_subscription";
            $subscriptionProcedure = "RIYA_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "RIYA_UNSUB";
            $unSubscriptionTable = "tbl_riya_unsub";
            $lang = '01';
			$subredirectUrl="http://202.87.41.147/hungamawap/uninor/183071/index2.php3";
			$alsubredirectUrl="http://202.87.41.147/hungamawap/uninor/183067/index2.php3";
            break;
        case 'uninor_sportsUnlimited':
            $sc = '52255';
            $s_id = '1408';
            $dbname = "uninor_cricket";
            $subscriptionTable = "tbl_cricket_subscription";
            $subscriptionProcedure = "SU_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "cricket_UNSUB";
            $unSubscriptionTable = "tbl_cricket_unsub";
            $lang = '01';
			$subredirectUrl="http://202.87.41.147/hungamawap/uninor/166786/index2.php3";
			$alsubredirectUrl="http://202.87.41.147/hungamawap/uninor/166789/index2.php3";
            break;
        case 'uninor_jokes':
            $sc = '5464622';
            $s_id = '1418';
            $dbname = "uninor_hungama";
            $subscriptionTable = "tbl_comedy_subscription";
            $subscriptionProcedure = "MPMC_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "COMEDY_UNSUB";
            $unSubscriptionTable = "tbl_comedy_unsub";
            $lang = '01';
            break;
	case 'uninor_jyotish':
            $sc = '52444';
            $s_id = '1416';
            $dbname = "uninor_jyotish";
            $subscriptionTable = "tbl_jyotish_subscription";
            $subscriptionProcedure = "JYOTISH_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "Jyotish_UNSUB";
            $unSubscriptionTable = "tbl_Jyotish_unsub";
            $lang = '01';
            break;
        case 'uninor_rt':
            $sc = '52888';
            $s_id = '1412';
            $dbname = "uninor_myringtone";
            $subscriptionTable = "tbl_jyotish_subscription";
            $subscriptionProcedure = "ringtone_bulk_push";
            $unSubscriptionProcedure = "Jyotish_UNSUB";
            $unSubscriptionTable = "tbl_Jyotish_unsub";
            $lang = '01';
            break;
        default:
            echo "Invalid service.";
            exit;
    }

    $con = mysql_connect("database.master", "weburl", "weburl");
    if (!$con) {
        die('could not connect1: ' . mysql_error());
    }

    if (strlen($_REQUEST['lang']) <= 3 && $_REQUEST['lang'])
        $lang = $_REQUEST['lang'];

    if ($reqtype == 3) {
        $amount = $getAmount;
        mysql_select_db($dbname, $con);
        $sub = "select count(*) from " . $dbname . "." . $subscriptionTable . " where ANI='$msisdn'";
        $qry1 = mysql_query($sub);
        $rows1 = mysql_fetch_row($qry1);
        if ($rows1[0] <= 0) {
            if($servicename=='uninor_rt')
                $call = "call " . $dbname . "." . $subscriptionProcedure . "($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid,'$ringid',0)";
            else
                $call = "call " . $dbname . "." . $subscriptionProcedure . "($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid,0)";
            
            $qry1 = mysql_query($call) or die(mysql_error());
            $select = "select count(*) from " . $dbname . "." . $subscriptionTable . " where ANI='$msisdn'";
            $qry2 = mysql_query($select);
            $row1 = mysql_num_rows($qry2);
            if ($row1 >= 1) {
                $result = 0;
            } else {
                //$result=1;
                $result = 0;
            }
        } else {
            $result = 2;
        }
        if ($result == 0) {
            $rcode = $abc[0];
            $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $call . "\r\n");
            fclose($file);
            mysql_close($con);
			header("location:".$subredirectUrl);
            exit;
        }
        if ($result == 1) {
            echo $rcode = $abc[1];
            $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $call . "\r\n");
            fclose($file);
            mysql_close($con);
            exit;
        }
        if ($result == 2) {
            echo $rcode = $abc[2];
            $log_file_path = "logs/uninor/subscription/" . $servicename . "/subscriptionWap_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $lang . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $call . "\r\n");
            fclose($file);
            mysql_close($con);
			header("location:".$alsubredirectUrl);
            exit;
        }
    }
}
?>   