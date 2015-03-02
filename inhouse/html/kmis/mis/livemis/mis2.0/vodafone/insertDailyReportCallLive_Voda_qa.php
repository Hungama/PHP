<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
error_reporting(0);
$type = strtolower($_REQUEST['last']);
//$type='y';
if (date('H') == '00' || $type == 'y') {
    $type = 'y';
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/vodafone/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/vodafone/serviceNameconfig.php");
$kpiPrevfiledate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/vodafone/livekpi_" . $kpiPrevfiledate . ".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate = date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/vodafone/livekpi_" . $kpifiledate . ".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Voda******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('VodafoneMU', 'Vodafone54646', 'VodafoneMTV', 'VH1Vodafone', 'REDFMVodafone', 'VodafonePoet');

/////// start the code to delete existing data of Vodafone service////////////////
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

///////// start the code to insert the data of activation Voda////////////////
$call_tf = array();

$call_tf_query = "select 'CALLS_TF',circle, count(id),'1302' as service_name,date(call_date),hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1303' as service_name,date(call_date),hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(546461) and operator in('vodm') group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1307' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55841) and operator in('vodm') group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1301' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis like '55665%' and operator in('vodm') group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1310' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55935) and operator in('vodm') group by circle,hour(call_time)";

$call_tf_result = mysql_query($call_tf_query, $dbConnVoda) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($circle_info[strtoupper($call_tf[1])] == '')
            $circle_info[strtoupper($call_tf[1])] = 'Other';
        $service_name = getServiceName($call_tf[3]);
        $edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }

        $insert_call_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time','$service_name', '" . $circle_info[strtoupper($call_tf[1])] . "','$call_tf[0]','$call_tf[2]',0)";
        $queryIns_call = mysql_query($insert_call_tf_data1, $LivdbConn);
    }
}
///////////////End code to insert the data for call_tf for Voda///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'1302' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%')
and dnis !='5464681' and operator in('vodm') group by circle,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConnVoda) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $service_name = getServiceName($call_t[3]);
        $edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_t[0]','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}

//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_T',circle, count(id),'130202' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond 
and dnis = '5464681' and operator in('vodm') group by circle,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConnVoda) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $service_name = getServiceName($call_t[3]);
        $edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_t[0]','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//start code to insert the data for mous_tf for Voda
// sleep for 10 seconds
sleep(10);
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
$nextDeleteQuery = "delete from misdata.livemis where date=date_format('" . $next_date . "','%Y-%m-%d 00:00:00') and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%')";
if ($date_Currentthour != '00') {
    if ($type != 'y') {
        echo "Next day data delete" . $nextDeleteQuery;
        $deleteResult12 = mysql_query($nextDeleteQuery, $LivdbConn) or die(mysql_error());
    }
}
echo "Current hour is" . $date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%')";
if ($date_Currentthour != '23') {
    if ($type != 'y') {
        echo $DeleteQuery;
        $deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
    } else {
        echo 'NOK';
    }
}

mysql_close($dbConnVoda);
mysql_close($LivdbConn);

echo "generated";
$kpi_process_status = '*******Script end for insertDailyReportCallLive_Voda*********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>