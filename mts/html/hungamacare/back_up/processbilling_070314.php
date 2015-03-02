<?php

include("config/dbConnect.php");

function getShortCode($serviceId) {
    $shortCode = "";
    switch ($serviceId) {
        case '1101':
            $shortCode = '52222';
            break;
        case '11012':
            $shortCode = '5222212';
            break;
        case '1102':
            $shortCode = '54646';
            break;
        case '1103':
            $shortCode = '546461';
            break;
        case '1106':
            $shortCode = '5432155';
            break;
        case '1111':
            $shortCode = '5432105';
            break;
        case '1110':
            $shortCode = '55935';
            break;
        case '1116':
            $shortCode = '54444';
            break;
        case '1113':
            $shortCode = '54646196';
            break;
        case '1124':
            $shortCode = '522223';
            break;
        case '1125':
            $shortCode = '5464622';
            break;
        case '1126':
            $shortCode = '51111';
            break;
        case '1123':
            $shortCode = '55333';
            break;
    }
    return $shortCode;
}

$dir_path = "/var/www/html/hungamacare/log/";

$file_name1 = "processlog_" . date("dmy") . ".txt";
$file_path = $dir_path . $file_name1;
$fp = fopen($file_path, "a+");

$select_query = "select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id,amount,language,act_date,renew_date from billing_intermediate_db.bulk_upload_history where status=0 and upload_for not in('event_active','event_unsub','tryandbuy') and service_id in(1101,1102,1103,1111,1106,1110,1116,1113,1124,1125,1123,1126) limit 1";

