<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));

echo $query = "select distinct ANI,circle,message,added_on from master_db.tbl_new_engagement_log where type='" . $type . "'
                and service_id=" . $service_id . " and status= '" . $status . "' and date(added_on) = DATE(NOW()) ";
$data = mysql_query($query, $dbConn);
echo $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
unlink($log_path);
while ($data_array = mysql_fetch_array($data)) {
    echo $logstring = $data_array[0] . "#" . $data_array[1] . "#" . $data_array[2] . "#" . $data_array[3] . "#" . date('his') . "\r\n";
    error_log($logstring, 3, $log_path);
}
?>