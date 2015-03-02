<?php
error_reporting(0);
$stopdate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if($stopdate>='2014-11-03')
{
exit;
}
//log landing request for each request start here 
$logDir="/var/www/html/hungamacare/igenius/logs/dump/";
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

$msisdn =$_REQUEST['msisdn'];
$timestamp =$_REQUEST['timestamp'];//yyyy-mm-dd hh:ii:ss
$childid =$_REQUEST['childid'];
$recordtype =$_REQUEST['recordtype'];//0 fresh ,1 updated

/*
$curdate = date("Ymd");
$logPath2 = $logDir."processSuccess_".$curdate.".txt";

				$dbname="Hungama_GSK_Africa";
				$subscriptionProcedure="GSK_SUCCESSFUL_CALL_UPDATE";
						
		$con = mysql_connect("192.168.100.224","webcc","webcc");
	
		if(!$con)
		{
		$logData="#DB-Status-NotConnected#".date("Y-m-d H:i:s")."\n";
			die('could not connect1: ' . mysql_error());
		}
		else
		{
		$logData="#DB-Status-Connected#".date("Y-m-d H:i:s")."\n";
		}
		error_log($logData,3,$logPath2);
			$call="call ".$dbname.".".$subscriptionProcedure."('$ANI','$IN_DURATION','$IN_START_TIME')";
			$result =mysql_query($call,$con);
			if($result)
			{
			$logData="#query-WAP#".$call."#Success#".date("Y-m-d H:i:s")."\n";
			}
			else
			{
			$logData="#query-WAP#".$call."#Failure#".date("Y-m-d H:i:s")."\n";
			}
			error_log($logData,3,$logPath2);
			//call logs on 227
$CalllogPath="/home/Hungama_call_logs/NEW/GSK/GSK_calllog_".date("Ymd").".txt";
$CalllogData="NA#GSK_AFRICA#1#".date("Ymd")."#".date("H:i:s")."#".$IN_DURATION."#".$ANI."#".$IN_DURATION."#12345#12345#ND#0"."\n";
error_log($CalllogData,3,$CalllogPath);
			mysql_close($con);
			*/
echo 'SUCCESS';
exit;
?>