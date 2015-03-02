<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

$rule_id = $_REQUEST['rule_id'];
$rule_id = '2';
$query = "select scenerios,service_id from master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn);
$ruleData = mysql_fetch_array($rule_result); //echo "<pre>";print_r($ruleData);
$actionquery = "select sms_cli from master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
$action_result = mysql_query($actionquery, $dbConn);
$actionData = mysql_fetch_array($action_result); //echo "<pre>";print_r($actionData);die('here');

$sms_cli = $actionData[0];
$type = $ruleData[0];
$service_id = $ruleData[1];
//
$Numberquery = "select ANI,type,circle,service_id from master_db.tbl_new_engagement_number where date(added_on)=date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "'";
$result = mysql_query($Numberquery, $dbConn);
$SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rule_id . "' and status=1";
$smsresult = mysql_query($SMSquery, $dbConn);
$smsData = mysql_fetch_array($smsresult); //echo "<pre>";print_r($smsData);die('here');
$msg = $smsData[1];
while ($smsRecord = mysql_fetch_row($result)) {

    //echo $procedureCall = "call master_db.SENDSMS_NEW(" . $smsRecord[0] . ",'" . $msg . "','" . $sms_cli . "','mtsm','NO_CALL_PROMO',5)";
//		if($procedureCall)
//		{
    //$result1 = mysql_query($procedureCall);
    //echo $Update = "update master_db.tbl_new_engagement_log set status=1 where id=" . $smsRecord[0] . " and ani=" . $smsRecord[1];
    echo $insertquery = "insert into master_db.tbl_new_engagement_log(ANI,circle,message,added_on,service_id,status,type,rule_id) 
     values('$smsRecord[0]', '$smsRecord[2]','$msg',now(), '$service_id', 1,'$type','$rule_id')";
    $EXeresult = mysql_query($insertquery, $dbConn);
    echo $Update = "update master_db.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
    $$EXEresult = mysql_query($Update, $dbConn);
    echo "<br>";
//		}
}
?>
  