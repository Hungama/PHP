<?php

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id = 85 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{	
		if($circle=='') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CC" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CCI";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_SMSPack-".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo endless Music//////////////////////

$get_deactivation_base="select count(*),circle from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id NOT IN (40,85) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo endless Music//////////////////////


////////////////////////////////////////////// Start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,dnis from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle= $pauseArray[$circle];
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$pCircle','NA','$count','NA','NA','NA','NA','1002P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo 54646//////////////////////


//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Filmi Meri Jaan///////////////////////////////


$get_deactivation_base="select count(*),circle from docomo_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////


//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Miss Riya////////////////////////////////////////////


$get_deactivation_base="select count(*),circle from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id!=73 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base="select count(*),circle from docomo_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo MTV////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV//////////////////////

$get_deactivation_base="select count(*),circle from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=72 group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo MTV////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo GL//////////////////////

$get_deactivation_base="select count(*),circle from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (66,75,76) group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows >= 1)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

//////////////////////// end code to insert the Deactivation base into the MIS database Docomo GL////////////////////////////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Endless Music//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' AND plan_id != 40 group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{	
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CC" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CCI";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

	
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1001)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

/////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo Endless Music  //////////////////////


////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo 54646//////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{ 
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount=0;
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1002)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub,dnis from docomo_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis ";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason,$dnis) = mysql_fetch_array($deactivation_base_query))
	{ 
		$pCircle= $pauseArray[$circle];
		$mode = $pauseCode[$unsub_reason];

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$chrg_amount','$count','$unsub_reason','NA','NA','NA','1002P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database  Docomo 54646 //////////////////////


/////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Filmi Meri Jaan  //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_starclub.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1005)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



//////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Docomo Miss Riya  //////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' and plan_id!=73 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1009)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////////////////////////////////// end code to insert the Deactivation base into the MIS database Docomo Filmi Meri Jaan//////////////////////



//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo MTV////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		$chrg_amount="0";
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";


		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1003)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo MTV

//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo REDFM////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id!=72 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";


		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1010)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo REDFM

//////////////////////// start code to insert the Deactivation Base into the MIS database Docomo GL////////////////////////////////////////////

$get_deactivation_base="select count(*),circle,unsub_reason from docomo_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' and plan_id IN (66,75,76) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle=='' || $circle=='0') $circle='UND';
		elseif(strtoupper($circle)=='HAR') $circle='HAY';
		if($unsub_reason=="SELF_REQ")	
			$unsub_reason="IVR";

		if($unsub_reason=="155223") $unsub_reason="IVR_155223";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CCARE") $unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="CHURN" || strtoupper($unsub_reason)=="SYSTEM" || strtoupper($unsub_reason)=="WDSCHURN" || strtoupper($unsub_reason)=="LOWBALANCE" || strtoupper($unsub_reason)=="IMIADMIN") $unsub_reason="in";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1011)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database Docomo GL
?>