<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
error_reporting(0);
$type=strtolower($_REQUEST['last']);
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/mts/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/mts/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mts/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mts/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLivel_MTSCNS******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('MTSMU', 'MTS54646', 'MTSContest', 'MTSJokes', 'MTS Regional', 'MTVMTS', 'MTSDevo', 'MTSFMJ', 'RedFMMTS', 'MTSVA', 'MTSComedy', 'MTSMND', 'MTSAC', 'MTSReg');

$getCurrentTimeQuery = "select now()";

$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery = "select date_format('" . $currentTime[0] . "','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery, $dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

if ($_GET['time']) {
    echo $DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2014-07-18 01:00:00';
//and date>'".$view_date1." 00:00:00'
//exit;
$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
//$check_date='2014-03-27';
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));

$DeleteQuery2 = "delete from misdata.livemis where date='$DateFormat[0]' and service IN ('" . implode("','", $service_array) . "')  and type in('Active_Base','Pending_Base','CNS_1','CNS_2','CNS_NOTIF')";
$deleteResult12 = mysql_query($DeleteQuery2, $LivdbConn) or die(mysql_error());


//////////////////////////////////////////insert first consent logs start here ////////////////////////////////
$get_firstconsent_base = "select count(ANI),circle,service ,firstconsent 
from MTS_IVR.tbl_consent_log_mts
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1101,1124,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and firstconsent='Y' group by circle,service,firstconsent order by firstconsent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $consent) = mysql_fetch_array($firstconsent_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $consent_str1 = "CNS_1";

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','" . $circle_info[strtoupper($circle)] . "','$consent_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

//////////////////////////////////////////first consent logs end here //////////////////////////////////////
//////////////////////////////////////////insert second consent logs start here ////////////////////////////////
$get_firstconsent_base = "select count(ANI),circle,service ,secondconsent 
from MTS_IVR.tbl_consent_log_mts
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service in(1101,1124,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and secondconsent='Y' and error_desc ='Request Success' group by circle,service,secondconsent order by secondconsent";

$firstconsent_base_query = mysql_query($get_firstconsent_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($firstconsent_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id, $consent) = mysql_fetch_array($firstconsent_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $consent_str1 = "CNS_2";

        $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','" . $circle_info[strtoupper($circle)] . "','$consent_str1','$count',0)";
        $queryIns = mysql_query($insert_data4, $LivdbConn);
    }
}

//////////////////////////////////////////second consent logs end here //////////////////////////////////////
//////////////////////////////////////////insert Notification consent logs start here ////////////////////////////////
$get_consentnotification_base = "select ANI,circle,service,date_time
from MTS_IVR.tbl_consent_log_mts
where date(date_time)=date_format('$DateFormat[0]','%Y-%m-%d')
and service in(1101,1124,1102,1123,1125,1126,1103,1111,1106,1110,1116,11012,1113)
 and secondconsent='Y' and error_desc ='Request Success' order by date_time ASC";
// where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]'  group by circle,service order by date_time ASC
$notificationconsent_base_query = mysql_query($get_consentnotification_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($notificationconsent_base_query);
if ($numRows > 0) {
    while ($row = mysql_fetch_array($notificationconsent_base_query)) {
        $count = 0;
        $ANI = $row['ANI'];
        $circle = $row['circle'];
        $service_id = $row['service'];
        $date_time = $row['date_time'];
        $service_name = getServiceName($service_id);
        $totalStatusQuery = "SELECT 'Success' as type,count(*) as total FROM master_db.tbl_billing_success nolock WHERE msisdn='" . $ANI . "'
	and service_id='" . $service_id . "' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
	UNION 
	SELECT 'Failure' as type, count(*) as total FROM master_db.tbl_billing_failure nolock WHERE msisdn='" . $ANI . "'
	and service_id='" . $service_id . "' and event_type='SUB' and response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' ";

        $statusResult = mysql_query($totalStatusQuery, $dbConn);
        while ($row1 = mysql_fetch_array($statusResult)) {
            $type = $row1['type'];
            $status[$type] = $row1['total'];
        }
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $consent_str1 = "CNS_NOTIF";
        if ($status['Success'] || $status['Failure']) {
            $count = 1;
        }
        if ($count) {
            $insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_format('$DateFormat[0]','%Y-%m-%d %H'), '$service_name','" . $circle_info[strtoupper($circle)] . "','$consent_str1','$count',0)";
            $queryIns = mysql_query($insert_data4, $LivdbConn);
        }
    }
}
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
$kpi_process_status = '***************Script end for insertDailyReportLivel_MTSCNS******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>