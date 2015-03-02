<?php
error_reporting(1);
//clearstatcache(); 
$dbConn_106 = mysql_connect("database.master_mts", "ivr", "ivr");
if (!$dbConn_106) {
    echo '106- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}

$nowtime = date('H:i');
$nowtime = date('h:i A', strtotime($nowtime));

$getCurrentTimeQuery="select DATE_FORMAT(now(),'%h:%i %p')";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn_106);
$currentTime = mysql_fetch_row($timequery2);

$nowtime=$currentTime[0];

//$nowtime = '04:45 PM';
//Get rule for predefined only
//$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence from honeybee_sms_engagement.tbl_rule_engagement_action nolock where status=1 and time_slot='" . $nowtime . "' and action_name='sms_pre_defined_time'";
$qry = "select a.rule_id,a.time_slot,a.action_name,a.sms_cli,a.sms_sequence from honeybee_sms_engagement.tbl_rule_engagement_action as a,honeybee_sms_engagement.tbl_rule_engagement as b where b.status=1 and a.time_slot='" . $nowtime . "' and a.action_name='sms_pre_defined_time' and a.rule_id=b.id";
$logPathAFID="/var/www/html/hungamacare/honey-bee/Script/logs.txt"; 
$logStringAFID=$$nowtime."#".$qry."#".date('Y-m-d H:i:s')."#"."\r\n";
//error_log($logStringAFID,3,$logPathAFID);

$checkrule = mysql_query($qry, $dbConn_106);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process' . "\n\r";
    echo $logData;
    mysql_close($dbConn_106);
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
  $insert_query = "insert into honeybee_sms_engagement.tbl_rule_engagement_temp_process (rule_id,action_name,time_slot,sms_cli,status,added_on,sms_sequence) 
            values ('".$rows['rule_id']."','".$rows['action_name']."','".$rows['time_slot']."','".$rows['sms_cli']."',0,now(),'".$rows['sms_sequence']."')";
            mysql_query($insert_query, $dbConn_106);

	}
	
}
mysql_close($dbConn_106);
echo "done";
?>