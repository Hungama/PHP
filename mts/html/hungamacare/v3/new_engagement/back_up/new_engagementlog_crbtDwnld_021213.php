<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$status = 'active';
if ($status == 'active') {
    $status_info = "b.status=1";
} else if ($status == 'pending') {
    $status_info = "b.status=11";
} else {
    $status_info = "b.status in(1,11)";
}
$type = $_REQUEST['type'];
if ($type == '23') {
//////////////////////////////////////////////// code start for Downloaded/changed 1 or more CRBT in last 1 day /////////////////////////////////////
    $query_1days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a, mts_radio.tbl_radio_subscription b
                where  date(a.date_time) = DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and " . $status_info . " and a.ani=b.ani";

    $result_1days = mysql_query($query_1days, $dbConn) or die(mysql_error());

    $result_row_1days = mysql_num_rows($result_1days);

    if ($result_row_1days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '23' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_1days = mysql_fetch_row($result_1days)) {

            $insert_query_1days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_1days[0] . ",'" . $details_1days[1] . "',now(),1101,'23')";
            mysql_query($insert_query_1days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded/changed 1 or more CRBT in last 1 day /////////////////////////////////////
}
if ($type == '24') {
//////////////////////////////////////////////// code start for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
    $query_3days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a,mts_radio.tbl_radio_subscription b  where  date(date_time) 
                between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.status= 1 and " . $status_info . " and a.ani=b.ani
                    group by a.ani having count(a.ani) >= 2";

    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '24' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {
            $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type)
                       values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now(),1101,'24')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Downloaded 2 or more CRBT in last 5 day /////////////////////////////////////
}
echo "Done";
?>
   
