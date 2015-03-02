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
		}
		return $shortCode;
	}
	
	$dir_path="/var/www/html/hungamacare/log/";
	
	$file_name1="processlog_".date("dmy").".txt";
	$file_path=$dir_path.$file_name1;
	$fp=fopen($file_path,"a+");
	
	$select_query="select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id from billing_intermediate_db.bulk_upload_history where status=0 and service_id in(1101,1102,1103,1111,1106,1110) limit 1";
	
	$query = mysql_query($select_query, $dbConn) or die(mysql_error());
	while(list($file_name, $datetime, $service_type, $channel, $price, $upload_for,$batch_id,$service_id) = mysql_fetch_array($query)) 
	{
		fwrite($fp,$file_name.",".$datetime.",".$service_type.",".$channel.",".$price.",". $upload_for.",".$batch_id.",".$service_id."\r\n");

		$update_bulk_history="update billing_intermediate_db.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=".$service_id;
		$bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());

		$file_to_read="http://10.130.14.107/hungamacare/bulkuploads/".$service_id."/".$file_name;
		$file_data=file($file_to_read);
		$file_size=sizeof($file_data);
		switch($upload_for)
		{
			case 'active':
				$reqtype=1;
				$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
				$amt = mysql_query($amtquery,$dbConn);
				List($amount) = mysql_fetch_row($amt);
			break;
			case 'deactive':
				$reqtype=2;
				$price=7;
			break;
			case 'topup':
				$reqtype='topup';
			break;
			case 'renewal':
				$reqtype='resub';
				$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$price' and S_id=$service_id";
				$amt = mysql_query($amtquery,$dbConn);
				List($amount) = mysql_fetch_row($amt);
			break;
		}
		for($i=0;$i<$file_size;$i++)
		{
			$msisdn=trim($file_data[$i]);
			switch($service_id)
			{
				case '1101':
					$tableName='mts_radio.tbl_radio_blacklist';
					break;
				case '1102':
					$tableName='mts_hungama.tbl_jbox_blacklist';
					break;
				case '1103':
					$tableName='mts_mtv.tbl_jbox_blacklist';
					break;
				case '1106':
					$tableName='mts_starclub.tbl_jbox_blacklist';
					break;
				case '1111':
					$tableName='dm_radio.tbl_jbox_blacklist';
					break;
				case '1110':
					$tableName='mts_redfm.tbl_jbox_blacklist';
					break;
			}
			$getBlacklist="select count(*) from ".$tableName ." where ani=".$msisdn;
			$BlackList = mysql_query($getBlacklist,$dbConn);
			List($BList) = mysql_fetch_row($BlackList);
			if(strlen(trim($msisdn))==10 && $BList<=0)
			{
				if($reqtype==2)
				{
					$billing_url ="http://10.130.14.107/MTS/MTS.php?msisdn=".trim($msisdn);
					$billing_url .="&mode=".$channel."&reqtype=".$reqtype."&planid=".$price."&serviceid=".$service_id."&ac=0";
					$billing_url .="&subchannel=bulk&rcode=100,101,102";
					$url_response=file_get_contents($billing_url);
				}
				elseif($reqtype==1)
				{				
					$billing_url ="http://10.130.14.107/MTS/MTS.php?msisdn=".trim($msisdn);
					$billing_url .="&mode=".$channel."&reqtype=".$reqtype."&planid=".$price."&serviceid=".$service_id."&ac=0";
					$billing_url .="&subchannel=bulk&rcode=100,101,102";
					$url_response=file_get_contents($billing_url);
				} 
				elseif($reqtype=='topup') {
					/*$topup_url ="http://10.130.14.107/topup/topup.php?ani=".trim($msisdn)."&amount=".$price;
					$url_response=file_get_contents($topup_url);*/					

					$lang='02';
					$plan_id='5';
					$mode='OBD-MS';
					$sc='54646';

					$getCircle="select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
					$circle1=mysql_query($getCircle);
					$circle=mysql_fetch_row($circle1);
					
					$insertToppupRequest="insert into master_db.tbl_billing_reqs values('',$msisdn,'TOPUP',now(),$price,0,'$lang',$sc,'$mode','$circle[0]','MTSM',$service_id,0,$plan_id)";
					$qry1=mysql_query($insertToppupRequest);

					$log_file_path="/var/www/html/topup/log/bulk_topup_log_".date('Y-m-d').".txt";
					$LogString=$msisdn."#".$mode."#".date('H:i:s')."#".$price."#".$insertToppupRequest."\r\n";
					error_log($LogString,3,$log_file_path);
				} 
				elseif($reqtype == "resub") {
					$getCircle="select circle from master_db.tbl_valid_series where series=substring($msisdn,1,4) and length(series)=4";
					$circle1=mysql_query($getCircle);
					$circle=mysql_fetch_row($circle1);
					$plan_id = $price;
					
					$shortCode = getShortCode($service_id);					
					$insertResubRequest="insert into master_db.tbl_billing_reqs values('','".$msisdn."','RESUB',now(),$amount,0,'01','".$shortCode."','$channel','$circle[0]','MTSM',$service_id,0,$plan_id)";

					$qry1=mysql_query($insertResubRequest);
			
					$log_file_path="/var/www/html/hungamacare/log/bulk_resub_log_".date('Y-m-d').".txt";
					$LogString=$msisdn."#".$channel."#".date('H:i:s')."#".$price."#".$insertResubRequest."\n";
					error_log($LogString,3,$log_file_path);
				}
			}
		} // end of for 
		echo "<br/>Processing of the file.<b>".$file_name." </b>has been done successfuly";
	} // end of while
	echo "done";
	fclose($fp);
	mysql_close($dbConn);
?>
