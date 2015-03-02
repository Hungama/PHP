<?php
error_reporting(1);
$logdate = date("Y-m-d");
$logPath_process = "/var/www/html/MTS/logs/processlogs/" . $logdate . "_log.txt";
$logPath_Combo = "/var/www/html/MTS/logs/combopack/" . $logdate . "_log.txt";
$logString_process = "DB Connection Start-" . date('d-m-Y h:i:s') . "\r\n";
error_log($logString_process, 3, $logPath_process);
$con = mysql_pconnect("database.master_mts", "billing", "billing");
if (!$con) {
    die('could not connect1: ' . mysql_error());
}
$logString_process = "DB Connection completed-" . date('d-m-Y h:i:s') . "\r\n";
error_log($logString_process, 3, $logPath_process);

$msisdn = $_GET['msisdn'];
$mode = $_REQUEST['mode'];
if (strtoupper($_REQUEST['mode']) == 'SCIVR')
    $mode = "IVR";
elseif (strtoupper($_REQUEST['mode']) == 'SCWEB')
    $mode = "WEB";

$reqtype = $_REQUEST['reqtype'];
$planid = $_REQUEST['planid'];
$subchannel = $_REQUEST['subchannel'];
if (strtoupper($_REQUEST['subchannel']) == 'SCIVR')
    $subchannel = "IVR";
elseif (strtoupper($_REQUEST['subchannel']) == 'SCWEB')
    $subchannel = "WEB";

$isnotcombo=true;
$rcode = $_REQUEST['rcode'];
$seviceId = $_REQUEST['serviceid'];
$ac = $_REQUEST['ac'];
$param = $_REQUEST['param'];
$test = $_REQUEST['test'];
//disable online request parameter as per discussion with vivek P & vikrant garg on 25 jan14 
if ($mode == '197_OBD' || $mode == 'TZ_OBD')
    $online = $_REQUEST['online'];
else
    $online = '';
//VG_OBD >> No online response
$catId1 = $_REQUEST['cat1'];
$catId2 = $_REQUEST['cat2'];
$lang1 = $_REQUEST['lang'];
$batchId = $_REQUEST['batchid'];

$curdate = date("Y-m-d");
$StartTime = date("H:i:s");
$UCT = $_REQUEST['UCT'];

$ccgid = $_REQUEST['CCGID'];
if ($ccgid == '')
    $ccgid = 0;

if (!isset($ccgid)) {
    $ccgid = 0;
}

$transid = $_REQUEST['TCID'];
if (!isset($transid)) {
    $transid = 0;
}
//for voicegate trx_id
$transid_new = $_REQUEST['trx_id'];
if (isset($transid_new)) {
    $transid = $transid_new;
}
if (!isset($transid)) {
    $transid = 0;
}

if ($catId1 || $catId2) {
    if (!$catId1)
        $catId1 = "NA";
    if (!$catId2)
        $catId2 = "NA";
}

$remoteAdd = trim($_SERVER['REMOTE_ADDR']);

$langArray = array('TEL' => '08', 'HIN' => '01', 'TAM' => '07', 'KAN' => '10', 'ENG' => '02', 'MAI' => '21', 'MAL' => '09', 'NEP' => '19', 'ASS' => '17', 'GUJ' => '12', 'RAJ' => '18', 'BHO' => '04', 'PUN' => '03', 'ORI' => '13', 'MAR' => '11', 'CHH' => '16', 'HAR' => '05', 'BEN' => '06', 'HIM' => '15', 'KAS' => '14', 'KUM' => '20');

function getReligion($religion) {
    $query = mysql_query("SELECT religion FROM dm_radio.tbl_religion_detail nolock WHERE religion like '%" . $religion . "%'");
    list($religionValue) = mysql_fetch_array($query);
    return $religionValue;
}

// here UCT will be crbt_id
if ($seviceId == '11011') {
    $log_file_path = "logs/MTS/subscription/1101/subscription_" . $curdate . ".txt";
} else {
    $log_file_path = "logs/MTS/subscription/" . $seviceId . "/subscription_" . $curdate . ".txt";
}


$file = fopen($log_file_path, "a+");

if (!isset($rcode)) {
    $rcode = "SUCCESS,FAILURE,FAILURE";
}
$abc = explode(',', $rcode);

