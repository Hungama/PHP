<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
error_reporting(0);
$type = strtolower($_REQUEST['last']);

if (date('H') == '00' || $type == 'y') {
    $type = 'y';
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
//$view_date1='2014-07-21';
//$type='y';
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/inhouse/serviceNameconfig.php");
$kpiPrevfiledate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_" . $kpiPrevfiledate . ".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate = date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_" . $kpifiledate . ".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_Reliance******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
$service_array = array('Reliance54646', 'MTVReliance', 'RelianceCM', 'RelianceMM');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "') 
                    and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";
} else {
    $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') 
                        and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";
}
echo $DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());



$fileDumpfile = "activationReliance1_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime,mode from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id in(1202,1203,1208,1201) 
and plan_id!=95 and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1, $mode) = mysql_fetch_array($query1)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($mode == 'OBD' && $service_id == '1201' && ($event_type == 'TOPUP' || strtolower(trim($event_type)) == 'event')) {
            $charging_str1 = "Activation_" . $charging_amt;
            $revenue = $charging_amt * $count;
        } else {
            if ($event_type == 'RESUB') {
                $charging_str1 = "Renewal_" . $charging_amt;
                $revenue = $charging_amt * $count;
            } elseif ($event_type == 'TOPUP') {
                $charging_str1 = "TOP-UP_" . $charging_amt;
                $revenue = $charging_amt * $count;
            }
        }
        $ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str1 . "|" . $count . "|" . $revenue . "\r\n";
        error_log($ActivationData, 3, $fileDumpPath1);
    }
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump7, $LivdbConn);
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
/// Uninor AA data 
////////////////////////////////////////////////// remove the 1005 FMJ id from this query : show wid//////////////////////// 
$fileDumpfile2 = "activationReliance2_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_activation_query2 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='" . $view_date1 . "' and service_id 
in (1202,1203,1208,1201) and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath12);
    $query21 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
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

////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646///////
////////////////////////////////// Start code to insert the Failure Activation of ACT,REN,TOPUP//////////////////////////

$fileDumpfile3 = "activationReliance3_" . date('ymd') . '.txt';
$fileDumpPath13 = $fileDumpPath . $fileDumpfile3;

$charging_fail = "select count(*),circle,event_type,service_id,plan_id ,adddate(date_format(date_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(date_time)='" . $view_date1 . "'
and service_id IN (1202,1203,1208,1201) 
group by circle,event_type,plan_id,hour(date_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13);
    while (list($count, $circle, $event_type, $service_id, $plan_id, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT";
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN";
        if ($event_type == 'topup' || $event_type == 'TOPUP')
            $faileStr = "FAIL_TOP";
        if ($event_type == 'EVENT')
            $faileStr = "FAIL_EVENT";

        $ActivationData13 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData13, 3, $fileDumpPath13);
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}

$fileDumpfile4 = "activationReliance4_" . date('ymd') . '.txt';
$fileDumpPath14 = $fileDumpPath . $fileDumpfile4;

$charging_fail = "select count(*),circle,event_type,service_id,plan_id,status ,adddate(date_format(date_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(date_time)='" . $view_date1 . "'
and service_id IN (1202,1203,1208,1201) group by circle,event_type,plan_id,status";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath14);

    while (list($count, $circle, $event_type, $service_id, $plan_id, $status, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        $fail_reason = failureReason($status);
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT_" . $fail_reason;
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN_" . $fail_reason;
        if ($event_type == 'topup' || $event_type == 'TOPUP')
            $faileStr = "FAIL_TOP_" . $fail_reason;
        if ($event_type == 'EVENT')
            $faileStr = "FAIL_EVENT";

        $ActivationData14 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        if ($faileStr != '')
            error_log($ActivationData14, 3, $fileDumpPath14);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath14 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump9, $LivdbConn);
}
////////////////////////////////// END code to insert the Charging Failure Activation of ACT,REN,TOPUP//////////////////////////
////////// End the code to insert the data of activation UninorRT////////////////
// Add Uninor Redfm Wapsite into Live Mis
$fileDumpfile5 = "activationReliance5_" . date('ymd') . '.txt';
$fileDumpPath5 = $fileDumpPath . $fileDumpfile5;

