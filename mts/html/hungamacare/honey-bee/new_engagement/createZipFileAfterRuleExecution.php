<?php
error_reporting(0);
require_once("/var/www/html/hungamacare/honey-bee/incs/db.php");
$RuleEngamentprocesslog = "/var/www/html/hungamacare/honey-bee/Script/logs/createRuleFile_" . date('Ymd') . ".txt";
$logstring_cron = $rule_id . "#createZipFileAfterRuleExecution.php start#" . date('his') . "\r\n";
error_log($logstring_cron, 3, $RuleEngamentprocesslog);
function create_zip($files = array(), $destination = '', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //vars
    $valid_files = array();
    //if files were passed in...
    if (is_array($files)) {
        //cycle through each file
        foreach ($files as $file) {
            //make sure the file exists
            if (file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }
    //if we have good files...
    if (count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach ($valid_files as $file) {
            $zip->addFile($file, $file);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    } else {
        return false;
    }
}

$circle_info = array('GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
//$rule_id=33;
$get_rule_info = "select rule_name,service_id,service_base,filter_base,scenerios,dnd_scrubbing,added_on,circle
from honeybee_sms_engagement.tbl_rule_engagement nolock where id='" . $rule_id . "'";
$rule_data = mysql_query($get_rule_info, $dbConn);
$rule_details = mysql_fetch_array($rule_data);

$emailidquery = "select email from master_db.live_user_master nolock where username='" . $rule_array['added_by'] . "' ";
$emailidresult = mysql_query($emailidquery, $dbConn);
$emailidData = mysql_fetch_array($emailidresult);
$email_id = $emailidData['email'];
$curdate = date("d-m-Y");

$mailIdquery = "select cc_user from honeybee_sms_engagement.tbl_rule_engagement_action nolock where rule_id='" . $rule_id . "'";
$mailId_result = mysql_query($mailIdquery, $dbConn);
$mailIdData = mysql_fetch_array($mailId_result);
$cc_user_array = explode(",", $mailIdData['cc_user']);

//begin of HTML message 
$Numberquery = "select ANI,circle,message,added_on from honeybee_sms_engagement.tbl_new_engagement_log nolock where date(added_on)=date(now()) and rule_id='" . $rule_id . "'"; //
$result = mysql_query($Numberquery, $dbConn);
$result_total_sms_targeted = mysql_num_rows($result);
$filepathdndcheck_csv = $ruleFilelogPath.$rule_id . '_' . $curdate . '.xls';

$logstring_cron = $rule_id . "#Total MDN-" . $result_total_sms_targeted . "#Inside sendreport-SmsBase Zip file process start#" . date('H:i:s') . "\r\n";
error_log($logstring_cron, 3, $RuleEngamentprocesslog);
unlink($filepathdndcheck_csv);
$logData = "ANI\tCircle\tMessage\tMsg sent time" . "\r\n";
error_log($logData, 3, $filepathdndcheck_csv);
while ($aniRecord = mysql_fetch_row($result)) {
    $msg_sent_time = date('jS F Y h:i:s A', strtotime($aniRecord[3]));
    $circle = $circle_info[$aniRecord[1]];
     $logData = $aniRecord[0] . "\t" . $circle . "\t" . trim($aniRecord[2]) . "\t" . $msg_sent_time . "\r\n";
    error_log($logData, 3, $filepathdndcheck_csv);
}
$logstring_cron = $rule_id . "#Inside sendreport-SmsBase Zip file process start#" . date('H:i:s') . "\r\n";
error_log($logstring_cron, 3, $RuleEngamentprocesslog);
$path = $filepathdndcheck_csv;
$files_to_zip = array($path);

$ruleDonwloadBaseptah="/var/www/html/hungamacare/honey-bee/Script/ruledownloadlogs/";
$ruleDonwloadFileptah=$ruleDonwloadBaseptah.'SMS_Rule_Execution_' . $rule_id . '_' . $curdate . '.zip';
$result = create_zip($files_to_zip,$ruleDonwloadFileptah,true);
$path1 = 'SMS_Rule_Execution_' . $rule_id . '_' . $curdate . '.zip';
unlink($filepathdndcheck_csv);

$logstring_cron = $rule_id . "#Inside sendreport-SmsBase Zip file process end#" . date('H:i:s') . "\r\n";
error_log($logstring_cron, 3, $RuleEngamentprocesslog);
$insert_query = "insert into honeybee_sms_engagement.tbl_send_sms_data_process (rule_id,status,added_on,cc_email,email,filename,Scid,Fid,rule_name,dnd_scrubbing,circle,service_base,service_id)
			   values ('" . $rule_id . "','0',now(),'" . $mailIdData['cc_user'] . "','" . $email_id . "','" . $path1 . "','" . $rule_details['scenerios'] . "','" . $rule_details['filter_base'] . "','" . $rule_details['rule_name'] . "','" . $rule_details['dnd_scrubbing'] . "','" . $rule_details['circle'] . "','" . $rule_details['service_base'] . "','" . $rule_details['service_id'] . "')";
mysql_query($insert_query, $dbConn);
$logstring_cron = $rule_id . "#createZipFileAfterRuleExecution.php end#" . date('H:i:s') . "\r\n";
error_log($logstring_cron, 3, $RuleEngamentprocesslog);
echo "SMS Download File Creation done";
?>