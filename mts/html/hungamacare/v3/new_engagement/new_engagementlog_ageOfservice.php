<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$serviceArray = array('1101' => 'MTS - muZic Unlimited', '1111' => 'MTS - Bhakti Sagar', '1123' => 'MTS - Monsoon Dhamaka', '1110' => 'MTS - Red FM',
    '1116' => 'MTS - Voice Alerts', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTSReg', '1113' => 'MTS - MPD', '1102' => 'MTS - 54646', '1106' => 'MTSFMJ');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1101':
            //$subscription_db = "mts_radio";
            //$subscription_table = "tbl_radio_subscription";
			$subscription_db = "mts_mu";
            $subscription_table = "tbl_HB_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_radio_calllog";
            $dnis_str = "dnis like '52222%'";
            break;
        case '1111':
            $subscription_db = "dm_radio";
            $subscription_table = "tbl_digi_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_Devotional_calllog";
            $dnis_str = "dnis like '5432105%'";
            break;
        case '1123':
            $subscription_db = "Mts_summer_contest";
            $subscription_table = "tbl_contest_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mtv_calllog";
            $dnis_str = "dnis like '55333%'";
            break;
        case '1110':
            $subscription_db = "mts_redfm";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_redfm_calllog";
            $dnis_str = "dnis='55935'";
            break;
        case '1116':
            $subscription_db = "mts_voicealert";
            $subscription_table = "tbl_voice_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_voicealert_calllog";
            $dnis_str = "dnis like '54444%' ";
            break;
        case '1125':
            $subscription_db = "mts_JOKEPORTAL";
            $subscription_table = "tbl_jokeportal_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis like '5464622'";
            break;
        case '1126':
            $subscription_db = "mts_Regional";
            $subscription_table = "tbl_regional_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_reg_calllog";
            $dnis_str = "dnis ='51111'";
            break;
        case '1113':
            $subscription_db = "mts_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis like '54646196%'";
            break;
        case '1102':
            $subscription_db = "mts_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis not in(546461) and dnis not like '%p%'";
            break;
        case '1106':
            $subscription_db = "mts_starclub";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mtv_calllog";
            $dnis_str = "dnis IN ('5432155','54321551','54321552','54321553')";
            break;
    }
///////////////////////////////////////////// Start Code For 0-5 days  ///////////////////////////////////////////////////////////////////////////////////////
    $query_0to5days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from " . $subscription_db . "." . $subscription_table . "  where status in(1,11)
                   and " . $dnis_str . " GROUP BY  ANI HAVING diff>=0 and diff<=5";
    $result_0to5days = mysql_query($query_0to5days, $dbConn) or die(mysql_error());

    $result_row_0to5days = mysql_num_rows($result_0to5days);

    if ($result_row_0to5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '18' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_0to5days = mysql_fetch_row($result_0to5days)) {
            $insert_query_0to5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now()," . $s_id . ",'18','" . $details_0to5days[2] . "')";
            mysql_query($insert_query_0to5days, $dbConn);
        }
    }
///////////////////////////////////////////// end Code For 0-5 days  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 5-10 days  ////////////////////////////////////////////////////////
    $query_5to10days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from " . $subscription_db . "." . $subscription_table . " where status in(1,11)
                   and " . $dnis_str . " GROUP BY  ANI HAVING diff>=5 and diff<=10";
    $result_5to10days = mysql_query($query_5to10days, $dbConn) or die(mysql_error());

    $result_row_5to10days = mysql_num_rows($result_5to10days);

    if ($result_row_5to10days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '19' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5to10days = mysql_fetch_row($result_5to10days)) {
            $insert_query_5to10days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_5to10days[0] . ",'" . $details_5to10days[1] . "',now()," . $s_id . ",'19','" . $details_5to10days[2] . "')";
            mysql_query($insert_query_5to10days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For 5-10 days  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 10-20 days  ////////////////////////////////////////////////////////
    $query_10to20days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from " . $subscription_db . "." . $subscription_table . " where status in(1,11)
                   and " . $dnis_str . " GROUP BY  ANI HAVING diff>=10 and diff<=20";
    $result_10to20days = mysql_query($query_10to20days, $dbConn) or die(mysql_error());

    $result_row_10to20days = mysql_num_rows($result_10to20days);

    if ($result_row_10to20days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '20' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_10to20days = mysql_fetch_row($result_10to20days)) {
            $insert_query_10to20days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_10to20days[0] . ",'" . $details_10to20days[1] . "',now()," . $s_id . ",'20','" . $details_10to20days[2] . "')";
            mysql_query($insert_query_10to20days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For 10-20 days  ////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For 20-30 days ////////////////////////////////////////////////
    $query_20to30days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from " . $subscription_db . "." . $subscription_table . " where status in(1,11)
                   and " . $dnis_str . " GROUP BY  ANI HAVING diff>=20 and diff<=30";
    $result_20to30days = mysql_query($query_20to30days, $dbConn) or die(mysql_error());

    $result_row_20to30days = mysql_num_rows($result_20to30days);

    if ($result_row_20to30days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '21' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_20to30days = mysql_fetch_row($result_20to30days)) {
            $insert_query_20to30days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_20to30days[0] . ",'" . $details_20to30days[1] . "',now()," . $s_id . ",'21','" . $details_20to30days[2] . "')";
            mysql_query($insert_query_20to30days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For 20-30 days  /////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For More than 30 days ////////////////////////////////////////////////
    $query_G30days = "select ANI,circle,status, SUB_DATE,DATEDIFF(now(),Sub_date ) as diff from " . $subscription_db . "." . $subscription_table . " where status in(1,11)
                   and " . $dnis_str . " GROUP BY  ANI HAVING diff>=30";
    $result_G30days = mysql_query($query_G30days, $dbConn) or die(mysql_error());

    $result_row_G30days = mysql_num_rows($result_G30days);

    if ($result_row_G30days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '22' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_G30days = mysql_fetch_row($result_G30days)) {
            $insert_query_G30days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G30days[0] . ",'" . $details_G30days[1] . "',now()," . $s_id . ",'22','" . $details_G30days[2] . "')";
            mysql_query($insert_query_G30days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For More than 30 days  /////////////////////////////////////////////////
}
echo "Done- Age Of service data--";
mysql_close($dbConn);
?>