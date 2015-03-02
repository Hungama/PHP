<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
$serviceArray = array('1101' => 'MTS - muZic Unlimited', '1111' => 'MTS - Bhakti Sagar', '1123' => 'MTS - Monsoon Dhamaka', '1110' => 'MTS - Red FM',
    '1116' => 'MTS - Voice Alerts', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTSReg', '1113' => 'MTS - MPD', '1102' => 'MTS - 54646', '1106' => 'MTSFMJ');

foreach ($serviceArray as $s_id => $s_val) {
$subscription_db='';
    switch ($s_id) {
        case '1101':
            $subscription_db = "mts_mu";
            $subscription_table = "tbl_HB_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_radio_calllog";
            $dnis_str = "a.dnis like '52222%'";
            break;
			/*
        case '1111':
            $subscription_db = "dm_radio";
            $subscription_table = "tbl_digi_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_Devotional_calllog";
            $dnis_str = "a.dnis like '5432105%'";
            break;
        case '1123':
            $subscription_db = "Mts_summer_contest";
            $subscription_table = "tbl_contest_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mtv_calllog";
            $dnis_str = "a.dnis like '55333%'";
            break;
        case '1110':
            $subscription_db = "mts_redfm";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_redfm_calllog";
            $dnis_str = "a.dnis='55935'";
            break;
        case '1116':
            $subscription_db = "mts_voicealert";
            $subscription_table = "tbl_voice_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_voicealert_calllog";
            $dnis_str = "a.dnis like '54444%' ";
            break;
        case '1125':
            $subscription_db = "mts_JOKEPORTAL";
            $subscription_table = "tbl_jokeportal_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "a.dnis like '5464622'";
            break;
        case '1126':
            $subscription_db = "mts_Regional";
            $subscription_table = "tbl_regional_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_reg_calllog";
            $dnis_str = "a.dnis ='51111'";
            break;
        case '1113':
            $subscription_db = "mts_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "a.dnis like '54646196%'";
            break;
        case '1102':
            $subscription_db = "mts_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "a.dnis not in(546461) and a.dnis not like '%p%'";
            break;
        case '1106':
            $subscription_db = "mts_starclub";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mtv_calllog";
            $dnis_str = "a.dnis IN ('5432155','54321551','54321552','54321553')";
            break;*/
    }

if(!empty($subscription_db))
	{	
/////////////////////// code start for Called in last 3 days ////////////////////////////////////
    $query_3days = "select distinct a.msisdn,a.circle,a.status from " . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.status ='-1' ";

    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '37' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'37','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
////////////////////// code end for Called in last 3 days //////////////////////
////////////////////// code start for Called in last 5 days ////////////////////
$query_5days = "select distinct a.msisdn,a.circle,a.status from " . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.status ='-1'";

    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '38' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {
            $insert_query_5days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'38','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Called in last 5 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Called in last 7 days /////////////////////////////////////
    $query_7days = "select distinct a.msisdn,a.circle,a.status from " . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.status ='-1'";

    $result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '39' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {
            $insert_query_7days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now()," . $s_id . ",'39','" . $details_7days[2] . "')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
////////////////// code end for Called in last 7 days ///////////////////////
////////////////// code start for Called in last 15 days ////////////////////
    $query_15days = "select distinct a.msisdn,a.circle,a.status from " . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.status ='-1'";

    $result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '40' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {
            $insert_query_15days = "insert into honeybee_sms_engagement.tbl_new_engagement_number(ANI,circle,added_on,service_id,type,status)
                       values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now()," . $s_id . ",'40','" . $details_15days[2] . "')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
///////////////////////// code end for Called in last 15 days ///////////////////
}
}//check for empty db
mysql_close($dbConn);
echo "Done";
?>