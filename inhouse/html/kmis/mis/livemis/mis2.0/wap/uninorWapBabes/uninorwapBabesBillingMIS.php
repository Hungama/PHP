<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectS2Nmro.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$view_date1='2014-11-04';
echo $view_date1;
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorWapBabes/livedump/wap/';
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorWapBabes/livedump/wap/processlogBilling_".date(Ymd).".txt";
include ("/var/www/html/kmis/mis/livemis/mis2.0/wap/uninorWapBabes/serviceNameconfig.php");

$DeleteQuery = "delete from misdata.tbl_billing_wap_3puninor_babes  where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$file_process_status = '***************Script start for uninorwapBabesBillingMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}
//$successTable = "master_db.tbl_billing_success";
//Success Data
$fileDumpfile = "billingSuccessdumpFile_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;
$get_ldr_BillingData = "select billing_ID,concat('91',msisdn),event_type,status,SC,MODE,circle,operator,amount,chrg_amount,service_id,plan_id,response_time,trans_ID,aff_id,ccg_id,case event_type when 'sub' then 'Activation' when 'SUB_RETRY' then 'Activation' when 'TOPUP' then 'TOP-UP' when 'Event' then 'Event' when 'resub' then 'Renewal' when 'Grace' then 'Renewal' when 'Resub_Fail' then 'Renewal' when 'Resub_Retry_Fail' then 'Renewal' when 'EVENT_RETRY' then 'Event' when 'park' then 'Renewal' when 'ALRSUB' then 'Activation' when 'sub_fail' then 'Activation' else event_type end 'TYPE',deviceUA
from $successTable nolock where date(response_time)='" . $view_date1 . "' and service_id='3001' order by response_time desc";

$query1 = mysql_query($get_ldr_BillingData, $dbConnS2) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($billing_ID,$msisdn,$event_type,$status,$SC,$MODE,$circle,$operator,$amount,$chrg_amount,$service_id,$plan_id,$response_time,$trans_ID,$affid,$CGID,$TYPE,$Device_browser) = mysql_fetch_array($query1)) {
		 $service_name = getServiceName($service_id);
		 
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
//Activation, Renewal, Deactivation, Grace, Parking, Suspend, Download
		$ChannelID=$MODE;
		
		if($ChannelID==0)
		$ChannelID='WAP';
		
		$trnsType=$TYPE;
		if($status==1)
		{
		$Result=1;
		$status='SUCCESS';
		}
		$contentid='';
		
      $billingData = $billing_ID . "|" . $msisdn . "|" . $circle . "|" . $ChannelID . "|" . $response_time . "|" . $CGID. "|" . $affid. "|" . $trnsType. "|" . $amount. "|" . $chrg_amount. "|" . $Result. "|" . $status. "|" . $contentid. "|" . $Device_model. "|" . $Device_Os. "|" . $Device_browser. "|" . $ContentType."|"."\r\n";
      error_log($billingData, 3, $fileDumpPath1);
        }

    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.tbl_billing_wap_3puninor_babes FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(orderid,msisdn,circle,channel_id,date,cgid,affiliate,type,amount_attempted,amount_charged,result,status,content_id,device_model,device_os,device_browser,contenttype)';
    if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Billing success'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Billing success-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
		
}

//Failure Data

$failreasonArray=array('19'=>'Dates are not valid','35'=>'Requested product is not a parent product','4'=>'Product already subscribed','17'=>'Product not mapped to CP','31'=>'Product not active','3'=>'Product validation failure','2'=>'CP authentication failure','0'=>'Request Failed','33'=>'Low Balance','37'=>'Circle not found for given msisdn','38'=>'Hub name not found for the Msisdn Circle','39'=>'Product not mapped to Msisdn Circle','14'=>'Customer grace period assinged','30'=>'Deprovisioning Failed','40'=>'Invalid request : customer consent is required','27'=>'Subscriber grace period over');
		
