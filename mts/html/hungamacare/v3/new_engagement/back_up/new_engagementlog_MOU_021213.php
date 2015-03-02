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
if ($type == '1') {
//////////////////////////////////////////////// code start for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
    $query = "select distinct a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and " . $status_info . "  group by a.msisdn having 
            sum(duration_in_sec) <600 ";
    $result = mysql_query($query, $dbConn) or die(mysql_error());

    $result_row = mysql_num_rows($result);

    if ($result_row > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '1' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details = mysql_fetch_row($result)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),1101,'1')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Less than 10 MOUS in last 10 days ////////////////////////////////////////////////////////
}
if ($type == '2') {
//////////////////////////////////////////////// code start for More than 10, But less than 30 MOUS  in last 10 days ////////////////////////////////////////////////////////
    $query_1030MOU = "select distinct a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a where a.dnis like '52222%' 
    and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and " . $status_info . " 
            group by a.msisdn having sum(duration_in_sec) between 600 and 1800 ";

    $result_1030MOU = mysql_query($query_1030MOU, $dbConn) or die(mysql_error());

    $result_row_1030MOU = mysql_num_rows($result_1030MOU);

    if ($result_row_1030MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '2' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_1030MOU = mysql_fetch_row($result_1030MOU)) {
            $insert_query_1030MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details_1030MOU[0] . ",'" . $details_1030MOU[1] . "',now(),1101,'2')";
            mysql_query($insert_query_1030MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 10, But less than 30 MOUS  in last 10 days /////////////////////////////////////
}
if ($type == '3') {
//////////////////////////////////////////////// code start for More than 30 MOUS in last 10 days /////////////////////////////////////
    $query_G30MOU = "select distinct a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a 
    where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 10 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and " . $status_info . "
            group by a.msisdn having sum(duration_in_sec) >1800 ";

    $result_G30MOU = mysql_query($query_G30MOU, $dbConn) or die(mysql_error());

    $result_row_G30MOU = mysql_num_rows($result_G30MOU);

    if ($result_row_G30MOU > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '3' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_G30MOU = mysql_fetch_row($result_G30MOU)) {
            $insert_query_G30MOU = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_G30MOU[0] . ",'" . $details_G30MOU[1] . "',now(),1101,'3')";
            mysql_query($insert_query_G30MOU, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for More than 30 MOUS in last 10 days /////////////////////////////////////
}
if ($type == '4') {
//////////////////////////////////////////////// code start for Usage less than 5 mins in last 1 day /////////////////////////////////////
    $query_L5 = "select distinct a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and " . $status_info . " 
            group by a.msisdn having sum(duration_in_sec) <300 ";

    $result_L5 = mysql_query($query_L5, $dbConn) or die(mysql_error());

    $result_row_L5 = mysql_num_rows($result_L5);

    if ($result_row_L5 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '4' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_L5 = mysql_fetch_row($result_L5)) {
            $insert_query_L5 = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details_L5[0] . ",'" . $details_L5[1] . "',now(),1101,'4')";
            mysql_query($insert_query_L5, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage less than 5 mins in last 1 day /////////////////////////////////////
}
if ($type == '5') {
//////////////////////////////////////////////// code start for Usage more than 20 mins in last 1 day /////////////////////////////////////
    $query_G20 = "select distinct a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and " . $status_info . "  group by a.msisdn having 
            sum(duration_in_sec) >1200 ";

    $result_G20 = mysql_query($query_G20, $dbConn) or die(mysql_error());

    $result_row_G20 = mysql_num_rows($result_G20);

    if ($result_row_G20 > 0) {
        $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '5' and service_id=1101";
        mysql_query($delete_query, $dbConn);
        while ($details_G20 = mysql_fetch_row($result_G20)) {
            $insert_query = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details_G20[0] . ",'" . $details_G20[1] . "',now(),1101,'5')";
            mysql_query($insert_query, $dbConn);
        }
    }
//////////////////////////////////////////////// code end for Usage more than 20 mins in last 1 day /////////////////////////////////////
}
echo "Done";
?>
    