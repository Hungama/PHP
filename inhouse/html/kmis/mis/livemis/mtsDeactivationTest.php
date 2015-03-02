<?php

include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
// delete the prevoius record
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$view_time1 = date("h:i:s");
$view_date1 = '2014-07-18';
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

$fileDumpfile_Deact_mode = "mts_deactivationModeTest_" . date('ymd') . '.txt';
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

		echo $DeactivationModeData = $DateFormat1 . "|" . $service_name . "|" . $circle_info[strtoupper($circle)] . "|" . $deactivation_str1 . "|" . $count . "|" . '0' . "\r\n";
        error_log($DeactivationModeData, 3, $fileDumpPathDeact_mode);
		
		
        //$insert_data4 = "insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_format('$DateFormat1', '$service_name','" . $circle_info[strtoupper($circle)] . "','$deactivation_str1','$count',0)";
        //$queryIns = mysql_query($insert_data4, $LivdbConn);
    }
/*	$insertDumpModeDeactivation = 'LOAD DATA LOCAL INFILE "' . $fileDumpPathDeact_mode . '" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
    if(mysql_query($insertDumpModeDeactivation, $LivdbConn))
	echo 'MODE Inserted';
	else
	echo  mysql_error();
*/
}
?>