<?php

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546465%' 
or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not in('546461','546461000','5464612','5464640','5464643') and operator='airm' and dnis not like '%P%' )temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546465%' 
or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not in('546461','546461000','5464612','5464640','5464643') and operator='airm' and dnis not like '%P%'  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546465%' 
or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not in('546461','546461000','5464612','5464640','5464643') and operator='airm' and dnis not like '%P%'  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546465%' 
or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not in('546461','546461000','5464612','5464640','5464643') and operator='airm' and dnis not like '%P%' )temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546465%' 
or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646')
and dnis not in('546461','546461000','5464612','5464640','5464643') and operator='airm' and dnis not like '%P%'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1502','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}



//for UU Repeat @jyoti.porwal
//$uu_tf = array();
//echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'pauseCode' as service_name,date(item.call_date)
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
//and (dnis like '%34p%' or dnis like '%47p%') and operator='airm')temp ON item.msisdn= temp.msisdn 
//where date(item.call_date)='$view_date1' 
//and (dnis like '%34p%' or dnis like '%47p%') and operator='airm' group by item.circle";
//$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_tf_result);
//if ($numRows4 > 0) {
//    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
//        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
//        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1502P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
//    }
//}
////for UU New @jyoti.porwal
//$uu_total = array();
//echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'pauseCode' as service_name,date(item.call_date)
//from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
//and (dnis like '%34p%' or dnis like '%47p%') and operator='airm' group by item.circle";
//$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_total_result);
//if ($numRows4 > 0) {
//    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//    while ($uu_total = mysql_fetch_array($uu_total_result)) {
//
//        echo $repeat_query = "select  count(distinct item.msisdn)
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
//and (dnis like '%34p%' or dnis like '%47p%') and operator='airm')temp ON item.msisdn= temp.msisdn 
//where date(item.call_date)='$view_date1' 
//and (dnis like '%34p%' or dnis like '%47p%') and operator='airm'  and circle='$uu_total[1]'";
//        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
//        $uu_repeat = mysql_fetch_array($repeat_query_exe);
//        if ($uu_repeat[0] == '') {
//            $uu_repeat[0] = 0;
//        }
//        $uu_new = $uu_total[2] - $uu_repeat[0];
//
//        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
//        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1502P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
//    }
//}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelMPMC' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in ('5464612','5464640') and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis in ('5464612','5464640') and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1518','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelMPMC' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
and dnis in ('5464612','5464640') and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in ('5464612','5464640') and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis in ('5464612','5464640') and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1518','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelMtv' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461,546461000) and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis in(546461,546461000) and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1503','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelMtv' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item where date(item.call_date)='$view_date1' 
and dnis in(546461,546461000) and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461,546461000) and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis in(546461,546461000) and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1503','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelVH1' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(SELECT msisdn  FROM mis_db.tbl_54646_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55841  and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis=55841  and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelVH1' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
and dnis=55841  and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(SELECT msisdn  FROM mis_db.tbl_54646_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55841  and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis=55841  and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1507','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelGL' as service_name,date(item.call_date)
from mis_db.tbl_ldr_calllog item INNER JOIN(SELECT msisdn  FROM mis_db.tbl_ldr_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '55001%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '55001%' and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1511','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelGL' as service_name,date(item.call_date)
from mis_db.tbl_ldr_calllog item where date(item.call_date)='$view_date1' 
and dnis like '55001%' and operator='airm'  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_ldr_calllog item INNER JOIN(SELECT msisdn  FROM mis_db.tbl_ldr_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '55001%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '55001%' and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1511','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelEDU' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '53222345%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '53222345%' and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1514','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelEDU' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog item where date(item.call_date)='$view_date1' 
and dnis like '53222345%' and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_edu_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '53222345%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '53222345%' and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1514','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelMND' as service_name,date(item.call_date)
from mis_db.tbl_mnd_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_mnd_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'
or dnis like '55001699' or (dnis like '54646196' and circle='KAR') or (dnis = '5500196' and circle NOT IN ('DEL')) or dnis = '55001961' 
or dnis = '55001963' or dnis = '55001965' or dnis = '55001966' or dnis = '55001969') and operator='airm' )temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'
or dnis like '55001699' or (dnis like '54646196' and circle='KAR') or (dnis = '5500196' and circle NOT IN ('DEL')) or dnis = '55001961' 
or dnis = '55001963' or dnis = '55001965' or dnis = '55001966' or dnis = '55001969') and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1513','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelMND' as service_name,date(item.call_date)
from mis_db.tbl_mnd_calllog item where date(item.call_date)='$view_date1' 
and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'
or dnis like '55001699' or (dnis like '54646196' and circle='KAR') or (dnis = '5500196' and circle NOT IN ('DEL')) or dnis = '55001961' 
or dnis = '55001963' or dnis = '55001965' or dnis = '55001966' or dnis = '55001969') and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mnd_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_mnd_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'
or dnis like '55001699' or (dnis like '54646196' and circle='KAR') or (dnis = '5500196' and circle NOT IN ('DEL')) or dnis = '55001961' 
or dnis = '55001963' or dnis = '55001965' or dnis = '55001966' or dnis = '55001969') and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'
or dnis like '55001699' or (dnis like '54646196' and circle='KAR') or (dnis = '5500196' and circle NOT IN ('DEL')) or dnis = '55001961' 
or dnis = '55001963' or dnis = '55001965' or dnis = '55001966' or dnis = '55001969') and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1513','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelDevo' as service_name,date(item.call_date)
from mis_db.tbl_devotional_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_devotional_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '51050%' or dnis like '510168%') and operator='airm' )temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '51050%' or dnis like '510168%') and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1515','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelDevo' as service_name,date(item.call_date)
from mis_db.tbl_devotional_calllog item where date(item.call_date)='$view_date1' 
and (dnis like '51050%' or dnis like '510168%') and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_devotional_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_devotional_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '51050%' or dnis like '510168%') and operator='airm' )temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '51050%' or dnis like '510168%') and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1515','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelSE' as service_name,date(item.call_date)
from mis_db.tbl_SPKNG_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_SPKNG_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '571811%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '571811%' and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1517','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelSE' as service_name,date(item.call_date)
from mis_db.tbl_SPKNG_calllog item where date(item.call_date)='$view_date1' 
and dnis like '571811%' and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_SPKNG_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_SPKNG_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '571811%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '571811%' and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1517','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelPK' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_radio_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464613%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '5464613%' and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1520','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelPK' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item where date(item.call_date)='$view_date1' 
and dnis like '5464613%' and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_radio_calllog item INNER JOIN(SELECT msisdn FROM mis_db.tbl_radio_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464613%' and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '5464613%' and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1520','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelEU' as service_name,date(item.call_date)
from mis_db.tbl_AMU_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_AMU_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546469%' or (dnis = '5464694' and circle in('kol','wbl')))  and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '546469%' or (dnis = '5464694' and circle in('kol','wbl')))  and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1501','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelEU' as service_name,date(item.call_date)
from mis_db.tbl_AMU_calllog  item where date(item.call_date)='$view_date1' 
and (dnis like '546469%' or (dnis = '5464694' and circle in('kol','wbl')))  and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_AMU_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_AMU_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546469%' or (dnis = '5464694' and circle in('kol','wbl'))) and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '546469%' or (dnis = '5464694' and circle in('kol','wbl'))) and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1501','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelCK' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU'))temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','15221','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelCK' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog  item where date(item.call_date)='$view_date1' 
and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_edu_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU'))temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','15221','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'AirtelMAN' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis = '5464643' or (dnis like '5464614%'  and circle in ('KAR'))) and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis = '5464643' or (dnis like '5464614%'  and circle in ('KAR'))) and operator='airm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','15222','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'AirtelMAN' as service_name,date(item.call_date)
from mis_db.tbl_edu_calllog  item where date(item.call_date)='$view_date1' 
and (dnis = '5464643' or (dnis like '5464614%'  and circle in ('KAR'))) and operator='airm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_edu_calllog  item INNER JOIN(SELECT msisdn FROM mis_db.tbl_edu_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis = '5464643' or (dnis like '5464614%'  and circle in ('KAR'))) and operator='airm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis = '5464643' or (dnis like '5464614%'  and circle in ('KAR'))) and operator='airm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','15222','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
?>