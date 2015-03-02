<?php
error_reporting(1);
include("session.php");
include("db.php");
$logPath = "logs/uninor_ussd_".date("Y-m-d").".txt";

$obd_form_ussd=$_REQUEST['obd_form_ussd'];
$obd_form_circle=$_REQUEST['obd_form_circle'];
$obd_form_ptid=$_REQUEST['obd_form_ptid'];
$obd_form_ctype=$_REQUEST['obd_form_ctype'];
$curdate = date("Y_m_d-H_i_s");
$uploadedby=$_SESSION["logedinuser"];
$ipaddress=$_SERVER['REMOTE_ADDR'];

//check for exsting data
$check="select id from uninor_myringtone.tbl_ussd_mapping where ussd_string='".$obd_form_ussd."' and circle='".$obd_form_circle."' and status=1";
$ch_sql=mysql_query($check,$con);
$noofrecord=mysql_num_rows($ch_sql);
if($noofrecord>=1)
{
$update_status_pre = "UPDATE uninor_myringtone.tbl_ussd_mapping set status='2' where ussd_string='".$obd_form_ussd."' and circle='".$obd_form_circle."' and status=1";
   mysql_query($update_status_pre,$con);
}

$sql_ussdinfo="INSERT INTO uninor_myringtone.tbl_ussd_mapping (ussd_string,circle,contentid,status,added_on,contenttype)
VALUES ('".$obd_form_ussd."','".$obd_form_circle."','".$obd_form_ptid."',1,now(),'".$obd_form_ctype."')";
$logData="ipaddress#".$ipaddress."#".$obd_form_ussd."#".$obd_form_circle."$".$obd_form_ptid."#".date("Y-m-d H:i:s")."\r\n";;
error_log($logData,3,$logPath);


if (mysql_query($sql_ussdinfo,$con))
  {
mysql_close($con);
  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=listmappingdata.php">';
 
 }
  else 
  {
  $msg='Server error.Please try again.';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_ussd_myringtone.php">';
}
?>