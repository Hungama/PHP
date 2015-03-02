<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
error_reporting(0);
$type = strtolower($_REQUEST['last']);
if (date('H') == '00' || $type == 'y') {
    $type = 'y';
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/mts/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/mts/serviceNameconfig.php");
$kpiPrevfiledate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mts/livekpi_" . $kpiPrevfiledate . ".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate = date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mts/livekpi_" . $kpifiledate . ".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Mts******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('MTSMU', 'MTS54646', 'MTSReg', 'MTSJokes', 'MTSContest', 'MTVMTS', 'MTSDevo', 'MTSFMJ', 'RedFMMTS', 'MTSVA', 'MTSComedy', 'MTSMND', 'MTSAC','MTSSU');

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
//echo $DeleteQuery;

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


//////////////////////////////start code to insert the data for call_tf for MTS////////////////////////////////////////////////
$DumpfileCallsTF = "callsTFMts_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'1101' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) 
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'11012' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis='5222212' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1102' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' 
or dnis like '546463%' or dnis like '546469%' ) and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1125' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis = '5464622' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1123' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1124' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_AC_calllog where date(call_date)='$view_date1' and  circle='tnu' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1103' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis=546461 group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1111' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
 from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1'  and dnis=5432105 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1106' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis =5432155 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1110' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
 from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and  dnis =55935 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1116' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1113' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis like '54646196%' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1126' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1'  and dnis ='51111' and chrg_rate=0 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1108' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1'  and dnis ='52444' and chrg_rate=0 group by circle,hour(call_time)";

$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    unlink($DumpfileCallsTFPath);
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($circle_info[strtoupper($call_tf[1])] == '')
            $circle_info[strtoupper($call_tf[1])] = 'Other';
        $service_name = getServiceName($call_tf[3]);
        $circle = $call_tf[1];
        $DateFormat1 = $call_tf[6];
        $calltype = $call_tf[0];
        $totalCount = $call_tf[2];
        $callsTFData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $calltype . "|" . $totalCount . "|" . '0' . "\r\n";
        error_log($callsTFData, 3, $DumpfileCallsTFPath);
    }
    $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$DumpfileCallsT = "callsTMts_" . date('ymd') . '.txt';
$DumpfileCallsTPath = $fileDumpPath . $DumpfileCallsT;

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'1102' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%'
or dnis like '546468%') group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1106' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1123' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and  dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)
union
select 'CALLS_T_1',circle, count(id),'1123' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1126' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_reg_calllog
where date(call_date)='$view_date1'  and dnis ='51111' and chrg_rate=3  group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1106' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1'  and dnis in (54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'CALLS_T_1',circle, count(id),'1108' as service_name,date(call_date),hour(call_time),SUBSTRING(adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19)
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis='5244401' and chrg_rate=1 group by circle,hour(call_time)";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    unlink($DumpfileCallsTPath);
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $service_name = getServiceName($call_t[3]);
        $calltype = $call_t[0];
        $circle = $call_t[1];
        $DateFormat1 = $call_t[6];
        $totalCount = $call_t[2];
        $callsTData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $calltype . "|" . $totalCount . "|" . '0' . "\r\n";
        error_log($callsTData, 3, $DumpfileCallsTPath);
    }
    $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}


// sleep for 10 seconds
sleep(10);
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
$nextDeleteQuery = "delete from misdata.livemis where date=date_format('" . $next_date . "','%Y-%m-%d 00:00:00') and service IN ('" . implode("','", $service_array) . "')";
if ($date_Currentthour != '00') {
    if ($type != 'y') {
        echo "Next day data delete" . $nextDeleteQuery;
        $deleteResult12 = mysql_query($nextDeleteQuery, $LivdbConn) or die(mysql_error());
    }
}
echo "Current hour is" . $date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
if ($date_Currentthour != '23') {
    if ($type != 'y') {
        echo $DeleteQuery;
        $deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
    } else {
        echo 'NOK';
    }
}
unlink($DumpfileCallsTFPath);
unlink($DumpfileCallsTPath);
mysql_close($dbConn);
mysql_close($LivdbConn);
$kpi_process_status = '*******Script end for insertDailyReportCallLive_Mts*********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>