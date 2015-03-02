<?php
#require_once("../incs/db.php");
error_reporting(0);
if ($status == 'active') {
    $status_info = "status=1";
} else if ($status == 'pending') {
    $status_info = "status=11";
} else if ($status == 'non live') {
    $status_info = "status= -1";
} else {
    $status_info = "status in(1,11)";
}
$querySMSlog = "/var/www/html/hungamacare/honey-bee/Script/logs/querySMSlog_" . date('Ymd') . ".txt";
//echo $rule_id = 211;
// Get Rule details
$query = "select scenerios,service_id,circle,service_base,dnd_scrubbing from honeybee_sms_engagement.tbl_rule_engagement nolock where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn);
$ruleData = mysql_fetch_array($rule_result);
$dnd_scrubbing = $ruleData['dnd_scrubbing'];

// Get SMS CLI/Sequence details
$actionquery = "select sms_cli,sms_sequence from honeybee_sms_engagement.tbl_rule_engagement_action nolock where rule_id='" . $rule_id . "'";
$action_result = mysql_query($actionquery, $dbConn);
$actionData = mysql_fetch_array($action_result);

$sms_cli = $actionData[0];
$sms_sequence = $actionData[1];
$type = $ruleData[0];
$service_id = $ruleData[1];
$sms_circle = $ruleData[2];
$service_base = $ruleData[3];

//Get SMS That will push to user
if($sms_sequence=='random')
$orderby=" ORDER BY RAND() limit 1";
else
$orderby=" limit 1";

$SMSquery = "select id,message from honeybee_sms_engagement.tbl_new_sms_engagement nolock where rule_id='" . $rule_id . "' 
and message_type='NORM' and status=1 $orderby";
$smsresult = mysql_query($SMSquery, $dbConn);
$smsData = mysql_fetch_array($smsresult);
//Get Message
$msg = $smsData[1];
if ($msg != '') {
    $circle = explode(",", $ruleData[2]);
    $msisdn_count = 0;
    $curdate = date("d-m-Y_His");
    $filepathdndcheck = '/var/www/html/hungamacare/honey-bee/new_engagement/dndcheck/' . $rule_id . '_' . $curdate . '.txt';
    $filepathdndcheck_csv = '/var/www/html/hungamacare/honey-bee/new_engagement/dndcheck/' . $rule_id . '_' . $curdate . '.csv';
    $remote_file = $rule_id . '_' . $curdate . '.txt';
    $dndcheckfile = $rule_id . '_' . $curdate;
    unlink($filepathdndcheck);
    unlink($filepathdndcheck_csv);
	 for ($i = 0; $i < count($circle); $i++) {

		$Numberquery = "select ANI,type,circle,service_id from honeybee_sms_engagement.tbl_new_engagement_number nolock where date(added_on)=date(now())  and Type='" . $type . "' and service_id='" . $service_id . "' and " . $status_info . " and circle='" . $circle[$i] . "'";
        $result = mysql_query($Numberquery, $dbConn);

        $result_num = mysql_num_rows($result);
        $msisdn_count = $msisdn_count + $result_num;

        while ($aniRecord = mysql_fetch_row($result)) {
            $logData = $aniRecord[0] . "\n";
            error_log($logData, 3, $filepathdndcheck);
            error_log($logData, 3, $filepathdndcheck_csv);
        }
    }

    if ($dnd_scrubbing == 1) {
        sleep(100);
		 unlink($filepathdndcheck_csv);
	       require '/var/www/html/hungamacare/honey-bee/new_engagement/dndCheck_ftp.php';
    }
	 sleep(20);

    $lines = file($filepathdndcheck_csv);
    $i = 0;
    $mdncount = 0;
    $totalcount = 0;
    foreach ($lines as $line_num => $mobno) {
        $mno = trim($mobno);
        if (!empty($mno)) {
            $i++;
            $mdncount = $mdncount + 1;

            $getCircle = "select  master_db.getCircle(" . trim($mno) . ") as circle";
            $circle1 = mysql_query($getCircle, $dbConn);
            list($circle) = mysql_fetch_array($circle1);
            if (!$circle) {
                $circle = 'UND';
            }

            if ($i == 1) {
                $test_msg = 'Rule Execution Start for rule id- ' . $rule_id . " for Circle -" . $circle;
              $procedureCall_Test = "CALL  master_db.SENDSMS_BULK_DND('7838551197','" . $test_msg . "','" . $sms_cli . "','sms-promo','5')";
                mysql_query($procedureCall_Test, $dbConn);
            }
			// check for any message send today	IN_ACTION- PRED
			//$mno='8459059193';//Test Number
			$sms_procedurce="honeybee_sms_engagement.SENDSMS_HONYBEE_ENGMNT_DND";
			$sndMsgQuery = "CALL $sms_procedurce ('".$mno."','".$msg."','".$sms_cli."','sms-promo',1,'pre_defined_time',$service_id,0,'".$rule_id."')";
			$result1='';//Save query response
			if(mysql_query($sndMsgQuery, $dbConn))
				$result1='SUCCESS';
			else
				$result1=mysql_error();
			//Just for testing
			//$result1='SUCCESS';
			$sendSMSQueryLog = $rule_id . "#" . $mno . "#" . $result1."#".$sndMsgQuery ."#".date('Y-m-d H:i:s')."#"."\r\n";
            error_log($sendSMSQueryLog, 3, $querySMSlog);
			
			 if ($result1=='SUCCESS') {
               $insertquery = "insert into honeybee_sms_engagement.tbl_new_engagement_log(ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
     values('$mno', '$circle',\"$msg\",now(), '$service_id', 1,'$type','$rule_id','$service_base')";
                mysql_query($insertquery, $dbConn);
            }
        }
    }
    $totalcount = $mdncount;
    //updated for ftp dnd process end here
if ($msisdn_count == 0) {
        $insertquery1 = "insert into honeybee_sms_engagement.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id)
     values('0',now(), '$service_id', 9,'$type','$rule_id')";
        mysql_query($insertquery1, $dbConn);

        $UpdateRule = "update honeybee_sms_engagement.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
        $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
    }
    $Update = "update honeybee_sms_engagement.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
    $EXEresult = mysql_query($Update, $dbConn);
	
// Check for other message for this rule..if no sms found make this rule pause
    $CheckSMSquery = "select id,message from honeybee_sms_engagement.tbl_new_sms_engagement nolock where rule_id='" . $rule_id . "' and status=1 and message_type='NORM'";
    $Checksmsresult = mysql_query($CheckSMSquery, $dbConn);
    $ChecksmsData = mysql_fetch_array($Checksmsresult);
    $Checkmsg = $ChecksmsData[1];
    if (!($Checkmsg)) {
        $Update = "update honeybee_sms_engagement.tbl_rule_engagement set status=5 where id=" . $rule_id . "";
        $EXEresult = mysql_query($Update, $dbConn);
		//Send email to rule owner to inform about it
    }
} else {
    $insertquery2 = "insert into honeybee_sms_engagement.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id)
     values('0',now(), '$service_id', 10,'$type','$rule_id')";
    mysql_query($insertquery2, $dbConn);
    $UpdateRule = "update honeybee_sms_engagement.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
    $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
//status>> 1 ( Message Send)
//10 >> No message found
//9>> No records found
}
echo "Process end in SMS File"."************";
echo "<br>";
?>