<?php

include ("/var/www/html/hungamacare/2.0/incs/db.php");
$serviceArray = array('1301' => 'RadioUnlimited', '1302' => '54646');

foreach ($serviceArray as $s_id => $s_val) {
    switch ($s_id) {
        case '1501':
            $subscription_db = "airtel_radio";
            $subscription_table = "tbl_radio_subscription";
            $calllog_db = "mis_db";
            $calllog_table = "tbl_AMU_calllog";
            $dnis_str = "a.dnis like '546469%'";
            $crbt_db = "master_db";
            $crbt_table = "tbl_crbt_download";
            break;
    }
//////////////////////////////////////////////// code start for Downloaded/changed 1 or more CRBT in last 1 day /////////////////////////////////////
    $query_1days = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
                where  date(a.request_date) = DATE(NOW()-INTERVAL 1 DAY) and (a.response= 0 or a.response='OK') and b.status in(1,11) and a.ani=b.ani";

    $result_1days = mysql_query($query_1days, $dbConn) or die(mysql_error());

    $result_row_1days = mysql_num_rows($result_1days);

    if ($result_row_1days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '23' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1days = mysql_fetch_row($result_1days)) {

            $insert_query_1days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_1days[0] . ",'" . $details_1days[1] . "',now()," . $s_id . ",'23','" . $details_1days[2] . "')";
            mysql_query($insert_query_1days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded/changed 1 or more CRBT in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
    $query_5days = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
        where  date(a.request_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and b.status in(1,11) and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";

    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '24' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {
            $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now()," . $s_id . ",'24','" . $details_5days[2] . "')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
    //////////////////////////////////////////////// code start for Downloaded/changed 1 or more CRBT in last 1 day but falied by @jyotiPorwal/////////////////////////////////////
    $query_1Fdays = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
                where  date(a.request_date) = DATE(NOW()-INTERVAL 1 DAY) and (a.response != 0 or a.response !='OK') and b.status in(1,11) and a.ani=b.ani";

    $result_1Fdays = mysql_query($query_1Fdays, $dbConn) or die(mysql_error());

    $result_row_1Fdays = mysql_num_rows($result_1Fdays);

    if ($result_row_1Fdays > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '37' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_1Fdays = mysql_fetch_row($result_1Fdays)) {

            $insert_query_1Fdays = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_1Fdays[0] . ",'" . $details_1Fdays[1] . "',now()," . $s_id . ",'37','" . $details_1Fdays[2] . "')";
            mysql_query($insert_query_1Fdays, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded/changed 1 or more CRBT in last 1 day but falied by @jyotiPorwal/////////////////////////////////////
//////////////////////////////////////////////// code start for Downloaded 2 or more CRBT in last 5 day but falied by @jyotiPorwal/////////////////////////////////////
//    $query_5Fdays = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
//        where  date(a.request_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and (a.response != 0 or a.response !='OK')
//        and b.status in(1,11) and a.ani=b.ani group by a.ani having count(a.ani) >= 2";
//
//    $result_5Fdays = mysql_query($query_5Fdays, $dbConn) or die(mysql_error());
//
//    $result_row_5Fdays = mysql_num_rows($result_5Fdays);
//
//    if ($result_row_5Fdays > 0) {
//        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '24' and service_id='" . $s_id . "'";
//        mysql_query($delete_query, $dbConn);
//        while ($details_5Fdays = mysql_fetch_row($result_5Fdays)) {
//            $insert_query_5Fdays = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
//                       values (" . $details_5Fdays[0] . ",'" . $details_5Fdays[1] . "',now()," . $s_id . ",'24','" . $details_5Fdays[2] . "')";
//            mysql_query($insert_query_5Fdays, $dbConn);
//        }
//    }
//////////////////////////////////////////////// code end for Downloaded 2 or more CRBT in last 5 day but falied by @jyotiPorwal/////////////////////////////////////
}
echo "Done";
?>
   
