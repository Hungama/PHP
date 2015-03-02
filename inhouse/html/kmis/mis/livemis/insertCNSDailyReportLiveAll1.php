<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");
//$view_date1='2013-10-10';
$fileDumpPath='/var/www/html/kmis/mis/livedump/';

$kpiprocessfile = "livekpiprocess.txt";
$file_process_status = '***************Script start for insertDailyReportLiveAll1******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $kpiprocessfile);

function failureReason($reason) {
	switch($reason) {
		case '1307': $reason = "OTHERS"; //"Invalid Or Missing Mode";
			break;
		case '1304': $reason = "OTHERS"; //"Invalid Or Missing MSISDN";
			break;
		case '999': $reason = "OTHERS"; //"Failed";
			break;
		case '1316': $reason = "OTHERS"; //"Subscription plan not exists with try and buy offer";
			break;
		case '1305': $reason = "BAL"; //"Insufficient balance";
			break;
		case '201': $reason = "GRACE";
			break;
	}
	return $reason;
}

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1001':
				$service_name='TataDoCoMoMX';
			break;
			case '1003':
				$service_name='MTVTataDoCoMo';
			break;
			case '1002':
				$service_name='TataDoCoMo54646';
			break;
			case '1005':
				$service_name='TataDoCoMoFMJ';
			break;
			case '1202':
				$service_name='Reliance54646';
			break;
			case '1203':
				$service_name='MTVReliance';
			break;
			case '1208':
				$service_name='RelianceCM';
			break;
			case '1403':
				$service_name='MTVUninor';
			break;
			case '1402':
				$service_name='Uninor54646';
			break;
			case '1410':
				$service_name='REDFMUninor';
			break;
			case '1602':
				$service_name='TataIndicom54646';
			break;
			case '1601':
				$service_name='TataDoCoMoMXcdma';
			break;
			case '1603':
				$service_name='MTVTataDoCoMocdma';
			break;
			case '1605':
				$service_name='TataDoCoMoFMJcdma';
			break;
			case '1609':
				$service_name='RIATataDoCoMocdma';
			break;
			case '1009':
				$service_name='RIATataDoCoMo';
			break;
			case '1409':
				$service_name = 'RIAUninor';
			break;
			case '1801':
				$service_name = 'TataDoCoMoMXvmi';
			break;
			case '1809':
				$service_name = 'RIATataDoCoMovmi';
			break;
			case '1010':
				$service_name = 'REDFMTataDoCoMo';
			break;
			case '1412':
				$service_name = 'UninorRT';
			break;
			case '1610':
				$service_name = 'REDFMTataDoCoMocdma';
			break;
			case '1810':
				$service_name = 'REDFMTataDoCoMovmi';
			break;
			case '1416':
				$service_name = 'UninorAstro';
			break;
			case '14021':
				$service_name = 'AAUninor';
			break;
			case '1408':
				$service_name ='UninorSU';
			break;
			case '1418':
				$service_name ='UninorComedy';
			break;
			case '2121':
				$service_name ='SMSEtisalatNigeria';
			break;
			case '14101':
				$service_name ='WAPREDFMUninor';
			break;
			case '1423':
				$service_name ='UninorContest';
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

if($_GET['time']) {
	$DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2013-10-10 23:00:00';

$service_array = array('TataDoCoMoMX','MTVTataDoCoMo','TataDoCoMo54646','TataDoCoMoFMJ','Reliance54646','MTVReliance','RelianceCM','MTVUninor','Uninor54646', 'REDFMUninor','TataIndicom54646','TataDoCoMoMXcdma','MTVTataDoCoMocdma','TataDoCoMoFMJcdma','RIATataDoCoMocdma','RIATataDoCoMo','RIAUninor','TataDoCoMoMXvmi', 'Aircel54646','RIATataDoCoMovmi','REDFMTataDoCoMo','UninorRT','REDFMTataDoCoMocdma','REDFMTataDoCoMovmi','UninorAstro','AAUninor','UninorSU','UninorComedy','WAPREDFMUninor','UninorContest');


//echo $DeleteQuery="delete from misdata.livemis where date(date)='".$view_date1."' and date>'".$view_date1." 00:00:00' and service IN ('".implode("','",$service_array)."') and type like 'CNS%' ";
//$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());




//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
echo $get_firstconsent_base="select count(ANI),circle,service ,firstconsent 
from Inhouse_IVR.tbl_consent_log_unim
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1403,1402,1410,1409,1412,1416,14021,1408,1418,14101,1423)
 and firstconsent='Y' group by circle,service,firstconsent 
