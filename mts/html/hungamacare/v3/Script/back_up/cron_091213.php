<?php

//include database connection file
require_once("../incs/db.php");
$processlog = "/var/www/html/hungamacare/v3/Script/logs/processlog_" . date(Ymd) . ".txt";
echo $nowtime = date('H:i');
$date = date("dmy", mktime(0, 0, 0, date('m'), date('d'), date('Y')));
$qry = "select rule_id,time_slot,action_name,sms_cli from master_db.tbl_rule_engagement_action where status=1 and time_slot='" . $nowtime . "' and 
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
        $selectDisplayQuery = "SELECT service_id,service_base,scenerios,dnd_scrubbing,circle,added_by
                                FROM master_db.tbl_rule_engagement where id='" . $rows['rule_id'] . "'";
        $queryDisplaySel = mysql_query($selectDisplayQuery, $dbConn);
        $rule_array = mysql_fetch_array($queryDisplaySel);
        $status = $rule_array['service_base'];
        $service_id = $rule_array['service_id'];
        echo $type = $rule_array['scenerios'];
        if ($type == '35') {
            $SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rows['rule_id'] . "' and status=1";
            $smsresult = mysql_query($SMSquery, $dbConn);
            $smsData = mysql_fetch_array($smsresult);
            $msg = $smsData[1];
            if ($msg != '') {
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
                echo $log_path = "/var/www/html/hungamacare/v3/logs/" . $service_id . "/" . $type . "/" . $rule_id . "_" . $date . ".log";
                unlink($log_path);
                echo $logstring = $ani . "#" . $rule_array['circle'] . "#" . $msg . "#" . $date . "#" . date('his') . "\r\n";
                error_log($logstring, 3, $log_path);
            }
        } else {
//            if ($type == '1' || $type == '2' || $type == '3' || $type == '4' || $type == '5') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_MOU.php");
//            }
//            if ($type == '6' || $type == '7' || $type == '8' || $type == '9' || $type == '10' || $type == '11' || $type == '12' || $type == '13') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_Call.php");
//            }
//            if ($type == '14' || $type == '15' || $type == '16' || $type == '17') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_noCall.php");
//            }
//            if ($type == '18' || $type == '19' || $type == '20' || $type == '21' || $type == '22') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_ageOfservice.php");
//            }
//            if ($type == '23' || $type == '24') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_crbtDwnld.php");
//            }
//            if ($type == '25' || $type == '26' || $type == '27' || $type == '28') {
//                include("/var/www/html/hungamacare/v3/new_engagement/new_engagementlog_nonCrbtDwnld.php");
//            }

            include("/var/www/html/hungamacare/v3/new_engagement/new_engagementSendSms.php");

            include("/var/www/html/hungamacare/v3/new_engagement/new_engagementdata.php");

            include("/var/www/html/hungamacare/v3/new_engagement/createNewEngagementDwnFile.php");
        }
        $data = "ruleid#" . $rows['rule_id'] . "#timeslot#" . $rows['time_slot'] . "\r\n";
        error_log($data, 3, $processlog);
    }
}
mysql_close($dbConn);
exit;
?>