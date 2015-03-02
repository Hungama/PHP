<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

$serviceArray = array('1515' => 'AirtelDevo', '1513' => 'AirtelMND', '1517' => 'AirtelSE', '1502' => 'Airtel54646', 'AirtelMNDKK' => 'AirtelMNDKK', '1511' => 'AirtelGL', '1518' => 'AirtelComedy');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1515':
            $subscription_db = "airtel_devo";
            $subscription_table = "tbl_devo_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_devotional_calllog";
            $dnis_str = "dnis like '51050%'";
            break;
        case '1513':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "dnis IN ('5500196','54646196','55001961','55001962','55001963','55001964','55001965')";
            break;
        case '1517':
            $subscription_db = "airtel_SPKENG";
            $subscription_table = "tbl_spkeng_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_SPKNG_calllog";
            $dnis_str = "dnis like '571811%'";
            break;
        case '1502':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_jbox_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis like '54646%' and dnis not in('546461','546461000','5464612','54646169') and dnis not like '%p%'";
            break;
        case 'MNDKK':
            $subscription_db = "airtel_mnd";
            $subscription_table = "tbl_character_subscription1";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_mnd_calllog";
            $dnis_str = "dnis IN ('54646196') and circle IN ('KAR')";
            break;
        case '1511':
            $subscription_db = "airtel_rasoi";
            $subscription_table = "tbl_rasoi_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_ldr_calllog";
            $dnis_str = "dnis=55001";
            break;
        case '1518':
            $subscription_db = "airtel_hungama";
            $subscription_table = "tbl_comedyportal_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_54646_calllog";
            $dnis_str = "dnis=5464612";
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
            values (" . $details_0to5days[0] . ",'" . $details_0to5days[1] . "',now(),'" . $s_id . "','18','" . $details_0to5days[2] . "')";
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
            values (" . $details_5to10days[0] . ",'" . $details_5to10days[1] . "',now(),'" . $s_id . "','19','" . $details_5to10days[2] . "')";
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
            values (" . $details_10to20days[0] . ",'" . $details_10to20days[1] . "',now(),'" . $s_id . "','20','" . $details_10to20days[2] . "')";
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
            values (" . $details_20to30days[0] . ",'" . $details_20to30days[1] . "',now(),'" . $s_id . "','21','" . $details_20to30days[2] . "')";
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
            values (" . $details_G30days[0] . ",'" . $details_G30days[1] . "',now(),'" . $s_id . "','22','" . $details_G30days[2] . "')";
            mysql_query($insert_query_G30days, $dbConn);
        }
    }
///////////////////////////////////////////// End Code For More than 30 days  /////////////////////////////////////////////////
}
echo "Done";
?>
   
