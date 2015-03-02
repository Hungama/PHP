<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNLAll.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$stype = $_REQUEST['stype'];
if ($stype == 'NH') {
    $dbConn_BSNL = $dbConn_BSNL_North;
} else if ($stype == 'SH') {
    $dbConn_BSNL = $dbConn_BSNL_South;
} else {
    $dbConn_BSNL = $dbConn_BSNL_North;
}
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$view_time1 = date("h:i:s");
//$view_date1='2013-10-10';
$fileDumpPath = '/var/www/html/kmis/mis/livedump/BSNL';

$kpiprocessfile = "livekpiprocess.txt";
$file_process_status = '***************Script start for insertDailyReportLiveAllBSNL1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $kpiprocessfile);

function getServiceName($service_id) {
    switch ($service_id) {
        case '2202':
            $service_name = 'BSNL54646';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh',
    'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');

$getCurrentTimeQuery = "select now()";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery = "select date_format('" . $currentTime[0] . "','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery, $dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);

if ($_GET['time']) {
    $DateFormat[0] = $_GET['time'];
}

//echo $DateFormat[0] = '2013-10-10 23:00:00';

$service_array = array('BSNL54646');

////////////////////////////////////////////////////// delete privious record code start here //////////////////////////////////////////////////////////////
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and date>'" . $view_date1 . " 00:00:00' and 
    service IN ('" . implode("','", $service_array) . "') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%'
        or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or 
        type like 'Mode_EVENT_%')";
//$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
////////////////////////////////////////////////////// delete privious record code end here//////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// insert RESUB,TOPUP code start here ////////////////////////////////////////////////
$fileDumpfile = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id = '2202' and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn_BSNL) or die(mysql_error());
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
////////////////////////////////////////////////////////////// insert RESUB,TOPUP code end here ////////////////////////////////////////////////
////////////////////////////////////////////////////////////// insert SUB,RENEW code start here ////////////////////////////////////////////////
$fileDumpfile2 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_activation_query2 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock
    where date(response_time)='" . $view_date1 . "' and service_id 
in (2202) and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_query2, $dbConn_BSNL) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath12);
    $query21 = mysql_query($get_activation_query2, $dbConn_BSNL) or die(mysql_error());
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
////////////////////////////////////////////////////////////// insert RESUB,TOPUP code end here ////////////////////////////////////////////////
////////////////////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code start here ////////////////////////////////////////////////
$fileDumpfile3 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath13 = $fileDumpPath . $fileDumpfile3;

$charging_fail = "select count(*),circle,event_type,service_id,plan_id  from master_db.tbl_billing_failure nolock 
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service_id IN (2202) group by circle,event_type,plan_id";

$deactivation_base_query = mysql_query($charging_fail, $dbConn_BSNL) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13);
    while (list($count, $circle, $event_type, $service_id, $plan_id) = mysql_fetch_array($deactivation_base_query)) {

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT";
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN";
        if ($event_type == 'topup')
            $faileStr = "FAIL_TOP";

        $ActivationData13 = $DateFormat[0] . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData13, 3, $fileDumpPath13);
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}
////////////////////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code end here ///////////////////////////////////////////////
////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code with fail reason start here ///////////////////////////////////////////////
$fileDumpfile4 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath14 = $fileDumpPath . $fileDumpfile4;

$charging_fail = "select count(*),circle,event_type,service_id,plan_id,status  from master_db.tbl_billing_failure nolock 
where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
and service_id IN (2202) group by circle,event_type,plan_id,status";

$deactivation_base_query = mysql_query($charging_fail, $dbConn_BSNL) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath14);

    while (list($count, $circle, $event_type, $service_id, $plan_id, $status) = mysql_fetch_array($deactivation_base_query)) {

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        $fail_reason = failureReason($status);
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT_" . $fail_reason;
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN_" . $fail_reason;
        if ($event_type == 'topup')
            $faileStr = "FAIL_TOP_" . $fail_reason;

        $ActivationData14 = $DateFormat[0] . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData14, 3, $fileDumpPath14);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath14 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump9, $LivdbConn);
}
////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code with fail reason end here ////////////////////////////////////
//////////////////////////////////////////////////////////// insert Event code start here /////////////////////////////////////////////////////
$fileDumpfile8 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath18 = $fileDumpPath . $fileDumpfile8;

