<?php
$con = mysql_connect("192.168.100.224","webcc","webcc");
//check for status ready to upload  
$checkfiletoprocess=mysql_query("select file_name,service_id,trim(upload_for) as upload_for from master_db.bulk_upload_history where status=0 and channel='TC' and total_file_count<=20000 and service_id like '10%' limit 1",$con);
$notorestore=mysql_num_rows($checkfiletoprocess);
if($notorestore==0)
{
$logData='No file to process'."\n\r";
echo $logData;
error_log($logData,3,$logPath2);
mysql_close($con);
exit;
}
else
{
$logPath = "/var/www/html/kmis/services/hungamacare/bulkuploads/";
$row_file_info = mysql_fetch_array($checkfiletoprocess);
$filename=$row_file_info['file_name'];
$planid=$row_file_info['circle'];
$service_id=$row_file_info['service_id'];
$upload_for=$row_file_info['upload_for'];
//$filepath=$logPath.$serviceid.'/'.$file.".txt";
if($upload_for=='active')
{
//192.168.100.212
$file_to_read="http://192.168.100.212/kmis/services/hungamacare/bulkuploads/".$service_id."/".$filename.".txt";
$file_data=file($file_to_read);
$file_size=sizeof($file_data);
//$lines = file($file_to_read);
/*foreach ($lines as $line_num => $mobno)
 {
echo $mno=trim($mobno);
  }
*/

for($i=0; $i<$file_size; $i++) {
	$line = trim($file_data[$i]);
echo $line;
}

}

mysql_close($con);
exit;
}
?>