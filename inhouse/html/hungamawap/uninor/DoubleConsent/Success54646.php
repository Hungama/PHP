<?php
$logFile="logs/sdpResponse54646_".date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
//print_r ($_REQUEST);
$startTime=date("H:i:s");
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
}
for($k=0;$k<$arrCnt;$k++)
{
	//fwrite($filePointer,$_REQUEST[$keys[$k]]."|");
          fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");
header("location:http://202.87.41.147/hungamawap/uninor/183917/index.php3");
exit;

?>