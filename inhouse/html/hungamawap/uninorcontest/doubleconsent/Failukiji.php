<?php
session_start();
$old_sessionid = session_id();
include "/var/www/html/hungamawap/config/new_functions.php";
$logFile="logs/failsdpResponseKiji_".date('Ymd');
$logPath=$logFile.".txt";
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$startTime=date("H:i:s");
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
}
for($k=0;$k<$arrCnt;$k++)
{
	 fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");
$REQ_TYPE=$_REQUEST['REQ_TYPE'];
$CPTID=$_REQUEST['CPTID'];
$CGID=$_REQUEST['CGID'];
$MSISDN1=$_REQUEST['MSISDN'];
$RESULT=$_REQUEST['RESULT'];
$REASON=$_REQUEST['REASON'];
$CODE=$_REQUEST['CODE'];
$afid=$_REQUEST['afid'];
$circle=$_REQUEST['circle'];
$refererName=$_SERVER['HTTP_REFERER'];
$logdate = date("Ymd");
$stype='UKIJI';

$logPath_MIS218_Uninor="/var/www/html/hungamawap/uninorcontest/logs/wap/logs_".$logdate.".txt";

//save data for live MIS purpose start here
$saveLiveMisWAPLogs = "http://192.168.100.212/kmis/services/hungamacare/2.0/wap/saveLiveWAPlogs.php?zone_id=".$zoneid."&msisdn=".$msisdn."&msg=".urlencode($RESULT)."&afid=".$afid."&circle=".$circle."&service=WAPUninorContest&type=ccgresponse";
$savelogsresponse=file_get_contents($saveLiveMisWAPLogs);
//save data for live MIS purpose end here

$logPath_MIS="/var/www/html/hungamawap/uninorcontest/doubleconsent/logs/CCG/UninorKIJIAfterCCGVisitorMIS_".$logdate.".txt";
$logString_MIS = $stype."|".$REQ_TYPE."|".$MSISDN1."|".$CPTID."|".$CGID."|".$RESULT."|".$CODE."|".$Remote_add."|".$full_user_agent."|".$posturl."|WAP|117.239.178.108|" .$refererName."|".$afid."|".$circle."|".date('Y-m-d H:i:s')."|"."\r\n";
 error_log($logString_MIS, 3, $logPath_MIS);
 
 $msg='CGFAIL';  
 $redirectUrl='http://117.239.178.108/hungamawap/uninorcontest/html/failure.php';
  $logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($RESULT) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$content_id."|".date('Y-m-d H:i:s')."|CGCOMPLETE|".$REQ_TYPE."|"."\r\n";
		error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);			 
		session_destroy();		
header("location:$redirectUrl");

?>