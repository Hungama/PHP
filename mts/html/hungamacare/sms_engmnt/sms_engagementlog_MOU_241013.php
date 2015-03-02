<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

$query = "select a.msisdn,d.circle,d.message from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a,master_db.tbl_sms_engagement d 
            where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY) and DATE(NOW()-INTERVAL 1 DAY)
            and a.msisdn=b.ani and b.status=1 and d.status=1 and d.type='0-10 Mous' and d.service_id=1101 and date(d.added_on) = CURDATE() and  
            b.circle=d.circle  and b.ani in ('9667890489','9143844338','8693945793','8925332082','8459780905','9142112398') group by a.msisdn having 
            sum(duration_in_sec) <600 ";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '0-10 Mous' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type)
						   values (" . $details[0] . ",'" . $details[1] . "','" . $details[2] . "'," . "now(),1101,0,'0-10 Mous')";
        mysql_query($insert_query, $dbConn);
    }
}

$query_1030MOU = "select a.msisdn,d.circle,d.message from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a,
            master_db.tbl_sms_engagement d where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status=1 and d.status=1 and d.type='10-30 Mous' and d.service_id=1101  
            and date(d.added_on) = CURDATE() and b.circle=d.circle and b.ani in ('9667890489','9143844338','8693945793','8925332082','8459780905','9142112398')
            group by a.msisdn having sum(duration_in_sec) between 600 and 1800 ";

$result_1030MOU = mysql_query($query_1030MOU, $dbConn) or die(mysql_error());

$result_row_1030MOU = mysql_num_rows($result_1030MOU);

if ($result_row_1030MOU > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '10-30 Mous' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_1030MOU = mysql_fetch_row($result_1030MOU)) {
        $insert_query_1030MOU = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type)
						   values (" . $details_1030MOU[0] . ",'" . $details_1030MOU[1] . "','" . $details_1030MOU[2] . "'," . "now(),1101,0,'10-30 Mous')";
        mysql_query($insert_query_1030MOU, $dbConn);
    }
}

$query_G30MOU = "select a.msisdn,d.circle,d.message from mts_radio.tbl_radio_subscription b ,mis_db.tbl_radio_calllog a,
            master_db.tbl_sms_engagement d where a.dnis like '52222%' and a.operator in ('mtsm') and date(a.call_date) between DATE(NOW()-INTERVAL 11 DAY)
            and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani and b.status=1 and d.status=1 and d.type='>30 Mous' and d.service_id=1101 
            and date(d.added_on) = CURDATE() and b.circle=d.circle and b.ani in ('9667890489','9143844338','8693945793','8925332082','8459780905','9142112398')
            group by a.msisdn having sum(duration_in_sec) >1800 ";

$result_G30MOU = mysql_query($query_G30MOU, $dbConn) or die(mysql_error());

$result_row_G30MOU = mysql_num_rows($result_G30MOU);

if ($result_row_G30MOU > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '>30 Mous' and service_id=1101";
    mysql_query($delete_query, $dbConn);
    while ($details_G30MOU = mysql_fetch_row($result_G30MOU)) {
        $insert_query_G30MOU = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type) values (" . $details_G30MOU[0] . ",'" . $details_G30MOU[1] . "','" . $details_G30MOU[2] . "'," . "now(),1101,0,'>30 Mous')";
        mysql_query($insert_query_G30MOU, $dbConn);
    }
}
// end call
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
    