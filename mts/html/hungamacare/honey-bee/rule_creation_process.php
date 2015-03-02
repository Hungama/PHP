<?php
session_start();
require_once("incs/db.php");
$rule_name = $_REQUEST['rule_name'];
$service = $_REQUEST['service'];
$circle = $_REQUEST['circle'];
$action_base = $_REQUEST['action_base'];
$service_base = $_REQUEST['service_base'];
$filter_base = $_REQUEST['filter_base'];
$scenarios = $_REQUEST['scenarios'];
$dnd_scrubbing = $_REQUEST['dnd_scrubbing'];
$loginid=$_SESSION['loginId'];
$circle = implode(',', $circle);
$tagsinput=$_REQUEST['tagsinput'];
$logPath="logs/Request_".date('Ymd').".txt";
$logData=$rule_name."#".$tagsinput."#".date("Y-m-d H:i:s")."\n";
//error_log($logData,3,$logPath);

//action name process
if($action_base=='trigger_time')
{
$action_name = 'sms_trigger_time';
$time_slot = $_REQUEST['hours'].':'.$_REQUEST['minutes'];
$service_base='';
$filter_base='';
$scenarios='';
}
elseif($action_base=='call_hang_up')
{
$action_name = 'sms_call_hang_up';
$time_slot = '';
$service_base='';
$filter_base='';
$scenarios='';
}
elseif($action_base=='pre_defined_time')
{
$action_name = 'sms_pre_defined_time';
$time_slot = $_REQUEST['time_slot'];
$time_slot = date('h:i A', strtotime($time_slot));
}

