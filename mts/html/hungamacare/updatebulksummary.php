<?php
include("config/dbConnect.php");
$query_getname="select file_name,batch_id,service_id from billing_intermediate_db.bulk_upload_summary where status=0";
$execute_query_getname=mysql_query($query_getname);
while($rows=mysql_fetch_array($execute_query_getname))
{
	$dir_path="/var/www/html/hungamacare/bulkuploads/";
	$dist_dir_path="/var/www/html/hungamacare/status/";
	$file_name=trim($rows['file_name']);
	$batch_id=trim($rows['batch_id']);
	$service_id=trim($rows['service_id']);
	$file_path = $dir_path.$service_id."/".$file_name;
	$dist_dir_path = $dist_dir_path.$service_id."/".$file_name;
	if(file_exists($file_path))
	{
		$file=fopen($file_path,"r");
		$fail=0;
		$success=0;
		while(!feof($file))
		{
			$lbl=trim(fgets($file));
			if($service_id==1102)
			{
				$checking_url="http://10.130.14.107/MTS/check_subscription_MTS.php?msisdn=".$lbl."&flag=1";
			}
			else
			{
				echo $checking_url="http://10.130.14.107/MTS/check_subscription_mtv.php?msisdn=".$lbl."&flag=1";
			}
	
			echo $url_response=file_get_contents($checking_url);
			if($url_response=='Failed')
				$fail++;
			if($url_response=='Success')
				$success++;
			$out_file=fopen($dist_dir_path,"a+");
			fwrite($out_file,$lbl."|".$url_response."\r\n");
			fclose($out_file);
			echo $success."<br>".$fail;
		}
		$log_file_path="/var/www/html/hungamacare/updatebulksummery/".date("Y-m-d").".txt";
		$log_out_file=fopen($log_file_path,"a+");
		fwrite($log_out_file,$file_name."#service_id=".$service_id."#Success_Count-".$success."#Failure_Count-".$fail."#".date("Y-m-d-h-i")."\r\n");
		fclose($log_out_file);
		echo "<br>".$update="update billing_intermediate_db.bulk_upload_summary set status='1',actual_success='$success',actual_failure='$fail' where batch_id='$batch_id' and file_name='$file_name' and service_id='$service_id'";
		$execute_update=mysql_query($update);
	}
}
mysql_close($dbConn);
?>