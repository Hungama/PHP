<?php
//include database connection file
include ("config/dbConnect.php");
//check for status ready to upload 
//select * from  `etislat_hsep`.`tbl_sms_history_etisalat` 
$checkfiletoprocess=mysql_query("select batchid,servicename,serviceId, filename, date_time,status,circle,plainid from etislat_hsep.tbl_sms_history_etisalat where status=0 order by batchid ASC limit 1");
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
$update_status_pre = "UPDATE etislat_hsep.tbl_sms_history_etisalat set status='1' where batchid='".$etislat_sms_batchid."'";
  mysql_query($update_status_pre);

$etislat_sms_servicename=$row_file_info['servicename'];
$etislat_sms_serviceId=$row_file_info['serviceId'];
$etislat_sms_filename=$row_file_info['filename'];
$etislat_sms_date_time=$row_file_info['date_time'];
$etislat_sms_circle=$row_file_info['circle'];
$etislat_sms_plainid=$row_file_info['plainid'];

$status=0;
$flag=0;
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
$datetime=date("Y-m-d H:i:s",strtotime($data[0]));
$smsmessage=str_replace("\"", "", trim($data[1]));

//$logData_csv=$datetime.'#'.preg_replace('#[^\w()/.%\-&]#'," ",$smsmessage).'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status.'#'.trim($data[2])."#".$addedon."\r\n";
$logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status.'#'.trim($data[2])."#".$addedon."\r\n";
}
else
{
//date,message
$datetime=date("Y-m-d H:i:s",strtotime($data[0]));
$smsmessage=str_replace("\"", "", trim($data[1]));
//$logData_csv=$datetime.'#'.preg_replace('#[^\w()/.%\-&]#'," ",$smsmessage).'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status."#".$addedon."\r\n";

echo $logData_csv=$datetime.'#'.$smsmessage.'#'.$etislat_sms_serviceId.'#'.$etislat_sms_plainid.'#'.$etislat_sms_servicename.'#'.$flag.'#'.$status."#".$addedon."\r\n";
}
error_log($logData_csv,3,$newcsvtextfile);

}
	}

//read end here
$csv_anifile_path=$newcsvtextfile;
if($etislat_sms_servicename=='AST')
{
$sql_csvinfo= 'LOAD DATA LOCAL INFILE "'.$csv_anifile_path.'" 
        INTO TABLE etislat_hsep.tbl_sms_astro
        FIELDS TERMINATED BY "#" 
        LINES TERMINATED BY "\n" 
        (date_time,message,service_id,plan_id,service,flag,status,sun_sign,time_addedon)';
}
else
{
	
$sql_csvinfo= 'LOAD DATA LOCAL INFILE "'.$csv_anifile_path.'" 
        INTO TABLE etislat_hsep.tbl_sms_service
        FIELDS TERMINATED BY "#" 
		LINES TERMINATED BY "\n" 
        (date_time,message,service_id,plan_id,service,flag,status,time_addedon)';

}
mysql_query("set names 'utf8'");
if(mysql_query($sql_csvinfo))
                               {
                                   $isupload=true;
								  
                               }
                           else
                               {
                                    $isupload=false;
     							    
                               }
mysql_close($dbConn);

}//end of while
echo "File processed successfully.";
//close database connection
exit;
}
?>