<?php
//////////////////////////////////////////// start code to insert the data for call_tf for BSNL54646 /////////////////////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'BSNL54646' as service_name,date(call_date) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'BSNL54646' as service_name,date(call_date),status from mis_db.tbl_bsnl_54646_calllog
where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
        pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}


$call_t = array();
$call_t_query = "select 'CALLS_T_4',circle, count(id),'BSNL54646' as service_name,date(call_date) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546468%') and operator ='bsnl' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T_4',circle, count(id),'BSNL54646' as service_name,date(call_date),status from mis_db.tbl_bsnl_54646_calllog
where date(call_date)='$view_date1' and (dnis like '546468%') and operator ='bsnl' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T_4";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T_4";
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
        pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

//toll free data start here
$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'BSNL54646' as service_name,date(call_date) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_TF',circle, count(id),'BSNL54646' as service_name,date(call_date),status from mis_db.tbl_bsnl_54646_calllog
where date(call_date)='$view_date1' and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_TF";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_TF";
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
        pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2202','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

////////////////////////////////////////////////////////// end call_tf for BSNL54646 ////////////////////////////////////////////////////////
//BSNL PKP Start here

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'BSNLPKP' as service_name,date(call_date) from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and dnis='546464' and operator ='bsnl' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2213','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'BSNLPKP' as service_name,date(call_date),status from mis_db.tbl_mnd_calllog
where date(call_date)='$view_date1' and dnis='546464' and operator ='bsnl' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
        pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','2213','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
//end here
?>