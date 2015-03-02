<?php
error_reporting(1);
include("session.php");
include("db.php");
$logPath = "logs/uninor_ussd_".date("Y-m-d").".txt";
$obd_form_ussd=$_REQUEST['obd_form_ussd'];
$obd_form_circle=$_REQUEST['obd_form_circle'];
$obd_form_ctype=$_REQUEST['obd_form_ctype'];
$curdate = date("Y_m_d-H_i_s");
$uploadedby=$_SESSION["logedinuser"];
$ipaddress=$_SERVER['REMOTE_ADDR'];

$obd_form_ptid=$_REQUEST['obd_form_ptid'];
$isupload=false;
for($i=0;$i<10;$i++)
{
$sql_ussdinfo="INSERT INTO uninor_myringtone.tbl_ussd_mapping (ussd_string,circle,contentid,status,added_on,contenttype)
VALUES ('".$obd_form_ussd."','".$obd_form_circle."','".$obd_form_ptid[$i]."',1,now(),'".$obd_form_ctype."')";
mysql_query($sql_ussdinfo,$con);
$isupload=true;
}

if ($isupload)
  {
mysql_close($con);
  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=showuninor_ussd.php">';
 
 }
  else 
  {
  $msg='Server error.Please try again.';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_ussd.php">';
}
?>