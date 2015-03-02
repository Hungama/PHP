<?php
echo "UUser Repeat Section Start";
///////////////////////////////////////////// code start for endless service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '52222%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis like '52222%' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item  where date(item.call_date)='$view_date1' and dnis like '52222%' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

 $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '52222%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis like '52222%' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for endless service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSComedy service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSComedy' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=5222212)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis=5222212 group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','11012','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
 $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSComedy' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item  where date(item.call_date)='$view_date1' and dnis=5222212 group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=5222212)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis=5222212 and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','11012','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSComedy service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTS54646 service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTS54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and  (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis != 546461 and dnis !='5464622')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis != 546461 and dnis !='5464622' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal  
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTS54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis != 546461 and dnis !='5464622' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and  (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis != 546461 and dnis !='5464622')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis=54646 or dnis like '546464%' 
or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') 
and dnis != 546461 and dnis !='5464622' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTS54646 service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSJokes service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
 $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSJokes' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis = '5464622')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis = '5464622' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1125','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSJokes' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' and dnis = '5464622' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis = '5464622')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' and dnis = '5464622'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1125','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSJokes service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTS Regional service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal   
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTS Regional' as service_name,date(item.call_date)
from mis_db.tbl_reg_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_reg_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis ='51111' and chrg_rate in(1,3) )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis ='51111' and chrg_rate in(1,3) group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTS Regional' as service_name,date(item.call_date)
from mis_db.tbl_reg_calllog item where date(item.call_date)='$view_date1' 
and dnis ='51111' and chrg_rate in(1,3) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_reg_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_reg_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis ='51111' and chrg_rate in(1,3) )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis ='51111' and chrg_rate in(1,3)  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTS Regional service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSFMJ service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSFMJ' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(54321551,54321552,54321553,5432155) )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54321551,54321552,54321553,5432155)  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSFMJ' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item  where date(item.call_date)='$view_date1' 
and dnis in(54321551,54321552,54321553,5432155) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis in(54321551,54321552,54321553,5432155) )temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in(54321551,54321552,54321553,5432155)   and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSFMJ service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSMTV service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=546461)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=546461  group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSMTV' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog  item  where date(item.call_date)='$view_date1' 
and dnis=546461  group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=546461)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=546461  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSMTV service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTS Devotional service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTS Devotional' as service_name,date(item.call_date)
from mis_db.tbl_Devotional_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_Devotional_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=5432105)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=5432105 group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTS Devotional' as service_name,date(item.call_date)
from mis_db.tbl_Devotional_calllog  item  where date(item.call_date)='$view_date1' 
and dnis=5432105 group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_Devotional_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_Devotional_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=5432105)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=5432105   and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTS Devotional service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSRedFM service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSRedFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55935)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=55935 group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSRedFM' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item  where date(item.call_date)='$view_date1' 
and dnis=55935 group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog   where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis=55935)temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=55935   and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSRedFM service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSKIJI service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSKIJI' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '55333%'  and chrg_rate in(1,3))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate in(1,3) group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSKIJI' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item where date(item.call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate in(1,3) group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '55333%' and chrg_rate in(1,3))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate in(1,3) and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSKIJI service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSVA service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
 $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSVA' as service_name,date(item.call_date)
from mis_db.tbl_voicealertOBD_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_voicealertOBD_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54444%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54444%' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSVA' as service_name,date(item.call_date)
from mis_db.tbl_voicealertOBD_calllog item where date(item.call_date)='$view_date1' 
and dnis like '54444%' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_voicealertOBD_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_voicealertOBD_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54444%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54444%'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSVA service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSVA service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
$uu_tf = array();
 $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSVA' as service_name,date(item.call_date)
from mis_db.tbl_voicealert_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_voicealert_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54444%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54444%' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSVA' as service_name,date(item.call_date)
from mis_db.tbl_voicealert_calllog item where date(item.call_date)='$view_date1' 
and dnis like '54444%' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_voicealert_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_voicealert_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54444%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54444%'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSVA service @jyoti.porwal //////////////////////////////////////////////////////////
///////////////////////////////////////////// code start for MTSMPD service @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'MTSMPD' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54646196%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54646196%' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1113','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'MTSMPD' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '54646196%' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog where date(call_date) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and dnis like '54646196%')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '54646196%'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1113','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for MTSMPD service @jyoti.porwal //////////////////////////////////////////////////////////
echo "UUser Repeat Section End";
?>