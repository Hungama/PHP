<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
error_reporting(0);
$type=strtolower($_REQUEST['last']);
/**********************this script contains livemis of Aircel54646 also******************************/
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
//$view_date1='2014-07-21';
//$type='y';
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livedump/';

//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/inhouse/serviceNameconfig.php");

$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLive_Uninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);


$service_array = array('MTVUninor', 'Uninor54646', 'REDFMUninor', 'RIAUninor','Aircel54646', 'UninorRT','UninorAstro', 'AAUninor', 'UninorSU', 'UninorComedy', 'WAPREDFMUninor', 'UninorContest', 'UninorVABollyAlerts', 'UninorVAFilmy', 'UninorVABollyMasala', 'UninorVAHealth', 'UninorVAFashion');


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

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());


$fileDumpfile = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id in(1402,1403,1410,1409,1416,1408,1418,1423,1430,1431,1432,1433,1434) 
and plan_id!=95 and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath1);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query1)) {
        if ($plan_id == 95) {
            $service_id = '14021';
        }
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

/////////// End the code//////////////////////////////////////////////////////

$fileDumpfile1 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath11 = $fileDumpPath . $fileDumpfile1;

$get_activation_query1 = "select  count(msisdn),circle,chrg_amount,'14021',event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' and service_id in(1402) and plan_id=95 and event_type in('RESUB','TOPUP','SUB') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    unlink($fileDumpPath11);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query1)) {
        //if($plan_id == 95) { $service_id = '14021';}
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        if ($event_type == 'SUB') {
            $charging_str1 = "Activation_" . $charging_amt;
            $revenue = $charging_amt * $count;
        }
        if ($event_type == 'RESUB') {
            $charging_str1 = "Renewal_" . $charging_amt;
            $revenue = $charging_amt * $count;
        } elseif ($event_type == 'TOPUP') {
            $charging_str1 = "TOP-UP_" . $charging_amt;
            $revenue = $charging_amt * $count;
        }
        
            $ActivationData1 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str1 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData1, 3, $fileDumpPath11);
        
    }
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath11 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump7, $LivdbConn);
}

/// end here
// SWATI/////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
////////////////////////////////////////////////// remove the 1005 FMJ id from this query : show wid//////////////////////// 
$fileDumpfile2 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_activation_query2 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='" . $view_date1 . "' and service_id 
in (1402,1403,1410,1409,1416,1408,1418,1423,1430,1431,1432,1433,1434) 
and plan_id!=95 and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

$query2 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($query2);
if ($numRows2 > 0) {
    unlink($fileDumpPath12);
    $query21 = mysql_query($get_activation_query2, $dbConn) or die(mysql_error());
    while (list($activation_count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query21)) {
        if ($plan_id == 95) {
            $service_id = '14021';
        }
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

$fileDumpfile3 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath13 = $fileDumpPath . $fileDumpfile3;

$charging_fail = "select count(msisdn),circle,event_type,service_id,adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(response_time)='" . $view_date1 . "'
and service_id IN (1402,1403,1410,1409,1416,1408,1418,1423,1430,1431,1432,1433,1434) 
group by service_id,circle,event_type,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13);
    while (list($count, $circle, $event_type, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($plan_id == 95) {
            $service_id = '14021';
        }
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
		if($faileStr!='')
		{
        error_log($ActivationData13, 3, $fileDumpPath13);
		}
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}

$fileDumpfile4 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath14 = $fileDumpPath . $fileDumpfile4;

$charging_fail = "select count(msisdn),circle,event_type,service_id,status,adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(response_time)='" . $view_date1 . "'
and service_id IN (1402,1403,1410,1409,1416,1408,1418,1423,1430,1431,1432,1433,1434) group by service_id,circle,event_type,status,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath14);

    while (list($count, $circle, $event_type, $service_id, $status,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($plan_id == 95) {
            $service_id = '14021';
        }
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
            $faileStr = "FAIL_EVENT_" . $fail_reason;

        $ActivationData14 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
		if($faileStr!='')
		{
        error_log($ActivationData14, 3, $fileDumpPath14);
		}
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath14 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump9, $LivdbConn);
}
////////////////////////////////// END code to insert the Charging Failure Activation of ACT,REN,TOPUP//////////////////////////
// remove the UninorRT id from this query
$fileDumpfile7 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath17 = $fileDumpPath . $fileDumpfile7;

$get_activation_query5 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='" . $view_date1 . "' and service_id in(1412) and event_type in('SUB','EVENT') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath17);
    while (list($count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query5)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $amt = floor($charging_amt);
        if ($amt < 2)
            $amt1 = 1;
        $amt1 = $amt;


        //$activation_str5="Activation_".$amt1;
        $activation_str5 = "Event_" . $amt1;


            $revenue = $charging_amt * $count;
            $ActivationData17 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str5 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData17, 3, $fileDumpPath17);

    }
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath17 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" (Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump12, $LivdbConn);
}

/////////// End the code to insert the data of activation UninorRT////////////////
// Add Uninor Redfm Wapsite into Live Mis
$fileDumpfile8 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath18 = $fileDumpPath . $fileDumpfile8;

