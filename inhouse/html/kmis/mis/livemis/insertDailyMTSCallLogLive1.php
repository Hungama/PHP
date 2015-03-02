<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");

$type=strtolower($_REQUEST['last']);
if($type=='y')
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
else
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));


//$view_date1 = '2014-07-19';
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyMTSCallLogLive1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$processlog = "/var/www/html/kmis/mis/livemis/livemislogs/livekpi_mts_calllog.txt";
$file_process_status = 'MTS process file-insertDailyMTSCallLogLive1#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

function getServiceName($service_id) {
    switch ($service_id) {
        case '1101':
            $service_name = 'MTSMU';
            break;
        case '1102':
            $service_name = 'MTS54646';
            break;
        case '1126':
            $service_name = 'MTSReg';
            break;
        case '1125':
            $service_name = 'MTSJokes';
            break;
        case '1123':
            $service_name = 'MTSContest';
            break;
        case '1103':
            $service_name = 'MTVMTS';
            break;
        case '1106':
            $service_name = 'MTSFMJ';
            break;
        case '1111':
            $service_name = 'MTSDevo';
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
        case '1124':
            $service_name = 'MTSAC';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');

$service_array = array('MTSMU', 'MTS54646', 'MTSReg', 'MTSJokes', 'MTSContest', 'MTVMTS', 'MTSDevo', 'MTSFMJ', 'RedFMMTS', 'MTSVA', 'MTSComedy', 'MTSMND', 'MTSAC');


/////////////////////////////////////////////// delete existing data code start @jyoti.porwal /////////////////////////////////////////////////////
$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    echo $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "')  
                    and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
					$islastday=false;
} else {
   echo $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                    or date='" . $next_date . " 00:00:00') and service IN ('" . implode("','", $service_array) . "')  
                    and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
$islastday=true;
					}

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
/////////////////////////////////////////////// delete existing data code end @jyoti.porwal /////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_tf for MTS////////////////////////////////////////////////
$call_tf = array();

$call_tf_query = "select 'CALLS_TF',circle, count(id),'1101' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'11012' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis='5222212' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1102' as service_name,date(call_date),hour(call_time)
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' 
or dnis like '546463%' or dnis like '546469%' ) and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1125' as service_name,date(call_date),hour(call_time) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis = '5464622' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1123' as service_name,date(call_date),hour(call_time) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1124' as service_name,date(call_date),hour(call_time) 
from mis_db.tbl_AC_calllog where date(call_date)='$view_date1' and  circle='tnu' group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1103' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis=546461 group by circle,hour(call_time)
UNION
select 'CALLS_TF',circle, count(id),'1111' as service_name,date(call_date),hour(call_time)
 from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1'  and dnis=5432105 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1106' as service_name,date(call_date),hour(call_time)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and  dnis =5432155 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1110' as service_name,date(call_date),hour(call_time)
 from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and  dnis =55935 group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1116' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'CALLS_TF',circle, count(id),'1113' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and dnis like '54646196%' group by circle,hour(call_time)";

$file_process_status = $call_tf_query .  '#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $i = 0;
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $i++;
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
        $insert_call_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
		values('$date_time','$service_name', '" . $circle_info[strtoupper($call_tf[1])] . "','$call_tf[0]','$call_tf[2]',0)";
        $queryIns_call = mysql_query($insert_call_tf_data1, $LivdbConn);
        if ($queryIns_call) {
         //   echo "done";
        } else {
            echo mysql_error();
        }
        if ($i <= 2) {
            $file_process_status = $call_tf_query  . '#datetime#' . date("Y-m-d H:i:s") . "\r\n";
            error_log($file_process_status, 3, $processlog);
        }
    }
}

///////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
echo "calls_T";
$call_t = array();