if (!is_numeric("$planid")) {
    echo $abc[1];
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
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
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
                    fclose($file);
                }
                if ($reqtype == 2) {
                    $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
                    fclose($file);
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        if ($reqtype == 1) {
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
            fclose($file);
        }
        if ($reqtype == 2) {
            $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
            $file = fopen($log_file_path, "a");
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
            fclose($file);
        }
        exit;
    }
    return $msisdn;
}

$msisdn = checkmsisdn(trim($msisdn), $abc, $seviceId);

//check for CCGID if CCIG not found then do nothing only save logs in case of activation request
if ($reqtype == 1 && $ccgid == 0) {
//log landing request for each request start here 
    $logDir = "/var/www/html/MTS/logs/MTS/noccg/";
    $logFile_dump = "ccgdump_" . date('Ymd');
    $logPath = $logDir . $logFile_dump . ".txt";
    $filePointer1 = fopen($logPath, 'a+');
    chmod($logPath, 0777);
    $arrCnt = sizeof($_REQUEST);
    for ($i = 0; $i < $arrCnt; $i++) {
        $keys = array_keys($_REQUEST);
    }
    for ($k = 0; $k < $arrCnt; $k++) {
        fwrite($filePointer1, $keys[$k] . '=>' . $_REQUEST[$keys[$k]] . "|");
    }
    fwrite($filePointer1, date('H:i:s') . '|' . $remoteAdd . "\n");
//end here
    mysql_close($con);
    $logString_process = "Request Terminated without CCG ID -" . $msisdn . "#" . date('d-m-Y h:i:s') . "\r\n";
    error_log($logString_process, 3, $logPath_process);
    exit;
}





