<?php

session_start();
require_once("../2.0/incs/db.php");
$rule_id = $_REQUEST['rule_id'];
$circle = $_REQUEST['edit_circle'];
$service_base = $_REQUEST['service_edit_base'];
$filter_base = $_REQUEST['filter_edit_base'];
$scenarios = $_REQUEST['edit_scenarios'];
$edit_dnd_scrubbing = $_REQUEST['edit_dnd_scrubbing'];
$action_name = $_REQUEST['data_action'];
$sms_sequence = $_REQUEST['sms_edit_sequence'];
$sms_cli = $_REQUEST['sms_edit_cli'];
$email_user = $_REQUEST['email_edit_user'];
$cc_user = $_REQUEST['add_edit_cc'];
$cc_user = implode(',', $cc_user);
$time_slot = $_REQUEST['edit_time_slot'];
$upload_file = $_REQUEST['upload_edit_file'];
$service_id = $_REQUEST['service_id'];
$loginid = $_SESSION['loginId'];
$sms_type = $_REQUEST['sms_edit_type'];

$time_slot = date('h:i A', strtotime($time_slot));

$circle = implode(',', $circle);

$select_scenerios_qry = "select rule.id from master_db.tbl_rule_engagement rule, master_db.tbl_rule_engagement_action action 
                         where rule.circle='" . $circle . "' and rule.service_id='" . $service_id . "' and rule.service_base='" . $service_base . "' 
                         and rule.filter_base='" . $filter_base . "' and rule.scenerios='" . $scenarios . "' 
                         and rule.dnd_scrubbing='" . $edit_dnd_scrubbing . "'  and rule.added_by='" . $loginid . "' 
                          and action.action_name='" . $action_name . "'  and action.sms_type='" . $sms_type . "' 
                              and rule.id=action.rule_id and rule.status in (1,5) and rule.id !='" . $rule_id . "'";
$select_scenerios_qryEx = mysql_query($select_scenerios_qry, $dbConn);
$old_rule_id_deatils = mysql_fetch_array($select_scenerios_qryEx);
$old_rule_id = $old_rule_id_deatils['id'];
if ($old_rule_id) {
    $update_query = "update master_db.tbl_rule_engagement set status=0 where id='" . $old_rule_id . "'";
    mysql_query($update_query, $dbConn);
}

echo $update_query = "update master_db.tbl_rule_engagement set  circle='" . $circle . "', service_base='" . $service_base . "', filter_base='" . $filter_base . "' , scenerios='" . $scenarios . "', last_modified=now() where id='" . $rule_id . "'";
mysql_query($update_query, $dbConn);

if ($action_name == 'sms') {
    echo 'file name=' . $_FILES['upload_edit_file']['name'] . "<br/>";
    if ($_FILES['upload_edit_file']['name'] != '') {
        $obd_form_mob_file = $_FILES['upload_edit_file']['name'];
        $curdate = date("Y_m_d-H_i_s");
        if (isset($_FILES['upload_edit_file']) && !empty($_FILES['upload_edit_file']['name'])) {
            $lines = file($_FILES['upload_edit_file']['tmp_name']);
            $isok;
            $count = 0;
            foreach ($lines as $line_num => $mobno) {
                $mno = trim($mobno);
                if (!empty($mno)) {
                    $count++;
                }
            }
            if ($count > 25000) {
                echo "<div width=\"85%\" align=\"left\" class=\"txt\">
  <div class=\"alert alert-danger\">Please upload file of less than 25,000 numbers otherwise it will not process.</div></div>";
                exit;
            }


            if (!empty($obd_form_mob_file)) {
                $i = strrpos($obd_form_mob_file, ".");
                $l = strlen($obd_form_mob_file) - $i;
                $ext = substr($obd_form_mob_file, $i + 1, $l);
                $ext = 'txt';

                $createfilename = "msgfile_" . $curdate . '.' . $ext;
                $pathtofile = "MSGFile/" . $createfilename;
                if (copy($_FILES['upload_edit_file']['tmp_name'], $pathtofile)) {

                    echo $updateMsh = "update master_db.tbl_new_sms_engagement set status = 0 where rule_id='" . $rule_id . "'";
                    $exeQry = mysql_query($updateMsh, $dbConn);

                    /////////////////////////////
                    $lines = file($pathtofile);
                    $allmessage = '';
                    foreach ($lines as $line_num => $msg) {
                        $allmessage.=$msg;
                    }
                    $order = array("\r\n", "\n", "\r");
                    $replace = '<br />';
                    $newstr = str_replace($order, $replace, $allmessage);
                    $totalmessage = explode("<br />", $newstr);
                    foreach ($totalmessage as $allmessage) {
                        if (trim($allmessage) != '') {
                            $escape_msg = mysql_escape_string($allmessage);
                            $insertDump = "insert into master_db.tbl_new_sms_engagement(rule_id,Message,status,added_on) 
     values('$rule_id', '$escape_msg',1,now())";
                            if (mysql_query($insertDump, $dbConn)) {
                                $isupload = true;
                            } else {
                                $isupload = false;
                            }
                        }
                    }
                    //////////////////////////
                }
            }
        }
        echo $insertquery = "update master_db.tbl_rule_engagement_action set  sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "' , upload_file='" . $createfilename . "' , time_slot='" . $time_slot . "', cc_user='" . $cc_user . "'
             , sms_type='" . $sms_type . "'   where rule_id=" . $rule_id . "";
    } else {
        echo $insertquery = "update master_db.tbl_rule_engagement_action set  sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "' , time_slot='" . $time_slot . "', cc_user='" . $cc_user . "'  
                , sms_type='" . $sms_type . "' where rule_id=" . $rule_id . "";
    }
} else {
    echo $insertquery = "update master_db.tbl_rule_engagement_action set email_user='" . $email_user . "' ,
            cc_user='" . $cc_user . "' , time_slot='" . $time_slot . "'  
                 where rule_id=" . $rule_id . "";
}
$result = mysql_query($insertquery, $dbConn);
mysql_close($dbConn);
exit;
?>