<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
error_reporting(1);
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
//$view_date1='2014-07-20';
//echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/mcw/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/mcw/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mcw/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/mcw/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_MCW_Inbound******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('EnterpriseMcDw');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "')";
} else {
   $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "')";
}

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'OBD_CALLS_ATM',circle, count(ANI),'EnterpriseMcDw' as service_name,date(obd_sent_date_time),hour(obd_sent_date_time) ,
adddate(date_format(concat(obd_sent_date_time,' ',hour(obd_sent_date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp where date(obd_sent_date_time)='$view_date1' and status!=0 group by circle,hour(obd_sent_date_time)
order by hour(obd_sent_date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}


$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'OBD_CALLS_SUC',circle, count(ANI),'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status=2 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'OBD_UU_ATM',circle, count(distinct ANI),'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status!=0 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}


$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'OBD_UU',circle, count(ANI),'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status=2 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'PULSE_TF_PROMO',circle,sum(ceiling(duration/30)) as pulse,'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status!=0 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}


$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'MOU_TF_PROMO',circle,sum(duration)/60 as mous,'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status!=0 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'SEC_TF_PROMO',circle,sum(duration),'EnterpriseMcDw' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details where date(date_time)='$view_date1' and status!=0 group by circle,hour(date_time)
order by hour(date_time)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

//and isAgeVerified=1
$DumpfileCallsTF= "MCWMissed_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'TOTAL_AGE_VERIFIED','OTHERS' as Circle, count(ANI),'EnterpriseMcDw' as service_name,date(LastUpdateDate),hour(LastUpdateDate) ,
adddate(date_format(concat(LastUpdateDate,' ',hour(LastUpdateDate)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_ENT_MCDOWELL.tbl_AgeVerification where date(LastUpdateDate)='$view_date1' group by circle,hour(LastUpdateDate)
order by hour(LastUpdateDate)";

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
    }
	 $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $DumpfileCallsTFPath . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
  mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}



unlink($DumpfileCallsTFPath);
// sleep for 10 seconds
sleep(10);
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."')";
if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}
echo "Current hour is".$date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
if($date_Currentthour!='23')
{
if($type!='y')
{
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}
mysql_close($dbConn);
mysql_close($LivdbConn);
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_MCW_Inbound******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
echo "generated";
?>
