<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");

function getServiceName($service_id)
{
	switch($service_id)
	{
		case '1101':
			$service_name='MTSMU';
		break;
		case '1102':
			$service_name='MTS54646';
		break;
                case '1123':
			$service_name='MTSContest';
		break;
                case '1125':
			$service_name='MTSJokes';
		break;
                case '1126':
			$service_name='MTS Regional';
		break;
		case '1103':
			$service_name='MTVMTS';
		break;
		case '1111':
			$service_name = 'MTSDevo';
		break;
		case '1106':
			$service_name = 'MTSFMJ';
		break;
		case '1110':
			$service_name = 'RedFMMTS';
		break;
		case '1116':
			$service_name = 'MTSVA';
		break;
		case '11012':
			$service_name = 'MTSComedy';
		break;
		case '1113':
			$service_name = 'MTSMND';
		break;
	}
	return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$service_array = array('MTSMU','MTS54646','MTSContest','MTSJokes','MTS Regional','MTVMTS','MTSDevo','MTSFMJ','RedFMMTS','MTSVA','MTSComedy','MTSMND');

$getCurrentTimeQuery="select now()";

$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

if($_GET['time']) {
	echo $DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2013-02-26 13:00:00';
//exit;

echo $DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')  and (type like 'CNS%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
echo $get_firstconsent_base="select count(ANI),circle,service ,firstconsent 
from MTS_IVR.tbl_consent_log_mts
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1101,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and firstconsent='Y' group by circle,service,firstconsent order by firstconsent";

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
from MTS_IVR.tbl_consent_log_mts
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1101,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and secondconsent='Y' and error_desc ='Request Success' group by circle,service,secondconsent order by secondconsent";

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
from MTS_IVR.tbl_consent_log_mts
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in(1101,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and secondconsent='Y' and error_desc ='Request Success' order by date_time ASC";
// where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'  group by circle,service order by date_time ASC
$notificationconsent_base_query = mysql_query($get_consentnotification_base,$dbConn) or die(mysql_error());
$numRows = mysql_num_rows($notificationconsent_base_query);
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
 
echo "generated";
mysql_close($dbConn);
// end 

?>
