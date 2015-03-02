<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$mtsDbConn = mysql_connect('10.130.14.106', 'Archana_db','Archana@123');
$AirtelDbConn = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987');

$serviceMTS= array('MTS54646','MTSDevo','MTSFMJ','MTSMU','MTSVA');
$serviceAirtel= array('VH1Airtel');
$serviceUninor= array('REDFMUninor','RiaUninor','Uninor54646','MTVUninor','DIGIMA','UninorRT','UninorAstro');

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
	$getMsisdn="select msisdn,circle,serviceName,alert,cli from master_db.tbl_hourlyalert_msisdn where serviceName='".$summarydata[2]."' and circle!='PAN'";
	$msisdnQuery = mysql_query($getMsisdn,$dbConn);
	while($msisdnRecord1 = mysql_fetch_row($msisdnQuery))
	{	
		$message="";
		//$mailFileName=$mailFileDir.$summarydata[2]."_".$summarydata[3].".txt";
		//$mf=fopen($mailFileName,'w+');
		$cli=trim($msisdnRecord1[4]);
		if(!$cli) $cli='55935';
		if(strtolower($msisdnRecord1[2])==strtolower($summarydata[2]) && strtolower($msisdnRecord1[1])==strtolower($summarydata[3]))
		{
			$write_data="";
			$message =$DateFormat1[0] .":00:00: ".$summarydata[2].":".$summarydata[3].":";
			$message .=" Total Rev::".$summarydata[0];
			if(in_array($msisdnRecord1[2],$serviceUninor)) {			
				$proc1="CALL master_db.SENDSMS_NEW('".trim($msisdnRecord1[0])."','".$message."','".$cli."','UNIM','UNISMS',1)";
				$query123 = mysql_query($proc1,$dbConn);
			} elseif(in_array($msisdnRecord1[2],$serviceAirtel)) {			
				$proc1="CALL master_db.SENDSMS('".trim($msisdnRecord1[0])."','".$message."','601666',0,'".$cli."','revenu')";
				$query123 = mysql_query($proc1,$AirtelDbConn);
			} elseif(in_array($msisdnRecord1[2],$serviceMTS)) {			
				$proc1="CALL master_db.SENDSMS_BULK('".trim($msisdnRecord1[0])."','".$message."','".$cli."')";
				$query123 = mysql_query($proc1,$mtsDbConn);
			}
			//echo $$logfile;
			$write_data=$proc1."#".date('Y-m-d H:i:s')."\n";
			error_log($write_data,3,$logfile);
		}		
	} 
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

$logfile1 = "/var/www/html/kmis/mis/livemis/revenualert/revenu_alert_PAN_".date('Ymd').".txt";

$query12p = mysql_query($get_queryp,$LivdbConn);
while($summaryPdata = mysql_fetch_row($query12p)) 
{
	$getPanMsisdn="select msisdn,circle,serviceName,alert,cli from master_db.tbl_hourlyalert_msisdn where serviceName='".$summaryPdata[2]."' and circle='PAN'";
	$msisdnQuery1 = mysql_query($getPanMsisdn,$dbConn);
	
	while($msisdnRecordP = mysql_fetch_row($msisdnQuery1))
	{	
		$messageWrite = "";
		//$mailFileName1=$mailFileDir.$summaryPdata[2]."_".$summaryPdata[3].".txt";
		//$mf1=fopen($mailFileName1,'w+');

		$cli=trim($msisdnRecordP[4]);
		if(!$cli) $cli='55935';
		if(strtolower($msisdnRecordP[2])==strtolower($summaryPdata[2]) && strtolower($msisdnRecordP[1])==strtolower($summaryPdata[3]))
		{			
			$write_data="";
			if($summaryPdata[2] == 'UninorRT') 
			{
				$message =$DateFormat1[0] .":00:00 MyRingtone: ".$summaryPdata[3].":";
			} 
			else 
			{
				$message =$DateFormat1[0] .":00:00 ".$summaryPdata[2].": ".$summaryPdata[3].":";
			}
			$message .=" Total Rev::".$summaryPdata[0];
			$serName = $msisdnRecordP[2];
			$message .= $revenu_array[$serName];

			$messageWrite = $message."\n";

			//$proc1="CALL master_db.SENDSMS_NEW('".trim($msisdnRecordP[0])."','".$message."','".$cli."','UNIM','UNISMS',1)";
			//$query123 = mysql_query($proc1,$dbConn);

			if(in_array($msisdnRecordP[2],$serviceUninor)) {			
				$proc1="CALL master_db.SENDSMS_NEW('".trim($msisdnRecordP[0])."','".$message."','".$cli."','UNIM','UNISMS',1)";
				$query123 = mysql_query($proc1,$dbConn);
			} elseif(in_array($msisdnRecordP[2],$serviceAirtel)) {			
				$proc1="CALL master_db.SENDSMS('".trim($msisdnRecordP[0])."','".$message."','601666',0,'".$cli."','revenu')";
				$query123 = mysql_query($proc1,$AirtelDbConn);
			} elseif(in_array($msisdnRecordP[2],$serviceMTS)) {			
				$proc1="CALL master_db.SENDSMS_BULK('".trim($msisdnRecordP[0])."','".$message."','".$cli."')";
				$query123 = mysql_query($proc1,$mtsDbConn);
			}
			$write_data=$proc1."#".date('Y-m-d H:i:s')."\n";
			error_log($write_data,3,$logfile1);
		}
	}	
}

mysql_close($LivdbConn);
mysql_close($AirtelDbConn);
mysql_close($mtsDbConn);
mysql_close($dbConn);
echo "done";
?>
