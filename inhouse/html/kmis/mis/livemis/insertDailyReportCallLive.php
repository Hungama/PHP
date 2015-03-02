<?php
exit;
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
error_reporting(0);
$type=strtolower($_REQUEST['last']);
//echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
//if (date('H') == 01 || $type=='y')
if ($type=='y')
    echo $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
else
    echo $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$deleted_file = "/var/www/html/kmis/mis/livemis/livekpi_uninor" . date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"))) . ".txt";
unlink($deleted_file);

$view_time1 = date("h:i:s");



$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);


$processlog = "/var/www/html/kmis/mis/livemis/livekpi_uninor" . date('Ymd') . ".txt";
$file_process_status = 'insertDailyReportCallLive process file- Start#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

function getServiceName($service_id) {
    switch ($service_id) {
        case '1001':
            $service_name = 'TataDocomoMX';
            break;
        case '1003':
            $service_name = 'MTVTataDoCoMo';
            break;
        case '1002':
            $service_name = 'TataDoCoMo54646';
            break;
        case '1005':
            $service_name = 'TataDoCoMoFMJ';
            break;
        case '1202':
            $service_name = 'Reliance54646';
            break;
        case '1203':
            $service_name = 'MTVReliance';
            break;
        case '1208':
            $service_name = 'RelianceCM';
            break;
        case '1201':
            $service_name = 'RelianceMM';
            break;
        case '1403':
            $service_name = 'MTVUninor';
            break;
        case '1402':
            $service_name = 'Uninor54646';
            break;
        case '1410':
            $service_name = 'RedFMUninor';
            break;
        case '1430':
            $service_name = 'UninorVABollyAlerts';
            break;
        case '1431':
            $service_name = 'UninorVAFilmy';
            break;
        case '1432':
            $service_name = 'UninorVABollyMasala';
            break;
        case '1433':
            $service_name = 'UninorVAHealth';
            break;
        case '1434':
            $service_name = 'UninorVAFashion';
            break;
        case '1602':
            $service_name = 'TataIndicom54646';
            break;
        case '1601':
            $service_name = 'TataDoCoMoMXcdma';
            break;
        case '1603':
            $service_name = 'MTVTataIndicom';
            break;
        case '1605':
            $service_name = 'TataDoCoMoFMJcdma';
            break;
        case '1609':
            $service_name = 'RIATataDoCoMocdma';
            break;
        case '1009':
            $service_name = 'RIATataDoCoMo';
            break;
        case '1409':
            $service_name = 'RiaUninor';
            break;
        case '1801':
            $service_name = 'TataDocomoMXVMI';
            break;
        case '1902':
            $service_name = 'Aircel54646';
            break;
        case '1809':
            $service_name = 'RIATataDoCoMovmi';
            break;
        case '1010':
            $service_name = 'RedFMTataDoCoMo';
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
            $service_name = 'UninorSU';
            break;
        case '1418':
            $service_name = 'UninorComedy';
            break;
        case '1423':
            $service_name = 'UninorContest';
            break;
        case '1013':
            $service_name = 'TataDoCoMoMND';
            break;
        case '1613':
            $service_name = 'TataDoCoMoMNDcdma';
            break;
        case '1813':
            $service_name = 'TataDoCoMoMNDvmi';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');

$getCurrentTimeQuery = "select now()";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery = "select date_format('" . $currentTime[0] . "','%Y-%m-%d %H:00:00')";

$dateFormatQuery = mysql_query($getDateFormatQuery, $dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $view_date1='2014-07-16';
//echo $DateFormat[0] = '2014-07-16 23:00:00';
if ($_GET['time']) {
    echo $DateFormat[0] = $_GET['time'];
}
if ($type=='y')
{
	$DateFormat[0] = $view_date1." 23:00:00";
}
//echo $DateFormat[0];
$service_array = array('TataDocomoMX', 'MTVTataDoCoMo', 'TataDoCoMo54646', 'TataDoCoMoFMJ', 'TataDoCoMoMND', 'Reliance54646', 'MTVReliance', 'RelianceCM', 'RelianceMM', 'MTVUninor', 'Uninor54646', 'RedFMUninor', 'TataIndicom54646', 'TataDoCoMoMXcdma', 'TataDoCoMoMNDcdma', 'MTVTataIndicom', 'TataDoCoMoFMJcdma', 'RIATataDoCoMocdma', 'RIATataDoCoMo', 'RiaUninor', 'TataDocomoMXVMI', 'Aircel54646', 'RIATataDoCoMovmi', 'TataDoCoMoMNDvmi', 'RedFMTataDoCoMo', 'UninorRT', 'REDFMTataDoCoMocdma', 'REDFMTataDoCoMovmi', 'UninorAstro', 'AAUninor', 'UninorSU', 'UninorComedy', 'UninorContest', 'UninorVABollyAlerts', 'UninorVAFilmy', 'UninorVABollyMasala', 'UninorVAHealth', 'UninorVAFashion');

/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

/* $DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'MOU_%' OR type like 'SEC_%' OR type like 'UU_%')";
 */
$DeleteQuery = "delete from misdata.livemis where date>date_format('" . $view_date1 . "','%Y-%m-%d 00:00:00') and service IN('" . implode("','", $service_array) . "') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'MOU_%' OR type like 'SEC_%' OR type like 'UU_%')";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

//////////////////////////////start code to insert the data for call_tf for Tata Docomo Endless////////////////////////////////////////////////
$call_tf = array();

$call_tf_query = "select 'CALLS_TF',circle, count(id),'1001' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog 
where date(call_date)='$view_date1'
and dnis like '59090%' and operator in ('TATM') group by circle ,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1002' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1009' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1003' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1005' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1010' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1013' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator ='tatm' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1601' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATC','tatc') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1602' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in ('546461','5464626') and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1609' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=5464626 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1603' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1605' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis=56666 and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1608' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in(54433) and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1613' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1202' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1203' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('relc','relm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1201' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and dnis like '543219%' and operator in('relc','relm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1402' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461') and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1409' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628', '5464626') and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1410' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1430' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1'  and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1431' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1432' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1433' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1434' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1403' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from  mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=546461 and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1801' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1809' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464626%' and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1810' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1813' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in ('virm') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1610' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1'  and dnis=55935 and operator in ('tatc') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1412' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis=52888 and operator in ('unim') group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1416' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in ('unim') group by circle
UNION
select 'CALLS_TF',circle, count(id),'14021' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1408' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1418' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis like '5464622' and operator ='unim' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1423' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle,hour(call_time)";
//echo $call_tf_query;
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $i = 0;
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $i++;
        if ($circle_info[strtoupper($call_tf[1])] == '')
            $circle_info[strtoupper($call_tf[1])] = 'Other';
        $service_name = getServiceName($call_tf[3]);

        $insert_call_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf[6]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_tf[1])] . "','$call_tf[0]','$call_tf[2]',0)";
        if ($i <= 2) {
            //echo $insert_call_tf_data1;
        }
        $queryIns_call = mysql_query($insert_call_tf_data1, $LivdbConn);
    }
}

