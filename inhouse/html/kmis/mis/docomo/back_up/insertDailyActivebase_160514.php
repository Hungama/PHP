<?php 

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMX' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the active base date into the database Docomo Endless Music///////////////////////////////

$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMo54646' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoFMJ' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//// end code to insert the active base date into the databases Docomo Filmi Meri Jaan////////////////////////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='MTVTataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo MTV//////////////////////////////////////////////////////////////
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMo' and status='Pending' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Pending_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

///////// end code to insert the active base date into the databases Docomo REDFM//////////////////////////////////////////////////////////
///////////// start code to insert the active base date into the database Docomo Endless Music///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_radio.tbl_radio_subscription where status=1 AND plan_id != 40 and date(sub_date) <= '$view_date1' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoMX' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Endless Music//////////////////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo 54646///////////////////////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis not like '%P%' group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMo54646' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_active_base="select count(*),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and dnis like '%P%' group by circle,dnis";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($active_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$pCircle','NA','$count','NA','NA','NA','NA','NA','1002P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo 54646//////////////////////////////////////////////////////



/////////////////////////// start code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_starclub.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='TataDoCoMoFMJ' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan/////////////////////////////


////////////////////////////// start code to insert the active base date into the database Docomo Miss Riya/////////////////////////////////
/*
$get_active_base="select count(*),circle from docomo_manchala.tbl_riya_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=73 group by circle";
$active_base_query = mysql_query($get_active_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($active_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($active_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		else $circle=substr($circle,0,3);
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RIATataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////// end code to insert the active base date into the database Docomo Miss Riya////////////////////////////////////


//////////////////////////////// start code to insert the active base date into the database Docomo MTV ////////////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_hungama.tbl_mtv_subscription where status=1 and date(sub_date) <= '$view_date1' group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='MTVTataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo Filmi Meri Jaan////////////////////////////////////////////

//////////////////////////////// start code to insert the active base date into the database Docomo REDFM ////////////////////////////////////////////
/*
$getActiveBase="select count(*),circle from docomo_redfm.tbl_jbox_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id!=72 group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}*/
$getActiveBase="select count(*),circle from misdata.tbl_base_active nolock where service='RedFMTataDoCoMo' and status='Active' and date(date)='$view_date1' group by circle";
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
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec, service_id) values('$view_date1','Active_Base' ,'$circle1','NA','$countGL','NA','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo REDFM////////////////////////////////////////////

//////////////////////////////// start code to insert the active base date into the database Docomo GL ////////////////////////////////////////////

$getActiveBase="select count(*),circle from docomo_rasoi.tbl_rasoi_subscription where status=1 and date(sub_date) <= '$view_date1' and plan_id IN (66,75,76) group by circle";
$activeBaseQuery = mysql_query($getActiveBase, $dbConn) or die(mysql_error());
$numRowsfmj = mysql_num_rows($activeBaseQuery);
if ($numRowsfmj > 0)
{
	while(list($countfmj,$circlefmj) = mysql_fetch_array($activeBaseQuery))
	{
		if($circlefmj=='' || $circlefmj=='0') $circlefmj='UND';
		elseif(strtoupper($circlefmj)=='HAR') $circlefmj='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circlefmj','NA','$countfmj','NA','NA','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the active base date into the database Docomo GL////////////////////////////////////////////
?>