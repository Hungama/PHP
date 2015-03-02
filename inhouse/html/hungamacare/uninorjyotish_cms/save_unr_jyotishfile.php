<?php
error_reporting(1);
include("session.php");
include("db.php");
$logPath = "logs/uninor_jyotish_".date("Y-m-d").".txt";
$obd_form_mob_file=$_FILES['obd_form_mob_file']['name'];
$curdate = date("Y_m_d-H_i_s");
$uploadedby=$_SESSION["logedinuser"];

if(empty($uploadedby))
{
$uploadedby='uninor_jyotish';
}
$ipaddress=$_SERVER['REMOTE_ADDR'];
$service='uninor_jyotish';

if(!empty($obd_form_mob_file)){
$i = strrpos($obd_form_mob_file,".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file,$i+1,$l);
//$createobdfilename= $obd_form_mob_file."_obdrecording_".$curdate.'.'.$ext;
$ext='txt';
$createobdfilename= "uninor_jyotish_".$curdate.'.'.$ext;
$pathtoobdfile= "bulkuploadfiles/".$createobdfilename;
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
else
{
 echo "<script>alert('Error in file uploading.Please try again.')</script>";
 echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_jyotish_bulk.php">';
}
}
//save data in our log table 'tbl_obdrecording_log'

$sql_obdinfo="INSERT INTO master_db.tbl_obdrecording_log (uploadedby,ipaddress,odb_filename,filesize,servicetype)
VALUES ('".$uploadedby."','".$ipaddress."','".$createobdfilename."','".$totalcount."','".$service."')";

	$logData="uploadedby#".$uploadedby."#ipaddress#".$ipaddress."#filename#".$createobdfilename."#".date("Y-m-d H:i:s")."\r\n";;
	error_log($logData,3,$logPath);

if (mysql_query($sql_obdinfo,$con))
  {
//start rewrite file here for data inload process
$status=0;
$lines = file('bulkuploadfiles/'.$createobdfilename);

$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
 $allani[$line_num]=$mno;
	          
 }//end of foreach
//open file to rewrite

$file=fopen('bulkuploadfiles/'.$createobdfilename,"w");
foreach ($allani as $allani_no => $msisdn)
 {
//check to see if msisdn is empty..if empty then do not write in file
 if(!empty($msisdn))
{
$get_ani_ope ="select circle,operator  from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";

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
//ANI,STATUS,DNIS,message,retry,circle,operator
$DNIS='5464627';
$STATUS='0';
$SUB_TYPE='UI';
$USER_BAL='7';
$MODE_OF_SUB='TIVR';
$plan_id='89';
$chrg_amount='0';
$keypad='0';
//$dt = date("Y-m-d H:i:s",strtotime($data[1]));
$SUB_DATE=date('Y-m-d H:i:s');
$RENEW_DATE=Date('Y-m-d H:i:s', strtotime("+3 days"));

fwrite($file,$msisdn . "#" .$STATUS. "#" .$MODE_OF_SUB. "#" .$DNIS. "#" .$USER_BAL. "#" .$SUB_TYPE. "#".$plan_id."#".$cir."#" .$chrg_amount."#".$keypad ."#".$SUB_DATE."#".$RENEW_DATE."\r\n" );

}
 }
fclose($file);
// file rewriting end here
mysql_close($con);
  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
 echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_jyotish_bulk.php">';
 
 }
  else 
  {
  $msg='Server error.Please try again.';
    echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=uninor_jyotish_bulk.php">';
}
?>