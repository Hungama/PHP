<?php
$logFile="logs/sdpResponse_".date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
//print_r ($_REQUEST);
$startTime=date("H:i:s");
$CPTID = $_REQUEST['CPTID'];
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
switch($CPTID){
    case 'HUI0000007' :
        //header( '../181336/thanks.php3' ) ;
        header('Location: http://202.87.41.147/hungamawap/uninor/181336/thanks.php3');
        break;
}
echo $servletResult="SUCCESS";
exit;
?>