$fileDumpfile = "billingFaildumpFile_" . date('ymd') . '.txt';
$fileDumpPath2 = $fileDumpPath . $fileDumpfile;
$get_ldr_BillingFailureData = "select billing_ID,concat('91',msisdn),event_type,status,SC,MODE,circle,operator,amount,chrg_amount,service_id,plan_id,response_time,trans_ID,aff_id,ccg_id,case event_type when 'sub' then 'Activation' when 'SUB_RETRY' then 'Activation' when 'SUB_FAIL' then 'Activation' when 'TOPUP' then 'TOP-UP' when 'Event' then 'Event' when 'resub' then 'Renewal' when 'Grace' then 'Renewal' when 'Resub_Fail' then 'Renewal' when 'Resub_Retry_Fail' then 'Renewal' when 'EVENT_RETRY' then 'Event' when 'park' then 'Renewal' when 'ALRSUB' then 'Activation' when 'sub_fail' then 'Activation' else event_type end 'TYPE',deviceUA
from master_db.tbl_billing_failure nolock where date(response_time)='" . $view_date1 . "' and service_id='3001' order by response_time desc";

$query1 = mysql_query($get_ldr_BillingFailureData, $dbConnS2) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath2);
    while (list($billing_ID,$msisdn,$event_type,$status,$SC,$MODE,$circle,$operator,$amount,$chrg_amount,$service_id,$plan_id,$response_time,$trans_ID,$affid,$CGID,$TYPE,$Device_browser) = mysql_fetch_array($query1)) {
		 $service_name = getServiceName($service_id);
		 
			if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
			$ChannelID=$MODE;
		
		if($ChannelID==0)
		$ChannelID='WAP';
		
		$trnsType=$TYPE;
		$status=$failreasonArray[$chrg_amount];
		$Result=0;
		$chrg_amount=0;
		$contentid='';	
		
      $billingData = $billing_ID . "|" . $msisdn . "|" . $circle . "|" . $ChannelID . "|" . $response_time . "|" . $CGID. "|" . $affid. "|" . $trnsType. "|" . $amount. "|" . $chrg_amount. "|" . $Result. "|" . $status. "|" . $contentid. "|" . $Device_model. "|" . $Device_Os. "|" . $Device_browser. "|" . $ContentType."|"."\r\n";
      error_log($billingData, 3, $fileDumpPath2);
        }

    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath2 . '" INTO TABLE misdata.tbl_billing_wap_3puninor_babes FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(orderid,msisdn,circle,channel_id,date,cgid,affiliate,type,amount_attempted,amount_charged,result,status,content_id,device_model,device_os,device_browser,contenttype)';
    if(mysql_query($insertDump8, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Billing Failure'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Billing Failure-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}

//Deactivation Data-
$fileDumpfile = "billingDeactdumpFile_" . date('ymd') . '.txt';
$fileDumpPath3 = $fileDumpPath . $fileDumpfile;
$get_ldr_BillingDeactData = "select concat('91',ani) 'MSISDN',if(unsub_reason is null,'IVR',unsub_reason) 'unsub_reason',MODE_OF_SUB,circle,
unsub_date,'Deactivation' as 'TYPE',contentid,affid,deviceUA
 from Hungama_wap.tbl_wap_unsub nolock where date(unsub_date)='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_BillingDeactData, $dbConnS2) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath3);
    while (list($msisdn,$unsub_reason,$MODE,$circle,$unsub_date,$TYPE,$contentid,$affid,$Device_browser) = mysql_fetch_array($query1)) {
		 if ($circle_info[strtoupper($circle)] == '')
			$circle='Others';
			else
			$circle=$circle_info[strtoupper($circle)];
			
		$ChannelID=$MODE;
		
		if($ChannelID==0)
		$ChannelID='WAP';
		
		$trnsType=$TYPE;
		$status='SUCCESS';
		$Result=1;
		$chrg_amount=0;
		$billing_ID=0;	
		$amount=0;
		$contentid='';	
		
      $billingData = $billing_ID . "|" . $msisdn . "|" . $circle . "|" . $ChannelID . "|" . $unsub_date . "|" . $CGID. "|" . $affid. "|" . $trnsType. "|" . $amount. "|" . $chrg_amount. "|" . $Result. "|" . $status. "|" . $contentid. "|" . $Device_model. "|" . $Device_Os. "|" . $Device_browser. "|" . $ContentType."|"."\r\n";
      error_log($billingData, 3, $fileDumpPath3);
        }

    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath3 . '" INTO TABLE misdata.tbl_billing_wap_3puninor_babes FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(orderid,msisdn,circle,channel_id,date,cgid,affiliate,type,amount_attempted,amount_charged,result,status,content_id,device_model,device_os,device_browser,contenttype)';
    
	if(mysql_query($insertDump9, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Deactivation data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error for Deactivation data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}

//Download section
$fileDumpfile = "billingDowndumpFile_" . date('ymd') . '.txt';
$fileDumpPath4 = $fileDumpPath . $fileDumpfile;
$get_ldr_BillingDownData = "select concat('91',msisdn) 'MSISDN','Download' as 'TYPE',contentid,contenttype,date_time from Hungama_wap.tbl_wap_download nolock where date(date_time)='" . $view_date1 . "'";

$query1 = mysql_query($get_ldr_BillingDownData, $dbConnS2) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath4);
    while (list($msisdn,$TYPE,$contentid,$contenttype,$date_time) = mysql_fetch_array($query1)) {
	
$msisdnval_count_val = strlen($msisdn);
if ($msisdnval_count_val == 12) {
    $msisdnval2 = substr($msisdn, 2);
} else {
    $msisdnval2 = $msisdn;
}

	$getdeviceInfo=mysql_query("select circle,affid,deviceUA from Hungama_wap.tbl_wap_subscription nolock  where ani='".$msisdnval2."' ",$dbConnS2);
	$isfound=mysql_num_rows($getdeviceInfo);
	if($isfound==1)
	{
	list($circle,$affid,$Device_browser) = mysql_fetch_array($getdeviceInfo); 
	}
	else
	{
	$getdeviceInfo=mysql_query("select circle,affid,deviceUA from Hungama_wap.tbl_wap_unsub nolock  where ani='".$msisdnval2."' ",$dbConnS2);
	list($circle,$affid,$Device_browser) = mysql_fetch_array($getdeviceInfo); 
	}


		 if ($circle_info[strtoupper($circle)] == '')
			$circle='Other';
			else
			$circle=$circle_info[strtoupper($circle)];
			
		$ChannelID='WAP';
		$trnsType=$TYPE;
		$status='SUCCESS';
		$Result=1;
		$chrg_amount=0;
		$billing_ID=0;	
		$amount=0;
		$contenttype = str_replace(array("\n","\r\n","\r",PHP_EOL,"\t"), '', $contenttype);
		$Device_browser = str_replace(array("\n","\r\n","\r",PHP_EOL,"\t"), '', $Device_browser);
			
      $billingData = $billing_ID . "|" . $msisdn . "|" . $circle . "|" . $ChannelID . "|" . $date_time . "|" . $CGID. "|" . $affid. "|" . $trnsType. "|" . $amount. "|" . $chrg_amount. "|" . $Result. "|" . $status. "|" . $contentid. "|" . $Device_model. "|" . $Device_Os. "|" . $Device_browser. "|" . $contenttype."|"."\r\n";
      error_log($billingData, 3, $fileDumpPath4);
        }

    $insertDump10 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath4 . '" INTO TABLE misdata.tbl_billing_wap_3puninor_babes FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(orderid,msisdn,circle,channel_id,date,cgid,affiliate,type,amount_attempted,amount_charged,result,status,content_id,device_model,device_os,device_browser,contenttype)';
    	
	if(mysql_query($insertDump10, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully for Download data'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error for Download data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
    error_log($file_process_status, 3, $processlog);
}


/*********************************end here***************************************/

$file_process_status = '***************Script end for uninorwapBabesMIS******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath1);
unlink($fileDumpPath2);
unlink($fileDumpPath3);
unlink($fileDumpPath4);

mysql_close($dbConnS2);
mysql_close($LivdbConn);
echo "generated";
?>