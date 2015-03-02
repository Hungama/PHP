<?php
require_once("../../../db.php");
$StartDate = $_REQUEST['StartDate'];
$EndDate = $_REQUEST['EndDate'];
$type = $_REQUEST['type'];
$circle = $_REQUEST['circle'];

$dbNameMCD='Hungama_GSK_Africa';
$tblMissedCall=$dbNameMCD.'.tbl_gsk_pushobd';
$tblObdDetails=$dbNameMCD.'.tbl_gsk_success_fail_details';
//+233 Ghana,
//254 Kenya,
//+27 Africa
//+234 is nigeria
$circleArray=array('GHANA'=>'233','AFRICA'=>'27','KENYA'=>'254','NIGERIA'=>'234');

$country_code=$circleArray[$circle];
if ($StartDate == '' || $EndDate == '' || $type == '' || $country_code=='') {
    echo "Please provide all parameter";
    exit;
}
if ($_REQUEST['type'] == 'missedcall') {
    $data_query = "select ANI,date_time from $tblMissedCall nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and service='GSK_AFRICA' and country_code=$country_code order by date_time desc ";
} else if ($_REQUEST['type'] == 'content') {
    $data_query = "select ANI,service,duration,circle,date_time from $tblObdDetails nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and status=2 and service='GSK_AFRICA' and country_code=$country_code order by date_time desc ";
} else {
    echo "Type is not valid";
    exit;
}

$data = mysql_query($data_query, $con);
$result_row = mysql_num_rows($data);

if ($result_row > 0) {
    $exportFile = $type . '_GSK_' . date('YMDhis');
    $excellFile = $exportFile . ".csv";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
    if ($_REQUEST['type'] == 'missedcall') {
        echo "ANI,Datetime" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
            echo $mis_array['ANI'] . "," . $mis_array['date_time'] . "\r\n";
        }
    } else if ($_REQUEST['type'] == 'content') {
        echo "ANI,Service,Duration,Circle,Datetime" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
            echo $mis_array['ANI'] . "," . $mis_array['service'] . "," . $mis_array['duration'] . "," . $mis_array['circle'] . "," . $mis_array['date_time'] . "\r\n";
        }
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
} else {
    echo "No Record Found";
    exit;
}
mysql_close($dbConn);
?>