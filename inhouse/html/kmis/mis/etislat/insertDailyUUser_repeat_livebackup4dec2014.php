<?php

///////////////////////////////////////////// code start for Etisalat service @jyoti.porwal //////////////////////////////////////////////////////////
// UU_Content
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat', count(distinct item.ani),date(item.date_time),item.plan_id
from etislat_hsep.tbl_sms_alert_send item INNER JOIN(SELECT ani FROM etislat_hsep.tbl_sms_alert_send  where date(date_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and type='Alert' )temp ON item.ani= temp.ani 
where date(item.date_time)='$view_date1' and type='Alert' group by item.plan_id";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $plan_id = $uu_tf[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$circle','2121','0','$uu_tf[1]','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
echo $uu_total_query = "select 'UU_New', count(distinct item.ani),date(item.date_time),item.plan_id
from etislat_hsep.tbl_sms_alert_send item where date(item.date_time)='$view_date1' and type='Alert' group by item.plan_id";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {
        $plan_id = $uu_total[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        echo $repeat_query = "select  count(distinct item.ani)
from etislat_hsep.tbl_sms_alert_send item INNER JOIN(SELECT ani FROM etislat_hsep.tbl_sms_alert_send  where date(date_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and type='Alert' )temp ON item.ani= temp.ani 
where date(item.date_time)='$view_date1' and type='Alert' and plan_id='$uu_total[3]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[1] - $uu_repeat[0];
        //echo "New User=" . $uu_total[2] . "-" . $uu_repeat[0];
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_total[0]','$circle','2121','0','$uu_new','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//UU_MO
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat', count(distinct item.msisdn),date(item.response_time),item.plan_id,item.service_id
from " . $successTable . " item INNER JOIN(SELECT msisdn FROM " . $successTable . "  where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB') )temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB')  group by item.service_id,item.plan_id";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $plan_id = $uu_tf[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$circle','2121','0','$uu_tf[1]','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New', count(distinct item.msisdn),date(item.response_time),item.plan_id,item.service_id
from " . $successTable . " item where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB')  
        group by item.service_id,item.plan_id";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {
        $plan_id = $uu_total[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $repeat_query = "select  count(distinct item.msisdn)
from " . $successTable . " item INNER JOIN(SELECT msisdn FROM " . $successTable . "  where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB') )temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') and plan_id='$uu_total[3]' and service_id='$uu_total[4]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[1] - $uu_repeat[0];
        //echo "New User=" . $uu_total[2] . "-" . $uu_repeat[0];
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_total[0]','$circle','2121','0','$uu_new','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}

//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat', count(distinct item.msisdn),date(item.response_time),item.plan_id,item.service_id
from master_db.tbl_billing_failure item INNER JOIN(SELECT msisdn FROM master_db.tbl_billing_failure where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB'))temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by item.service_id,item.plan_id";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $plan_id = $uu_tf[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$circle','2121','0','$uu_tf[1]','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New', count(distinct item.msisdn),date(item.response_time),item.plan_id,item.service_id
from master_db.tbl_billing_failure item where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by item.service_id,item.plan_id";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {
        $plan_id = $uu_total[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $repeat_query = "select count(distinct item.msisdn)
from master_db.tbl_billing_failure item INNER JOIN(SELECT msisdn FROM master_db.tbl_billing_failure where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB'))temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') and plan_id='$uu_total[3]' and service_id='$uu_total[4]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[1] - $uu_repeat[0];
        //echo "New User=" . $uu_total[2] . "-" . $uu_repeat[0];
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_total[0]','$circle','2121','0','$uu_new','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//UU_MT
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat', count(distinct item.msisdn),date(item.response_time),item.plan_id
from " . $successTable . " item INNER JOIN(SELECT msisdn FROM " . $successTable . " where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB'))temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by item.plan_id";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $plan_id = $uu_tf[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$circle','2121','0','$uu_tf[1]','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New', count(distinct item.msisdn),date(item.response_time),item.plan_id
from " . $successTable . " item where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by item.plan_id";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {
        $plan_id = $uu_total[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $repeat_query = "select  count(distinct item.msisdn)
from " . $successTable . " item INNER JOIN(SELECT msisdn FROM " . $successTable . " where date(response_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and service_id in(2121) and event_type in('SUB'))temp ON item.msisdn= temp.msisdn 
where date(item.response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') and plan_id='$uu_total[3]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[1] - $uu_repeat[0];
        //echo "New User=" . $uu_total[2] . "-" . $uu_repeat[0];
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_total[0]','$circle','2121','0','$uu_new','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//select count(distinct ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type IN ('Alert','PRERENEW') 
//        group by plan_id
//for UU Repeat @jyoti.porwal
$uu_tf = array();
$uu_tf_query = "select 'UU_Repeat', count(distinct item.ani),date(item.date_time),item.plan_id
from etislat_hsep.tbl_sms_alert_send item INNER JOIN(SELECT ani FROM etislat_hsep.tbl_sms_alert_send where date(date_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and type IN ('Alert','PRERENEW') )temp ON item.ani= temp.ani 
where date(item.date_time)='$view_date1' and type IN ('Alert','PRERENEW')  group by item.plan_id";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $plan_id = $uu_tf[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_tf[0]','$circle','2121','0','$uu_tf[1]','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
//for UU New @jyoti.porwal
$uu_total = array();
$uu_total_query = "select 'UU_New', count(distinct item.ani),date(item.date_time),item.plan_id
from etislat_hsep.tbl_sms_alert_send item where date(item.date_time)='$view_date1' and type IN ('Alert','PRERENEW')  group by item.plan_id";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {
        $plan_id = $uu_total[3];
        if ($plan_id == "125" || $plan_id == "126" || $plan_id == "166")
            $circle = "EPL";
        elseif ($plan_id == "119" || $plan_id == "124" || $plan_id == "172")
            $circle = "SPL";
        elseif ($plan_id == "118" || $plan_id == "123" || $plan_id == "170")
            $circle = "Fun";
        elseif ($plan_id == "116" || $plan_id == "121" || $plan_id == "168")
            $circle = "Jokes";
        elseif ($plan_id == "117" || $plan_id == "122" || $plan_id == "171")
            $circle = "Hollywood";
        elseif ($plan_id == "115" || $plan_id == "120" || $plan_id == "169")
            $circle = "Astro";
        elseif ($plan_id == "174" || $plan_id == "175" || $plan_id == "176")
            $circle = "Lifestyle";
        elseif ($plan_id == "177" || $plan_id == "178" || $plan_id == "179")
            $circle = "Motive";
        else
            $circle = "Others";
        $repeat_query = "select count(distinct item.ani)
from etislat_hsep.tbl_sms_alert_send item INNER JOIN(SELECT ani FROM etislat_hsep.tbl_sms_alert_send where date(date_time) between DATE_SUB('$view_date1', INTERVAL 7 DAY) and DATE_SUB('$view_date1', INTERVAL 1 DAY)
and type IN ('Alert','PRERENEW') )temp ON item.ani= temp.ani 
where date(item.date_time)='$view_date1' and type IN ('Alert','PRERENEW') and plan_id='$uu_total[3]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[1] - $uu_repeat[0];
        //echo "New User=" . $uu_total[2] . "-" . $uu_repeat[0];
        echo $insert_data = "insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) 
            values('$view_date1', '$uu_total[0]','$circle','2121','0','$uu_new','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for Etisalat service @jyoti.porwal //////////////////////////////////////////////////////////
?>