<?php
//////////////////////start code to insert the data for Unique Users  for Tata Docomo Endless //////////////////////////////////////////////
$uu_tf = array();

$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog 
where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1101','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////// end Unique Users  for Tata Docomo Endless/////////////////////////////////////////////////////////////////////////
//////////////////////start code to insert the data for Unique Users for MTSComedy//////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSComedy' as service_name,date(call_date) from mis_db.tbl_radio_calllog 
where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','11012','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSComedy' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','11012','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////// end Unique Users for MTSComedy/////////////////////////////////////////////////////////////////////////
////////////////////////start code to insert the data for Unique Users  for MTS54646//////////////////////////////////////////////
$uu_tf = array();
//$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date) 
//from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
// (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
//and dnis != 546461 and dnis !='5464622' group by circle";
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis != 546461 and dnis !='5464622' group by circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
//$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis != '5464622' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') and dnis != 546461 and dnis !='5464622' and status IN (1)) group by circle)";
//$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' and status=1 group by circle)";

$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis != '5464622' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTS54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1102','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////// Start UU_TF MTSJokes //////////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSJokes' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis = '5464622' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1125','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////// End UU_TF MTSJokes //////////////////////////////////////////////////////
///////////////////////////////////////////////////////////// Start UU_TF MTS Regional //////////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date) 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 group by circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date) from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Non Active' as 'user_status'
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status in(-1,11,0)
AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status IN (1))
group by circle";
$uu_tf_query .= " UNION select 'UU_T_1',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Active' as 'user_status' 
 from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 and status=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T_1';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T_1';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date) from mis_db.tbl_reg_calllog where 
date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Non Active' as 'user_status'
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status in(-1,11,0)
AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status IN (1))
group by circle";
$uu_tf_query .= " UNION select 'UU_T',circle, count(distinct msisdn),'MTS Regional' as service_name,date(call_date),status,'Active' as 'user_status' 
 from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 and status=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1126','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

///////////////////////////////////////////////////////////// End UU_TF MTSJokes //////////////////////////////////////////////////////
////////////////////////start code to insert the data for Unique Users  for MTSFMJ //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSFMJ' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1106','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////////////// end Unique Users  for Tata Docomo 54646 /////////////////////////////////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for MTSMTV ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date) from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis=546461 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSMTV' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1103','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////// end code to insert the data for Unique Users  for Tata Docomo Mtv///////////////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for MTS Devotional ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog 
where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSDevo' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1111','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////// end code to insert the data for Unique Users  for MTS-Devotional /////////////////////////////////////////////
/////////////////start code to insert the data for Unique Users  for MTSRedFM ///////////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog 
where date(call_date)='$view_date1' and dnis=55935 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSRedFM' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1110','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

////////////////////// end code to insert the data for Unique Users for MTSRedFM /////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for Tata Docomo 54646 //////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for MTSKIJI //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=3 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' 
and chrg_rate=0 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' 
and chrg_rate=1 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T_1',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T_1';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T_1';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog 
where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' 
and dnis like '55333%' and chrg_rate=3 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'MTSKIJI' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_T';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_T';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1123','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

/////////////////// end Unique Users  for MTS KIJI /////////////////////////////////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for MTSVA //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_OBD',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealertOBD_calllog 
where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealert_calllog 
where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSVA' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1116','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

/////////////////// end Unique Users for MTSVA /////////////////////////////////////////////////////////////////////////
///////////////////////////start code to insert the data for Unique Users  for MTSMPD //////////////////////////////////////////////
$uu_tf = array();
$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1113','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSMPD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1113','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

/////////////////// end Unique Users for MTSMPD /////////////////////////////////////////////////////////////////////////
//////////////////////////////start code to insert the data for SEC_TF  for MTS MU ///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
//echo "total".$numRows5;
if ($numRows5 > 0) {

    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1101','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1101','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Endless
//////////////////////////////start code to insert the data for SEC_TF for MTSComedy ///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','11012','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','11012','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////// end insert the data for SEC_TF  for MTSComedy //////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////////
$sec_tf = array();
//$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec)
// from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
// (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') and dnis != 546461 and dnis !='5464622' group by circle";
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec)
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and
 (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// Start MTSJokes SEC_TF //////////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSJokes' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1125','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// End MTSJokes SEC_TF //////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////// Start MTS Regional SEC_T //////////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0  group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
        values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_1',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec) from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_1',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T_1';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T_1';

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec) from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1126','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// End MTS Regional SEC_T //////////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646
///////////////////////////////////////////start code to insert the data for SEC_TF  for Mts Starcllub///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
////////////////////////////// end insert the data for SEC_TF  for MTS Starclub ////////////////////////////////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for MTS KIJI/////////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_1',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1123','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

