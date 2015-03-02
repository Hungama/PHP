<?php
$logDir="/var/www/html/docomo/logs/docomo/dc/obd/";
$logFile="sdpResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
//print_r ($_REQUEST);
$str='';
$test=$_REQUEST['test'];
$startTime=date("H:i:s");
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
	$str.=$_REQUEST[$keys[$k]]."|";
}
fwrite($filePointer,date('H:i:s')."\n");
$data=explode("|",$str);
echo $servletResult="SUCCESS";
exit;
?>
