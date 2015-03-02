<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$logpath="/var/www/html/airtel/CC/bulkuploads/logs/log_".date('Ymd').".txt";
$select_query="select file_name, batch_id,service_id from airtel_hungama.bulk_upload_history where status=11 order by added_on desc limit 1";
$query = mysql_query($select_query, $dbConnAirtel) or die(mysql_error());
$num=mysql_num_rows($query);
if($num==1)
{
while(list($file_name,$batch_id,$service_id) = mysql_fetch_array($query)) 
	{
			//copy file to airtel (156) server start here
				$path_src="/var/www/html/airtel/CC/bulkuploads/".$service_id."/".$file_name.".txt";
				$path_dest="/var/www/html/kmis/services/hungamacare/bulkuploads/".$service_id."/".$file_name.".txt";
				$cmd="sshpass -p 'P#PO#MA#DI!&TOPO!H%' scp $path_src root@10.2.73.156:$path_dest";
				$out = shell_exec($cmd);
			//end here
			
			//copy lck file to airtel (156) server start here
				$path_src_lck="/var/www/html/airtel/CC/bulkuploads/".$service_id."/".$file_name.".lck";
				$path_dest_lck="/var/www/html/kmis/services/hungamacare/bulkuploads/".$service_id."/".$file_name.".lck";
				$cmd_lck="sshpass -p 'P#PO#MA#DI!&TOPO!H%' scp $path_src_lck root@10.2.73.156:$path_dest_lck";
				$out_lck = shell_exec($cmd_lck);
			//end here
			
	$update_bulk_history="update airtel_hungama.bulk_upload_history set status=0 where batch_id=$batch_id and service_id=".$service_id;
	$bulk_update_result = mysql_query($update_bulk_history, $dbConnAirtel) or die(mysql_error());
	$logData=$batch_id."#".$service_id."#".$file_name."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logpath);
	}
echo "done";
}
else
{
echo "No file to process";
}
mysql_close($dbConnAirtel);
exit;
?>