union
select count(ANI),circle,service ,firstconsent 
from Inhouse_IVR.tbl_consent_log_tata
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1001,1003,1002,1005,1602,1601,1603,1605,1609,1009,1010,1610)
 and firstconsent='Y' group by circle,service,firstconsent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$consent) = mysql_fetch_array($firstconsent_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_1";

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

//////////////////////////////////////////first consent logs end here //////////////////////////////////////

//////////////////////////////////////////insert second consent logs start here ////////////////////////////////
echo $get_firstconsent_base="select count(ANI),circle,service ,secondconsent 
from Inhouse_IVR.tbl_consent_log_unim
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1403,1402,1410,1409,1412,1416,14021,1408,1418,14101,1423)
 and secondconsent='Y' and ccgresult ='success' group by circle,service,secondconsent 
union
select count(ANI),circle,service ,secondconsent 
from Inhouse_IVR.tbl_consent_log_tata
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1001,1003,1002,1005,1602,1601,1603,1605,1609,1009,1010,1610)
 and secondconsent='Y' and ccgresult ='success' group by circle,service,secondconsent 
";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$service_id,$consent) = mysql_fetch_array($firstconsent_base_query))
	{
		if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_2";

		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
	}
}

//////////////////////////////////////////second consent logs end here //////////////////////////////////////
//////////////////////////////////////////insert Notification consent logs start here ////////////////////////////////
echo $get_consentnotification_base="select ANI,circle,service,date_time
from Inhouse_IVR.tbl_consent_log_unim
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in(1403,1402,1410,1409,1412,1416,14021,1408,1418,14101,1423)
 and secondconsent='Y' and ccgresult ='success' 
union
select ANI,circle,service,date_time
from Inhouse_IVR.tbl_consent_log_tata
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in(1001,1003,1002,1005,1602,1601,1603,1605,1609,1009,1010,1610)
 and secondconsent='Y' and ccgresult ='success' ";
// where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'  group by circle,service order by date_time ASC

$notificationconsent_base_query = mysql_query($get_consentnotification_base,$dbConn) or die(mysql_error());
$numRows = mysql_num_rows($notificationconsent_base_query);
echo $numRows;
if ($numRows > 0)
{
while($row = mysql_fetch_array($notificationconsent_base_query)) {
	$count=0;
	$ANI = $row['ANI'];
	$circle = $row['circle'];
	$service_id = $row['service'];
	$date_time = $row['date_time'];
	$service_name=getServiceName($service_id);
	$totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success nolock WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure nolock WHERE msisdn='".$ANI."'
	and service_id='".$service_id."' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' ";

	$statusResult = mysql_query($totalStatusQuery,$dbConn);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}
	if($circle_info[strtoupper($circle)]=='')
			$circle_info[strtoupper($circle)]='Other';
		$service_name=getServiceName($service_id);
		$consent_str1="CNS_NOTIF";
		if($status['Success']||$status['Failure'])
		{
		$count=1;
		}
		if($count)
		{
		$insert_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','".$circle_info[strtoupper($circle)]."','$consent_str1','$count',0)";
		$queryIns = mysql_query($insert_data4, $LivdbConn);
		}
	}
 }

//////////////////////////////////////////Notification consent logs end here //////////////////////////////////////
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
$file_process_status = '***************Script end for insertDailyReportLiveAll1******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $kpiprocessfile);
// end 
?>