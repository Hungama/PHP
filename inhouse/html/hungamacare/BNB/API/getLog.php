<?php  
ini_set('display_error',0);
$logPath="/var/www/html/hungamacare/BNB/logs/SMS/AllRequestIVRDemo_".date('Ymd').".txt";
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
echo "SUCCESS";
?>