<?php

include ("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

if ($status == 'active') {
    $status_info = "status=1";
} else if ($status == 'pending') {
    $status_info = "status=11";
} else {
    $status_info = "status in(1,11)";
}
$querySMSlog = "/var/www/html/kmis/services/hungamacare/v3/Script/querySMSlog_" . date(Ymd) . ".txt";
$querySMSlog1 = "/var/www/html/kmis/services/hungamacare/v3/Script/ALLSMSTargetd_" . date(Ymd) . ".txt";

function checkDND($mdn) {
    $ch = curl_init();
    //$callBackUrl="http://119.82.69.215:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=".$mdn;
    $dndCheckUrl = "http://119.82.69.215:8080/dndCheck/GetDetail?uname=hundndapi&pwd=hun_dnd_api&mno=" . $mdn;
    curl_setopt($ch, CURLOPT_URL, $dndCheckUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_PROXY, '10.2.34.54:8080');
    $CallBackResponse = curl_exec($ch);
    return $CallBackResponse;
}

echo $query = "select scenerios,service_id,circle,service_base from master_db.tbl_rule_engagement nolock where id='" . $rule_id . "'";
$rule_result = mysql_query($query, $dbConn);
$ruleData = mysql_fetch_array($rule_result);
$actionquery = "select sms_cli,sms_type from master_db.tbl_rule_engagement_action nolock where rule_id='" . $rule_id . "'";
$action_result = mysql_query($actionquery, $dbConn);
$actionData = mysql_fetch_array($action_result);

$sms_cli = $actionData[0];
$sms_type = $actionData[1];
$type = $ruleData[0];
$service_id = $ruleData[1];

$service_base = $ruleData[3];
//

$SMSquery = "select id,message from master_db.tbl_new_sms_engagement nolock where rule_id='" . $rule_id . "' and status=1";
if ($sms_sequence == 'random') {
    $SMSquery .= " ORDER BY RAND() limit 1";
}
echo $SMSquery;
$smsresult = mysql_query($SMSquery, $dbConn);
$smsData = mysql_fetch_array($smsresult);
$msg = $smsData[1];
if ($msg != '') {

    $circle = explode(",", $ruleData[2]);
    $msisdn_count = 0;
    for ($i = 0; $i < count($circle); $i++) {
        echo $Numberquery = "select ANI,type,circle,service_id from master_db.tbl_new_engagement_number nolock where date(added_on)=date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "' and " . $status_info . " and circle='" . $circle[$i] . "'";
        $result = mysql_query($Numberquery, $dbConn);

        $result_num = mysql_num_rows($result);
        $msisdn_count = $msisdn_count + $result_num;

        while ($smsRecord = mysql_fetch_row($result)) {

            $response = '';
            echo $response = checkDND($smsRecord[0]);
            if ($response == 'ND') {
                $response = 'ND';
            } else if ($response == 'preference:0<>opstype:D') {
                $response = 'ND';
            }

            $dndResponse_OUT = $rule_id . "#" . $smsRecord[0] . "#" . $response . "\r\n";
            error_log($dndResponse_OUT, 3, $querySMSlog1);
            if ($response == 'ND') {
                //number not in DND >> call procedure and save for output file
//                if ($sms_type == 'engagement') {
//                    echo $procedureCall = "CALL master_db.SENDSMS(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "',2,'51050','promo')";
//                } else {
//                    echo $procedureCall = "CALL master_db.SENDSMS(" . $ani . ",'" . $msg . "','" . $rows['sms_cli'] . "',0,'51050','promo')";
//                }
                //$result1 = mysql_query($procedureCall, $dbConn);
                $sendSMSQuery = $rule_id . "#" . $smsRecord[0] . "#" . $msg . "\r\n";
                error_log($sendSMSQuery, 3, $querySMSlog);

                // if ($result1) {
                echo $insertquery = "insert into master_db.tbl_new_engagement_log(ANI,circle,message,added_on,service_id,status,type,rule_id,service_base) 
     values('$smsRecord[0]', '$smsRecord[2]','$msg',now(), '$service_id', 1,'$type','$rule_id','$service_base')";
                $EXeresult = mysql_query($insertquery, $dbConn);
                // }
            }
        }
    }
    if ($msisdn_count == 0) {
        $insertquery1 = "insert into master_db.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id,msg_sent_status)
     values('0',now(), '$ruleData[service_id]', 9,'$ruleData[scenerios]','$rule_id',10)";
        mysql_query($insertquery1, $dbConn);
    }

    echo $Update = "update master_db.tbl_new_sms_engagement set status=10 where id=" . $smsData[0] . "";
    $EXEresult = mysql_query($Update, $dbConn);

    $CheckSMSquery = "select id,message from master_db.tbl_new_sms_engagement nolock where rule_id='" . $rule_id . "' and status=1";
    $Checksmsresult = mysql_query($CheckSMSquery, $dbConn);
    $ChecksmsData = mysql_fetch_array($Checksmsresult);
    $Checkmsg = $ChecksmsData[1];
    if (!($Checkmsg)) {
        $Update = "update master_db.tbl_rule_engagement set status=5 where id=" . $rule_id . "";
        $EXEresult = mysql_query($Update, $dbConn);
    }
} else {

    $insertquery2 = "insert into master_db.tbl_new_engagement_data(count,added_on,service_id,status,type,rule_id,msg_sent_status)
     values('0',now(), '$ruleData[service_id]', 10,'$ruleData[scenerios]','$rule_id',10)";
    mysql_query($insertquery2, $dbConn);
//status>> 1 ( Message Send)
//10 >> No message found
//9>> No records found
}
echo "<br>";
?>
  