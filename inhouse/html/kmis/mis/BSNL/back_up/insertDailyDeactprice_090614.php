<?php 
//////////////////// start code to insert the Deactivation Base into the MIS database for BSNL54646 ////////////////////////////////////////////
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from BSNL_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' 
and dnis not like '%P%' group by circle,unsub_reason";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        if ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "SYSTEM" || $unsub_reason == "system" || $unsub_reason == "RECON_BLOCK")
            $unsub_reason = "in";
        elseif ($unsub_reason == "CRM" || $unsub_reason == "OBD")
            $unsub_reason = "CC";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id,Revenue) 
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',2202,'')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////// end code to insert the Deactivation Base into the MIS database for BSNL54646 ////////////////////////////////////////////

//////////////////////////////// start code to insert the Deactivation Base into the MIS database for BSNL54646/////////////////////////

$get_deactivation_base = "select count(*),circle,status from BSNL_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' 
and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportBsnl(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) 
        values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',2202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////// end code to insert the Deactivation Base into the MIS database for BSNL54646/////////////////////////



?>