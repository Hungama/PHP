<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
echo $view_date1;
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/tata/livedump/wap/';
//include service name configuration
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/tata/livedump/wap/processlogSubscriberBase_".date(Ymd).".txt";
include ("/var/www/html/kmis/mis/docomo/serviceNameconfig.php");
$DeleteQuery = "delete from misdata.tbl_base_active_wap where date='" . $view_date1 . "' and service='WAPTataDoCoMoLDR'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for airtelwapSubscriberMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

$fileDumpfile = "activeBasetatawapdumpFile_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_ldr_ActiveBaseData = "select 'WAPTataDoCoMoLDR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,se_product_id,
charging_date,total_no_downloads,affid,device_model,deviceUA,plan_id from tata_ldr.tbl_ldr_subscription nolock
where status=1 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_ActiveBaseData, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$se_product_id,$charging_date,$total_no_downloads,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
			
		if($plan_id==501 || $plan_id==505)
		$subscribed_for=99;
		else if($plan_id==502 || $plan_id==506)
		$subscribed_for=49;
		else if($plan_id==503 || $plan_id==507)
		$subscribed_for=35;
		else if($plan_id==504 || $plan_id==508)
		$subscribed_for=5;
		
		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Active|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."\r\n";
 error_log($activeBaseData, 3, $fileDumpPath1);
	}
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser)';
  //mysql_query($insertDump7, $LivdbConn);
  if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Active Base'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Data Error Active Base-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}

// Pending base
$fileDumpfile = "pendingBasetatawapdumpFile_" . date('ymd') . '.txt';
$fileDumpPath2 = $fileDumpPath . $fileDumpfile;

$get_ldr_PendingBaseData = "select 'WAPTataDoCoMoLDR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,se_product_id,
charging_date,total_no_downloads,affid,device_model,deviceUA,plan_id from tata_ldr.tbl_ldr_subscription nolock
where status=11 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_PendingBaseData, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath2);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$se_product_id,$charging_date,$total_no_downloads,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
     
 	 if($plan_id==501 || $plan_id==505)
		$subscribed_for=99;
		else if($plan_id==502 || $plan_id==506)
		$subscribed_for=49;
		else if($plan_id==503 || $plan_id==507)
		$subscribed_for=35;
		else if($plan_id==504 || $plan_id==508)
		$subscribed_for=5;

		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Pending|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."\r\n";
      error_log($activeBaseData, 3, $fileDumpPath2);
        }
		

    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath2 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser)';
	//mysql_query($insertDump8, $LivdbConn);
	
	  if(mysql_query($insertDump8, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Pending Base'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Pending Base-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
	
}
$file_process_status = '***************Script end for airtelwapSubscriberMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath1);
unlink($fileDumpPath2);
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
?>