$plan_idValuePack = array(195, 196, 197);
$get_activation_query5 = "select count(msisdn),circle,floor(chrg_amount),service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='" . $view_date1 . "' and service_id in(1410,1409,1402,1430,1431,1432,1433,1434) and event_type in('EVENT','Event') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath18);
    while (list($count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query5)) {
        if ($service_id == '1410') {
            $activation_str51 = "EVENT_FS_" . $charging_amt;
            $service_id = '14101';
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
            error_log($ActivationData18, 3, $fileDumpPath18);
        
    }
    $insertDump13 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath18 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump13, $LivdbConn);
}

/////////// End the code to insert the data of Uninor REdFM Wapsite////////////////
//////////////////////////////////Start the code to activation Record mode wise: uninorRT //////////////////////////////////////////
$fileDumpfile9 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath19 = $fileDumpPath . $fileDumpfile9;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(1412) and event_type in('SUB','EVENT') group by circle,service_id,mode,hour(response_time) order by plan_id";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0) {
    unlink($fileDumpPath19);
    while (list($count, $circle, $service_id, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query61)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        //$activation_str61="Mode_Activation_".$mode;
        $activation_str61 = "Mode_Event_" . $mode;

        
            $ActivationData19 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str61 . "|" . $count . "|" . '0' . "\r\n";
            error_log($ActivationData19, 3, $fileDumpPath19);
        
    }
    $insertDump14 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath19 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump14, $LivdbConn);
}

//////////////////////////////////End the code to activation Record mode wise: uninorRT ///////////////////////////////////////////////
//////////////////////////////////Start code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////

$fileDumpfile10 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath20 = $fileDumpPath . $fileDumpfile10;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(1410,1409,1402,1430,1431,1432,1433,1434) and event_type in('EVENT','Event') group by circle,service_id,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
$numRows61 = mysql_num_rows($db_query61);
if ($numRows61 > 0) {
    unlink($fileDumpPath20);
    while (list($count, $circle, $service_id, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query61)) {
        if ($service_id == '1410')
            $service_id = '14101';
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

//////////////////////////////////End the code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
$fileDumpfile11 = "activationUninor_" . date('ymd') . '.txt';
$fileDumpPath21 = $fileDumpPath . $fileDumpfile11;

$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type, mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(1402,1403,1410,1409,1416,1408,1418,1423,1430,1431,1432,1433,1434)
 and event_type in('SUB','RENEW') 
 group by circle,service_id,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($db_query5);
if ($numRows5 > 0) {
    unlink($fileDumpPath21);
    while (list($mode_activation_count, $circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query5)) {
        if ($plan_id == 95) {
            $service_id = '14021';
        }
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

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////
$fileDumpfile15 = "deactivationUninor_" . date('ymd') . '.txt';
$fileDumpPath25 = $fileDumpPath . $fileDumpfile15;

$get_deactivation_base = "select count(ani),circle,'1402' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id!=95 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'14021' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id=95 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1403' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1410' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_redfm.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1430' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_BollyAlerts.tbl_BA_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1431' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_FilmiWords.tbl_FW_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1432' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_BollywoodMasala.tbl_BM_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1433' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_FilmiHeath.tbl_FH_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1434' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_CelebrityFashion.tbl_CF_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1409' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_manchala.tbl_riya_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1416' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_jyotish.tbl_Jyotish_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'14021' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_Artist_Aloud_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1408' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_cricket.tbl_cricket_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1418' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_comedy_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1418' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) 
from uninor_summer_contest.tbl_contest_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
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


////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////
$fileDumpfile16 = "deactivationModeUninor_" . date('ymd') . '.txt';
$fileDumpPath26 = $fileDumpPath . $fileDumpfile16;

$get_deactivation_base = "select count(ani),circle,'1402' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id!='95' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'14021' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' and plan_id='95' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1403' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1410' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_redfm.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1430' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_BollyAlerts.tbl_BA_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1431' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_FilmiWords.tbl_FW_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1432' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_BollywoodMasala.tbl_BM_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1433' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_FilmiHeath.tbl_FH_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1434' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from Uninor_CelebrityFashion.tbl_CF_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1409' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_manchala.tbl_riya_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1416' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'14021' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1408' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1418' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1418' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from uninor_summer_contest.tbl_contest_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
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

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////

// sleep for 10 seconds
sleep(10);

$date_Currentthour = date('H');
//delete data for next day default datetime 2013-10-27 00:00:00
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
/*
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";*/
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
//$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'Activation%' or type like 'Deactivation_%' or type like 'Mode_Deactivation_%' or type like 'Renewal%' or type like 'Mode_Activation%' or type like 'TOP-UP%' or type like 'EVENT%' or type like 'Event%' or type like 'Mode_EVENT_%' or type like 'FAIL_%')";
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "')";
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

mysql_close($dbConn);
mysql_close($LivdbConn);
echo "generated";
$kpi_process_status = '*******Script end for insertDailyReportLiveAll_Uninor********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>
