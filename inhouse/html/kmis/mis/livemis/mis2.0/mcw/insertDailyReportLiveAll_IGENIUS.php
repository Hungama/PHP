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
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_IGENIUS******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('EnterpriseMaxLifeIVR');

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
//Recordings Submitted - First time- REC1
$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'REC1',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=1 and rec_type='Fresh' and issubmitted=1 and isrecorded=1 group by hour(date_time),circle
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

//Re- recording Submitted- second time -REC1_RE

$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'REC1_RE',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=1 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1 group by hour(date_time),circle
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
/***************************************/
//Recordings Submitted - First time- REC2
$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'REC2',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=2 and rec_type='Fresh' and issubmitted=1 and isrecorded=1 group by hour(date_time),circle
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

//Re- recording Submitted- second time -REC2_RE

$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'REC2_RE',circle, count(ANI),'EnterpriseMaxLifeIVR' as service_name,date(date_time),hour(date_time) ,
adddate(date_format(concat(date_time,' ',hour(date_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from Hungama_Maxlife_IGenius.tbl_user_transaction where date(date_time)='$view_date1' and child_id=2 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1 group by hour(date_time),circle
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

//Toll Free Unique Users
$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();


$call_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'EnterpriseMaxLifeIVR' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_maxlife_calllog 
where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle,hour(call_time)";

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

//Toll free calls
$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'EnterpriseMaxLifeIVR' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from  mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle,hour(call_time)";

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


$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'PULSE_TF',circle,sum(ceiling(duration_in_sec/60)) as pulse,'EnterpriseMaxLifeIVR' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle,hour(call_time)
order by hour(call_time)";

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


$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'MOU_TF',circle,sum(duration_in_sec)/60 as mous,'EnterpriseMaxLifeIVR' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle,hour(call_time)
order by hour(call_time)";

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

$DumpfileCallsTF= "Igenius_" . date('ymd') . '.txt';
$DumpfileCallsTFPath = $fileDumpPath . $DumpfileCallsTF;
$call_tf = array();
$call_tf_query = "select 'SEC_TF',circle,sum(duration_in_sec),'EnterpriseMaxLifeIVR' as service_name,date(call_date),hour(call_time) ,
adddate(date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from mis_db.tbl_maxlife_calllog where date(call_date)='$view_date1' and dnis=66291356 and operator ='unim' group by circle,hour(call_time)
order by hour(call_time)";

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
echo "Next day data delete";
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}
echo "Current hour is";
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
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_IGENIUS******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
echo "generated";
?>