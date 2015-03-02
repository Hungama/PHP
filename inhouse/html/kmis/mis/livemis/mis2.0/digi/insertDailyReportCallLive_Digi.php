<?php
ini_set('max_execution_time', 0);
include ("dbDigiConnect.php");
// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/digi/livedump/';
//$view_date1="2013-01-15";
$processlog = "/var/www/html/digi/livekpi_digi_calllog_".date('Ymd').".txt";
$file_process_status = 'Digi process file-insertLiveCallLogDigi#datetime#' . date("Y-m-d H:i:s") . "\r\n";
//error_log($file_process_status, 3, $processlog);
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/digi/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/digi/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Digi******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

function getCircle($shortCode)
{
	if(strpos($shortCode,'131221'))
		$circle='Bangla';
	elseif(strpos($shortCode,'131222'))
		$circle='Nepali';
	elseif(strpos($shortCode,'131224'))
		$circle='Indian';
	return $circle;
}

$service_array = array('DIGIMA');

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
$gethour=explode(" ",$DateFormat[0]);
//echo $DateFormat[0]= '2013-11-27 09'; 
if($gethour[1]=='00')
{
//$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$datecondition="call_time >=time('$DateFormat[0]' - INTERVAL 60 MINUTE)";
}
else
{
$datecondition="call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]')";
}

//$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
if($gethour[1]!='00')
{
$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
//$DeleteQuery="delete from misdata.livemis where date>date_format('".$DateFormat."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());
$file_process_status = 'Query#'.$DeleteQuery.'#datetime#' . date("Y-m-d H:i:s") . "\r\n";
//error_log($file_process_status, 3, $processlog);
}
else
{
echo $file_process_status = '24th hourQuery#'.$DateFormat[0].'#datetime#' . date("Y-m-d H:i:s") . "\r\n";
//error_log($file_process_status, 3, $processlog);
}
///////////////////////////////////////////////////////////////start code to insert the data for call_tf////////////////////////  
$call_tf=array();
$call_tf_query="select 'CALLS_TF','Indian' as circle,count(id),'DIGI' as service_name,date(call_date) 
from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and $datecondition and dnis like '131224%' group by circle
union
select 'CALLS_TF','Bangla' as circle,count(id),'DIGI' as service_name,date(call_date) from mis_db.tbl_digi_calllog where 
date(call_date)='$view_date1' and $datecondition and dnis like '131221%' group by circle
union
select 'CALLS_TF','Nepali' as circle,count(id),'DIGI' as service_name,date(call_date) from mis_db.tbl_digi_calllog where 
date(call_date)='$view_date1' and $datecondition and dnis like '131222%' group by circle
";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','DIGIMA','".strtoupper($call_tf[1])."' ,'$call_tf[0]','$call_tf[2]',0)";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////////End code to insert the data for call_tf  ///////////////////////////////////////
echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
$kpi_process_status = '***************Script end for insertDailyReportCallLive_Digi******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>