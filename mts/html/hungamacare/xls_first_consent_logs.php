<?php

include("config/dbConnect.php");
$timestamp = $_REQUEST['timestamp'];
$timestamp1 = $_REQUEST['timestamp1'];
$timestamp = date("Y/m/d", strtotime($timestamp));
$timestamp1 = date("Y/m/d", strtotime($timestamp1));
$mytime = date("dmy");
$excellFile = $mytime . "_first_consent_logs.csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "ANI,Circle,Starttime,Service,Sort Code,Error Description ,Cons time,Cons status" . "\r\n";
$selectQry = "select ANI,circle,starttime,service,SC,error_desc,cons_time,cons_stat from master_db.tbl_double_consent_log 
              where date(cons_time) >='" . $timestamp . "' and date(cons_time) <='" . $timestamp1 . "'";
$query = mysql_query($selectQry, $dbConn);
$numofrows = mysql_num_rows($query);
while ($summarydata = mysql_fetch_array($query)) {
    echo $summarydata[0] . "," . $summarydata[1] . "," . $summarydata[2] . "," . $summarydata[3] . "," . $summarydata[4] . "," . $summarydata[5] . "," . $summarydata[6] . "," . $summarydata[7] . "\r\n";
}
header("Pragma: no-cache");
header("Expires: 0");
?>