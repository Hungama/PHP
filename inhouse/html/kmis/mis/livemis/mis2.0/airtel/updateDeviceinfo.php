<?php
error_reporting(0);
#include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
include_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$view_date1='2014-12-03';
//echo $view_date1;
$get_ldr_BrowsingData = "select id,msisdn,device_browser from misdata.tbl_browsing_wap_ldr_airtel nolock where date(date)='" . $view_date1 . "'";
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
$updatequery = "update misdata.tbl_browsing_wap_ldr_airtel set device_model='".trim($deviceinfo[0])."',device_os='".trim($deviceinfo[1])."',device_screen='".trim($deviceinfo[3])."' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
else
{
 $updatequery = "update misdata.tbl_browsing_wap_ldr_airtel set device_model='-',device_os='-',device_screen='-' where id='".$id."'";
    mysql_query($updatequery, $LivdbConn);
}
}
}
mysql_close($LivdbConn);
echo "generated";
?>
