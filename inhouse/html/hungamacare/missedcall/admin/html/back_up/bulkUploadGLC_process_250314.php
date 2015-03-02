<?php

ob_start();
session_start();
require_once("../../../db.php");
$logPath = "logs/uploadfile_" . date("Y-m-d") . ".txt";
$obd_form_mob_file = $_FILES['obd_form_mob_file']['name'];
$service = $_REQUEST['obd_form_option'];
$obd_form_capsule;
$curdate = date("Ymd-His");
$uploadedby = $_SESSION['loginId'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
if (empty($obd_form_mob_file)) {
    $msg = "301";
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=bulkUploadGLC.php?msg=301">';
    exit();
}

if (!empty($obd_form_mob_file)) {
    $i = strrpos($obd_form_mob_file, ".");
    $l = strlen($obd_form_mob_file) - $i;
    $ext = substr($obd_form_mob_file, $i + 1, $l);
    $ext = 'txt';
    $createobdfilename = "GLC_" . $curdate . '.' . $ext;
    $pathtoobdfile = "bulkupload/" . $createobdfilename;
    if (copy($_FILES['obd_form_mob_file']['tmp_name'], $pathtoobdfile)) {
        $lines = file($pathtoobdfile);
        $i = 0;
        foreach ($lines as $line_num => $mobno) {
            $mno = trim($mobno);
            if (!empty($mno)) {
                $i++;
            }
        }
        $totalcount = $i;
    }
}
//save data in our log table 'tbl_GLCBulkobdHistory'
$sql_obdinfo = "INSERT INTO master_db.tbl_GLCBulkobdHistory (uploadedby,ipaddress,odb_filename,filesize,servicetype,capsuleid)
VALUES ('" . $uploadedby . "','" . $ipaddress . "','" . $createobdfilename . "','" . $totalcount . "','" . $service . "','" . $obd_form_capsule . "')";

$logData = "uploadedby#" . $uploadedby . "#ipaddress#" . $ipaddress . "#filename#" . $createobdfilename . "#" . date("Y-m-d H:i:s") . "\r\n";

error_log($logData, 3, $logPath);

if (mysql_query($sql_obdinfo, $con)) {
    $msg = "200";
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=bulkUploadGLC.php?msg=200">';
} else {
    $msg = "201";
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=bulkUploadGLC.php?msg=201">';
}
//echo $msg;

mysql_close($con);
?>