$plan_idValuePack = array(195, 196, 197);
$get_activation_query5 = "select count(msisdn),circle,floor(chrg_amount),service_id,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='" . $view_date1 . "' and service_id in(2202) and event_type in('EVENT','Event') 
    group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn_BSNL) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath18);
    while (list($count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query5)) {

        $activation_str51 = "EVENT_" . $charging_amt;

        if (in_array($plan_id, $plan_idValuePack))
            $activation_str51 = "EVENT_Valuepack_" . $charging_amt;

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        $revenue = $charging_amt * $count;

        $ActivationData18 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str51 . "|" . $count . "|" . $revenue . "\r\n";
        error_log($ActivationData18, 3, $fileDumpPath18);
    }
    $insertDump13 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath18 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump13, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Event code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert Mode Event code start here /////////////////////////////////////////////////////
$fileDumpfile10 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath20 = $fileDumpPath . $fileDumpfile10;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(2202) and event_type in('EVENT','Event') 
    group by circle,service_id,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn_BSNL) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0) {
    unlink($fileDumpPath20);
    while (list($count, $circle, $service_id, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query61)) {

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        $activation_str61 = "Mode_EVENT_" . $mode;

        if (in_array($plan_id, $plan_idValuePack))
            $activation_str61 = "Mode_EVENT_Valuepack_" . $charging_amt;

        $ActivationData20 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str61 . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData20, 3, $fileDumpPath20);
    }
    $insertDump15 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath20 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump15, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Mode Event code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert Mode Activation code start here ////////////////////////////////////////////////////////
$fileDumpfile11 = "southactivation_" . date('ymd') . 'txt';
$fileDumpPath21 = $fileDumpPath . $fileDumpfile11;

$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(2202) and event_type in('SUB','RENEW') group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn_BSNL) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath21);
    while (list($mode_activation_count, $circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {

        $service_name = getServiceName($service_id);

        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $activation_str5 = "Mode_Activation_" . $mode;

        $ActivationData21 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $mode_activation_count . "|" . '0' . "\r\n";
        error_log($ActivationData21, 3, $fileDumpPath21);
    }
    $insertDump16 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath21 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump16, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Mode Activation code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert pending Base code start here /////////////////////////////////////////////////////
$fileDumpfile13 = "southactivation_" . date('ymd') . '.txt';
$fileDumpPath23 = $fileDumpPath . $fileDumpfile13;

$get_pending_base = "select count(ani),circle,'2202' as service_name from BSNL_hungama.tbl_jbox_subscription where  status IN (11,0,5) 
    group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConn_BSNL) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    unlink($fileDumpPath23);
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";

        $ActivationData23 = $DateFormat[0] . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Pending_Base' . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData23, 3, $fileDumpPath23);
    }
    $insertDump18 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath23 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump18, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert pending Base code end here ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert Active Base code start here ///////////////////////////////////////////////////////////
$fileDumpfile14 = "southactivation_" . date('ymd') . '.txt';
$fileDumpPath24 = $fileDumpPath . $fileDumpfile14;

$get_active_base = "select count(ani),circle,'2202' as service_name from BSNL_hungama.tbl_jbox_subscription where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConn_BSNL) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath24);
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) { //echo $service_id.",";
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);


        $ActivationData24 = $DateFormat[0] . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Active_Base' . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData24, 3, $fileDumpPath24);
    }
    $insertDump19 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath24 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump19, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Active Base code end here /////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert Deactivation code start here /////////////////////////////////////////////////////
$fileDumpfile15 = "southdeactivation_" . date('ymd') . '.txt';
$fileDumpPath25 = $fileDumpPath . $fileDumpfile15;

$get_deactivation_base = "select count(ani),circle,'2202' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
    from BSNL_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn_BSNL) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath25);
    while (list($count, $circle, $service_id, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);

        $ActivationData25 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Deactivation_2' . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData25, 3, $fileDumpPath25);
    }
    $insertDump20 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath25 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump20, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Deactivation code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert MODE Deactivation code start here /////////////////////////////////////////////////////
$fileDumpfile16 = "southdeactivationMode_" . date('ymd') . '.txt';
$fileDumpPath26 = $fileDumpPath . $fileDumpfile16;

$get_deactivation_base = "select count(ani),circle,'2202' as service_name,unsub_reason,
    adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from BSNL_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "'  group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn_BSNL) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    unlink($fileDumpPath26);
    while (list($count, $circle, $service_id, $unsub_reason, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $ActivationData26 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $deactivation_str1 . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData26, 3, $fileDumpPath26);
    }
    $insertDump21 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath26 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump21, $LivdbConn) or die(mysql_error());
}
//////////////////////////////////////////////////////////// insert MODE Deactivation code end here //////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($dbConn_BSNL);
mysql_close($LivdbConn);
echo "South Script generated";
$file_process_status = '***************Script end for insertDailyReportLiveAll1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $kpiprocessfile);
// end 
?>