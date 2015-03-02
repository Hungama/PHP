<?php 
///////////////////////////////////////////// code start for Vodafone54646 service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Vodafone54646' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646' or dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646' or dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Vodafone54646' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646' or dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646' or dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' 
or dnis like '546468%' or dnis='5464646' or dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
and dnis !='546461' and dnis not like '%P%' and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1302','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for Vodafone54646 service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for pause service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'pause' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '%34P%' or dnis like '%47P%') and operator in('vodm','voda') and status in (0,1,-1,11) )temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'pause' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and (dnis like '%34P%' or dnis like '%47P%') and operator in('vodm','voda') and status in (0,1,-1,11) )temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1302P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for pause service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for VodafoneMTV service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'VodafoneMTV' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1303','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'VodafoneMTV' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(546461) and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1303','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for VodafoneMTV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for VodafoneMTV service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'VH1' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1307','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'VH1' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55841) and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1307','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for VodafoneMTV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for VodafoneMU service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'VodafoneMU' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1301','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'VodafoneMU' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11))temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55665) and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1301','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for VodafoneMU service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for RedFM service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'RedFM' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11) )temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1310','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'RedFM' as service_name,date(item.call_date)
from master_db.tbl_voda_calllog item where date(item.call_date)='$view_date1' 
and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11)  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from master_db.tbl_voda_calllog item INNER JOIN(  SELECT msisdn  FROM master_db.tbl_voda_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11) )temp ON item.msisdn= temp.msisdn
where date(item.call_date)='$view_date1' 
and dnis in(55935) and operator in('vodm','voda') and status in (0,1,-1,11) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into master_db.dailyReportVodafone(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1310','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for RedFM service @jyoti.porwal //////////////////////////////////////////////////////////
?>