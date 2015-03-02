<?php
// start code to insert the Deactivation Base into the MIS database Airtel 54646
$get_deactivation_base="select count(*),circle,unsub_reason 
from airtel_hungama.tbl_jbox_unsub where date(unsub_date)='$view_date1' and plan_id NOT IN (50) group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") 
                    $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";
                
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646 

// start code to insert the Deactivation Base into the MIS database AirtelMPMC
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_comedyportal_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1518)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMPMC

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_mtv_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV
/// start code to insert the Deactivation Base into the MIS database AirtelRIA
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_manchala.tbl_riya_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

// start code to insert the Deactivation Base into the MIS database AirtelVH1
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_vh1.tbl_jbox_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelVH1 

// start code to insert the Deactivation Base into the MIS database AirtelGL
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_rasoi.tbl_rasoi_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelGL 

// start code to insert the Deactivation Base into the MIS database AirtelEDU
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_EDU.tbl_jbox_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEDU

// start code to insert the Deactivation Base into the MIS database AirtelMND

$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 
where date(unsub_date)='$view_date1' and plan_id !=81 group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}



$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 
where date(unsub_date)='$view_date1' and plan_id =81 group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',15131)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database AirtelMND
//  CHANDER
// start code to insert the Deactivation Base into the MIS database AirtelDevo
 $get_deactivation_base1="select count(*),circle,unsub_reason from airtel_devo.tbl_devo_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_10','$circle','NA','$count','NA','NA','NA','NA',1515)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelDevo

// start code to insert the Deactivation Base into the MIS database AirtelSE
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_SPKENG.tbl_spkeng_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_2','$circle','NA','$count','NA','NA','NA','NA',1517)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelSE

// start code to insert the Deactivation Base into the MIS database AirtelPK

$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_hungama.tbl_pk_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',1520)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

// end code to insert the Deactivation base into the MIS database AirtelPK

// start code to insert the Deactivation Base into the MIS database AirtelEU
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_radio.tbl_radio_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_10','$circle','NA','$count','NA','NA','NA','NA',1501)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEU

// start code to insert the Deactivation Base into the MIS database AirtelCK
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_hungama.tbl_arm_unsub 
where date(unsub_date)='$view_date1' and plan_id=64 group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',15221)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelCK

// start code to insert the Deactivation Base into the MIS database AirtelMAN
$get_deactivation_base1="select count(*),circle,unsub_reason from airtel_hungama.tbl_arm_unsub 
where date(unsub_date)='$view_date1' and plan_id=63 group by unsub_reason,circle";

$deactivation_base_query1 = mysql_query($get_deactivation_base1, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query1);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($deactivation_base_query1))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', 'Deactivation_30','$circle','NA','$count','NA','NA','NA','NA',15222)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMAN

//////////////////////////////////////////////////////////////////Deactivatin 30////////////////////////////////////////////////////////////


////////////////////////////////////////////// Mode_Deactivation /////////////////////////////////////////////////////////////////////////////

// start code to insert the Deactivation Base into the MIS database Airtel 54646
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_jbox_unsub 
where date(unsub_date)='$view_date1' and plan_id NOT IN (50) group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr)=='in') 
			$unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') 
			$unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') 
			$unsub_reason = "UD";

                $deactivation_str1="Mode_Deactivation_".$unsub_reason;
                $insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1502)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel 54646

// start code to insert the Deactivation Base into the MIS database AirtelMPMC
$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_comedyportal_unsub 
where date(unsub_date)='$view_date1' group by circle,unsub_reason";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') 
			$unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";

                $deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1518)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMPMC

// start code to insert the Deactivation Base into the MIS database Airtel MTV

$get_deactivation_base="select count(*),circle,unsub_reason from airtel_hungama.tbl_mtv_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query = mysql_query($get_deactivation_base, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";
                $deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) 
                values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1503)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database Airtel MTV

// start code to insert the Deactivation Base into the MIS database AirtelRIA

$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_manchala.tbl_riya_unsub 
where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','$chrg_amount','$count','$unsub_reason','NA','NA','NA',1509)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelRIA 

// start code to insert the Deactivation Base into the MIS database AirtelVH1

$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_vh1.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";

		//elseif($unsub_reason == '546461'  || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1507)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelVH1 

// start code to insert the Deactivation Base into the MIS database AirtelGL
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_rasoi.tbl_rasoi_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";

	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1511)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelGL

// start code to insert the Deactivation Base into the MIS database AirtelEDU
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_EDU.tbl_jbox_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1514)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEDU

// start code to insert the Deactivation Base into the MIS database AirtelMND
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' and plan_id!=81 group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1513)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_mnd.tbl_character_unsub1 where date(unsub_date)='$view_date1' and plan_id=81 group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS' ) $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',15131)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}


// end code to insert the Deactivation base into the MIS database AirtelMND

// start code to insert the Deactivation Base into the MIS database AirtelDevo
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_devo.tbl_devo_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1515)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelDevo

// start code to insert the Deactivation Base into the MIS database AirtelSE
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_SPKENG.tbl_spkeng_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1517)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelSE

// start code to insert the Deactivation Base into the MIS database AirtelPK
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_hungama.tbl_pk_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		//if($unsub_reason == 'Involuntary') $unsub_reason = "in";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1520)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelPK

// start code to insert the Deactivation Base into the MIS database AirtelEU
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_radio.tbl_radio_unsub where date(unsub_date)='$view_date1' group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',1501)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelEU

// start code to insert the Deactivation Base into the MIS database AirtelCK
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_hungama.tbl_arm_unsub where date(unsub_date)='$view_date1' and plan_id=64 group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";


	//	elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',15221)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelCK

// start code to insert the Deactivation Base into the MIS database AirtelMAN
$get_deactivation_base2="select count(*),circle,unsub_reason from airtel_hungama.tbl_arm_unsub where date(unsub_date)='$view_date1' and plan_id=63 group by unsub_reason,circle";

$deactivation_base_query2 = mysql_query($get_deactivation_base2, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($deactivation_base_query2);
if ($numRows > 0)
{
	while(list($count,$circle,$unsub_reason) = mysql_fetch_array($deactivation_base_query2))
	{
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";
		
		$unsub_reason_lwr= strtolower($unsub_reason);
		if($unsub_reason_lwr == 'involuntary' || $unsub_reason_lwr == 'bulk' || strtolower($unsub_reason_lwr) == 'in') $unsub_reason = "in";
		elseif($unsub_reason_lwr == 'self_req' || $unsub_reason_lwr == 'self_reqs') $unsub_reason = "START/STOP";
		elseif($unsub_reason_lwr == 'voluntary') $unsub_reason = "UD";

		//elseif($unsub_reason == '546461' || $unsub_reason == 'SELF_REQS') $unsub_reason ='IVR';

		$deactivation_str1="Mode_Deactivation_".$unsub_reason;

		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,mous,pulse,total_sec,service_id) values('$view_date1', '$deactivation_str1','$circle','','$count','$unsub_reason','NA','NA','NA',15222)";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}
// end code to insert the Deactivation base into the MIS database AirtelMAN



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>