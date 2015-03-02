<?php
//include("session.php");
include("db.php");
$logPath = "logs/obdrecording_log_".date("Y-m-d").".txt";
$obd_form_mob_file=$_FILES['obd_form_mob_file']['name'];
$obd_form_prompt_file=$_FILES['obd_form_prompt_file']['name'];
//calculate file size in Kb
//$mob_filesize=($_FILES["obd_form_mob_file"]["size"] / 1024);
//cli 
$obd_form_cli=$_REQUEST['obd_form_cli'];
//circle code
$obd_form_circle=$_REQUEST['obd_form_circle'];

$obdstartdate=$_REQUEST['obd_form_startdate'];
$obdenddate=$_REQUEST['obd_form_enddate'];

$obd_form_startdate = date("Y-m-d H:i:s",strtotime($obdstartdate));
$obd_form_enddate = date("Y-m-d H:i:s",strtotime($obdenddate));


//for start datetime
$currentstartTime = time($obd_form_startdate); //Change date into time
//Add 2 and half hour equavelent seconds 60*60
$sttimeAftertwohalfHour = $currentstartTime+9000;
echo "<br>Current Date and Time: ".date("Y-m-d H:i:s",$currentstartTime);
echo "<br>Date and Time After adding 2 hlf hour: ".date("Y-m-d H:i:s",$sttimeAftertwohalfHour);
echo "*******************************";
echo "<br>";
//for end datetime
$currentendTime = time($obd_form_enddate); //Change date into time
//Add 2 and half hour equavelent seconds 60*60
$edtimeAftertwohalfHour = $currentendTime+9000;
echo "<br>Current Date and Time: ".date("Y-m-d H:i:s",$currentendTime);
echo "<br>Date and Time After adding 2 hlf hour: ".date("Y-m-d H:i:s",$edtimeAftertwohalfHour);


//$obd_form_startdate_2hr=
//$obd_form_enddate_2hr
exit;

$curdate = date("Y_m_d-H_i_s");
$uploadedby=$a;
$uploadedby="admin";
$ipaddress=$_SERVER['REMOTE_ADDR'];


if(!empty($obd_form_mob_file)){
$i = strrpos($obd_form_mob_file,".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file,$i+1,$l);
//$createobdfilename= $obd_form_mob_file."_obdrecording_".$curdate.'.'.$ext;
$createobdfilename= "_obdrecording_".$curdate.'.'.$ext;
$pathtoobdfile= "obdrecording/".$createobdfilename;
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
/*
Uploaded Wav file should be save on below path:
*/
if(!empty($obd_form_prompt_file)){
$j = strrpos($obd_form_prompt_file,".");
$k = strlen($obd_form_prompt_file) - $j;
$ext = substr($obd_form_prompt_file,$j+1,$k);
$createobdprompt= $obd_form_prompt_file;
$pathtoobdpromptfile= "obdrecording/prompt/".$createobdprompt;
copy($_FILES['obd_form_prompt_file']['tmp_name'], $pathtoobdpromptfile);
}

//save data in our log table 'tbl_obdrecording_log'

$sql_obdinfo="INSERT INTO tbl_obdrecording_log (uploadedby,ipaddress,odb_filename,circle,cli,startdate,enddate,filesize)
VALUES ('".$uploadedby."','".$ipaddress."','".$createobdfilename."','".$obd_form_circle."','".$obd_form_cli."','".$obd_form_startdate."','".$obd_form_enddate."','".$totalcount."')";

	$logData="uploadedby#".$uploadedby."#ipaddress#".$ipaddress."#filename#".$createobdfilename."#circle#".$obd_form_circle."#cli#".$obd_form_cli."#startdate#".$obd_form_startdate."#enddate#".$obd_form_enddate."#".date("Y-m-d H:i:s")."\n";;
	error_log($logData,3,$logPath);

if (mysql_query($sql_obdinfo,$con))
  {
  $msg='Data saved successfully.';
  echo "<script>alert('data saved successfully')</script>";
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
  }
  else 
  {
  $msg='Server error.Please try again.';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=home.php">';
  }
?>