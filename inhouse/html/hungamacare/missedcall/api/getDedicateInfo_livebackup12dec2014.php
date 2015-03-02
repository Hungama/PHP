<?php  
ini_set('display_error',0);
include("/var/www/html/kmis/services/hungamacare/2.0/incs/db.php");
if(!$msisdn)
$msisdn=$_REQUEST['from'];
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$msisdn=$_REQUEST['from'];
if(strlen($msisdn)==12)
$msisdn = substr($msisdn, -10);
$BpartyANI=substr($_REQUEST['text'],-10);

if (!is_numeric($BpartyANI)) 
$BpartyANI='';

$message=$_REQUEST['text'];

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
$getdataProcedure="MCDOWELL_DEDICATESONG_DETAILS";
$qry = "CALL " . $db . "." . $getdataProcedure . "($msisdn,'" . $BpartyANI . "','" . $message . "','" . $sipheader . "')";

if(mysql_query($qry, $dbConn))
$status='SUCCESS';
else
$status='ERROR-'.mysql_error();

$logData_SMS=$msisdn."#".$BpartyANI."#".$message."#".$sipheader."#".$username."#".$password."#".$status."#".$qry."#".date("Y-m-d H:i:s")."\n";
error_log($logData_SMS,3,$logpath);
mysql_close($dbConn);
echo "SUCCESS";
exit;
?>