///////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_T',circle, count(id),'1002' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1009' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1602' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1609' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1608' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis=54433 and operator in('TATC') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1208' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1202' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%') and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_6',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546466%' and dnis!='5464669' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_9',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546467%' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T_1',circle, count(id),'1402' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  dnis like '546468%' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1409' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle,dnis,hour(call_time)
UNION
select 'CALLS_T',circle, count(id),'1902' as service_name,date(call_date),dnis,hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis like '54646%' and operator in('airc') group by circle,dnis,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_T';
        if ($call_t[5] == 5464669 && $call_t[3] == 1009)
            $call_type = 'CALLS_T';
        elseif ($call_t[3] == 1009)
            $call_type = 'CALLS_T_1';
        if ($call_t[5] == 5464669 && $call_t[3] == 1609)
            $call_type = 'CALLS_T';
        elseif ($call_t[3] == 1609)
            $call_type = 'CALLS_T_1';
        if (($call_t[5] == '5464669' || $call_t[5] == '5464666') && $call_t[3] == 1202)
            $call_type = "CALLS_T_6";
        elseif ($call_t[3] == 1202)
            $call_type = 'CALLS_T';
        if (($call_tf[5] == '544334' || $call_tf[5] == '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T_6";
        elseif ($call_tf[5] == '544337' && $call_t[3] == 1208)
            $call_type = "CALLS_T_9";
        elseif (($call_tf[5] != '544334' && $call_tf[5] != '544337' && $call_tf[5] != '5443344') && $call_t[3] == 1208)
            $call_type = "CALLS_T";

        $service_name = getServiceName($call_t[3]);
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_t[7]',interval 1 hour),'$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for PULSE_tf for Tata Docomo Endless////////////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle,'1001' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '59090%' and operator in('TATM') group by circle 
UNION
select 'PULSE_TF',circle,'1002' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and operator ='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1009' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=5464626 and operator ='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1005' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_starclub_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis in ('56666') and operator='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1003' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=546461 and operator ='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1010' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=55935 and operator ='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1013' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis = '55001' or dnis='550011') and operator ='tatm' group by circle
UNION
select 'PULSE_TF',circle,'1202' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') group by circle
UNION
select 'PULSE_TF',circle,'1203' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=546461 and operator in('relm','relc') group by circle
UNION
select 'PULSE_TF',circle,'1201' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_musicmania_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '543219%' and operator in('relm','relc') group by circle
UNION
select 'PULSE_TF',circle,'1402' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second)  and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1409' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second)  and dnis IN ('5464628','5464626') and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1410' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second)  and dnis=55935 and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1430' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_bollyalerts_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1431' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_FilmiWords_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1432' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_BollywoodMasala_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1433' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_FilmiHeath_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1434' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_CelebrityFashion_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second)  and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1403' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second)  and dnis=546461 and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1801' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '59090%' and operator in('virm') group by circle
UNION
select 'PULSE_TF',circle,'1809' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '5464626%' and operator in('virm') group by circle
UNION
select 'PULSE_TF',circle,'1813' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis = '55001' or dnis='550011') and operator in('virm') group by circle
UNION
select 'PULSE_TF',circle,'1601' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '59090%' and operator in('TATC','tatc') group by circle
UNION
select 'PULSE_TF',circle,'1602' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle
UNION
select 'PULSE_TF',circle,'1609' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=5464626 and operator in('TATC') group by circle
UNION
select 'PULSE_TF',circle,'1608' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=54433 and operator in('TATC') group by circle
UNION
select 'PULSE_TF',circle,'1603' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=546461 and operator in('TATC') group by circle
UNION 
select 'PULSE_TF',circle,'1605' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_starclub_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=56666 and operator in('TATC') group by circle
UNION 
select 'PULSE_TF',circle,'1613' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle
UNION 
select 'PULSE_TF',circle,'1810' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=55935 and operator in('virm') group by circle
UNION 
select 'PULSE_TF',circle,'1610' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=55935 and operator in('TATC') group by circle
UNION 
select 'PULSE_TF',circle,'1412' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rt_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis=52888 and operator in('unim') group by circle
UNION 
select 'PULSE_TF',circle,'1416' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '5464627%' and operator in('unim') group by circle
UNION
select 'PULSE_TF',circle,'14021' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where  date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis='5464611' and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1408' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '52444%' and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1418' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_azan_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '5464622' and operator ='unim' group by circle
UNION
select 'PULSE_TF',circle,'1423' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]' - INTERVAL 1 second) and dnis like '52000%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($pulse_tf_result);
if ($numRows1 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($circle_info[strtoupper($pulse_tf[1])] == '')
            $circle_info[strtoupper($pulse_tf[1])] = 'Other';
        $service_name = getServiceName($pulse_tf[2]);
        $insert_pulse_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($pulse_tf[1])] . "','$pulse_tf[0]','$pulse_tf[4]',0)";
        $queryIns_call = mysql_query($insert_pulse_tf_data1, $LivdbConn);
    }
}
///////////////End code to insert the data for PULSE_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for PULSE_t for Live Mis////////////////////////////////////////////////
$pulse_t = array();

