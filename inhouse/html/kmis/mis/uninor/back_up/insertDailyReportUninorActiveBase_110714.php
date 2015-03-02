<?

////////////////////////// start code to insert the Pending base data into the database for UninorContest/////////////////////////////////////

$getActiveBaseContest="select count(*),circle from misdata.tbl_base_active nolock where service='UninorContest' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQueryContest = mysql_query($getActiveBaseContest, $LivdbConn) or die(mysql_error());
$numRowsContest = mysql_num_rows($activeBaseQueryContest);
if ($numRowsContest > 0)
{
	while(list($countContest,$circle) = mysql_fetch_array($activeBaseQueryContest))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countContest','NA','NA','NA','NA','NA',1423)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////// end code to insert the active base data into the database for UninorContest/////////////////////////////////////

///////////////////////////// start code to insert the active base data into the database for Uninor54646/////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='Uninor54646' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
////////////////////////////// end code to insert the active base data into the database for UninorCricket//////////////////////////////

$get_active_base="select count(*),substr(dnis,9,1) as circle1,dnis from uninor_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=95 and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$dnis) = mysql_fetch_array($active_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$insert_data3="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,sub_type,mous,pulse,total_sec) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','1402P','NA','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}
////////////////////////// end code to insert the active base data into the database for Uninor54646////////////////////////////////////////

///////////////////////// start code to insert the active base data into the database for UninorAAV/////////////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='AAUninor' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',14021)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
////////////////////////// end code to insert the active base data into the database for UninorAAV///////////////////////////////////////////

////////////////////////// start code to insert the active base data into the database for UninorMPMC///////////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='UninorComedy' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1418)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////// end code to insert the active base data into the database for UninorMPMC////////////////////////////////////////

/////////////////////////////// start code to insert the active base data into the database for UninorMTV///////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='MTVUninor' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
////////////////////////////////////// end code to insert the active base data into the database for UninorMTV///////////////////////////////

////////////////////////////////// start code to insert the active base data into the database for UninorRedFM /////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RedFMUninor' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////// end code to insert the active base data into the database for UninorREdFm//////////////////////////////////////

///////////////////////////////// start code to insert the active base data into the database for UninorManchala////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RIAUninor' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////// start code to insert the Active base data into the database for UninorJAD//////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='UninorAstro' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code to insert the active base data into the database for UninorJAD///////////////////////////

///////////////////////// start code to insert the active base data into the database for UninorCricket/////////////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='UninorSU' and status='Active' and date(date)='$view_date1' group by circle";
$activeBaseQuery1 = mysql_query($getActiveBase, $LivdbConn) or die(mysql_error());
$numRowsRIA = mysql_num_rows($activeBaseQuery1);
if ($numRowsRIA > 0)
{
	while(list($countGL,$circle) = mysql_fetch_array($activeBaseQuery1))
	{
		$circle1 = $circle_info1[$circle];
		if($circle1 == "") $circle1="UND";
		elseif($circle1 == "HAR") $circle1="HAY";
		elseif($circle1 == "PUN") $circle1="PUB";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////// end code to insert the active base data into the database for UninorCricket////////////////////////////////////

?>
