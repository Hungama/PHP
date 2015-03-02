<?php
//include database connection file
require_once("../incs/db.php");
$processlog = "/var/www/html/hungamacare/honey-bee/Script/logs/processlog_" . date('Ymd') . ".txt";
$msgnotsentlog = "/var/www/html/hungamacare/honey-bee/Script/logs/nomsglog_" . date('Ymd') . ".txt";
$predflog = "/var/www/html/hungamacare/honey-bee/Script/logs/predefinedlog_" . date('Ymd') . ".txt";
$RuleEngamentprocesslog = "/var/www/html/hungamacare/honey-bee/Script/logs/createRuleFile_" . date('Ymd') . ".txt";
$nowtime = date('H:i');
$nowtime = date('h:i A', strtotime($nowtime));
$getCurrentTimeQuery = "select DATE_FORMAT(now(),'%h:%i %p')";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
$currentTime = mysql_fetch_row($timequery2);
$nowtime = $currentTime[0];
//$nowtime = '04:45 PM';
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence from honeybee_sms_engagement.tbl_rule_engagement_temp_process nolock 
where status=0 and action_name='sms_pre_defined_time' limit 1";
$checkrule = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process in queue' . "\n\r";
    echo $logData;
    mysql_close($dbConn);//close database connection
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
        $rule_id = $rows['rule_id'];
        $sms_sequence = $rows['sms_sequence'];
		$sms_cli=$rows['sms_cli'];
		echo $rule_id."#".$sms_sequence."#".$sms_cli;
        $updateQuery_rule = "UPDATE honeybee_sms_engagement.tbl_rule_engagement_temp_process SET status = 1 WHERE rule_id = " . $rule_id;
        mysql_query($updateQuery_rule, $dbConn);

        $selectDisplayQuery = "SELECT service_id,service_base,scenerios,dnd_scrubbing,circle,added_by
                                FROM honeybee_sms_engagement.tbl_rule_engagement nolock where id='" . $rows['rule_id'] . "' and status=1";
        $queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
        $rule_array = mysql_fetch_array($queryDisplaySel);
        $status = $rule_array['service_base'];
        $service_id = $rule_array['service_id'];
        $type = $rule_array['scenerios'];
		
        $noofRulerows = mysql_num_rows($queryDisplaySel);
        if ($noofRulerows == 0) {
            $logData = 'This Rule is not active.' . "\n\r";
            echo $logData;
			$logData = "This Rule is not active rule id-".$rule_id."No SMS Will Push#".date('Y-m-d H:i:s')."\n\r";
            error_log($logData, 3, $msgnotsentlog);
            //close database connection
            mysql_close($dbConn);
            exit;
        } else {
            $SMSquery = "select id,message from honeybee_sms_engagement.tbl_new_sms_engagement nolock where rule_id='" . $rows['rule_id'] . "' and status=1 and message_type='NORM'";
            if ($sms_sequence == 'random') {
                $SMSquery .= " ORDER BY RAND() limit 1";
            }
            $smsresult = mysql_query($SMSquery, $dbConn);
            $smsData = mysql_fetch_array($smsresult);
			//Get Message that will push
            $msg = $smsData[1];			
            if ($msg != '') {
			// Test Scenerio start here 
                if ($type == '35') {
                  //  $emailidquery = "select mobile from master_db.live_user_master where username='" . $rule_array['added_by'] . "' ";
                   // $emailidresult = mysql_query($emailidquery, $dbConn);
                   // $emailidData = mysql_fetch_array($emailidresult);
				   //Hard code MTS testing number for test rule
                    $ani = 8459506442;//$emailidData['mobile'];//8459506442
					$sms_procedurce="honeybee_sms_engagement.SENDSMS_HONYBEE_ENGMNT_DND";
					$procedureCall = "CALL $sms_procedurce ('".$ani."','".$msg."','".$sms_cli."','sms-promo',5,'pre_defined_time',$service_id,0,'".$rule_id."')";
                    if(mysql_query($procedureCall, $dbConn))
						$resp='SUCCESS';
					else
						$resp='FAIL';
					$logstringPredf = $rule_id . "#" . $sms_cli . "#" . $ani."#".$msg . "#" . $procedureCall . "#" .$resp."#".$type."#". date('Y-m-d H:i:s') . "\r\n";
					error_log($logstringPredf, 3, $predflog);
		
                    $insertLog_query = "insert into honeybee_sms_engagement.tbl_new_engagement_log (ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
                                  values ('" . $ani . "','" . $rule_array['circle'] . "','" . $msg . "',now(),'" . $rule_array['service_id'] . "',0,'" . $type . "','$rule_id','" . $rule_array['service_base'] . "')";
                    mysql_query($insertLog_query, $dbConn);
                    $insert_query = "insert into honeybee_sms_engagement.tbl_new_engagement_data (count,added_on,service_id,status,type,rule_id,msg_sent_status) 
                                  values (1,now()," . $rule_array['service_id'] . ",0,'" . $type . "','$rule_id',10)";
                    mysql_query($insert_query, $dbConn);
					// Set last processed rule details
                    $UpdateRule = "update honeybee_sms_engagement.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
                    $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);

					//Not consume this message because it's send for testing only
                    $Update = "update honeybee_sms_engagement.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
					// $EXEresult = mysql_query($Update, $dbConn);
					$rulelogpath="/var/www/html/hungamacare/honey-bee/logs/$service_id/$type";
					if (!file_exists($rulelogpath)) {
						mkdir($rulelogpath, 0777, true);
					}
                   $log_path = $rulelogpath . "/" . $rule_id . "_" . $date . ".log";
				    unlink($log_path);					
                    $msg_sent_time = date("jS F Y h:i:s A");
                    $ownerCircleArray = explode(",", $rule_array['circle']);
                    $ownerCircleArray = implode("|", $ownerCircleArray);
                    $logstring = $ani . "#" . $ownerCircleArray . "#" . $msg . "#" . $msg_sent_time . "#" . date('his') . "\r\n";
                    error_log($logstring, 3, $log_path);
                }// end here
				else {
				//Main SMS Execution start here 
					include("/var/www/html/hungamacare/honey-bee/new_engagement/engagementSendSms.php");
                     }
				  //Create File to download SMS Rule sent data from Interface
				 include("/var/www/html/hungamacare/honey-bee/new_engagement/engagementdata.php");
				 include("/var/www/html/hungamacare/honey-bee/new_engagement/createZipFileAfterRuleExecution.php");
                 $data = "ruleid#" . $rows['rule_id'] . "#timeslot#" . $rows['time_slot'] . "\r\n";
                 error_log($data, 3, $processlog);
              
            } else {
             //Message not found for this rule- No SMS Will Push --save for logs only 
			$insertquery2 = "insert into honeybee_sms_engagement.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id,msg_sent_status) values('0', now(), '$rule_array[service_id]', 10,'$rule_array[scenerios]','$rule_id',10)";
             mysql_query($insertquery2, $dbConn);

                $UpdateRule = "update honeybee_sms_engagement.tbl_rule_engagement set last_processed_time=now(),status=5 where id=" . $rule_id . "";
                $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);
		         $logData = "Message not found for this rule-".$rule_id."No SMS Will Push --save for logs only #".date('Y-m-d H:i:s')."\n\r";
                error_log($logData, 3, $msgnotsentlog);
                //close database connection
                mysql_close($dbConn);
                exit;
            }
        }
    }
}
echo "done";
mysql_close($dbConn);
exit;
?>