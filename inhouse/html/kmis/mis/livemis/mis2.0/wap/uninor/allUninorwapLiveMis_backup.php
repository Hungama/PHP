<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
include_once("/var/www/html/kmis/services/hungamacare/config/dbcon/db_218.php");
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
#$view_date1='2014-10-28';
#$type='y';
echo $type;
echo $view_date1;
$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/wap/uninor/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = $fileDumpPath."livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = $fileDumpPath."livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for uninorwapLiveMis******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
$service_array = array('WAPUninorLDR','WAPUninorContest');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
  $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00' and service IN ('" . implode("','", $service_array) . "')";
} else {
  $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "')";
}
 //echo $DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

//Uninor LDR
$fileDumpfile = "dumpFile1_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;
$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id=1411 and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query1)) {
		$service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        if ($event_type == 'RESUB') {
            $charging_str1 = "Renewal_" . $charging_amt;
            $revenue = $charging_amt * $count;
        } elseif ($event_type == 'TOPUP') {
            $charging_str1 = "TOP-UP_" . $charging_amt;
            $revenue = $charging_amt * $count;
        }
          $ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str1 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData, 3, $fileDumpPath1);
        }

    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump7, $LivdbConn);
}

//Uninor KIJI
$fileDumpPath_KIJI_RESUBTOPUP = $fileDumpPath . "dumpFileKIJI_" . date('ymd') . '.txt';
$get_activation_queryKIJI = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_queryKIJI .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id=1423 and plan_id=270 and cppp='HUN0046027' and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_queryKIJI, $dbConn212) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath_KIJI_RESUBTOPUP);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query1)) {
		$service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        if ($event_type == 'RESUB') {
            $charging_str1 = "Renewal_" . $charging_amt;
            $revenue = $charging_amt * $count;
        } elseif ($event_type == 'TOPUP') {
            $charging_str1 = "TOP-UP_" . $charging_amt;
            $revenue = $charging_amt * $count;
        }
          $ActivationDataRT = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str1 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationDataRT, 3, $fileDumpPath_KIJI_RESUBTOPUP);
        }

    $insertDump_KIJI_RT = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_KIJI_RESUBTOPUP . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump_KIJI_RT, $LivdbConn);
}


//Uninor LDR SUBSCRIPTION
$fileDumpfile2 = "dumpFile2_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_activation_query2 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='" . $view_date1 . "' and event_type='SUB' and service_id=1411 group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_query2, $dbConn212) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath12);
    $query21 = mysql_query($get_activation_query2, $dbConn212) or die(mysql_error());
    while (list($activation_count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query21)) {
		
         $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $revenue = $charging_amt * $activation_count;
        $activation_str2 = "Activation_" . $charging_amt;

        
            $ActivationData12 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str2 . "|" . $activation_count . "|" . $revenue . "\r\n";
            error_log($ActivationData12, 3, $fileDumpPath12);
        
    }
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath12 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump7, $LivdbConn);
}


//Uninor KIJI SUBSCRIPTION
$fileDumpPath_SUBKIJI = $fileDumpPath . "dumpFileSUbKIJI_" . date('ymd') . '.txt';

$get_activation_querySUBKIJI = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='" . $view_date1 . "' and event_type='SUB' and service_id=1423 and plan_id=270 and cppp='HUN0046027' group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_querySUBKIJI, $dbConn212) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath_SUBKIJI);
    $query21 = mysql_query($get_activation_querySUBKIJI, $dbConn212) or die(mysql_error());
    while (list($activation_count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query21)) {
		
         $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $revenue = $charging_amt * $activation_count;
        $activation_str2 = "Activation_" . $charging_amt;

        
            $ActivationDataSUBKIJI = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str2 . "|" . $activation_count . "|" . $revenue . "\r\n";
            error_log($ActivationDataSUBKIJI, 3, $fileDumpPath_SUBKIJI);
        
    }
    $insertDumpSUBKIJI = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath_SUBKIJI . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDumpSUBKIJI, $LivdbConn);
}