$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1002' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1009' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'PULSE_T',circle, sum(pulse) as count,'1208' as service_name,date(call_date),sum(pulse) as pulse,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1202' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1402' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '54646' or dnis like '546464%' or dnis like '546465%') and operator ='unim' group by circle,dnis
UNION
select 'PULSE_T_6',circle, sum(ceiling(duration_in_sec/60)) as count,'1402' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546466%' and dnis!='5464669' and operator ='unim' group by circle,dnis
UNION
select 'PULSE_T_9',circle, sum(ceiling(duration_in_sec/60)) as count,'1402' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546467%' and operator ='unim' group by circle,dnis
UNION
select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)) as count,'1402' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546468%' and operator ='unim' group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1409' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis = '5464669' and operator ='unim' group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1602' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1609' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1608' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=54433 and operator in('TATC') group by circle,dnis
UNION
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'1902' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle,dnis";

$pulse_t_result1 = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pulse_t_result1);
if ($numRows12 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result1)) {
        $pulse_type = 'PULSE_T';
        if ($pulse_tf[6] != '5464669' && $pulse_t[3] == 1009)
            $pulse_type = "PULSE_T_1";
        if (($pulse_tf[6] == '544334' || $pulse_tf[6] == '5443344') && $pulse_t[3] == 1208)
            $pulse_type = "PULSE_T_6";
        if ($pulse_tf[6] == '544337' && $pulse_t[3] == 1208)
            $pulse_type = "PULSE_T_9";
        if (($pulse_tf[6] != '544334' && $pulse_tf[6] != '544337' && $pulse_tf[6] != '5443344') && $pulse_t[3] == 1208)
            $pulse_type = "PULSE_T";
        if (($pulse_t[5] == '5464669' || $pulse_t[5] == '5464666') && $pulse_t[3] == 1202)
            $pulse_type = "PULSE_T_6";
        if ($pulse_t[5] == 5464669 && $pulse_t[3] == 1609)
            $pulse_type = 'PULSE_T';
        if ($pulse_t[3] == 1609 && $pulse_t[5] != 5464669)
            $pulse_type = 'PULSE_T_1';

        $service_name = getServiceName($pulse_t[3]);

        if ($pulse_t[3] == '1902' || $pulse_t[3] == '1602' || ($pulse_t[3] == '1402' && $pulse_t[0] != 'PULSE_T_6' && $pulse_t[0] != 'PULSE_T_9' && $pulse_t[0] != 'PULSE_T_1')) {
            $chrg_rate = '3';
        } elseif ($pulse_t[3] == '1202') {
            if ($pulse_t[5] == '5464669' || $pulse_t[5] == '5464666' || $pulse_t[5] == '5464645') {
                $chrg_rate = '6';
            } else {
                $chrg_rate = '3';
            }
        } elseif ($pulse_t[0] == 'PULSE_T_6' && $pulse_t[3] == 1402) {
            $chrg_rate = '6';
        } elseif ($pulse_t[0] == 'PULSE_T_9' && $pulse_t[3] == 1402) {
            $chrg_rate = '9';
        } elseif ($pulse_t[0] == 'PULSE_T_1' && $pulse_t[3] == 1402) {
            $chrg_rate = '1';
        } elseif ($pulse_t[6] == '5464669' && $pulse_t[3] == 1409) {
            $chrg_rate = '6';
        } else {
            $chrg_rate = '0';
        }
        $insert_pulse_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_type','$pulse_t[2]','$chrg_rate')";
        $queryIns_call = mysql_query($insert_pulse_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for PULSE_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for MOU_tf for Tata Docomo Endless////////////////////////////////////////////////
$mou_tf = array();

$mou_tf_query = "select 'MOU_TF',circle, count(id),'1001' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATM') group by circle 
UNION
select 'MOU_TF',circle, count(id),'1002' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1009' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5464626 and operator ='tatm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1003' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator='tatm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1005' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in ('56666') and operator='tatm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1010' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in ('55935') and operator='tatm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1013' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator='tatm' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60 as count,'1202' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') group by circle
UNION
select 'MOU_TF',circle, count(id),'1203' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator in('relm','relc') group by circle
UNION
select 'MOU_TF',circle, count(id),'1201' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '543219%' and operator in('relm','relc') group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1402' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1410' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1430' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1431' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1432' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1433' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1434' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1403' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1409' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis IN ('5464626','5464628') and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, count(id),'1801' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('virm') group by circle
UNION
select 'MOU_TF',circle, count(id),'1809' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464626%' and operator in('virm') group by circle
UNION
select 'MOU_TF',circle, count(id),'1813' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('virm') group by circle
UNION
select 'MOU_TF',circle, count(id),'1601' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATC','tatc') group by circle
UNION
select 'MOU_TF',circle, count(id),'1602' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle
UNION
select 'MOU_TF',circle, count(id),'1609' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5464626 and operator in('TATC') group by circle
UNION
select 'MOU_TF',circle, count(id),'1608' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,546468) and operator in('TATC') group by circle
UNION
select 'MOU_TF',circle, count(id),'1603' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator in('TATC') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1605' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=56666 and operator in('TATC') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1613' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1810' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator in('virm') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1610' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator in('TATC') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1412' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=52888 and operator in('unim') group by circle
UNION 
select 'MOU_TF',circle, count(id),'1416' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464627%' and operator in('unim') group by circle
UNION
select 'MOU_TF',circle, count(id),'14021' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where  date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464611' and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, count(id),'1408' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52444%' and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, count(id),'1418' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464622' and operator ='unim' group by circle
UNION
select 'MOU_TF',circle, count(id),'1423' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52000%' and operator ='unim' group by circle";

