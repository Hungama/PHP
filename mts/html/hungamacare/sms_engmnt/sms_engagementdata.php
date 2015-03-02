<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$query = "select count(*),service_id,type,date(added_on),duration from master_db.tbl_sms_engagement_log where date(added_on) = date(now()) and status=1 group by type,service_id,date(added_on) ";

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_sms_engagement_data where date(added_on) = date(now())";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_sms_engagement_data (count,added_on,service_id,status,type,duration) values (" . $details[0] . ",now()," . $details[1] . ",0,'" . $details[2] . "','" . $details[4] . "')";
        mysql_query($insert_query, $dbConn);
    }
}
echo 'done';
?>
  