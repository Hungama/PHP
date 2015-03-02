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
if ($type == '25') {
//////////////////////////////////////////////// code start for No CRBT Download in 3 days from activation /////////////////////////////////////
    $query_3days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a,mts_radio.tbl_radio_subscription b
    where  date(a.date_time) between DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY) and  a.status=3 and " . $status_info . "
        and date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and a.ani=b.ani";

    $result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

    $result_row_3days = mysql_num_rows($result_3days);

    if ($result_row_3days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '25' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_3days = mysql_fetch_row($result_3days)) {

            $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now(),1101,'25')";
            mysql_query($insert_query_3days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 3 days from activation /////////////////////////////////////
}
if ($type == '26') {
//////////////////////////////////////////////// code start for No CRBT Download in 5 days from activation /////////////////////////////////////
    $query_5days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a,mts_radio.tbl_radio_subscription b
    where  date(a.date_time) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY) and  a.status=3 and " . $status_info . "
        and date(b.sub_date) = DATE(NOW()-INTERVAL 6 DAY) and a.ani=b.ani";

    $result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

    $result_row_5days = mysql_num_rows($result_5days);

    if ($result_row_5days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '26' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_5days = mysql_fetch_row($result_5days)) {

            $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now(),1101,'26')";
            mysql_query($insert_query_5days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 5 days from activation /////////////////////////////////////
}
if ($type == '27') {
//////////////////////////////////////////////// code start for No CRBT Download in 7 days from activation /////////////////////////////////////
    $query_7days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a,mts_radio.tbl_radio_subscription b
    where  date(a.date_time) between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY) and  a.status=3 and " . $status_info . "
        and date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and a.ani=b.ani";

    $result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

    $result_row_7days = mysql_num_rows($result_7days);

    if ($result_row_7days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '27' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_7days = mysql_fetch_row($result_7days)) {

            $insert_query_7days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now(),1101,'27')";
            mysql_query($insert_query_7days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 7 days from activation /////////////////////////////////////
}
if ($type == '28') {
//////////////////////////////////////////////// code start for No CRBT Download in 15 days from activation /////////////////////////////////////
    $query_15days = "select distinct a.ani,a.circle from mts_radio.tbl_crbtrng_reqs_log a,mts_radio.tbl_radio_subscription b
    where  date(a.date_time) between DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY) and  a.status=3 and " . $status_info . "
        and date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and a.ani=b.ani";

    $result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

    $result_row_15days = mysql_num_rows($result_15days);

    if ($result_row_15days > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '28' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_15days = mysql_fetch_row($result_15days)) {

            $insert_query_15days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now(),1101,'28')";
            mysql_query($insert_query_15days, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for No CRBT Download in 15 days from activation /////////////////////////////////////
}
echo "Done";
?>
   
