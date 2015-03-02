<?php

session_start();
$user_id = $_SESSION['loginId'];
require_once("incs/db.php");
$id = $_REQUEST['id'];
$tnb_days = $_REQUEST['tnb_days'];
$tnb_mins = $_REQUEST['tnb_mins'];
$pre_sms = $_REQUEST['pre_sms'];
$bulktype = $_REQUEST['bulktype'];
$currentdate = date("Y-m-d");
$remoteAdd = $_SERVER['REMOTE_ADDR'];
$baseurl = "logs/bulkfilestop/";
$logPath = $baseurl . "bulkfilestop_" . $currentdate . ".txt";


if ($bulktype == 'tryandbuy') {
    $sql = "update MTS_IVR.tbl_new_tnb_whitelisted_config set tnb_days='" . $tnb_days . "',tnb_mins='" . $tnb_mins . "',pre_sms='" . $pre_sms . "'
    WHERE id='" . $id . "'";
}

if (isset($sql)) {
    if (mysql_query($sql, $dbConn)) {
        $res = "File has been edited.";
    } else {
        $res = mysql_error();
    }
    echo $res;
    $logData = $batch_id . "#" . $bulktype . "#" . $remoteAdd . "#" . $res . "#" . $user_id . "#edi#" . date("Y-m-d H:i:s") . "\n";
    mysql_close($dbConn);
} else {
    $res = "Invalid Request";
    echo $res;
    $logData = $batch_id . "#" . $bulktype . "#" . $remoteAdd . "#" . $res . "#" . $user_id . "#edi#" . date("Y-m-d H:i:s") . "\n";
}

error_log($logData, 3, $logPath);
?>