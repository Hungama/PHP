<?php

//include database connection file
require_once("../incs/db.php");
$processlog = "/var/www/html/hungamacare/v3/Script/logs/processlog_" . date(Ymd) . ".txt";
echo $nowtime = date('H:i');
echo $nowtime = date('h:i A', strtotime($nowtime));
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$qry = "select rule_id,time_slot,action_name,sms_cli,sms_sequence from master_db.tbl_rule_engagement_action where status=1 and time_slot='" . $nowtime . "' and 
    action_name='sms'";
$checkrule = mysql_query($qry, $dbConn);
$noofrows = mysql_num_rows($checkrule);
if ($noofrows == 0) {
    $logData = 'No Rule to process' . "\n\r";
    echo $logData;
//close database connection
    mysql_close($dbConn);
    exit;
} else {
    while ($rows = mysql_fetch_array($checkrule)) {
        $rule_id = $rows['rule_id'];
        $sms_sequence = $rows['sms_sequence'];
        $selectDisplayQuery = "SELECT service_id,service_base,scenerios,dnd_scrubbing,circle,added_by
                                FROM master_db.tbl_rule_engagement where id='" . $rows['rule_id'] . "' and status=1";
        $queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
        $rule_array = mysql_fetch_array($queryDisplaySel);
        $status = $rule_array['service_base'];
        $service_id = $rule_array['service_id'];
        echo $type = $rule_array['scenerios'];
        $noofRulerows = mysql_num_rows($queryDisplaySel);
        if ($noofRulerows == 0) {
            $logData = 'No Rule to process' . "\n\r";
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
                    echo $procedureCall = "call master_db.SENDSMS_NEW(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "','mtsm')";
                    $result1 = mysql_query($procedureCall, $dbConn);
                    $insert_query = "insert into master_db.tbl_new_engagement_data (count,added_on,service_id,status,type,rule_id) 
                                  values (1,now()," . $rule_array['service_id'] . ",0,'" . $type . "','$rule_id')";
                    mysql_query($insert_query, $dbConn);
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

                    echo $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
                    unlink($log_path);
                    $msg_sent_time = date("jS F Y h:i:s A");
                    echo $logstring = $ani . "#" . $rule_array['circle'] . "#" . $msg . "#" . $msg_sent_time . "#" . date('his') . "\r\n";
                    error_log($logstring, 3, $log_path);
                } else {
                    include("/var/www/html/hungamacare/v3/new_engagement/new_engagementSendSms.php");

                    include("/var/www/html/hungamacare/v3/new_engagement/new_engagementdata.php");

                    include("/var/www/html/hungamacare/v3/new_engagement/createNewEngagementDwnFile.php");
                }
            }
            $data = "ruleid#" . $rows['rule_id'] . "#timeslot#" . $rows['time_slot'] . "\r\n";
            error_log($data, 3, $processlog);
        }
    }
}
mysql_close($dbConn);
exit;
?>