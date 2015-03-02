<?php

session_start();
require_once("incs/db.php");

$action_name = $_REQUEST['action_name'];
$sms_sequence = $_REQUEST['sms_sequence'];
$sms_cli = $_REQUEST['sms_cli'];
$time_slot = $_REQUEST['time_slot'];
$time_slot = date('h:i A', strtotime($time_slot));
//if ($action_name == 'sms') {
//    $time_slot = $_REQUEST['sms_time_slot'];
//    $min = $_REQUEST['sms_min'];
//    //$sec = $_REQUEST['sms_sec'];
//} else {
//    $time_slot = $_REQUEST['email_time_slot'];
//    $min = $_REQUEST['email_min'];
//    //$sec = $_REQUEST['email_sec'];
//}
//$time_slot = $time_slot . ":" . $min . ":" . $sec;
//$time_slot = $time_slot . ":" . $min;
$upload_file = $_REQUEST['upload_file'];
$email_user = $_REQUEST['email_user'];
$add_cc = $_REQUEST['add_cc'];
$add_cc = implode(',', $add_cc);
$loginid = $_SESSION['loginId'];
$selQry = "select max(id) from master_db.tbl_rule_engagement";
$selQryEx = mysql_query($selQry, $dbConn);
$rule_id = mysql_fetch_row($selQryEx);

$selRuleDetailsQry = "select circle,service_id,service_base,filter_base,scenerios,dnd_scrubbing from master_db.tbl_rule_engagement where id='" . $rule_id[0] . "'";
$selRuleDetailsQryEx = mysql_query($selRuleDetailsQry, $dbConn);
$details = mysql_fetch_array($selRuleDetailsQryEx);

$select_scenerios_qry = "select rule.id from master_db.tbl_rule_engagement rule, master_db.tbl_rule_engagement_action action 
                         where rule.circle='" . $details['circle'] . "' and rule.service_id='" . $details['service_id'] . "' 
                             and rule.service_base='" . $details['service_base'] . "' 
                         and rule.filter_base='" . $details['filter_base'] . "' and rule.scenerios='" . $details['scenerios'] . "' 
                            and rule.dnd_scrubbing='" . $details['dnd_scrubbing'] . "'  and rule.added_by='" . $loginid . "' 
                          and action.action_name='" . $action_name . "' and rule.id=action.rule_id and rule.status in (1,5)";
$select_scenerios_qryEx = mysql_query($select_scenerios_qry, $dbConn);
$old_rule_id_deatils = mysql_fetch_array($select_scenerios_qryEx);
$old_rule_id = $old_rule_id_deatils['id'];
if ($old_rule_id) {
    $update_query = "update master_db.tbl_rule_engagement set status=0 where id='" . $old_rule_id . "'";
    mysql_query($update_query, $dbConn);
}

if ($action_name == 'sms') {

    $obd_form_mob_file = $_FILES['upload_file']['name'];

    //$uploadedby = $_SESSION["logedinuser"];
//    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $curdate = date("Y_m_d-H_i_s");
    if (isset($_FILES['upload_file']) && !empty($_FILES['upload_file']['name'])) {
        $lines = file($_FILES['upload_file']['tmp_name']);
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
            if (copy($_FILES['upload_file']['tmp_name'], $pathtofile)) {
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                        $insertDump = "insert into master_db.tbl_new_sms_engagement(rule_id,Message,status) 
     values('$rule_id[0]', '$escape_msg',1)";
                        if (mysql_query($insertDump, $dbConn)) {
                            $isupload = true;
                        } else {
                            $isupload = false;
                        }
                    }
                }
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                $lines = file($pathtofile);
//                $i = 0;
//                foreach ($lines as $line_num => $mobno) {
//                    $mno = trim($mobno);
//                    if (!empty($mno)) {
//                        $i++;
//                    }
//                }
//                $totalcount = $i;
//
//                $insertDump = 'LOAD DATA LOCAL INFILE "' . $pathtofile . '" 
//						INTO TABLE master_db.tbl_new_sms_engagement
//						LINES TERMINATED BY "\n" 
//						(Message) SET rule_id="' . $rule_id[0] . '" , status=1';
//
//                if (mysql_query($insertDump, $dbConn)) {
//                    $isupload = true;
//                } else {
//                    $isupload = false;
//                }
            }
        }

        $insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,sms_sequence,sms_cli,time_slot,upload_file,status,added_on,added_by,cc_user) 
     values('$rule_id[0]', '$action_name','$sms_sequence', '$sms_cli', '$time_slot', '$createfilename',1,now(),'$loginid','$add_cc')";

//$insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,sms_sequence,sms_cli,time_slot,upload_file,status,added_on,added_by) 
//     values('$rule_id[0]', '$action_name','$sms_sequence', '$sms_cli', '$time_slot', '$upload_file',1,now(),'')";
    }
} else {
    $insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,time_slot,email_user,cc_user,status,added_on,added_by) 
     values('$rule_id[0]', '$action_name','$time_slot', '$email_user', '$add_cc',1,now(),'$loginid')";
}
$result = mysql_query($insertquery, $dbConn);
$updateQry = "update master_db.tbl_rule_engagement set status=1 where id='" . $rule_id[0] . "'";
$ExeupdateQry = mysql_query($updateQry, $dbConn);
//if (mysql_query($insertquery, $dbConn)) {
//    $msg = "Message has been saved successfully";
//    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
//<div class=\"alert alert-success\">$msg</div></div>";
//} else {
//    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
//<div class=\"alert alert-danger\">There seem to be error in saving message.Please try again.</div></div>";
//}
mysql_close($dbConn);
exit;
?>
