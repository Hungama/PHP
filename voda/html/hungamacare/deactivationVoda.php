<?php
include("dbConnect.php");

if(isset($_REQUEST['date'])) {
	$view_date1=trim($_REQUEST['date']);
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo $view_date1="2013-04-21";

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

$deleteprevioousdata="delete from master_db.dailyReportVodafone where date(report_date)='$view_date1' and type like '%Deactivation%'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone 54646////////////////
$get_deactivation_base="select count(*),circle,unsub_reason ,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	 $unsub_reason="IVR";
		elseif($unsub_reason=="INVOLUNTRY")	$unsub_reason="in";
		elseif($unsub_reason=='CCI') $unsub_reason="CC";	

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,unsub_reason,status,substr(dnis,14,1) as code,dnis from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status,$code,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pcircle = $pauseArray[$circle];
		$pauseCodeVal = $pauseCode[$code];
		$deactivation_str1="Mode_Deactivation_".$pauseCodeVal;
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pcircle','$count','$unsub_reason','NA','NA','NA','1302P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone 54646///////////////////////

///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone VH1////////////////
$get_deactivation_base="select count(*),circle,unsub_reason ,status from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	 $unsub_reason="IVR";
		elseif($unsub_reason=="INVOLUNTRY")	$unsub_reason="in";
		elseif($unsub_reason=='CCI') $unsub_reason="CC";	

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1307)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone VH1///////////////////////

///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone RedFM////////////////
$get_deactivation_base="select count(*),circle,unsub_reason ,status from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	 $unsub_reason="IVR";
		elseif($unsub_reason=="INVOLUNTRY")	$unsub_reason="in";
		elseif($unsub_reason=='CCI') $unsub_reason="CC";	

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1310)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone RedFM///////////////////////


//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////
$get_deactivation_base="select count(*),circle,status from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%p%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////

//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone VH1////////////////////////////////
$get_deactivation_base="select count(*),circle,status from vodafone_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1307)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone VH1////////////////////////////////

//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone RedFM////////////////////////////////
$get_deactivation_base="select count(*),circle,status from vodafone_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1310)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
/////////////////////////////// End code to insert the Deactivation Base into the MIS database For Vodafone RedFM////////////////////////////////


echo 'done';
mysql_close($dbConn);
?>
