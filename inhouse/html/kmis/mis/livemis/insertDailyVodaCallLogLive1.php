<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
error_reporting(0);
// delete the prevoius record
$type=strtolower($_REQUEST['last']);
if($type=='y')
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
else
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

//echo $view_date1='2014-07-16';

$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyVodaCallLogLive1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);


$deleted_file = "/var/www/html/kmis/mis/livemis/livekpi_voda_calllog_".date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).".txt";
unlink($deleted_file);
$date_lasthour = date('H', strtotime('-1 hour'));
$processlog = "/var/www/html/kmis/mis/livemis/livekpi_voda_calllog_" . date('Ymd') . ".txt";
$file_process_status = 'MIS process file-insertDailyVodaCallLogLive1#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

function getServiceName($service_id) {
    switch ($service_id) {
        case '1301':
            $service_name = 'VodafoneMU';
            break;
        case '1302':
            $service_name = 'Vodafone54646';
            break;
        case '1303':
            $service_name = 'VodafoneMTV';
            break;
        case '1307':
            $service_name = 'VH1Vodafone';
            break;
        case '1310':
            $service_name = 'REDFMVodafone';
            break;
        case '130202':
            $service_name = 'VodafonePoet';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');
$service_array = array('VodafoneMU', 'Vodafone54646', 'VodafoneMTV', 'VH1Vodafone', 'REDFMVodafone', 'VodafonePoet');

/////// start the code to delete existing data of Vodafone service////////////////
//delete existing data
$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "')  
                    and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
					
$cond="and hour(call_time)<='$date_lasthour'";
} else {
   $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                    or date='" . $next_date . " 00:00:00') and service IN ('" . implode("','", $service_array) . "')  
                    and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
}

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$file_process_status = $DateFormat[0] . "#" . $DeleteQuery . '#datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
///////// start the code to insert the data of activation Voda////////////////
echo "Call_TF Start"."<br>";
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
echo "Call_TF End"."<br>";
///////////////End code to insert the data for call_tf for Voda///////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for call_t for Live Mis////////////////////////////////////////////////
$call_t = array();
echo "Call_T Start"."<br>";
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
echo "Call_T End"."<br>";
//////////////////////////////End code to insert the data for call_t for LIve MIs///////////////////////////////////////////////////////////////////
//start code to insert the data for mous_tf for Voda
$mous_tf = array();
echo "MOU_TF Start"."<br>";
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'1302' as service_name,date(call_date),hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle,hour(call_time)
union
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1303' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(546461) and operator in('vodm') group by circle,hour(call_time)
union
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1307' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55841) and operator in('vodm') group by circle,hour(call_time)
union
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1301' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis like '55665%' and operator in('vodm') group by circle,hour(call_time)
union
select 'MOU_TF',circle, sum(duration_in_sec)/60,'1310' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55935) and operator in('vodm') group by circle,hour(call_time)";

$mous_tf_result = mysql_query($mous_tf_query, $dbConnVoda) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $service_name = getServiceName($mous_tf[3]);
		$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($mous_tf[1])] . "','$mous_tf[0]','$mous_tf[2]',0)";
        $queryIns_mous = mysql_query($insert_mous_tf_data1, $LivdbConn);
    }
}
echo "MOU_TF End"."<br>";
//////////////////////////////////// end//////////////////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t For Voda////////////////////////////
$mous_t = array();
echo "MOU_T Start"."<br>";
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'1302' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='5464681' and operator in('vodm') group by circle,hour(call_time) ";

$mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $service_name = getServiceName($mous_t[3]);
		$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '" . $circle_info[strtoupper($mous_t[1])] . "','$mous_t[0]','$mous_t[2]',0)";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Voda////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for mou_t For Voda////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'130202' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis = '5464681' and operator in('vodm') group by circle,hour(call_time)";

$mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConnVoda) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $service_name = getServiceName($mous_t[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_mous_t_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($mous_t[1])] . "','$mous_t[0]','$mous_t[2]',0)";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);
    }
}
echo "MOU_T End"."<br>";
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Voda////////////////////////////
/////////////////////////////////start code to insert the data for PULSE_TF for the Voda SErvice/////////////////////////////////////////

echo "PULSE_TF Start"."<br>";
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1302' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle,hour(call_time) 
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1303' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(546461) and operator in('vodm') group by circle,hour(call_time) 
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1307' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55841) and operator in('vodm') group by circle,hour(call_time) 
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1301' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis like '55665%' and operator in('vodm') group by circle,hour(call_time) 
union
select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'1310' as service_name,date(call_date),hour(call_time)  
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55935) and operator in('vodm') group by circle,hour(call_time)";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnVoda) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $service_name = getServiceName($pulse_tf[3]);
		$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_tf_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_tf[1])] . "','$pulse_tf[0]','$pulse_tf[2]',0)";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data1, $LivdbConn);
    }
}
echo "PULSE_TF End"."<br>";
/////////////////////////////////////////End code to insert the data for PULSE_TF for Voda/////////////////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T Voda////////////////////////////
echo "PULSE_T Start"."<br>";
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'1302' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='5464681' and operator in('vodm') group by circle,hour(call_time)";

$pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $service_name = getServiceName($pulse_t[3]);
		$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_t_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_t[0]','$pulse_t[2]',0)";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
    }
}
/////////////////////////////////////////////////////////////////End code to insert the data for Voda////////////////////////////
/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_T Voda////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling((duration_in_sec-10)/60)),'130202' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond 
and dnis = '5464681' and operator in('vodm') group by circle,hour(call_time)";

$pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConnVoda) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $service_name = getServiceName($pulse_t[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_pulse_t_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($pulse_t[1])] . "','$pulse_t[0]','$pulse_t[2]',3)";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);
    }
}
echo "PULSE_T END"."<br>";
/////////////////////////////////////////////////////////////////End code to insert the data for Voda////////////////////////////
////////////////////////////////////////////start code to insert the data for Unique Users  for Voda ////////////////////////////////
$uu_tf = array();
echo "UU_TF Start"."<br>";
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'1302' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1303' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(546461) and operator in('vodm') group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1307' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55841) and operator in('vodm') group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1301' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis like '55665%' and operator in('vodm') group by circle,hour(call_time)
union
select 'UU_TF',circle, count(distinct msisdn),'1310' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55935) and operator in('vodm') group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data2, $LivdbConn);
    }
}
echo "UU_TF end"."<br>";
///////////////////////////////////////////// end Unique Users  for Voda//////////////////////////////////////////////////////
//////////////////////////////////////Start code to insert the data  Unique Users for toll for Voda//////////////////////////////

echo "UU_T Start"."<br>";
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'1302' as service_name,date(call_date) ,hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis !='5464681' and operator in('vodm') group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data32 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
    }
}

///////////////////////////////////End code to insert the data  Unique Users for toll for Voda//////////////////////////////
//////////////////////////////////////Start code to insert the data  Unique Users for toll for Voda//////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'130202' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis = '5464681' and operator in('vodm') group by circle,hour(call_time)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConnVoda) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $service_name = getServiceName($uu_tf[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_uu_tf_data32 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($uu_tf[1])] . "','$uu_tf[0]','$uu_tf[2]',0)";
        $queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);
    }
}
echo "UU_T END"."<br>";
///////////////////////////////////End code to insert the data  Unique Users for toll for Voda//////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for Voda /////////////////////////////////
$sec_tf = array();
echo "SEC_TF Start"."<br>";
$sec_tf_query = "select 'SEC_TF',circle,sum(duration_in_sec),'1302' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis !='546461' and operator in('vodm') group by circle,hour(call_time)
union
select 'SEC_TF',circle,sum(duration_in_sec),'1303' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(546461) and operator in('vodm') group by circle,hour(call_time)
union
select 'SEC_TF',circle,sum(duration_in_sec),'1307' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55841) and operator in('vodm') group by circle,hour(call_time)
union
select 'SEC_TF',circle,sum(duration_in_sec),'1301' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis like '55665%' and operator in('vodm') group by circle,hour(call_time)
union
select 'SEC_TF',circle,sum(duration_in_sec),'1310' as service_name,date(call_date),hour(call_time) 
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis in(55935) and operator in('vodm') group by circle,hour(call_time)";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnVoda) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $service_name = getServiceName($sec_tf[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_tf_data5 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time','$service_name', '" . $circle_info[strtoupper($sec_tf[1])] . "','$sec_tf[0]','$sec_tf[2]',0)";
        $queryIns_sec = mysql_query($insert_sec_tf_data5, $LivdbConn);
    }
}
// end insert the data for SEC_TF  for Voda
echo "SEC_TF End"."<br>";
$sec_t = array();
echo "SEC_T Start"."<br>";
$sec_t_query = "select 'SEC_T',circle,sum(duration_in_sec),'1302' as service_name,date(call_date),hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis !='5464681' and operator in('vodm') group by circle,hour(call_time)";


$sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $service_name = getServiceName($sec_t[3]);
				$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_t_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_t[0]','$sec_t[2]',0)";
        $queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
    }
}

$sec_t = array();

$sec_t_query = "select 'SEC_T',circle,sum(duration_in_sec),'130202' as service_name,date(call_date),hour(call_time)
from master_db.tbl_voda_calllog nolock where date(call_date)='$view_date1' $cond and dnis = '5464681' and operator in('vodm') group by circle,hour(call_time)";


$sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConnVoda) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $service_name = getServiceName($sec_t[3]);
		$edit_hour = $call_tf[5] + 1;
        if ($edit_hour == '24') {
            $edit_hour = "00";
            $date_time = $next_date . " " . $edit_hour . ":00:00";
        } else {
            $date_time = $call_tf[4] . " " . $edit_hour . ":00:00";
        }
        $insert_sec_t_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$date_time', '$service_name', '" . $circle_info[strtoupper($sec_t[1])] . "','$sec_t[0]','$sec_t[2]',0)";
        $queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);
    }
}
echo "SEC_T End"."<br>";


//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type like 'CALLS%' OR type like 'PULSE%' OR type like 'UU%' OR type like 'SEC%' OR type like 'MOU%')";
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

echo "generated";
mysql_close($dbConnVoda);
$kpi_process_status = '***************Script end for insertDailyVodaCallLogLive1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>