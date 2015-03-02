<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNL.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
error_reporting(0);
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$view_time1 = date("h:i:s");
$kpiPrevfiledate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/bsnl/livekpi_" . $kpiPrevfiledate . ".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate = date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/bsnl/livekpi_" . $kpifiledate . ".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_BSNL******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

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
    $DateFormat[0] = $_GET['time'];
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

echo $call_t_query = "select 'CALLS_T',circle, count(id),'2202' as service_name,date(call_date),dnis from mis_db.tbl_bsnl_54646_calllog 
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
		echo $insert_call_t_data1."<br>";
        $queryIns_call = mysql_query($insert_call_t_data1, $LivdbConn);
    }
}
/////////////////////////////////////////////// insert CALL data code end here //////////////////////////////////////////////////////////
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

mysql_close($dbConn);
mysql_close($LivdbConn);
$kpi_process_status = '***************Script end for insertDailyReportCallLive_BSNL******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
echo "generated"; 
?>