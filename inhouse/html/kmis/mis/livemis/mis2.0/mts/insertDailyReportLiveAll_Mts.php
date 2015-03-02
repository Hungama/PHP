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
$kpi_process_status = '***************Script start for insertDailyReportLiveAll_Mts******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$service_array = array('MTSMU', 'MTS54646', 'MTSContest', 'MTSJokes', 'MTS Regional', 'MTVMTS', 'MTSDevo', 'MTSFMJ', 'RedFMMTS', 'MTSVA', 'MTSComedy', 'MTSMND', 'MTSAC', 'MTSReg','MTSSU');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));

if (strtotime($check_date) == strtotime($view_date1)) {
 $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'   and service IN ('" . implode("','", $service_array) . "')   and (type not like 'CALLS%' and type not like 'CNS_%')";
} else {
$DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') and (type not like 'CALLS%' and type not like 'CNS_%')";
}
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$fileDumpfile = "activationMts1_" . date('ymd') . '.txt';
$fileDumpPath1 = $fileDumpPath . $fileDumpfile;

$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where date(response_time)='" . $view_date1 . "' 
and service_id in(1101,1124,1102,1125,1103,1111,1106, 1110,1116,1113,1126,1123,1108) and event_type in('SUB','RESUB','TOPUP','EVENT','Event','SUB_RETRY') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
unlink($fileDumpPath1);
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query)) {

       if ($plan_id == '29' && $service_id == '1101')
            $service_id = '11012';
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';

        if ($event_type == 'SUB' || $event_type =='SUB_RETRY') {
            $revenue = $charging_amt * $count;
            $activation_str = "Activation_" . $charging_amt;
            if ($plan_id == 11 && $service_id == 1106) {
                $activation_str = "Activation_Ticket_20"; //.$mode; 
            } elseif ($plan_id == 12 && $service_id == 1106) {
                $activation_str = "Activation_Ticket_15"; //.$mode; 
            } elseif ($plan_id == 13 && $service_id == 1106) {
                $activation_str = "Activation_Ticket_10"; //.$mode; 
            } elseif ($plan_id == 19 && $service_id == 1106) {
                $activation_str = "Activation_Ticket_5"; //.$mode; 
            } else {
                $activation_str = "Activation_" . $charging_amt;
            }

         //   $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str','$count',$revenue)";
			$ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str . "|" . $count . "|" . $revenue . "\r\n";
            
			
        } elseif ($event_type == 'RESUB') {
            $charging_str = "Renewal_" . $charging_amt;
            if ($plan_id == 11 && $service_id == 1106) {
                $charging_str = "Renewal_Ticket_20"; //.$mode; 
            } elseif ($plan_id == 12 && $service_id == 1106) {
                $charging_str = "Renewal_Ticket_15"; //.$mode; 
            } elseif ($plan_id == 13 && $service_id == 1106) {
                $charging_str = "Renewal_Ticket_10"; //.$mode; 
            } elseif ($plan_id == 19 && $service_id == 1106) {
                $charging_str = "Renewal_Ticket_5"; //.$mode; 
            } else {
                $charging_str = "Renewal_" . $charging_amt;
            }

            $revenue = $charging_amt * $count;
            //$insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
			$ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str . "|" . $count . "|" . $revenue . "\r\n";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOPUP_" . $charging_amt;
            $revenue = $charging_amt * $count;
            //$insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
			$ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str . "|" . $count . "|" . $revenue . "\r\n";
        } elseif (strtoupper($event_type) == 'EVENT') {
            $charging_str = "Event_" . $charging_amt;
            $revenue = $charging_amt * $count;
            //$insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
			$ActivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $charging_str . "|" . $count . "|" . $revenue . "\r\n";
        }

		error_log($ActivationData, 3, $fileDumpPath1);
     //   $queryIns = mysql_query($insert_data, $LivdbConn);
        $event_type = '';
        $activation_str = '';
        $charging_amt = '';
        $insert_data = '';
        $charging_str = '';
        $queryIns = '';
    }
	    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
	if(mysql_query($insertDump7, $LivdbConn))
	echo 'Activation-Renewal All data Inserted';
	else
	echo  mysql_error();
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646//////////
//////////////////////////////////Start the code to activation Record mode wise //////////////////////////////////////////////////////////

