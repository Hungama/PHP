<?php
include ("/var/www/html/hungamacare/config/dbConnect.php");
$serviceArray = array('1101' => 'MTS - muZic Unlimited', '1111' => 'MTS - Bhakti Sagar', '1123' => 'MTS - Monsoon Dhamaka', '1110' => 'MTS - Red FM',
    '1116' => 'MTS - Voice Alerts', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTSReg', '1113' => 'MTS - MPD', '1102' => 'MTS - 54646', '1106' => 'MTSFMJ');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1101':
           // $subscription_db = "mts_radio";
           // $subscription_table = "tbl_radio_subscription";
			$subscription_db = "mts_mu";
            $subscription_table = "tbl_HB_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_radio_calllog";
            $dnis_str = "a.dnis like '52222%'";
            break;
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
            break;
    }

//////////////////////////////////////////////// code start for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
    $query = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani  and b.status in(1,11) group by a.msisdn having 
            sum(duration_in_sec) <600 ";
    $result = mysql_query($query, $dbConn) or die(mysql_error());

    $result_row = mysql_num_rows($result);

    if ($result_row > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '1' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details = mysql_fetch_row($result)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now()," . $s_id . ",'1','" . $details[2] . "')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
//////////////////////////////////////////////// code start for More than 10, But less than 30 MOUS  in last 10 days ////////////////////////////////////////////////////////
    $query_1030MOU = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
        where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status in(1,11)
            group by a.msisdn having sum(duration_in_sec) between 600 and 1800 ";

    $result_1030MOU = mysql_query($query_1030MOU, $dbConn) or die(mysql_error());

    $result_row_1030MOU = mysql_num_rows($result_1030MOU);

    if ($result_row_1030MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '2' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1030MOU = mysql_fetch_row($result_1030MOU)) {
            $insert_query_1030MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_1030MOU[0] . ",'" . $details_1030MOU[1] . "',now()," . $s_id . ",'2','" . $details_1030MOU[2] . "')";
            mysql_query($insert_query_1030MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 10, But less than 30 MOUS  in last 10 days /////////////////////////////////////
//////////////////////////////////////////////// code start for More than 30 MOUS in last 10 days /////////////////////////////////////
    $query_G30MOU = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
    where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status in(1,11)
            group by a.msisdn having sum(duration_in_sec) >1800 ";

    $result_G30MOU = mysql_query($query_G30MOU, $dbConn) or die(mysql_error());

    $result_row_G30MOU = mysql_num_rows($result_G30MOU);

    if ($result_row_G30MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '3' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_G30MOU = mysql_fetch_row($result_G30MOU)) {
            $insert_query_G30MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G30MOU[0] . ",'" . $details_G30MOU[1] . "',now()," . $s_id . ",'3','" . $details_G30MOU[2] . "')";
            mysql_query($insert_query_G30MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 30 MOUS in last 10 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Usage less than 5 mins in last 1 day /////////////////////////////////////
    $query_L5 = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani
            and b.status in(1,11) group by a.msisdn having sum(duration_in_sec) <300 ";

    $result_L5 = mysql_query($query_L5, $dbConn) or die(mysql_error());

    $result_row_L5 = mysql_num_rows($result_L5);

    if ($result_row_L5 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '4' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_L5 = mysql_fetch_row($result_L5)) {
            $insert_query_L5 = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_L5[0] . ",'" . $details_L5[1] . "',now()," . $s_id . ",'4','" . $details_L5[2] . "')";
            mysql_query($insert_query_L5, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage less than 5 mins in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Usage more than 20 mins in last 1 day /////////////////////////////////////
		$query_G20 = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani  and b.status in(1,11) group by a.msisdn having 
            sum(duration_in_sec) >1200 ";

    $result_G20 = mysql_query($query_G20, $dbConn) or die(mysql_error());

    $result_row_G20 = mysql_num_rows($result_G20);

    if ($result_row_G20 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '5' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_G20 = mysql_fetch_row($result_G20)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_G20[0] . ",'" . $details_G20[1] . "',now()," . $s_id . ",'5','" . $details_G20[2] . "')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage more than 20 mins in last 1 day /////////////////////////////////////
}
mysql_close($dbConn);
echo "Done-MOU data ..";
?>  