$mou_tf_result = mysql_query($mou_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($mou_tf_result);
if ($numRows1 > 0) {
    while ($mou_tf = mysql_fetch_array($mou_tf_result)) {
        if ($circle_info[strtoupper($mou_tf[1])] == '')
            $circle_info[strtoupper($mou_tf[1])] = 'Other';
        $service_name = getServiceName($mou_tf[3]);
        $insert_mou_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($mou_tf[1])] . "','$mou_tf[0]','$mou_tf[5]',0)";
        $queryIns_call = mysql_query($insert_mou_tf_data1, $LivdbConn);
    }
}
///////////////End code to insert the data for MOU_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for MOU_t for Live Mis////////////////////////////////////////////////
$mou_t = array();

$mou_t_query = "select 'MOU_T',circle, count(id),'1002' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1009' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1208' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1202' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1409' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis = '5464669' and operator ='unim' group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1402' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%') and operator ='unim' group by circle,dnis
UNION
select 'MOU_T_6',circle, count(id),'1402' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546466%' and dnis!='5464669' and operator ='unim' group by circle,dnis
UNION
select 'MOU_T_9',circle, count(id),'1402' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546467%' and operator ='unim' group by circle,dnis
UNION
select 'MOU_T_1',circle, count(id),'1402' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546468%' and operator ='unim' group by circle,dnis

