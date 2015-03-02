<?php
error_reporting(1);
$con = mysql_pconnect("10.130.14.106", "billing", "billing");
if (!$con) {
    die('could not connect1: ' . mysql_error());
}
$rcode = $_REQUEST['rcode'];
$msisdn = $_GET['msisdn'];
$planid = $_GET['planid'];
$mode = $_REQUEST['mode'];
$reqtype = $_REQUEST['reqtype'];
$seviceId = $_REQUEST['serviceid'];
$online = $_REQUEST['online'];
$catId1 = $_REQUEST['cat1'];
$catId2 = $_REQUEST['cat2'];
$curdate = date("Y-m-d");
$StartTime = date("H:i:s");
$amount = $_REQUEST['amt'];
$transid=0;
if ($catId1 || $catId2) {
    if (!$catId1)
        $catId1 = "NA";
    if (!$catId2)
        $catId2 = "NA";
}
//disable online request parameter as per discussion with vivek P & vikrant garg on 25 jan14 
if($mode=='197_OBD' || $mode=='TZ_OBD')
$online = $_REQUEST['online'];
else
$online='';
//VG_OBD >> No online response
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
//$langArray = array('TEL' => '08', 'HIN' => '01', 'TAM' => '07', 'KAN' => '10', 'ENG' => '02', 'MAI' => '21', 'MAL' => '09', 'NEP' => '19', 'ASS' => '17', 'GUJ' => '12', 'RAJ' => '18', 'BHO' => '04', 'PUN' => '03', 'ORI' => '13', 'MAR' => '11', 'CHH' => '16', 'HAR' => '05', 'BEN' => '06', 'HIM' => '15', 'KAS' => '14', 'KUM' => '20');
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
    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "\r\n");
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
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "\r\n");
                    fclose($file);
                }
                if ($reqtype == 2) {
                    $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
                    $file = fopen($log_file_path, "a");
                    fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "\r\n");
                    fclose($file);
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        echo $abc[1];
        $rcode = $abc[1];
        if ($reqtype == 1) {
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "#" . $remoteAdd . "\r\n");
            fclose($file);
        }
        exit;
    }
    return $msisdn;
}
$msisdn = checkmsisdn(trim($msisdn), $abc, $seviceId);
if (($msisdn == "") || ($mode == "") || ($reqtype == "") || ($planid == "")) {
    echo "Please provide the complete parameter";
} else {
    switch ($seviceId) {
        case '1103':
            $sc = '546461';
            $s_id = '1103';
            $DB = 'mts_mtv';
            $subscriptionTable = "tbl_mtv_subscription";
            $subscriptionProcedure = "MTV_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "MTV_UNSUB";
            $unSubscriptionTable = "tbl_mtv_unsub";
            $lang = '01';
            break;
        case '1102':
            $sc = '54646';
            $s_id = '1102';
            $DB = 'mts_hungama';
            $subscriptionTable = "tbl_jbox_subscription";
            $subscriptionProcedure = "JBOX_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "jbox_unsub";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
        case '1110':
            $sc = '55935';
            $s_id = '1110';
            $DB = 'mts_redfm';
            $subscriptionTable = "tbl_jbox_subscription";
            $subscriptionProcedure = "REDFM_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
        case '1106':
            $sc = '5432155';
            $s_id = '1106';
            $DB = 'mts_starclub';
            $subscriptionTable = "tbl_jbox_subscription";
            $subscriptionProcedure = "FMJ_EVENT_ACT_BULK";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_jbox_unsub";
            $lang = '01';
            break;
        case '1113':
            $sc = '54646196';
            $s_id = '1113';
            $DB = 'mts_mnd';
            $subscriptionTable = "tbl_character_subscription1";
            $subscriptionProcedure = "MND_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "MND_UNSUB";
            $unSubscriptionTable = "tbl_character_unsub1";
            $lang = '01';
            break;
        case '1116':
            $sc = '54444';
            $s_id = '1116';
            $DB = 'mts_voicealert';
            $subscriptionTable = "tbl_voice_subscription";
            $subscriptionProcedure = "VA_EVENT_SUB_BULK";
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
        case '1125':
            $sc = '5464622';
            $s_id = '1125';
            $DB = 'mts_JOKEPORTAL';
            $subscriptionTable = "tbl_jokeportal_subscription";
            $subscriptionProcedure = "JOKEPORTAL_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "JOKEPORTAL_UNSUB";
            $unSubscriptionTable = "tbl_jokeportal_unsub";
            $lang = '01';
        break;
        case '1126':
            $sc = '51111';
            $s_id = '1126';
            $DB = 'mts_Regional';
            $subscriptionTable = "tbl_regional_subscription";
            $subscriptionProcedure = "REGIONAL_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "REGIONAL_UNSUB";
            $unSubscriptionTable = "tbl_regional_unsub";
            $lang = '01';
        break;
        case '1123':
            $sc = '55333';
            $s_id = '1123';
            $DB = 'Mts_summer_contest';
            $subscriptionTable = "tbl_contest_subscription";
            $subscriptionProcedure = "CONTEST_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "CONTEST_UNSUB";
            $unSubscriptionTable = "tbl_contest_unsub";
            $lang = '01';
        break;
        case '1111':
            $sc = '5432105';
            $s_id = '1111';
            $DB = 'dm_radio';
            $subscriptionTable = "tbl_digi_subscription";
            $subscriptionProcedure = "BS_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "DIGI_UNSUB";
            $unSubscriptionTable = "tbl_digi_unsub";
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
            $subscriptionProcedure = "RADIO_EVENT_SUB_BULK";
            $unSubscriptionProcedure = "RADIO_UNSUB";
            $unSubscriptionTable = "tbl_radio_unsub";
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

    if ($_REQUEST['test'])
        echo $langValue;
    if ($reqtype == 3) {
	//if ($reqtype == 1) {
        if (!$amount)
        {
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
        $sub = "select count(*) from " . $DB . "." . $subscriptionTable . " where ANI='$msisdn' and MODE_OF_SUB!='TRCV'";
        $qry1 = mysql_query($sub);
        $rows1 = mysql_fetch_row($qry1);
        if ($rows1[0] <= 0) {
            $qry = "call " . $DB . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $planid.",0)";
        if ($_REQUEST['test'])
            echo $qry;
            
            $qry1 = mysql_query($qry) or die(mysql_error());
            
            $query3 = "select ani,chrg_amount,sub_date,renew_date from " . $DB . "." . $subscriptionTable . " where ANI='$msisdn'";

            if ($_REQUEST['test'])
                echo $query3;

            if($online == 'y'){
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
                }
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
                } elseif ($result == 4) {
                    if ($mode == 'IBD' && $seviceId=='1113') {
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
            if ($online == 'y'){
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
                }else{
                echo $rcode = "Already Subscribed";
                }
            }
            else{
                echo $rcode = $abc[2];
            }
        }
        if ($UCT != "")
            fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#uct->" . $UCT . "#" . $rcode . "#" . $remoteAdd . "\r\n");
        else
            fwrite($file, $msisdn . "#" . $StartTime . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . $qry . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "\r\n");
    }// end of if($reqtype == 1)
////////////////////////////////////// Request to deactive the Msisdn//////////////////////////////////////////////////////////////////////
    if ($reqtype == 2) {
        $log_file_path = "logs/MTS/unsubscription/" . $seviceId . "/unsubscription_" . $curdate . ".txt";
        $file = fopen($log_file_path, "a");
        mysql_select_db($DB, $con);
        $unsub = "select count(*) from " . $DB . "." . $subscriptionTable . " where ANI='$msisdn'";
        $qry5 = mysql_query($unsub, $con);
        $rows5 = mysql_fetch_row($qry5);
        if ($rows5[0] >= 1) {
            $unsubsQuery = "call " . $DB . "." . $unSubscriptionProcedure . " ('$msisdn','$mode')";
            $qry1 = mysql_query($unsubsQuery) or die(mysql_error());
            $qry2 = mysql_query("select count(*) from " . $DB . "." . $unSubscriptionTable . "  where ANI='$msisdn'");
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

        fwrite($file, $msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "#" . $remoteAdd . "\r\n");
        
    }
	fclose($file);
    mysql_close($con);
    exit;
////////////////////////////////////// End of Request to deactive the Msisdn//////////////////////////////////////////////////////////////////////
}
?>