<?php

error_reporting(1);
$logdate = date("Y-m-d");
$logPath_process = "/var/www/html/MTS/logs/processlogs/" . $logdate . "_log.txt";
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

/****************************Added for Combo packs only start here ******************************/
$comboPackArray=array(120,121,122,123,124,125,126,127,128,129,130,131,132);
		if(in_array($planid,$comboPackArray))
			{
			$pagename='MTS_Telecall.php';
			$url = "http://10.130.14.107/MTS/$pagename?msisdn=".$msisdn."&mode=".$mode."&reqtype=".$reqtype."&planid=".$planid."&serviceid=".$seviceId;
			$url.="&subchannel=".$subchannel."&rcode=".$rcode."&CCGID=".$ccgid."&ac=".$ac."&test=".$test."&online=".$online;
			$url.="&cat1=".$catId1."&cat2=".$catId2."&lang=".$lang1."&batchid=".$batchId."&TCID=".$transid."&UCT=".$UCT."&rel=".$rel;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			echo $data = curl_exec($ch);
			//echo $url;
			exit;
}

/**********************************End here ***********************************************/

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
        case '1103':
            $sc = '546461';
            $s_id = '1103';
            $DB = 'mts_mtv';
            $subscriptionTable = "tbl_mtv_subscription";

            if ($batchId)
                $subscriptionProcedure = "MTV_SUB_BULK";
            else
                $subscriptionProcedure = "MTV_SUB";

            $unSubscriptionProcedure = "MTV_UNSUB";
            $unSubscriptionTable = "tbl_mtv_unsub";
            $lang = '01';
            break;
        case '1102':
            if ($param == '9XM')
                $sc = '54646996';
            elseif ($param == 'AAV')
                $sc = '5464611';
            elseif ($param == '9XT')
                $sc = '54646997';
            else
                $sc = '54646';

            if ($ac == 1)
                $sc = '546469';
            $s_id = '1102';
            $DB = 'mts_hungama';
            $subscriptionTable = "tbl_jbox_subscription";

            if ($batchId)
                $subscriptionProcedure = "JBOX_SUB_BULK";
            else
                $subscriptionProcedure = "jbox_sub";

            $unSubscriptionProcedure = "jbox_unsub";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
        case '1101':
        case '11011':
            if ($seviceId == '1101')
                $sc = '52222';
            elseif ($seviceId == '11011')
                $sc = '5222212';
            $seviceId = '1101';
            $s_id = '1101';
            $DB = 'mts_radio';
            $subscriptionTable = "tbl_radio_subscription";

            if ($batchId)
                $subscriptionProcedure = "RADIO_SUB_BULK";
            else
                $subscriptionProcedure = "RADIO_SUB";

            $unSubscriptionProcedure = "RADIO_UNSUB";
            $unSubscriptionTable = "tbl_radio_unsub";
            $lang = '01';
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
        case '1106':
            if ($planid == 11 || $planid == 12 || $planid == 13 || $planid == 19) {
                $sc = '54321551';
                $s_id = '1106';
                $DB = 'mts_starclub';
                $subscriptionTable = "tbl_celebrity_evt_ticket";
                $showQuery = "SELECT show_id,celeb_id,show_date,start_time,end_time FROM mts_starclub.tbl_show_details nolock WHERE show_status=1";
                $showResult = mysql_query($showQuery);
                while ($showDetail = mysql_fetch_array($showResult)) {
                    $celebId = $showDetail['celeb_id'];
                    $showId = $showDetail['show_id'];
                    $startDate = $showDetail['show_date'];
                    $startTime = $showDetail['start_time'];
                    $endTime = $showDetail['end_time'];
                }
                $subscriptionProcedure = "JBOX_PURCHASE_CELEBRITY_TICKET";
                $lang = '01';
                if (!$showId) {
                    echo "No Current event exist!";
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#No Current event exits" . "\r\n");
                    exit;
                }
            } else {
                $sc = '5432155';
                $s_id = '1106';
                $DB = 'mts_starclub';
                $subscriptionTable = "tbl_jbox_subscription";
                if ($batchId)
                    $subscriptionProcedure = "JBOX_SUB_BULK";
                else
                    $subscriptionProcedure = "JBOX_SUB";

                $unSubscriptionProcedure = "JBOX_UNSUB";
                $unSubscriptionTable = "tbl_jbox_unsub";
                $lang = '01';
            }
            break;
        case '1113':
            $sc = '54646196';
            $s_id = '1113';
            $DB = 'mts_mnd';
            $subscriptionTable = "tbl_character_subscription1";

            if ($batchId)
                $subscriptionProcedure = "MND_SUB_BULK";
            else
                $subscriptionProcedure = "MND_SUB";

            $unSubscriptionProcedure = "MND_UNSUB";
            $unSubscriptionTable = "tbl_character_unsub1";
            $lang = '01';
            break;
        case '1116':
            $sc = '54444';
            $s_id = '1116';
            $DB = 'mts_voicealert';
            //$batchId=0;
            $subscriptionTable = "tbl_voice_subscription";
            if ($catId1 || $catId2) {
                if ($planid == 25 || $planid == 26 || $planid = 94) {
                    if ($batchId)
                        $subscriptionProcedure = "VOICE_OBD_Bulk";
                    else
                        $subscriptionProcedure = "VOICE_OBD";
                } //elseif($planid==27) $subscriptionProcedure="VOICE_OBD";
            } else {
                if ($batchId)
                    $subscriptionProcedure = "VOICE_SUB_Bulk";
                else
                    $subscriptionProcedure = "VOICE_SUB";
            }
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_voice_unsub";
            if ($lang1) {
                if ($lang1 <= 9) {
                    //$lang="0".$lang1;
                    $lang = $lang1;
                }
                else
                    $lang = $lang1;
            }
            else
                $lang = '01';
            break;
        case '1124':
            $sc = '522223';
            $s_id = '1124';
            $DB = 'mts_radio';
            $subscriptionTable = "tbl_AudioCinema_subscription";
            if ($batchId)
                $subscriptionProcedure = "CINEMA_SUB_Bulk";
            else
                $subscriptionProcedure = "CINEMA_SUB";
            $unSubscriptionProcedure = "CINEMA_UNSUB";
            $unSubscriptionTable = "tbl_AudioCinema_unsub";
            $lang = '01';
            break;
        case '1125':
            $sc = '5464622';
            $s_id = '1125';
            $DB = 'mts_JOKEPORTAL';
            $subscriptionTable = "tbl_jokeportal_subscription";
            if ($batchId)
                $subscriptionProcedure = "JOKES_SUB_BULK";
            /* elseif($test)
              {
              $subscriptionProcedure = "JOKEPORTAL_SUB_TNB";
              } */
            else
                $subscriptionProcedure = "JOKEPORTAL_SUB";
            $unSubscriptionProcedure = "JOKEPORTAL_UNSUB";
            $unSubscriptionTable = "tbl_jokeportal_unsub";
            $lang = '01';
            break;
        case '1126':
            $sc = '51111';
            $s_id = '1126';
            $DB = 'mts_Regional';
            $subscriptionTable = "tbl_regional_subscription";
            $subscriptionProcedure = "REGIONAL_SUB";
            $unSubscriptionProcedure = "REGIONAL_UNSUB";
            $unSubscriptionTable = "tbl_regional_unsub";
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
        default:
            echo "Invalid Service name";
            exit;
            break;
    }
    if ($_REQUEST['test'])
        echo $subscriptionProcedure;

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
        $langValue = "01";
    }
    if (!$langValue)
        $langValue = "01";

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
        if ($planid == 11 || $planid == 12 || $planid == 13 || $planid == 19)
            $sub = "select count(*) from " . $DB . "." . $subscriptionTable . " nolock where ANI='$msisdn' and cele_showid='1'";
        else
            $sub = "select count(*) from " . $DB . "." . $subscriptionTable . " nolock where ANI='$msisdn' and MODE_OF_SUB!='TRCV'";
        $qry1 = mysql_query($sub);
        $rows1 = mysql_fetch_row($qry1);

        if ($rows1[0] <= 0) {
            if ($planid == 11 || $planid == 12 || $planid == 13 || $planid == 19) {
                $qry = "call " . $DB . "." . $subscriptionProcedure . "('" . $msisdn . "','" . $mode . "','" . $sc . "','" . $showId . "','" . $celebId . "','" . $startDate . "' ,'" . $startTime . "' ,'" . $endTime . "', " . $s_id . "," . $planid . "'," . $transid . "," . $ccgid . ")";
            } else {
                if ($catId1 || $catId2) {
                    //  $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ", " . $planid . ", '" . $catId1 . "', '" . $catId2 . ", '" . $transid . "', '" . $ccgid;
                    $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "','" . $s_id . "','" . $planid . "','" . $catId1 . "','" . $catId2 . "'," . $transid . "," . $ccgid;
                } else if ($s_id == 1102 || $s_id == 1125 || $s_id == 1126 || $s_id == 1123 || $s_id == 1110 || $s_id == 1113 || $s_id == 1116 || $s_id == 1101 || $s_id == 11011 || $s_id == 1103 || $s_id == 1111) {
                    if ($batchId) {
                        //$qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ",'" . $planid. "'," . $transid . "," . $ccgid;
                        $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $planid;
                    } else {
                        $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ",'" . $planid . "'," . $transid . "," . $ccgid;
                    }
                }
//                else if($s_id == 1123){
//                     $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $planid;
//                }
                else {
                    $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . ",'" . $planid . "'," . $transid . "," . $ccgid;
                }
                if ($batchId)
                    $qry .= ", " . $batchId . ")";
                else
                    $qry .= ")";
            }


            if ($_REQUEST['test'])
                echo $qry;
            if ($_REQUEST['rel'] && $s_id == '1111') {

                $religion = $_REQUEST['rel'];
                $religionValue = getReligion($religion);
                $langValue = $langArray[strtoupper($lang)];
                $qry_relign_proc = "call " . $DB . "." . $DIGI_RELIGION_SELECTION . " ('" . $msisdn . "','" . $religionValue . "','" . $langValue . "')";
                $qry_relign_proc_call = mysql_query($qry_relign_proc);
                $logString_process = "Query process tbl_religion_profile start here-" . $qry_relign_proc . "#" . $_REQUEST['rel'] . "#" . $lang . "#" . date('d-m-Y h:i:s') . "\r\n";
                error_log($logString_process, 3, $logPath_process);
                /* 	
                  $countData = mysql_query("SELECT count(*) FROM dm_radio.tbl_religion_profile WHERE ANI='" . $msisdn . "'");
                  list($countRel) = mysql_fetch_array($countData);

                  $langValue = $langArray[strtoupper($lang)];
                  if (!$langValue)
                  $langValue = "01";
                  if ($countRel) {
                  $updateReligion = "UPDATE dm_radio.tbl_religion_profile SET lastreligion_cat='" . strtolower($religionValue) . "',lang='" . $langValue . "' WHERE ANI='" . $msisdn . "'";
                  mysql_query($updateReligion);
                  } else {
                  $insertReligion = "INSERT INTO dm_radio.tbl_religion_profile (ANI, lastreligion_cat, lang) VALUES ('" . $msisdn . "', '" . strtolower($religionValue) . "', '" . $langValue . "')";
                  mysql_query($insertReligion);
                  }
                 */
            }
            $logString_process = "Query process start here-" . $qry . "#" . date('d-m-Y h:i:s') . "\r\n";
            error_log($logString_process, 3, $logPath_process);
            $qry1 = mysql_query($qry) or die(mysql_error());
            $logString_process = "Query process end here-" . $qry . "#" . date('d-m-Y h:i:s') . "\r\n";
            error_log($logString_process, 3, $logPath_process);
            if ($planid == 11 || $planid == 12 || $planid == 13 || $planid == 19)
                $query3 = "select count(*) from " . $DB . "." . $subscriptionTable . " nolock where ANI='$msisdn' and cele_showid='1'";
            else
                $query3 = "select ani,chrg_amount,sub_date,renew_date from " . $DB . "." . $subscriptionTable . " nolock where ANI='$msisdn'";

            if ($_REQUEST['test'])
                echo $query3;

            if ($online == 'y') {
                $query4 = " and status=1";
                $query2 = $query3 . $query4;
                if ($_REQUEST['test'])
                    echo $query2;
                for ($ik = 1; $ik < 6; $ik++) {
                    sleep(10);
                    $qry2 = mysql_query($query2);
                    $result2 = mysql_fetch_row($qry2);
                    if ($result2[0] >= 1) {
                        $notReExecute = 1;
                        $result = 0;
                        break;
                    }
                } // End of For loop
            } // End of IF loop

            if ($notReExecute != 1) {
                $qry2 = mysql_query($query2);
                $result2 = mysql_fetch_row($qry2);
                if ($result2[0] >= 1)
                    $result = 0;
                else {
                    $qry3 = mysql_query($query3);
                    $result3 = mysql_fetch_row($qry3);
                    if ($result3[0] >= 1)
                        $result = 4;
                    else
                        $result = 1;
                }
            }
        } else {
            $result = 2;
            if ($_REQUEST['lang']) {
                $updateLang = "UPDATE " . $dbname . "." . $subscriptionTable . " SET def_lang='" . $langValue . "' WHERE ANI='" . $msisdn . "'";
                mysql_query($updateLang);
            }
            if ($_REQUEST['rel'] && $s_id == '1111') {

                $religion = $_REQUEST['rel'];
                $religionValue = getReligion($religion);
                $langValue = $langArray[strtoupper($lang)];
                $qry_relign_proc = "call " . $DB . "." . $DIGI_RELIGION_SELECTION . " ('" . $msisdn . "','" . $religionValue . "','" . $langValue . "')";
                $qry_relign_proc_call = mysql_query($qry_relign_proc);
                $logString_process = "Query process tbl_religion_profile satay**** start here-" . $qry_relign_proc . "#" . $_REQUEST['rel'] . "#" . $lang . "#" . date('d-m-Y h:i:s') . "\r\n";
                error_log($logString_process, 3, $logPath_process);
                /*
                  $countData = mysql_query("SELECT count(*) FROM dm_radio.tbl_religion_profile WHERE ANI='" . $msisdn . "'");
                  list($countRel) = mysql_fetch_array($countData);
                  $religionValue = getReligion($religion);
                  $langValue = $langArray[strtoupper($lang)];
                  if (!$langValue)
                  $langValue = "01";
                  if ($countRel) {
                  $updateReligion = "UPDATE dm_radio.tbl_religion_profile SET lastreligion_cat='" . strtolower($religionValue) . "',lang='" . $langValue . "' WHERE ANI='" . $msisdn . "'";
                  mysql_query($updateReligion);
                  } else {
                  $insertReligion = "INSERT INTO dm_radio.tbl_religion_profile (ANI, lastreligion_cat, lang) VALUES ('" . $msisdn . "', '" . strtolower($religionValue) . "', '" . $langValue . "')";
                  mysql_query($insertReligion);
                  } */
            }
        }


        if ($result == 0 && $seviceId == 1101 && $UCT != "") {     // Insert CRBT for UCT
            $insert_data = "insert into mts_radio.tbl_radiocrbt_reqs(ani,reqs_date,reqs_type,crbt_id,status) values('$msisdn', '$curdate','crbt','$UCT','0')";
            $uc = mysql_query($insert_data);
            echo $rcode = "100";
        } // End of Insert CRBT for UCT