/////////////Start the code to activation Record mode wise ///////////////////
//Uninor LDR
$fileDumpfile11 = "dumpFile4_" . date('ymd') . '.txt';
$fileDumpPath7 = $fileDumpPath . $fileDumpfile11;
$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id=1411 and event_type='SUB' group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn212) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath7);
    while (list($mode_activation_count, $circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {
		 $service_name = getServiceName($service_id);

        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
		
		$revenue = 0;
        $activation_str5 = "Mode_Activation_" . $mode;

         $ActivationData21 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $mode_activation_count . "|" . $revenue . "\r\n";
            error_log($ActivationData21, 3, $fileDumpPath7);
       }
    $insertDump16 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath7 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump16, $LivdbConn);
}


//Uninor KIJI
$fileDumpPathKIJIMode = $fileDumpPath . "dumpFileKijiMode_" . date('ymd') . '.txt';
$get_mode_activation_queryKIJI = "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_queryKIJI .=" where date(response_time)='" . $view_date1 . "' 
 and service_id=1423 and plan_id=270 and cppp='HUN0046027' and event_type='SUB' group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_queryKIJI, $dbConn212) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPathKIJIMode);
    while (list($mode_activation_count,$circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {
		 $service_name = getServiceName($service_id);

        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
		
		$revenue = 0;
        $activation_str5 = "Mode_Activation_" . $mode;

         $ActivationDataKIJIMode = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $mode_activation_count . "|" . $revenue . "\r\n";
            error_log($ActivationDataKIJIMode, 3, $fileDumpPathKIJIMode);
       }
    $insertDumpKijiMode = 'LOAD DATA LOCAL INFILE "' . $fileDumpPathKIJIMode . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDumpKijiMode, $LivdbConn);
}

//deactivation data
$fileDumpfile15 = "dumpFile5_" . date('ymd') . '.txt';
$fileDumpPath8 = $fileDumpPath . $fileDumpfile15;

$get_deactivation_base = "select count(ani),circle,'1411' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_ldr.tbl_ldr_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1423' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_summer_contest.tbl_contest_unsubwap  where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath8);
    while (list($count, $circle, $service_id, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
			
        $service_name = getServiceName($service_id);

        $ActivationData25 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Deactivation' . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData25, 3, $fileDumpPath8);
    }
    $insertDump20 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath8 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump20, $LivdbConn);
}


$fileDumpfile16 = "dumpFile6_" . date('ymd') . '.txt';
$fileDumpPath9 = $fileDumpPath . $fileDumpfile16;

$get_deactivation_base = "select count(ani),circle,'1411' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_ldr.tbl_ldr_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1423' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_summer_contest.tbl_contest_unsubwap where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath9);
    while (list($count, $circle, $service_id, $unsub_reason, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $ActivationData26 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $deactivation_str1 . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData26, 3, $fileDumpPath9);
    }
    $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath9 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}

//UU Visitors
$fileDumpfile17 = "dumpFile7_" . date('ymd') . '.txt';
$fileDumpPath10 = $fileDumpPath . $fileDumpfile17;

$get_UU_Visitors = "select 'UU_Visitors',circle,count(distinct msisdn),'1411' as service_name,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR)
from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorLDR1' and datatype='browsing' group by circle,hour(datetime)
UNION
select 'UU_Visitors',circle,count(distinct msisdn),'1423' as service_name,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR)
from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorContest1' and datatype='browsing' group by circle,hour(datetime)";

$uuvisitors_base_query = mysql_query($get_UU_Visitors, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($uuvisitors_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath10);
    while (list($datatype,$circle,$count,$service_id, $DateFormat1) = mysql_fetch_array($uuvisitors_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $ActivationData27 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $datatype . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData27, 3, $fileDumpPath10);
    }
    $insertDump22 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath10 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump22, $LivdbConn) or die(mysql_error());
}


//Clicks_ChannelID (or AffID)
$fileDumpfile18 = "dumpFile8_" . date('ymd') . '.txt';
$fileDumpPath11 = $fileDumpPath . $fileDumpfile18;

