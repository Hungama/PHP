<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$query = "select a.ani,b.circle,b.message from airtel_SPKENG.tbl_spkeng_subscription a,master_db.tbl_sms_engagement b where 
    (date(b.scheduledDate)=date(now()) or daily_msg=1) and a.status=1 and  a.circle=b.circle and b.service_id=1517 and b.type='active_base' and b.status=1 ";

$result = mysql_query($query, $dbConn) or die(mysql_error());
$result_row = mysql_num_rows($result);
if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and type = 'active_base' and service_id=1517";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_sms_engagement_log (ANI,circle,message,added_on,service_id,status,type) 
            values (" . $details[0] . ",'" . $details[1] . "','" . $details[2] . "'," . "now(),1517,0,'active_base')";
        mysql_query($insert_query, $dbConn);
    }
}
?>
    