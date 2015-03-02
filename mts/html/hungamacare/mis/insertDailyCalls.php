<?php
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1101','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status 
from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%' group by circle,status"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1101','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////
////////////////start code to insert the data for call_tf for MTS Comedy///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSComedy' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','11012','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','11012','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

//////////////End code to insert the data for call_tf for MTS Comedy///////////////////////////////////////////////////////////////////
//////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf = array();
//$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) 
//from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
//and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%' )
// and dnis != 546461  and dnis != '5464622' group by circle";

$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%')
 and dnis != 546461  and dnis != '5464622' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////////////////////////////////////////////////////// MTSJokes Call_tf ///////////////////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSJokes' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1125','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////// MTSJokes Call_tf ///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////// Start code for Regional Call_t ///////////////////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Regional' as service_name,date(call_date) from mis_db.tbl_reg_calllog
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=0 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=0 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
        values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";


        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T_1';
        else
            $call_tf[0] = 'N_CALLS_T_1';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";


        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTS Regional' as service_name,date(call_date),status from mis_db.tbl_reg_calllog 
where date(call_date)='$view_date1' and dnis ='51111' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T';
        else
            $call_tf[0] = 'N_CALLS_T';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1126','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////// End code for Regional Call_t /////////////////////////////////////////////////////////////
//////////start code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis =5432155 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////End code to insert the data for call_tf MTS Starclub ///////////////////////////////////////////////////////////////////
//////////start code to insert the data for call_tf for MTSMPD ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSMPD' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis ='54646196' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1113','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis='54646196' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1113','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////End code to insert the data for call_tf MTSMPD ///////////////////////////////////////////////////////////////////
////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////start code to insert the data for call_tf for MTSKIJI ///////////////////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
$call_tf = array();
$call_tf_query = "select 'CALLS_T_1',circle, count(id),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}


$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTSKIJI' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1123','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

// end code to insert call data on interface service MTSKIJI

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T';
        else
            $call_tf[0] = 'N_CALLS_T';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1102','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of Tata Docomo Mtv////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1103','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1103','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of Tata Docomo Mtv//////////////////////////////////////////
////////start code to insert the data for call_t for MTS Starclub ///////////////////////////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in (54321551,54321552,54321553) group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T';
        else
            $call_tf[0] = 'N_CALLS_T';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1106','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

////////End code to insert the data for call_tf for MTS Starclub ///////////////////////////////////////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of MTS-Devotional////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1111','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1111','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTS-Devotional //////////////////////////////////
//////////////////////////Start code to insert the data for call_tf for the service of MTSRedFM ////////////////////////////////////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1110','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1110','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the data for call_tf for the service of MTSRedFM //////////////////////////////////
//////////start code to insert the data for call_tf for MTSVA ///////////////////////////////////////////////////////////////////
$call_tf = array();
$call_tf_query = "select 'CALLS_OBD',circle, count(id),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSVA' as service_name,date(call_date) from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSVA' as service_name,date(call_date),status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        else
            $call_tf[0] = 'N_CALLS_TF';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1116','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}
//////////////////////////////End code to insert the data for call_tf MTSVA ///////////////////////////////////////////////////////////////////
/////////////////////////////////////start code to insert the data for mous_tf for tata Docomo Endless////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
 from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1101','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end
/////////////////////////////////////start code to insert the data for mous_tf for MTS Comedy////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','11012','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSComedy' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','11012','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end
//start code to insert the data for mous_tf for tata Docomo 54646
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
and dnis != 546461 and dnis !='5464622' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// Start MTSJokes MOU TF //////////////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSJokes' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1125','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// End MTSJokes MOU TF //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Start MTSJokes MOU TF //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// Start MTS Regional MOU T //////////////////////////////////////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
$mous_tf = array();
$mous_tf_query = "select 'MOU_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T_1',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T_1';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T_1';

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTS Regional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1126','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////////////////////////////////// End Regional Jokes MOU T ////////////////////////////////////////////////////////////////

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id ,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
////////////////////////////////////////start code to insert the data for mous_tf for MTS Starclub////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
////////////////////////////////// end to insert the data for mous_tf for MTS Starclub////////////////////////////
////////////////////////////////////////////start code to insert the data for mous_t for tata Docomo 54646//////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}


////////////////////////////////////////////start code to insert the data for mous_t for MTSKIJI//////////////////////////////

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T_1',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTSKIJI' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1123','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

// end code to insert MTS KIJI of MOU_T


