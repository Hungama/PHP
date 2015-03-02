<?php
//include("config/dbConnect.php");
	include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	//$dbConn = mysql_connect("10.2.73.156","billing","billing");
	
	$dir_path="/var/www/html/kmis/services/hungamacare/log/";
	
	$file_name1="processlog_".date("dmy").".txt";
	$file_path=$dir_path.$file_name1;
	$fp=fopen($file_path,"a+");
	
	$select_query="select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id from airtel_hungama.bulk_upload_history where status=0 order by added_on desc limit 1";
	$query = mysql_query($select_query, $dbConn) or die(mysql_error());
	while(list($file_name, $datetime, $service_type, $channel, $price, $upload_for,$batch_id,$service_id) = mysql_fetch_array($query)) 
	{		
		fwrite($fp,$file_name.",".$datetime.",".$service_type.",".$channel.",".$price.",". $upload_for.",".$batch_id.",".$service_id."\r\n");

		$update_bulk_history="update airtel_hungama.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=".$service_id;
		$bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());

		$file_to_read="http://10.2.73.156/kmis/services/hungamacare/bulkuploads/".$service_id."/".$file_name.".txt";
		$file_data=file($file_to_read);
		$file_size=sizeof($file_data);
		$success_count=0;
		$failure_count=0;
		$rejected_count=0;
		switch($upload_for)
		{
			case 'active':
				$reqtype=1;
				$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
				$amt = mysql_query($amtquery);
				List($amount) = mysql_fetch_row($amt);
			break;
			case 'deactive':
				if($service_id == '15022') { $service_id='1502'; }
				elseif($service_id == '1504') { $service_id='1511'; }
				$reqtype=2;
			break;
		}
		for($i=0;$i<$file_size;$i++)
		{
			//$msisdn=$file_data[$i];
			$msisdn12=explode("#",$file_data[$i]);
			$msisdn=trim($msisdn12[0]);
			if(strlen(trim($msisdn))==10)
			{
				$logPath="/var/www/html/kmis/services/hungamacare/log/bulk_upload_log_".date("Ymd").".txt";
				if($reqtype==1)
				{	
					//$logPath="/var/www/html/kmis/services/hungamacare/log/bulk_upload_log_".date("Ymd").".txt";
					/*if($service_id==1511 && ($plan_id==30 || $plan_id==48)) {
						$callProcedure1="call airtel_manchala.RIYA_SUB_BULK($msisdn,'01','$channel','5500169',$amount,$service_id,$price)";					
					} else {
						$callProcedure1="call master_db.BULK_ACTIVATION($msisdn,'01','$channel',54646,$amount,$service_id,$price,$batch_id)";
					} */

					$callProcedure1="call master_db.BULK_ACTIVATION($msisdn,'01','$channel',54646,$amount,$service_id,$price,$batch_id)";
					$callProcedure= mysql_query($callProcedure1);
					$logData=$msisdn."#".$service_id."#".$price."#".$channel."#".$callProcedure1."#".date("Y-m-d H:i:s")."\n";
					error_log($logData,3,$logPath);
				}
				else
				{	
					$billing_url="http://10.2.73.156/airtel/airtel.php?msisdn=".trim($msisdn);
					$billing_url .="&mode=".$channel."&reqtype=".$reqtype."&planid=".$price."&subchannel=bulk&serviceid=".$service_id."&rcode=100,101,102";
					$url_response=file_get_contents($billing_url);
					if($url_response==100)
						$success_count++;
					else
						$failure_count++;
					$logData=$msisdn."#".$service_id."#".$channel."#".$billing_url."#".$url_response."#".date("Y-m-d H:i:s")."\n";
					error_log($logData,3,$logPath);
				}
			}
			else
				$rejected_count++;
		}
		$insert_summary_data="insert into billing_intermediate_db.bulk_upload_summary(batch_id,file_name,channel,service_id,success_count,failure_count,rejected_count) values('$batch_id','$file_name','$channel','$service_id','$success_count','$failure_count','$rejected_count')";
		$summery_result = mysql_query($insert_summary_data, $dbConn) or die(mysql_error());
		echo "<br/>Processing of the file.<b>".$file_name." </b>has been done successfuly";
	}
	fclose($fp);
	mysql_close($dbConn);

?>