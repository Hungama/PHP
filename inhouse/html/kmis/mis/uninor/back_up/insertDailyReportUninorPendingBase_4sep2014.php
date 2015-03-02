<?

////////////////////////////////// start code to insert the Pending Base data into the database for UninorContest///////////////////////////////
$file_process_status = '***************Script start for UninorContest Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorContest' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1423)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorContest Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the Pending Base data into the database for Uninor54646///////////////////////////////
////////////////////////////////// start code to insert the Pending Base data into the database for Uninor54646///////////////////////////////
$file_process_status = '***************Script start for Uninor54646 Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Uninor54646' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL1, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL1','NA','NA','NA','NA','NA',1402)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for Uninor54646 Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the Pending Base data into the database for Uninor54646///////////////////////////////
$file_process_status = '***************Script start for 1402P Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$get_pending_base = "select count(ani),substr(dnis,9,3) as circle1,dnis from uninor_hungama.tbl_jbox_subscription 
where status IN (11,0,5) and date(sub_date) <= '$view_date1' and dnis like '%P%' and plan_id!=95 group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($pending_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_pending_base = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1402P')";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}
$file_process_status = '***************Script end for 1402P Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////////// end code to insert the active base data into the database for Uninor54646/////////////////////////////////
///////////////////////////////// start code to insert the Pending Base data into the database for UninorAAV///////////////////////////////
$file_process_status = '***************Script start for AAUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='AAUninor' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',14021)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for AAUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////////////////// end code to insert the active base data into the database for UninorAAV////////////////////
////////////////////////////////// start code to insert the Pending Base data into the database for UninorMPMC/////////////////////////
$file_process_status = '***************Script start for UninorComedy Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorComedy' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1418)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorComedy Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////// end code to insert the active base data into the database for UninorMPMC/////////////////////////////////////////
///////////////////////// start code to insert the Pending Base data into the database for UninorMTV/////////////////////////////////////////
$file_process_status = '***************Script start for MTVUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVUninor' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1403)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for MTVUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorMTV///////////////////////////////////////
////////////////////////////// start code to insert the Pending base data into the database for UninorRedFM////////////////////////////////
$file_process_status = '***************Script start for RedFMUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RedFMUninor' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1410)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for RedFMUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////// end code to insert the active base data into the database for UninorRedFm//////////////////////////////////////
//////////////////////////// start code to insert the Pending base data into the database for UninorManchla///////////////////////////////
$file_process_status = '***************Script start for RIAUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RIAUninor' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1409)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for RIAUninor Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
///////////////////////////////// end code to insert the active base data into the database for UninorManchala///////////////////////////////
//////////////////////////////// start code to insert the Pending base data into the database for UninorJAD//////////////////////////////////
$file_process_status = '***************Script start for UninorAstro Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorAstro' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1416)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorAstro Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
///////////////////////////////// end code to insert the active base data into the database for UninorJAD///////////////////////////
/////////////// start code to insert the Pending base data into the database for UninorCricket
$file_process_status = '***************Script start for UninorSU Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorSU' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1408)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorSU Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorCricket////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVABollyAlerts
$file_process_status = '***************Script start for UninorVABollyAlerts Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVABollyAlerts' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1430)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVABollyAlerts Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorVABollyAlerts////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVAFilmy
$file_process_status = '***************Script start for UninorVAFilmy Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAFilmy' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1431)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAFilmy Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorVAFilmy////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVABollyMasala
$file_process_status = '***************Script start for UninorVABollyMasala Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVABollyMasala' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1432)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVABollyMasala Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorVABollyMasala////////////////////////////////
//////////////// start code to insert the Pending base data into the database for UninorVAHealth
$file_process_status = '***************Script start for UninorVAHealth Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAHealth' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1433)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAHealth Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorVAHealth////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVAFashion
$file_process_status = '***************Script start for UninorVAFashion Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAFashion' and status='Pending' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0) {
    while (list($countGL, $circle) = mysql_fetch_array($activeBaseQuery1)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1434)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAFashion Pending Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////// end code to insert the active base data into the database for UninorVAFashion////////////////////////////////
?>
