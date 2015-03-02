<?php 

/////////////////////////////////////// start code to insert the data for mous_tf for Uninor54646 ////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '%P%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1402','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and dnis not like '%P%' and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'Uninor54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        elseif ($mous_t[6] == 1)
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1402','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////// end code to insert the data for mous_tf for Uninor54646 ////////////////////////////////////////////////////

////////////////////////start code to insert the data for mous_tf for UninorKIJI/////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1423','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1423','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////  end mous_tf for UninorKIJI ///////////////////////////////////////////////////////

//////////////////////////////////////// start code to insert the data for mous_tf for UninorPause //////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, sum(duration_in_sec)/60,'UninorPause' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_T";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_T";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1402P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

/////////////////////////////////////////////////////// end mous_tf for UninorPause ////////////////////////////////////////////////////////////////////

///////////////////////////////////// start code to insert the data for mous_tf for UninorAAV ///////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','14021','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','14021','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1418','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
echo $mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorAAV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn); // or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn); // or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1418','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end mous_tf for UninorAAV /////////////////////////////////////////////////////////////////////

///////////////////////////////// start code to insert the data for mous_tf for UninorMS /////////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1400','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////// end mous_tf for UninorMS ///////////////////////////////////////////////////////////////////////

//////////////////////////////////////// start code to insert the data for mous_tf for UninorREDFM //////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorREDFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1410','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
//////////////////////////////////////////// end mous_tf for UninorREDFM ///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////// start code to insert the data for mous_tf for UninorMTV //////////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorMTV' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1403','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////// end mous_tf for UninorMTV /////////////////////////////////////////////////////////////

////////////////////////////////////////////////// start code to insert the data for mous_tf for UninorRiya /////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1409','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        $insert_mous_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}

$mous_t = array();
$mous_t_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorRia' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator ='unim' group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0) {
    $mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
    while ($mous_t = mysql_fetch_array($mous_t_result)) {
        if ($mous_t[6] == 1)
            $mous_t[0] = "L_MOU_T";
        elseif ($mous_t[6] == 1)
            $mous_t[0] = "N_MOU_T";
        $insert_mous_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','3','$mous_t[5]','','1409','$mous_t[5]','NA','NA')";
        $queryIns_mousT = mysql_query($insert_mous_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////// end mous_tf for UninorRiya ///////////////////////////////////////////////////

/////////////////////////////////////////////////////// start code to insert the data for mous_tf for UninorRT /////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorRT' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1412','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////////// end mous_tf for UninorRT ////////////////////////////////////////////////////

//////////////////////////////////////////////////// start code to insert the data for mous_tf for UninorJAD ////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorJAD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1416','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorJAD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1416','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////// end mous_tf for UninorJAD /////////////////////////////////////////////////////////////

/////////////////////////////////////////// start code to insert the data for mous_tf for UninorCricket /////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_TF";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_TF";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, sum(duration_in_sec)/60,'UninorCricket' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    $mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = "L_MOU_T";
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = "N_MOU_T";
        $insert_mous_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1408','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// end mous_tf for UninorCricket ////////////////////////////////////////////////////////////
?>