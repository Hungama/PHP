<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//start code to insert the data for mous_tf for tata Docomo Endless
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1001','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1001','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// ----------------------- end ---------------------------
//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
//start code to insert the data for mous_tf for tata Docomo PauseCode
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $p = $mous_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1002P','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo PauseCode
//start code to insert the data for mous_tf for Tata Docomo Miss Riya
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for Tata Docomo Miss Riya
////////////////////////////////start code to insert the data for mous_tf for tata Docomo mtv////////////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1003','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1003','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for tata Docomo mtv
//start code to insert the data for mous_tf for tata Docomo Filmi meri jaan 
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1005','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1005','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo Filmi meri jaan 
//start code to insert the data for mous_tf for tata Docomo Redfm
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoRedfm' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1010','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoRedfm' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis in ('55935') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1010','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo Redfm
//start code to insert the data for mous_tf for tata DocomoGL
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata DocomoGL
//start code to insert the data for mous_tf for tata DocomoMS
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1000','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1000','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata DocomoMS
//start code to insert the data for mous_t for tata Docomo 54646
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not like '%P%' and dnis not in('5464669','5464668') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1002','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
//start code to insert the data for mous_t for tata Docomo Miss Riya
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 5464669) {
            if ($mous_tf[7] == 1)
                $mous_tf[0] = 'L_MOU_T';
            if ($mous_tf[7] != 1)
                $mous_tf[0] = 'N_MOU_T';
        }elseif ($mous_tf[6] == 5464668) {
            if ($mous_tf[7] == 1)
                $mous_tf[0] = 'L_MOU_T_1';
            if ($mous_tf[7] != 1)
                $mous_tf[0] = 'N_MOU_T_1';
        }
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 5464669) {
            $mous_tf[0] = 'MOU_T';
        } elseif ($mous_tf[6] == 5464668) {
            $mous_tf[0] = 'MOU_T_1';
        }
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1009','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
//start code to insert the data for mous_t for tata DocomoGL
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    if ($mous_tf[1] == '' || $mous_tf[1] == '0')
        $mous_tf[1] = 'UND';
    elseif (strtoupper($mous_tf[1]) == 'HAR')
        $mous_tf[1] = 'HAY';
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        if ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';

        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1011','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata DocomoGL
/////////////////////////////////////////// start code to insert the data for mous_tf for TataDoCoMoMND @jyoti.porwal /////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'TataDoCoMoMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATM') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1013','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'TataDoCoMoMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATM') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        if ($mous_tf[1] == '' || $mous_tf[1] == '0')
            $mous_tf[1] = 'UND';
        elseif (strtoupper($mous_tf[1]) == 'HAR')
            $mous_tf[1] = 'HAY';
        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$mous_tf[1]','0','$mous_tf[5]','','1013','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
/////////////////////////////////////////// end code to insert the data for mous_tf for TataDoCoMoMND @jyoti.porwal /////////////////////////////////
?>