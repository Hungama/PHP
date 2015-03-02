<?php

///////////////////////////////////// start code to insert the data for Unique Users  for toll free for Uninor54646 ////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog nolock where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis NOT IN ('546461','5464626','5464628','5464611') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock 
where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646') and dnis!='5464669' 
and dnis not like '%P%' and operator in('unim') group by circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646') 
and dnis!='5464669' and operator in('unim') and status in(-1,11,0) and dnis not like '%P%' AND MSISDN  NOT IN( select DISTINCT MSISDN 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646')
and dnis!='5464669' and dnis not like '%P%' and operator in('unim') 
and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis='5464646')
and dnis!='5464669' and dnis not like '%P%' and operator in('unim')
and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T";
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T_6',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock 
where date(call_date)='$view_date1' and  dnis like '546466%' and dnis!='5464669' 
and dnis not like '%P%' and operator in('unim') group by circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T_6',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546466%' 
and dnis!='5464669' and operator in('unim') and status in(-1,11,0) and dnis not like '%P%' AND MSISDN  NOT IN( select DISTINCT MSISDN 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546466%' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim') 
and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546466%' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim')
and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T_6";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T_6";
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T_9',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock 
where date(call_date)='$view_date1' and  dnis like '546467%' and dnis!='5464669' 
and dnis not like '%P%' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T_9',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546467%' and dnis!='5464669' 
and dnis!='5464669' and operator in('unim') and status in(-1,11,0) and dnis not like '%P%' AND MSISDN  NOT IN( select DISTINCT MSISDN 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546467%' and dnis!='5464669' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim') 
and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546467%' and dnis!='5464669' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim')
and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T_9";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T_9";
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T_1',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock 
where date(call_date)='$view_date1' and  dnis like '546468%'  and dnis!='5464669' 
and dnis not like '%P%' and operator in('unim') group by circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T_1',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546468%' 
and dnis!='5464669' and operator in('unim') and status in(-1,11,0) and dnis not like '%P%' AND MSISDN  NOT IN( select DISTINCT MSISDN 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546468%' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim') 
and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  dnis like '546468%' and dnis!='5464669' and dnis not like '%P%' 
and operator in('unim')
and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T_1";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T_1";
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////// end toll free for Uninor54646 //////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorKIJI /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorKIJI' as service_name,date(call_date) from mis_db.tbl_cricket_calllog  nolock where date(call_date)='$view_date1' and dnis like '52000%' and dnis not like '%P%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1423','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorKIJI' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52000%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1423','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorKIJI/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// start code to insert the data for Unique Users  for toll free for UninorPause //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='unim' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'UninorPause' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='unim' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////////////// end toll free for UninorPause ////////////////////////////////////////////////////////
////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorAAV ///////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','14021','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorAAV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='5464611' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','14021','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////// end toll free for UninorAAV /////////////////////////////////////////////////////////
//////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorMPMC /////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date) from mis_db.tbl_azan_calllog  nolock where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1418','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status NOT IN (1) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMPMC' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_azan_calllog where date(call_date)='$view_date1' and dnis='5464622' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1418','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////// end toll free for UninorMPMC ////////////////////////////////////////////////////////
/////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorMS ////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////////// end toll free for UninorMS ///////////////////////////////////////////////////
////////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorRiya //////////////////////////////
//dnis IN ('5464628', '66291428')  tbl_mnd_calllog  tbl_54646_calllog  ('5464626','5464628')
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_mnd_calllog  nolock where date(call_date)='$view_date1' and dnis IN ('5464628', '66291428') and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1413','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '66291428') and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '66291428') and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis IN ('5464628', '66291428') and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1413','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
/*
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'UninorRia' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464669' and operator in('unim') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[5] == 1)
            $uu_tf[0] = "L_UU_T";
        elseif ($uu_tf[5] != 1)
            $uu_tf[0] = "N_UU_T";
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1409','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
*/
///////////////////////////////////////////////////////////// end toll free for UninorRiya ///////////////////////////////////////////////////////////
//////////////////////////////////////////// start code to insert the data for Unique Users  for toll free for REDFM ////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog  nolock where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorREDFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// end toll free for UninorREDFM /////////////////////////////////////////////
/////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorMTV /////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog  nolock where date(call_date)='$view_date1' and dnis in(546461) and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
///////////////////////////////////////////////////////////// end toll free for UninorMTV /////////////////////////////////////////////////////
//////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorRT /////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorRT' as service_name,date(call_date) from mis_db.tbl_rt_calllog  nolock where date(call_date)='$view_date1' and dnis like '52888%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//////////////////////////////////////////////////////////////// end toll free for UninorRT ///////////////////////////////////////////////////////
///////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorJAD ////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date) from mis_db.tbl_54646_calllog  nolock where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1416','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorJAD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464627%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1416','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////// end toll free for UninorJAD //////////////////////////////////////////////////////////////
//////////////////////////// start code to insert the data for Unique Users  for toll free for UninorCricket ////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog nolock  where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date) from mis_db.tbl_cricket_calllog nolock  where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'UninorCricket' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52299%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////// end toll free for UninorCricket //////////////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorVABollyAlerts /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyAlerts' as service_name,date(call_date) 
from mis_db.tbl_bollyalerts_calllog nolock  where date(call_date)='$view_date1'  and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1430','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyAlerts' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyAlerts' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_bollyalerts_calllog where date(call_date)='$view_date1'  and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1430','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorVABollyAlerts///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorVAFilmy /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorVAFilmy' as service_name,date(call_date) from mis_db.tbl_FilmiWords_calllog nolock 
where date(call_date)='$view_date1' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1431','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorVAFilmy' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorVAFilmy' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_FilmiWords_calllog where date(call_date)='$view_date1' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1431','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorVAFilmy///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorVABollyMasala /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyMasala' as service_name,date(call_date) 
from mis_db.tbl_BollywoodMasala_calllog  nolock where date(call_date)='$view_date1' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1432','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyMasala' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorVABollyMasala' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_BollywoodMasala_calllog where date(call_date)='$view_date1' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1432','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorVABollyMasala///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorVAHealth /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorVAHealth' as service_name,date(call_date) 
from mis_db.tbl_FilmiHeath_calllog  nolock where date(call_date)='$view_date1'  and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1433','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorVAHealth' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorVAHealth' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_FilmiHeath_calllog where date(call_date)='$view_date1' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1433','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorVAHealth///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// start code to insert the data for Unique Users  for toll free for UninorVAFashion /////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorVAFashion' as service_name,date(call_date) 
from mis_db.tbl_CelebrityFashion_calllog  nolock where date(call_date)='$view_date1' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1434','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorVAFashion' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'UninorVAFashion' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_CelebrityFashion_calllog where date(call_date)='$view_date1' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1434','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//////////////////////////////////////////////////// end toll free for UninorVAFashion///////////////////////////////////////////////////////////////////////////

/////////// start code to insert the data for Unique Users  for toll free for UninorReg /////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'UninorReg' as service_name,date(call_date) from mis_db.tbl_54646_calllog nolock where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1441','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'UninorReg' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Uninor54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464606%' and dnis not like '%P%' and operator ='unim' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        /* if($uu_tf[5] == 1) $uu_tf[0] = "L_UU_TF";
          elseif($uu_tf[5] != 1) $uu_tf[0] = "N_UU_TF"; */
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1441','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//End for uninorReg


?>