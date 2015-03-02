<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNL.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

error_reporting(0);
echo $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$deleted_file = "/var/www/html/kmis/mis/livemis/livekpi_BSNL".date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).".txt";
unlink($deleted_file);

$view_time1 = date("h:i:s");
$processlog = "/var/www/html/kmis/mis/livemis/livekpi_BSNL" . date('Ymd') . ".txt";
$file_process_status = 'insertBSNLDailyReportCallLive process file- Start#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

function getServiceName($service_id) {
    switch ($service_id) {
        case '2202':
            $service_name = 'BSNL54646';
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
//$view_date1='2013-10-28';
//echo $DateFormat[0] = '2013-10-28 19:00:00';
if ($_GET['time']) {
    echo $DateFormat[0] = $_GET['time'];
}
echo $DateFormat[0];
$service_array = array('BSNL54646');

/////////////////////////////////////////////// delete previous data  code start here //////////////////////////////////////////////////////////
$DeleteQuery = "delete from misdata.livemis where date='$DateFormat[0]' and service IN('" . implode("','", $service_array) . "')
    and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'MOU_%' OR type like 'SEC_%' OR type like 'UU_%')";
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
/////////////////////////////////////////////// delete previous data  code end here //////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert CALL data code start here //////////////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_T',circle, count(id),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]' - INTERVAL 1 second) and  (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle,dnis";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_T';

        $service_name = getServiceName($call_t[3]);
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL data code end here //////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert PULSE data code start here //////////////////////////////////////////////////////////
$pulse_t = array();

$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)) as count,'2202' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time 
between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle,dnis";

