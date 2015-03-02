<?php
error_reporting(0);
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/db_218.php");

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$view_date1='2014-11-20';
echo $view_date1;
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/livedump/wap/processlogUpdateDeviceInfo_".date(Ymd).".txt";
$file_process_status = '*************Script start for subscription base*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//update subscriptionbase
$get_ldr_SubData = "select id,device_browser from misdata.tbl_base_active_wap nolock where service IN ('WAPUninorContest','WAPUninorLDR') and date='" . $view_date1 . "'";
$query1 = mysql_query($get_ldr_SubData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
while (list($id,$useragent) = mysql_fetch_array($query1)) {
$useragent=trim($useragent);
if($useragent)
{	 
$useragent=urlencode($useragent);
$getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
$getInfoUrl.="?ua=$useragent";
$result=curl_init($getInfoUrl);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$res= curl_exec($result);
curl_close($result);
$deviceinfo=explode("@@",$res);
//devicemodel@@deviceos@@devicebrowser@@devicescreen
 $updatequery = "update misdata.tbl_base_active_wap set device_model='".trim($deviceinfo[0])."' where id='".$id."'";
 mysql_query($updatequery, $LivdbConn);
}
else
{
 $updatequery = "update misdata.tbl_base_active_wap set device_model='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
 
 }
}

$file_process_status = '*************Script end for subscription base*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

sleep (20);
$file_process_status = '*************Script start for Browsing Data*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//update browsing table for ldr uninor
$get_ldr_BrowsingData = "select id,msisdn,device_browser from misdata.tbl_browsing_wap_ldr_uninor nolock where date(date)='" . $view_date1 . "'";
$query1 = mysql_query($get_ldr_BrowsingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
     while (list($id,$msisdn,$useragent) = mysql_fetch_array($query1)) {

$useragent=trim($useragent);
if($useragent)
{
$useragent=urlencode($useragent);
$getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
$getInfoUrl.="?ua=$useragent";
$result=curl_init($getInfoUrl);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$res= curl_exec($result);
curl_close($result);
$deviceinfo=explode("@@",$res);
//print_r($deviceinfo);
//devicemodel@@deviceos@@devicebrowser@@devicescreen
 $updatequery = "update misdata.tbl_browsing_wap_ldr_uninor set device_model='".trim($deviceinfo[0])."',device_os='".trim($deviceinfo[1])."',device_screen='".trim($deviceinfo[3])."' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
else
{
 $updatequery = "update misdata.tbl_browsing_wap_ldr_uninor set device_model='-',device_os='-',device_screen='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
}
}


//update browsing table for contest uninor
$get_contest_BrowsingData = "select id,msisdn,device_browser from misdata.tbl_browsing_wap_contest_uninor nolock where date(date)='" . $view_date1 . "'";
$query1 = mysql_query($get_contest_BrowsingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
     while (list($id,$msisdn,$useragent) = mysql_fetch_array($query1)) {

$useragent=trim($useragent);
if($useragent)
{
$useragent=urlencode($useragent);
$getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
$getInfoUrl.="?ua=$useragent";
$result=curl_init($getInfoUrl);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$res= curl_exec($result);
curl_close($result);
$deviceinfo=explode("@@",$res);
//print_r($deviceinfo);
//devicemodel@@deviceos@@devicebrowser@@devicescreen
 $updatequery = "update misdata.tbl_browsing_wap_contest_uninor set device_model='".trim($deviceinfo[0])."',device_os='".trim($deviceinfo[1])."',device_screen='".trim($deviceinfo[3])."' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
else
{
  $updatequery = "update misdata.tbl_browsing_wap_contest_uninor set device_model='-',device_os='-',device_screen='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
}
}

$file_process_status = '*************Script end for browsing data*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

$file_process_status = '*************Script start for Billing data*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
sleep (20);

//update billing data ldr uninor
$get_ldr_BillingData = "select id,device_browser from misdata.tbl_billing_wap_ldr_uninor nolock where date(date)='" . $view_date1 . "'";
$query1 = mysql_query($get_ldr_BillingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
     while (list($id,$useragent) = mysql_fetch_array($query1)) {

$useragent=trim($useragent);
if($useragent)
{
$useragent=urlencode($useragent);
$getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
$getInfoUrl.="?ua=$useragent";
$result=curl_init($getInfoUrl);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$res= curl_exec($result);
curl_close($result);
$deviceinfo=explode("@@",$res);
//print_r($deviceinfo);
//devicemodel@@deviceos@@devicebrowser@@devicescreen
 $updatequery = "update misdata.tbl_billing_wap_ldr_uninor set device_model='".trim($deviceinfo[0])."',device_os='".trim($deviceinfo[1])."' where id='".$id."'";
 mysql_query($updatequery, $LivdbConn);
 }
else
{
 $updatequery = "update misdata.tbl_billing_wap_ldr_uninor set device_model='-',device_os='-',device_screen='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
}
}


//update billing data contest uninor
$get_ldr_BillingData = "select id,device_browser from misdata.tbl_billing_wap_contest_uninor nolock where date(date)='" . $view_date1 . "'";
$query1 = mysql_query($get_ldr_BillingData, $LivdbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
     while (list($id,$useragent) = mysql_fetch_array($query1)) {

$useragent=trim($useragent);
if($useragent)
{
$useragent=urlencode($useragent);
$getInfoUrl="http://192.168.100.212/kmis/mis/waplog/core-device/detect-device/detect-process/getdeviceinfo.php";
$getInfoUrl.="?ua=$useragent";
$result=curl_init($getInfoUrl);
curl_setopt($result,CURLOPT_RETURNTRANSFER,TRUE);
$res= curl_exec($result);
curl_close($result);
$deviceinfo=explode("@@",$res);
//print_r($deviceinfo);
//devicemodel@@deviceos@@devicebrowser@@devicescreen
 $updatequery = "update misdata.tbl_billing_wap_contest_uninor set device_model='".trim($deviceinfo[0])."',device_os='".trim($deviceinfo[1])."' where id='".$id."'";
 mysql_query($updatequery, $LivdbConn);
 }
else
{
 $updatequery = "update misdata.tbl_billing_wap_contest_uninor set device_model='-',device_os='-',device_screen='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
}
}

$file_process_status = '*************Script end for Billing data*********' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
mysql_close($dbConn212);
mysql_close($LivdbConn);
echo "generated";
?>