<?php
include("db.php");
$checkfiletoprocess=mysql_query("select batch_id,file_name,service_id,added_on,menuid,ussd_string,upload_for,flag,schedule_for,start_date,end_date from master_db.bulk_ussd_history where status =0 and total_file_count<=25000 and upload_for in('live','test') order by batch_id ASC limit 4");
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
$form_ussd_mode=$row_file_info['upload_for'];
$form_ussd_schedule_for=$row_file_info['schedule_for'];
$form_ussd_start_date=$row_file_info['start_date'];
$form_ussd_end_date=$row_file_info['end_date'];


$update_status_pre = "UPDATE master_db.bulk_ussd_history set status='1',added_on='".$obd_form_uploadtime."' where batch_id='".$obd_form_batchid."'";
  mysql_query($update_status_pre,$con);
$obd_form_mob_file=$row_file_info['file_name'];
$obd_form_service_id=$row_file_info['service_id'];

if($form_ussd_mode=='live')
{
$lines = file('ussdbulkfile/'.$obd_form_mob_file);
foreach ($lines as $line_num => $mobno)
{
//read line of file
$mno=trim($mobno);
$ANI=$mno;
$menuid=$obd_form_menuid;
$ussd_string=$obd_form_ussd_string;

$status=1;
$db_tbl='USSD.REDFM_USSD_BULK_WL_NEW';
$Query="call ".$db_tbl." ('$ANI','$ussd_string','$menuid','$obd_form_service_id','$obd_form_batchid','$form_ussd_schedule_for','$status','$form_ussd_start_date','$form_ussd_end_date')";

$subsQuery1=mysql_query($Query);
}
}
else
{
$form_test_ani=$row_file_info['flag'];
$menuid=$obd_form_menuid;
$ussd_string=$obd_form_ussd_string;
$status=5;
$ANI=$form_test_ani;
$allani=explode(',',$ANI);
$totaltestno=count($allani);
for($i=0;$i<$totaltestno;$i++)
{
$push_ani=$allani[$i];
$db_tbl='USSD.REDFM_USSD_BULK_WL_NEW';
$Query="call ".$db_tbl." ('$push_ani','$ussd_string','$menuid','$obd_form_service_id','$obd_form_batchid','$form_ussd_schedule_for','$status','$form_ussd_start_date','$form_ussd_end_date')";
$subsQuery1=mysql_query($Query);
}

}

$update_status_post = "UPDATE master_db.bulk_ussd_history set status='2',added_on='".$obd_form_uploadtime."' where batch_id='".$obd_form_batchid."'";
 mysql_query($update_status_post,$con);
 }
//close database connection
echo "File processed successfully.";
mysql_close($con);
//close database connection
exit;
}
?>