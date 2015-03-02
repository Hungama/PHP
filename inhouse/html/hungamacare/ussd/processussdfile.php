<?php
include("db.php");
$getstatus="http://192.168.100.212/hungamacare/ussd/processussdfile-bulk.php";
	echo $status = file_get_contents($getstatus);
	$curdate = date("Y-m-d");
		
$logPath_211 = "logs/211/etisalat_message_".$curdate.".txt";
$logData="#url#".$getstatus."#response#".$status."#".date("Y-m-d H:i:s")."\r\n";
//	error_log($logData,3,$logPath_211);
$checkfiletoprocess=mysql_query("select batch_id,file_name,service_id,added_on,menuid,ussd_string from master_db.bulk_ussd_history where status =0 and total_file_count<=25000 and upload_for NOT IN('live','test') order by batch_id ASC limit 4");
$notorestore=mysql_num_rows($checkfiletoprocess);
if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
mysql_close($con);
exit;
}
else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{	
$obd_form_batchid=$row_file_info['batch_id'];
$obd_form_uploadtime=$row_file_info['added_on'];
$obd_form_menuid=$row_file_info['menuid'];
$obd_form_ussd_string=$row_file_info['ussd_string'];

$update_status_pre = "UPDATE master_db.bulk_ussd_history set status='1',added_on='".$obd_form_uploadtime."' where batch_id='".$obd_form_batchid."'";
  mysql_query($update_status_pre,$con);
$obd_form_mob_file=$row_file_info['file_name'];
$obd_form_service_id=$row_file_info['service_id'];

$lines = file('ussdbulkfile/'.$obd_form_mob_file);
foreach ($lines as $line_num => $mobno)
 {
//read line of file
$mno=trim($mobno);
$ANI=$mno;
$menuid=$obd_form_menuid;
$ussd_string=$obd_form_ussd_string;
$db_tbl='USSD.REDFM_USSD_BULK_WL';
$Query="call ".$db_tbl." ('$ANI','$ussd_string','$menuid','$obd_form_service_id','$obd_form_batchid')";
$subsQuery1=mysql_query($Query);
//exit;
}
$update_status_post = "UPDATE master_db.bulk_ussd_history set status='2',added_on='".$obd_form_uploadtime."' where batch_id='".$obd_form_batchid."'";
 mysql_query($update_status_post,$con);
 }
//close database connection
echo "File processed successfully.";
mysql_close($con);
//close database connection
}

?>