<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$service_id_array = array('1101');
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));

$TypeQry = "SELECT Scid FROM master_db.tbl_filter_base_scenarios";
$TypeData = mysql_query($TypeQry, $dbConn);

for ($i = 0; $i < count($service_id_array); $i++) {
    while ($type_data_array = mysql_fetch_array($TypeData)) {
        $RuleQry = "SELECT id FROM master_db.tbl_rule_engagement where scenerios='" . $type_data_array[0] . "' and service_id=" . $service_id_array[$i] . "";
        $RuleData = mysql_query($RuleQry, $dbConn);
        while ($rule_data_array = mysql_fetch_array($RuleData)) {
//            $query = "select distinct ANI,circle,message,added_on from master_db.tbl_new_engagement_log where type='" . $type_data_array[0] . "'
//                and service_id=" . $service_id_array[$i] . " and rule_id=" . $rule_data_array[0] . " and date(added_on) = DATE(NOW())";
//            $data = mysql_query($query, $dbConn);
//            $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id_array[$i] . "/" . $type_data_array[0] . "/" . $rule_data_array[0] . "_" . $date . ".log";
            $query = "select distinct ANI,circle,message,added_on from master_db.tbl_new_engagement_log where type='" . $type_data_array[0] . "'
                and service_id=" . $service_id_array[$i] . " and date(added_on) = DATE(NOW())";
            $data = mysql_query($query, $dbConn);
            echo $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id_array[$i] . "/" . $type_data_array[0] . "/" . $date . ".log";
            unlink($log_path);
            while ($data_array = mysql_fetch_array($data)) {
                echo $logstring = $data_array[0] . "#" . $data_array[1] . "#" . $data_array[2] . "#" . $data_array[3] . "#" . date('his') . "\r\n";
                error_log($logstring, 3, $log_path);
            }
        }
    }
}
?>