$call_t_query = "select 'CALLS_T',circle, count(id),'1102' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%'
or dnis like '546468%') group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1106' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1123' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and  dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)
union
select 'CALLS_T_1',circle, count(id),'1123' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)";
//echo $call_t_query;
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $service_name = getServiceName($call_t[3]);
        $edit_hour = $call_t[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_t[4] . " " . $edit_hour . ":00:00";
        }
         $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
        values('$date_time','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_t[0]','$call_t[2]',0)";
         $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);

    }
}
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis (MTS Regional) ////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_T',circle, count(id),'1126' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_reg_calllog
where date(call_date)='$view_date1'  and dnis ='51111' and chrg_rate=3  group by circle,hour(call_time)
union
select 'CALLS_T',circle, count(id),'1106' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1'  and dnis in (54321551,54321552,54321553) group by circle,hour(call_time)";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $service_name = getServiceName($call_t[3]);
        $edit_hour = $call_t[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_t[4] . " " . $edit_hour . ":00:00";
        }
         $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_t[0]','$call_t[2]',0)";
         $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//start code to insert the data for mous_tf for tata Docomo Endless
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'1101' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'11012' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)  
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis='5222212' group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'1102' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or 
dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
UNION
select 'MOU_TF',circle, count(id),'1125' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time) 
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle,hour(call_time)
UNION
select 'MOU_TF',circle, count(id),'1123' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
UNION
select 'MOU_TF',circle, count(id),'1124' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_AC_calllog where date(call_date)='$view_date1' and circle='tnu' group by circle,hour(call_time)
UNION
select 'MOU_TF',circle, count(id),'1103' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,hour(call_time)
UNION
select 'MOU_TF',circle, count(id),'1111' as service_name,date(call_date),sum(duration_in_sec)/60 as mous ,hour(call_time) 
from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'1106' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'1110' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'1116' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time) 
from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'MOU_TF',circle, count(id),'1113' as service_name,date(call_date),sum(duration_in_sec)/60 as mous ,hour(call_time)
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,hour(call_time)";
//echo $mous_tf_query;
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $service_name = getServiceName($mous_tf[3]);
        $edit_hour = $mous_tf[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $mous_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name','" . $circle_info[strtoupper($mous_tf[1])] . "','$mous_tf[0]','$mous_tf[5]',0)";
        $queryIns_mous = mysql_query($insert_mous_tf_data1, $LivdbConn);
    }
}
//////////////////////////////////// end//////////////////////////////////////////
///////////////////////////////////////////////////Start code to insert the data for mou_t For ////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'1102' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' 
or dnis like '546467%' or dnis like '546468%') group by circle,hour(call_time)
union
select 'MOU_T',circle, count(id),'1106' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'MOU_T',circle, count(id),'1123' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)
union
select 'MOU_T_1',circle, count(id),'1123' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
 from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $service_name = getServiceName($mous_t[3]);
        $edit_hour = $mous_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $mous_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name','" . $circle_info[strtoupper($mous_t[1])] . "','$mous_t[0]','$mous_t[5]',0)";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////
///////////////////////////////////////////////////Start code to insert the data for mou_t For MTS Regional////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, count(id),'1126' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time) 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1'  and dnis ='51111' and chrg_rate=3  group by circle,hour(call_time)
union
select 'MOU_T',circle, count(id),'1106' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(call_time)
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)";

$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $service_name = getServiceName($mous_t[3]);
        $edit_hour = $mous_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $mous_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name','" . $circle_info[strtoupper($mous_t[1])] . "','$mous_t[0]','$mous_t[5]',0)";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t REliance 54646////////////////////////////
/////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1101' as service_name,date(call_date)
,sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
 from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'11012' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse ,hour(call_time)
from mis_db.tbl_radio_calllog where 
date(call_date)='$view_date1' and dnis='5222212' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1102' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1125' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and dnis ='5464622' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1123' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1124' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_AC_calllog where 
date(call_date)='$view_date1' and circle='tnu' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1103' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis=546461 group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1111' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time) 
from mis_db.tbl_Devotional_calllog where 
date(call_date)='$view_date1'  and dnis=5432105 group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1106' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1'  and dnis=5432155 group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1110' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time) 
from mis_db.tbl_redfm_calllog where 
date(call_date)='$view_date1' and dnis=55935 group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1116' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_voicealert_calllog where 
date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1113' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and dnis like '54646196%' group by circle,hour(call_time)";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $service_name = getServiceName($pulse_tf[3]);
        $edit_hour = $pulse_tf[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $pulse_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_tf[1])] . "','$pulse_tf[0]','$pulse_tf[2]',0)";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data1, $LivdbConn);
    }
}
//////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////
/////////////////////////////////////////////////////Start code to insert the data for PULSE_T REliance 54646////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1102' as service_name,date(call_date)
,sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' 
or dnis like '546467%' or dnis like '546468%') group by circle,hour(call_time)
union
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1106' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $service_name = getServiceName($pulse_t[3]);
        if ($pulse_t[3] == '1102')
            $chrg_rate = 3;
        else
            $chrg_rate = 0;
        $edit_hour = $pulse_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $pulse_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_t_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_t[0]','$pulse_t[2]','$chrg_rate')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////
/////////////////////////////////////////////////////Start code to insert the data for PULSE_T MTS Regional ////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1126' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse ,hour(call_time)
from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle,hour(call_time)
union
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1106' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'1123' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(call_time)
from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $service_name = getServiceName($pulse_t[3]);
        $edit_hour = $pulse_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $pulse_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_t_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_t[0]','$pulse_t[2]',3)";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
    }
}
/////////////////////////////////////////////////////Start code to insert the data for PULSE_T MTS Regional ////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'1123' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse ,hour(call_time)
from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)";
$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $service_name = getServiceName($pulse_t[3]);
        $edit_hour = $pulse_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $pulse_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_t_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_t[0]','$pulse_t[2]',1)";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T REliance 54646////////////////////////////
