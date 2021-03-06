<?php

include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNL.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

error_reporting(0);
$type = strtolower($_REQUEST['last']);
if (date('H') == '00' || $type == 'y') {
    $type = 'y';
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/bsnl/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/bsnl/serviceNameconfig.php");
$kpiPrevfiledate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/bsnl/livekpi_" . $kpiPrevfiledate . ".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate = date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/bsnl/livekpi_" . $kpifiledate . ".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_BSNL******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('BSNL54646');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));

if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'   and service IN ('" . implode("','", $service_array) . "')   and (type not like 'CALLS%' and type not like 'CNS_%')";
} else {
    $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') and (type not like 'CALLS%' and type not like 'CNS_%')";
}
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

//get South LIVE MIS START HERe
$generateSouthMIS = "http://192.168.100.212/kmis/mis/livemis/mis2.0/bsnl/insertDailyReportLiveAllBSNL1_south.php?stype=SH&last=" . $type;
$curl_call = curl_init($generateSouthMIS);
curl_setopt($curl_call, CURLOPT_RETURNTRANSFER, TRUE);
$api_exec_sms = curl_exec($curl_call);
curl_close($curl_call);
echo $api_exec_sms;
//South LIVE MIS End here
////////////////////////////////////////////////////// delete privious record code end here//////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// insert RESUB,TOPUP code start here ////////////////////////////////////////////////
$fileDumpfile = "activation_" . date('ymd') . 'txt';
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
$fileDumpfile2 = "activation_" . date('ymd') . 'txt';
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
$fileDumpfile3 = "activation_" . date('ymd') . 'txt';
$fileDumpPath13 = $fileDumpPath . $fileDumpfile3;

//$charging_fail = "select count(*),circle,event_type,service_id,plan_id  from master_db.tbl_billing_failure nolock 
//where date_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '$DateFormat[0]' 
//and service_id IN (2202) group by circle,event_type,plan_id";
$charging_fail = "select count(*),circle,event_type,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime
from master_db.tbl_billing_failure nolock 
where date(response_time) = '" . $view_date1 . "'
and service_id IN (2202) group by circle,event_type,plan_id,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn_BSNL) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13);
    while (list($count, $circle, $event_type, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT";
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN";
        if ($event_type == 'topup')
            $faileStr = "FAIL_TOP";

        $ActivationData13 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData13, 3, $fileDumpPath13);
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}
////////////////////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code end here ///////////////////////////////////////////////
////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code with fail reason start here ///////////////////////////////////////////////
$fileDumpfile4 = "activation_" . date('ymd') . 'txt';
$fileDumpPath14 = $fileDumpPath . $fileDumpfile4;

$charging_fail = "select count(*),circle,event_type,service_id,plan_id,status,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime
from master_db.tbl_billing_failure nolock 
where date(response_time) = '" . $view_date1 . "'
and service_id IN (2202) group by circle,event_type,plan_id,status,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn_BSNL) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath14);

    while (list($count, $circle, $event_type, $service_id, $plan_id, $status, $hour, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {

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

        $ActivationData14 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        error_log($ActivationData14, 3, $fileDumpPath14);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath14 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump9, $LivdbConn);
}
////////////////////////////////////////////// insert SUB,RESUB,TOPUP failure code with fail reason end here ////////////////////////////////////
//////////////////////////////////////////////////////////// insert Event code start here /////////////////////////////////////////////////////
$fileDumpfile8 = "activation_" . date('ymd') . 'txt';
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
$fileDumpfile10 = "activation_" . date('ymd') . 'txt';
$fileDumpPath20 = $fileDumpPath . $fileDumpfile10;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(2202) and event_type in('EVENT','Event') 
    group by circle,service_id,event_type,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn_BSNL) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0) {
    unlink($fileDumpPath20);
    while (list($count, $circle, $service_id, $mode, $revenue, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query61)) {

        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        $activation_str61 = "Mode_EVENT_" . $mode;

        if (in_array($plan_id, $plan_idValuePack))
            $activation_str61 = "Mode_EVENT_Valuepack_" . $charging_amt;

        $ActivationData20 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str61 . "|" . $count . "|" . $revenue . "\r\n";
        error_log($ActivationData20, 3, $fileDumpPath20);
    }
    $insertDump15 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath20 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump15, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Mode Event code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert Mode Activation code start here ////////////////////////////////////////////////////////
$fileDumpfile11 = "activation_" . date('ymd') . 'txt';
$fileDumpPath21 = $fileDumpPath . $fileDumpfile11;

$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),
    adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(2202) and event_type in('SUB','RENEW') group by circle,service_id,event_type,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn_BSNL) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath21);
    while (list($mode_activation_count, $circle, $service_id, $event_type, $mode, $revenue, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {

        $service_name = getServiceName($service_id);

        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $activation_str5 = "Mode_Activation_" . $mode;

        $ActivationData21 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $mode_activation_count . "|" . $revenue . "\r\n";
        error_log($ActivationData21, 3, $fileDumpPath21);
    }
    $insertDump16 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath21 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump16, $LivdbConn);
}
//////////////////////////////////////////////////////////// insert Mode Activation code end here /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////// insert pending Base code start here /////////////////////////////////////////////////////
$fileDumpfile13 = "activation_" . date('ymd') . '.txt';
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
$fileDumpfile14 = "activation_" . date('ymd') . '.txt';
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
$fileDumpfile15 = "deactivation_" . date('ymd') . '.txt';
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
$fileDumpfile16 = "deactivationMode_" . date('ymd') . '.txt';
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
// sleep for 10 seconds
sleep(10);
$date_Currentthour = date('H');

//delete data for next day default datetime 2013-10-27 00:00:00
$next_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
$nextDeleteQuery = "delete from misdata.livemis where date=date_format('" . $next_date . "','%Y-%m-%d 00:00:00') and service IN ('" . implode("','", $service_array) . "')";


if ($date_Currentthour != '00') {
    if ($type != 'y') {
        echo "Next day data delete" . $nextDeleteQuery;
        $deleteResult12 = mysql_query($nextDeleteQuery, $LivdbConn) or die(mysql_error());
    }
}

echo "Current hour is" . $date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type not like 'CALLS%' and type not like 'CNS_%')";
if ($date_Currentthour != '23') {
    if ($type != 'y') {
        echo $DeleteQuery;
        $deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
    } else {
        echo 'NOK';
    }
}

mysql_close($dbConn);
mysql_close($dbConn_BSNL);
mysql_close($LivdbConn);
echo "generated";
$file_process_status = '***************Script end for insertDailyReportLiveAll1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $kpiprocessfile);
// end 
/*
  $generateSouthMIS = "http://192.168.100.212/kmis/mis/livemis/insertDailyReportLiveAllBSNL1_south.php?stype=SH";
  $curl_call = curl_init($generateSouthMIS);
  curl_setopt($curl_call, CURLOPT_RETURNTRANSFER, TRUE);
  $api_exec_sms = curl_exec($curl_call);
  curl_close($curl_call);
  echo $api_exec_sms;
 */
?>
