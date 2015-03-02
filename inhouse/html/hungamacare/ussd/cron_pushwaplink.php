<?php
//include database connection file
error_reporting(0);
include("db.php");
//servicetype -- DIGI | HUL
$logPath = "logs/cron/ringtone_file_processed_".date("Y-m-d").".txt";
//check for status ready to upload  
$checkfiletoprocess=mysql_query("select batchid,file_name, added_by, added_on, total_file_count,content_type, contentId,ip,service_id,mode from master_db.bulk_rbtsendsms_history where status IN ( 1, 0) and prcocess_status='free' and total_file_count<=10000 order by batchid ASC limit 1");
$notorestore=mysql_num_rows($checkfiletoprocess);
if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
//close database connection
mysql_close($con);
exit;
}

else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{	
$obd_form_batchid=$row_file_info['batchid'];
$obd_form_uploadtime=$row_file_info['added_on'];

$update_status_pre = "UPDATE master_db.bulk_rbtsendsms_history set status='1',prcocess_status='block',added_on='".$obd_form_uploadtime."' where batchid='".$obd_form_batchid."'";
 mysql_query($update_status_pre,$con);

$obd_form_mob_file=$row_file_info['file_name'];
$obd_form_content_type=$row_file_info['content_type'];
$obd_form_contentId=$row_file_info['contentId'];
$obd_form_service_id=$row_file_info['service_id'];
$obd_form_mode=$row_file_info['mode'];

$status=0;
$lines = file('RBTBulkUpload/'.$obd_form_mob_file);
$isupload=false;
$allani= array();
$i=0;
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
//echo $line_num.'-'.$mno."<br>";
 $allani[$line_num]=$mno;
//echo  $mno."<br>";      
//$waplink='http://202.87.41.147/CMT/api/Voice/UniDirCharge.php?cid=123456&t=tt';
$waplink='Thanks for downloading from Uninor My Ringtones. Click to download ';
$waplink.='http://202.87.41.147/CMT/api/Voice/UniDirCharge.php?cid='.$obd_form_contentId.'&t='.$obd_form_content_type;
$waplink=urlencode($waplink);
$sndMsgQuery = "CALL master_db.SENDSMS_NEW('".$mno."','".$waplink."','52888','UNIM','TONEBULKSMS',1)";
mysql_query($sndMsgQuery,$con);
}

}//end of while


$logData="#BatchId#".$obd_form_batchid."#filename#".$obd_form_mob_file."#contenttype#".$obd_form_content_type."#contentid#".$obd_form_contentId."#serviceid#".$obd_form_service_id."#mode#".$obd_form_mode."#waplink#".$waplink."\n\r";
error_log($logData,3,$logPath);

//If file successfully read and insert line by line in database we remove that file from here and copy it to lock folder and chage table column status to 1
$isupload=true;
if($isupload)
{
$update_status_post = "UPDATE master_db.bulk_rbtsendsms_history set status='2',prcocess_status='completed',added_on='".$obd_form_uploadtime."' where batchid='".$obd_form_batchid."'";
mysql_query($update_status_post,$con);
mysql_close($con);    
}
echo "File processed successfully.";

//close database connection
exit;
}
?>