<?php
error_reporting(0);
include "/var/www/html/hungamawap/config/new_functions.php";

$msisdn=trim($_REQUEST['msisdn']);
$userName = trim($_REQUEST['username']);
$DOB = trim($_REQUEST['dob']);
$IMAGE_NAME = trim($_REQUEST['imgname']);
$action = trim($_REQUEST['action']);

//log landing request for each request start here 
$logFile_dump="logs/dump/dump_".date('Ymd');
$logPathDump=$logFile_dump.".txt";
$filePointer1=fopen($logPathDump,'a+');
chmod($logPathDump,0777);
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

$getInfo="http://119.82.69.212/airtel/profileInfo.php?msisdn=".$msisdn."&username=".$userName."&dob=".$DOB;
$getInfo.="&imgname=".$IMAGE_NAME."&action=".$action;

$ch_result=curl_init($getInfo);
curl_setopt($ch_result,CURLOPT_RETURNTRANSFER,TRUE);
$result= curl_exec($ch_result);
curl_close($ch_result);
echo $result;
$logPath = "logs/saveProfile_" . date("Ymd") . ".txt";
$logData = $msisdn . "#" .$userName."#".$DOB."#".$IMAGE_NAME."#".$action."#RESPONSE-".$result."#".$Remote_add."#".date('Y-m-d H:i:s') . "\n";
error_log($logData, 3, $logPath);
?>