UNION
select 'MOU_T',circle, count(id),'1602' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1609' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1608' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=54433 and operator in('TATC') group by circle,dnis
UNION
select 'MOU_T',circle, count(id),'1902' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '54646%' and operator in('airc') group by circle,dnis";

$mou_t_result1 = mysql_query($mou_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($mou_t_result1);
if ($numRows12 > 0) {
    while ($mou_t = mysql_fetch_array($mou_t_result1)) {
        $mou_type = 'MOU_T';
        if ($mous_tf[5] == 5464669 && $mous_tf[3] == 1009)
            $mous_type = 'MOU_T';
        elseif ($mous_tf[5] == 5464668 && $mous_tf[3] == 1009)
            $mous_type = 'MOU_T_1';
        if ($mous_tf[6] == '544334' || $mous_tf[6] == '5443344' && $mous_tf[3] == 1208)
            $mous_type = "MOU_T_6";
        if ($mous_tf[6] == '544337' && $mous_tf[3] == 1208)
            $mous_type = "MOU_T_9";
        if ($mous_tf[6] != '544334' && $mous_tf[6] != '544337' && $mous_tf[6] != '5443344' && $mous_tf[3] == 1208)
            $mous_type = "MOU_T";
        if ($mous_t[6] == '5464669' || $mous_t[6] == '5464666' && $mous_tf[3] == 1202)
            $mous_type = "MOU_T_6";
        if ($mous_t[6] == 5464669 && $mous_tf[3] == 1609)
            $mous_type = 'MOU_T';
        if ($mous_tf[3] == 1609 && $mous_t[6] != 5464669)
            $mous_type = 'MOU_T_1';

        $service_name = getServiceName($mou_t[3]);
        $insert_mou_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($mou_t[1])] . "','$mou_type','$mou_t[5]',0)";
        $queryIns_call = mysql_query($insert_mou_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for MOU_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_tf for LiveMIS////////////////////////////////////////////////
$sec_tf = array();

$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'1001' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATM') group by circle 
UNION
select 'SEC_TF',circle, count(msisdn),'1002' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator ='tatm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1009' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5464626 and operator ='tatm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1005' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in ('56666') and operator='tatm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1010' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator='tatm' group by circle
UNION
select 'SEC_TF',circle, count(id),'1003' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator='tatm' group by circle
UNION
select 'SEC_TF',circle, count(id),'1013' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator='tatm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1202' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1203' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator in('relm','relc') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1201' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '543219%' and operator in('relm','relc') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1402' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1409' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis IN ('5464626','5464628') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1410' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1430' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1431' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1432' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_BollywoodMasala_calllog  where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1433' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1434' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1403' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1801' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('virm') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1809' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464626%' and operator in('virm') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1813' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('virm') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1601' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATC','tatc') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1602' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator in('TATC') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1609' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5464626 and operator in('TATC') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1608' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=54433 and operator in('TATC') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1603' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator in('TATC') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1605' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=56666 and operator in('TATC') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1613' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1810' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator in('virm') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1610' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator in('TATC') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1412' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=52888 and operator in('unim') group by circle
UNION 
select 'SEC_TF',circle, count(msisdn),'1416' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464627%' and operator in('unim') group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'14021' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where  date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464611' and operator ='unim' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1408' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52444%' and operator ='unim' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1418' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464622' and operator ='unim' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1423' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52000%' and operator ='unim' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($sec_tf_result);
if ($numRows1 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($circle_info[strtoupper($sec_tf[1])] == '')
            $circle_info[strtoupper($sec_tf[1])] = 'Other';
        $service_name = getServiceName($sec_tf[3]);
        $insert_sec_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($sec_tf[1])] . "','$sec_tf[0]','$sec_tf[5]',0)";
        $queryIns_call = mysql_query($insert_sec_tf_data1, $LivdbConn);
    }
}
///////////////End code to insert the data for SEC_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_t for Live Mis////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_T',circle, count(msisdn),'1002' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and operator ='tatm' group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1009' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464668','5464669') and operator ='tatm' group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1208' as service_name,date(call_date),sum(duration_in_sec),dnis 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1202' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1402' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%') and operator in('unim') group by circle,dnis
UNION
select 'SEC_T_6',circle, count(msisdn),'1402' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546466%' and dnis!='5464669' and operator in('unim') group by circle,dnis
UNION
select 'SEC_T_9',circle, count(msisdn),'1402' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546467%'  and operator in('unim') group by circle,dnis
UNION
select 'SEC_T_1',circle, count(msisdn),'1402' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546468%' and operator in('unim') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1409' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis = '5464669' and operator in('unim') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1602' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1609' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1608' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=54433 and operator in('TATC') group by circle,dnis
UNION
select 'SEC_T',circle, count(msisdn),'1902' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '54646%' and operator in('airc') group by circle,dnis";

$sec_t_result1 = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($sec_t_result1);
if ($numRows12 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result1)) {
        $sec_type = 'SEC_T';
        if ($sec_t[6] == '544334' || $sec_t[6] == '5443344' && $sec_t[3] == 1208)
            $sec_type = "SEC_T_6";
        if ($sec_t[6] == '544337' && $sec_t[3] == 1208)
            $sec_type = "SEC_T_9";
        if ($sec_t[6] != '544334' && $sec_t[6] != '544337' && $sec_t[6] != '5443344' && $sec_t[3] == 1208)
            $sec_type = "SEC_T";
        if ($sec_tf[6] == 5464669 && $sec_t[3] == 1009)
            $sec_type = 'SEC_T';
        if ($sec_tf[6] != 5464669 && $sec_t[3] == 1009)
            $sec_type = 'SEC_T_1';
        if (($sec_t[6] == '5464669' || $sec_t[6] == '5464666') && $sec_t[3] == 1202)
            $sec_type = 'SEC_T_6';
        if ($sec_t[6] != 5464669 && $sec_t[3] == 1609)
            $sec_type = 'SEC_T_1';


        $service_name = getServiceName($sec_t[3]);
        $insert_sec_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_type','$sec_t[5]',0)";
        $queryIns_call = mysql_query($insert_sec_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for SEC_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for UU_TF for LiveMIS////////////////////////////////////////////////
$uu_tf = array();

$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'1001' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATM') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1002' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and operator ='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1009' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464626' and operator ='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1003' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=546461 and operator='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1005' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in ('56666') and operator='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1010' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in ('55935') and operator='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1013' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator='tatm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1202' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('relm','relc') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1203' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =546461 and operator in('relm','relc') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1201' as service_name,date(call_date) from mis_db.tbl_musicmania_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '543219%' and operator in('relm','relc') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1402' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1409' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis IN ('5464628','5464626') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1410' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55935 and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1430' as service_name,date(call_date) from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1431' as service_name,date(call_date) from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1432' as service_name,date(call_date) from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1433' as service_name,date(call_date) from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1434' as service_name,date(call_date) from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1403' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461) and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1801' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('virm') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1809' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464626%' and operator in('virm') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1813' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('virm') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1601' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '59090%' and operator in('TATC','tatc')  group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1602' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1609' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =5464626 and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1608' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433) and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1603' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =546461 and operator in('TATC') group by circle
UNION 
select 'UU_TF',circle, count(distinct msisdn),'1605' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =56666 and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1613' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis = '55001' or dnis='550011') and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1810' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =55935 and operator in('virm') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1610' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =55935 and operator in('TATC') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1412' as service_name,date(call_date) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =52888 and operator in('unim') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1416' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464627%' and operator in('unim') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'14021' as service_name,date(call_date) from mis_db.tbl_54646_calllog where  date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464611' and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1408' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52444%' and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1418' as service_name,date(call_date) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464622' and operator ='unim' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1423' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '52000%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($uu_tf_result);
if ($numRows1 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($circle_info[strtoupper($uu_tf[1])] == '')
            $circle_info[strtoupper($uu_tf[1])] = 'Other';
        $service_name = getServiceName($uu_tf[3]);
        $insert_uu_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_call = mysql_query($insert_uu_tf_data1, $LivdbConn);
    }
}
///////////////End code to insert the data for UU_TF for LiveMIS///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for UU_T for Live Mis////////////////////////////////////////////////
$uu_t = array();

