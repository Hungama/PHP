<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
// delete the prevoius record
error_reporting(0);
$type=strtolower($_REQUEST['last']);
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1."<br>";
//$view_date1='2015-02-23';

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/inhouse/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/inhouse/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLive_Tata******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);


$service_array = array('TataDoCoMoMX', 'MTVTataDoCoMo', 'TataDoCoMo54646', 'TataDoCoMoFMJ', 'TataDoCoMoMND', 'TataIndicom54646', 'TataDoCoMoMXcdma', 'MTVTataDoCoMocdma', 'TataDoCoMoFMJcdma', 'RIATataDoCoMocdma', 'TataDoCoMoMNDcdma', 'RIATataDoCoMo','TataDoCoMoMXvmi', 'RIATataDoCoMovmi', 'TataDoCoMoMNDvmi', 'REDFMTataDoCoMo', 'REDFMTataDoCoMocdma', 'REDFMTataDoCoMovmi');


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



/////////////////////////////// remove the 1005 FMJ id from this query : show wid ////////////////////////////////////////////

$fileDumpfile = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_activation_query1 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success";
$get_activation_query1 .= " nolock where date(response_time)='" . $view_date1 . "' 
and service_id in(1001,1002,1003,1009,1013,1601,1602,1603,1605,1607,1609,1613,1801,1809,1813,1010,1610,1810) 
and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query1 = mysql_query($get_activation_query1, $dbConn) or die(mysql_error());
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

///start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
////////////////////////////////////////////////// remove the 1005 FMJ id from this query : show wid//////////////////////// 
$fileDumpfile2 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_activation_query2 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock where date(response_time)='" . $view_date1 . "' and service_id 
in (1001,1002,1003,1009,1013,1601,1602,1603,1605,1607,1609,1613,1801,1813,1809,1010,1610,1810) 
and plan_id!=95 and event_type in('SUB','RENEW') group by circle,chrg_amount,service_id, plan_id, hour(response_time)";

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

$fileDumpfile3_Fail = "activationFailTata_" . date('ymd') . '.txt';
$fileDumpPath13_Fail = $fileDumpPath . $fileDumpfile3_Fail;

$charging_fail = "select count(msisdn),circle,event_type,service_id,adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(response_time)='" . $view_date1 . "'
and service_id IN (1001,1002,1003,1009,1013,1601,1602,1603,1605,1607,1609,1613,1801,1813,1809, 1010,1610,1810) 
group by service_id,circle,event_type,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13_Fail);
    while (list($count, $circle, $event_type, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        if ($event_type == 'SUB')
            $faileStr = "FAIL_ACT";
        if ($event_type == 'RESUB')
            $faileStr = "FAIL_REN";
        if ($event_type == 'topup')
            $faileStr = "FAIL_TOP";
		if ($event_type == 'EVENT')
            $faileStr = "FAIL_EVENT";		

        $ActivationData13 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        if($faileStr!='')
		{
		error_log($ActivationData13, 3, $fileDumpPath13_Fail);
		}
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13_Fail . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}
///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
// remove the 1005 FMJ id from this query : show wid 
$fileDumpfile5 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath15 = $fileDumpPath . $fileDumpfile5;

$get_activation_query3 = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query3 .= " where date(response_time)='" . $view_date1 . "' and service_id in(1005) and event_type in('RESUB','TOPUP') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query3 = mysql_query($get_activation_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($query3);
if ($numRows3 > 0) {
    unlink($fileDumpPath15);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query3)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';


        if ($event_type == 'RESUB') {
            if ($plan_id == 20)
                $charging_str3 = "Renewal_Ticket_15";
            elseif ($plan_id == 33)
                $charging_str3 = "Renewal_Ticket_20";
            elseif ($plan_id == 34)
                $charging_str3 = "Renewal_Ticket_10";
            elseif ($plan_id == 19)
                $charging_str3 = "Renewal_Follow_5";
            else
                $charging_str3 = "Renewal_" . $charging_amt;
            //$charging_str="Renewal_".$charging_amt;
            $revenue = $charging_amt * $count;
        }
        elseif ($event_type == 'TOPUP') {
            $charging_str3 = "TOP-UP_" . $charging_amt;
            $revenue = $charging_amt * $count;
        }
        
            $ActivationData15 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str3 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData15, 3, $fileDumpPath15);
        
    }
    $insertDump10 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath15 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump10, $LivdbConn);
}
//start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
// remove the 1005 FMJ id from this query : show wid 
$fileDumpfile6 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath16 = $fileDumpPath . $fileDumpfile6;

$get_activation_query4 = "select count(msisdn),circle,chrg_amount,service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query4 .= " where date(response_time)='" . $view_date1 . "'  and service_id in(1005) and event_type in('SUB') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query4 = mysql_query($get_activation_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($query4);
if ($numRows4 > 0) {
    unlink($fileDumpPath16);
    while (list($count, $circle, $charging_amt, $service_id, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query4)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';


        if ($plan_id == 20)
            $activation_str4 = "Activation_Ticket_15";
        elseif ($plan_id == 33)
            $activation_str4 = "Activation_Ticket_20";
        elseif ($plan_id == 34)
            $activation_str4 = "Activation_Ticket_10";
        elseif ($plan_id == 19)
            $activation_str4 = "Activation_Follow_5";
        else
            $activation_str4 = "Activation_" . $charging_amt;
        
            $revenue = $charging_amt * $count;
            $ActivationData16 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str4 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData16, 3, $fileDumpPath16);
        
    }
    $insertDump11 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath16 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump11, $LivdbConn);
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646////////////////
/////////// End the code to insert the data of activation UninorRT////////////////
// Add Uninor Redfm Wapsite into Live Mis
$fileDumpfile8 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath18 = $fileDumpPath . $fileDumpfile8;

