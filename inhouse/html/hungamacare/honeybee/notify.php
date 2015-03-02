<?php
error_reporting(0);
//log landing request for each request start here 
$logDir="/var/www/html/hungamacare/honeybee/logs/";
$logFile_dump="logs_".date('Ymd');
$logPath=$logDir.$logFile_dump.".txt";
$curdate = date("Ymd");
$filePointer1=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer1,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer1,date('H:i:s')."\n");
//end here
$response="SUCCESS";
echo "out_string.length=1;out_string[0]='" . $response . "'";
?>