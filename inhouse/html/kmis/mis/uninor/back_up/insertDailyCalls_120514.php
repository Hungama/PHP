<?php
//////////////////////////////////////////// start code to insert the data for call_tf for Uninor54646 /////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date) 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' 
or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461','5464611') 
and dnis not like '%P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date),status from  
mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' 
or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('5464628','5464626','546461','5464611')
and dnis not like '%P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1402','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and dnis not like '%P%' and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'Uninor54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646') and dnis not like '%P%' and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1402','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
////////////////////////////////////////////////////////// end call_tf for Uninor54646 ////////////////////////////////////////////////////////

///////////////////////////////////////////////// start code to insert the data for call_tf for UninorPause ///////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'UninorPause' as service_name,date(call_date),dnis 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorPause' as service_name,date(call_date),status from  
mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'UninorPause' as service_name,date(call_date),dnis 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'UninorPause' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_T";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_T";
        $p = $call_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////////////// end call_tf for UninorPause //////////////////////////////////////////////////////////

////////////////////////////////////////////////// start code to insert the data for call_tf for Uninor54646 ////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date) 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','14021','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Uninor54646' as service_name,date(call_date),status 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','14021','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////// end call_tf for Uninor54646 ////////////////////////////////////////////////////////////

//////////////////////////////////// start code to insert the data for call_tf for UninorMPMC ///////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMPMC' as service_name,date(call_date) 
from  mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1418','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMPMC' as service_name,date(call_date),status from 
mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1418','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

/////////////////////////////////////////////////////////// end call_tf for UninorMPMC //////////////////////////////////////////////////////////

////////////////////////////////////////// start code to insert the data for call_tf for UninorMS ////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMS' as service_name,date(call_date),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub, service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1400','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////// end call_tf for UninorMS //////////////////////////////////////////////////////////

///////////////////////////////////////////////////// start code to insert the data for call_tf for UninorRiya /////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorRia' as service_name,date(call_date),status 
from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '5464626') and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1409','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////////////////// end call_tf for UninorRiya /////////////////////////////////////////////////////

///////////////////////////////////////////////////////// start code to insert the data for call_tf for UninorREdFm //////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date) from 
mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorREdFm' as service_name,date(call_date),status 
from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id, mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1410','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// end call_tf for UninorREdFm ///////////////////////////////////////////////////////////

/////////////////////////////////////////////////// start code to insert the data for call_tf for UninorMTV ////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date) from 
mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorMTV' as service_name,date(call_date),status 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1403','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////////////// end call_tf for UninorMTV //////////////////////////////////////////////////

////////////////////////////////////////////// start code to insert the data for call_tf for UninorRT /////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorRT' as service_name,date(call_date) from  mis_db.tbl_rt_calllog where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1412','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////// end call_tf for UninorRT ///////////////////////////////////////////////////////////////////////

///////////////////////////////////// start code to insert the data for call_tf for UninorJAD //////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorJAD' as service_name,date(call_date) from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1416','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorJAD' as service_name,date(call_date),status from  mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1416','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////////// end call_tf for UninorJAD ///////////////////////////////////////////////////////////

//////////////////////////////////////////////////// start code to insert the data for call_tf for UninorCricket /////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorCricket' as service_name,date(call_date) from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorCricket' as service_name,date(call_date),status from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'UninorCricket' as service_name,date(call_date) from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'UninorCricket' as service_name,date(call_date),status from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_T";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_T";
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1408','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////  end calllog for Uninor cricket /////////////////////////////////////////////////////////////

/////////////////////////////////////////  insert Toll Free calllog for Uninor KIJI/////////////////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorKIJI' as service_name,date(call_date) from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1423','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'UninorKIJI' as service_name,date(call_date),status from  mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    $call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        if ($call_tf[5] == 1)
            $call_tf[0] = "L_CALLS_TF";
        elseif ($call_tf[5] != 1)
            $call_tf[0] = "N_CALLS_TF";

        $insert_call_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1423','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////// end call_tf for UninorKIJI //////////////////////////////////////////////////////////////

///////////////////////////////// start code to insert the data for call_t for UninorRiya ////////////////////////////////////////////////////////
$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        $insert_call_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}

$call_t = array();
$call_t_query = "select 'CALLS_T',circle, count(id),'UninorRia' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis= '5464669' and operator ='unim' group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($call_t_result);
if ($numRows12 > 0) {
    $call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
    while ($call_t = mysql_fetch_array($call_t_result)) {
        if ($call_t[5] == 1)
            $call_t[0] = "L_CALLS_T";
        elseif ($call_t[5] != 1)
            $call_t[0] = "N_CALLS_T";
        $insert_call_t_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1409','NA','NA','NA')";
        $queryInsCallT = mysql_query($insert_call_t_data, $dbConn);
    }
}
/////////////////////////////////////////////////////// end call_t for UninorRiya ///////////////////////////////////////////////////////////////////////
?>