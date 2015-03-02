<?php
session_start();
error_reporting(1);
require_once("incs/db.php");
require_once("language.php");
//check for existing session
if(empty($_SESSION['loginId_voda']))
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
		<div class=\"alert alert-danger\">Your session has timed out. Please login again.</div></div>";
exit;
}
else
{
$uploadeby_voda=$_SESSION['loginId_voda'];
}
$remoteAdd = trim($_SERVER['REMOTE_ADDR']);
$cat_info=$_POST['cat_info'];
$circle_info=$_POST['circle_info'];
 $scheduleDateArray = $_REQUEST['dpd1'];
$sd_date = explode(",", $scheduleDateArray);
foreach($sd_date as $sdate)
{
$shDate = strtotime($sdate);
$scheduleDate = date('Y-m-d', $shDate);
$chekforExist=mysql_query("select Category from vodafone_hungama.tbl_cat_menu nolock where PlayDate='".$scheduleDate."'",$dbConn);
$isData=mysql_num_rows($chekforExist);
$insertQuery="insert into vodafone_hungama.tbl_cat_menu(Category,PlayDate,Circle,added_by,added_on,ipAddress) values('".$cat_info."', '".$scheduleDate."', '".$circle_info."', '".$uploadeby_voda."', now(),'".$remoteAdd."')";
if($isData<=0)
{
mysql_query($insertQuery,$dbConn);
}
}
		
$msg = "Configuration has been saved successfully";
echo "<div width=\"85%\" align=\"left\" class=\"txt\"><div class=\"alert alert-success\">$msg</div></div>";
mysql_close($dbConn);
?>