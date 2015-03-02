<?php
include("session.php");
include("db.php");
$obd_form_mob_file=$_FILES['obd_form_mob_file']['name'];
$obd_form_menuid=$_REQUEST['obd_form_menuid'];
$obd_form_ussdstr=$_REQUEST['obd_form_ussdstr'];

$obd_form_service=$_REQUEST['obd_form_service'];

$uploadedby=$_SESSION["logedinuser"];
$ipaddress=$_SERVER['REMOTE_ADDR'];
$curdate = date("Y_m_d-H_i_s");

if(!empty($obd_form_mob_file)){
$i = strrpos($obd_form_mob_file,".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file,$i+1,$l);
$ext='txt';

$createfilename= "ussdbulkfile_".$curdate.'.'.$ext;
$pathtofile= "ussdbulkfile/".$createfilename;
if(copy($_FILES['obd_form_mob_file']['tmp_name'], $pathtofile))
{
$lines = file($pathtofile);
$i=0;
foreach ($lines as $line_num => $mobno) 
{
$mno=trim($mobno);
if(!empty($mno))
{
$i++;
}
}
$totalcount=$i;
}
}

$sql="INSERT INTO master_db.bulk_ussd_history (file_name,added_by,added_on,upload_for,status,operator,total_file_count,service_id,ip,menuid,ussd_string)
VALUES ('".$createfilename."','".$uploadedby."',now(),'','0','','".$totalcount."','".$obd_form_service."','".$ipaddress."','".$obd_form_menuid."','".$obd_form_ussdstr."')";

if (mysql_query($sql,$con))
  {
  $msg='File Uploaded Successfully.';
//  echo "<script>alert('Data saved successfully')</script>";
  echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=upload_ussdbase.php?msg=File Uploades successfully.\">";
  }
  else 
  {
  $msg='Server error.Please try again.';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=upload_ussdbase.php">';
  }
?>