$pulse_t_result1 = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pulse_t_result1);
if ($numRows12 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result1)) {
        $pulse_type = 'PULSE_T';

        $service_name = getServiceName($pulse_t[3]);
        $insert_pulse_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_type','$pulse_t[2]',0)";
        $queryIns_call = mysql_query($insert_pulse_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL data code end here //////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for MOU_t for Live Mis////////////////////////////////////////////////
$mou_t = array();

$mou_t_query = "select 'MOU_T',circle, count(id),'2202' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]') and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle,dnis";

$mou_t_result1 = mysql_query($mou_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($mou_t_result1);
if ($numRows12 > 0) {
    while ($mou_t = mysql_fetch_array($mou_t_result1)) {
        $mou_type = 'MOU_T';

        $service_name = getServiceName($mou_t[3]);
        $insert_mou_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($mou_t[1])] . "','$mou_type','$mou_t[5]',0)";
        $queryIns_call = mysql_query($insert_mou_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for MOU_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_t for Live Mis////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_T',circle, count(msisdn),'2202' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%')  and operator in('bsnl') group by circle,dnis";

$sec_t_result1 = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($sec_t_result1);
if ($numRows12 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result1)) {
        $sec_type = 'SEC_T';

        $service_name = getServiceName($sec_t[3]);
        $insert_sec_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_type','$sec_t[5]',0)";
        $queryIns_call = mysql_query($insert_sec_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for SEC_t for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for UU_T for Live Mis////////////////////////////////////////////////
$uu_t = array();

$uu_t_query = "select 'UU_T',circle, count(distinct msisdn),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator in('bsnl') group by circle,dnis";

$uu_t_result1 = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($uu_t_result1);
if ($numRows12 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result1)) {
        $uu_type = 'UU_T';

        $service_name = getServiceName($uu_t[3]);
        $insert_uu_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($uu_t[1])] . "','$uu_type','$uu_t[2]',0)";
        $queryIns_call = mysql_query($insert_uu_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for UU_t for LIve MIs///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert CALL_T_4 data code start here //////////////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_T_4',circle, count(id),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]' - INTERVAL 1 second) and  (dnis like '546468%') and operator ='bsnl' group by circle,dnis";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_T_4';

        $service_name = getServiceName($call_t[3]);
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL_T_4 data code end here //////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert PULSE_T_4 data code start here //////////////////////////////////////////////////////////
$pulse_t = array();

$pulse_t_query = "select 'PULSE_T_4',circle, sum(ceiling(duration_in_sec/60)) as count,'2202' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time 
between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546468%') and operator ='bsnl' group by circle,dnis";

$pulse_t_result1 = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pulse_t_result1);
if ($numRows12 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result1)) {
        $pulse_type = 'PULSE_T_4';

        $service_name = getServiceName($pulse_t[3]);
        $insert_pulse_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_type','$pulse_t[2]',0)";
        $queryIns_call = mysql_query($insert_pulse_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert PULSE_T_4 data code end here //////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for MOU_t_4 for Live Mis////////////////////////////////////////////////
$mou_t = array();

$mou_t_query = "select 'MOU_T_4',circle, count(id),'2202' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]') and (dnis like '546468%') and operator ='bsnl' group by circle,dnis";

$mou_t_result1 = mysql_query($mou_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($mou_t_result1);
if ($numRows12 > 0) {
    while ($mou_t = mysql_fetch_array($mou_t_result1)) {
        $mou_type = 'MOU_T_4';

        $service_name = getServiceName($mou_t[3]);
        $insert_mou_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($mou_t[1])] . "','$mou_type','$mou_t[5]',0)";
        $queryIns_call = mysql_query($insert_mou_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for MOU_t_4 for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_t_4 for Live Mis////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_T_4',circle, count(msisdn),'2202' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis like '546468%')  and operator in('bsnl') group by circle,dnis";

$sec_t_result1 = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($sec_t_result1);
if ($numRows12 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result1)) {
        $sec_type = 'SEC_T_4';

        $service_name = getServiceName($sec_t[3]);
        $insert_sec_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_type','$sec_t[5]',0)";
        $queryIns_call = mysql_query($insert_sec_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for SEC_t_4 for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for UU_T_4 for Live Mis////////////////////////////////////////////////
$uu_t = array();

$uu_t_query = "select 'UU_T_4',circle, count(distinct msisdn),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis like '546468%') and operator in('bsnl') group by circle,dnis";

$uu_t_result1 = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($uu_t_result1);
if ($numRows12 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result1)) {
        $uu_type = 'UU_T_4';

        $service_name = getServiceName($uu_t[3]);
        $insert_uu_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($uu_t[1])] . "','$uu_type','$uu_t[2]',0)";
        $queryIns_call = mysql_query($insert_uu_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for UU_t_4 for LIve MIs///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert CALL TF data code start here //////////////////////////////////////////////////////////
$call_t = array();

$call_t_query = "select 'CALLS_TF',circle, count(id),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)=date('$DateFormat[0]' - INTERVAL 60 MINUTE) and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]' - INTERVAL 1 second) and  (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and operator ='bsnl' group by circle,dnis";

$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $call_type = 'CALLS_TF';

        $service_name = getServiceName($call_t[3]);
        $insert_call_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($call_t[1])] . "','$call_type','$call_t[2]',0)";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL TF data code end here //////////////////////////////////////////////////////////
/////////////////////////////////////////////// insert PULSE TF data code start here //////////////////////////////////////////////////////////
$pulse_t = array();

$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)) as count,'2202' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time 
between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and operator ='bsnl' group by circle,dnis";

$pulse_t_result1 = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pulse_t_result1);
if ($numRows12 > 0) {
    while ($pulse_t = mysql_fetch_array($pulse_t_result1)) {
        $pulse_type = 'PULSE_TF';

        $service_name = getServiceName($pulse_t[3]);
        $insert_pulse_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_type','$pulse_t[2]',0)";
        $queryIns_call = mysql_query($insert_pulse_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL TF data code end here //////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for MOU_TF for Live Mis////////////////////////////////////////////////
$mou_t = array();

$mou_t_query = "select 'MOU_TF',circle, count(id),'2202' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) 
and time('$DateFormat[0]') and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and operator ='bsnl' group by circle,dnis";

$mou_t_result1 = mysql_query($mou_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($mou_t_result1);
if ($numRows12 > 0) {
    while ($mou_t = mysql_fetch_array($mou_t_result1)) {
        $mou_type = 'MOU_TF';

        $service_name = getServiceName($mou_t[3]);
        $insert_mou_t_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($mou_t[1])] . "','$mou_type','$mou_t[5]',0)";
        $queryIns_call = mysql_query($insert_mou_t_data1, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for MOU_TF for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_TF for Live Mis////////////////////////////////////////////////
$sec_t = array();

$sec_t_query = "select 'SEC_TF',circle, count(msisdn),'2202' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')  and operator in('bsnl') group by circle,dnis";

$sec_t_result1 = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($sec_t_result1);
if ($numRows12 > 0) {
    while ($sec_t = mysql_fetch_array($sec_t_result1)) {
        $sec_type = 'SEC_TF';

        $service_name = getServiceName($sec_t[3]);
        $insert_sec_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_type','$sec_t[5]',0)";
        $queryIns_call = mysql_query($insert_sec_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for SEC_TF for LIve MIs///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for UU_TF for Live Mis////////////////////////////////////////////////
$uu_t = array();

$uu_t_query = "select 'UU_TF',circle, count(distinct msisdn),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') 
and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator in('bsnl') group by circle,dnis";

$uu_t_result1 = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($uu_t_result1);
if ($numRows12 > 0) {
    while ($uu_t = mysql_fetch_array($uu_t_result1)) {
        $uu_type = 'UU_TF';

        $service_name = getServiceName($uu_t[3]);
        $insert_uu_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
        values('$DateFormat[0]','$service_name', '" . $circle_info[strtoupper($uu_t[1])] . "','$uu_type','$uu_t[2]',0)";
        $queryIns_call = mysql_query($insert_uu_t_data, $LivdbConn);
    }
}
//////////////////////////////End code to insert the data for UU_TF for LIve MIs///////////////////////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);
$file_process_status = 'insertDailyReportCallLive process file- End#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
echo "generated";
// end 
?>