$plan_idValuePack = array(195, 196, 197);
$get_activation_query5 = "select count(msisdn),circle,floor(chrg_amount),service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime,mode from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='" . $view_date1 . "' and service_id in(1208,1201) and event_type in('EVENT','Event') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath5);
    while (list($count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1, $mode) = mysql_fetch_array($query5)) {
        if ($mode == 'OBD' && $service_id == '1201') {
            $activation_str51 = "Activation_" . $charging_amt;
        } else {
            $activation_str51 = "EVENT_" . $charging_amt;

            if (in_array($plan_id, $plan_idValuePack))
                $activation_str51 = "EVENT_Valuepack_" . $charging_amt;
        }
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';


        $revenue = $charging_amt * $count;

        $ActivationData18 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str51 . "|" . $count . "|" . $revenue . "\r\n";
        error_log($ActivationData18, 3, $fileDumpPath5);
    }
    $insertDump13 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath5 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump13, $LivdbConn);
}

//////////////////////////////////Start code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////

$fileDumpfile10 = "activationReliance6_" . date('ymd') . '.txt';
$fileDumpPath6 = $fileDumpPath . $fileDumpfile10;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime,mode from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(1208,1201) and event_type in('EVENT','Event') group by circle,service_id,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0) {
    unlink($fileDumpPath6);
    while (list($count, $circle, $service_id, $mode, $plan_id, $hour, $DateFormat1, $mode) = mysql_fetch_array($db_query61)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($mode == 'OBD' && $service_id == '1201') {
            $activation_str61 = "Mode_Activation_" . $mode;
        } else {
            $activation_str61 = "Mode_EVENT_" . $mode;

            if (in_array($plan_id, $plan_idValuePack))
                $activation_str61 = "Mode_EVENT_Valuepack_" . $charging_amt;
        }

        $ActivationData20 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str61 . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData20, 3, $fileDumpPath6);
    }
    $insertDump15 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath6 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump15, $LivdbConn);
}

//////////////////////////////////End the code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
$fileDumpfile11 = "activationReliance7_" . date('ymd') . '.txt';
$fileDumpPath7 = $fileDumpPath . $fileDumpfile11;

$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(1202,1203,1208,1201)
 and event_type in('SUB','RENEW') 
 group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath7);
    while (list($mode_activation_count, $circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {
        $service_name = getServiceName($service_id);

        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $activation_str5 = "Mode_Activation_" . $mode;

        $ActivationData21 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $mode_activation_count . "|" . '0' . "\r\n";
        error_log($ActivationData21, 3, $fileDumpPath7);
    }
    $insertDump16 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath7 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump16, $LivdbConn);
}
////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////
$fileDumpfile15 = "deactivationReliance8_" . date('ymd') . '.txt';
$fileDumpPath8 = $fileDumpPath . $fileDumpfile15;

$get_deactivation_base = "select count(ani),circle,'1202' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1203' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1208' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_cricket.tbl_cricket_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1201' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_music_mania.tbl_MusicMania_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath8);
    while (list($count, $circle, $service_id, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);

        $ActivationData25 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Deactivation_2' . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData25, 3, $fileDumpPath8);
    }
    $insertDump20 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath8 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump20, $LivdbConn);
}

////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////
$fileDumpfile16 = "deactivationRelianceMode9_" . date('ymd') . '.txt';
$fileDumpPath9 = $fileDumpPath . $fileDumpfile16;

$get_deactivation_base = "select count(ani),circle,'1202' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1203' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_hungama.tbl_mtv_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1208' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_cricket.tbl_cricket_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1201' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from reliance_music_mania.tbl_MusicMania_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
// sleep for 10 seconds
sleep(10);
$date_Currentthour = date('H');

//delete data for next day default datetime 2013-10-27 00:00:00
$next_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
/*
  $nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')
  and service IN ('".implode("','",$service_array)."') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";
 */
$nextDeleteQuery = "delete from misdata.livemis where date=date_format('" . $next_date . "','%Y-%m-%d 00:00:00') and service IN ('" . implode("','", $service_array) . "')";


if ($date_Currentthour != '00') {
    if ($type != 'y') {
        echo "Next day data delete" . $nextDeleteQuery;
        $deleteResult12 = mysql_query($nextDeleteQuery, $LivdbConn) or die(mysql_error());
    }
}

echo "Current hour is" . $date_Currentthour;
//$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
if ($date_Currentthour != '23') {
    if ($type != 'y') {
        echo $DeleteQuery;
        $deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
    } else {
        echo 'NOK';
    }
}
unlink($fileDumpPath26);
unlink($fileDumpPath1);
unlink($fileDumpPath21);
unlink($fileDumpPath25);
unlink($fileDumpPath20);
mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_Reliance******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>