$get_Clicks_Visitors = "select count(msisdn),circle, '1411' as service_name,affiliateid,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorLDR1' and datatype='browsing' group by circle,affiliateid,hour(datetime)
UNION
select count(msisdn),circle, '1423' as service_name,affiliateid,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorContest1' and datatype='browsing' group by circle,affiliateid,hour(datetime)";

$clicks_base_query = mysql_query($get_Clicks_Visitors, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($clicks_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath11);
    while (list($count,$circle,$service_id,$affid,$DateFormat1) = mysql_fetch_array($clicks_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
		$datatype='Clicks_'.$affid;
        $ActivationData28 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $datatype . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData28, 3, $fileDumpPath11);
    }
    $insertDump23 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath11 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump23, $LivdbConn) or die(mysql_error());
}

//NOMSISDN_AffID (or AffID)
$fileDumpfile10 = "dumpFile10_" . date('ymd') . '.txt';
$fileDumpPath13 = $fileDumpPath . $fileDumpfile10;

$get_Clicks_NOMSISDNVisitors = "select count(msisdn),circle, '1411' as service_name,affiliateid,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorLDR1' and datatype='browsing' and (msisdn=0 or msisdn='') group by circle,affiliateid,hour(datetime)
UNION
select count(msisdn),circle, '1423' as service_name,affiliateid,adddate(date_format(datetime,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from mis_db.tbl_browsing_wap nolock where date(datetime)='" . $view_date1 . "' and service='WAPUninorContest1' and datatype='browsing' and (msisdn=0 or msisdn='') group by circle,affiliateid,hour(datetime)";

$clicks_NoMSisdnbase_query = mysql_query($get_Clicks_NOMSISDNVisitors, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($clicks_NoMSisdnbase_query);
if ($numRows > 0) {
    unlink($fileDumpPath13);
    while (list($count,$circle,$service_id,$affid,$DateFormat1) = mysql_fetch_array($clicks_NoMSisdnbase_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
		$datatype='NOMSISDN_'.$affid;
        $ActivationData30 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $datatype . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData30, 3, $fileDumpPath13);
    }
    $insertDump25 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump25, $LivdbConn) or die(mysql_error());
}

//Downloads_0
$fileDumpfile19 = "dumpFile9_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile19;

$get_total_downloads = "select count(msisdn),circle,'1411' as service_name,adddate(date_format(date_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_ldr.tbl_ldr_wap_download nolock where date(date_time)='" . $view_date1 . "' group by hour(date_time),circle";

$total_download_query = mysql_query($get_total_downloads, $dbConn212) or die(mysql_error());
$numRows = mysql_num_rows($total_download_query);
if ($numRows > 0) {
    unlink($fileDumpPath12);
    while (list($count,$circle,$service_id,$DateFormat1) = mysql_fetch_array($total_download_query)) {
		if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
		$datatype='Downloads_0';
        $ActivationData29 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $datatype . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData29, 3, $fileDumpPath12);
    }
    $insertDump24 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath12 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump24, $LivdbConn) or die(mysql_error());
}

// sleep for 10 seconds
sleep(10);
$date_Currentthour = date('H');

//delete data for next day default datetime 2013-10-27 00:00:00
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service IN ('" . implode("','", $service_array) . "')";
if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete ".$nextDeleteQuery."<br>";
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}

echo "Current hour is ".$date_Currentthour."<br>";;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' 
and service IN ('" . implode("','", $service_array) . "')";
if($date_Currentthour!='23')
{
if($type!='y')
{
echo $DeleteQuery."<br>";;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}


unlink($fileDumpPath1);
unlink($fileDumpPath12);
unlink($fileDumpPath7);
unlink($fileDumpPath8);
unlink($fileDumpPath9);
unlink($fileDumpPath10);
unlink($fileDumpPath11);
unlink($fileDumpPath12);
unlink($fileDumpPath13);
unlink($fileDumpPath_SUBKIJI);
unlink($fileDumpPathKIJIMode);
mysql_close($LivdbConn);
mysql_close($dbConn212);
echo "generated";
$kpi_process_status = '***************Script end for uninorwapLiveMis******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>