<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/db_218.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
echo $view_date1;
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/livedump/';
//include service name configuration
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/livedump/wap/processlogBilling_".date(Ymd).".txt";
include ("/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/serviceNameconfig.php");

$DeleteQuery = "delete from misdata.tbl_base_active_wap where date='" . $view_date1 . "' and service in('WAPUninorLDR','WAPUninorContest')";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = '***************Script start for uninorwapSubscriberMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

$fileDumpfile = "activeBasedumpFile_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_ldr_ActiveBaseData = "select 'WAPUninorLDR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,se_product_id,
charging_date,total_no_downloads,affid,device_model,deviceUA,plan_id from uninor_ldr.tbl_ldr_subscription nolock
where status=1 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_ActiveBaseData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$se_product_id,$charging_date,$total_no_downloads,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	
		if($plan_id==266)
		$subscribed_for=99;
		
		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Active|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."|".$subscribed_for."\r\n";
 error_log($activeBaseData, 3, $fileDumpPath1);
	}
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser,subscribed_for)';
  
  if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Active Base'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Active Base-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}

// Pending base
$fileDumpfile = "pendingBasedumpFile_" . date('ymd') . '.txt';
$fileDumpPath2 = $fileDumpPath . $fileDumpfile;

$get_ldr_PendingBaseData = "select 'WAPUninorLDR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,se_product_id,
charging_date,total_no_downloads,affid,device_model,deviceUA,plan_id from uninor_ldr.tbl_ldr_subscription nolock
where status=11 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_PendingBaseData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath2);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$se_product_id,$charging_date,$total_no_downloads,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
		if($plan_id==266)
		$subscribed_for=99;
		
		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Pending|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."|".$subscribed_for."\r\n";
      error_log($activeBaseData, 3, $fileDumpPath2);
        }
		

    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath2 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser,subscribed_for)';
	
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
//Uninor Contest Base Insertion start here

$fileDumpfile = "activeBasedumpFileKiji_" . date('ymd') . '.txt';
$fileDumpPath3 = $fileDumpPath . $fileDumpfile;

$get_kiji_ActiveBaseData = "select 'WAPUninorContest',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,affid,device_model,deviceUA,plan_id from uninor_summer_contest.tbl_contest_subscription_wapcontest nolock
where status=1 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_kiji_ActiveBaseData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath3);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
	
		if($plan_id==270 || $plan_id==24)
		$subscribed_for=5;
		
		$charging_date='';
		$total_no_downloads=0;
		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Active|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."|".$subscribed_for."\r\n";
 error_log($activeBaseData, 3, $fileDumpPath3);
	}
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath3 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser,subscribed_for)';
  
  if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Active Base KIJI'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Active Base KIJI-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}

// Pending base KIJI
$fileDumpfile = "pendingBasedumpFileKiji_" . date('ymd') . '.txt';
$fileDumpPath4 = $fileDumpPath . $fileDumpfile;

$get_kiji_PendingBaseData = "select 'WAPUninorContest',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,circle,chrg_amount,
affid,device_model,deviceUA,plan_id from uninor_summer_contest.tbl_contest_subscription_wapcontest nolock
where status=11 and date(sub_date)<='" . $view_date1 . "'";

$query1 = mysql_query($get_kiji_PendingBaseData, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath4);
    while (list($service,$msisdn,$sub_date,$renew_date,$mode_of_sub,$circle,$chrg_amount,$affid,$device_model,$device_browser,$plan_id) = mysql_fetch_array($query1)) {
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
		if($plan_id==270 || $plan_id==24)
		$subscribed_for=5;
		
		$charging_date='';
		$total_no_downloads=0;
		
		
$activeBaseData = $view_date1."|".$service."|".$msisdn . "|" . $circle . "|" . $mode_of_sub . "|" . $affid . "|" . $sub_date . "|" . $renew_date. "|Pending|" . $chrg_amount. "|" . $charging_date. "|" . intval($total_no_downloads). "|" . $device_model. "|" . $device_browser."|".$subscribed_for."\r\n";
      error_log($activeBaseData, 3, $fileDumpPath4);
        }
		

    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath4 . '" INTO TABLE misdata.tbl_base_active_wap FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  (date,service,msisdn,circle,mode,affiliate,sub_date,validity_date,status,last_charged,last_charged_on,bal_downloads,device_model,device_browser,subscribed_for)';
	
	if(mysql_query($insertDump8, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Pending Base kiji'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Pending Base kiji-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
	
}


$file_process_status = '***************Script end for uninorwapSubscriberMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath1);
unlink($fileDumpPath2);
unlink($fileDumpPath3);
unlink($fileDumpPath4);

mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>