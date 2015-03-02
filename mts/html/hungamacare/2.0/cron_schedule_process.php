<?php

session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
//check for existing session
if (empty($_SESSION['loginId'])) {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
    exit;
} else {
    $uploadeby = $_SESSION['loginId'];
}
if (1) {  
    $serviceId = $_POST['service_info'];
    $hour = $_POST['hour'];
    $mins = $_REQUEST['mins'];
    $currTime = date("Y-m-d H:i:s");
    $scheduleTime = $hour . ':' . $mins . ':' . '00';
    $dnd_status = $_POST['dnd_status'];
    $message = $_POST['message'];
    
    $updateQuery = "UPDATE master_db.tbl_cron_schedule_contest SET status=0 ,lastmodify=now() WHERE service_id='" . $serviceId . "'";
    $queryIns = mysql_query($updateQuery, $dbConn);

    $InsertQuery = "insert into master_db.tbl_cron_schedule_contest(schedule_time,added_on,service_id,added_by,dnd_scrubing,lastmodify)
		values('" . $scheduleTime . "', '" . $currTime . "', '" . $serviceId . "','" . $_SESSION['loginId'] . "', " . $dnd_status . ",now())";
    $msgQueryIns = mysql_query($InsertQuery, $dbConn);
    $SelQuery = "select service_id,message from master_db.tbl_cron_schedule_footer_msg where service_id="."'" . $serviceId . "'";
    $SelQry = mysql_query($SelQuery, $dbConn);
    $details = mysql_fetch_array($SelQry);
    $sel_service_id=$details['service_id'];
    $sel_message=$details['message'];
    if($sel_service_id == $serviceId && $sel_message == '' && $message == ''){ 
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Please enter footer message.</div></div>";
    exit;
    } elseif($sel_service_id == $serviceId && $message != ''){ 
    $MsgUpdateQuery = "UPDATE master_db.tbl_cron_schedule_footer_msg SET message ='".$message."' where service_id='".$serviceId."'";		
    $MsgQueryUpdate = mysql_query($MsgUpdateQuery, $dbConn);
    }else{ 
        $MsgInsertQuery = "insert into master_db.tbl_cron_schedule_footer_msg(service_id,message)
		values('" . $serviceId . "', '" . $message . "')";
        $MsgQueryIns = mysql_query($MsgInsertQuery, $dbConn);
    }
    $msg = " Cron has been successfully scheduled";
    echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
} else {
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
				<div class=\"alert alert-danger\">There seem to be error.</div></div>";
}
exit;
?>