//if($result==0 && $UCT == "")
        if ($result == 0) {
            if ($online == 'y') {
                if ($mode == 'IBD' && $seviceId == '1113') {
                    $displayStr = "<ROOT><SERVICE>";
                    $displayStr.="<SVCNAME>MTSMPD</SVCNAME>";
                    $displayStr.="<SVCSTATUS>Active</SVCSTATUS>";
                    $displayStr.="<ACTDATE>" . $result2[2] . "</ACTDATE>";
                    $displayStr.="<DEACTDATE>NA</DEACTDATE>";
                    $displayStr.="<RENDATE>" . $result2[3] . "</RENDATE>";
                    $displayStr.="<LASTRENDATE>NA</LASTRENDATE>";
                    $displayStr.="</SERVICE></ROOT>";
                    echo $displayStr;
                }
                else
                    echo $rcode = 'Successfully Subscribed#' . $result2[1];
            }
            else
                echo $rcode = $abc[0];
        }
//elseif(($result==1 || $result==4) && $UCT == "")
        elseif (($result == 1 || $result == 4)) {

            if ($online == 'y') {
                if ($result == 1) {
                    if ($mode == 'IBD' && $seviceId == '1113') {
                        $displayStr = "<ROOT><SERVICE>";
                        $displayStr.="<SVCNAME>MTSMPD</SVCNAME>";
                        $displayStr.="<SVCSTATUS>Charging Failed</SVCSTATUS>";
                        $displayStr.="<ACTDATE>NA</ACTDATE>";
                        $displayStr.="<DEACTDATE>NA</DEACTDATE>";
                        $displayStr.="<RENDATE>NA</RENDATE>";
                        $displayStr.="<LASTRENDATE>NA</LASTRENDATE>";
                        $displayStr.="</SERVICE></ROOT>";
                        echo $displayStr;
                    } else {
                        echo $rcode = "Charging Failed";
                    }
                } elseif ($result == 4 && $seviceId == '1113') {
                    if ($mode == 'IBD') {
                        $displayStr = "<ROOT><SERVICE>";
                        $displayStr.="<SVCNAME>MTSMPD</SVCNAME>";
                        $displayStr.="<SVCSTATUS>Charging In Process</SVCSTATUS>";
                        $displayStr.="<ACTDATE>NA</ACTDATE>";
                        $displayStr.="<DEACTDATE>NA</DEACTDATE>";
                        $displayStr.="<RENDATE>NA</RENDATE>";
                        $displayStr.="<LASTRENDATE>NA</LASTRENDATE>";
                        $displayStr.="</SERVICE></ROOT>";
                        echo $displayStr;
                    } else {
                        echo $rcode = "Charging In Process";
                    }
                } else {
                    echo $rcode = "Charging In Process";
                }
            } else {
                if ($result == 1)
                    echo $rcode = $abc[1];
                elseif ($result == 4)
                    echo $rcode = $abc[0];
            }
        }
