<?php
//require_once("../incs/db.php");
$query = "select count(*),service_id,type,date(added_on) from honeybee_sms_engagement.tbl_new_engagement_log where date(added_on) = date(now()) 
    and Type='" . $type . "' and service_id='" . $service_id . "'  and rule_id='" . $rule_id . "'
    and status=1 group by type,service_id,date(added_on) ";
$result = mysql_query($query, $dbConn);
$details = mysql_fetch_array($result);
$curdate = date("d-m-Y");
$donwloadFileptah='SMS_Rule_Execution_' . $rule_id . '_' . $curdate . '.zip';
$insert_query = "insert into  honeybee_sms_engagement.tbl_new_engagement_data(count,added_on,service_id,status,type,duration,rule_id,msg_sent_status,filepath) 
   values (" . $details[0] . ",now()," . $details[1] . ",0,'" . $details[2] . "','" . $details[4] . "','$rule_id',10,'".$donwloadFileptah."')";

if(mysql_query($insert_query, $dbConn))
$queryRuleSummary='SUCCESS';
else
$queryRuleSummary=mysql_error();

$saveRuleSummarydata = $rule_id."#".$queryRuleSummary."#".$insert_query."#".date('Y-m-d H:i:s')."#"."\r\n";
error_log($saveRuleSummarydata, 3, $processlog);
echo 'done';
?>
  