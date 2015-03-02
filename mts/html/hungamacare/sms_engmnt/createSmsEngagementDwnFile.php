<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$service_id_array = array('1101');
$type_array = array('3 Days', '7 Days','15 Days','0-10 Mous', '10-30 Mous', '>30 Mous', 'active_base');
$type_path = array('3 Days', '7 Days','15 Days', '0-10 Mous', '10-30 Mous', '>30 Mous', 'active_base');
$replace_array = array(" ", "-", ">");
$type_path = str_replace($replace_array, "_", $type_array);
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
for ($i = 0; $i < count($service_id_array); $i++) {
    for ($j = 0; $j < count($type_array); $j++) {
        $duration_array = explode(":", $type_array[$j]);
        if ($duration_array[1] != '') {
            $query = "select distinct ani,circle,message,added_on from master_db.tbl_sms_engagement_log where type='" . $duration_array[0] . "' and service_id=" . $service_id_array[$i] . " and date(added_on) = DATE(NOW()) and duration='" . $duration_array[1] . "'";
        } else {
            $query = "select distinct ani,circle,message,added_on from master_db.tbl_sms_engagement_log where type='" . $type_array[$j] . "' and service_id=" . $service_id_array[$i] . " and date(added_on) = DATE(NOW())";
        }
        $data = mysql_query($query, $dbConn);
        $log_path = "/var/www/html/hungamacare/2.0/logs/sms_engmnt/" . $service_id_array[$i] . "/" . $type_path[$j] . "/log_" . $date . ".log";
        unlink($log_path);
        while ($data_array = mysql_fetch_array($data)) {
            $data_array[2] = str_replace(",", " (comma) ", $data_array[2]);
            $logstring = $data_array[0] . "#" . $data_array[1] . "#" . $data_array[2] . "#" . $data_array[3] . "#" . date('his') . "\r\n";
            error_log($logstring, 3, $log_path);
        }
    }
}
?>