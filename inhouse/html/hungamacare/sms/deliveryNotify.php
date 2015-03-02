<?php
$logDir="/var/www/html/hungamacare/log/txtNation/";
$logFile="txtNationDeliveryNotify_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$logStr='';

$arrCnt=sizeof($_REQUEST);
for($i=0;$i<$arrCnt;$i++)
	$keys=array_keys($_REQUEST);

for($k=0;$k<$arrCnt;$k++)
	$logStr .=$keys[$k]."->".$_REQUEST[$keys[$k]]."|";

$logStr.=date("his")."\r\n";
error_log($logStr, 3,$logPath);
echo "success";
?>

