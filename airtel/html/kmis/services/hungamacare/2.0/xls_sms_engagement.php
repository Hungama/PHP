<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$service_id = $_REQUEST['service_id'];
$type = $_REQUEST['type'];
$added_on = $_REQUEST['added_on'];
$replace_array = array(" ", "-", ">");
$type_path = str_replace($replace_array, "_", $type);
$mytime=date("dmy",strtotime($added_on));
$excellFile = $mytime . ".csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "ANI,Circle,Message,Added On" . "\r\n";
$filePath = "/var/www/html/kmis/services/hungamacare/2.0/logs/sms_engmnt/" . $service_id . "/" . $type_path . "/log_" . $mytime . ".log";
$lines = file($filePath);
foreach ($lines as $line_num => $BGData) {
    $data = explode("#", $BGData);
    echo $data[0] . "," . $data[1] . "," . $data[2] . "," . $data[3] . "\r\n";
}
header("Pragma: no-cache");
header("Expires: 0");
?>