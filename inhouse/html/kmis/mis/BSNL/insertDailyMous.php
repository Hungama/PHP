<?php

/////////////////////////////////////// start code to insert the data for mous_tf for BSNL54646 ////////////////////////////////////////////////////
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator ='bsnl' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%')  and operator ='bsnl' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        else
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}


$mous_t = array();
$mous_t_query = "select 'MOU_T_4',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546468%') and operator ='bsnl' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T_4',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546468%')  and operator ='bsnl' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T_4";
        else
            $mous_t[0] = "N_MOU_T_4";
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

//insert toll free calls data

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546461%' 
or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'BSNL54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546461%' 
or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator ='bsnl' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_TF";
        else
            $mous_t[0] = "N_MOU_TF";
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2202','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
///////////////////////////////////////////////////

//BSNL PKP total mou code here

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'BSNLPKP' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis='546464' and operator ='bsnl' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2213','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'BSNLPKP' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis='546464' and operator ='bsnl' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        else
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','2213','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}




/////////////////////////////////////// end code to insert the data for mous_tf for BSNL54646 ////////////////////////////////////////////////////
?>