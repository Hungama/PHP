<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
$serviceArray = array('1501' => 'AirtelEU');

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
    $query_3days = "select distinct a.ani,a.circle,b.status from " . $crbt_db . "." . $crbt_table . " a, " . $subscription_db . "." . $subscription_table . " b
        where  date(a.request_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and b.status in(1,11) and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";

    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '24' and service_id='" . $s_id . "'";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now()," . $s_id . ",'24','" . $details_3days[2] . "')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
}
echo "Done";
?>
   
