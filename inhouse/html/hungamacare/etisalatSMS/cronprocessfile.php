<?php
//include database connection file
include ("config/dbConnect.php");
$checkfiletoprocess=mysql_query("select batchid,servicename,serviceId, filename, date_time,status,circle,plainid,flagvalue from etislat_hsep.tbl_sms_history_etisalat where status=0 order by batchid ASC limit 8");
$notorestore=mysql_num_rows($checkfiletoprocess);
$addedon=date("Y-m-d H:i:s");
if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
//close database connection
mysql_close($dbConn);
exit;
}

else
{
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{
	
$etislat_sms_batchid=$row_file_info['batchid'];
$obd_form_uploadtime=$row_file_info['date_time'];
$update_status_pre = "UPDATE etislat_hsep.tbl_sms_history_etisalat set status='1',date_time='".$obd_form_uploadtime."' where batchid='".$etislat_sms_batchid."'";
mysql_query($update_status_pre);

$etislat_sms_servicename=$row_file_info['servicename'];
$etislat_sms_serviceId=$row_file_info['serviceId'];
$etislat_sms_filename=$row_file_info['filename'];
$etislat_sms_date_time=$row_file_info['date_time'];
$etislat_sms_circle=$row_file_info['circle'];
$etislat_sms_plainid=$row_file_info['plainid'];
$etislat_sms_flagvalue=$row_file_info['flagvalue'];
$status=0;
//$flag=0;
$flag=$etislat_sms_flagvalue;
$cvspath="smsPackfile/".$etislat_sms_servicename."/".$etislat_sms_filename.'.csv';
$filenametowrite=explode('.',$etislat_sms_filename);
//read and write file from uploaded CSV
$newcsvtextfile="smsPackfile/".$etislat_sms_servicename."/".$filenametowrite[0].'.txt';
$fGetContents = file_get_contents($cvspath);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 1; $i < $totalcount; $i++) {
$data = explode(",", $e[$i]);
if($totalcount!=$i+1)
{
if($etislat_sms_servicename=='AST')
{
//date,message,sun_sign
$smstime=$data[0]." ".$data[1];
$mytime=date("Y-d-m H:i:s",strtotime($smstime));
$datetime=$mytime;
$smsmessage=str_replace("\"", "", trim($data[2]));
$smsmessage=str_replace("’", "'", $smsmessage);
$logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status.'#'.trim($data[2])."#".$addedon."\r\n";
}
else
{
//2012-01-12
//$explodedDate=explode('-',$data[0]);
//10/14/2014,
//Array ( [0] => 10 [1] => 14 [2] => 2014 ) 2181-10-10
$explodedDate=explode('/',$data[0]);
//print_r($explodedDate);
//m d y
//$datetime=date("Y-m-d", mktime(0, 0, 0,$explodedDate[2],$explodedDate[0],$explodedDate[1]));
$smsmessage=str_replace("\"", "", trim($data[2]));
$smsmessage=str_replace("’", "'", $smsmessage);
//$datetime=$explodedDate[2].'-'.$explodedDate[0].'-'.$explodedDate[1];
$datetime=$explodedDate[0].'-'.$explodedDate[1].'-'.$explodedDate[2];

if($etislat_sms_servicename=='JOKES')
{
$smsmessage_priority=trim($data[3]);
if($smsmessage_priority==0)
{
$smsmessage_priority=1;
}
$logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status.'#Priority'.$smsmessage_priority."#".$addedon."\r\n";
$sql_savemsgifo="INSERT INTO etislat_hsep.tbl_sms_service (date_time,message,service_id,plan_id,service,flag,status,time_addedon,msg_pr)
VALUES ('".$datetime."','".mysql_real_escape_string($smsmessage)."','".$etislat_sms_serviceId."','".$etislat_sms_plainid."','".$etislat_sms_servicename."','".$flag."','".$status."','".$addedon."','".$smsmessage_priority."')";
}
else
{
$logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status."#".$addedon."\r\n";
$sql_savemsgifo="INSERT INTO etislat_hsep.tbl_sms_service (date_time,message,service_id,plan_id,service,flag,status,time_addedon,msg_pr)
VALUES ('".$datetime."','".mysql_real_escape_string($smsmessage)."','".$etislat_sms_serviceId."','".$etislat_sms_plainid."','".$etislat_sms_servicename."','".$flag."','".$status."','".$addedon."','1')";
}

if (mysql_query($sql_savemsgifo))
  {
 $logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status."#".$addedon."\r\n";
  }
  else
  {
  }
}
error_log($logData_csv,3,$newcsvtextfile);

}
	}

//read end here
mysql_close($dbConn);
}
//end of while
echo "File processed successfully.";
//close database connection
exit;
}
?>