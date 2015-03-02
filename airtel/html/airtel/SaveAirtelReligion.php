<?php
error_reporting(0);
$langid=$_REQUEST['langId'];
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
if(!$dbConn)
	die('could not connect: ' . mysql_error());

$updateReligion="update airtel_devo.tbl_religion_profile set lang=".$langid." where msisdn=".$msisdn;
$QueryMNDWhl = mysql_query($updateReligion);

$getReligionQuery="select lang from airtel_devo.tbl_religion_profile where msisdn=".$msisdn;
$getResult = mysql_query($getReligionQuery);
$getRecord=mysql_fetch_array($getResult);
if($getRecord[0]==$langid)
	echo "Success";
else
	echo "Failed";
//close database connection
mysql_close($dbConn);



?>   