//elseif($result==2 && $UCT == "")
        elseif ($result == 2) {
            if ($online == 'y') {
                if ($mode == 'IBD' && $seviceId == '1113') {
                    $displayStr = "<ROOT><SERVICE>";
                    $displayStr.="<SVCNAMEMTSMPD</SVCNAME>";
                    $displayStr.="<SVCSTATUS>Already Subscribed</SVCSTATUS>";
                    $displayStr.="<ACTDATE>" . $result2[2] . "</ACTDATE>";
                    $displayStr.="<DEACTDATE>NA</DEACTDATE>";
                    $displayStr.="<RENDATE>" . $result2[3] . "</RENDATE>";
                    $displayStr.="<LASTRENDATE>NA</LASTRENDATE>";
                    $displayStr.="</SERVICE></ROOT>";
                    echo $displayStr;
                } else {
                    echo $rcode = "Already Subscribed";
                }
            } else {
                echo $rcode = $abc[2];
            }
        }
        if ($UCT != "")
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#uct->" . $UCT . "#" . $rcode . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
        else
            fwrite($file, $msisdn . "#" . $StartTime . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $qry . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "#" . $ccgid . "\r\n");
    }// end of if($reqtype == 1)
////////////////////////////////////// Request to deactive the Msisdn//////////////////////////////////////////////////////////////////////
    if ($reqtype == 2) {
        $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
        $file = fopen($log_file_path, "a");
        mysql_select_db($DB, $con);
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
////////////////////////////////////// End of Request to deactive the Msisdn//////////////////////////////////////////////////////////////////////
}
?>