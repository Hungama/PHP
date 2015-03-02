<?php
echo "Start Deactivation script --";
// start code to insert the Deactivation Base into the MIS database for Uninor54646
$get_deactivation_base = "select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' 
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id,Revenue) 
        values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1402,'')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}


/////////////////////////////// Start Uninor KIJI/////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from uninor_summer_contest.tbl_contest_unsub
where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1423)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End Uninor KIJI////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub ,status,dnis 
from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status, $dnis) = mysql_fetch_array($deactivation_base_query)) {
        $pCircle = $pauseArray[$circle];
        $unsub_reason = $pauseCode[$unsub_reason];
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','$unsub_reason','NA','NA','NA','1402P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for Uninor54646/ Uninor Pause Code
// start code to insert the Deactivation Base into the MIS database for UninorAAV

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_Artist_Aloud_unsub 
where date(unsub_date)='$view_date1' and plan_id=95 group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',14021)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
echo "In Deactivation script 1--";
// end code to insert the Deactivation base into the MIS database for UninorAAV
// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_comedy_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA','1418')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorMPMC
// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_mtv_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data7 = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1403)";
        $queryIns = mysql_query($insert_data7, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorMTV
// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm = "select count(*),circle,unsub_reason ,status from uninor_redfm.tbl_jbox_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows3 > 0) {
    $deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query_redfm)) {
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
        $insert_data_redfm = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1410)";
        $queryIns = mysql_query($insert_data_redfm, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorREdfm
// start code to insert the Deactivation Base into the MIS database for UninorManchala
//uninor_manchala.tbl_riya_unsub 
$get_deactivation_base_m = "select count(*),circle,unsub_reason ,status from uninor_mnd.tbl_character_unsub1
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0) {
    $deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query_m)) {
        if ($circle == "")
            $circle = "UND";
        if ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "SYSTEM" || $unsub_reason == "system" || $unsub_reason == "RECON_BLOCK")
            $unsub_reason = "in";
        elseif ($unsub_reason == "CRM" || $unsub_reason == "OBD" || $unsub_reason == 'CCI')
            $unsub_reason = "CC";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1413)";
        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorManchala
// start code to insert the Deactivation Base into the MIS database for UninorJAD
$get_deactivation_base_m = "select count(*),circle,unsub_reason ,status from uninor_jyotish.tbl_Jyotish_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0) {
    $deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query_m)) {
        if ($circle == "")
            $circle = "UND";
        if ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "SYSTEM" || $unsub_reason == "system" || $unsub_reason == "RECON_BLOCK")
            $unsub_reason = "in";
        elseif ($unsub_reason == "CRM" || $unsub_reason == "OBD" || $unsub_reason == 'CCI')
            $unsub_reason = "CC";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1416)";
        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}
// end code to insert the Deactivation base into the MIS database for UninorJAD
// start code to insert the Deactivation Base into the MIS database for UninorCricket
$get_deactivation_base_m = "select count(*),circle,unsub_reason ,status from uninor_cricket.tbl_cricket_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0) {
    $deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
    while (list($count, $circle, $unsub_reason, $status) = mysql_fetch_array($deactivation_base_query_m)) {
        if ($circle == "")
            $circle = "UND";
        if ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "SYSTEM" || $unsub_reason == "system" || $unsub_reason == "RECON_BLOCK")
            $unsub_reason = "in";
        elseif ($unsub_reason == "CRM" || $unsub_reason == "OBD" || $unsub_reason == 'CCI')
            $unsub_reason = "CC";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        if ($unsub_reason == 'CCI')
            $deactivation_str1 = "Mode_Deactivation_CC";
        $insert_data_m = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1408)";
        $queryIns = mysql_query($insert_data_m, $dbConn);
    }
}
echo "In Deactivation script 2--";
// end code to insert the Deactivation base into the MIS database for UninorCricket
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for Uninor54646/////////////////////////
/*
$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' 
and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1402)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
*/
//////////////////////////////// end code to insert the Deactivation Base into the MIS database for Uninor54646/////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for Uninor54646/////////////////////////

$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' 
and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1402)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////// end code to insert the Deactivation Base into the MIS database for Uninor54646/////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorKIJI/////////////////////////

$get_deactivation_base = "select count(*),circle,status from uninor_summer_contest.tbl_contest_unsub where date(unsub_date)='$view_date1' 
and dnis not like '%P%' group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1423)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the Deactivation base into the MIS database for UninorKIJI////////////////////////////////////
// start code to insert the Deactivation Base into the MIS database for Uninor AAV

$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' 
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','14021')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//----------Uninor AAV
// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' 
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1418')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//----------UninorMPMC
// start code to insert the Deactivation Base into the MIS database for UninorRiya
// uninor_manchala.tbl_riya_unsub
$get_deactivation_base = "select count(*),circle,status from uninor_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' 
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1413)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorRiya
/////////////// start code to insert the Deactivation Base into the MIS database for UninorMTV////////