////////////////////////////start code to insert the data for Unique Users //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'1101' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_radio_calllog where 
date(call_date)='$view_date1'  and dnis like '52222%' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'11012' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_radio_calllog where 
date(call_date)='$view_date1'  and dnis='5222212' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1102' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1'  and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1125' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1'  and dnis = '5464622' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1123' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1'  and dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1124' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_AC_calllog where 
date(call_date)='$view_date1'  and circle='tnu' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1103' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1'  and dnis=546461 group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1111' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_Devotional_calllog where 
date(call_date)='$view_date1' and dnis=5432105 group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1106' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis=5432155 group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1110' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_redfm_calllog where 
date(call_date)='$view_date1' and dnis=55935 group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1116' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_voicealert_calllog where 
date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1113' as service_name,date(call_date) ,hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and dnis like '54646196%' group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
        $edit_hour = $uu_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $uu_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data2, $LivdbConn);
    }
}
///////////////////////////////////////////// end Unique Users//////////////////////////////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data  Unique Users for toll //////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'1102' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1'  and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%') group by circle,hour(call_time)
union
select 'UU_T',circle, count(distinct msisdn),'1106' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'UU_T',circle, count(distinct msisdn),'1123' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)
union
select 'UU_T_1',circle, count(distinct msisdn),'1123' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
        $edit_hour = $uu_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $uu_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data32 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
    }
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll//////////////////////////////
////////////////////////////////////////////////////////////Start code to insert the data  Unique Users for toll MTS Regional //////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'1126' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1'   and dnis ='51111' and chrg_rate=3  group by circle,hour(call_time)
union
select 'UU_T',circle, count(distinct msisdn),'1106' as service_name,date(call_date),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
        $edit_hour = $uu_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $uu_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data32 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
    }
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll//////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  Toll Free//////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'1101' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_radio_calllog where 
date(call_date)='$view_date1' and dnis like '52222%' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'11012' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_radio_calllog where 
date(call_date)='$view_date1' and dnis='5222212' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1102' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis != 546461 and dnis !='5464622' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1125' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and dnis = '5464622' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1123' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1124' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_AC_calllog where 
date(call_date)='$view_date1' and circle='tnu' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1103' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis=546461 group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1111' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_Devotional_calllog where 
date(call_date)='$view_date1' and dnis=5432105 group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1106' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis=5432155 group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1110' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_redfm_calllog where 
date(call_date)='$view_date1' and dnis=55935 group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1116' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_voicealert_calllog where 
date(call_date)='$view_date1' and dnis like '54444%' group by circle,hour(call_time)
union
select 'SEC_TF',circle, count(msisdn),'1113' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and dnis like '54646196%' group by circle,hour(call_time)";


$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $service_name = getServiceName($sec_tf[3]);
        $edit_hour = $sec_tf[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $sec_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_tf_data5 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time','$service_name', '" . $circle_info[strtoupper($sec_tf[1])] . "','$sec_tf[0]','$sec_tf[5]',0)";
        $queryIns_sec = mysql_query($insert_sec_tf_data5, $LivdbConn);
    }
}
// end insert the data for SEC_TF  for toll Free
///////////////////////////////////////////////////////// Start Code SEC_T /////////////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_T',circle, count(msisdn),'1102' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%') group by circle,hour(call_time)
union
select 'SEC_T',circle, count(msisdn),'1106' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)
union
select 'SEC_T',circle, count(msisdn),'1123' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle,hour(call_time)
union
select 'SEC_T_1',circle, count(msisdn),'1123' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle,hour(call_time)";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $service_name = getServiceName($sec_t[3]);
        $edit_hour = $sec_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $sec_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_t_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_t[0]','$sec_t[5]',0)";
        $queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
    }
}
//////////////////////////////////////////////////////// End Code SEC_T ///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////// Start Code SEC_T MTS Regional /////////////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_T',circle, count(msisdn),'1126' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_54646_calllog where 
date(call_date)='$view_date1'  and dnis ='51111' and chrg_rate=3  group by circle,hour(call_time)
union
select 'SEC_T',circle, count(msisdn),'1106' as service_name,date(call_date),sum(duration_in_sec),hour(call_time)
from mis_db.tbl_mtv_calllog where 
date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,hour(call_time)";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $service_name = getServiceName($sec_t[3]);
        $edit_hour = $sec_t[6] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $sec_t[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_t_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$date_time', '$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_t[0]','$sec_t[5]',0)";
        $queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
    }
}

$date_Currentthour = date('H');
//delete data for next day default datetime 2013-10-27 00:00:00
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}


echo "Current hour is".$date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
if($date_Currentthour!='23')
{
if(!$islastday)
{
echo "Next hour data delete-".$DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}

//////////////////////////////////////////////////////// End Code SEC_T ///////////////////////////////////////////////////////////////////////
mysql_close($dbConn);

echo "generated";
$kpi_process_status = '***************Script end for insertDailyMTSCallLogLive1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>