if (($msisdn == "") || ($mode == "") || ($reqtype == "") || ($planid == "")) {
    echo "Please provide the complete parameter";
    $logString_process = "Please provide the complete parameter -Subscription process end here-" . date('d-m-Y h:i:s') . "\r\n";
    error_log($logString_process, 3, $logPath_process);
    mysql_close($con);
} else {
    switch ($seviceId) {
        case '1101':
        case '11011':
            if ($seviceId == '1101')
                $sc = '52222';
            elseif ($seviceId == '11011')
                $sc = '5222212';
            $seviceId = '1101';
            $s_id = '1101';
            
			/*
			$DB = 'mts_radio';
            $subscriptionTable = "tbl_radio_subscription";

            if ($batchId)
                $subscriptionProcedure = "RADIO_SUB_BULK";
            else
                $subscriptionProcedure = "RADIO_SUB";

            $unSubscriptionProcedure = "RADIO_UNSUB";
            $unSubscriptionTable = "tbl_radio_unsub";
			*/
			$DB = 'mts_mu';
            $subscriptionTable = "tbl_HB_subscription";

            if ($batchId)
                $subscriptionProcedure = "HB_SUB_BULK";
            else
                $subscriptionProcedure = "HB_SUB";

            $unSubscriptionProcedure = "HB_UNSUB";
            $unSubscriptionTable = "tbl_HB_unsub";
            $lang = '1';
            break;
        case '1111':
            $sc = '5432105';
            $s_id = '1111';
            $DB = 'dm_radio';
            $subscriptionTable = "tbl_digi_subscription";

            if ($batchId)
                $subscriptionProcedure = "DIGI_SUB_BULK";
            else
                $subscriptionProcedure = "DIGI_SUB";

            $unSubscriptionProcedure = "DIGI_UNSUB";
            $unSubscriptionTable = "tbl_digi_unsub";
            $DIGI_RELIGION_SELECTION = "DIGI_RELIGION_SELECTION";

            $lang = '01';
            break;
        case '1110':
            $sc = '55935';
            $s_id = '1110';
            $DB = 'mts_redfm';
            $subscriptionTable = "tbl_jbox_subscription";

            if ($batchId)
                $subscriptionProcedure = "JBOX_SUB_BULK";
            else
                $subscriptionProcedure = "JBOX_SUB";

            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
         case '1123':
            $sc = '55333';
            $s_id = '1123';
            $DB = 'Mts_summer_contest';
            $subscriptionTable = "tbl_contest_subscription";
            $subscriptionProcedure = "CONTEST_SUB";
            $unSubscriptionProcedure = "CONTEST_UNSUB";
            $unSubscriptionTable = "tbl_contest_unsub";
            $lang = '01';
            break;
		case '1108':
            $sc = '52444';
            $s_id = '1108';
            $DB = 'MTS_cricket';
            $subscriptionTable = "tbl_cricket_subscription";
            $subscriptionProcedure = "CRICKET_SUB";
            $unSubscriptionProcedure = "CRICKET_UNSUB";
            $unSubscriptionTable = "tbl_cricket_unsub";
            $lang = '01';
        break;

        default:
            echo "Invalid Service name";
            exit;
            break;
    }
   
    $logString_process = "Subscription process start here for -" . $msisdn . "#" . date('d-m-Y h:i:s') . "\r\n";
    error_log($logString_process, 3, $logPath_process);

    $logString_process = $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $remoteAdd . "#" . $transid . "#" . $ccgid . "#" . $_REQUEST['rel'] . "#" . $lang . "#" . date('d-m-Y h:i:s') . "\r\n";
    error_log($logString_process, 3, $logPath_process);

    if (!is_numeric($_REQUEST['lang'])) {
        $lang = $_REQUEST['lang'];
        $langValue = $langArray[strtoupper($lang)];
    } elseif (is_numeric($_REQUEST['lang'])) {
        $langValue = $_REQUEST['lang'];
    } else {
        $langValue = "1";
    }
    if (!$langValue)
        $langValue = "1";

    if ($_REQUEST['test'])
        echo $langValue;

    if ($reqtype == 1) {
        $amtquery = "select iAmount from master_db.tbl_plan_bank nolock where Plan_id='$planid' and S_id=$seviceId";
        $amt = mysql_query($amtquery);
        List($row1) = mysql_fetch_row($amt);
        $amount = $row1;

        if ($_GET['amt'])
            $amount = $_GET['amt'];

        if ($amount == '') {
            echo "Plan Id is Wrong";
            exit;
        }
        if ($planid == 10)
            $amount = '1.25';

        if ($planid == 92 || $planid == 93)
            $amount = '1';

        mysql_select_db($DB, $con);
		//handled for combo packs start here
		$comboPackArray=array(120,121,122,123,124,125,126,127,128,129,130,131,132);
		if(in_array($planid,$comboPackArray))
			{
			 $DB = 'MTS_IVR';
			 $subscriptionProcedure = "COMBO_PACK_SUB";
			  $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ",'" . $planid . "'," . $transid . "," . $ccgid;
			  $qry .= ")";
			   //echo $qry;
			}
			if(mysql_query($qry))
			{
            $rcode = $abc[0];
			}
			else
			{
			$rcode = $abc[1];
			}
			echo $rcode;
			
			$logString_Combo = $msisdn . "#" . $StartTime . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#". date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $ccgid."#".$qry."#".$rcode."\r\n";
			error_log($logString_Combo, 3, $logPath_Combo);

		//handled for combo packs end here
		
        fwrite($file, $msisdn . "#" . $StartTime . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $qry . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
    }// end of if($reqtype == 1)
////////////////////////////////////// Request to deactive the Msisdn//////////////////////////////////////////////////////////////////////
    if ($reqtype == 2) {
        $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
        $file = fopen($log_file_path, "a");
		$DB = 'MTS_IVR';
		$unSubscriptionProcedure = "COMBO_PACK_UNSUB";
		$unsub = "select count(*) from " . $DB . "." . $subscriptionTable . "  nolock where ANI='$msisdn'";
        $qry5 = mysql_query($unsub, $con);
        $rows5 = mysql_fetch_row($qry5);
        if ($rows5[0] >= 1) {
            $unsubsQuery = "call " . $DB . "." . $unSubscriptionProcedure . " ('$msisdn','$mode')";
            $qry1 = mysql_query($unsubsQuery) or die(mysql_error());
            $qry2 = mysql_query("select count(*) from " . $DB . "." . $unSubscriptionTable . "   nolock where ANI='$msisdn'");
            $row1 = mysql_fetch_row($qry2);
            if ($row1[0] >= 1)
                $result = 0;
            else
                $result = 1;
        }
        else
            $result = 2;

        if ($result == 0)
            echo $rcode = $abc[0];
        elseif ($result == 1)
            echo $rcode = $abc[1];
        elseif ($result == 2)
            echo $rcode = $abc[2];

        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
        fclose($file);
    }
    mysql_close($con);
    $logString_process = "**********************************************" . "\r\n";
    error_log($logString_process, 3, $logPath_process);
    $logString_process = "Subscription process end here-" . $msisdn . "#" . date('d-m-Y h:i:s') . "\r\n";
    error_log($logString_process, 3, $logPath_process);

    exit;
////////////// End of Request to deactive the Msisdn//////////
}
?>