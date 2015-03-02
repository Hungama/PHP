<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
//$circle_info = array('CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi', 'ALL' => 'ALL');
$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
echo $query = "select distinct ANI,circle,message,added_on from master_db.tbl_new_engagement_log where type='" . $type . "'
                and service_id=" . $service_id . " and service_base= '" . $status . "'   and rule_id= '" . $rule_id . "' and date(added_on) = DATE(NOW())";
$data = mysql_query($query, $dbConn);
$log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
unlink($log_path);
while ($data_array = mysql_fetch_array($data)) {
    $msg_sent_time = date('jS F Y h:i:s A', strtotime($data_array[3]));
    $circle = $circle_info[$data_array[1]];
    $logstring = $data_array[0] . "#" . $circle . "#" . $data_array[2] . "#" . $msg_sent_time . "#" . date('his') . "\r\n";
    error_log($logstring, 3, $log_path);
}
?>