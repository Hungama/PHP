<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$last_week_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 8, date("Y")));
//$view_date1='2015-02-18';
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/aircelwapstore/livedump/wap/';
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/aircelwapstore/livedump/processlogBilling_".date(Ymd).".txt";
// Delete last week data
echo "Delete last week data";

$Delete_last_Query = "delete from Hungama_WAP_Logging.tbl_billing_wap_store_aircel where date(date)='" . $last_week_date . "'";
$deleteResult = mysql_query($Delete_last_Query, $dbConn) or die(mysql_error());

echo "Delete today data";
// Delete previous data
$DeleteQuery = "delete from Hungama_WAP_Logging.tbl_billing_wap_store_aircel where date(date)='" . $view_date1 . "'";
$deleteResult12 = mysql_query($DeleteQuery, $dbConn) or die(mysql_error());
$file_process_status = '*******Script start for Aircel Wap Store Billing **********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

echo "fetch data";
//$successTable = "master_db.tbl_billing_success";
//Success Data
$fileDumpfile = "AircelWapStorebillingSuccessdumpFile_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;
$get_ldr_BillingData = "select msisdn,circle,channel_id,date,type,amount_attempted,amount_charged from misdata.tbl_billing_wap_store_aircel nolock where date(date)='" . $view_date1 . "' order by date desc";

$query1 = mysql_query($get_ldr_BillingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($msisdn,$circle,$ChannelID,$date,$type,$chrg_attempted,$chrg_amount) = mysql_fetch_array($query1)) {
	  $added_on=date("Y-m-d H:i:s");
	  
      $billingData =  $msisdn . "|" . $circle . "|" . $ChannelID . "|" . $date . "|" . $type. "|" . $chrg_attempted. "|" . $chrg_amount."|" . $added_on."|"."\r\n";
      error_log($billingData, 3, $fileDumpPath1);
        }

    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE Hungama_WAP_Logging.tbl_billing_wap_store_aircel FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(msisdn,circle,channel_id,date,type,amount_attempted,amount_charged,added_on)';
    //mysql_query($insertDump7, $LivdbConn);
	
	if(mysql_query($insertDump7, $dbConn))
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

$file_process_status = '*******Script end for aircelwapstore billing*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
unlink($fileDumpPath1);

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";

?>
