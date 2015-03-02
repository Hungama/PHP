<?php
include("session.php");
include("db.php");
$logPath = "logs/obdrecording_log_".date("Y-m-d").".txt";
$obd_form_mob_file=$_FILES['obd_form_mob_file']['name'];
$obd_form_prompt_file=$_FILES['obd_form_prompt_file']['name'];
//circle code
$capsule=$_REQUEST['obd_form_capsule'];
$service=$_REQUEST['obd_form_option'];
$promo=$_REQUEST['promo'];

//$service='HUL';
//$service='HUL_PROMOTION';
if($promo=='promo')
{
$capsule=6;
}
if($capsule==1)
{
//$obd_form_capsule=0;
$obd_form_capsule=1;
}
else if($capsule==2)
{
	//$obd_form_capsule=29;
	$obd_form_capsule=2;
}
else if($capsule==3)
{
//$obd_form_capsule=63;
$obd_form_capsule=3;
}
else if($capsule==4)
{
	//$obd_form_capsule=96;
	$obd_form_capsule=4;
}
else if($capsule==5)
{
	//$obd_form_capsule=129;
	$obd_form_capsule=5;
}
else if($capsule==6)
{
	//$obd_form_capsule=129;
	$obd_form_capsule=6;
}
else if($capsule==7)
{
	//$obd_form_capsule=196;
	$obd_form_capsule=7;
}
else if($capsule==8)
{
	//$obd_form_capsule=196;
	$obd_form_capsule=8;
}
else if($capsule==9)
{
	$obd_form_capsule=9;
	//echo "<script>alert('Currently disabled.Please try later')</script>";
	//echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
}
else
{
echo "<script>alert('Currently disabled.Please try later')</script>";
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
	exit;
//$obd_form_capsule=162;
}
$obd_form_capsule;
//calculate file size in Kb

$curdate = date("Y_m_d-H_i_s");
$uploadedby=$a;
//$uploadedby="admin";
$ipaddress=$_SERVER['REMOTE_ADDR'];


if(!empty($obd_form_mob_file)){
$i = strrpos($obd_form_mob_file,".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file,$i+1,$l);
//$createobdfilename= $obd_form_mob_file."_obdrecording_".$curdate.'.'.$ext;
$ext='txt';
$createobdfilename= "_obdrecording_".$curdate.'.'.$ext;
$pathtoobdfile= "obdrecording/hul/".$createobdfilename;
if(copy($_FILES['obd_form_mob_file']['tmp_name'], $pathtoobdfile))
{
$lines = file($pathtoobdfile);
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
//Uploaded Wav file should be save on below path:
//save data in our log table 'tbl_obdrecording_log'
//capsuleid
$sql_obdinfo="INSERT INTO master_db.tbl_obdrecording_log (uploadedby,ipaddress,odb_filename,filesize,servicetype,capsuleid)
VALUES ('".$uploadedby."','".$ipaddress."','".$createobdfilename."','".$totalcount."','".$service."','".$obd_form_capsule."')";

	$logData="uploadedby#".$uploadedby."#ipaddress#".$ipaddress."#filename#".$createobdfilename."#".date("Y-m-d H:i:s")."\r\n";;
	error_log($logData,3,$logPath);

if (mysql_query($sql_obdinfo,$con))
  {
//mysql_close($con);
//start rewrite file here for data inload process
$status=0;
$lines = file('obdrecording/hul/'.$createobdfilename);

$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
 $allani[$line_num]=$mno;
	          
 }//end of foreach
//open file to rewrite

$newfile='/var/www/html/digi/digiobd/obdrecording/hul/tbl_hul_pushobb/'.$createobdfilename;

$file=fopen('obdrecording/hul/'.$createobdfilename,"w");
foreach ($allani as $allani_no => $msisdn)
 {
//check to see if msisdn is empty..if empty then do not write in file
 if(!empty($msisdn))
{
$logData_obd=$msisdn."#".$service. "#".$status."\r\n";;
	error_log($logData_obd,3,$newfile);

	$get_ani_ope ="select  circle,operator  from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";

	$circle_operator= mysql_query($get_ani_ope,$con);
	 $get_cir_operator = mysql_fetch_array($circle_operator);
if(!empty($get_cir_operator['circle']))
{
$cir=$get_cir_operator['circle'];
}
else
{
	$cir='UND';
}
if(!empty($get_cir_operator['operator']))
{
$op=$get_cir_operator['operator'];
}
else
{
	$op='UND';
}
//ANI,STATUS,DNIS,message,retry,circle,operator
$dnis='66291352';
$messge='test';
$retry='0';
//fwrite($file,$msisdn . "#" .$status. "#" .$service. "#" .$dnis. "#" .$messge. "#" .$retry. "#" .$cir."#".$op . "\r\n" );
fwrite($file,$msisdn . "#" .$status. "#" .$dnis. "#" .$messge. "#" .$retry. "#" .$cir."#".$op . "\r\n" );

}
 }
fclose($file);
// file rewriting end here
mysql_close($con);
  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
  if($promo=='promo')
{
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd_promotion.php">';
}
else
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
} 
 }
  else 
  {
  $msg='Server error.Please try again.';
 // echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
   if($promo=='promo')
{
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd_promotion.php">';
}
else
{
echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
}
  }

?>