<?php
////////////////////////// start code to insert the Pending base data into the database for UninorContest/////////////////////////////////////
$file_process_status = '***************Script start for UninorContest Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBaseContest = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorContest' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQueryContest = mysql_query($getActiveBaseContest, $LivdbConn) or die(mysql_error());
$numRowsContest = mysql_num_rows($activeBaseQueryContest);
if ($numRowsContest > 0) {
    while (list($countContest, $circle) = mysql_fetch_array($activeBaseQueryContest)) {
        $circle1 = $circle_info1[$circle];
        if ($circle1 == "")
            $circle1 = "UND";
        elseif ($circle1 == "HAR")
            $circle1 = "HAY";
        elseif ($circle1 == "PUN")
            $circle1 = "PUB";
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countContest','NA','NA','NA','NA','NA',1423)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorContest Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorContest/////////////////////////////////////
///////////////////////////// start code to insert the active base data into the database for Uninor54646/////////////////////////////////
$file_process_status = '***************Script start for Uninor54646 Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Uninor54646' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1402)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for Uninor54646 Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////// end code to insert the active base data into the database for UninorCricket//////////////////////////////
$file_process_status = '***************Script start for 1402P Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$get_active_base = "select count(*),substr(dnis,9,1) as circle1,dnis from uninor_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=95 and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($active_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_data3 = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','1402P','NA','NA','NA','NA')";
        $queryIns = mysql_query($insert_data3, $dbConn);
    }
}
$file_process_status = '***************Script end for 1402P Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////// end code to insert the active base data into the database for Uninor54646////////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorAAV/////////////////////////////////////////
$file_process_status = '***************Script start for AAUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='AAUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',14021)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for AAUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////// end code to insert the active base data into the database for UninorAAV///////////////////////////////////////////
////////////////////////// start code to insert the active base data into the database for UninorMPMC///////////////////////////////////////
$file_process_status = '***************Script start for UninorComedy Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorComedy' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1418)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorComedy Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
///////////////////////////// end code to insert the active base data into the database for UninorMPMC////////////////////////////////////////
/////////////////////////////// start code to insert the active base data into the database for UninorMTV///////////////////////////////////
$file_process_status = '***************Script start for MTVUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1403)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for MTVUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
////////////////////////////////////// end code to insert the active base data into the database for UninorMTV///////////////////////////////
////////////////////////////////// start code to insert the active base data into the database for UninorRedFM /////////////////////////////
$file_process_status = '***************Script start for RedFMUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RedFMUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1410)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for RedFMUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorREdFm//////////////////////////////////////
///////////////////////////////// start code to insert the active base data into the database for UninorManchala////////////////////////////
$file_process_status = '***************Script start for RIAUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RIAUninor' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1409)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for RIAUninor Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////////// start code to insert the Active base data into the database for UninorJAD//////////////////////////////////
$file_process_status = '***************Script start for UninorAstro Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorAstro' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1416)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorAstro Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
///////////////////////////////// end code to insert the active base data into the database for UninorJAD///////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorCricket/////////////////////////////////////
$file_process_status = '***************Script start for UninorSU Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorSU' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1408)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorSU Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorCricket////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorVABollyAlerts/////////////////////////////////////
$file_process_status = '***************Script start for UninorVABollyAlerts Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVABollyAlerts' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1430)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script start end UninorVABollyAlerts Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorVABollyAlerts////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorVAFilmy/////////////////////////////////////
$file_process_status = '***************Script start for UninorVAFilmy Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAFilmy' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1431)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAFilmy Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorVAFilmy////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorVABollyMasala/////////////////////////////////////
$file_process_status = '***************Script start for UninorVABollyMasala Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVABollyMasala' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1432)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVABollyMasala Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorVABollyMasala////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorVAHealth/////////////////////////////////////
$file_process_status = '***************Script start for UninorVAHealth Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAHealth' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1433)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAHealth Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
//////////////////////////// end code to insert the active base data into the database for UninorVAHealth////////////////////////////////////
///////////////////////// start code to insert the active base data into the database for UninorVAFashion/////////////////////////////////////
$file_process_status = '***************Script start for UninorVAFashion Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='UninorVAFashion' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1434)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for UninorVAFashion Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
/////// end code to insert the active base data into the database for UninorVAFashion///////////////


$file_process_status = '********Script start for SMSUninorGujarati Active Base************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='SMSUninorGujarati' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1439)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***********Script end for SMSUninorGujarati Active Base**************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);


$file_process_status = '************Script start for SMSUninorAlert Active Base**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='SMSUninorAlert' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1440)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '***************Script end for SMSUninorAlert Active Base******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);


$file_process_status = '************Script start for SMSUninorFashion Active Base**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='SMSUninorFashion' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1438)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
$file_process_status = '*******Script end for SMSUninorFashion Active Base**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
?>