<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d 01:00:00')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

$getDateFormatQuery1="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery1 = mysql_query($getDateFormatQuery1,$dbConn) or die(mysql_error());
$DateFormat1 = mysql_fetch_row($dateFormatQuery1);

$logfile = "/var/www/html/kmis/mis/livemis/revenualert/revenu_alert_".date('Ymd').".txt";
$mailFileDir="/var/www/html/kmis/mis/livemis/maillog/";

$get_query="select sum(a1),'type',service,circle,date from (select sum(revenue) as a1,'activation',service,circle,date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Activation_%'  group by circle,service"; 
$get_query .=" union ";
$get_query .="select sum(revenue),'Renewal',service,circle,date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Renewal_%'  group by circle,service) a group by 'activation',circle,service order by circle,service";

$query12 = mysql_query($get_query,$LivdbConn);
while($summarydata = mysql_fetch_row($query12)) 
{
	$message="";
	
	$mailFileName=$mailFileDir.$summarydata[2]."_".$summarydata[3].".txt";
	$mf1=fopen($mailFileName,'w+');

	$message =$DateFormat1[0] .":00:00: ".$summarydata[2].":".$summarydata[3].":";
	$message .=" Total Rev::".$summarydata[0];

	fwrite($mf1,$message);
	fclose($mf1);
	//error_log($message,3,$mailFileName);
}


$get_queryp="select sum(a1),'type',service,'PAN',date from (select sum(revenue) as a1,'activation',service,date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Activation_%' group by service"; 
$get_queryp .=" union ";
$get_queryp .="select sum(revenue),'Renewal',service,date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Renewal_%'  group by service) a group by 'activation',service order by service";

$revenu_array = array();
$query = "select sum(revenue) as Total,'Act Rev' as type,service,'PAN',date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Activation_%' group by service
UNION
select sum(revenue) as Total,'Ren Rev' as type,service,'PAN',date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and type like 'Renewal_%' group by service 
UNION
select sum(value) as Total,'Act Cnt' as type,service,'PAN',date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and 
type like 'Activation_%' group by service
UNION
select sum(value) as Total,'Ren Cnt' as type,service,'PAN',date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and 
type like 'Renewal_%' group by service
UNION
select sum(value) as Total,'Pulse' as type,service,'PAN',date from misdata.livemis where date between '$DateFormat[0]' and '$DateFormat1[0]' and 
type like 'PULSE_%' group by service";
$query_revenu = mysql_query($query,$LivdbConn);

while($summaryRevenuP = mysql_fetch_array($query_revenu)) 
{
	$service_val = $summaryRevenuP['service'];
	if($service_val == 'UninorRT')
	{
		if($summaryRevenuP['type'] == 'Act Rev') 
			$type="Total Dwnlds Rev";
		elseif($summaryRevenuP['type'] == 'Act Cnt') 
			$type="Total Dwnlds Cnt";
		elseif($summaryRevenuP['type'] == 'Pulse') 
			$type="TPulse";
		$revenu_array[$service_val] .= " ".$type." ::".$summaryRevenuP['Total'];
	} 
	else 
	{
		$revenu_array[$service_val] .= " ".$summaryRevenuP['type']." ::".$summaryRevenuP['Total'];
	}
}

$query12p = mysql_query($get_queryp,$LivdbConn);
while($summaryPdata = mysql_fetch_row($query12p)) 
{
	$messageWrite = "";
	$PanMailFileName1=$mailFileDir.$summaryPdata[2]."_PAN.txt";
	$mf2=fopen($PanMailFileName1,'w+');
	if($summaryPdata[2] == 'UninorRT') 
		$message =$DateFormat1[0] .":00:00 MyRingtone: ".$summaryPdata[3].":";
	else 
		$message =$DateFormat1[0] .":00:00 ".$summaryPdata[2].": ".$summaryPdata[3].":";
	
			$message .=" Total Rev::".$summaryPdata[0];
			$serName = $summaryPdata[2];
			$message .= $revenu_array[$serName];
			$messageWrite = $message."\n";
			fwrite($mf2,$messageWrite);
			fclose($mf2);
}
mysql_close($LivdbConn);
mysql_close($dbConn);
echo "done";
?>
