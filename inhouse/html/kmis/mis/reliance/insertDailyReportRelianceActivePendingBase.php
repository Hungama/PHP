<?php
///////////////////////////////////////////////////////// end the code /////////////////////////////////////////////////////////////////////////
///////////////////////// start code to insert the Pending Base date into the database Reliance 54646//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis not like '%P%' group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1202)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Reliance54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_pending_base = "select count(ani),substr(dnis,9,3) as circle1,dnis from reliance_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis like '%P%' group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0) {
    $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($pending_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_pending_base = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1202P')";
        $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
    }
}

///////////////////////////////// end code to insert the pending base date into the database REliance 54646///////////////////////////////////////
//////////////////////////////// start code to insert the Pending Base date into the database Cricket Mania//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_cricket.tbl_cricket_subscription where status IN (11,0,5) group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1208)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceCM' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

///////////////////////// end code to insert the pending base date into the database Cricket Mania///////////////////////////////////////
/////////////////////////////// start code to insert the Pending Base date into the database Reliance Mtv//////////////////////////////////////

/* $get_pending_base="select count(ani),circle from reliance_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle";
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  $numRows12 = mysql_num_rows($pending_base_query);
  if ($numRows12 > 0)
  {
  $pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($pending_base_query))
  {
  $insert_pending_base="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1203)";
  $queryIns_pending = mysql_query($insert_pending_base, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVReliance' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

////////////////////////// end code to insert the active base date into the database REliance Mtv///////////////////////////////////////
///////////////////////////////// start code to insert the active base date into the database REliance 54646//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis not like '%P%' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1202)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='Reliance54646' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1202)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}

$get_active_base = "select count(*),substr(dnis,9,3) as circle1,dnis from reliance_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0) {
    $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
    while (list($count, $circle, $dnis) = mysql_fetch_array($active_base_query)) {
        $pCircle = $pauseArray[$circle];
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','NA','NA','NA','NA','1202P')";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////////////////// end code to insert the active base date into the database REliance 54646/////////////////////////////////////
////////////////////////////// start code to insert the active base date into the database Cricket Mania//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_cricket.tbl_cricket_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1208)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceCM' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1208)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
//////////////////////////////// end code to insert the active base date into the database Cricket Mania/////////////////////////////////////
///////////////////////////////// start code to insert the active base date into the database relianceMM @jyoti.porwal/////////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceMM' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
        values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the active base date into the database relianceMM @jyoti.porwal////////////////////////////////////
///////////////////////////////// start code to insert the pending base date into the database relianceMM @jyoti.porwal////////////////////////////////////
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='RelianceMM' and status='Pending' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) 
        values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1201)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////////// end code to insert the pending base date into the database relianceMM @jyoti.porwal///////////////////////////////////
/////////////////////// start code to insert the active base date into the database REliance Mtv//////////////////////////////////

/* $get_active_base="select count(*),circle from reliance_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  $numRows = mysql_num_rows($active_base_query);
  if ($numRows > 0)
  {
  $active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
  while(list($count,$circle) = mysql_fetch_array($active_base_query))
  {
  $insert_data="insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1203)";
  $queryIns = mysql_query($insert_data, $dbConn);
  }
  } */
$getActiveBase = "select count(*),circle from misdata.tbl_base_active nolock where service='MTVReliance' and status='Active' and date(date)='$view_date1' group by circle";
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
        $insert_data = "insert into mis_db.dailyReportReliance(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1203)";
        $queryIns = mysql_query($insert_data, $dbConn);
    }
}
///////////////////////////// end code to insert the active base date into the database REliance Mtv/////////////////////////////////////

?>