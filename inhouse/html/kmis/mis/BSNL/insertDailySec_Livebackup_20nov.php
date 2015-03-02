<?php 
////////////////////////////////// start code to insert the data for SEC_TF  for BSNL54646 ///////////////////////////////////////////////////////////
$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%') and operator in('bsnl') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis='54646' or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%')  and operator in('bsnl') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T_4',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546468%') and operator in('bsnl') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T_4',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546468%') and operator in('bsnl') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T_4";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T_4";
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
//toll free data start here
$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_bsnl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator in('bsnl') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_TF',circle, count(msisdn),'BSNL54646' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_bsnl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and operator in('bsnl') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_TF";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_TF";
        $insert_sec_t_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
        total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','2202','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////// end SEC_TF for BSNL54646 ////////////////////////////////////////////////////////

?>