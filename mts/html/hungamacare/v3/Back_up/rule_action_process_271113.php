<?php
session_start();
require_once("incs/db.php");

$action_name = $_REQUEST['action_name'];
$sms_sequence = $_REQUEST['sms_sequence'];
$sms_cli = $_REQUEST['sms_cli'];
$time_slot = $_REQUEST['time_slot'];
$upload_file = $_REQUEST['upload_file'];
$email_user = $_REQUEST['email_user'];
$add_cc = $_REQUEST['add_cc'];
$loginid=$_SESSION['loginId'];
$selQry = "select max(id) from master_db.tbl_rule_engagement";
$selQryEx = mysql_query($selQry, $dbConn);
$rule_id = mysql_fetch_row($selQryEx);

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
                $lines = file($pathtofile);
                $i = 0;
                foreach ($lines as $line_num => $mobno) {
                    $mno = trim($mobno);
                    if (!empty($mno)) {
                        $i++;
                    }
                }
                $totalcount = $i;

                $insertDump = 'LOAD DATA LOCAL INFILE "' . $pathtofile . '" 
						INTO TABLE master_db.tbl_new_sms_engagement
						LINES TERMINATED BY "\n" 
						(Message) SET rule_id="' . $rule_id[0] . '"';

                if (mysql_query($insertDump, $dbConn)) {
                    $isupload = true;
                } else {
                    $isupload = false;
                }
            }
        }

        $insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,sms_sequence,sms_cli,time_slot,upload_file,status,added_on,added_by) 
     values('$rule_id[0]', '$action_name','$sms_sequence', '$sms_cli', '$time_slot', '$createfilename',1,now(),'$loginid')";

//$insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,sms_sequence,sms_cli,time_slot,upload_file,status,added_on,added_by) 
//     values('$rule_id[0]', '$action_name','$sms_sequence', '$sms_cli', '$time_slot', '$upload_file',1,now(),'')";
    }
} else {
    $insertquery = "insert into master_db.tbl_rule_engagement_action(rule_id,action_name,time_slot,email_user,cc_user,status,added_on,added_by) 
     values('$rule_id[0]', '$action_name','$time_slot', '$email_user', '$add_cc',1,now(),'$loginid')";
}
$result = mysql_query($insertquery, $dbConn);
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
