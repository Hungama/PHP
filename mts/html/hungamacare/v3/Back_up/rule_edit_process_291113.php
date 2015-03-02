<?php

session_start();
require_once("incs/db.php");

$rule_id = $_REQUEST['rule_id'];
$circle = $_REQUEST['edit_circle'];
$service_base = $_REQUEST['service_edit_base'];
$filter_base = $_REQUEST['filter_edit_base'];
$scenarios = $_REQUEST['edit_scenarios'];
$action_name = $_REQUEST['action_edit_name'];
$sms_sequence = $_REQUEST['sms_edit_sequence'];
$sms_cli = $_REQUEST['sms_edit_cli'];
$email_user = $_REQUEST['email_edit_user'];
$cc_user = $_REQUEST['add_edit_cc'];
//$upload_fil = $_REQUEST['upload_edit_file'];
$upload_file = $_REQUEST['upload_edit_file'];
//$dnd_scrubbing = $_REQUEST['dnd_scrubbing'];
$loginid = $_SESSION['loginId'];
echo $update_query = "update master_db.tbl_rule_engagement set  circle='" . $circle . "', service_base='" . $service_base . "', filter_base='" . $filter_base . "' , scenerios='" . $scenarios . "' where id='" . $rule_id . "'";
mysql_query($update_query, $dbConn);

if ($action_name == 'sms') {
    echo 'file name=' . $_FILES['upload_edit_file']['name'] . "<br/>";
    if ($_FILES['upload_edit_file']['name'] != '') {
        $obd_form_mob_file = $_FILES['upload_edit_file']['name'];

        //$uploadedby = $_SESSION["logedinuser"];
//    $ipaddress = $_SERVER['REMOTE_ADDR'];
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
                    $lines = file($pathtofile);
                    $i = 0;
                    foreach ($lines as $line_num => $mobno) {
                        $mno = trim($mobno);
                        if (!empty($mno)) {
                            $i++;
                        }
                    }
                    $totalcount = $i;
                    $updateMsh = "update master_db.tbl_new_sms_engagement set status = 0 where rule_id='".$rule_id."'";
                    $exeQry = mysql_query($updateMsh, $dbConn);
                    
                    $insertDump = 'LOAD DATA LOCAL INFILE "' . $pathtofile . '" 
						INTO TABLE master_db.tbl_new_sms_engagement
						LINES TERMINATED BY "\n" 
						(Message) SET rule_id="' . $rule_id . '" , status=1';

                    if (mysql_query($insertDump, $dbConn)) {
                        $isupload = true;
                    } else {
                        $isupload = false;
                    }
                }
            }
        }
        echo $insertquery = "update master_db.tbl_rule_engagement_action set action_name='" . $action_name . "' , sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "' , upload_file='" . $createfilename . "'  where rule_id=" . $rule_id . "";
    } else {
        echo $insertquery = "update master_db.tbl_rule_engagement_action set action_name='" . $action_name . "' , sms_sequence='" . $sms_sequence . "' ,
            sms_cli='" . $sms_cli . "'  where rule_id=" . $rule_id . "";
    }
} else {
    echo $insertquery = "update master_db.tbl_rule_engagement_action set action_name='" . $action_name . "' , email_user='" . $email_user . "' ,
            cc_user='" . $cc_user . "'  where rule_id=" . $rule_id . "";
}
$result = mysql_query($insertquery, $dbConn);

mysql_close($dbConn);
exit;
?>