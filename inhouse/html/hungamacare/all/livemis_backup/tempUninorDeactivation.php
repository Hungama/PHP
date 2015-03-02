<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo $view_date1='2013-01-15';


//----- pause code array ----------

$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');

//---------------------------------


echo $deleteprevioousdata="delete from mis_db.dailyReportUninor where date(report_date)='$view_date1' and type like '%Deactivation_%'";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());
// end the deletion logic


// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,substr(dnis,14,1) as unsub ,status,dnis from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,unsub_reason,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$unsub_reason=$pauseCode[$unsub_reason];
		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','$unsub_reason','NA','NA','NA','1402P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646/ Uninor Pause Code

// start code to insert the Deactivation Base into the MIS database for UninorAAV

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' and plan_id=95 group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',14021)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorAAV

// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA','1418')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMPMC


// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,unsub_reason ,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data7="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data7, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV

// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,unsub_reason ,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_redfm);
if ($numRows3 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD")	$unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
			$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_redfm="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data_redfm, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorREdfm


// start code to insert the Deactivation Base into the MIS database for UninorManchala

$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1409)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorManchala

// start code to insert the Deactivation Base into the MIS database for UninorJAD
$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database for UninorJAD

// start code to insert the Deactivation Base into the MIS database for UninorCricket
$get_deactivation_base_m="select count(*),circle,unsub_reason ,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($deactivation_base_query_m);
if ($numRows3 > 0)
{
	$deactivation_base_query_m = mysql_query($get_deactivation_base_m, $dbConn) or die(mysql_error());
	while(list($count,$circle,$unsub_reason,$status) = mysql_fetch_array($deactivation_base_query_m))
	{
		if($circle == "") $circle="UND";
		if($unsub_reason=="SELF_REQ" || $unsub_reason=="SELF_REQS")	$unsub_reason="IVR";
		elseif($unsub_reason=="SYSTEM" || $unsub_reason=="system")	$unsub_reason="in";
		elseif($unsub_reason=="CRM" || $unsub_reason=="OBD" || $unsub_reason=='CCI') $unsub_reason="CC";

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;
		if($unsub_reason=='CCI')
				$deactivation_str1="Mode_Deactivation_CC";
		$insert_data_m="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','$unsub_reason','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data_m, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database for UninorCricket


// start code to insert the Deactivation Base into the MIS database for Uninor54646

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis not like '%P%' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1402)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base="select count(*),substr(dnis,9,3) as circle1,status,dnis from uninor_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and dnis like '%P%' group by circle,dnis";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status,$dnis) = mysql_fetch_array($deactivation_base_query))
	{
		$pCircle = $pauseArray[$circle];
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$pCircle','$count','NA','NA','NA','1402P')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for Uninor54646


// start code to insert the Deactivation Base into the MIS database for Uninor AAV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_Artist_Aloud_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','14021')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//----------Uninor AAV

// start code to insert the Deactivation Base into the MIS database for UninorMPMC

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_comedy_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA','1418')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
//----------UninorMPMC

// start code to insert the Deactivation Base into the MIS database for UninorRiya

$get_deactivation_base="select count(*),circle,status from uninor_manchala.tbl_riya_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
        $deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
        while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
        {
                $deactivation_str1="Deactivation_30";
                $insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1409)";
                $queryIns = mysql_query($insert_data, $dbConn);
        }
}

// end code to insert the Deactivation base into the MIS database for UninorRiya



// start code to insert the Deactivation Base into the MIS database for UninorMTV

$get_deactivation_base="select count(*),circle,status from uninor_hungama.tbl_mtv_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1403)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorMTV


// start code to insert the Deactivation Base into the MIS database for UninorRedFM

$get_deactivation_base_redfm="select count(*),circle,status from uninor_redfm.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query_fm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($deactivation_base_query_fm);
if ($numRows2 > 0)
{
	$deactivation_base_query_redfm = mysql_query($get_deactivation_base_redfm, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query_redfm))
	{
		$deactivation_str1="Deactivation_10";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1410)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorRedFM

// start code to insert the Deactivation Base into the MIS database for UninorJAD

$get_deactivation_base="select count(*),circle,status from uninor_jyotish.tbl_Jyotish_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1416)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database for UninorJAD


// start code to insert the Deactivation Base into the MIS database for UninorCricket

$get_deactivation_base="select count(*),circle,status from uninor_cricket.tbl_cricket_unsub where date(unsub_date)='$view_date1' group by circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
	while(list($count,$circle,$status) = mysql_fetch_array($deactivation_base_query))
	{
		$deactivation_str1="Deactivation_30";
		$insert_data="insert into mis_db.dailyReportUninor(report_date,type,circle,total_count,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$count','NA','NA','NA',1408)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

echo "Deactivation Done";

// end code to insert the Deactivation base into the MIS database for UninorCricket

/*** Live Mis DB Connection ***/
/*
$LivdbConn = mysql_connect('192.168.100.218','kunalk.arora','google') or die(mysql_error());
if (!$LivdbConn) {
   die('Could not connect Live: ' . mysql_error());
}

$date=$view_date1;

$serviceArray=array('1403'=>'MTVUninor','1402'=>'Uninor54646','1410'=>'RedFMUninor','1409'=>'RIAUninor','1412'=>'UninorRT','1416'=>'UninorAstro', '14021'=>'AAUninor','1408'=>'UninorSU','1418'=>'UninorComedy','14101'=>'WAPREDFMUninor');

$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra', 'APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu' ,'KOL'=>'Kolkata','NES'=>'NE', 'CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala', 'HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','HAR'=>'Haryana',' '=>'Others');

$airtelQuery = "select report_date,service_id,circle,type,sum(total_count),'0' from mis_db.dailyReportUninor where report_date = '".$date."' and type like '%Deactivation_%' and service_id like '14%' group by service_id,circle,type";
$result = mysql_query($airtelQuery,$dbConn);

$delQuery = "DELETE FROM misdata.dailymis WHERE Date='".$date."' and service IN ('MTVUninor','Uninor54646','RedFMUninor','RIAUninor','UninorRT','UninorAstro', 'UninorArtistAloud', 'UninorSU','UninorComedy','WAPREDFMUninor') and type like '%Deactivation_%'";
$delResult = mysql_query($delQuery,$LivdbConn);

while($row = mysql_fetch_array($result)) {
	$serviceId = trim($row[1]);
	$circleId = trim($row[2]);
	$circleName = $circle_info[strtoupper($circleId)];
	if(!$circleName) $circleName ='Others';
	$serviceName = $serviceArray[$serviceId]; //Date,Service,Circle,Type,Value,Revenue
	if($serviceName && $row[3]) {
		$insertQuery = "INSERT INTO misdata.dailymis VALUES ('".$date."','".$serviceName."','".$circleName."', '".$row[3]."', '".$row[4]."','0')";
		$result1 = mysql_query($insertQuery,$LivdbConn);
	}
}

echo " dailyMIS done";*/
mysql_close($dbConn);
?>
