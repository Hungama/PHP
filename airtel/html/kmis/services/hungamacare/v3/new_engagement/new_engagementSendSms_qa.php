<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
error_reporting(0);
if ($status == 'active') {
    $status_info = "status=1";
} else if ($status == 'pending') {
    $status_info = "status=11";
} else {
    $status_info = "status in(1,11)";
}
$querySMSlog = "/var/www/html/kmis/services/hungamacare/v3/Script/querySMSlog_" . date(Ymd) . ".txt";
$querySMSlog1 = "/var/www/html/kmis/services/hungamacare/v3/Script/ALLSMSTargetd_" . date(Ymd) . ".txt";

echo $rule_id = 39;

echo $query = "select scenerios,service_id,circle,service_base,dnd_scrubbing from master_db.tbl_rule_engagement where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn);
$ruleData = mysql_fetch_array($rule_result);
$dnd_scrubbing = $ruleData['dnd_scrubbing'];

echo $actionquery = "select sms_cli from master_db.tbl_rule_engagement_action where rule_id='" . $rule_id . "'";
$action_result = mysql_query($actionquery, $dbConn);
$actionData = mysql_fetch_array($action_result);

$sms_cli = $actionData[0];
$type = $ruleData[0];
$service_id = $ruleData[1];
$sms_circle = $ruleData[2];
$service_base = $ruleData[3];
//

echo $SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rule_id . "' and status=1";
$smsresult = mysql_query($SMSquery, $dbConn);
$smsData = mysql_fetch_array($smsresult);
$msg = $smsData[1];
if ($msg != '') {
    $circle = explode(",", $ruleData[2]);
    $msisdn_count = 0;

    $curdate = date("d-m-Y_His");
    $filepathdndcheck = '/var/www/html/kmis/services/hungamacare/v3/new_engagement/dndcheck/' . $rule_id . '_' . $curdate . '.txt';
    $filepathdndcheck_csv = '/var/www/html/kmis/services/hungamacare/v3/new_engagement/dndcheck/' . $rule_id . '_' . $curdate . '.csv';
    $remote_file = $rule_id . '_' . $curdate . '.txt';
    $dndcheckfile = $rule_id . '_' . $curdate;
    unlink($filepathdndcheck);
    unlink($filepathdndcheck_csv);
    for ($i = 0; $i < count($circle); $i++) {

        echo $Numberquery = "select ANI,type,circle,service_id from master_db.tbl_new_engagement_number nolock where date(added_on)=date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "' and " . $status_info . " and circle='" . $circle[$i] . "'";
        $result = mysql_query($Numberquery, $dbConn);

        $result_num = mysql_num_rows($result);
        $msisdn_count = $msisdn_count + $result_num;

        while ($aniRecord = mysql_fetch_row($result)) {
            $logData = $aniRecord[0] . "\n";
            error_log($logData, 3, $filepathdndcheck);
        }
    }

    if ($dnd_scrubbing == 1) {
        sleep(10);
        unlink($filepathdndcheck_csv);
        require '/var/www/html/kmis/services/hungamacare/v3/new_engagement/dndCheck_ftp.php';
    }
    sleep(10);

    $lines = file($filepathdndcheck_csv);
    $i = 0;
    $mdncount = 0;
    $totalcount = 0;
    foreach ($lines as $line_num => $mobno) {
        $mno = trim($mobno);
        if (!empty($mno)) {
            $i++;
            $mdncount = $mdncount + 1;

            $getCircle = "select master_db.getCircle(" . trim($mno) . ") as circle";
            $circle1 = mysql_query($getCircle, $dbConn);
            list($circle) = mysql_fetch_array($circle1);
            if (!$circle) {
                $circle = 'UND';
            }

            if ($sms_type == 'engagement') {
                //echo $procedureCall = "CALL master_db.SENDSMS(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "',2,'51050','promo')";
            } else {
                //echo $procedureCall = "CALL master_db.SENDSMS(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "',0,'51050','promo')";
            }
            //$sendSMSQuery = $procedureCall . "\r\n";
            $sendSMSQuery = $rule_id . "#" . $smsRecord[0] . "#" . $msg . "\r\n";
            error_log($sendSMSQuery, 3, $querySMSlog);
            if ($m == '1') {
                $test_msg = 'Rule Executed Successfully for rule id- ' . $rule_id . " for Circle -" . $circle;
                //$procedureCall_Test = "CALL master_db.SENDSMS_NEW('8587800665','" . $test_msg . "','" . $sms_cli . "','UNIM','sms-promo',3)";
                //mysql_query($procedureCall_Test, $dbConn);
            }
           // $result1 = mysql_query($procedureCall, $dbConn);

            $sendSMSQuery = $rule_id . "#" . $mno . "#" . $msg . "\r\n";
            error_log($sendSMSQuery, 3, $querySMSlog);

            if ($result1) {
                echo $insertquery = "insert into master_db.tbl_new_engagement_log(ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
     values('$mno', '$circle','$msg',now(), '$service_id', 1,'$type','$rule_id','$service_base')";
                $EXeresult = mysql_query($insertquery, $dbConn);
            }
        }
    }
    $totalcount = $mdncount;
    //updated for ftp dnd process end here




    if ($msisdn_count == 0) {
        $insertquery1 = "insert into master_db.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id)
     values('0',now(), '$service_id', 9,'$type','$rule_id')";
        mysql_query($insertquery1, $dbConn);

        $UpdateRule = "update master_db.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
        $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
    }
    $Update = "update master_db.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
    $EXEresult = mysql_query($Update, $dbConn);

    $CheckSMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rule_id . "' and status=1";
    $Checksmsresult = mysql_query($CheckSMSquery, $dbConn);
    $ChecksmsData = mysql_fetch_array($Checksmsresult);
    $Checkmsg = $ChecksmsData[1];
    if (!($Checkmsg)) {
        $Update = "update master_db.tbl_rule_engagement set status=5 where id=" . $rule_id . "";
        $EXEresult = mysql_query($Update, $dbConn);
    }
} else {

    $insertquery2 = "insert into master_db.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id)
     values('0',now(), '$service_id', 10,'$type','$rule_id')";
    mysql_query($insertquery2, $dbConn);

    $UpdateRule = "update master_db.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
    $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
//status>> 1 ( Message Send)
//10 >> No message found
//9>> No records found
}
echo "<br>";
?>
  