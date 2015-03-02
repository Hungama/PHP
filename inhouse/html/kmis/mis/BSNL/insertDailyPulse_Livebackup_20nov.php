<?php 
///////////////////////////////////////start code to insert the data for PULSE_TF for BSNL54646////////////////////////////
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1'  and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%')
and operator ='bsnl' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
	$pulse_tRev=$pulse_t[5]*3;//NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec,Revenue) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' 
and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}


$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_4',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546468%')
and operator ='bsnl' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
	$pulse_tRev=$pulse_t[5]*4;//NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec,Revenue) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','4','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_4',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546468%') and operator ='bsnl' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T_4";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T_4";
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

//toll free data start here
$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
	$pulse_tRev=0;//NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec,Revenue) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'BSNL54646' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' 
 and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_TF";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_TF";
        $insert_pulse_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','2202','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for BSNL54646////////////////////////////

?>