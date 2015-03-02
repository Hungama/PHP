<?php
///////////////// Start code to insert the Pending Base date into the database Docomo Endless Music///////////////////////////////////
/*
$get_pending_base="select count(ani),circle from docomo_radio.tbl_radio_subscription where status IN (11,0,5) AND plan_id NOT IN (40,85) group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle=='') $circle='UND';
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1001)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo 54646///////////////////////////////////


/*$get_pending_base="select count(ani),circle from docomo_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis not like '%P%' group by circle";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pending_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','','$count','NA','NA','NA',1002)";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}*/
$get_pending_base="select count(ani),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_subscription where status IN (11,0,5) and dnis like '%P%' group by circle,dnis";
$pending_base_query = mysql_query($get_pending_base, $dbConn) or die(mysql_error());

$numRows12 = mysql_num_rows($pending_base_query);
if ($numRows12 > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($pending_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_pending_base="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$pCircle','','$count','NA','NA','NA','1002P')";
		$queryIns_pending = mysql_query($insert_pending_base, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////



///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Filmi Meri Jaan//////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_starclub.tbl_jbox_subscription where status IN (11,0,5) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1005)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
///////////////////////////////////// Start code to insert the Pending Base date into the database Docomo Miss Riya////////////////////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and plan_id!=73 and date(sub_date)<='".$view_date1."' group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1009)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
////////// Start code to insert the Pending Base date into the database Docomo MTV////////////////////////////////////////////////////////////

/*
$getPendingBase="select count(ani),circle from docomo_hungama.tbl_mtv_subscription where status IN (11,0,5) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1003)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
////////// Start code to insert the Pending Base date into the database Docomo REDFM////////////////////////////////////////////////////////////
/*
$getPendingBase="select count(ani),circle from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and plan_id!=72 group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1010)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}*/
////////// Start code to insert the Pending Base date into the database Docomo GL////////////////////////////////////////////////////////////

$getPendingBase="select count(ani),circle from docomo_rasoi.tbl_rasoi_subscription where status IN (11,0,5) and plan_id IN (66,75,76) group by circle";
$pendingBaseQuery = mysql_query($getPendingBase, $dbConn) or die(mysql_error());
$numRowsFmj = mysql_num_rows($pendingBaseQuery);
if ($numRowsFmj > 0)
{
	while(list($fmjCount,$fmjCircle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($fmjCircle=='' || $fmjCircle=='0') $fmjCircle='UND';
		elseif(strtoupper($fmjCircle)=='HAR') $fmjCircle='HAY';
		$insertPendingBase="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$fmjCircle','','$fmjCount','NA','NA','NA',1011)";
		$queryInsPending = mysql_query($insertPendingBase, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo GL//////////////////////////////////////////////////////////
?>
