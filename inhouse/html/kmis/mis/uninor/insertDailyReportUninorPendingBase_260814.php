<?

////////////////////////////////// start code to insert the Pending Base data into the database for UninorContest///////////////////////////////

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

////////////////////////////////// end code to insert the Pending Base data into the database for Uninor54646///////////////////////////////
////////////////////////////////// start code to insert the Pending Base data into the database for Uninor54646///////////////////////////////

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

////////////////////////////////// end code to insert the Pending Base data into the database for Uninor54646///////////////////////////////

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

//////////////////////////////// end code to insert the active base data into the database for Uninor54646/////////////////////////////////
///////////////////////////////// start code to insert the Pending Base data into the database for UninorAAV///////////////////////////////

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

//////////////////////////////////////// end code to insert the active base data into the database for UninorAAV////////////////////
////////////////////////////////// start code to insert the Pending Base data into the database for UninorMPMC/////////////////////////

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
////////////////////////// end code to insert the active base data into the database for UninorMPMC/////////////////////////////////////////
///////////////////////// start code to insert the Pending Base data into the database for UninorMTV/////////////////////////////////////////

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

//////////////////////////// end code to insert the active base data into the database for UninorMTV///////////////////////////////////////
////////////////////////////// start code to insert the Pending base data into the database for UninorRedFM////////////////////////////////

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

////////////////////////// end code to insert the active base data into the database for UninorRedFm//////////////////////////////////////
//////////////////////////// start code to insert the Pending base data into the database for UninorManchla///////////////////////////////

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

///////////////////////////////// end code to insert the active base data into the database for UninorManchala///////////////////////////////
//////////////////////////////// start code to insert the Pending base data into the database for UninorJAD//////////////////////////////////

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
///////////////////////////////// end code to insert the active base data into the database for UninorJAD///////////////////////////
/////////////// start code to insert the Pending base data into the database for UninorCricket
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
////////////////////////////////// end code to insert the active base data into the database for UninorCricket////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVABollyAlerts
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
////////////////////////////////// end code to insert the active base data into the database for UninorVABollyAlerts////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVAFilmy
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
////////////////////////////////// end code to insert the active base data into the database for UninorVAFilmy////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVABollyMasala
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
////////////////////////////////// end code to insert the active base data into the database for UninorVABollyMasala////////////////////////////////
//////////////// start code to insert the Pending base data into the database for UninorVAHealth
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
////////////////////////////////// end code to insert the active base data into the database for UninorVAHealth////////////////////////////////
////////////// start code to insert the Pending base data into the database for UninorVAFashion
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
////////////////////////////////// end code to insert the active base data into the database for UninorVAFashion////////////////////////////////
?>
