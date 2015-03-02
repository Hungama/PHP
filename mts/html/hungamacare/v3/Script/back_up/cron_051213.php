<?php

//include database connection file
require_once("../incs/db.php");
$processlog = "/var/www/html/hungamacare/v3/Script/logs/processlog_" . date(Ymd) . ".txt";
echo $nowtime = date('H:i');
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
        echo $type = $rule_array['scenerios'];
        if ($type == '35') {
            $SMSquery = "select id,message from master_db.tbl_new_sms_engagement where rule_id='" . $rows['rule_id'] . "' and status=1";
            $smsresult = mysql_query($SMSquery, $dbConn);
            $smsData = mysql_fetch_array($smsresult);
            $msg = $smsData[1];
            $emailidquery = "select mobile from master_db.live_user_master where username='" . $rule_array['added_by'] . "' ";
            $emailidresult = mysql_query($emailidquery, $dbConn);
            $emailidData = mysql_fetch_array($emailidresult);
            $ani = $emailidData['mobile'];
            $procedureCall = "call master_db.SENDSMS_NEW(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "','mtsm')";
            $result1 = mysql_query($procedureCall, $dbConn);
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
        $data = "ruleid#".$rows['rule_id'] . "#timeslot#" . $rows['time_slot'];
        error_log($data, 3, $processlog);
    }
}
mysql_close($dbConn);
exit;
?>