<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");

if ($status == 'active') {
    $status_info = "status=1";
} else if ($status == 'pending') {
    $status_info = "status=11";
} else {
    $status_info = "status in(1,11)";
}
$query = "select scenerios,service_id,circle,service_base from master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn);
$ruleData = mysql_fetch_array($rule_result);
$actionquery = "select sms_cli from master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
$action_result = mysql_query($actionquery, $dbConn);
$actionData = mysql_fetch_array($action_result);

$sms_cli = $actionData[0];
$type = $ruleData[0];
$service_id = $ruleData[1];
$sms_circle = $ruleData[2];
$service_base = $ruleData[3];
//
echo $Numberquery = "select ANI,type,circle,service_id from master_db.tbl_new_engagement_number where date(added_on)=date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "' and " . $status_info . " ";
$result = mysql_query($Numberquery, $dbConn);
$SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rule_id . "' and status=1";
$smsresult = mysql_query($SMSquery, $dbConn);
$smsData = mysql_fetch_array($smsresult);
echo $msg = $smsData[1];
if ($msg != '') {
    while ($smsRecord = mysql_fetch_row($result)) {
        if ($sms_circle == $smsRecord[2]) {
//        echo $procedureCall = "call master_db.SENDSMS_NEW(" . $smsRecord[0] . ",'" . $msg . "','" . $sms_cli . "','mtsm')"; // it will work fine
//        $result1 = mysql_query($procedureCall, $dbConn);
//        if ($result1) {
            $insertquery = "insert into master_db.tbl_new_engagement_log(ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
     values('$smsRecord[0]', '$smsRecord[2]','$msg',now(), '$service_id', 1,'$type','$rule_id','$service_base')";
            $EXeresult = mysql_query($insertquery, $dbConn);
            // }
        }
    }
    $Update = "update master_db.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
    $EXEresult = mysql_query($Update, $dbConn);
    
    $CheckSMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rule_id . "' and status=1";
    $Checksmsresult = mysql_query($CheckSMSquery, $dbConn);
    $ChecksmsData = mysql_fetch_array($Checksmsresult);
    echo $Checkmsg = $ChecksmsData[1];
    if (!($Checkmsg)) {
        $Update = "update master_db.tbl_rule_engagement set status=5 where id=" . $rule_id . "";
        $EXEresult = mysql_query($Update, $dbConn);
    }
}
echo "<br>";
?>
  