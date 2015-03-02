<?php

session_start();
require_once("../2.0/incs/db.php");
$circle = $_REQUEST['circle'];
$opeartor = $_REQUEST['opeartor'];
$service = $_REQUEST['service'];
$sc = $_REQUEST['sc'];
$timestamp = strtotime($_REQUEST['timestamp']);
$timestamp = date('Y-m-d H:i:s', $timestamp);
$timestamp1 = strtotime($_REQUEST['timestamp1']);
$timestamp1 = date('Y-m-d H:i:s', $timestamp1);
$add_name = $_REQUEST['add_name'];
$is_skip = $_REQUEST['is_skip'];
$loginid = $_SESSION['loginId'];
$remoteAdd = trim($_SERVER['REMOTE_ADDR']); // for getting IP adress
foreach ($circle as $key => $circleValue) {
    $flag = 1;
    $selectQuery = "SELECT starttime,endtime FROM MTS_IVR.tbl_ad_campaign WHERE S_id='" . $service . "' and circle = '" . $circleValue . "' and sc='" . $sc . "'";
    $querySel = mysql_query($selectQuery, $dbConn);
    while ($details = mysql_fetch_array($querySel)) {
        if ((strtotime($timestamp) >= strtotime($details['starttime']) && strtotime($timestamp) <= strtotime($details['endtime'])) || (strtotime($timestamp1) >= strtotime($details['starttime']) && strtotime($timestamp1) <= strtotime($details['endtime']))) {
            $flag = 0;
        }
    }
    if ($flag == 1) {
        $insertquery = "insert into MTS_IVR.tbl_ad_campaign(S_id,ad_name,circle,sc,isSkip,added_on,added_by,status,operator,starttime,endtime,ipaddress) 
     values('$service', '$add_name','$circleValue', '$sc', '$is_skip',now(),'$loginid','1','$opeartor','$timestamp','$timestamp1','$remoteAdd')";
        $result = mysql_query($insertquery, $dbConn);
    }
}
mysql_close($dbConn);
exit;
?>