$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'docomo54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous ,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1102','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end to insert the data for mous_tf for tata Docomo 54646
////////////////////////////////////////////start code to insert the data for mous_t for MTS Starclub//////////////////////////////
$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T',circle, count(id),'MTSFMJ' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1106','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
///////////////////////////////// end to insert the data for mous_tf for MTS Starclub/////////////////////////////
//start code to insert the data for mous_tf for tata Docomo mtv
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1103','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for tata Docomo mtv
//start code to insert the data for mous_tf for MTS-Devotional
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTS Devotional' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1111','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTS-Devotional
//start code to insert the data for mous_tf for MTSRedFM
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSRedFM' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1110','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTSRedFM
//start code to insert the data for mous_tf for MTSVA
$mous_tf = array();
$mous_tf_query = "select 'MOU_OBD',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSVA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1116','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTSVA
//start code to insert the data for mous_tf for MTSMPD
$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1113','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSMPD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1113','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}
// end code to insert the data for mous_tf for MTSMPD
/////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////////////
$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '52222%'  group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1101','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////
/////////////////////////start code to insert the data for PULSE_TF for MTScomedy/////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTScomedy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','11012','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTScomedy' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis=5222212 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','11012','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for MTScomedy/////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();

//$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'
// and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
// and dnis != 546461 and dnis !='5464622' group by circle";

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'
 and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') 
 and dnis != 546461 and dnis !='5464622' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



/////////////////////////////////////////////////////////// Start MTSJokes Pulse_TF ////////////////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSJokes' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis = '5464622' group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1125','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// End MTSJokes Pulse_TF ////////////////////////////////////////////////////
/////////////////////////////////////////////////////////// Start MTS Regional Pulse_T ////////////////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=0 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=1
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T_1';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T_1';

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date),
sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog where date(call_date)='$view_date1' and dnis = '51111' and chrg_rate=3
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T';


        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1126','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////////////////////// End MTS Regional Pulse_T ////////////////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis != 546461 and dnis !='5464622' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Starclub /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=5432155 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' or dnis='5464646') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



/////////////////////////////////////////start code to insert the data for PULSE_TF for the MTS KIJI /////////////////////////////////////////

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=0 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=1 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSKIJI' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '55333%' and chrg_rate=3 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1123','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

// end code to insert Pulse for service MTS KIJI


$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and ( dnis=54646 or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T';

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1102','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse ,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(54321551,54321552,54321553) group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1106','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse ,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1103','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTS Devotional' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_Devotional_calllog where date(call_date)='$view_date1' and dnis=5432105 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1111','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here
////////////////////End code to insert the data for PULSE_TF for the MTSRedFM /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1110','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here
////////////////////End code to insert the data for PULSE_TF for the MTSVA /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_OBD',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_voicealert_calllog where date(call_date)='$view_date1' and dnis like '54444%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1116','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here
////////////////////End code to insert the data for PULSE_TF for the MTSMPD /////////////////////////////////////////
$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSMPD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1113','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSVA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646196%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','1113','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}
/// code end here

//-------------------------------------------MTS IBD calls start here--------------------------------------------------------------------
//IBD calls fetching

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}


$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_VasPortal_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}






//MTS MU IBD calls fetching

$call_tf = array();
$call_tf_query = "select 'M_CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','M_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'M_CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'M_L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'M_N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','M_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'M_PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','M_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'M_PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'M_L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'M_N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','M_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'M_MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','M_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'M_MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'M_L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'M_N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','M_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}









// MTS Devo IBD calls fetching


$call_tf = array();
$call_tf_query = "select 'D_CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date) from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','D_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'D_CALLS_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_Devotional_calllog  nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status"; 
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'D_L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'D_N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','D_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'D_PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','D_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'D_PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'D_L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'D_N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','D_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'D_MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','D_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'D_MOU_TF',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_Devotional_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'D_L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'D_N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','D_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}




//MTS Contest ibd calls fetching

$call_tf = array();
$call_tf_query = "select 'C_CALLS_T_1',circle, count(id),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','C_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'C_CALLS_T',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'C_L_CALLS_T_1';
        else
            $call_tf[0] = 'C_N_CALLS_T_1';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','C_IBD','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}




$pulse_tf = array();

$pulse_tf_query = "select 'C_PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=1 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[2]','','C_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'C_PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=1 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'C_L_PULSE_T_1';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'C_N_PULSE_T_1';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','C_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'C_MOU_T_1',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','C_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'C_MOU_T',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'C_L_MOU_T_1';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'C_N_MOU_T_1';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','C_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

// rs 3 contest



$call_tf = array();
$call_tf_query = "select 'C_CALLS_T_3',circle, count(id),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','C_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'C_CALLS_T',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'C_L_CALLS_T_3';
        else
            $call_tf[0] = 'C_N_CALLS_T_3';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','C_IBD','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}




$pulse_tf = array();

$pulse_tf_query = "select 'C_PULSE_T_3',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=3 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[2]','','C_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'C_PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=3 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'C_L_PULSE_T_3';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'C_N_PULSE_T_3';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','C_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'C_MOU_T_3',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','C_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'C_MOU_T',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'C_L_MOU_T_3';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'C_N_MOU_T_3';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','C_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}




//MTS Regional ibd calls fetching

