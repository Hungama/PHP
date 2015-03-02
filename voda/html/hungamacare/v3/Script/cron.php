<?php
//include database connection file
include ("/var/www/html/hungamacare/2.0/incs/db.php");
$processlog = "/var/www/html/hungamacare/v3/Script/logs/processlog_" . date(Ymd) . ".txt";
$querylog = "/var/www/html/hungamacare/v3/Script/querylog_" . date(Ymd) . ".txt";
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence,sms_type from master_db.tbl_rule_engagement_temp_process where status=0 and action_name='sms' limit 1";
$queryData = $qry . "\r\n";
//error_log($queryData, 3, $querylog);

$checkrule = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process1' . "\n\r";
    echo $logData;
    mysql_close($dbConn);
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
        $rule_id = $rows['rule_id'];
        $sms_sequence = $rows['sms_sequence'];

        $updateQuery_rule = "UPDATE master_db.tbl_rule_engagement_temp_process SET status = 1 WHERE rule_id = " . $rule_id;
        mysql_query($updateQuery_rule, $dbConn);

        echo $selectDisplayQuery = "SELECT service_id,service_base,scenerios,dnd_scrubbing,circle,added_by
                                FROM master_db.tbl_rule_engagement where id='" . $rows['rule_id'] . "' and status=1";
        $queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
        $rule_array = mysql_fetch_array($queryDisplaySel);
        $status = $rule_array['service_base'];
        $service_id = $rule_array['service_id'];
        $type = $rule_array['scenerios'];
        echo $noofRulerows = mysql_num_rows($queryDisplaySel);
        if ($noofRulerows == 0) {
            $logData = 'No Rule to process2' . "\n\r";
            echo $logData;
            //close database connection
            mysql_close($dbConn);
            exit;
        } else {
            $SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rows['rule_id'] . "' and status=1";
            if ($sms_sequence == 'random') {
                $SMSquery .= " ORDER BY RAND() limit 1";
            }
            $smsresult = mysql_query($SMSquery, $dbConn);
            $smsData = mysql_fetch_array($smsresult);
            $msg = $smsData[1];
            if ($msg != '') {
                if ($type == '35') {
                    $emailidquery = "select mobile from master_db.live_user_master where username='" . $rule_array['added_by'] . "' ";
                    $emailidresult = mysql_query($emailidquery, $dbConn);
                    $emailidData = mysql_fetch_array($emailidresult);
                    $ani = $emailidData['mobile'];
                    
					$procedureCall = "CALL master_db.SENDSMS_BULK('".$ani."','" . $msg . "',";
                    switch ($service_id) {
                        case '1302':
						case '1307':
						case '1310':
								$smscli='54646';
								$procedureCall .= "'$rows[sms_cli]','sms-promo','1')";
							break;
						case '1301':
								$smscli='55665';
								$procedureCall .= "'$rows[sms_cli]','sms-promo','1')";
                            break;
                    }
					
					
                  $result1 = mysql_query($procedureCall, $dbConn);
                    $insertLog_query = "insert into master_db.tbl_new_engagement_log (ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
                                  values ('" . $ani . "','" . $rule_array['circle'] . "','" . $msg . "',now(),'" . $rule_array['service_id'] . "',0,'" . $type . "','$rule_id','" . $rule_array['service_base'] . "')";
                    mysql_query($insertLog_query, $dbConn);
                    $insert_query = "insert into master_db.tbl_new_engagement_data (count,added_on,service_id,status,type,rule_id,msg_sent_status) 
                                  values (1,now()," . $rule_array['service_id'] . ",0,'" . $type . "','$rule_id',10)";
                    mysql_query($insert_query, $dbConn);

                    $UpdateRule = "update master_db.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
                    $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);

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

                    $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
                    unlink($log_path);
                    $msg_sent_time = date("jS F Y h:i:s A");
                    $ownerCircleArray = explode(",", $rule_array['circle']);
                    $ownerCircleArray = implode("|", $ownerCircleArray);
                    echo $logstring = $ani . "#" . $ownerCircleArray . "#" . $msg . "#" . $msg_sent_time . "#" . date('his') . "\r\n";
                    error_log($logstring, 3, $log_path);
                } else {
				echo "Step 1";
				 include("/var/www/html/hungamacare/v3/new_engagement/new_engagementSendSms.php");
				echo "Step 2";
                  include("/var/www/html/hungamacare/v3/new_engagement/new_engagementdata.php");
				echo "Step 3";
                  include("/var/www/html/hungamacare/v3/new_engagement/createNewEngagementDwnFile.php");
                }
                $data = "ruleid#" . $rows['rule_id'] . "#timeslot#" . $rows['time_slot'] . "\r\n";
                error_log($data, 3, $processlog);
            } else {
                $insertquery2 = "insert into master_db.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id,msg_sent_status) 
     values('0', now(), '$rule_array[service_id]', 10,'$rule_array[scenerios]','$rule_id',10)";
                mysql_query($insertquery2, $dbConn);

                $UpdateRule = "update master_db.tbl_rule_engagement set last_processed_time=now() where id=" . $rule_id . "";
                $UpdateRuleEXEresult = mysql_query($UpdateRule, $dbConn);

                $logData = 'No Rule to process3' . "\n\r";
                echo $logData;
                //close database connection
                mysql_close($dbConn);
                exit;
            }
        }
    }
}
echo "Done";
mysql_close($dbConn);
exit;
?>