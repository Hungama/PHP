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
       /* case '1111':
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
//////////////////// Start Code For Not called in 3 days from activation ////////////////////////
$query_3days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and b.status in(1,11) ";

    $result_3days = mysql_query($query_3days, $dbConn);

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '14' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'14','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
/////////////// end Code For Not called in 3 days from activation  ////////////////////////
///////////// Start Code For Not called in 5 days from activation  ////////////////////
$query_5days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and b.status in(1,11)";

$result_5days = mysql_query($query_5days, $dbConn);

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '15' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {
            $insert_query_5days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'15','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
/////////////// End Code For Not called in 5 days from activation  //////////////////////////
///////////////// Start Code For Not called in 7 days from activation  ////////////////////
$query_7days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and b.status in(1,11)";

    $result_7days = mysql_query($query_7days, $dbConn);

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '16' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {
            $insert_query_7days = "insert into honeybee_sms_engagement.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now()," . $s_id . ",'16','" . $details_7days[2] . "')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
////////////// End Code For Not called in 7 days from activation  //////////////
//////////////// Start Code For Not called in 15 days from activation  ///////////
$query_15days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and b.status in(1,11)";

    $result_15days = mysql_query($query_15days, $dbConn);

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from honeybee_sms_engagement.tbl_new_engagement_number where date(added_on) = date(now()) and type = '17' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {
            $insert_query_15days = "insert into honeybee_sms_engagement.tbl_new_engagement_number(ANI,circle,added_on,service_id,type,status)
                       values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now()," . $s_id . ",'17','" . $details_15days[2] . "')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
///////////////// End Code For Not called in 15 days from activation  /////////////////

}//check for empty db name
}
mysql_close($dbConn);
echo "Done";
?>