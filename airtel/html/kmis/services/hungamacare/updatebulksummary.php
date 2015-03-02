<?php
include("config/dbConnect.php");
$query_getname="select file_name,batch_id,service_id from billing_intermediate_db.bulk_upload_summary where status=0";
$execute_query_getname=mysql_query($query_getname);
while($rows=mysql_fetch_array($execute_query_getname))
{
	$dir_path="/var/www/html/kmis/services/hungamacare/bulkuploads/";
	$dist_dir_path="/var/www/html/kmis/services/hungamacare/status/";
	$file_name=trim($rows['file_name']);
	$batch_id=trim($rows['batch_id']);
	$service_id=trim($rows['service_id']);
	$file_path = $dir_path.$service_id."/".$file_name;
	$dist_dir_path = $dist_dir_path.$service_id."/".$file_name;
	$out_file=fopen($dist_dir_path,"a+");
	chmod($dist_dir_path,0777);
	if(file_exists($file_path))
	{
		$file=fopen($file_path,"r");
		$fail=0;
		$success=0;
		while(!feof($file))
		{
			$lbl=trim(fgets($file));
			if($service_id==1001)
			{
				$checking_url="http://10.2.73.156/docomo/check_subscription.php";
				$checking_url.="?msisdn=".$lbl."&flag=1";
			}
			else
			{
				$checking_url="http://10.2.73.156/reliance/check_subscription_reliance.php";
				$checking_url .="?msisdn=".$lbl."&flag=1&service=".$service_id;
			}
			$timeout=1;
			$url_response=file_get_contents($checking_url);
			/*$ch = curl_init($checking_url);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS,$checkData);
			curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			curl_setopt ($ch,CURLOPT_TIMEOUT,$timeout);
			//curl_setopt ($ch, CURLOPT_FILE, $out_file);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1)
			$url_response=curl_exec ($ch);
			
			curl_close ($ch);*/
			if(trim($url_response)=='Failed')
				$fail++;
			elseif(trim($url_response)=='Success')
				$success++;
			fwrite($out_file,$lbl."|".$url_response."\r\n");
		}
		$log_file_path="/var/www/html/kmis/services/hungamacare/updatebulksummery/".date("Y-m-d").".txt";
		$log_out_file=fopen($log_file_path,"a+");
		fwrite($log_out_file,$file_name."#service_id=".$service_id."#Success_Count-".$success."#Failure_Count-".$fail."#".date("Y-m-d-h-i")."\r\n");
		fclose($out_file);
		fclose($log_out_file);
	}
	
	$update="update billing_intermediate_db.bulk_upload_summary set status='1',actual_success='$success',actual_failure='$fail' where batch_id='$batch_id' and file_name='$file_name' and service_id='$service_id'";
	$execute_update=mysql_query($update);
}
mysql_close($dbConn);
?>