<?php

//////////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog
where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '59090%' and operator in('TATM'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATM') group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1001','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_radio_calllog item  where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATM') group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_radio_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_radio_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '59090%' and operator in('TATM'))temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '59090%' and operator in('TATM')  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1001','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////
///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis  not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status IN (1)) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis  not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator ='tatm')temp ON item.msisdn= temp.msisdn 
where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646'
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis  not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis  not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
         from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
         and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
        or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
        and dnis  not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator ='tatm')temp ON item.msisdn= temp.msisdn 
        where date(item.call_date)='$view_date1' 
        and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '54646' 
        or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
        and dnis  not in('546461','5464626','5464669','5464668') and dnis not like '%P%' and operator ='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1002','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
///////////////////start code to insert the data for Unique Users  for Tata Docomo PauseCode //////////////////////////////////////////////

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('TATM') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator in('TATM') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%'  and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('TATM') and status IN (1)) group by circle,dnis)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator in('TATM') and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $p = $uu_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$pCircle','0','$uu_tf[2]','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'PauseCode' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and (dnis like '%34P%' or dnis like '%47P%') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator ='tatm' group by item.circle,item.dnis";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'PauseCode' as service_name,date(item.call_date),item.dnis
from mis_db.tbl_54646_calllog item  where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator ='tatm' group by item.circle,item.dnis";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and (dnis like '%34P%' or dnis like '%47P%') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and (dnis like '%34P%' or dnis like '%47P%') and operator ='tatm'  and item.circle='$uu_total[1]' and item.dnis='$uu_total[5]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1002P','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
////////////////////////// end Unique Users  for Tata Docomo PauseCode ///////////////////////////////////////////////////////////////////
///////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis IN ('5464626','5464628') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis IN ('5464626','5464628') and operator ='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog item where date(item.call_date)='$view_date1' 
and dnis IN ('5464626','5464628') and operator ='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis IN ('5464626','5464628') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis IN ('5464626','5464628') and operator ='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
///////////////start code to insert the data for Unique Users  for Tata Docomo Mtv ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[5] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1003','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1003','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Docomo Mtv' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis=546461 and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=546461 and operator='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1003','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Docomo Mtv' as service_name,date(item.call_date)
from mis_db.tbl_mtv_calllog item  where date(item.call_date)='$view_date1' 
and dnis=546461 and operator='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_mtv_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_mtv_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis=546461 and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis=546461 and operator='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1003','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////////////// end code to insert the data for Unique Users  for Tata Docomo Mtv///////////////////////////////////////////////////////
/////////////start code to insert the data for Unique Users  for Tata Docomo Filmi Meri jaan//////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1005','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_starclub_calllog 
where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1005','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_starclub_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_starclub_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in ('56666') and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in ('56666') and operator='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1005','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_starclub_calllog item where date(item.call_date)='$view_date1' 
and dnis in ('56666') and operator='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_starclub_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_starclub_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in ('56666') and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in ('56666') and operator='tatm'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1005','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////// end Unique Users  for Tata Docomo Filmi Meri jaan/////////////////////////////////////////////////////////////////////////
/////////////start code to insert the data for Unique Users  for Tata Docomo Redfm//////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_redfm_calllog 
where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in ('55935') and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in ('55935') and operator='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1010','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'endless' as service_name,date(item.call_date)
from mis_db.tbl_redfm_calllog item  where date(item.call_date)='$view_date1' 
and dnis in ('55935') and operator='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_redfm_calllog item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_redfm_calllog  where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis in ('55935') and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis in ('55935') and operator='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1010','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////// end Unique Users  for Tata Docomo Redfm/////////////////////////////////////////////////////////////////////////
/////////////start code to insert the data for Unique Users  for Tata DocomoMS//////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator in('TATM') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1000','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'DocomoMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1000','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'DocomoMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '5464630%' and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1000','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'DocomoMS' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog  item  where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '5464630%' and operator='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '5464630%' and operator='tatm'  and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1000','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
/////////////// end Unique Users  for Tata DocomoMS/////////////////////////////////////////////////////////////////////////
///////////////////start code to insert the data for Unique Users_T  for Tata Docomo 54646 //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'DocomoRia' as service_name,date(call_date),dnis,status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status IN (1)) group by circle,dnis)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'DocomoRia' as service_name,date(call_date),dnis,status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' and status=1 group by circle,dnis)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == '5464669') {
            if ($uu_tf[6] == 1)
                $uu_tf[0] = 'L_UU_T';
            if ($uu_tf[6] != 1)
                $uu_tf[0] = 'N_UU_T';
            //$uu_tf[0]='UU_T';
        }
        elseif ($uu_tf[5] == '5464668') {
            if ($uu_tf[6] == 1)
                $uu_tf[0] = 'L_UU_T_1';
            if ($uu_tf[6] != 1)
                $uu_tf[0] = 'N_UU_T_1';
            //$uu_tf[0]='UU_T_1';
        }
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and  dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == '5464669') {
            $uu_tf[0] = 'UU_T';
        } elseif ($uu_tf[5] == '5464668') {
            $uu_tf[0] = 'UU_T_1';
        }
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and  dnis in('5464669','5464668') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and  dnis in('5464669','5464668') and operator ='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'Docomo54646' as service_name,date(item.call_date)
from mis_db.tbl_54646_calllog  item  where date(item.call_date)='$view_date1' 
and  dnis in('5464669','5464668') and operator ='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.msisdn)
from mis_db.tbl_54646_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_54646_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and  dnis in('5464669','5464668') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and  dnis in('5464669','5464668') and operator ='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1009','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// end Unique Users  for Tata Docomo 54646 ////////////////////////////////////////
///////////////////start code to insert the data for Unique Users_T  for Tata DocomoGL //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status IN (1)) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        if ($uu_tf[5] == 1)
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[5] != 1)
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1011','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog 
where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        if ($uu_tf[1] == '' || $uu_tf[1] == '0')
            $uu_tf[1] = 'UND';
        elseif (strtoupper($uu_tf[1]) == 'HAR')
            $uu_tf[1] = 'HAY';
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1011','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU Repeat @jyoti.porwal
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.msisdn),'DocomoGL' as service_name,date(item.call_date)
from mis_db.tbl_rasoi_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rasoi_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $insert_uu_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1011','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.msisdn),'DocomoGL' as service_name,date(item.call_date)
from mis_db.tbl_rasoi_calllog  item  where date(item.call_date)='$view_date1' 
and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select count(distinct item.msisdn)
from mis_db.tbl_rasoi_calllog  item INNER JOIN(  SELECT msisdn  FROM mis_db.tbl_rasoi_calllog   where date(call_date) between '$last_7day_end' and '$last_7day_start'
and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm')temp ON item.msisdn= temp.msisdn where date(item.call_date)='$view_date1' 
and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        $insert_uu_total_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$uu_total[0]','$uu_total[1]','0','$uu_new','','1011','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// end Unique Users  for Tata DocomoGL ////////////////////////////////////////
?>