<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
error_reporting(0);
$type=strtolower($_REQUEST['last']);
//$type='y';
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
//$view_date1='2014-07-20';
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/inhouse/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Uninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('MTVUninor', 'Uninor54646', 'REDFMUninor', 'RIAUninor','Aircel54646', 'UninorRT','UninorAstro', 'AAUninor', 'UninorSU', 'UninorComedy', 'WAPREDFMUninor', 'UninorContest', 'UninorVABollyAlerts', 'UninorVAFilmy', 'UninorVABollyMasala', 'UninorVAHealth', 'UninorVAFashion');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "') 
                    and (type like 'CALLS_%')";
} else {
   $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') 
                        and (type like 'CALLS_%')";
}
echo $DeleteQuery;

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());




$DumpfileCallsTF= "callsFUninor_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;

$call_tf = array();

$call_tf_query = "select 'CALLS_TF',circle, count(id),'1402' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461') and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1413' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628', '5464626') and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1410' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1430' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1'  and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1431' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1432' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1433' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1434' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1403' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=546461 and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1412' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis=52888 and operator in ('unim') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1416' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in ('unim') group by circle
UNION
select 'CALLS_TF',circle, count(id),'14021' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1408' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1418' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis like '5464622' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1423' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle,hour(call_time)";
//echo $call_tf_query;
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
unlink($DumpfileCallsTFPath);
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($circle_info[strtoupper($call_tf[1])] == '')
            $circle_info[strtoupper($call_tf[1])] = 'Other';
        $service_name = getServiceName($call_tf[3]);

		$circle=$call_tf[1];
		$DateFormat1=$call_tf[6];
		$calltype=$call_tf[0];
		$totalCount=$call_tf[2];
		 $callsTFData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $calltype . "|" . $totalCount . "|" . '0' . "\r\n";
        error_log($callsTFData, 3, $DumpfileCallsTFPath);
		
        //$insert_call_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf[6]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_tf[1])] . "','$call_tf[0]','$call_tf[2]',0)";
        //$queryIns_call = mysql_query($insert_call_tf_data1, $LivdbConn);
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

///////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$DumpfileCallsT= "callsTUninor_" . date('ymd') . '.txt';
$DumpfileCallsTPath = $fileDumpPath . $DumpfileCallsT;

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%') and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_6',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546466%' and dnis!='5464669' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_9',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546467%' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_1',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546468%' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1413' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1902' as service_name,date(call_date),dnis,hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis like '54646%' and operator in('airc') group by circle,dnis,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
unlink($DumpfileCallsTPath);
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_T';
        if (($call_t[5] == '5464669' || $call_t[5] == '5464666') && $call_t[3] == 1202)
            $call_type = "CALLS_T_6";
        if (($call_tf[5] == '544334' || $call_tf[5] == '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T_6";
        elseif ($call_tf[5] == '544337' && $call_t[3] == 1208)
            $call_type = "CALLS_T_9";
        elseif (($call_tf[5] != '544334' && $call_tf[5] != '544337' && $call_tf[5] != '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T";

        $service_name = getServiceName($call_t[3]);

		$circle=$call_t[1];
		$DateFormat1=$call_t[7];
		$calltype=$call_type;
		$totalCount=$call_t[2];
		 $callsTData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $calltype . "|" . $totalCount . "|" . '0' . "\r\n";
        error_log($callsTData, 3, $DumpfileCallsTPath);

        //$insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_t[7]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        //$queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
	
	 $insertDump22 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump22, $LivdbConn) or die(mysql_error());
	
}
unlink($DumpfileCallsTFPath);
unlink($DumpfileCallsTPath);

// sleep for 10 seconds
sleep(10);
//////////////////////////////End code to insert the data for call_t for LIve 
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
/*
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type like 'CALLS%')";
*/

$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."')";
echo "<br>";

if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}



echo "Current hour is".$date_Currentthour;
//$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%')";
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
if($date_Currentthour!='23')
{
if($type!='y')
{
echo $DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
$kpi_process_status = '*******Script end for insertDailyReportCallLive_Uninor**************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>