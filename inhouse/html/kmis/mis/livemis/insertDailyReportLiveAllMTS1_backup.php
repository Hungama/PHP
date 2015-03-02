<?php
error_reporting(1);
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
// delete the prevoius record
$type=strtolower($_REQUEST['last']);
if($type=='y')
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
else
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));

$view_time1 = date("h:i:s");
//echo $view_date1 = '2014-07-19';

$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportLiveAllMTS1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);

$fileDumpPath = '/var/www/html/kmis/mis/livemis/';
function getServiceName($service_id) {
    switch ($service_id) {
        case '1101':
            $service_name = 'MTSMU';
            break;
        case '1124':
            $service_name = 'MTSAC';
            break;
        case '1102':
            $service_name = 'MTS54646';
            break;
        case '1123':
            $service_name = 'MTSContest';
            break;
        case '1125':
            $service_name = 'MTSJokes';
            break;
        case '1126':
            $service_name = 'MTSReg';
            break;
        case '1103':
            $service_name = 'MTVMTS';
            break;
        case '1111':
            $service_name = 'MTSDevo';
            break;
        case '1106':
            $service_name = 'MTSFMJ';
            break;
        case '1110':
            $service_name = 'RedFMMTS';
            break;
        case '1116':
            $service_name = 'MTSVA';
            break;
        case '11012':
            $service_name = 'MTSComedy';
            break;
        case '1113':
            $service_name = 'MTSMND';
            break;
    }
    return $service_name;
}

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh');

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

//$DeleteQuery = "delete from misdata.livemis where date(date)='".$view_date1."'  and service IN ('" . implode("','", $service_array) . "') 
// and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not 
// like 'CNS_%') and type not in('Active_Base','Pending_Base')";
if (strtotime($check_date) == strtotime($view_date1)) {
    echo $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "') 
                    and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not 
                    like 'CNS_%') and type not in('Active_Base','Pending_Base')";
$islastday=false;
} else {
   echo $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') 
                        and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not 
                        like 'CNS_%') and type not in('Active_Base','Pending_Base')";
$islastday=true;
}
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$DeleteQuery2 = "delete from misdata.livemis where date='$DateFormat[0]' and service IN ('" . implode("','", $service_array) . "')  and type in('Active_Base','Pending_Base','CNS_1','CNS_2','CNS_NOTIF')";
$deleteResult12 = mysql_query($DeleteQuery2, $LivdbConn) or die(mysql_error());



///////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////
// remove the 1005 FMJ id from this query : show wid 
$get_activation_query = "select count(msisdn),circle,chrg_amount,service_id,event_type,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_activation_query .= " where date(response_time)='" . $view_date1 . "' 
and service_id in(1101,1124,1102,1125,1103,1111,1106, 1110,1116,1113,1126,1123) and event_type in('SUB','RESUB','TOPUP','EVENT','Event','SUB_RETRY') group by circle,service_id,chrg_amount,event_type,plan_id,hour(response_time)";

$query = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($query);
if ($numRows > 0) {
    while (list($count, $circle, $charging_amt, $service_id, $event_type, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($query)) {

        //echo $count."#".$circle."#".$charging_amt."#".$service_id."#".$event_type."#".$plan_id."#".$hour."#".$DateFormat1."<br>";
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

            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str','$count',$revenue)";
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
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
        } elseif ($event_type == 'TOPUP') {
            $charging_str = "TOPUP_" . $charging_amt;
            $revenue = $charging_amt * $count;
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
        } elseif (strtoupper($event_type) == 'EVENT') {
            $charging_str = "Event_" . $charging_amt;
            $revenue = $charging_amt * $count;
            $insert_data = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$charging_str','$count',$revenue)";
        }


        $queryIns = mysql_query($insert_data, $LivdbConn);
        $event_type = '';
        $activation_str = '';
        $charging_amt = '';
        $insert_data = '';
        $charging_str = '';
        $queryIns = '';
    }
}

/////////// End the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club , Docomo 54646//////////
//////////////////////////////////Start the code to activation Record mode wise //////////////////////////////////////////////////////////

$get_mode_activation_query = "select count(msisdn),circle,service_id,event_type,mode,plan_id,hour(response_time),adddate(date_format(response_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime from master_db.tbl_billing_success nolock ";
$get_mode_activation_query .=" where date(response_time)='" . $view_date1 . "' 
 and service_id in(1101,1124,1102,1125,1103,1111,1106,1110,1116,1113,1126,1123) 
 and event_type in('SUB','EVENT','Event','SUB_RETRY') group by circle,service_id,event_type,mode,hour(response_time) order by event_type,plan_id,hour(response_time)";

