<?php 
////////////////////////////////// start code to insert the data for SEC_TF  for Uninor54646 ///////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1402','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and dnis not like '%P%' and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1402','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'Uninor54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and dnis not like '%P%' and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1402','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////// end SEC_TF for Uninor54646 ////////////////////////////////////////////////////////

///////////////////////////////////////// start code to insert the data for SEC_TF  for UninorPause /////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('unim') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('unim') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];

        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('unim') group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'UninorPause' as service_name,date(call_date),sum(duration_in_sec),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('unim') group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];

        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_T";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_T";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1402P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////// end SEC_TF for UninorPause //////////////////////////////////////////////////////////

////////////////////////////////////// start code to insert the data for SEC_TF  for UninorAAV /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorAAV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','14021','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorAAV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','14021','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////// end code to insert the data for SEC_TF  for UninorAAV /////////////////////////////////////////////////////////

////////////////////////////////////////// start code to insert data of Uninor KIJI //////////////////////////////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorKIJI' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1423','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorKIJI' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis='52000%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1423','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////end code to insert data of Uninor KIJI /////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorMPMC //////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMPMC' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1418','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMPMC' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1418','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////////// end SEC_TF for UninorMPMC /////////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorMS ///////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1400','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////////////// end SEC_TF for UninorMS /////////////////////////////////////////////////////////

/////////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorRia ////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1409','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        $insert_sec_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1409','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}

$sec_t = array();
$sec_t_query = "select 'SEC_T',circle, count(msisdn),'UninorRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0) {
    $sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
    while ($sec_t = mysql_fetch_array($sec_t_result)) {
        if ($sec_t[6] == 1)
            $sec_t[0] = "L_SEC_T";
        elseif ($sec_t[6] != 1)
            $sec_t[0] = "N_SEC_T";
        $insert_sec_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0.05','$sec_t[5]','','1409','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////// end SEC_TF for UninorRiya /////////////////////////////////////////////////////////////

////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorREDFM /////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1410','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////////////////// end SEC_TF for UninorREDFM /////////////////////////////////////////////////////////

//////////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorMTV ////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorMTV' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1403','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////////  end SEC_TF for UninorMTV /////////////////////////////////////////////////////////////

////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorRT ////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorRT' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1412','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////////// end SEC_TF for UninorRT ///////////////////////////////////////////////////////////

/////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorJAD ////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorJAD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1416','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorJAD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1416','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////////////////// end SEC_TF for UninorJAD /////////////////////////////////////////////////////

////////////////////////////////////////////////////// start code to insert the data for SEC_TF  for UninorCricket //////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_TF";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_TF";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator in('unim') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'UninorCricket' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator in('unim') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    $sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[6] == 1)
            $sec_tf[0] = "L_SEC_T";
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = "N_SEC_T";
        $insert_sec_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1408','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////////////// end SEC_TF for UninorCricket //////////////////////////////////////////////////
?>