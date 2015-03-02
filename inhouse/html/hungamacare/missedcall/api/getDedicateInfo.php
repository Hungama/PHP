<?php  
ini_set('display_error',0);
#include("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");

$msisdn=$_REQUEST['from'];//A party
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

$message=trim($_REQUEST['text']);  //Whole text msg by party A


if(strlen($msisdn)==12)
$msisdn = substr($msisdn, -10);


$BpartyANI=substr($message,-10); //Get B party ANI

if (!is_numeric($BpartyANI)) 
$BpartyANI='';

$isFail=false;

if(strlen($BpartyANI)!=10)
{
$isFail=true;
}

$sipheader='sms';
$baselogpath="/var/www/html/hungamacare/missedcall/api/logs/dedicateSongLogs/";
$logFile_dump="dump_".date('Ymd');
$logPathDedicate=$baselogpath.$logFile_dump.".txt";
$filePointer1=fopen($logPathDedicate,'a+');
chmod($logPathDedicate,0777);
$arrCnt=sizeof($_REQUEST);
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer1,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer1,date('H:i:s')."\n");

$logpath=$baselogpath."getdedicatedAPIlog_".date('Ymd').".txt";
$db="Hungama_ENT_MCDOWELL";

if($isFail)
$getdataProcedure="MCDOWELL_DEDICATESONG_DETAILS_Fail";
else
$getdataProcedure="MCDOWELL_DEDICATESONG_DETAILS";

$qry = "CALL " . $db . "." . $getdataProcedure . "($msisdn,'" . $BpartyANI . "','" . $message . "','" . $sipheader . "')";

/*
if(mysql_query($qry, $dbConn))
$status='SUCCESS';
else
$status='ERROR-'.mysql_error();
*/
$status='STOPPED';//Date 23 Feb2015
$logData_SMS=$msisdn."#".$BpartyANI."#".$message."#".$sipheader."#".$username."#".$password."#".$status."#".$qry."#".date("Y-m-d H:i:s")."\n";
error_log($logData_SMS,3,$logpath);
mysql_close($dbConn);
echo "SUCCESS";
exit;
?>