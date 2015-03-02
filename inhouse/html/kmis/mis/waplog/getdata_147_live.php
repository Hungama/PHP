<?php
error_reporting(1);
//Get Uninor data
$curdate = date("Ymd");
$getInfo1="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgUninorWAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo1);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get Tata data
$getInfo2="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgvisitorlogsTata_live.php?date=".$curdate;
$ch_result=curl_init($getInfo2);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get Voda data
$getInfo3="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgVodaWAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo3);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get Airtel
$getInfo4="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgAirtelWAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo4);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get  Data Response Airtel 

$getInfo5="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgResponseAirtelWAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo5);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get Aircell data 
$getInfo6="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgAircellWAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo6);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);

sleep(20);
//Get Bsnl data 
$getInfo8="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgvisitorlogsBSNL_live?date=".$curdate;
$ch_result=curl_init($getInfo8);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
sleep(20);
//Get Aircellstore1 data 
$getInfo9="http://192.168.100.212/kmis/mis/waplog/live/getdata_147_ccgAircelStore1WAP_live.php?date=".$curdate;
$ch_result=curl_init($getInfo9);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
?>