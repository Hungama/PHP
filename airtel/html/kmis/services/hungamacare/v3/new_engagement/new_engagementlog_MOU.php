<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
//////////////////////////////////////////////////////// delete back date code start here @jyoti.porwal /////////////////////////////////////////////////
$delete_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
echo $deleteprevioousdata = "delete from master_db.tbl_new_engagement_number where date(added_on)='$delete_date'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
//////////////////////////////////////////////////////// delete back date code end here @jyoti.porwal /////////////////////////////////////////////////
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

//////////////////////////////////////////////// code start for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
    echo $query = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani  and b.status in(1,11) group by a.msisdn having 
            sum(duration_in_sec) <600 ";
    $result = mysql_query($query, $dbConn) or die(mysql_error());

    $result_row = mysql_num_rows($result);

    if ($result_row > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '1' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details = mysql_fetch_row($result)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),'" . $s_id . "','1','" . $details[2] . "')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
//////////////////////////////////////////////// code start for More than 10, But less than 30 MOUS  in last 10 days ////////////////////////////////////////////////////////
    echo $query_1030MOU = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
        where " . $dnis_str . " and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status in(1,11)
            group by a.msisdn having sum(duration_in_sec) between 600 and 1800 ";

    $result_1030MOU = mysql_query($query_1030MOU, $dbConn) or die(mysql_error());

    $result_row_1030MOU = mysql_num_rows($result_1030MOU);

    if ($result_row_1030MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '2' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1030MOU = mysql_fetch_row($result_1030MOU)) {
            $insert_query_1030MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_1030MOU[0] . ",'" . $details_1030MOU[1] . "',now(),'" . $s_id . "','2','" . $details_1030MOU[2] . "')";
            mysql_query($insert_query_1030MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 10, But less than 30 MOUS  in last 10 days /////////////////////////////////////
//////////////////////////////////////////////// code start for More than 30 MOUS in last 10 days /////////////////////////////////////
    echo $query_G30MOU = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
    where " . $dnis_str . " and a.operator in ('airm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status in(1,11)
            group by a.msisdn having sum(duration_in_sec) >1800 ";

    $result_G30MOU = mysql_query($query_G30MOU, $dbConn) or die(mysql_error());

    $result_row_G30MOU = mysql_num_rows($result_G30MOU);

    if ($result_row_G30MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '3' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_G30MOU = mysql_fetch_row($result_G30MOU)) {
            $insert_query_G30MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G30MOU[0] . ",'" . $details_G30MOU[1] . "',now(),'" . $s_id . "','3','" . $details_G30MOU[2] . "')";
            mysql_query($insert_query_G30MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 30 MOUS in last 10 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Usage less than 5 mins in last 1 day /////////////////////////////////////
    echo $query_L5 = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('airm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani
            and b.status in(1,11) group by a.msisdn having sum(duration_in_sec) <300 ";

    $result_L5 = mysql_query($query_L5, $dbConn) or die(mysql_error());

    $result_row_L5 = mysql_num_rows($result_L5);

    if ($result_row_L5 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '4' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_L5 = mysql_fetch_row($result_L5)) {
            $insert_query_L5 = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_L5[0] . ",'" . $details_L5[1] . "',now(),'" . $s_id . "','4','" . $details_L5[2] . "')";
            mysql_query($insert_query_L5, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage less than 5 mins in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Usage more than 20 mins in last 1 day /////////////////////////////////////
    echo $query_G20 = "select distinct a.msisdn,b.circle,b.status from " . $subscription_db . "." . $subscription_table . " b ," . $calllog_db . "." . $calllog_table . " a
            where " . $dnis_str . " and a.operator in ('airm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani  and b.status in(1,11) group by a.msisdn having 
            sum(duration_in_sec) >1200 ";

    $result_G20 = mysql_query($query_G20, $dbConn) or die(mysql_error());

    $result_row_G20 = mysql_num_rows($result_G20);

    if ($result_row_G20 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '5' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_G20 = mysql_fetch_row($result_G20)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
						   values (" . $details_G20[0] . ",'" . $details_G20[1] . "',now(),'" . $s_id . "','5','" . $details_G20[2] . "')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage more than 20 mins in last 1 day /////////////////////////////////////
}
echo "Done";
?>
    