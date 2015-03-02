<?php

///////////////////////////////////////////// code start for Reliance54646 service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Reliance54646' as service_name,date(item.call_date),item.dnis
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by item.circle,item.dnis";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Reliance54646' as service_name,date(item.call_date),item.dnis
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') group by item.circle,item.dnis";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='546461' and dnis not like '%P%' and operator in('relm','relc') and circle='$uu_total[1]' and dnis='$uu_total[5]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1202','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for Reliance54646 service @jyoti.porwal //////////////////////////////////////////////////////////
/////////////////////////////////////////////// code start for Pausecode service @jyoti.porwal //////////////////////////////////////////////////////////
////for UU Repeat @jyoti.porwal
//$uu_tf = array();
//echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Pausecode' as service_name,date(item.call_date),item.dnis
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
//and (dnis like '%34P%' or dnis like '%47P%') and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
//and (dnis like '%34P%' or dnis like '%47P%') and operator in('relm','relc') group by item.circle,item.dnis";
//$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_tf_result);
//if ($numRows4 > 0) {
//    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
//    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
//        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
//        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1202P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
//    }
//}
////for UU New @jyoti.porwal
//$uu_total = array();
//echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Pausecode' as service_name,date(item.call_date),item.dnis
//from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
//and (dnis like '%34P%' or dnis like '%47P%') and operator in('relm','relc') group by item.circle,item.dnis";
//$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//$numRows4 = mysql_num_rows($uu_total_result);
//if ($numRows4 > 0) {
//    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
//    while ($uu_total = mysql_fetch_array($uu_total_result)) {
//
//        echo $repeat_query = "select  count(distinct item.msisdn)
//from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
//and (dnis like '%34P%' or dnis like '%47P%') and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
//and (dnis like '%34P%' or dnis like '%47P%') and operator in('relm','relc') and circle='$uu_total[1]' and dnis='$uu_total[5]'";
//        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
//        $uu_repeat = mysql_fetch_array($repeat_query_exe);
//        if ($uu_repeat[0] == '') {
//            $uu_repeat[0] = 0;
//        }
//        $uu_new = $uu_total[2] - $uu_repeat[0];
//
//        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
//        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1202P','NA','NA','NA')";
//        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
//    }
//}
/////////////////////////////////////////////// code end for Pausecode service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for RelianceMS service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'RelianceMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464630%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('relm','relc') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1200','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'RelianceMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('relm','relc') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '5464630%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator in('relm','relc')  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1200','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for RelianceMS service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for RelianceCricket service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'RelianceCricket' as service_name,date(item.call_date),item.dnis
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by item.circle,item.dnis";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1208','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'RelianceCricket' as service_name,date(item.call_date),item.dnis
from mis_db.tbl_cricket_calllog item  where date(item.call_date)='$view_date1' 
and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') group by item.circle,item.dnis";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_cricket_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_cricket_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54433,544337,5443322,5443333,544334,5443344) and operator in('relm','relc') and circle='$uu_total[1]' and dnis='$uu_total[5]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1208','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for RelianceCricket service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for RelianceMTV service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'RelianceMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
 and dnis =546461 and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
 and dnis =546461 and operator in('relm','relc') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1203','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'RelianceMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item  where date(item.call_date)='$view_date1' 
 and dnis =546461 and operator in('relm','relc') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
 and dnis =546461 and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
 and dnis =546461 and operator in('relm','relc') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1203','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for RelianceMTV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for RelianceMM service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'RelianceMM' as service_name,date(item.call_date)
from mis_db.tbl_musicmania_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_musicmania_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
 and dnis like '543219%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
 and dnis like '543219%' and operator in('relm','relc') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1201','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'RelianceMM' as service_name,date(item.call_date)
from mis_db.tbl_musicmania_calllog item  where date(item.call_date)='$view_date1' 
 and dnis like '543219%' and operator in('relm','relc') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_musicmania_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_musicmania_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
 and dnis like '543219%' and operator in('relm','relc'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
 and dnis like '543219%' and operator in('relm','relc') and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1201','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for RelianceMTV service @jyoti.porwal //////////////////////////////////////////////////////////
?>