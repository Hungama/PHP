<?php
#include ("/var/www/html/hungamacare/2.0/incs/db.php");
$query = "select count(*),service_id,type,date(added_on) from master_db.tbl_new_engagement_log where date(added_on) = date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "'  and rule_id='" . $rule_id . "'
    and status=1 group by type,service_id,date(added_on) ";
$result = mysql_query($query, $dbConn);
$details = mysql_fetch_array($result);

$insert_query = "insert into master_db.tbl_new_engagement_data (count,added_on,service_id,status,type,duration,rule_id,msg_sent_status) 
        values (" . $details[0] . ",now()," . $details[1] . ",0,'" . $details[2] . "','" . $details[4] . "','$rule_id',10)";
mysql_query($insert_query, $dbConn);
echo 'done>> new_engagementdata.php>>>';
?>
  