$uu_t_query = "select 'UU_T',circle, count(distinct msisdn),'1002' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1009' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1208' as service_name,date(call_date),dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1202' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and operator in('relm','relc') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1402' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%') and operator in('unim') group by circle,dnis
UNION
select 'UU_T_6',circle, count(distinct msisdn),'1402' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546466%' and dnis!='5464669' and operator in('unim') group by circle,dnis
UNION
select 'UU_T_9',circle, count(distinct msisdn),'1402' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546467%'  and operator in('unim') group by circle,dnis
UNION
select 'UU_T_1',circle, count(distinct msisdn),'1402' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and  dnis like '546468%' and operator in('unim') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1409' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis = '5464669' and operator in('unim') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1602' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1609' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in('5464669','5464668') and operator in('TATC') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1608' as service_name,date(call_date),dnis from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(54433,546468) and operator in('TATC') group by circle,dnis
UNION
select 'UU_T',circle, count(distinct msisdn),'1902' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '54646%' and operator in('airc') group by circle,dnis";

$uu_t_result1 = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($uu_t_result1);
if ($numRows12 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result1)) {
        $uu_type = 'SEC_T';
        if ($uu_t[5] == '5464669' && $uu_t[3] == 1009)
            $uu_type = 'UU_T';
        if ($uu_t[5] == '5464668' && $uu_t[3] == 1009)
            $uu_type = 'UU_T_1';
        if ($uu_t[5] == '544334' || $uu_t[5] == '5443344' && $uu_t[3] == 1208)
            $uu_type = "UU_T_6";
        if ($uu_t[5] == '544337' && $uu_t[3] == 1208)
            $uu_type = "UU_T_9";
        if ($uu_t[5] != '544334' && $uu_t[5] != '544337' && $uu_t[5] != '5443344' && $uu_t[3] == 1208)
            $uu_type = "UU_T";
        if ($uu_t[5] == '5464669' || $uu_t[5] == '5464666' && $uu_t[3] == 1202)
            $uu_type = "UU_T_6";
        if ($uu_tf[5] == '5464669' && $uu_t[3] == 1609)
            $uu_type = 'UU_T';
        elseif ($uu_tf[5] == '5464668' && $uu_t[3] == 1609)
            $uu_type = 'UU_T_1';

        $service_name = getServiceName($uu_t[3]);
        $insert_uu_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($uu_t[1])] . "','$uu_type','$uu_t[2]',0)";
        $queryIns_call = mysql_query($insert_uu_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for UU_t for LIve MIs///////////////////////////////////////////////////////////////////
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not like 'CNS_%') and type not in('Active_Base','Pending_Base')";
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
echo $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'MOU_%' OR type like 'SEC_%' OR type like 'UU_%')";
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
$file_process_status = 'insertDailyReportCallLive process file- End#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
echo "generated";
$kpi_process_status = '***************Script end for insertDailyReportCallLive******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>