$call_tf = array();
$call_tf_query = "select 'R_CALLS_T_1',circle, count(id),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','R_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'R_CALLS_T',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'R_L_CALLS_T_1';
        else
            $call_tf[0] = 'R_N_CALLS_T_1';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','R_IBD','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}




$pulse_tf = array();

$pulse_tf_query = "select 'R_PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=1 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[2]','','R_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'R_PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=1 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'R_L_PULSE_T_1';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'R_N_PULSE_T_1';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','R_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'R_MOU_T_1',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','R_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'R_MOU_T',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=1 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'R_L_MOU_T_1';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'R_N_MOU_T_1';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','R_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

// for rs 3


$call_tf = array();
$call_tf_query = "select 'R_CALLS_T_3',circle, count(id),'MTSIBD' as service_name,date(call_date) 
from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','R_IBD','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'R_CALLS_T',circle, count(id),'MTSIBD' as service_name,date(call_date),status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'R_L_CALLS_T_3';
        else
            $call_tf[0] = 'R_N_CALLS_T_3';
        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','R_IBD','NA','NA','NA');";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}




$pulse_tf = array();

$pulse_tf_query = "select 'R_PULSE_T_3',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=3 group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[2]','','R_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



$pulse_tf = array();

$pulse_tf_query = "select 'R_PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'MTSIBD' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%'  and chrg_rate=3 group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'R_L_PULSE_T_3';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'R_N_PULSE_T_3';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[2]','','R_IBD','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'R_MOU_T_3',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','R_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'R_MOU_T',circle, count(id),'MTSIBD' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_reg_calllog nolock where date(call_date)='$view_date1' and dnis like '55789%' and chrg_rate=3 group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        //$circle = $pulse_tf[1];
        $circle = $mous_tf[1];

        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'R_L_MOU_T_3';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'R_N_MOU_T_3';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','R_IBD','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}



//-------------------------------------------MTS IBD calls end here----------------------------------------------------------------------

///////// MTS SU ////////////

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'MTSSU' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%' group by circle"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1108','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_TF',circle, count(id),'mtssu' as service_name,date(call_date),status 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%' group by circle,status"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_TF';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_TF';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1108','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

///////// toll call //


$call_tf = array();
$call_tf_query = "select 'CALLS_T_1',circle, count(id),'MTSSU' as service_name,date(call_date) from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%' group by circle"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1108','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

$call_tf = array();
$call_tf_query = "select 'CALLS_T_1',circle, count(id),'endless' as service_name,date(call_date),status 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%' group by circle,status"; //and dnis NOT IN (5222212)
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);

if ($numRows1 > 0) {
    while ($call_tf = mysql_fetch_array($call_tf_result)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($call_tf[5] == 1)
            $call_tf[0] = 'L_CALLS_T_1';
        elseif ($call_tf[5] != 1)
            $call_tf[0] = 'N_CALLS_T_1';

        $insert_call_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1108','NA','NA','NA')";
        $queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
    }
}

///// MOU_tf ////

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'mtssu' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
 from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1108','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_TF',circle, count(id),'mtssu' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_TF';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_TF';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1108','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}


$mous_tf = array();
$mous_tf_query = "select 'MOU_T_1',circle, count(id),'mtssu' as service_name,date(call_date),sum(duration_in_sec)/60 as mous
 from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1108','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

$mous_tf = array();
$mous_tf_query = "select 'MOU_T_1',circle, count(id),'mtssu' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0) {
    while ($mous_tf = mysql_fetch_array($mous_tf_result)) {
        $circle = $mous_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($mous_tf[6] == 1)
            $mous_tf[0] = 'L_MOU_T_1';
        elseif ($mous_tf[6] != 1)
            $mous_tf[0] = 'N_MOU_T_1';
        $insert_mous_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1108','$mous_tf[5]','NA','NA')";
        $queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
    }
}

/// pulse _tf 

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSSU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec)
        values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1108','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();
$pulse_tf_query = "select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'MTSSU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '52444%' and dnis not like '5244401%' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_TF';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_TF';
        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
        values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1108','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTSSU' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%'
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1108','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}

$pulse_tf = array();

$pulse_tf_query = "select 'PULSE_T_1',circle, sum(ceiling(duration_in_sec/60)),'MTS Regional' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_cricket_calllog where date(call_date)='$view_date1' and dnis like '5244401%'
group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0) {
    while ($pulse_tf = mysql_fetch_array($pulse_tf_result)) {
        $circle = $pulse_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($pulse_tf[6] == 1)
            $pulse_tf[0] = 'L_PULSE_T_1';
        elseif ($pulse_tf[6] != 1)
            $pulse_tf[0] = 'N_PULSE_T_1';

        $insert_pulse_tf_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse, total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1108','NA','$pulse_tf[5]','NA')";
        $queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
    }
}



/////////// MTS su ///////////////////////////


?>