$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' 
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1403)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorMTV
// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm = "select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_fm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_fm);
if ($numRows2 > 0) {
    $deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query_redfm)) {
        $deactivation_str1 = "Deactivation_10";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1410)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorRedFM
// start code to insert the Deactivation Base into the MIS database for UninorJAD

$get_deactivation_base = "select count(*),circle,status from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='$view_date1'
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1416)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorJAD
// start code to insert the sunsign Base into the MIS database for UninorJAD

$get_ss_base = "select 'Sign_Base',count(distinct ANI) as count,circlecode from uninor_jyotish.UpdateJyotishAlarm group by circlecode";

$ss_base_query = mysql_query($get_ss_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($ss_base_query);
if ($numRows > 0) {
    $ss_base_query_result = mysql_query($get_ss_base, $dbConn) or die(mysql_error());
    while (list($ss_base, $count, $circle) = mysql_fetch_array($ss_base_query_result)) {
        if (!$circle)
            $circle = 'UND';
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$ss_base','$circle','$count','NA','NA','NA',1416)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the sunsign base into the MIS database for UninorJAD
// start code to insert the Deactivation Base into the MIS database for UninorCricket

$get_deactivation_base = "select count(*),circle,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' 
group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1408)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

// end code to insert the Deactivation base into the MIS database for UninorCricket
/////////////////////////////// Start UninorVABollyAlerts/////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from Uninor_BollyAlerts.tbl_BA_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1430)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End UninorVABollyAlerts////////////////////////////////////////////////////////////////////////
/////////////////////////////// Start UninorVAFilmy /////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from Uninor_FilmiWords.tbl_FW_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1431)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End UninorVAFilmy ////////////////////////////////////////////////////////////////////////
/////////////////////////////// Start UninorVABollyMasala /////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from Uninor_BollywoodMasala.tbl_BM_unsub
where date(unsub_date)='$view_date1'  group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1432)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End UninorVABollyMasala  ////////////////////////////////////////////////////////////////////////
/////////////////////////////// Start UninorVAHealth  /////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from Uninor_FilmiHeath.tbl_FH_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1433)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End UninorVAHealth  ////////////////////////////////////////////////////////////////////////
/////////////////////////////// Start UninorVAFashion  /////////////////////////////////////////////////////////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason ,status from Uninor_CelebrityFashion.tbl_CF_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1434)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////////////////// End UninorVAFashion ////////////////////////////////////////////////////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorVABollyAlerts /////////////////////////

$get_deactivation_base = "select count(*),circle,status from Uninor_BollyAlerts.tbl_BA_unsub where date(unsub_date)='$view_date1' 
 group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1430)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the Deactivation base into the MIS database for UninorVABollyAlerts ////////////////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorVAFilmy /////////////////////////

$get_deactivation_base = "select count(*),circle,status from Uninor_FilmiWords.tbl_FW_unsub where date(unsub_date)='$view_date1' 
 group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1431)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the Deactivation base into the MIS database for UninorVAFilmy  ////////////////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorVABollyMasala /////////////////////////

$get_deactivation_base = "select count(*),circle,status from Uninor_BollywoodMasala.tbl_BM_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1432)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the Deactivation base into the MIS database for UninorVABollyMasala ////////////////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorVAHealth /////////////////////////

$get_deactivation_base = "select count(*),circle,status from Uninor_FilmiHeath.tbl_FH_unsub where date(unsub_date)='$view_date1' 
 group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1433)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the Deactivation base into the MIS database for UninorVAHealth////////////////////////////////////
//////////////////////////////// start code to insert the Deactivation Base into the MIS database for UninorVAFashion/////////////////////////

$get_deactivation_base = "select count(*),circle,status from Uninor_CelebrityFashion.tbl_CF_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1434)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////// end code to insert the Deactivation base into the MIS database for UninorVAFashion  /////////////////

/////////////////Uninor SMS PACKS START//////////////////
$get_deactivation_base = "select count(*),circle,status from Uninor_smspack.tbl_local_gujarati_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1439)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_deactivation_base = "select count(*),circle,status from Uninor_smspack.tbl_rich_alerts_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1440)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_deactivation_base = "select count(*),circle,status from Uninor_smspack.tbl_fashion_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1438)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////////////Uninor SMS PACKS END//////////////////


//////// start code to insert the Deactivation Base into the MIS database for UninorDesi beats ////////////

$get_deactivation_base = "select count(*),circle,status from uninor_hungama.tbl_LG_unsub where date(unsub_date)='$view_date1' 
group by circle";
$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $status) = mysql_fetch_array($deactivation_base_query)) {
        $deactivation_str1 = "Deactivation_30";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1441)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////// end code to insert the Deactivation base into the MIS database for UninorDesi beats  /////////////////

echo "End Deactivation script --";

?>