$db_query = mysql_query($get_mode_activation_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($db_query);
if ($numRows1 > 0) {
    while (list($count, $circle, $service_id, $event_type, $mode, $plan_id, $hour, $DateFormat1) = mysql_fetch_array($db_query)) {
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

        $insert_data1 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$activation_str1','$count',0)";
        $queryIns = mysql_query($insert_data1, $LivdbConn);
        $service_name = '';
        $event_type = '';
        $activation_str1 = '';
        $insert_data1 = '';
        $queryIns = '';
        $mode = '';
    }
}

//////////////////////////////////End the code to activation Record mode wise ////////////////////////////////////////////////////////////
///////////////////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////

$get_pending_base = "select count(ani),circle,'1101' as service_name from mts_radio.tbl_radio_subscription where status=11 and plan_id!='29' group by circle 
union
select count(ani),circle,'1124' as service_name from mts_radio.tbl_AudioCinema_subscription where status=11 group by circle 
union
select count(ani),circle,'11012' as service_name from mts_radio.tbl_radio_subscription where status=11 and plan_id='29' group by circle 
union
select count(ani),circle,'1102' as service_name from mts_hungama.tbl_jbox_subscription where status=11 group by circle 
union
select count(ani),circle,'1125' as service_name from mts_JOKEPORTAL.tbl_jokeportal_subscription where status=11 group by circle 
union
select count(ani),circle,'1126' as service_name from mts_Regional.tbl_regional_subscription where status=11 group by circle 
union
select count(ani),circle,'1123' as service_name from Mts_summer_contest.tbl_contest_subscription where status=11 group by circle 
union
select count(ani),circle,'1103' as service_name from mts_mtv.tbl_mtv_subscription where status=11 group by circle
union
select count(ani),circle,'1111' as service_name from dm_radio.tbl_digi_subscription where status=11 group by circle
union
select count(ani),circle,'1106' as service_name from mts_starclub.tbl_jbox_subscription where status=11 group by circle
union
select count(ani),circle,'1110' as service_name from mts_redfm.tbl_jbox_subscription where status=11 group by circle
union
select count(ani),circle,'1116' as service_name from mts_voicealert.tbl_voice_subscription where status=11 group by circle
union
select count(ani),circle,'1113' as service_name from mts_mnd.tbl_character_subscription1 where status=11 group by circle";

$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($pending_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_pending_base = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Pending_Base','$count',0)";
        $queryIns_pending = mysql_query($insert_pending_base, $LivdbConn);
        $insert_pending_base = '';
        $queryIns_pending = '';
        $count = '';
        $circle = '';
        $service_id = '';
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////
////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////

$get_active_base = "select count(ani),circle,'1101' as service_name from mts_radio.tbl_radio_subscription where status=1 and plan_id!=29 group by circle 
union
select count(ani),circle,'1124' as service_name from mts_radio.tbl_AudioCinema_subscription where status=1 group by circle 
union
select count(ani),circle,'11012' as service_name from mts_radio.tbl_radio_subscription where status=1 and plan_id=29 group by circle 
union
select count(ani),circle,'1102' as service_name from mts_hungama.tbl_jbox_subscription where status=1 group by circle 
union
select count(ani),circle,'1125' as service_name from mts_JOKEPORTAL.tbl_jokeportal_subscription where status=1 group by circle 
union
select count(ani),circle,'1126' as service_name from mts_Regional.tbl_regional_subscription where status=1 group by circle 
union
select count(ani),circle,'1123' as service_name from Mts_summer_contest.tbl_contest_subscription where status=1 group by circle
union
select count(ani),circle,'1103' as service_name from mts_mtv.tbl_mtv_subscription where status=1 group by circle 
union
select count(ani),circle,'1111' as service_name from dm_radio.tbl_digi_subscription where status=1 group by circle
union
select count(ani),circle,'1106' as service_name from mts_starclub.tbl_jbox_subscription where status=1 group by circle
union
select count(ani),circle,'1110' as service_name from mts_redfm.tbl_jbox_subscription where status=1 group by circle
union
select count(ani),circle,'1116' as service_name from mts_voicealert.tbl_voice_subscription where status=1 group by circle
union
select count(ani),circle,'1113' as service_name from mts_mnd.tbl_character_subscription1 where status=1 group by circle";

$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $service_id) = mysql_fetch_array($active_base_query)) {
        if ($circle_info[strtoupper($circle)] == '')
            $circle_info[strtoupper($circle)] = 'Other';
        $service_name = getServiceName($service_id);
        $insert_data2 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat[0]','%Y-%m-%d %H'),'$service_name' ,'" . $circle_info[strtoupper($circle)] . "','Active_Base','$count',0)";
        $queryIns = mysql_query($insert_data2, $LivdbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////
/////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////
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
		
	//	$insert_data3 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat1','$service_name','" . $circle_info[strtoupper($circle)] . "','Deactivation_2','$count',0)";
      //  mysql_query($insert_data3, $LivdbConn);
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
		
		
        //$insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        //$queryIns = mysql_query($insert_data4, $LivdbConn);
    }
	$insertDumpModeDeactivation = 'LOAD DATA LOCAL INFILE "' . $fileDumpPathDeact_mode . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    if(mysql_query($insertDumpModeDeactivation, $LivdbConn))
	echo 'MODE Inserted';
	else
	echo  mysql_error();
}

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

$date_Currentthour = date('H');
//delete data for next day default datetime 2013-10-27 00:00:00
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00')  
and service IN ('".implode("','",$service_array)."') and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not like 'CNS_%') and type not in('Active_Base','Pending_Base')";
echo "<br>";

if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}


echo "Current hour is".$date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type not like 'CALLS%' and type not like 'PULSE%' and type not like 'UU%' and type not like 'SEC%' and type not like 'MOU%' and type not 
                    like 'CNS_%') and type not in('Active_Base','Pending_Base')";
if($date_Currentthour!='23')
{
if($type!='y')
{
echo "Next hour data delete-".$DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}
//////////////////////////////////////////Notification consent logs end here //////////////////////////////////////

echo "generated";
mysql_close($dbConn);
$kpi_process_status = '***************Script end for insertDailyReportLiveAllMTS1******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>