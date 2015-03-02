<?php
$excellFile="http://119.82.69.212/kmis/services/hungamacare/MTS_NEW_ENGMNT/dndcheck/51_09-12-2013.csv";
$data = file_get_contents('http://119.82.69.212/kmis/services/hungamacare/MTS_NEW_ENGMNT/dndcheck/51_09-12-2013.csv');
header("Content-Type: text/csv");
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="'.$excellFile.'"');
print "$header\r\n$data";
?>