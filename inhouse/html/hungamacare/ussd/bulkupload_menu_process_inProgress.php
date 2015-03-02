<?php
session_start();
require_once("db.php");

$post_for=$_REQUEST['post_for'];

if($post_for=='BASE')
{
$obd_form_mob_file=$_FILES['upfile']['name'];


$obd_ussdstr=explode("-",$_REQUEST['ussd_str']);
$obd_form_ussdstr=$obd_ussdstr[0];
$obd_form_menuid=$obd_ussdstr[1];

$obd_form_service=$_REQUEST['obd_form_service'];

$settime=$_REQUEST['settime'];
if($settime=='yes')
{
$schedule_start_time=$_REQUEST['schedule_start_time'];
$schedule_end_time=$_REQUEST['schedule_end_time'];
}
else
{
$schedule_start_time='08:00:00';
$schedule_end_time='20:00:00';
}
$data_schedule=explode('-',trim($_REQUEST['schedule_date']));

$satartdate=explode('/',$data_schedule[0]);
$enddate=explode('/',$data_schedule[1]);

$obd_form_schedule_date=trim($satartdate[2]).'-'.trim($satartdate[0]).'-'.trim($satartdate[1]).' '.$schedule_start_time;


$obd_form_schedule_start_date=trim($satartdate[2]).'-'.trim($satartdate[0]).'-'.trim($satartdate[1]).' '.$schedule_start_time;
$obd_form_schedule_end_date=trim($enddate[2]).'-'.trim($enddate[0]).'-'.trim($enddate[1]).' '.$schedule_end_time;


$mode=$_REQUEST['mode'];
//$mode='live';
if($mode=='test')
{
$testingno=$_REQUEST['testingno'];
$allani=explode(',',$testingno);
$totaltestno=count($allani);
for($i=0;$i<$totaltestno;$i++)
{
if(is_numeric($allani[$i]) && strlen($allani[$i])==10) {
$isok=1;
  } else {
$isok=0;
break;
  }
}

if($isok)
{
if($totaltestno>10)
{
 echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please enter less than or 10 mobile numbers for testing.</div></div>";
exit;
}
}
else
{
 echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please enter valid mobile number.</div></div>";
exit;
}


}
else
{
$testingno='NA';
}
$uploadedby=$_SESSION["logedinuser"];
$ipaddress=$_SERVER['REMOTE_ADDR'];
$curdate = date("Y_m_d-H_i_s");
if($mode=='test')
{

$logPath = "logs/fileupload/ussd_file_uplaod".$curdate.".txt";
$logData="#UploadBy#".$uploadedby."#filename#".$createfilename."#serviceid#".$obd_form_service."#menuid#".$obd_form_menuid."#ussd_str#".$obd_form_ussdstr."#ipaddess#".$ipaddress."#Upload For#".$mode."#schedulefor#".$obd_form_schedule_date."#start_date#".$obd_form_schedule_start_date."#end_date#".$obd_form_schedule_end_date."\n\r";
error_log($logData,3,$logPath);
	
		$selMaxId="select max(batch_id)+1 from master_db.bulk_ussd_history";
			$qryBatch = mysql_query($selMaxId,$con);
			list($batchId) = mysql_fetch_array($qryBatch);
			
$sql="INSERT INTO master_db.bulk_ussd_history (file_name,added_by,added_on,upload_for,status,operator,total_file_count,service_id,ip,menuid,ussd_string,flag,menuserialid,schedule_for,start_date,end_date)
VALUES ('".$createfilename."','".$uploadedby."',now(),'".$mode."','2','','".$totalcount."','".$obd_form_service."','".$ipaddress."','".$obd_form_menuid."','".$obd_form_ussdstr."','".$testingno."','".$menu_serialid."',now(),'".$obd_form_schedule_start_date."','".$obd_form_schedule_end_date."')";
if (mysql_query($sql,$con))
  {
  $msg='Data Uploaded Successfully.';
  
  //direct insertion for testing
$form_test_ani=$testingno;
$menuid=$obd_form_menuid;
$ussd_string=$obd_form_ussdstr;
$status=5;
$ANI=$form_test_ani;
$allani=explode(',',$ANI);
$totaltestno=count($allani);
for($i=0;$i<$totaltestno;$i++)
{
$push_ani=$allani[$i];
$db_tbl='USSD.REDFM_USSD_BULK_WL_NEW';
$Query="call ".$db_tbl." ('$push_ani','$ussd_string','$menuid','$obd_form_service_id','$batchId',now(),'$status','$obd_form_schedule_start_date','$obd_form_schedule_end_date')";
$subsQuery1=mysql_query($Query);
}
//end here
  
  
  
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
  }
  else
  {
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Error while uplaoding data.</div></div>";
  }

}
else
{
if(isset($_FILES['upfile']) && !empty($_FILES['upfile']['name'])) {
 $lines = file($_FILES['upfile']['tmp_name']);
$isok;
$count=0;
foreach ($lines as $line_num => $mobno) 
{
$mno=trim($mobno);
if(!empty($mno))
{
if(is_numeric($mno) && strlen($mno)==10) {
$isok=1;
$count++;
    } else {
$isok=2;
break;
  }
}
  }
if($isok==2)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">File can not be uploaded. There are some errors in file.Please check and upload again.</div></div>";
exit;
}
else if($count>25000)
{
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">Please upload file of less than 25,000 numbers otherwise it will not process.</div></div>";
exit;
}

 
if(!empty($obd_form_mob_file)){
$i = strrpos($obd_form_mob_file,".");
$l = strlen($obd_form_mob_file) - $i;
$ext = substr($obd_form_mob_file,$i+1,$l);
$ext='txt';

$createfilename= "ussdbulkfile_".$curdate.'.'.$ext;
$pathtofile= "ussdbulkfile/".$createfilename;
if(copy($_FILES['upfile']['tmp_name'], $pathtofile))
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
$logPath = "logs/fileupload/ussd_file_uplaod".$curdate.".txt";
$logData="#UploadBy#".$uploadedby."#filename#".$createfilename."#serviceid#".$obd_form_service."#menuid#".$obd_form_menuid."#ussd_str#".$obd_form_ussdstr."#ipaddess#".$ipaddress."#Upload For#".$mode."#"."#schedulefor#".$obd_form_schedule_date.$curdate."#start_date#".$obd_form_schedule_start_date."#end_date#".$obd_form_schedule_end_date."\n\r";
error_log($logData,3,$logPath);
	
	
$sql="INSERT INTO master_db.bulk_ussd_history (file_name,added_by,added_on,upload_for,status,operator,total_file_count,service_id,ip,menuid,ussd_string,flag,menuserialid,schedule_for,start_date,end_date)
VALUES ('".$createfilename."','".$uploadedby."',now(),'".$mode."','0','','".$totalcount."','".$obd_form_service."','".$ipaddress."','".$obd_form_menuid."','".$obd_form_ussdstr."','".$testingno."','".$menu_serialid."',now(),'".$obd_form_schedule_start_date."','".$obd_form_schedule_end_date."')";
if (mysql_query($sql,$con))
  {
  $msg='File Uploaded Successfully.';
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
  }
  else 
  {
 echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">File can not be uploaded. There are some errors in file.Please check and upload again.</div></div>";
  }
  }
  else
  {
  echo 'No File';
  }
  }
  }
  else if($post_for=='OBD')
  {
$obd_form_prompt_file=$_FILES['upfile']['name'];
$obd_name=$_REQUEST['obd_name'];
$obd_description=$_REQUEST['obd_description'];
$selMaxId="select max(id)+1 from master_db.obd_upload_history";
			$qryBatch = mysql_query($selMaxId,$con);
			list($id) = mysql_fetch_array($qryBatch);

if(!empty($obd_form_prompt_file)){
$i = strrpos($obd_form_prompt_file,".");
$l = strlen($obd_form_prompt_file) - $i;
$ext = substr($obd_form_prompt_file,$i+1,$l);
$obd_name= $id.'.'.$ext;
$pathtofile= "prompt/".$obd_name;
$filepath='/sendobd';
if(copy($_FILES['upfile']['tmp_name'], $pathtofile))
{
$sql="INSERT INTO master_db.obd_upload_history (id,obd_name,description,filepath,added_on,status)
VALUES ('".$id."','".$obd_name."','".$obd_description."','".$filepath."',now(),'0')";
if (mysql_query($sql,$con))
  {
  $msg='File Uploaded Successfully.Reference ID: '.$id;
  echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
  }
  else 
  {
 echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">File can not be uploaded. There are some errors in file.Please check and upload again.</div></div>";
  }
  
}
}


  }
  else if($post_for=='MENU')
  {
//  echo 'Menu';
$cat_name=$_REQUEST['form_song_categoryname'];
$ussd_str=$_REQUEST['ussd_str'];
$menu_id=$_REQUEST['menu_id'];
$obd_form_circle=$_REQUEST['obd_form_circle'];

$song1_id=$_REQUEST['form_songname_1_id'];
$song2_id=$_REQUEST['form_songname_2_id'];
$song3_id=$_REQUEST['form_songname_3_id'];

$song1=$_REQUEST['form_songname_1'];
$song2=$_REQUEST['form_songname_2'];
$song3=$_REQUEST['form_songname_3'];

$song_ttid1=$_REQUEST['form_truetoneid_1'];
$song_ttid2=$_REQUEST['form_truetoneid_2'];
$song_ttid3=$_REQUEST['form_truetoneid_3'];
  //first update all record to status 0
$update_song_status = "update USSD.tbl_songname set status=0 where ussd_string='".$ussd_str."'";
mysql_query($update_song_status,$con);
//insert all three 3 new song
$sql_song1="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$menu_id."','".$cat_name."','".$song1_id."','".$song1."','".$song_ttid1."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song2="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$menu_id."','".$cat_name."','".$song2_id."','".$song2."','".$song_ttid2."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song3="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$menu_id."','".$cat_name."','".$song3_id."','".$song3."','".$song_ttid3."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

if(mysql_query($sql_song1,$con))
{
if(!empty($song2))
{
mysql_query($sql_song2,$con);
}
if(!empty($song3))
{
mysql_query($sql_song3,$con);
}
$msg='Data Saved Successfully.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
}
else
{
$msg='Data Uploaded Error.Please try again.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">$msg</div></div>";
}
  }
  else if($post_for=='DTMF')
  {
//  echo 'Menu';
$cat_name=$_REQUEST['form_song_categoryname'];
$ussd_str=$_REQUEST['ussd_str'];
//$menu_id=$_REQUEST['menu_id'];
$obd_form_circle=$_REQUEST['obd_form_circle'];

$dtmf1_id=$_REQUEST['form_dtmf_1_id'];
$dtmf2_id=$_REQUEST['form_dtmf_2_id'];
$dtmf3_id=$_REQUEST['form_dtmf_3_id'];
$dtmf4_id=$_REQUEST['form_dtmf_4_id'];
$dtmf5_id=$_REQUEST['form_dtmf_5_id'];

$dtmf1=$_REQUEST['form_dtmf_1'];
$dtmf2=$_REQUEST['form_dtmf_2'];
$dtmf3=$_REQUEST['form_dtmf_3'];
$dtmf4=$_REQUEST['form_dtmf_4'];
$dtmf5=$_REQUEST['form_dtmf_5'];

$contentid1=$_REQUEST['form_contentid_1'];
$contentid2=$_REQUEST['form_contentid_2'];
$contentid3=$_REQUEST['form_contentid_3'];
$contentid4=$_REQUEST['form_contentid_4'];
$contentid5=$_REQUEST['form_contentid_5'];
  //first update all record to status 0
$update_song_status = "update USSD.tbl_songname_dtmf set status=0 where ussd_string='".$ussd_str."'";
mysql_query($update_song_status,$con);
//insert all three 3 new song
$sql_song1="INSERT INTO USSD.tbl_songname_dtmf (song_category,song_index,DTMF,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$cat_name."','".$dtmf1_id."','".$dtmf1."','".$contentid1."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song2="INSERT INTO USSD.tbl_songname_dtmf (song_category,song_index,DTMF,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$cat_name."','".$dtmf2_id."','".$dtmf2."','".$contentid2."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song3="INSERT INTO USSD.tbl_songname_dtmf (song_category,song_index,DTMF,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$cat_name."','".$dtmf3_id."','".$dtmf3."','".$contentid3."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song4="INSERT INTO USSD.tbl_songname_dtmf (song_category,song_index,DTMF,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$cat_name."','".$dtmf4_id."','".$dtmf4."','".$contentid4."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

$sql_song5="INSERT INTO USSD.tbl_songname_dtmf (song_category,song_index,DTMF,contentid,contenttype,status,ussd_string,circle)
VALUES ('".$cat_name."','".$dtmf5_id."','".$dtmf5."','".$contentid5."','OBD','1','".$ussd_str."','".$obd_form_circle."')";

if(mysql_query($sql_song1,$con))
{
if(!empty($song2))
{
mysql_query($sql_song2,$con);
}
if(!empty($song3))
{
mysql_query($sql_song3,$con);
}
if(!empty($song4))
{
mysql_query($sql_song4,$con);
}
if(!empty($song5))
{
mysql_query($sql_song5,$con);
}
$msg='Data Saved Successfully.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
}
else
{
$msg='Data Uploaded Error.Please try again.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">$msg</div></div>";
}
  }
  else
  {
  echo 'Invalid';
  }  
exit;
?>