$fileDumpfile2 = "activationMts2_" . date('ymd') . '.txt';
$fileDumpPath12 = $fileDumpPath . $fileDumpfile2;

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,sum(chrg_amount) as revenue,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(1101,1124,1102,1125,1103,1111,1106,1110,1116,1113,1126,1123,1108) 
 and event_type in('SUB','EVENT','Event','SUB_RETRY') group by circle,service_id,event_type,mode,hour(response_time) order by event_type,plan_id,hour(response_time)";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0) {
unlink($fileDumpPath12);
    while (list($count, $circle, $service_id, $event_type, $mode, $revenue, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query)) {
        if ($plan_id == '29' && $service_id == '1101')
            $service_id = '11012';
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $activation_str1 = "Mode_Activation_" . $mode;

        if ($plan_id == 11 && $service_id == 1106) {
            $activation_str1 = "Mode_Activation_Ticket_20" . $mode;
        } elseif ($plan_id == 12 && $service_id == 1106) {
            $activation_str1 = "Mode_Activation_Ticket_15" . $mode;
        } elseif ($plan_id == 13 && $service_id == 1106) {
            $activation_str1 = "Mode_Activation_Ticket_10" . $mode;
        } elseif ($plan_id == 19 && $service_id == 1106) {
            $activation_str1 = "Mode_Activation_Ticket_5" . $mode;
        } elseif ($event_type == 'SUB' || $event_type == 'SUB_RETRY') {
            $activation_str1 = "Mode_Activation_" . $mode;
        } elseif (strtoupper($event_type) == 'EVENT') {
            $activation_str1 = "Mode_Event_" . $mode;
        }
		
        //$insert_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str1','$count',0)";
		
		$ActivationData12 = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $activation_str1 . "|" . $count . "|" . $revenue . "\r\n";
            error_log($ActivationData12, 3, $fileDumpPath12);
			
        //$queryIns = mysql_query($insert_data1, $LivdbConn);
        $service_name = '';
        $event_type = '';
        $activation_str1 = '';
        $insert_data1 = '';
        $queryIns = '';
        $mode = '';
    }
	 $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath12 . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    if(mysql_query($insertDump7, $LivdbConn))
	echo 'Mode Wise data Inserted';
	else
	echo  mysql_error();
	
}

/////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////
$fileDumpfile_Deact = "mts_deactivation_" . date('ymd') . '.txt';
$fileDumpPathDeact = $fileDumpPath . $fileDumpfile_Deact;

