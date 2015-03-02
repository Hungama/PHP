<?php
error_reporting(1);
//clearstatcache(); 
$dbConn_106 = mysql_connect("10.130.14.106", "ivr", "ivr");
if (!$dbConn_106) {
    echo '106- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}

$nowtime = date('H:i');
echo $nowtime = date('h:i A', strtotime($nowtime));

$getCurrentTimeQuery="select DATE_FORMAT(now(),'%h:%i %p')";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn_106);
$currentTime = mysql_fetch_row($timequery2);

$nowtime=$currentTime[0];

//$nowtime = '06:41 PM';
//$qry = "select rule_id,time_slot,action_name,sms_cli from master_db.tbl_rule_engagement_action where status=1 and added_by='satay.tiwari' and action_name='email'";
$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence from master_db.tbl_rule_engagement_action where status=1 and time_slot='" . $nowtime . "' and action_name='sms'";
$checkrule = mysql_query($qry, $dbConn_106);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process' . "\n\r";
    echo $logData;
    mysql_close($dbConn_106);
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
  $insert_query = "insert into master_db.tbl_rule_engagement_temp_process (rule_id,action_name,time_slot,sms_cli,status,added_on,sms_sequence) 
            values ('".$rows['rule_id']."','".$rows['action_name']."','".$rows['time_slot']."','".$rows['sms_cli']."',0,now(),'".$rows['sms_sequence']."')";
            mysql_query($insert_query, $dbConn_106);

	}
	
}
mysql_close($dbConn_106);
echo "done";
?>