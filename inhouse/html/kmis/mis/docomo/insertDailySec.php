<?php

/////////////////////start code to insert the data for SEC_TF  for tata Docomo Endless ///////////////////////////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and dnis not like '590902%' and dnis not like '590905%' and operator in('TATM') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and dnis not like '590902%' and dnis not like '590905%' and operator in('TATM') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////// toll calls in enless


$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and (dnis like '590902%' or dnis like '590905%') and operator in('TATM') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T_6';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T_6';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and (dnis like '590902%' or dnis like '590905%') and operator in('TATM') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1001','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}


// end insert the data for SEC_TF  for tata Docomo Endless 
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo 54646///////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec), status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626','5464628') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626','5464628') and dnis not like '%P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

/////////////////////////////////// end insert the data for SEC_TF  for tata Docomo 54646 ///////////////////////////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo PauseCode///////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        $p = $sec_tf[1];
        $pCircle = $pauseArray[$p];
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1002P','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

/////////////////////////////////// end insert the data for SEC_TF  for tata Docomo PauseCode ///////////////////////////////////////////////////
////////////////////////start code to insert the data for SEC_TF  for tata Docomo Miss Riya///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoMissRia' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

/////////////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo 54646 /////////////////////////////////////////
///////////////////////start code to insert the data for SEC_TF  for tata Docomo Filmi Meri Jaan ///////////////////////////////////////////////////

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec), status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1005','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1005','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

////////////////////////////////////////// end insert the data for SEC_TF  for tata Docomo Filmi Meri Jaan ////////////////////////////////////////////
////////////////////////////////start code to insert the data for SEC_TF  for tata Docomo REdfm /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoRedFM' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1010','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoRedFM' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1010','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
///////////////////////////////////// end insert the data for SEC_TF  for tata Docomo REdfm ///////////////////////////////////////////////
////////////////////////////////start code to insert the data for SEC_TF  for tata DocomoGL /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
///////////////////////////////////// end insert the data for SEC_TF  for tata DocomoGL ///////////////////////////////////////////////
////////////////////////////////start code to insert the data for SEC_TF  for tata DocomoMS /////////////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1000','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'DocomoMS' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1000','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
///////////////////////////////////// end insert the data for SEC_TF  for tata DocomoMS ///////////////////////////////////////////////
///////////////////////////////////////////start code to insert the data for SEC_T  for tata Docomo 54646///////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464668','5464669') and dnis not like '5464669%' and dnis not like '%P%' and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T_6';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T_6';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in ('5464668','5464669') and dnis not like '5464669%' and dnis not like '%P%' and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1002','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}
// end insert the data for SEC_TF  for tata Docomo 54646 
///////////////////////////////////////////start code to insert the data for SEC_T  for tata Docomo 54646/////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T_1',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464668') and operator ='tatm' group by circle,dnis,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
      
            if ($sec_tf[7] == 1)
                $sec_tf[0] = 'L_SEC_T_1';
            if ($sec_tf[7] != 1)
                $sec_tf[0] = 'N_SEC_T_1'; //$sec_tf[0]='SEC_T_1';
        
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_1',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464668') and operator ='tatm' group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

// toll calling

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464669%' and operator ='tatm' group by circle,dnis,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
      
            if ($sec_tf[7] == 1)
                $sec_tf[0] = 'L_SEC_T_6';
            if ($sec_tf[7] != 1)
                $sec_tf[0] = 'N_SEC_T_6'; //$sec_tf[0]='SEC_T_1';
        
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T_6',circle, count(msisdn),'Docomo54646' as service_name,date(call_date),sum(duration_in_sec),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464669%' and operator ='tatm' group by circle,dnis";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1009','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}



// end insert the data for SEC_TF  for tata Docomo 54646 
///////////////////////////////////////////start code to insert the data for SEC_T  for tata DocomoGL /////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_T';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_T';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_T',circle, count(msisdn),'DocomoGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1011','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

// end insert the data for SEC_TF  for tata DocomoGL 
//////////////////////////////start code to insert the data for SEC_TF  for TataDoCoMoMND @jyoti.porwal ///////////////////////////////////////////////////
$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'TataDoCoMoMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATM') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1013','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

$sec_tf = array();
$sec_tf_query = "select 'SEC_TF',circle, count(msisdn),'TataDoCoMoMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and (dnis = '55001' or dnis='550011') and operator in('TATM') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0) {
    while ($sec_tf = mysql_fetch_array($sec_tf_result)) {
        if ($sec_tf[1] == '' || $sec_tf[1] == '0')
            $sec_tf[1] = 'UND';
        elseif (strtoupper($sec_tf[1]) == 'HAR')
            $sec_tf[1] = 'HAY';
        if ($sec_tf[6] == 1)
            $sec_tf[0] = 'L_SEC_TF';
        if ($sec_tf[6] != 1)
            $sec_tf[0] = 'N_SEC_TF';

        $insert_sec_tf_data = "insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$sec_tf[0]','$sec_tf[1]','0','$sec_tf[5]','','1013','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
    }
}

//////////////////////////////end code to insert the data for SEC_TF  for TataDoCoMoMND @jyoti.porwal ///////////////////////////////////////////////////
?>