$get_deactivation_base = "select count(ani),circle,'1101' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id!=29 group by circle,hour(unsub_date)
union
select count(ani),circle,'1124' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_AudioCinema_unsub
where date(unsub_date)='" . $view_date1 . "' and status=1 group by circle,hour(unsub_date)
union
select count(ani),circle,'11012' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id=29 group by circle,hour(unsub_date)
union
select count(ani),circle,'1102' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1125' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_JOKEPORTAL.tbl_jokeportal_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1123' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from Mts_summer_contest.tbl_contest_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1126' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_Regional.tbl_regional_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1103' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_mtv.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1111' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from dm_radio.tbl_digi_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1106' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_starclub.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1110' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1116' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_voicealert.tbl_voice_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1113' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_mnd.tbl_character_unsub1
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)
union
select count(ani),circle,'1108' as service_name,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from MTS_cricket.tbl_cricket_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,hour(unsub_date)";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
unlink($fileDumpPathDeact);
    while (list($count, $circle, $service_id, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
	 $DeactivationData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . 'Deactivation_2' . "|" . $count . "|" . '0' . "\r\n";
        error_log($DeactivationData, 3, $fileDumpPathDeact);
		
   }
	$insertDumpDeactivation = 'LOAD DATA LOCAL INFILE "' . $fileDumpPathDeact . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    if(mysql_query($insertDumpDeactivation, $LivdbConn))
	echo 'Deactivation Inserted';
	else
	echo  mysql_error();
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base = "select count(ani),circle,'1101' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id!=29 group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1124' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_AudioCinema_unsub 
where date(unsub_date)='" . $view_date1 . "' and status=1 group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'11012' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_radio.tbl_radio_unsub 
where date(unsub_date)='" . $view_date1 . "' and plan_id=29 group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1002' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_hungama.tbl_jbox_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1125' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_JOKEPORTAL.tbl_jokeportal_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1123' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from Mts_summer_contest.tbl_contest_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1126' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_Regional.tbl_regional_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1003' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_mtv.tbl_mtv_unsub 
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1111' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from dm_radio.tbl_digi_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1106' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_starclub.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1110' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_redfm.tbl_jbox_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1116' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_voicealert.tbl_voice_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1113' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from mts_mnd.tbl_character_unsub1
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)
union
select count(ani),circle,'1108' as service_name,unsub_reason,SUBSTRING(adddate(date_format(unsub_date,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR),1,19) from MTS_cricket.tbl_cricket_unsub
where date(unsub_date)='" . $view_date1 . "' group by circle,unsub_reason,hour(unsub_date)";

$fileDumpfile_Deact_mode = "mts_deactivationMode_" . date('ymd') . '.txt';
$fileDumpPathDeact_mode = $fileDumpPath . $fileDumpfile_Deact_mode;

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
unlink($fileDumpPathDeact_mode);
    while (list($count, $circle, $service_id, $unsub_reason, $DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

		$DeactivationModeData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $deactivation_str1 . "|" . $count . "|" . '0' . "\r\n";
        error_log($DeactivationModeData, 3, $fileDumpPathDeact_mode);
		
   }
	$insertDumpModeDeactivation = 'LOAD DATA LOCAL INFILE "' . $fileDumpPathDeact_mode . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    if(mysql_query($insertDumpModeDeactivation, $LivdbConn))
	echo 'MODE Inserted';
	else
	echo  mysql_error();
}

////////////////////////////////// Start code to insert the Failure Activation of ACT,REN,TOPUP//////////////////////////

$fileDumpfile3_Fail = "activationFailMts_" . date('ymd') . '.txt';
$fileDumpPath13_Fail = $fileDumpPath . $fileDumpfile3_Fail;

$charging_fail = "select count(msisdn),circle,event_type,service_id,adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime  from master_db.tbl_billing_failure nolock 
where date(response_time)='" . $view_date1 . "'
and service_id IN (1101,1124,1102,1125,1103,1111,1106, 1110,1116,1113,1126,1123,1108) 
group by service_id,circle,event_type,hour(response_time)";

$deactivation_base_query = mysql_query($charging_fail, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query);
if ($numRows3 > 0) {
    unlink($fileDumpPath13_Fail);
    while (list($count, $circle, $event_type, $service_id,$DateFormat1) = mysql_fetch_array($deactivation_base_query)) {
        $service_name = getServiceName($service_id);
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
			$event_type=trim($event_type);
		if ($event_type == 'SUB' || $event_type == 'SUB_RETRY')
		{
            $faileStr = "FAIL_ACT";
		}
        else if ($event_type == 'RESUB' || $event_type == 'Resub_Fail' || $event_type == 'Resub_Retry_Fail' || $event_type == 'Grace')
		{
            $faileStr = "FAIL_REN";
		}
        else if ($event_type == 'TOPUP')
        { 
		$faileStr = "FAIL_TOP"; 
		}
		else if ($event_type == 'EVENT')
            {
			$faileStr = "FAIL_EVENT";
			}

        $ActivationDataFail = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $faileStr . "|" . $count . "|" . '0' . "\r\n";
        if($faileStr!='')
		{
		error_log($ActivationDataFail, 3, $fileDumpPath13_Fail);
		}
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath13_Fail . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    mysql_query($insertDump8, $LivdbConn);
}



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
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type not like 'CALLS%' and type not like 'CNS_%')";
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
unlink($fileDumpPathDeact_mode);
unlink($fileDumpPathDeact);
unlink($fileDumpPath1);
unlink($fileDumpPath12);
unlink($fileDumpPath13_Fail);
echo "generated";
$kpi_process_status = '***************Script end for insertDailyReportLiveAll_MTS******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>