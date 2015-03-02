<?php

require_once("incs/db.php");
$service_id = $_REQUEST['service_id'];
$type = $_REQUEST['type'];
$added_on = $_REQUEST['added_on'];
$rule_id = $_REQUEST['rule_id'];
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$mytime = date("dmy", strtotime($added_on));
$excellFile = $mytime . ".csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "ANI,Circle,Message,Added On" . "\r\n";
$filePath = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
$lines = file($filePath);
foreach ($lines as $line_num => $BGData) {
    $data = explode("#", $BGData);
    echo $data[0] . "," . $data[1] . "," . $data[2] . "," . $data[3] . "\r\n";
}
header("Pragma: no-cache");
header("Expires: 0");
?>