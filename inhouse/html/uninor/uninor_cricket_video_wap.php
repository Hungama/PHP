<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$log_path = "/var/www/html/Uninor/logs/CricketVideoWap/log_" . date('dmy') . ".log";
$msisdn = $_REQUEST['msisdn'];
$content_id = $_REQUEST['content_id'];
$rcode = $_REQUEST['rcode'];
if (!isset($rcode)) {
    $rcode = "OK,NOK";
}
$abc = explode(',', $rcode);
if (($msisdn == "") || ($content_id == "")) {
    echo "Please provide the complete parameter";
} else {
    $chk_msisdn_content = "select count(*) from uninor_cricket.video_wap where msisdn='$msisdn' and content_id='$content_id'";
    $query = mysql_query($chk_msisdn_content, $dbConn);
    $result = mysql_fetch_row($query);
    //if (mysql_num_rows($query) > 1) {'
    if ($result[0] > 0) {
        echo $rcode = $abc[1];
   } else {
        $insert_query = "insert into uninor_cricket.video_wap";
        $insert_query .= "(msisdn,content_id,date,status) values(" . $msisdn . "," . $content_id . ",now(),1)";
        $query = mysql_query($insert_query, $dbConn);
        echo $rcode = $abc[0];
   }
    
}
$logstring = $msisdn . "#" . $content_id . "#" . $rcode . "#" . date('his') . "\r\n";
    error_log($logstring, 3, $log_path);
    exit;
?>   