///////////////////////////////////////////END code to insert the data for SEC_TF  for MTS KIJI/////////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1102','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646
////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646/////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'MTS FMJ' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1106','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646
///////////start code to insert the data for SEC_TF  for tata Docomo Mtv /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1103','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Mtv' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1103','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Mtv ////////////////////////////////////
///////////start code to insert the data for SEC_TF  for MTS-Devotional /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1111','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1111','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF  for MTS-Devotional ////////////////////////////////////////
///////////start code to insert the data for SEC_TF for MTSRedFM /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1110','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1110','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSRedFM ////////////////////////////////////////
///////////start code to insert the data for SEC_TF for MTSVA /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_OBD',circle, count(msisdn),'MTSVA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSVA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSVA ////////////////////////////////////////
///////////start code to insert the data for SEC_TF for MTSMPD /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1113','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1113','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
//////////////////////////////////////// end insert the data for SEC_TF for MTSMPD ////////////////////////////////////////


//---------------------------------------MTS IBD Start here -------------------------------------------------------------

// MTS IBD uu, sec insert

$uu_tf = array();

$uu_tf_query = "select 'UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_VasPortal_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_VasPortal_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_VasPortal_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

// MTS MU ibd uu sec insert

$uu_tf = array();

$uu_tf_query = "select 'M_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_radio_calllog  nolock where date(call_date)='$view_date1' and dnis like '55789%'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','M_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'M_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'M_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'M_L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'M_N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','M_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'M_SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','M_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'M_SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'M_L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'M_N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','M_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}



// MTS devo ibd uu sec insert


$uu_tf = array();

$uu_tf_query = "select 'D_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog  nolock where date(call_date)='$view_date1' and dnis like '55789%'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','D_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$uu_tf = array();
$uu_tf_query = "(select 'D_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'D_UU_TF',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis like '55789%'  and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'D_L_UU_TF';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'D_N_UU_TF';

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','D_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$sec_tf = array();
$sec_tf_query = "select 'D_SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','D_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'D_SEC_TF',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'D_L_SEC_TF';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'D_N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','D_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}



// MTS Contest Ibd uu sec insert

$uu_tf = array();
$uu_tf_query = "select 'C_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' 
and dnis like '55789%' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','C_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'C_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55789%' 
and chrg_rate=1 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'C_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'C_L_UU_T_1';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'C_N_UU_T_1';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','C_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'C_SEC_T_1',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','C_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'C_SEC_T_1',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'C_L_SEC_T_1';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'C_N_SEC_T_1';

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','C_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

// MTS Regional IBD uu Sec insert


$uu_tf = array();
$uu_tf_query = "select 'R_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' 
and dnis like '55789%' and chrg_rate=1 group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','R_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}


$uu_tf = array();
$uu_tf_query = "(select 'R_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 and status in(-1,11,0) 
AND MSISDN  NOT IN ( select DISTINCT MSISDN from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis like '55789%' 
and chrg_rate=1 and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'R_UU_T_1',circle, count(distinct msisdn),'MTSIBD' as service_name,date(call_date),status,'Active' as 'user_status' 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 and status=1 group by circle)";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        $circle = $uu_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($uu_tf[6] == 'Active')
            $uu_tf[0] = 'R_L_UU_T_1';
        if ($uu_tf[6] == 'Non Active')
            $uu_tf[0] = 'R_N_UU_T_1';
        $insert_uu_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','R_IBD','NA','NA','NA')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'R_SEC_T_1',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','R_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'R_SEC_T_1',circle, count(msisdn),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $circle = $sec_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'R_L_SEC_T_1';
        elseif ($sec_tf[6] != 1)
            $sec_tf[0] = 'R_N_SEC_T_1';

        $insert_sec_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','R_IBD','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


//--------------------------------------MTS IBD Ends here-----------------------------------------------------------------

?>