$query = mysql_query($select_query, $dbConn) or die(mysql_error());
while (list($file_name, $datetime, $service_type, $channel, $price, $upload_for, $batch_id, $service_id, $Newamount, $lang, $act_date, $rw_date) = mysql_fetch_array($query)) {
    fwrite($fp, $file_name . "," . $datetime . "," . $service_type . "," . $channel . "," . $price . "," . $upload_for . "," . $batch_id . "," . $service_id . "," . $Newamount . "," . $lang . "," . $act_date . "," . $renew_date . "\r\n");

    $update_bulk_history = "update billing_intermediate_db.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=" . $service_id;
    $bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());

    $file_to_read = "http://10.130.14.107/hungamacare/bulkuploads/" . $service_id . "/" . $file_name;
    $file_data = file($file_to_read);
    $file_size = sizeof($file_data);
    switch ($upload_for) {
        case 'active':
            $reqtype = 1;
            $amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
            $amt = mysql_query($amtquery, $dbConn);
            List($amount) = mysql_fetch_row($amt);
            if ($service_id == 1116) {
                $paramData = explode("-", $service_type);
                if ($paramData[0] != 'N')
                    $cat1 = $paramData[0];
                else
                    $cat1 = "";
                if ($paramData[1] != 'N')
                    $cat2 = $paramData[1];
                else
                    $cat2 = "";
                if ($paramData[2] != 'N')
                    $lang = $paramData[2];
                else
                    $lang = "01";
                $service_type = "";
            }
            break;
        case 'deactive':
            $reqtype = 2;
            $price = 7;
            break;
        case 'topup':
            $reqtype = 'topup';
            break;
        case 'renewal':
            $reqtype = 'resub';
            $amtquery = "select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
            $amt = mysql_query($amtquery, $dbConn);
            List($amount) = mysql_fetch_row($amt);
            break;
    }
    for ($i = 0; $i < $file_size; $i++) {
        $msisdn = trim($file_data[$i]);
        switch ($service_id) {
            case '1101': $subTable = "mts_radio.tbl_radio_subscription";
                $tableName = 'mts_radio.tbl_radio_blacklist';
                break;
            case '1102': $subTable = "mts_hungama.tbl_jbox_subscription";
                $tableName = 'mts_hungama.tbl_jbox_blacklist';
                break;
            case '1103': $subTable = "mts_mtv.tbl_mtv_subscription";
                $tableName = 'mts_mtv.tbl_jbox_blacklist';
                break;
            case '1106': $subTable = "mts_starclub.tbl_jbox_subscription";
                $tableName = 'mts_starclub.tbl_jbox_blacklist';
                break;
            case '1111': $subTable = "dm_radio.tbl_digi_subscription";
                $tableName = 'dm_radio.tbl_jbox_blacklist';
                break;
            case '1110': $subTable = "mts_redfm.tbl_jbox_subscription";
                $tableName = 'mts_redfm.tbl_jbox_blacklist';
                break;
            case '1116': $subTable = "mts_voicealert.tbl_voice_subscription";
                $tableName = 'mts_voicealert.tbl_jbox_blacklist';
                break;
            case '1113': $subTable = "mts_mnd.tbl_character_subscription1";
                //$tableName='mts_mnd.tbl_character_unsub1';
                $tableName = 'mts_mnd.tbl_jbox_blacklist';
                break;
            case '1124': $subTable = "mts_radio.tbl_AudioCinema_subscription";
                $tableName = 'mts_radio.tbl_radio_blacklist';
                break;
            case '1125': $subTable = "mts_JOKEPORTAL.tbl_jokeportal_subscription";
                $tableName = 'mts_JOKEPORTAL.tbl_jbox_blacklist';
                break;
        }
        $getBlacklist = "select count(*) from " . $tableName . " where ani=" . $msisdn;
        $BlackList = mysql_query($getBlacklist, $dbConn);
        List($BList) = mysql_fetch_row($BlackList);
        if (strlen(trim($msisdn)) == 10 && $BList <= 0) {
            if ($reqtype == 2) {
                $billing_url = "http://10.130.14.107/MTS/MTS.php?msisdn=" . trim($msisdn);
                $billing_url .="&mode=" . $channel . "&reqtype=" . $reqtype . "&planid=" . $price . "&serviceid=" . $service_id . "&ac=0";
                $billing_url .="&subchannel=bulk&rcode=100,101,102";
                $url_response = file_get_contents($billing_url);
            } elseif ($reqtype == 1) {
                $billing_url = "http://10.130.14.107/MTS/MTS.php?msisdn=" . trim($msisdn);
                $billing_url .="&mode=" . $channel . "&reqtype=" . $reqtype . "&planid=" . $price . "&serviceid=" . $service_id . "&ac=0&amt=" . $Newamount;
                if ($service_id == 1116) {
                    $billing_url .="&cat1=" . $cat1 . "&cat2=" . $cat2;
                }
                $billing_url .="&lang=" . $lang . "&subchannel=bulk&rcode=100,101,102&batchid=" . $batch_id;
                echo $billing_url;
                echo $url_response = file_get_contents($billing_url);

                $fileName = explode(".", $file_name);
                $log_file_path = "/var/www/html/hungamacare/log/" . $fileName[0] . "_bulk_log_" . date('Y-m-d') . ".txt";
                $LogString = $msisdn . "#" . $channel . "#" . $price . "#" . $billing_url . "#" . $url_response . "#" . date('Y-m-d H:i:s') . "\n";
                error_log($LogString, 3, $log_file_path);
            } elseif ($reqtype == 'topup') {
                /* $topup_url ="http://10.130.14.107/topup/topup.php?ani=".trim($msisdn)."&amount=".$price;
                  $url_response=file_get_contents($topup_url); */

                $lang = '02';
                $plan_id = '5';
                $mode = 'OBD-MS';
                $sc = '54646';

                $getCircle = "select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
                $circle1 = mysql_query($getCircle, $dbConn);
                $circle = mysql_fetch_row($circle1);

                //	$insertToppupRequest="insert into master_db.tbl_billing_reqs values('',".trim($msisdn).",'TOPUP',now(),$price,0,'$lang',$sc,'$mode','$circle[0]','MTSM',$service_id,0,$plan_id,'0')";
                $insertToppupRequest = "insert into master_db.tbl_billing_reqs values(''," . trim($msisdn) . ",'TOPUP',now(),$price,0,'$lang',$sc,'$mode','$circle[0]','MTSM',$service_id,0,$plan_id,'0','0','0')";
                $qry1 = mysql_query($insertToppupRequest, $dbConn);

                $log_file_path = "/var/www/html/topup/log/bulk_topup_log_" . date('Y-m-d') . ".txt";
                $LogString = $msisdn . "#" . $mode . "#" . date('H:i:s') . "#" . $price . "#" . $insertToppupRequest . "\r\n";
                error_log($LogString, 3, $log_file_path);
            } elseif ($reqtype == "resub") {
                $getCircle = "select master_db.getCircle(" . trim($msisdn) . ") as circle";
                $circle1 = mysql_query($getCircle, $dbConn) or die(mysql_error());
                while ($row = mysql_fetch_array($circle1)) {
                    $circle = $row['circle'];
                }
                if (!$circle) {
                    $circle = 'UND';
                }

                $plan_id = $price;

                $shortCode = getShortCode($service_id);
                //$insertResubRequest="insert into master_db.tbl_billing_reqs values('','".$msisdn."','RESUB',now(),$amount,0,'01','".$shortCode."','$channel','$circle','MTSM',$service_id,$batch_id,$plan_id,'0')";
                $insertResubRequest = "insert into master_db.tbl_billing_reqs values('','" . $msisdn . "','RESUB',now(),$amount,0,'01','" . $shortCode . "','$channel','$circle','MTSM',$service_id,$batch_id,$plan_id,'0','0','0')";
                $qry1 = mysql_query($insertResubRequest, $dbConn);

                if ($plan_id == '64' || $plan_id == '66' || $plan_id == '68') {
                    $subDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") - 150, date("Y")));
                } else {
                    $subDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") - 30, date("Y")));
                }
                $renewDate = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));

                if (!empty($act_date)) {
                    $subDate = $act_date;
                }
                if (!empty($rw_date)) {
                    $renewDate = $rw_date;
                }


                $insertSub = "insert into " . $subTable . " (ANI,SUB_DATE,RENEW_DATE,DEF_LANG,STATUS,MODE_OF_SUB,DNIS,USER_BAL,SUB_TYPE,plan_id,circle, chrg_amount) value ('" . $msisdn . "', '" . $subDate . "', '" . $renewDate . "', '01', 0, '" . $channel . "', '" . $shortCode . "', '0', 'bulk','" . $plan_id . "','" . $circle . "','" . $amount . "')";
                mysql_query($insertSub, $dbConn);

                $log_file_path = "/var/www/html/hungamacare/log/bulk_resub_log_" . date('Y-m-d') . ".txt";
                $LogString = $msisdn . "#" . $channel . "#" . date('H:i:s') . "#" . $price . "#" . $insertResubRequest . "\n";
                error_log($LogString, 3, $log_file_path);
            }
        }
    } // end of for 
    echo "<br/>Processing of the file.<b>" . $file_name . " </b>has been done successfuly";
} // end of while
echo "done";
fclose($fp);
mysql_close($dbConn);
?>
