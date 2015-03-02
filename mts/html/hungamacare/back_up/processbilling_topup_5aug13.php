<?php
include("config/dbConnect.php");

	function getShortCode($serviceId) {
		$shortCode="";
		switch($serviceId) {
			case '1101':
				$shortCode='52222';
				break;
			case '11012':
				$shortCode='5222212';
				break;
			case '1102':
				$shortCode='54646';
				break;
			case '1103':
				$shortCode='546461';
				break;
			case '1106':
				$shortCode='5432155';
				break;
			case '1111':
				$shortCode='5432105';
				break;
			case '1110':
				$shortCode='55935';
				break;
			case '1116':
				$shortCode='54444';
				break;
			case '1113':
				$shortCode='54646196';
				break;
			case '1124':
				$shortCode='522223';
				break;
			case '1125':
				$shortCode='5464622';
				break;
				
		}
		return $shortCode;
	}
	
	$dir_path="/var/www/html/hungamacare/log/";
	
	$file_name1="processlog_topup_".date("dmy").".txt";
	$file_path=$dir_path.$file_name1;
	$fp=fopen($file_path,"a+");
	
	$select_query="select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id,amount,language from billing_intermediate_db.bulk_upload_history where status=0 and upload_for='event_active' and service_id in(1101,1102,1103,1111,1106,1110,1116,1113,1124) limit 1";
	
	$query = mysql_query($select_query, $dbConn) or die(mysql_error());
	while(list($file_name, $datetime, $service_type, $channel, $price, $upload_for,$batch_id,$service_id,$Newamount,$lang) = mysql_fetch_array($query)) 
	{
	
		fwrite($fp,$file_name.",".$datetime.",".$service_type.",".$channel.",".$price.",". $upload_for.",".$batch_id.",".$service_id.",".$Newamount.",".$lang."\r\n");

		$update_bulk_history="update billing_intermediate_db.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=".$service_id;
		$bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());

		$file_to_read="http://10.130.14.107/hungamacare/bulkuploads/".$service_id."/".$file_name;
		$file_data=file($file_to_read);
		$file_size=sizeof($file_data);
		switch($upload_for)
		{
			case 'event_active':
				$reqtype=1;
			break;
				case 'topup':
				$reqtype='topup';
			break;
		}
	//}
		for($i=0;$i<$file_size;$i++)
		{
			$msisdn=trim($file_data[$i]);
			switch($service_id)
			{
				case '1102': 
							$subscriptionProcedure="mts_hungama.JBOX_EVENT_ACT_BULK";
				//MTS 54646
				break;
				case '1103': //MTS MTV topup
							$subscriptionProcedure="mts_mtv.MTV_EVENT_ACT_BULK";
					break;
				case '1106': //MTS StarClub(MTSFMJ)
							$subscriptionProcedure="mts_starclub.FMJ_EVENT_ACT_BULK";
				break;
				case '1110': //MTS REDFM
							$subscriptionProcedure="mts_redfm.REDFM_EVENT_ACT_BULK";
				break;
				case '1116': //MTSVA
							$subscriptionProcedure="mts_voicealert.VA_EVENT_ACT_BULK";
				break;
				case '1113': //MTS MND
							$subscriptionProcedure="mts_mnd.MND_EVENT_ACT_BULK";
				break;
				case '1125': 
					         $subscriptionProcedure="mts_JOKEPORTAL.JOKEPORTAL_EVENT_ACT_BULK";
				break;
					//MTS JOKES
			}
			if($reqtype == 1) {
					$plan_id = $price;
					$shortCode = getShortCode($service_id);					
			
			$call = "call " . $subscriptionProcedure . "('$msisdn','$lang','$channel','$shortCode','$Newamount',$service_id,$price,'$batch_id')";
			$qry1 = mysql_query($call,$dbConn) or die(mysql_error());
          
					$log_file_path="/var/www/html/hungamacare/bulkuploads/topupcharging/topup_log_".date('Y-m-d').".txt";
					$LogString=$msisdn."#".$channel."#".date('H:i:s')."#".$price."#".$call."\n";
					error_log($LogString,3,$log_file_path);
				}
			
		} // end of for 
		$update_bulk_history="update billing_intermediate_db.bulk_upload_history set status=2 where batch_id=$batch_id and service_id=".$service_id;
		$bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());
		echo "<br/>Processing of the file.<b>".$file_name." </b>has been done successfuly";
	} // end of while
	echo "done";
	fclose($fp);
	mysql_close($dbConn);
?>
