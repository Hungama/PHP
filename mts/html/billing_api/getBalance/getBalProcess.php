<?php
#require_once("/var/www/html/hungamacare/2.0/incs/db.php");
require_once("/var/www/html/hungamacare/config/dbConnect_MTS.php");
$logfile= date('ymd').'.txt';

$get_query="select id,batch_id,file_name from billing_intermediate_db.getBal_upload_history where status=0 and scheduletime<=now() order by added_on desc limit 1";
$query = mysql_query($get_query,$dbConn);
$file_name=mysql_fetch_array($query);
$read_file_name= $file_name['file_name'];
$batch_id=$file_name['batch_id'];
$update_query="update billing_intermediate_db.getBal_upload_history set status='3' where batch_id='".$batch_id."'";                
$update_query_result = mysql_query($update_query,$dbConn);                

//$file_name="robhung2-sept6.txt";
 $file_to_read = "http://10.130.14.107/hungamacare/bulkuploads/getbalance/".$read_file_name;
 
    $file_data = file($file_to_read);
    $file_size = sizeof($file_data);
	  for ($i = 0; $i < $file_size; $i++) {
	   $msisdn = trim($file_data[$i]);
		$billing_url="http://10.130.14.107/billing_api/getBalance/mts_billing_api_getBal.php?rn=QB&msisdn=".$msisdn."&fname=".$read_file_name;
		$url_response = file_get_contents($billing_url);
		$logstring = $batch_id . "#" . $msisdn."#".$billing_url."#".date('y-m-d H:i:s'). "\r\n";
		//error_log($logstring, 3, $logfile);
		}               
               
$update_query="update billing_intermediate_db.getBal_upload_history set status='2' where batch_id='".$batch_id."'";                
$update_query_result = mysql_query($update_query,$dbConn);                
echo "done"."<br>";	
mysql_close($dbConn);
?>