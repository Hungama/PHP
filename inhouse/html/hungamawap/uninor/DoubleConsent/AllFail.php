<?php
include "/var/www/html/hungamawap/config/new_functions.php";
$stype=strtoupper($_REQUEST['stype']);
if(!empty($stype))
{
$getInfo="http://192.168.100.212/kmis/services/hungamacare/2.0/wap/getwapinfo.php?stype=".$stype;
$ch_result=curl_init("$getInfo");
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$ch_execute_response= curl_exec($ch_result);
curl_close($ch_result);
$details=explode("#",$ch_execute_response);
$succUrl=$details[7];
$failureUrl=urldecode($details[8]);
}
$logFile="logs/SDP/failsdpResponse".$stype.'_'.date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);

$logFile_all="logs/SDP/allSDPFailedResponse_".date('Ymd');
$logPath_all=$logFile_all.".txt";
$filePointer_all=fopen($logPath_all,'a+');
chmod($logPath_all,0777);

$arrCnt=sizeof($_REQUEST);
$startTime=date("H:i:s");
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
}
for($k=0;$k<$arrCnt;$k++)
{
fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
fwrite($filePointer_all,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");
fwrite($filePointer_all,date('H:i:s')."\n");
//header("location:http://202.87.41.147/hungamawap/uninor/183915/index.php3");
header("location:$failureUrl");
exit;
?>