$plan_idValuePack = array(195, 196, 197);
$get_activation_query5 = "select count(msisdn),circle,floor(chrg_amount),service_id,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock";
$get_activation_query5 .= " where date(response_time)='" . $view_date1 . "' and service_id in(1009,1609) and event_type in('EVENT','Event') group by circle,service_id,chrg_amount,plan_id,hour(response_time)";

$query5 = mysql_query($get_activation_query5, $dbConn) or die(mysql_error());
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

/////////// End the code to insert the data of Uninor REdFM Wapsite////////////////
//////////////////////////////////Start code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////

$fileDumpfile10 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath20 = $fileDumpPath . $fileDumpfile10;

$get_mode_activation_query61 = "select count(msisdn),circle,service_id,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query61 .=" where date(response_time)='" . $view_date1 . "' and service_id in(1009,1010,1609) and event_type in('EVENT','Event') group by circle,service_id,event_type,mode order by plan_id,hour(response_time)";

$db_query61 = mysql_query($get_mode_activation_query61, $dbConn) or die(mysql_error());
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

//////////////////////////////////End the code to mode wise: uninor REDFM Wapsite ///////////////////////////////////////////////
//////////////////////////////////Start the code to activation Record mode wise ////////////////////////////////////////////////////////////////////////////
$fileDumpfile11 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath21 = $fileDumpPath . $fileDumpfile11;

$get_mode_activation_query5 = "select count(msisdn),circle,service_id,event_type,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query5 .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(1001,1002,1003,1009,1013,1601,1602,1603,1605,1607,1609,1613,1801,1813,1809,1010,1610,1810)
 and event_type in('SUB','RENEW') 
 group by circle,service_id,event_type,mode,plan_id,hour(response_time) order by event_type";

$db_query5 = mysql_query($get_mode_activation_query5, $dbConn) or die(mysql_error());
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

$fileDumpfile12 = "activationTata_" . date('ymd') . '.txt';
$fileDumpPath22 = $fileDumpPath . $fileDumpfile12;

$get_mode_activation_query6 = "select count(msisdn),circle,service_id,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query6 .=" where date(response_time)='" . $view_date1 . "' and service_id in(1005) and event_type in('SUB') group by circle,service_id,event_type,mode,hour(response_time) order by plan_id";

$db_query6 = mysql_query($get_mode_activation_query6, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($db_query6);
if ($numRows6 > 0) {
    unlink($fileDumpPath22);
    while (list($count, $circle, $service_id, $mode, $revenue, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query6)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        if ($plan_id == 20)
            $activation_str6 = "Mode_Activation_Ticket_15_" . $mode;
        elseif ($plan_id == 33)
            $activation_str6 = "Mode_Activation_Ticket_20_" . $mode;
        elseif ($plan_id == 34)
            $activation_str6 = "Mode_Activation_Ticket_10_" . $mode;
        elseif ($plan_id == 19)
            $activation_str6 = "Mode_Activation_Follow_5_" . $mode;
        else
            $activation_str6 = "Mode_Activation_" . $mode;

              
            $ActivationData22 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str6 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData22, 3, $fileDumpPath22);
        
    }
    $insertDump17 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath22 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump17, $LivdbConn);
}

////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////
$fileDumpfile15 = "deactivationTata_" . date('ymd') . '.txt';
$fileDumpPath25 = $fileDumpPath . $fileDumpfile15;

$get_deactivation_base = "select count(ani),circle,'1001' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_radio.tbl_radio_unsub where date(unsub_date)='" . $view_date1 . "' and plan_id != 40 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1003' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1002' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1005' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_starclub.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1009' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_manchala.tbl_riya_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id!=73 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1013' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_mnd.tbl_character_unsub1
where date(unsub_date)='" . $view_date1 . "' and plan_id='106' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1809' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_manchala.tbl_riya_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id=73 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1601' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1602' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1603' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1609' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_manchala.tbl_riya_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1613' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_mnd.tbl_character_unsub1 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1801' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_radio.tbl_radio_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id = 40 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1813' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_mnd.tbl_character_unsub1
where date(unsub_date)='" . $view_date1 . "' and plan_id='164' group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1010' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id!=72 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1810' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id=72 group by circle,hour(unsub_date)
UNION
select count(ani),circle,'1610' as service_name,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

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


$fileDumpfile16 = "deactivationModeTata_" . date('ymd') . '.txt';
$fileDumpPath26 = $fileDumpPath . $fileDumpfile16;

$get_deactivation_base = "select count(ani),circle,'1001' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_radio.tbl_radio_unsub where date(unsub_date)='" . $view_date1 . "' and plan_id != 40 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1003' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR)
UNION
select count(ani),circle,'1002' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1005' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_starclub.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1009' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_manchala.tbl_riya_unsub where date(unsub_date)='" . $view_date1 . "' and plan_id!=73 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1013' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_mnd.tbl_character_unsub1 where date(unsub_date)='" . $view_date1 . "' and plan_id='106' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1809' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_manchala.tbl_riya_unsub where date(unsub_date)='" . $view_date1 . "' and plan_id=73 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1601' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1602' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_hungama.tbl_jbox_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1603' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_hungama.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1609' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_manchala.tbl_riya_unsub where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1613' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_mnd.tbl_character_unsub1 where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1801' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_radio.tbl_radio_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id = 40 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1813' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_mnd.tbl_character_unsub1
where date(unsub_date)='" . $view_date1 . "' and plan_id='164' group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1010' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id!=72 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1810' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from docomo_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' and plan_id=72 group by circle,unsub_reason,hour(unsub_date)
UNION
select count(ani),circle,'1610' as service_name,unsub_reason,adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) from indicom_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

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
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_Tata******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>
