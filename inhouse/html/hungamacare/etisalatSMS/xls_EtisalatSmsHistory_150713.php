<?php

include ("config/dbConnect.php");
$date = date("Y-m-d", strtotime($_REQUEST['date']));
$plan_id = $_REQUEST['service'];
$mytime = date("dmy", strtotime($added_on));
$select_query = "select ani,message,DR_REC,DR_ERR from etislat_hsep.tbl_etislat_sms_log where msg_type='Alert' and plan_id='" . $plan_id . "' and date(date_time)='" . $date . "'";
$result = mysql_query($select_query);
$result_row = mysql_num_rows($result);
$excellFile = $mytime . ".csv";
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "ANI,Message,DR REC,DR ERR" . "\r\n";
if ($result_row > 0) {
    while ($details = mysql_fetch_row($result)) {
        //print_r($details);echo "<br/>";die('here');
        // $data[] = $details;
        echo $details[0] . "," . $details[1] . "," . $details[2] . "," . $details[3] . "\r\n";
    }
}
header("Pragma: no-cache");
header("Expires: 0");
?>