<?php
include("session.php");
include("db.php");
$logPath = "logs/obdrecording_log_".date("Y-m-d").".txt";
$obd_form_mob_file=$_FILES['obd_form_mob_file']['name'];
$obd_form_prompt_file=$_FILES['obd_form_prompt_file']['name'];
//calculate file size in Kb

$obdstartdate=$_REQUEST['obd_form_startdate'];
$obdenddate=$_REQUEST['obd_form_enddate'];

$obd_form_startdate = date("Y-m-d H:i:s",strtotime($obdstartdate));
$obd_form_enddate = date("Y-m-d H:i:s",strtotime($obdenddate));
$curdate = date("Y_m_d-H_i_s");
$uploadedby=$a;
//$uploadedby="admin";
$ipaddress=$_SERVER['REMOTE_ADDR'];
$service='HUL_PROMOTION';


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

if(!empty($obd_form_prompt_file)){
$j = strrpos($obd_form_prompt_file,".");
$k = strlen($obd_form_prompt_file) - $j;
$ext = substr($obd_form_prompt_file,$j+1,$k);
$createobdprompt= $obd_form_prompt_file;
$pathtoobdpromptfile= "obdrecording/hul/prompt/".$createobdprompt;
copy($_FILES['obd_form_prompt_file']['tmp_name'], $pathtoobdpromptfile);
}

//save data in our log table 'tbl_obdrecording_log'

$sql_obdinfo="INSERT INTO master_db.tbl_obdrecording_log (uploadedby,ipaddress,odb_filename,startdate,enddate,filesize,servicetype)
VALUES ('".$uploadedby."','".$ipaddress."','".$createobdfilename."','".$obd_form_startdate."','".$obd_form_enddate."','".$totalcount."','HUL')";

	$logData="uploadedby#".$uploadedby."#ipaddress#".$ipaddress."#filename#".$createobdfilename."#startdate#".$obd_form_startdate."#enddate#".$obd_form_enddate."#".date("Y-m-d H:i:s")."\n";;
	error_log($logData,3,$logPath);

if (mysql_query($sql_obdinfo,$con))
  {
	  $lastinsetreid=mysql_insert_id();
//  $sql_update_time="update tbl_obdrecording_log set enddate= enddate+ INTERVAL 150 MINUTE,startdate= startdate+ INTERVAL 150 MINUTE where batchid=".$lastinsetreid;
//mysql_query($sql_update_time,$con);
//close database connection
mysql_close($con);
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
$file=fopen('obdrecording/hul/'.$createobdfilename,"w");
foreach ($allani as $allani_no => $msisdn)
 {
//fwrite($file,$msisdn . "#" . $obd_form_startdate . "#" . $obd_form_enddate . "#" . $status . "\r\n" );
fwrite($file,$msisdn . "#" . $service . "#" . $status . "#" . $obd_form_startdate . "#" . $obd_form_enddate . "\r\n" );
 }
fclose($file);
// file rewriting end here

  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
  }
  else 
  {
  $msg='Server error.Please try again.';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=hulobd.php">';
  }
?>