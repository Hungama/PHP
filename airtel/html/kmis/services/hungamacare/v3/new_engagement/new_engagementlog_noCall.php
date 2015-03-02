<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

$serviceArray = array('1515' => 'AirtelDevo', '1513' => 'AirtelMND', '1517' => 'AirtelSE', '1502' => 'Airtel54646', 'AirtelMNDKK' => 'AirtelMNDKK', 
    '1511' => 'AirtelGL', '1518' => 'AirtelComedy', '1501' => 'AirtelEU');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1515':
            $subscription_db = "airtel_devo";
            $subscription_table = "tbl_devo_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_devotional_calllog";
            $dnis_str = "a.dnis like '51050%'";
            break;
        case '1513':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "a.dnis IN ('5500196','54646196','55001961','55001962','55001963','55001964','55001965')";
            break;
        case '1517':
            $subscription_db = "airtel_SPKENG";
            $subscription_table = "tbl_spkeng_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_SPKNG_calllog";
            $dnis_str = "a.dnis like '571811%'";
            break;
        case '1502':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "a.dnis like '54646%' and a.dnis not in('546461','546461000','5464612','54646169') and a.dnis not like '%p%'";
            break;
        case 'MNDKK':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "a.dnis IN ('54646196') and a.circle IN ('KAR')";
            break;
        case '1511':
            $subscription_db = "airtel_rasoi";
            $subscription_table = "tbl_rasoi_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_ldr_calllog";
            $dnis_str = "a.dnis=55001";
            break;
        case '1518':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_comedyportal_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "a.dnis=5464612";
            break;
        case '1501':
            $subscription_db = "airtel_radio";
            $subscription_table = "tbl_radio_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_AMU_calllog";
            $dnis_str = "a.dnis like '546469%'";
            break;
    }
///////////////////////////////////////////// Start Code For Not called in 3 days from activation  ///////////////////////////////////////////////////////////////////////////////////////
    echo $query_3days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and b.status in(1,11) ";

    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '14' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now(),'" . $s_id . "','14','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
///////////////////////////////////////////// end Code For Not called in 3 days from activation  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For Not called in 5 days from activation  ////////////////////////////////////////////////////////
    echo $query_5days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and b.status in(1,11)";

    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '15' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {
            $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now(),'" . $s_id . "','15','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For Not called in 5 days from activation  ////////////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For Not called in 7 days from activation  ////////////////////////////////////////////////////////
    echo $query_7days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and b.status in(1,11)";

    $result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '16' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {
            $insert_query_7days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now(),'" . $s_id . "','16','" . $details_7days[2] . "')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For Not called in 7 days from activation  ////////////////////////////////////////////////
///////////////////////////////////////////// Start Code For Not called in 15 days from activation  ////////////////////////////////////////////////
    echo $query_15days = "select distinct ani,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b 
where not exists(select a.msisdn from " . $calllog_db . "." . $calllog_table . " a where " . $dnis_str . "
and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and
date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and b.status in(1,11)";

    $result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '17' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {
            $insert_query_15days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now(),'" . $s_id . "','17','" . $details_15days[2] . "')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For Not called in 15 days from activation  /////////////////////////////////////////////////
}
echo "Done";
?>
   
