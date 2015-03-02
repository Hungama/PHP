<?php
#include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra',
    'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa',
    'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala',
    'HPD' => 'Himachal Pradesh', '' => 'Other');
$query = "select distinct ANI,circle,message,added_on from master_db.tbl_new_engagement_log where type='" . $type . "'
                and service_id=" . $service_id . " and service_base= '" . $status . "'   and rule_id= '" . $rule_id . "' and date(added_on) = DATE(NOW())";
$data = mysql_query($query, $dbConn);


$log_path_service = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/";

if (!is_dir($log_path_service)) {
    mkdir($log_path_service);
    chmod($log_path_service, 0777);
}

$log_path_type = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/";

if (!is_dir($log_path_type)) {
    mkdir($log_path_type);
    chmod($log_path_type, 0777);
}

$log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";

unlink($log_path);
while ($data_array = mysql_fetch_array($data)) {
    $msg_sent_time = date('jS F Y h:i:s A', strtotime($data_array[3]));
    $circle = $circle_info[$data_array[1]];
   $logstring = $data_array[0] . "#" . $circle . "#" . $data_array[2] . "#" . $msg_sent_time . "#" . date('his') . "\r\n";
    error_log($logstring, 3, $log_path);
}
echo "Dwn File Creation Completed";
sleep(30);
include("/var/www/html/hungamacare/v3/new_engagement/sendreport-SmsBase.php");
?>