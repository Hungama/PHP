<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

///////////////////////////////////////////// Start Code For 1513  ///////////////////////////////////////////////////////////////////////////////////////
$query = "select distinct ani,d.circle,d.message from airtel_mnd.tbl_character_subscription1 b ,master_db.tbl_sms_engagement d where not exists (select 
    a.msisdn from mis_db.tbl_mnd_calllog a where a.dnis in('5500196','54646196','55001961','55001962','55001963','55001964','55001965') and a.operator in ('airm') and date(a.call_date) between 
    DATE(NOW()-INTERVAL 3 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and date(b.sub_date) = DATE(NOW()-INTERVAL 4 DAY) and b.status=1 and
    d.status=1 and d.type='3 days' and d.service_id=1513 and date(d.added_on) = CURDATE() and b.circle=d.circle";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '3 Days' and service_id=1513";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type) values (" . $details[0] . ",'" . $details[1] . "','" . $details[2] . "'," . "now(),1513,0,'3 Days')";
        mysql_query($insert_query, $dbConn);
    }
}


$query_7days = "select distinct ani,d.circle,d.message from airtel_mnd.tbl_character_subscription1 b ,master_db.tbl_sms_engagement d where not exists 
    (select a.msisdn from mis_db.tbl_mnd_calllog a where a.dnis in('5500196','54646196','55001961','55001962','55001963','55001964','55001965') and a.operator in ('airm') and date(a.call_date) 
    between DATE(NOW()-INTERVAL 7 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and date(b.sub_date) = DATE(NOW()-INTERVAL 8 DAY) and b.status=1 
    and d.status=1 and d.type='7 Days' and d.service_id=1513 and date(d.added_on) = CURDATE() and b.circle=d.circle";

$result_7days = mysql_query($query_7days, $dbConn) or die(mysql_error());

$result_row_7days = mysql_num_rows($result_7days);

if ($result_row_7days > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '7 Days' and service_id=1513";
    mysql_query($delete_query, $dbConn);
    while ($details_7days = mysql_fetch_row($result_7days)) {
        $insert_query_7days = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type)
                       values (" . $details_7days[0] . ",'" . $details_7days[1] . "','" . $details_7days[2] . "'," . "now(),1513,0,'7 Days')";
        mysql_query($insert_query_7days, $dbConn);
    }
}

$query_15days = "select distinct ani,d.circle,d.message from airtel_mnd.tbl_character_subscription1 b ,master_db.tbl_sms_engagement d where not exists 
(select a.msisdn from mis_db.tbl_mnd_calllog a where a.dnis in('5500196','54646196','55001961','55001962','55001963','55001964','55001965') and a.operator in ('airm') and date(a.call_date) between 
DATE(NOW()-INTERVAL 15 DAY) and DATE(NOW()-INTERVAL 1 DAY) and a.msisdn=b.ani) and date(b.sub_date) = DATE(NOW()-INTERVAL 16 DAY) and b.status=1 and 
d.status=1 and d.type='15 Days' and d.service_id=1513 and date(d.added_on) = CURDATE() and b.circle=d.circle";

$result_15days = mysql_query($query_15days, $dbConn) or die(mysql_error());

$result_row_15days = mysql_num_rows($result_15days);

if ($result_row_15days > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = '15 Days' and service_id=1513";
    mysql_query($delete_query, $dbConn);
    while ($details_15days = mysql_fetch_row($result_15days)) {
        $insert_query_15days = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type)
                       values (" . $details_15days[0] . ",'" . $details_15days[1] . "','" . $details_15days[2] . "'," . "now(),1513,0,'15 Days')";
        mysql_query($insert_query_15days, $dbConn);
    }
}
////////////////////////////////////////////////// End Code For 1513  ///////////////////////////////////////////////////////////////////////////////////////
?>
   