//check the one service have one circle in call hang up and transition -->
if($action_base=='call_hang_up' || $action_base=='trigger_time' || $action_base=='pre_defined_time')
{
$checkCircleRuleQry = "select count(1) as total from honeybee_sms_engagement.tbl_rule_engagement nolock
 where service_id='" . $service . "' and action_base='" . $action_base . "' and circle in('$circle') and status='1'";
$checkresult = mysql_query($checkCircleRuleQry, $dbConn);
list($noofcircle)=mysql_fetch_array($checkresult);
}
else{
$noofcircle='0';
}
if($noofcircle==0)
{
//circle insert check

$insertquery = "insert into honeybee_sms_engagement.tbl_rule_engagement(rule_name,service_id,action_base,service_base,filter_base,scenerios,dnd_scrubbing,status,added_on,added_by,circle) values('$rule_name', '$service','$action_base','$service_base', '$filter_base', '$scenarios', '$dnd_scrubbing',11,now(),'$loginid','$circle')";
$result = mysql_query($insertquery, $dbConn);

$sms_sequence = $_REQUEST['sms_sequence'];
$sms_cli = $_REQUEST['sms_cli'];
$upload_file = $_REQUEST['upload_file'];
$email_user = $_REQUEST['email_user'];
$loginid = $_SESSION['loginId'];
$selQry = "select max(id) from honeybee_sms_engagement.tbl_rule_engagement";
$selQryEx = mysql_query($selQry, $dbConn);
$rule_id = mysql_fetch_row($selQryEx);

$selRuleDetailsQry = "select circle,service_id,service_base,filter_base,scenerios,dnd_scrubbing 
from honeybee_sms_engagement.tbl_rule_engagement nolock where id='" . $rule_id[0] . "'";
$selRuleDetailsQryEx = mysql_query($selRuleDetailsQry, $dbConn);
$details = mysql_fetch_array($selRuleDetailsQryEx);

$select_scenerios_qry = "select rule.id from honeybee_sms_engagement.tbl_rule_engagement rule, honeybee_sms_engagement.tbl_rule_engagement_action action 
                         where rule.circle='" . $details['circle'] . "' and rule.service_id='" . $details['service_id'] . "' 
                             and rule.service_base='" . $details['service_base'] . "' 
                         and rule.filter_base='" . $details['filter_base'] . "' and rule.scenerios='" . $details['scenerios'] . "' 
                            and rule.dnd_scrubbing='" . $details['dnd_scrubbing'] . "'  and rule.added_by='" . $loginid . "' 
                          and action.action_name='" . $action_name . "' and rule.id=action.rule_id and rule.status in (1,5)";
$select_scenerios_qryEx = mysql_query($select_scenerios_qry, $dbConn);
$old_rule_id_deatils = mysql_fetch_array($select_scenerios_qryEx);
$old_rule_id = $old_rule_id_deatils['id'];
if ($old_rule_id) {
    $update_query = "update honeybee_sms_engagement.tbl_rule_engagement set status=0 where id='" . $old_rule_id . "'";
    mysql_query($update_query, $dbConn);
}
$action_name1='sms';
if ($action_name1 == 'sms') {

$obd_form_mob_file = $_FILES['upload_file']['name'];
$curdate = date("Y_m_d-H_i_s");
    if (isset($_FILES['upload_file']) && !empty($_FILES['upload_file']['name'])) {
        $lines = file($_FILES['upload_file']['tmp_name']);
        $isok;
        $count = 0;

if (!empty($obd_form_mob_file)) {
$i = strrpos($obd_form_mob_file, ".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file, $i + 1, $l);
$ext = 'csv';

$createfilename = "msgfile_" . $curdate . '.' . $ext;
$pathtofile = "MSGFile/" . $createfilename;
if (copy($_FILES['upload_file']['tmp_name'], $pathtofile)) {
/* $fGetContents = file_get_contents($pathtofile);
$e = explode("\n", $fGetContents);
$totalcount=count($e); */
ini_set('auto_detect_line_endings',TRUE);
$f_pointer=fopen($pathtofile,"r"); // file pointer
while (($ar = fgetcsv($f_pointer, 10000, ",")) !== FALSE)
{
$smstype=$ar[0];
$escape_msg = $ar[1];

$insertDump='';
if(strtolower($smstype)!='type' && strtolower($escape_msg)!='message' && $escape_msg!='' && $smstype!='')
{
$insertDump = "insert into honeybee_sms_engagement.tbl_new_sms_engagement(rule_id,Message,message_type,status,added_on) 
values('$rule_id[0]', '$escape_msg','$smstype',1,now())";
	if (mysql_query($insertDump, $dbConn))
	$isupload = true;
	else
	$isupload = false;

}
}
ini_set('auto_detect_line_endings',FALSE);
fclose($f_pointer);

/* for ($i = 1; $i < $totalcount; $i++) { 
$data = explode(",", $e[$i]);
if($totalcount!=$i+1)
{
$smstype=$data[0];
$smsmessage=str_replace("\"", "", trim($data[1]));
$smsmessage=str_replace("’", "'", $smsmessage);
$logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status.'#'.trim($data[2])."#".$addedon."\r\n";
if (trim($smsmessage) != '') {
$escape_msg = mysql_escape_string($smsmessage);
$insertDump = "insert into honeybee_sms_engagement.tbl_new_sms_engagement(rule_id,Message,message_type,status,added_on) 
values('$rule_id[0]', '$escape_msg','$smstype',1,now())";
if (mysql_query($insertDump, $dbConn)) {
$isupload = true;
} else {
$isupload = false;
}
}
}
}
*/

}
}

$insertquery = "insert into honeybee_sms_engagement.tbl_rule_engagement_action(rule_id,action_name,sms_sequence,sms_cli,time_slot,upload_file,status,added_on,added_by,cc_user,email_user) 
values('$rule_id[0]', '$action_name','$sms_sequence', '$sms_cli', '$time_slot', '$createfilename',1,now(),'$loginid','$add_cc','$email_user')";
    }
	$result = mysql_query($insertquery, $dbConn);
$updateQry = "update honeybee_sms_engagement.tbl_rule_engagement set status=1 where id='" . $rule_id[0] . "'";
$ExeupdateQry = mysql_query($updateQry, $dbConn);
echo "rule has been created successfully.";
}
}
else{
echo "Rule already exist in this circle for this service.";

}
//end
mysql_close($dbConn);
exit;
?>