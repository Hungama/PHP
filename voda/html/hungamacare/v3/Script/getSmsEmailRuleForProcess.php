<?php
error_reporting(1);
$dbConnVoda = mysql_connect("10.43.248.137","php_promo","php@321");
if (!$dbConnVoda) {
    echo 'Voda- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}

$nowtime = date('H:i');
$nowtime = date('h:i A', strtotime($nowtime));

$getCurrentTimeQuery="select DATE_FORMAT(now(),'%h:%i %p')";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConnVoda);
$currentTime = mysql_fetch_row($timequery2);

$nowtime=$currentTime[0];
$flag=true;
//$nowtime = '01:15 PM';
if($flag)
$timeCheck=" and time_slot='" . $nowtime . "' ";

$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence,sms_type from master_db.tbl_rule_engagement_action where status=1 $timeCheck and action_name in('email','sms')";
$checkrule = mysql_query($qry, $dbConnVoda);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process' . "\n\r";
    echo $logData;
    mysql_close($dbConnVoda);
    exit;
} else {//put status =1 for 26 jan14
    while ($rows = mysql_fetch_array($checkrule)) {
  $insert_query = "insert into master_db.tbl_rule_engagement_temp_process (rule_id,action_name,time_slot,sms_cli,status,added_on,sms_sequence,sms_type) 
            values ('".$rows['rule_id']."','".$rows['action_name']."','".$rows['time_slot']."','".$rows['sms_cli']."',0,now(),'".$rows['sms_sequence']."','".$rows['sms_type']."')";
            mysql_query($insert_query, $dbConnVoda);

	}
	
}
mysql_close($dbConnVoda);
echo "done";
?>