<?php
include("dbConnect.php");

if(isset($_REQUEST['date'])) {
	$view_date1=trim($_REQUEST['date']);
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
echo $view_date1="2013-04-25";


echo $deleteprevioousdata="delete from master_db.dailyReportVodafone where date(report_date)='$view_date1' and type like 'Mode_Deactivation_%'";
echo $delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

echo $deleteprevioousdata="delete from master_db.dailyReportVodafone where date(report_date)='$view_date1' and type like 'Deactivation_30'";
echo $delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

// end the deletion logic

//----- pause code array ----------

$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');

//---------------------------------

///////////////////////////////////////////////////////////// start code to insert the Deactivation Base into the MIS database Vodafone 54646////////////////
$get_deactivation_base="select count(*),circle,unsub_reason from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if(strtoupper($unsub_reason)=="SELF_REQ" || strtoupper($unsub_reason)=="SELF_REQS")	
			$unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="INVOLUNTRY" || $unsub_reason=="LowBalance" || strtoupper($unsub_reason)=="LOWBALANCE")	
			$unsub_reason="in";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CRM")	
			$unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="155223_SMS" || strtoupper($unsub_reason)=="SM" || strtoupper($unsub_reason)=="321_SMS")	
			$unsub_reason="SMS";
		elseif(strtoupper($unsub_reason)=="321_USSD" )	
			$unsub_reason="USSD";
		elseif(strtoupper($unsub_reason)=="IVR-9xM" )	
			$unsub_reason="9XMIVR";

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
		if(strtoupper($unsub_reason)=="SELF_REQ" || strtoupper($unsub_reason)=="SELF_REQS")	
			$unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="INVOLUNTRY" || $unsub_reason=="LowBalance" || strtoupper($unsub_reason)=="LOWBALANCE")	
			$unsub_reason="in";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CRM")	
			$unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="155223_SMS" || strtoupper($unsub_reason)=="SM" || strtoupper($unsub_reason)=="321_SMS")	
			$unsub_reason="SMS";
		elseif(strtoupper($unsub_reason)=="321_USSD" )	
			$unsub_reason="USSD";
		elseif(strtoupper($unsub_reason)=="IVR-9xM" )	
			$unsub_reason="9XMIVR";

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
		if(strtoupper($unsub_reason)=="SELF_REQ" || strtoupper($unsub_reason)=="SELF_REQS")	
			$unsub_reason="IVR";
		elseif(strtoupper($unsub_reason)=="INVOLUNTRY" || $unsub_reason=="LowBalance" || strtoupper($unsub_reason)=="LOWBALANCE")	
			$unsub_reason="in";
		elseif(strtoupper($unsub_reason)=="CCI" || strtoupper($unsub_reason)=="CRM")	
			$unsub_reason="CC";
		elseif(strtoupper($unsub_reason)=="155223_SMS" || strtoupper($unsub_reason)=="SM" || strtoupper($unsub_reason)=="321_SMS")	
			$unsub_reason="SMS";
		elseif(strtoupper($unsub_reason)=="321_USSD" )	
			$unsub_reason="USSD";
		elseif(strtoupper($unsub_reason)=="IVR-9xM" )	
			$unsub_reason="9XMIVR";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1310)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
///////////////////////////////// end code to insert the Deactivation base into the MIS database Vodafone RedFM///////////////////////

//////////////////////////// start code to insert the Deactivation Base into the MIS database For Vodafone 54646////////////////////////////////
$get_deactivation_base="select count(*),circle from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%p%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1302)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as code,dnis from vodafone_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$code,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pcircle = $pauseArray[$circle];
		$pauseCodeVal = $pauseCode[$code];
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into master_db.dailyReportVodafone(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pcircle','$count','$unsub_reason','NA','NA','NA','1302P')";
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

// ---------- Code end here -------------------

echo 'done';
mysql_close($dbConn);
?>
