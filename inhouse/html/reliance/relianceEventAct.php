<?php
error_reporting(0);
$msisdn = $_REQUEST['msisdn'];
$mode = $_REQUEST['mode'];
$reqtype = $_REQUEST['reqtype'];
$planid = $_REQUEST['planid'];
$seviceId = $_REQUEST['serviceid'];
$amount = $_REQUEST['amt'];
$curdate = date("Y-m-d");
if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE,ALREADY SUBSCRIBED";
}
$abc = explode(',', $rcode);
if (!is_numeric("$planid")) {
    echo $abc[1];
    $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
    $file = fopen($log_file_path, "a");
    chmod($log_file_path, 0777);
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
    fclose($file);
    exit;
}

function checkmsisdn($msisdn, $abc, $seviceId) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                echo $abc[1];
                $rcode = $abc[1];
                if ($reqtype == 1) {
                    $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    chmod($log_file_path, 0777);
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
                    fclose($file);
                }
                if ($reqtype == 2) {
                    $log_file_path = "logs/reliance/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    chmod($log_file_path, 0777);
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
                    fclose($file);
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        if ($reqtype == 1) {
            $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            chmod($log_file_path, 0777);
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
            fclose($file);
        }
        exit;
    } elseif (!is_numeric($msisdn)) {
        echo $abc[1];
        $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
        $file = fopen($log_file_path, "a");
        chmod($log_file_path, 0777);
        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
        fclose($file);
        exit;
    }

    return $msisdn;
}

$msisdn = checkmsisdn(trim($msisdn), $abc, $seviceId);

if (($msisdn == "") || ($mode == "") || ($reqtype == "") || ($planid == "")) {
    echo "Please provide the complete parameter";
} else {
    $con = mysql_connect("database.master", "weburl", "weburl");
    if (!$con) {
        die('we are facing some temporarily problem please try later');
    }
    switch ($seviceId) {
        case '1202':
            $s_id = '1202';
            $subscriptionTable = "reliance_hungama.tbl_jbox_subscription";
            $subscriptionProcedure = "reliance_hungama.JBOX_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "reliance_hungama.JBOX_UNSUB";
            $unSubscriptionTable = "reliance_hungama.tbl_jbox_unsub";
	     $sc = '54646';
	    $lang = '01';
            break;
        case '1208':
            $sc = '54433';
            $s_id = '1208';
            $subscriptionTable = "reliance_cricket.tbl_cricket_subscription";
            $subscriptionProcedure = "reliance_cricket.JBOX_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "reliance_cricket.CRICKET_UNSUB";
            $unSubscriptionTable = "reliance_cricket.tbl_cricket_unsub";
            $lang = '01';
            break;
        default :
            echo "Product not configure";
            break;
    }
    $langValue = "01";
    if ($reqtype == 3) {

        if(!$amount)
		{
			$amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
			$amt = mysql_query($amtquery);
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
		}

		$sub = "select count(*) from " . $subscriptionTable . " where ANI='$msisdn'";
		$qry1 = mysql_query($sub);
        $rows1 = mysql_fetch_row($qry1);
        if ($rows1[0] <= 0) {
            $qry = "call " . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $planid . ",'0')";
            $qry1 = mysql_query($qry);
            $query2 = "select count(*) from " . $subscriptionTable . " where ANI='$msisdn'";
            $qry2 = mysql_query($query2);
            $result2 = mysql_fetch_row($qry2);
            if ($result2[0] >= 1)
                $result = 0;
            else
                $result = 1;
        }
        else
            $result = 2;
        if ($result == 0) {
            echo $rcode = $abc[0];
            $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            chmod($log_file_path, 0777);
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . $aftId . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
            fclose($file);
            mysql_close($con);
            exit;
        }

        if ($result == 1) {
            echo $rcode = $abc[1];
            $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            chmod($log_file_path, 0777);
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . $aftId . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
            fclose($file);
            mysql_close($con);
            exit;
        }
        if ($result == 2) {
            if ($_REQUEST['lang']) {
                $updateLang = "UPDATE " . $subscriptionTable . " SET def_lang='" . $langValue . "' WHERE ANI='" . $msisdn . "'";
                mysql_query($updateLang);
            }

            echo $rcode = $abc[2];
            $log_file_path = "logs/reliance/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            chmod($log_file_path, 0777);
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#L:" . $langValue . "#LC:" . $lang . "#" . $aftId . "#" . date('H:i:s') . "#" . $rcode . "\r\n");
            fclose($file);
            mysql_close($con);
            exit;
        }
    }
}
?>   