<?php

///////////////////////////////////////////// code start for Uninor54646 service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Uninor54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%'
 or dnis like '546469%' or dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' 
or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646')
 and dnis NOT IN ('546461','5464626','5464628','5464611','5464669') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and (item.dnis like '546460%' or item.dnis like '546461%' or item.dnis like '546462%' or item.dnis like '546463%'
 or item.dnis like '546469%' or item.dnis like '54646' or item.dnis like '546464%' or item.dnis like '546465%' or item.dnis like '546466%' 
or item.dnis like '546467%' or item.dnis like '546468%' or item.dnis like '5464666%' or item.dnis like '5464682%' or item.dnis like '5464681%' or item.dnis='5464646')
 and item.dnis NOT IN ('546461','5464626','5464628','5464611','5464669') and item.dnis not like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Uninor54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' and (item.dnis like '546460%' or item.dnis like '546461%' or item.dnis like '546462%' or item.dnis like '546463%'
 or item.dnis like '546469%' or item.dnis like '54646' or item.dnis like '546464%' or item.dnis like '546465%' or item.dnis like '546466%' 
or item.dnis like '546467%' or item.dnis like '546468%' or item.dnis like '5464666%' or item.dnis like '5464682%' or item.dnis like '5464681%' or item.dnis='5464646')
 and item.dnis NOT IN ('546461','5464626','5464628','5464611','5464669') and item.dnis not like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%'
 or dnis like '546469%' or dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' 
or dnis like '546467%' or dnis like '546468%' or dnis like '5464666%' or dnis like '5464682%' or dnis like '5464681%' or dnis='5464646')
 and dnis NOT IN ('546461','5464626','5464628','5464611','5464669') and dnis not like '5464606%' and dnis not like '%P%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and (item.dnis like '546460%' or item.dnis like '546461%' or item.dnis like '546462%' or item.dnis like '546463%'
 or item.dnis like '546469%' or item.dnis like '54646' or item.dnis like '546464%' or item.dnis like '546465%' or item.dnis like '546466%' 
or item.dnis like '546467%' or item.dnis like '546468%' or item.dnis like '5464666%' or item.dnis like '5464682%' or item.dnis like '5464681%' or item.dnis='5464646')
 and item.dnis NOT IN ('546461','5464626','5464628','5464611','5464669') and dnis not like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1402','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for Uninor54646 service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorKIJI service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorKIJI' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and dnis like '52000%' and dnis not like '%P%' and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '52000%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1423','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorKIJI' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item  where date(item.call_date)='$view_date1' and item.dnis like '52000%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and dnis like '52000%' and dnis not like '%P%' and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '52000%' and item.dnis not like '%P%' and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1423','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorKIJI service @jyoti.porwal //////////////////////////////////////////////////////////
/////////////////////////////////////////////// code start for UninorPause service @jyoti.porwal //////////////////////////////////////////////////////////
//// For UU Repeat
//$uu_tf = array();
//echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorPause' as service_name,date(item.call_date)
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
// and (dnis like '%34P%' or dnis like '%47P%') and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and (item.dnis like '%34P%' or item.dnis like '%47P%') and item.operator ='unim' group by item.circle,item.dnis";
//$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_tf_result);
//if ($numRows4 > 0) {
//    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
//        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1402P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
//    }
//}
//
////for UU New
//$uu_total = array();
//echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorPause' as service_name,date(item.call_date),item.dnis
//from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' and (item.dnis like '%34P%' or item.dnis like '%47P%') and item.operator ='unim' group by item.circle,item.dnis";
//$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_total_result);
//if ($numRows4 > 0) {
//    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//    while ($uu_total = mysql_fetch_array($uu_total_result)) {
//
//        echo $repeat_query = "select  count(distinct item.msisdn)
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
// and (dnis like '%34P%' or dnis like '%47P%') and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and (item.dnis like '%34P%' or item.dnis like '%47P%') and item.operator ='unim' and circle='$uu_total[1]' and dnis='$uu_total[5]'";
//        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
//        $uu_repeat = mysql_fetch_array($repeat_query_exe);
//        if ($uu_repeat[0] == '') {
//            $uu_repeat[0] = 0;
//        }
//        $uu_new = $uu_total[2] - $uu_repeat[0];
//
//        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1402P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
//    }
//}
/////////////////////////////////////////////// code end for UninorPause service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorAAV service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorAAV' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis='5464611' and operator ='unim' )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis='5464611' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','14021','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorAAV' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' and item.dnis='5464611' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis='5464611' and operator ='unim' )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis='5464611' and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','14021','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorAAV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorMPMC service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorMPMC' as service_name,date(item.call_date)
from mis_db.tbl_azan_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_azan_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis='5464622' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis='5464622' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1418','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorMPMC' as service_name,date(item.call_date)
from mis_db.tbl_azan_calllog item  where date(item.call_date)='$view_date1' and item.dnis='5464622' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn) from mis_db.tbl_azan_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_azan_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis='5464622' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis='5464622' and item.operator ='unim'   and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1418','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorMPMC service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorMS service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464630%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '5464630%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1400','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' and item.dnis like '5464630%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464630%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '5464630%' and item.operator ='unim' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1400','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorMS service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorRia service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
////dnis IN ('5464628', '66291428')  tbl_mnd_calllog  tbl_54646_calllog  ('5464628','5464626','5464669')
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorRia' as service_name,date(item.call_date)
from mis_db.tbl_mnd_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mnd_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis IN ('5464628', '66291428') and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis IN ('5464628', '66291428') and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1413','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorRia' as service_name,date(item.call_date)
from mis_db.tbl_mnd_calllog item  where date(item.call_date)='$view_date1' and item.dnis IN ('5464628', '66291428') and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

    $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mnd_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mnd_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis IN ('5464628', '66291428') and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis IN ('5464628', '66291428') and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1413','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorRia service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorREDFM service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorREDFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55935 and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis=55935 and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1410','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorREDFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item  where date(item.call_date)='$view_date1' and item.dnis=55935 and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55935 and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis=55935 and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1410','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorREDFM service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorMTV service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461) and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis in(546461) and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1403','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item  where date(item.call_date)='$view_date1' and item.dnis in(546461) and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461) and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis in(546461) and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1403','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorMTV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorRT service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorRT' as service_name,date(item.call_date)
