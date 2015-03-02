<?php
include("dbConnect.php");
	
	$dir_path="/var/www/html/hungamacare/log/";
	
	$file_name1="processlog_".date("dmy").".txt";
	$file_path=$dir_path.$file_name1;
	$fp=fopen($file_path,"a+");
	
	$select_query="select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id,language from vodafone_hungama.bulk_upload_history where status=0 order by added_on desc limit 5";
	$query = mysql_query($select_query, $dbConn) or die(mysql_error());
	while(list($file_name, $datetime, $service_type, $channel, $price, $upload_for,$batch_id,$service_id,$lang) = mysql_fetch_array($query)) 
	{
		fwrite($fp,$file_name.",".$datetime.",".$service_type.",".$channel.",".$price.",". $upload_for.",".$batch_id.",".$service_id.",".$lang."\r\n");

		$update_bulk_history="update vodafone_hungama.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=".$service_id;
		$bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());

		//$file_to_read="http://119.82.69.212/vodafone/bulkuploads/".$service_id."/".$file_name.".txt"; 
        $file_to_read="http://10.43.248.137/hungamacare/bulkuploads/".$service_id."/".$file_name.".txt";
		$file_data=file($file_to_read);
		$file_size=sizeof($file_data);
		$success_count=0;
		$failure_count=0;
		$rejected_count=0;
		switch($upload_for)
		{
			case 'active':
				$logPath = "/var/www/html/hungamacare/bulkuploads/".$service_id."/log/".$file_name.".txt";
				$reqtype=1;
				$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
				$amt = mysql_query($amtquery);
				List($amount) = mysql_fetch_row($amt);
			break;
			case 'deactive':
				$reqtype=2;
				break;
		}
		switch($service_id) {
			case '1302' : $service_name = 'vodafone_54646';
			break;
			case '1307' : $service_name = 'vodafone_vh1';
			break;
			case '1310' : $service_name = 'vodafone_redfm';
			break;
		}
		for($i=0;$i<$file_size;$i++)
		{
			//$msisdn=$file_data[$i];
			$msisdn12=explode("#",$file_data[$i]);
			$msisdn=$msisdn12[0];
			if(strlen(trim($msisdn))==10)
			{
			//added for CCG start
			switch($service_id) {
			case '1302' : $ussd_ccg_url = 'http://10.43.248.137/vodafone/UssdVoda.php?mode=USSD&msisdn='.$msisdn.'&servicename=vodafone_54646';
			break;
			case '1307' : $ussd_ccg_url = 'http://10.43.248.137/vodafone/UssdVoda.php?mode=USSD&msisdn='.$msisdn.'&servicename=vodafone_vh1';
			break;
			case '1310' : $ussd_ccg_url = 'http://10.43.248.137/vodafone/UssdVoda.php?mode=USSD&msisdn='.$msisdn.'&servicename=vodafone_redfm';
			break;
								}
			//end here
			
				if($reqtype==1) {
				
					if($channel=='USSD')
					{
					sleep(2);
					$url_response=file_get_contents($ussd_ccg_url);		
					/*
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $ussd_ccg_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$url_response = curl_exec($ch);
					*/
					$logData = $msisdn."#".$ussd_ccg_url."#".$url_response."#".date('Y-m-d H:i:s')."\n";
					error_log($logData,3,$logPath);
					}
					else
					{					
					$callProcedure1="call master_db.BULK_ACTIVATION('$msisdn','".$lang."','$channel','54646','$amount','$service_id','$price','$batch_id')";
					$callProcedure= mysql_query($callProcedure1);
					$logData = $msisdn."#".$callProcedure1."#".date('Y-m-d H:i:s')."\n";
					error_log($logData,3,$logPath);
					}
					//added for CCG start
					
					//end here
					
				} else {
					$billing_url = "http://10.43.248.137/vodafone/vodafone.php?msisdn=".trim($msisdn);
					$billing_url .= "&mode=".$channel."&reqtype=".$reqtype."&planid=".$price."&subchannel=bulk&servicename=".$service_name."&rcode=100,101,102";
					
					$url_response=file_get_contents($billing_url);
					
					$logData = $msisdn."#".$billing_url."#".$url_response."#".date('Y-m-d H:i:s')."\n";
					error_log($logData,3,$logPath);

					if($url_response==100) $success_count++;
					else $failure_count++;
				}
			}
			else
				$rejected_count++;
		}
		/*$insert_summary_data="insert into vodafone_hungama.bulk_upload_summary(batch_id,file_name,channel,service_id,success_count,failure_count,rejected_count) values('$batch_id','$file_name','$channel','$service_id','$success_count','$failure_count','$rejected_count')";
		$summery_result = mysql_query($insert_summary_data, $dbConn) or die(mysql_error());*/
		echo "<br/>Processing of the file.<b>".$file_name." </b>has been done successfuly";
	}
	fclose($fp);
	mysql_close($dbConn);

?>
