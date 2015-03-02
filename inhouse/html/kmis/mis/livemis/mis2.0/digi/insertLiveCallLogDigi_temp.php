<?php
ini_set('max_execution_time', 0);
include ("dbDigiConnect.php");
// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_time1= date("h:i:s");
$processlog = "/var/www/html/kmis/mis/livemis/mis2.0/digi/livekpi_digi_calllog_temp".date('Ymd').".txt";
$file_process_status = 'Digi process file-insertLiveCallLogDigi_Temp#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

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

//$view_date1="2013-11-01";
$view_date1=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$view_date_24=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
//echo $view_date1;
$DateFormat[0]= "$view_date_24 00"; 
//exit;
////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."')
 and (type like 'CALLS_%')";
//$DeleteQuery="delete from misdata.livemis where date>date_format('".$DateFormat."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
$file_process_status = 'Query#'.$DeleteQuery.'#datetime#' . date("Y-m-d H:i:s") . "\r\n";
//error_log($file_process_status, 3, $processlog);


//$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());
///////////////////////////////////////////////////////////////start code to insert the data for call_tf////////////////////////  
$call_tf=array();
$call_tf_query="select 'CALLS_TF','Indian' as circle,count(id),'DIGI' as service_name,date(call_date)
 from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time >=time('23:00:00') and dnis like '131224%' group by circle
union
select 'CALLS_TF','Bangla' as circle,count(id),'DIGI' as service_name,date(call_date) 
from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time >=time('23:00:00') and dnis like '131221%' group by circle
union
select 'CALLS_TF','Nepali' as circle,count(id),'DIGI' as service_name,date(call_date) 
from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and call_time >=time('23:00:00') and dnis like '131222%' group by circle
";
//echo $call_tf_query;
//exit;
$file_process_status = 'CallS_TF-Query#'.$call_tf_query.'#datetime#' . date("Y-m-d H:i:s") . "\r\n";
//error_log($file_process_status, 3, $processlog);

$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$insert_call_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
		values('$DateFormat[0]','DIGIMA','".strtoupper($call_tf[1])."' ,'$call_tf[0]','$call_tf[2]',0)";
		echo $insert_call_tf_data."<br>";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////////start code to insert the data for calls_tf ////////////////////////////
$file_process_status = 'Digi process file-insertLiveCallLogDigi_Temp End here#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
echo "Done for today.";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>