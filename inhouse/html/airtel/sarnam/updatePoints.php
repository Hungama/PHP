<?php 
include("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$headers=getallheaders(); 
$mMsisdn=$headers['Msisdn'];
$relName=$_REQUEST['relName'];
$deityName=$_REQUEST['deityName'];
$type=$_REQUEST['type'];

if(!$mMsisdn)
	$mMsisdn=$_REQUEST['Msisdn'];

$points=$_REQUEST['points'];
if(!$points)
	$points=1;

$insertQuery="insert airtel_devo.tbl_wap_point(id,msisdn,circle,points,religion,deity,contenttype,added_on) values('',$mMsisdn,'',$points,'".$relName."','".$deityName."','".$type."',now())";
$mysqlReqult=mysql_query($insertQuery,$dbConnAirtel);

?>