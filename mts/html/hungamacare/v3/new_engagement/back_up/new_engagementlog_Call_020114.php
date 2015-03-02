<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

//////////////////////////////////////////////// code start for Called in last 1 day /////////////////////////////////////
echo $query_1days = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11)";

$result_1days = mysql_query($query_1days, $dbConn) or die(mysql_error());

$result_row_1days = mysql_num_rows($result_1days);

if ($result_row_1days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '6' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_1days = mysql_fetch_row($result_1days)) {

        $insert_query_1days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_1days[0] . ",'" . $details_1days[1] . "',now(),1101,'6','" . $details_1days[2] . "')";
        mysql_query($insert_query_1days, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Called in last 3 days /////////////////////////////////////
echo $query_3days = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11)";

$result_3days = mysql_query($query_3days, $dbConn) or die(mysql_error());

$result_row_3days = mysql_num_rows($result_3days);

if ($result_row_3days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '7' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_3days = mysql_fetch_row($result_3days)) {
        $insert_query_3days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_3days[0] . ",'" . $details_3days[1] . "',now(),1101,'7','" . $details_3days[2] . "')";
        mysql_query($insert_query_3days, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called in last 3 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Called in last 5 days /////////////////////////////////////
echo $query_5days = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 5 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11)";

$result_5days = mysql_query($query_5days, $dbConn) or die(mysql_error());

$result_row_5days = mysql_num_rows($result_5days);

if ($result_row_5days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '8' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_5days = mysql_fetch_row($result_5days)) {
        $insert_query_5days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_5days[0] . ",'" . $details_5days[1] . "',now(),1101,'8','" . $details_5days[2] . "')";
        mysql_query($insert_query_5days, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called in last 5 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Called in last 7 days /////////////////////////////////////
echo $query_7days = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11)";

$result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

$result_row_7days = mysql_num_rows($result_7days);

if ($result_row_7days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '9' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_7days = mysql_fetch_row($result_7days)) {
        $insert_query_7days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_7days[0] . ",'" . $details_7days[1] . "',now(),1101,'9','" . $details_7days[2] . "')";
        mysql_query($insert_query_7days, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called in last 7 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Called in last 15 days /////////////////////////////////////
echo $query_15days = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11)";

$result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

$result_row_15days = mysql_num_rows($result_15days);

if ($result_row_15days > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '10' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_15days = mysql_fetch_row($result_15days)) {
        $insert_query_15days = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status)
                       values (" . $details_15days[0] . ",'" . $details_15days[1] . "',now(),1101,'10','" . $details_15days[2] . "')";
        mysql_query($insert_query_15days, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called in last 15 days /////////////////////////////////////
//////////////////////////////////////////////// code start for Called more than 2 times in last 1 day /////////////////////////////////////
echo $query_G2times = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11) group by a.msisdn having count(a.msisdn) > 2";

$result_G2times = mysql_query($query_G2times, $dbConn) or die(mysql_error());

$result_row_G2times = mysql_num_rows($result_G2times);

if ($result_row_G2times > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '11' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G2times = mysql_fetch_row($result_G2times)) {

        $insert_query_G2times = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G2times[0] . ",'" . $details_G2times[1] . "',now(),1101,'11','" . $details_G2times[2] . "')";
        mysql_query($insert_query_G2times, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called more than 2 times in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Called more than 4 times in last 1 day /////////////////////////////////////
echo $query_G4times = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11) group by a.msisdn having count(a.msisdn) > 4";

$result_G4times = mysql_query($query_G4times, $dbConn) or die(mysql_error());

$result_row_G4times = mysql_num_rows($result_G4times);

if ($result_row_G4times > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '12' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G4times = mysql_fetch_row($result_G4times)) {

        $insert_query_G4times = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G4times[0] . ",'" . $details_G4times[1] . "',now(),1101,'12','" . $details_G4times[2] . "')";
        mysql_query($insert_query_G4times, $dbConn);
    }
}
//////////////////////////////////////////////// code end for Called more than 4 times in last 1 day /////////////////////////////////////
//////////////////////////////////////////////// code start for Called more than 6 times in last 1 day /////////////////////////////////////
echo $query_G6times = "select distinct a.msisdn,b.circle,b.status from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) = DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status in(1,11) group by a.msisdn having count(a.msisdn) > 6";

$result_G6times = mysql_query($query_G6times, $dbConn) or die(mysql_error());

$result_row_G6times = mysql_num_rows($result_G6times);

if ($result_row_G6times > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_number where date(added_on) = date(now()) and type = '13' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G6times = mysql_fetch_row($result_G6times)) {

        $insert_query_G6times = "insert into master_db.tbl_new_engagement_number (ANI,circle,added_on,service_id,type,status) 
            values (" . $details_G6times[0] . ",'" . $details_G6times[1] . "',now(),1101,'13','" . $details_G6times[2] . "')";
        mysql_query($insert_query_G6times, $dbConn);
    }
}
///////////////////////////////////////////////// code end for Called more than 6 times in last 1 day ///////////////////////////////////////////////

echo "Done";
?>
   
