<?php

require_once("../../../db.php");
$type = $_REQUEST['type'];
$StartDate = $_REQUEST['StartDate'];
$EndDate = $_REQUEST['EndDate'];
if ($_REQUEST['type'] == 'total_missed_call') {
    $data_query = "select ANI,cast(date_time as date) as date,cast(date_time as time) as time from hul_hungama.tbl_hul_pushobd_sub nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and service='HUL' order by date_time desc ";
}
//else if ($_REQUEST['type'] == 'total_unique_call') {
//    echo $data_query = "select ANI,date_time from hul_hungama.tbl_hul_pushobd_sub nolock 
// where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and ANI!='' and service='HUL' order by date_time desc ";
//} else if ($_REQUEST['type'] == 'promotion_obd_received') {
//    $data_query = "select ANI,service,duration,circle,odb_name,date_time from hul_hungama.tbl_hulobd_success_fail_details nolock 
// where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and service='HUL_PROMOTION' and ANI!=''  order by date_time desc ";
//} 
else if ($_REQUEST['type'] == 'total_minutes_consumed') {
    $data_query = "select ANI,service,duration,circle,odb_name,cast(date_time as date) as date,cast(date_time as time) as time from hul_hungama.tbl_hulobd_success_fail_details nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and service='HUL' and status=2 and ANI!='' order by date_time desc ";
}
//else if ($_REQUEST['type'] == 'most_heared_category') {
//    $data_query = "select ANI,service,duration,circle,odb_name,date_time from hul_hungama.tbl_hulobd_success_fail_details nolock 
// where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and service='HUL' and ANI!='' order by date_time desc ";
//}
else if ($_REQUEST['type'] == 'total_people_targeted') {
    $data_query = "select ANI,service,duration,circle,odb_name,cast(date_time as date) as date,cast(date_time as time) as time from hul_hungama.tbl_hulobd_success_fail_details nolock 
 where date(date_time) between '" . $StartDate . "' and '" . $EndDate . "' and service='HUL' and status=2 and ANI!='' order by date_time desc ";
} else {
    exit;
}
//die('here');
$data = mysql_query($data_query, $con);
$result_row = mysql_num_rows($data);

if ($result_row > 0) {
    $exportFile = $type . '_' . date('YMDhis');
    $excellFile = $exportFile . ".csv";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
    if ($_REQUEST['type'] == 'total_missed_call') {
        echo "ANI,Date,Time" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
            echo $mis_array['ANI'] . "," . $mis_array['date'] . "," . $mis_array['time'] . "\r\n";
        }
    } else {
        echo "ANI,Service,Duration,Circle,ObdName,Date,Time" . "\r\n";
        while ($mis_array = mysql_fetch_array($data)) {
            echo $mis_array['ANI'] . "," . $mis_array['service'] . "," . $mis_array['duration'] . "," . $mis_array['circle'] . "," . $mis_array['odb_name'] . "," . $mis_array['date'] . "," . $mis_array['time'] . "\r\n";
        }
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$excellFile");
?>
    <?php

}
mysql_close($dbConn);