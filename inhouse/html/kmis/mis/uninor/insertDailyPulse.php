<?php
echo "Pulse data Start here";
///////////////////////////////////////start code to insert the data for PULSE_TF for Uninor54646////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1402','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646') and dnis not like '%P%' 
and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulse_tRev = $pulse_t[5] * 3; //NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec,Revenue)
		values('$view_date1', '$pulse_t[0]','$pulse_t[1]','3','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646') 
and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_6',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546466%' and dnis!='5464669' and dnis not like '%P%' 
and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulse_tRev = $pulse_t[5] * 6; //NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec,Revenue)
		values('$view_date1', '$pulse_t[0]','$pulse_t[1]','6','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_6',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis like '546466%'  and dnis!='5464669'
and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T_6";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T_6";
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_9',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '546467%' and dnis not like '%P%' 
and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulse_tRev = $pulse_t[5] * 9; //NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec,Revenue)
		values('$view_date1', '$pulse_t[0]','$pulse_t[1]','9','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_9',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis like '546467%' and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T_9";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T_9";
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546468%' and dnis not like '%P%' 
and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulse_tRev = $pulse_t[5] * 1; //NA
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec,Revenue)
		values('$view_date1', '$pulse_t[0]','$pulse_t[1]','1','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and  dnis like '546468%' and dnis not like '%P%'  and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T_1";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T_1";
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1402','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for Uninor54646////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorKIJI////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and dnis not like '%P%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1423','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1423','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorKIJI////////////////////////////
///////////////////////////////// start code to insert the data for PULSE_TF for UninorPause //////////////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";

        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,
dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) 
values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'UninorPause' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,
status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $p = $pulse_tf[1];
        $pCircle = $pauseArray[$p];
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_T";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_T";

        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1402P','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

//////////////////////////////////////////////////////// end PULSE_TF for UninorPause ///////////////////////////////////////////////////////////
///////////////////////////////////////// start code to insert the data for PULSE_TF for UninorAAV ////////////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','14021','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','14021','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1418','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorAAV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1418','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////// end code to insert the data for PULSE_TF for UninorAAV ////////////////////////////////////////////////////
///////////////////////////////////////// start code to insert the data for PULSE_TF for UninorMS ///////////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1400','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////// end PULSE_TF for UninorMS ////////////////////////////////////////////////////////////
////////////////////////////////////////////// start code to insert the data for PULSE_TF for UninorRiya ////////////////////////////////////////////////
// dnis IN ('5464628','5464626') tbl_54646_calllog //tbl_mnd_calllog
//dnis IN ('5464628', '66291428')  tbl_mnd_calllog

echo "Pulse data IN here";
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628', '66291428') and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1413','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
//dnis IN ('5464628', '66291428')  tbl_mnd_calllog
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'  and dnis IN ('5464628','66291428') and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1413','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/*
//commented on PKP Intergration 9 sep 2014
$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        $pulse_tRev = $pulse_t[5] * 6;
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
values('$view_date1', '$pulse_t[0]','$pulse_t[1]','6','$pulse_t[5]','','1409','NA','$pulse_t[5]','$pulse_tRev')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}

$pulse_t = array();
$pulse_t_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorRia' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0) {
    $pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
    while ($pulse_t = mysql_fetch_array($pulse_t_result)) {
        if ($pulse_t[6] == 1)
            $pulse_t[0] = "L_PULSE_T";
        elseif ($pulse_t[6] != 1)
            $pulse_t[0] = "N_PULSE_T";
        $insert_pulse_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1409','NA','$pulse_t[5]','NA')";
        $queryIns_pulseT = mysql_query($insert_pulse_t_data, $dbConn);
    }
}
*/
////////////////////////////////////////////////////////////// end PULSE_TF for UninorRiya ////////////////////////////////////////////////////////////
//////////////////////////////////////////// start code to insert the data for PULSE_TF for UninorREdfm //////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorREdfm' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1410','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////// end PULSE_TF for UninorREdfm //////////////////////////////////////////////////////////////
////////////////////////////////////////////////// start code to insert the data for PULSE_TF for UninorMTV ///////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorMTV' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1403','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////////// end PULSE_TF for UninorMTV /////////////////////////////////////////////////////////////
////////////////////////////////////////////////// start code to insert the data for PULSE_TF for UninorRT ////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorRT' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1412','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////////// end PULSE_TF for UninorRT //////////////////////////////////////////////////////
//////////////////////////////////////////// start code to insert the data for PULSE_TF for UninorJAD ///////////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorJAD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1416','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorJAD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1416','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////// end PULSE_TF for UninorJAD //////////////////////////////////////////////////////////
///////////////////////////////////////// start code to insert the data for PULSE_TF for UninorCricket ///////////////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'UninorCricket' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_T";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_T";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1408','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// end PULSE_TF for UninorCricket ////////////////////////////////////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorVABollyAlerts////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVABollyAlerts' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1'  and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1430','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVABollyAlerts' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status
from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1430','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorVABollyAlerts////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorVAFilmy////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAFilmy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1431','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAFilmy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1431','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorVAFilmy////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorVABollyMasala////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVABollyMasala' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1'  and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1432','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVABollyMasala' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1432','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorVABollyMasala////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorVAHealth////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAHealth' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse
from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1433','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAHealth' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1433','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorVAHealth////////////////////////////
///////////////////////////////////////start code to insert the data for PULSE_TF for UninorVAFashion////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAFashion' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse
from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1434','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'UninorVAFashion' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status
from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1434','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
echo "Pulse data end here";
///////////////////////////////////////end code to insert the data for PULSE_TF for UninorVAFashion////////////////////////////


//////////////////start code to insert the data for PULSE_TF for UninorReg////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1441','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Uninor54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    $pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = "L_PULSE_TF";
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = "N_PULSE_TF";
        $insert_pulse_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1441','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

//Uninor reg ends here

?>