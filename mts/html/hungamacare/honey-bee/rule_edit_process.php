<?php
session_start();
require_once("incs/db.php");
$rule_id = $_REQUEST['rule_id'];
$circle = $_REQUEST['edit_circle'];
$service_base = $_REQUEST['service_edit_base'];
$filter_base = $_REQUEST['filter_edit_base'];
$scenarios = $_REQUEST['edit_scenarios'];
$edit_dnd_scrubbing = $_REQUEST['edit_dnd_scrubbing'];
$action_name = $_REQUEST['data_action'];
$action_base = $_REQUEST['action_edit_base'];

$sms_sequence = $_REQUEST['sms_edit_sequence'];
$sms_cli = $_REQUEST['sms_edit_cli'];
$email_user = $_REQUEST['email_edit_user'];
$cc_user = $_REQUEST['add_edit_cc'];
$cc_user = implode(',', $cc_user);

if($action_base =='trigger_time')
{
$time_slot = $_REQUEST['hours'].':'.$_REQUEST['minutes'];
}
else if($action_base =='call_hang_up')
{
$time_slot = '';
}
else if($action_base =='pre_defined_time') {
$time_slot = date('h:i A', strtotime($_REQUEST['edit_time_slot']));
}

$upload_file = $_REQUEST['upload_edit_file'];
$service_id = $_REQUEST['service_id'];
$loginid = $_SESSION['loginId'];



$circle = implode(',', $circle);

$select_scenerios_qry = "select rule.id from honeybee_sms_engagement.tbl_rule_engagement rule, honeybee_sms_engagement.tbl_rule_engagement_action action 
                         where rule.circle='" . $circle . "' and rule.service_id='" . $service_id . "' and rule.service_base='" . $service_base . "' 
                         and rule.filter_base='" . $filter_base . "' and rule.scenerios='" . $scenarios . "' 
                         and rule.dnd_scrubbing='" . $edit_dnd_scrubbing . "'  and rule.added_by='" . $loginid . "' 
                          and action.action_name='" . $action_name . "' and rule.id=action.rule_id and rule.status in (1,5) and rule.id !='" . $rule_id . "'";
$select_scenerios_qryEx = mysql_query($select_scenerios_qry, $dbConn);
$old_rule_id_deatils = mysql_fetch_array($select_scenerios_qryEx);
$old_rule_id = $old_rule_id_deatils['id'];
if ($old_rule_id) {
    $update_query = "update honeybee_sms_engagement.tbl_rule_engagement set status=0 where id='" . $old_rule_id . "'";
    mysql_query($update_query, $dbConn);
}

$update_query = "update honeybee_sms_engagement.tbl_rule_engagement set  circle='" . $circle . "', service_base='" . $service_base . "', filter_base='" . $filter_base . "' , scenerios='" . $scenarios . "', dnd_scrubbing='" . $edit_dnd_scrubbing . "', last_modified=now() where id='" . $rule_id . "'";
mysql_query($update_query, $dbConn);
 
	
    if ($_FILES['upload_edit_file']['name'] != '') {
        $obd_form_mob_file = $_FILES['upload_edit_file']['name'];
        $curdate = date("Y_m_d-H_i_s");
        if (isset($_FILES['upload_edit_file']) && !empty($_FILES['upload_edit_file']['name'])) {
            $lines = file($_FILES['upload_edit_file']['tmp_name']);
            $isok;
            $count = 0;

            if (!empty($obd_form_mob_file)) {
                $i = strrpos($obd_form_mob_file, ".");
                $l = strlen($obd_form_mob_file) - $i;
                $ext = substr($obd_form_mob_file, $i + 1, $l);
                $ext = 'csv';

                $createfilename = "msgfile_" . $curdate . '.' . $ext;
                $pathtofile = "MSGFile/" . $createfilename;
                if (copy($_FILES['upload_edit_file']['tmp_name'], $pathtofile)) {

$updateMsh = "update honeybee_sms_engagement.tbl_new_sms_engagement set status = 0 where rule_id='" . $rule_id . "'";
$exeQry = mysql_query($updateMsh, $dbConn);
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
	values('$rule_id', '$escape_msg','$smstype',1,now())";
	if (mysql_query($insertDump, $dbConn))
	$isupload = true;
	else
	$isupload = false;
	}
}
// code end for csv					
}
ini_set('auto_detect_line_endings',FALSE);
fclose($f_pointer);
}
        }
        $updatequery = "update honeybee_sms_engagement.tbl_rule_engagement_action set  sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "' , upload_file='" . $createfilename . "' , time_slot='" . $time_slot . "', cc_user='" . $cc_user . "'
                where rule_id=" . $rule_id . "";
    } else {
        $updatequery = "update honeybee_sms_engagement.tbl_rule_engagement_action set  sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "' , time_slot='" . $time_slot . "', cc_user='" . $cc_user . "'  where rule_id=" . $rule_id . "";
    }

$result = mysql_query($updatequery, $dbConn);
mysql_close($dbConn);
exit;
?>