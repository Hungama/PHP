<?php
///////////////////// start code to PENDING BASE Contest ////////////////////////////

if($LivdbConn)
{
//Active/Pending base insertion if db connection to 218 is ok
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSContest' 
and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1123)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}



$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSContest' 
and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1123)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}




/////////////////////////////////////////////////////////////////// END code to PENDING BASE Contest ////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database Docomo MUSIC UNLIMITED////////////////////////////////
///////////////////////////////////////////////////////////////////End the code to Renwewal Record mode wise ////////////////////////////////////////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSMU' and status='Pending' 
and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MUSIC UNLIMITED////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS comedy///////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSComedy' and status='Pending' 
and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',11012)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////////////////////// end code to insert the active base date into the database MTS comedy////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS 54646 Music///////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTS54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS MTSJokes ///////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSJokes' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
                values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1125)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
///////////////////////////////////// Start code to insert the Pending Base date into the database MTS Regional///////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSReg' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
                values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1126)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Regional//////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTVMTS' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTS Starclub//////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSFMJ' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database Docomo MTV//////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTS-devotional //////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSDevo' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTS-Devotional //////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTSRedFM //////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='RedFMMTS' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTSRedFM /////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTS Voice Alert //////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSVA' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1116)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTS Voice Alert /////////////////////////////////////////
//////////////////////////////////// end code to insert the active base date into the database MTSMPD //////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSMND' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1113)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

//////////////////////////////////// end code to insert the active base date into the database MTSMPD /////////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database Docomo  Music Unlimited////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSMU' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1101)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database MTS comedy////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSComedy' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',11012)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
/////////// end code to insert the active base date into the database MTS comedy//////////////////////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database MTS 54646//////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTS54646' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1102)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database MTS MTSJokes //////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSJokes' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id)
                values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1125)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database MTS Regional//////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSReg' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id)
                values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1126)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Regional/////////////////////////////////////
////////////////// start code to insert the active base date into the database MTS MTV///////////////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTVMTS' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1103)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music/////////////////////////////////////
////////////////// start code to insert the active base date into the database Starclub///////////////////////////////////////////////////

$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSFMJ' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1106)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music////////////////////////////////
///////// start code to insert the active base date into the database MTSDevo///////////////////////////////////////////////////
/*
  $get_active_base="select count(*),circle from dm_radio.tbl_digi_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle == "") $circle="UND";
  elseif($circle == "HAR") $circle="HAY";
  elseif($circle == "PUN") $circle="PUB";

  $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1111)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSDevo' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1111)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database MTS-Devotional ///////////////////////////////////////////////
///////// start code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////////
/*
  $get_active_base="select count(*),circle from mts_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle == "") $circle="UND";
  elseif($circle == "HAR") $circle="HAY";
  elseif($circle == "PUN") $circle="PUB";

  $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1110)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='RedFMMTS' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1110)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
////////////////////////// end code to insert the active base date into the database MTSRedfm ///////////////////////////////////////////////
///////// start code to insert the active base date into the database MTS Voice Alert ///////////////////////////////////////////////////
/*
  $get_active_base="select count(*),circle from mts_voicealert.tbl_voice_subscription where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle == "") $circle="UND";
  elseif($circle == "HAR") $circle="HAY";
  elseif($circle == "PUN") $circle="PUB";

  $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1116)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSVA' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1116)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database MTS Voice Alert ///////////////////////////////////////////////
///////// start code to insert the active base date into the database MTSMPD ///////////////////////////////////////////////////
/*
  $get_active_base="select count(*),circle from mts_mnd.tbl_character_subscription1 where status=1 and date(sub_date)<='$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  if($circle == "") $circle="UND";
  elseif($circle == "HAR") $circle="HAY";
  elseif($circle == "PUN") $circle="PUB";

  $insert_data="insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1113)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active where service='MTSMND' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.mtsDailyReport(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1113)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
}
////////////////////////// end code to insert the active base date into the database MTSMPD ///////////////////////////////////////////////
?>