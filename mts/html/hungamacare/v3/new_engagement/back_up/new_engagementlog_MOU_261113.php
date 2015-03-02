<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

$query = "select a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status=1  group by a.msisdn having 
            sum(duration_in_sec) <600 ";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_engagement_number where date(added_on) = date(now()) and type = '1' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),1101,'1')";
        mysql_query($insert_query, $dbConn);
    }
}

$query_1030MOU = "select a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a where a.dnis like '52222%' 
    and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status=1 
            group by a.msisdn having sum(duration_in_sec) between 600 and 1800 ";

$result_1030MOU = mysql_query($query_1030MOU, $dbConn) or die(mysql_error());

$result_row_1030MOU = mysql_num_rows($result_1030MOU);

if ($result_row_1030MOU > 0) {
    $delete_query = "delete from master_db.tbl_engagement_number where date(added_on) = date(now()) and type = '2' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_1030MOU = mysql_fetch_row($result_1030MOU)) {
        $insert_query_1030MOU = "insert into master_db.tbl_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details_1030MOU[0] . ",'" . $details_1030MOU[1] . "',now(),1101,'2')";
        mysql_query($insert_query_1030MOU, $dbConn);
    }
}

$query_G30MOU = "select a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a 
    where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status=1 
            group by a.msisdn having sum(duration_in_sec) >1800 ";

$result_G30MOU = mysql_query($query_G30MOU, $dbConn) or die(mysql_error());

$result_row_G30MOU = mysql_num_rows($result_G30MOU);

if ($result_row_G30MOU > 0) {
    $delete_query = "delete from master_db.tbl_engagement_number where date(added_on) = date(now()) and type = '3' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G30MOU = mysql_fetch_row($result_G30MOU)) {
        $insert_query_G30MOU = "insert into master_db.tbl_engagement_number (ANI,circle,added_on,service_id,type) 
            values (" . $details_G30MOU[0] . ",'" . $details_G30MOU[1] . "',now(),1101,'3')";
        mysql_query($insert_query_G30MOU, $dbConn);
    }
}

$query = "select a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status=1  group by a.msisdn having 
            sum(duration_in_sec) <300 ";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_engagement_number where date(added_on) = date(now()) and type = '4' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),1101,'4')";
        mysql_query($insert_query, $dbConn);
    }
}

$query = "select a.msisdn,b.circle from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status=1  group by a.msisdn having 
            sum(duration_in_sec) >1200 ";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_engagement_number where date(added_on) = date(now()) and type = '5' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_engagement_number (ANI,circle,added_on,service_id,type)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),1101,'5')";
        mysql_query($insert_query, $dbConn);
    }
}

echo "Done";
// end call
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
    