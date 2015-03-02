<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
$service_id = $_REQUEST['service_id'];
$type = $_REQUEST['type'];
$date = $_REQUEST['added_on'];
$rule_id = $_REQUEST['rule_id'];
$excellFile = $date . ".xls";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "ANI\tCircle\tMessage\tMsg sent time" . "\r\n";
$filePath = "/var/www/html/kmis/services/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
$lines = file($filePath);
foreach ($lines as $line_num => $BGData) {
    $data = explode("#", $BGData);
    $data[2] = trim($data[2]);
    echo $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\r\n";
}
header("Pragma: no-cache");
header("Expires: 0");
?>