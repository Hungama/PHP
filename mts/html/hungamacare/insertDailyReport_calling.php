<?php

include ("/var/www/html/hungamacare/config/dbConnect.php");
$view_date1 = '2014-08-05';

if ($view_date1) {
    $tempDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    if ($view_date1 < $tempDate) {
        $successTable = "master_db.tbl_billing_success_backup";
    } else {
        $successTable = "master_db.tbl_billing_success";
    }
}
echo $view_date1;

$circle_info1 = array('Delhi' => 'DEL', 'Gujarat' => 'GUJ', 'WestBengal' => 'WBL', 'Bihar' => 'BIH', 'Rajasthan' => 'RAJ', 'UP WEST' => 'UPW', 'Maharashtra' => 'MAH', 'Andhra Pradesh' => 'APD', 'UP EAST' => 'UPE', 'Assam' => 'ASM', 'Tamil Nadu' => 'TNU', 'Kolkata' => 'KOL', 'NE' => 'NES', 'Chennai' => 'CHN', 'Orissa' => 'ORI', 'Karnataka' => 'KAR',
    'Haryana' => 'HAR', 'Punjab' => 'PUN', 'Mumbai' => 'MUM', 'Madhya Pradesh' => 'MPD', 'Jammu-Kashmir' => 'JNK', "Punjab" => 'PUB', 'Kerala' => 'KER', 'Himachal Pradesh' => 'HPD', 'Other' => 'UND', 'Haryana' => 'HAY');

//////////////////////////////// Start delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
//echo $view_date1="2012-05-01";

$deleteprevioousdata = "delete from mis_db.mtsDailyReport where date(report_date)='$view_date1' and (type like '%call%' or type like '%mou%'
or type like '%pulse%' or type like '%sec%' or type like '%uu%')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////
////////////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

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
///////////////////////////// VoiceAlert Special Type ////////////////////////////////////////////////////////////////////

$va_logs2 = array();
//$va_query1="select 'VA_Calls',count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle";
$va_query1 = "select 'VA_Calls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle";
$va_query_result1 = mysql_query($va_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($va_query_result1);
if ($numRows1 > 0) {
    while ($va_data1 = mysql_fetch_array($va_query_result1)) {
        $circle = $call_tf[1];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_va_data1 = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data1[0]','$va_data1[2]','0','$va_data1[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data1, $dbConn);
    }
}

$va_logs3 = array();
//count(ani),circle from mts_voicealert.tbl_OBD_category_logs where date(date_time)='$view_date1' group by circle
$va_query3 = "select 'VA_ExpectedCalls',count(msisdn),circle from mis_db.tbl_voicealertOBD_calllog where date(call_date)='$view_date1' group by circle
UNION
select 'VA_ExpectedCalls',count(ani),circle from mts_voicealert.tbl_OBD_SMS_logs where date(date_time)='$view_date1' group by circle";

$va_query_result3 = mysql_query($va_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($va_query_result3);
if ($numRows3 > 0) {
    while ($va_data3 = mysql_fetch_array($va_query_result3)) {
        $circle = $va_data3[2];
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_va_data3 = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$va_data3[0]','$circle','0','$va_data3[1]','','1116','NA','NA','NA')";
        $queryIns_sec = mysql_query($insert_va_data3, $dbConn);
    }
}

///////////////////////////// VoiceAlert Special Type Code End here  /////////////////////////////////////////////////////


mysql_close($dbConn);

echo "done";
// end
?>
