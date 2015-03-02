<?php

error_reporting(1);
//clearstatcache(); 
include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
if (!$dbConn) {
    echo '160- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}

$getCurrentTimeQuery = "select DATE_FORMAT(now(),'%h:%i %p')";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
$currentTime = mysql_fetch_row($timequery2);

echo $nowtime = $currentTime[0];
//$nowtime = '04:05 PM';
echo $qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence,sms_type from master_db.tbl_rule_engagement_action where status=1 and time_slot='" . $nowtime . "' and action_name='sms'";
$checkrule = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process' . "\n\r";
    echo $logData;
    mysql_close($dbConn);
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
        $insert_query = "insert into master_db.tbl_rule_engagement_temp_process (rule_id,action_name,time_slot,sms_cli,status,added_on,sms_sequence,sms_type) 
            values ('" . $rows['rule_id'] . "','" . $rows['action_name'] . "','" . $rows['time_slot'] . "','" . $rows['sms_cli'] . "',0,now(),'" . $rows['sms_sequence'] . "',
                '" . $rows['sms_type'] . "')";
        mysql_query($insert_query, $dbConn);
    }
}
mysql_close($dbConn);
echo "done";
?>