<?php
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS KIJI///////////////////

$get_deactivation_base = "select count(*),circle from Mts_summer_contest.tbl_contest_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1123)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo Music Unlimited//////////////////////

$get_deactivation_base = "select count(*),circle from mts_mu.tbl_HB_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Comedy//////////////////////

$get_deactivation_base = "select count(*),circle from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' and plan_id IN (29) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',11012)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS Comedy//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base = "select count(*),circle from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSJokes //////////////////////

$get_deactivation_base = "select count(*),circle from mts_JOKEPORTAL.tbl_jokeportal_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1125)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Regional //////////////////////

$get_deactivation_base = "select count(*),circle from mts_Regional.tbl_regional_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1126)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database AudioCinema //////////////////////

$get_deactivation_base = "select count(*),circle from mts_radio.tbl_AudioCinema_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1124)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database AudioCinema//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base = "select count(*),circle from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Starclub//////////////////////

$get_deactivation_base = "select count(*),circle from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database  MTS Starclub//////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS-Devotional //////////////////////

$get_deactivation_base = "select count(*),circle from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional //////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSRedfm //////////////////////

$get_deactivation_base = "select count(*),circle from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTSRedfm //////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTS Voice Alert //////////////////////

$get_deactivation_base = "select count(*),circle from mts_voicealert.tbl_voice_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1116)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTS Voice Alert //////////////////////
//////////////////////////// Start code to insert the Deactivation Base into the MIS database MTSMPD //////////////////////

$get_deactivation_base = "select count(*),circle from mts_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1113)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

/////////////////////////////////// end code to insert the Deactivation base into the MIS database MTSMPD //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database MTS KIJI//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from Mts_summer_contest.tbl_contest_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN Vo" || $unsub_reason == "Insuf" || $unsub_reason == "IN Voluntary" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
		values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1123)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////// end code to insert the Deactivation base into the MIS database  MTS KIJI  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo  Music UNLIMITED//////////////////////

//mts_mu.tbl_HB_unsub
//mts_radio.tbl_radio_unsub

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_mu.tbl_HB_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";
        elseif ($unsub_reason == "155223 SMS")
            $unsub_reason = "SMS";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database MTS Comedy//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' and plan_id IN (29) group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',11012)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////// end code to insert the Deactivation base into the MIS database MTS Comedy //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_mtv.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $chrg_amount = "";
        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS database Starclub//////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        elseif ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $chrg_amount = "";
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS MTS-Devotional //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from dm_radio.tbl_digi_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;
        $chrg_amount = "";
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTS-Devotional  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS MTSRedfm //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTSRedfm  //////////////////////
///////////// start code to insert the Deactivation Base into the MIS Voice Alert //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_voicealert.tbl_voice_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1116)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTS Voice Alert  //////////////////////
///////////// start code to insert the Deactivation Base into the MISMPD //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1113)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database MTSMPD  //////////////////////
///////////// start code to insert the Deactivation Base into the AudioCinema //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_radio.tbl_AudioCinema_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
        values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1124)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database AudioCinema  //////////////////////
/////////////// start code to insert the Deactivation Base into the JOKEPORTAL //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_JOKEPORTAL.tbl_jokeportal_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1125)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database JOKEPORTAL  //////////////////////
/////////////// start code to insert the Deactivation Base into the REGIONAL //////////////////////

$get_deactivation_base = "select count(*),circle,unsub_reason from mts_Regional.tbl_regional_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1126)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////// end code to insert the Deactivation base into the MIS database REGIONAL  //////////////////////
//////////////// start code deactiactivation base of mts su //////////////


$get_deactivation_base = "select count(*),circle from MTS_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1108)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}



$get_deactivation_base = "select count(*),circle,unsub_reason from MTS_cricket.tbl_cricket_unsub
where date(unsub_date)='$view_date1' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0) {
    while (list($count, $circle, $unsub_reason, $unsub_reason) = mysql_fetch_array($deactivation_base_query)) {
        if ($circle == "")
            $circle = "UND";
        elseif ($circle == "HAR")
            $circle = "HAY";
        elseif ($circle == "PUN")
            $circle = "PUB";

        if ($unsub_reason == "Insufficient Balance" || $unsub_reason == "TNB_CHURN" || $unsub_reason == "IN-Voluntary" || $unsub_reason == "IN Voluantry")
            $unsub_reason = "in";
        elseif (($serviceId != '1101' && $unsub_reason == "push") || $unsub_reason == "BACKEND" || $unsub_reason == "COMEDY_REQ")
            $unsub_reason = "CC";
        elseif ($unsub_reason == "SELF_REQ" || $unsub_reason == "SELF_REQS")
            $unsub_reason = "IVR";

        $deactivation_str1 = "Mode_Deactivation_" . $unsub_reason;

        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id)
        values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1108)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////// end of code mts su



?>