from mis_db.tbl_rt_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rt_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '52888%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '52888%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1412','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorRT' as service_name,date(item.call_date)
from mis_db.tbl_rt_calllog item  where date(item.call_date)='$view_date1' and item.dnis like '52888%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_rt_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rt_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '52888%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '52888%' and item.operator ='unim'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1412','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorRT service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorJAD service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorJAD' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464627%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and item.dnis like '5464627%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1416','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorJAD' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1'  and item.dnis like '5464627%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464627%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and item.dnis like '5464627%' and item.operator ='unim'   and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1416','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorJAD service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorCricket service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorCricket' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and (dnis like '52444%' or dnis like '52299%') and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and (item.dnis like '52444%' or item.dnis like '52299%') and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorCricket' as service_name,date(item.call_date)
from mis_db.tbl_cricket_calllog item  where date(item.call_date)='$view_date1'  and (item.dnis like '52444%' or item.dnis like '52299%') and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and (dnis like '52444%' or dnis like '52299%') and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and (item.dnis like '52444%' or item.dnis like '52299%') and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1408','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorCricket service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorVABollyAlerts service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorVABollyAlerts' as service_name,date(item.call_date)
from mis_db.tbl_bollyalerts_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_bollyalerts_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1430','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorVABollyAlerts' as service_name,date(item.call_date)
from mis_db.tbl_bollyalerts_calllog item  where date(item.call_date)='$view_date1'  and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_bollyalerts_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_bollyalerts_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1430','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorVABollyAlerts service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorVAFilmy service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorVAFilmy' as service_name,date(item.call_date)
from mis_db.tbl_FilmiWords_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_FilmiWords_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1431','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorVAFilmy' as service_name,date(item.call_date)
from mis_db.tbl_FilmiWords_calllog item  where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_FilmiWords_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_FilmiWords_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1'  and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1431','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorVAFilmy service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorVABollyMasala service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorVABollyMasala' as service_name,date(item.call_date)
from mis_db.tbl_BollywoodMasala_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_BollywoodMasala_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1432','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorVABollyMasala' as service_name,date(item.call_date)
from mis_db.tbl_BollywoodMasala_calllog item  where date(item.call_date)='$view_date1'  and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_BollywoodMasala_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_BollywoodMasala_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1432','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorVABollyMasala service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorVAHealth service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorVAHealth' as service_name,date(item.call_date)
from mis_db.tbl_FilmiHeath_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_FilmiHeath_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)  and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1433','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorVAHealth' as service_name,date(item.call_date)
from mis_db.tbl_FilmiHeath_calllog item  where date(item.call_date)='$view_date1'  and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_FilmiHeath_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_FilmiHeath_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1433','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorVAHealth service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for UninorVAFashion service @jyoti.porwal //////////////////////////////////////////////////////////
// For UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorVAFashion' as service_name,date(item.call_date)
from mis_db.tbl_CelebrityFashion_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_CelebrityFashion_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1434','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorVAFashion' as service_name,date(item.call_date)
from mis_db.tbl_CelebrityFashion_calllog item  where date(item.call_date)='$view_date1' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_CelebrityFashion_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_CelebrityFashion_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY) and operator ='unim'
)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.operator ='unim'    and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1434','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for UninorVAFashion service @jyoti.porwal //////////////////////////////////////////////////////////

///////////////////////////////////////////// code start for Uninor reg service /////////////////////////
//for UU Repeat
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'UninorReg' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464606%' and dnis not like '%P%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and item.dnis like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1441','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'UninorReg' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' and item.dnis like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464606%' and dnis not like '%P%' and operator ='unim')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis like '5464606%' and item.dnis not like '%P%' and item.operator ='unim' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1441','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//Uninor reg end here
?>