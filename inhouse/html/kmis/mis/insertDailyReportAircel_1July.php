<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

if($_REQUEST['date']) {
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//echo $view_date1="2013-04-02";

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

//----- pause code array ----------
$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall','209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');

$pauseCode = array('1'=>'LG','2'=>'MW','3'=>'MJ','4'=>'CW','5'=>'JAD');
//---------------------------------

// delete the prevoius record
$deleteprevioousdata="delete from mis_db.daily_report where date(report_date)='$view_date1' and service_id in (1902,1919,'HUL','1902P')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//////////////////////////////// End delete the data of the previous data//////////////////////////////////////////////////////////////////////////////

//////////start code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in ('airc') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1902','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'Aircel54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in ('airc') group by circle,status";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		if($call_t[5] == 1) $call_t[0] = "L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0] = "N_CALLS_T";
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1902','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

//////////////End code to insert the data for CALLS_T for Aircel 54646///////////////////////////////////////////////////////////////////


//////////start code to insert the data for CALLS_T for Aircel 54646 pause///////////////////////////////////////////////////////////////////

$call_t=array();
$call_t_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in ('airc') group by circle,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$p = $call_t[1];
		$pCircle = $pauseArray[$p];
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pCircle','0','$call_t[2]','','1902P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_t=array();
$call_t_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in ('airc') group by circle,status,dnis";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$p = $call_t[1];
		$pCircle = $pauseArray[$p];
		if($call_t[5] == 1) $call_t[0] = "L_CALLS_T";
		elseif($call_t[5] != 1) $call_t[0] = "N_CALLS_T";
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$pCircle','0','$call_t[2]','','1902P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}


//////////////End code to insert the data for CALLS_T for Aircel 54646 pause///////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for MOU_T for Aircel 54646///////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1902','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}

$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'Aircel54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle,status";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		if($mous_t[6] == 1) $mous_t[0] = "L_MOU_T";
		elseif($mous_t[6] != 1) $mous_t[0] = "N_MOU_T";
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1902','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end

//////////////////////////start code to insert the data for MOU_T for Aircel 54646 pause///////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,dnis";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$p = $mous_t[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pCircle','0','$mous_t[5]','','1902P','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}

$mous_t=array();
$mous_t_query="select 'MOU_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,status,dnis";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$p = $mous_t[1];
		$pCircle = $pauseArray[$p];

		if($mous_t[6] == 1) $mous_t[0] = "L_MOU_T";
		elseif($mous_t[6] != 1) $mous_t[0] = "N_MOU_T";
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$pCircle','0','$mous_t[5]','','1902P','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}
// end

/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1902','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse, status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle,status";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		if($pulse_t[6] == 1) $pulse_t[0] ="L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] ="N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1902','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel 54646 SErvice/////////////////////////////////////////



/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel 54646 SErvice pause/////////////////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$p = $pulse_t[1];
		$pCircle = $pauseArray[$p];
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pCircle','0','$pulse_t[5]','','1902P','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

$pulse_t=array();
$pulse_t_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,status,dnis";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$p = $pulse_t[1];
		$pCircle = $pauseArray[$p];
		if($pulse_t[6] == 1) $pulse_t[0] ="L_PULSE_T";
		elseif($pulse_t[6] != 1) $pulse_t[0] ="N_PULSE_T";
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pCircle','0','$pulse_t[5]','','1902P','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel 54646 SErvice pause/////////////////////////////////////////



//////////////////////////start code to insert the data for Unique Users  for Aircel 54646 //////////////////////////////////////////////
$uu_t=array();
$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','','1902','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}

$uu_t=array();
$uu_t_query = "(select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') and status IN (1)) group by circle)";
$uu_t_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') and status=1 group by circle)";

//$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		if($uu_t[5] == 1) $uu_t[0] = "L_UU_T";
		elseif($uu_t[5] != 1) $uu_t[0] = "N_UU_T";
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','','1902','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}
/////////////////////////// end Unique Users  for Aircel 54646/////////////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for Aircel 54646 pause//////////////////////////////////////////////
$uu_t=array();
$uu_t_query="select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,dnis";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		$p = $uu_t[1];
		$pCircle = $pauseArray[$p];
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$pCircle','0','$uu_t[2]','','1902P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}

$uu_t=array();
$uu_t_query = "(select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') and status IN (1)) group by circle,dnis)";
$uu_t_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle1, count(distinct msisdn),'PauseCode' as service_name,date(call_date),status,'Active' as 'user_status',dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') and status=1 group by circle,dnis)";

//$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and operator in('airc') group by circle,status";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		$p = $uu_t[1];
		$pCircle = $pauseArray[$p];
		if($uu_t[5] == 1) $uu_t[0] = "L_UU_T";
		elseif($uu_t[5] != 1) $uu_t[0] = "N_UU_T";
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$pCircle','0','$uu_t[2]','','1902P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}
/////////////////////////// end Unique Users  for Aircel 54646 pause/////////////////////////////////////////////////////////////////////////

/////////////////////start code to insert the data for SEC_T  for Aircel 54646 ///////////////////////////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1902','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

$sec_t=array();
$sec_t_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '54646%' and dnis not like '5464634P%' and operator in('airc') group by circle,status";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1902','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end insert the data for SEC_T  for Aircel 54646

/////////////////////start code to insert the data for SEC_T  for Aircel 54646 pause ///////////////////////////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$p = $sec_t[1];
		$pCircle = $pauseArray[$p];
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$pCircle','0','$sec_t[5]','','1902P','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

$sec_t=array();
$sec_t_query="select 'SEC_T',substr(dnis,9,3) as circle1, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec), status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464634P%' and operator in('airc') group by circle,status,dnis";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$p = $sec_t[1];
		$pCircle = $pauseArray[$p];
		if($sec_t[6] == 1) $sec_t[0] = "L_SEC_T";
		elseif($sec_t[6] != 1) $sec_t[0] = "N_SEC_T";
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$pCircle','0','$sec_t[5]','','1902P','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}
// end insert the data for SEC_T  for Aircel 54646 pause/////////////////////////

//////////start code to insert the data for CALLS_T for Aircel Lajong///////////////////////////////////////////////////////////////////

$call_t=array();
$call_t_query="select 'CALLS_T',circle, count(id),'AircelLajong' as service_name,date(call_date) from mis_db.tbl_lajong_calllog where date(call_date)='$view_date1' and dnis like '5464646%' and operator in ('airc') group by circle";
$call_t_result = mysql_query($call_t_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_t_result);
if ($numRows1 > 0)
{
	while($call_t = mysql_fetch_array($call_t_result))
	{
		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_t[0]','$call_t[1]','0','$call_t[2]','','1919','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_t_data, $dbConn);
	}
}

//////////////End code to insert the data for CALLS_T for Aircel Lajong///////////////////////////////////////////////////////////////////

//////////////////////////start code to insert the data for MOU_T for Aircel Lajong///////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'AircelLajong' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_lajong_calllog where date(call_date)='$view_date1' and dnis like '5464646%' and operator in('airc') group by circle";
$mous_t_result = mysql_query($mous_t_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_t_result);
if ($numRows2 > 0)
{
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$insert_mous_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$mous_t[0]','$mous_t[1]','0','$mous_t[5]','','1919','$mous_t[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_t_data, $dbConn);
	}
}


/////////////////////////////////////////start code to insert the data for PULSE_T for the Aircel Lajong SErvice/////////////////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_lajong_calllog where date(call_date)='$view_date1' and dnis like '5464646%' and operator in('airc') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_t_result);
if ($numRows3 > 0)
{
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$insert_pulse_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$pulse_t[0]','$pulse_t[1]','0','$pulse_t[5]','','1919','NA','$pulse_t[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_t_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Aircel Lajong SErvice/////////////////////////////////////////

//////////////////////////start code to insert the data for Unique Users  for Aircel Lajong //////////////////////////////////////////////
$uu_t=array();
$uu_t_query="select 'UU_T',circle, count(distinct msisdn),'54646' as service_name,date(call_date) from mis_db.tbl_lajong_calllog where date(call_date)='$view_date1' and dnis like '5464646%' and operator in('airc') group by circle";

$uu_t_result = mysql_query($uu_t_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_t_result);
if ($numRows4 > 0)
{
	while($uu_t = mysql_fetch_array($uu_t_result))
	{
		$insert_uu_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_t[0]','$uu_t[1]','0','$uu_t[2]','','1919','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_t_data, $dbConn);
	}
}

/////////////////////////// end Unique Users  for Aircel Lajong/////////////////////////////////////////////////////////////////////////

/////////////////////start code to insert the data for SEC_T  for Aircel Lajong ///////////////////////////////////////////////////

$sec_t=array();
$sec_t_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_lajong_calllog where date(call_date)='$view_date1' and dnis like '5464646%' and operator in('airc') group by circle";

$sec_t_result = mysql_query($sec_t_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_t_result);
if ($numRows5 > 0)
{
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$insert_sec_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_t[0]','$sec_t[1]','0','$sec_t[5]','','1919','NA','NA','$sec_t[5]')";
		$queryIns_sec = mysql_query($insert_sec_t_data, $dbConn);
	}
}

// end insert the data for SEC_T  for Aircel Lajong

////////////////// Recording data for Aircel Lajong service //////////////////////////

$recCall_query="SELECT 'REC_CALL',count(ANI), circle FROM aircel_hungama.tbl_jbox_recording_lajong where date(date_time)='$view_date1' group by circle";

$recCall_result = mysql_query($recCall_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($recCall_result);
if ($numRows > 0)
{
	while($recData = mysql_fetch_array($recCall_result))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData[0]','$recData[2]','0','$recData[1]','','1919','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$recu_query="SELECT 'REC_UU',count(distinct ANI), circle FROM aircel_hungama.tbl_jbox_recording_lajong where date(date_time)='$view_date1' group by circle";

$recu_result = mysql_query($recu_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($recu_result);
if ($numRows > 0)
{
	while($recData1 = mysql_fetch_array($recu_result))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','1919','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

////////////////// Recording data for Aircel Lajong service code end here //////////////////////////

////////////////// HUL Data ///////////////////////

$recu_query="SELECT 'M_CALL_TF',count(ANI),circle FROM newseleb_hungama.tbl_max_bupa_details WHERE date(date_time)='$view_date1' group by circle";

$recu_result = mysql_query($recu_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($recu_result);
if ($numRows > 0)
{
	while($recData1 = mysql_fetch_array($recu_result))
	{
		$insert_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data, $dbConn);
	}
}

$recu_query1="SELECT 'M_UU_TF',count(distinct ANI),circle FROM newseleb_hungama.tbl_max_bupa_details WHERE date(date_time)='$view_date1' group by circle";

$recu_result1 = mysql_query($recu_query1, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($recu_result1);
if ($numRows1 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result1))
	{
		$insert_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data1, $dbConn);
	}
}

$recu_query2="SELECT 'COBD_*',count(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' group by circle";

$recu_result2 = mysql_query($recu_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($recu_result2);
if ($numRows2 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result2))
	{
		$insert_data2="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

$recu_query3="SELECT 'COBD_SUCC',count(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=2 group by circle";

$recu_result3 = mysql_query($recu_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($recu_result3);
if ($numRows3 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result3))
	{
		$insert_data3="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}


$recu_query4="SELECT 'COBD_UU',count(distinct ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=2 group by circle";

$recu_result4 = mysql_query($recu_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($recu_result4);
if ($numRows4 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result4))
	{
		$insert_data4="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data4, $dbConn);
	}
}

$recu_query5="SELECT 'COBD_SEC',sum(duration),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=2 group by circle";

$recu_result5 = mysql_query($recu_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($recu_result5);
if ($numRows5 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result5))
	{
		$insert_data5="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

$recu_query6="SELECT 'COBD_MOU',ceil(sum(duration)/60),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=2 group by circle";

$recu_result6 = mysql_query($recu_query6, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($recu_result6);
if ($numRows6 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result6))
	{
		$insert_data6="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data6, $dbConn);
	}
}

$recu_query7="SELECT 'COBD_NA',COUNT(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=1 and error_code='noanswer' group by circle";

$recu_result7 = mysql_query($recu_query7, $dbConn) or die(mysql_error());
$numRows7 = mysql_num_rows($recu_result7);
if ($numRows7 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result7))
	{
		$insert_data7="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data7, $dbConn);
	}
}


$recu_query8="SELECT 'COBD_WAT',COUNT(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=1 and error_code='busy' group by circle";

$recu_result8 = mysql_query($recu_query8, $dbConn) or die(mysql_error());
$numRows8 = mysql_num_rows($recu_result8);
if ($numRows8 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result8))
	{
		$insert_data8="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data8, $dbConn);
	}
}

$recu_query9="SELECT 'COBD_SEC_',COUNT(ANI),circle,duration  FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL' and status=2 group by circle,duration";

$recu_result9 = mysql_query($recu_query9, $dbConn) or die(mysql_error());
$numRows9 = mysql_num_rows($recu_result9);
if ($numRows9 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result9))
	{
		if($recData1[3]<5) $recData1[0]='COBD_SEC_5';
		elseif($recData1[3]>=5 && $recData1[3]<=15) $recData1[0]='COBD_SEC_6';
		elseif($recData1[3]>=16 && $recData1[3]<=25) $recData1[0]='COBD_SEC_16';
		elseif($recData1[3]>25 && $recData1[3]<=35) $recData1[0]='COBD_SEC_26';
		elseif($recData1[3]>35) $recData1[0]='COBD_SEC_35';

		$insert_data9="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data9, $dbConn);
	}
}


////////////////// HUL Data End Here //////////////

////////////////// HUL-PROMO Data ///////////////////////

$recu_query2="SELECT 'PCOBD_*',count(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' group by circle";

$recu_result2 = mysql_query($recu_query2, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($recu_result2);
if ($numRows2 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result2))
	{
		$insert_data2="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data2, $dbConn);
	}
}

$recu_query3="SELECT 'PCOBD_SUCC',count(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=2 group by circle";

$recu_result3 = mysql_query($recu_query3, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($recu_result3);
if ($numRows3 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result3))
	{
		$insert_data3="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data3, $dbConn);
	}
}


$recu_query4="SELECT 'PCOBD_UU',count(distinct ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=2 group by circle";

$recu_result4 = mysql_query($recu_query4, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($recu_result4);
if ($numRows4 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result4))
	{
		$insert_data4="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data4, $dbConn);
	}
}

$recu_query5="SELECT 'PCOBD_SEC',sum(duration),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=2 group by circle";

$recu_result5 = mysql_query($recu_query5, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($recu_result5);
if ($numRows5 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result5))
	{
		$insert_data5="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data5, $dbConn);
	}
}

$recu_query6="SELECT 'PCOBD_MOU',ceil(sum(duration)/60),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=2 group by circle";

$recu_result6 = mysql_query($recu_query6, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($recu_result6);
if ($numRows6 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result6))
	{
		$insert_data6="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data6, $dbConn);
	}
}

$recu_query7="SELECT 'PCOBD_NA',COUNT(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=1 and error_code='noanswer' group by circle";

$recu_result7 = mysql_query($recu_query7, $dbConn) or die(mysql_error());
$numRows7 = mysql_num_rows($recu_result7);
if ($numRows7 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result7))
	{
		$insert_data7="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data7, $dbConn);
	}
}


$recu_query8="SELECT 'PCOBD_WAT',COUNT(ANI),circle FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=1 and error_code='busy' group by circle";

$recu_result8 = mysql_query($recu_query8, $dbConn) or die(mysql_error());
$numRows8 = mysql_num_rows($recu_result8);
if ($numRows8 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result8))
	{
		$insert_data8="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data8, $dbConn);
	}
}

$recu_query9="SELECT 'PCOBD_SEC_',COUNT(ANI),circle,duration  FROM hul_hungama.tbl_hulobd_success_fail_details WHERE date(date_time)='$view_date1' and service='HUL_PROMOTION' and status=2 group by circle,duration";

$recu_result9 = mysql_query($recu_query9, $dbConn) or die(mysql_error());
$numRows9 = mysql_num_rows($recu_result9);
if ($numRows9 > 0)
{
	while($recData1 = mysql_fetch_array($recu_result9))
	{
		if($recData1[3]<5) $recData1[0]='PCOBD_SEC_5';
		elseif($recData1[3]>=5 && $recData1[3]<=15) $recData1[0]='PCOBD_SEC_6';
		elseif($recData1[3]>=16 && $recData1[3]<=25) $recData1[0]='PCOBD_SEC_16';
		elseif($recData1[3]>25 && $recData1[3]<=35) $recData1[0]='PCOBD_SEC_26';
		elseif($recData1[3]>35) $recData1[0]='PCOBD_SEC_35';

		$insert_data9="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$recData1[0]','$recData1[2]','0','$recData1[1]','','HUL','NA','NA','NA')";
		$queryIns = mysql_query($insert_data9, $dbConn);
	}
}

////////////////// HUL-PROMO Data End Here //////////////



//-------------------------- Etisalat MIS --------------------------------

// delete the prevoius record
$deleteprevioousdata="delete from mis_db.dailyReportEtislat where date(report_date)='$view_date1' and service_id in ('2121')";
$delete_result = mysql_query($deleteprevioousdata, $dbConn) or die(mysql_error());

//Active base
$activeBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status=1 and date(sub_date)<='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status=1 and date(sub_date)<='$view_date1'";

$activeBaseQuery = mysql_query($activeBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($activeBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($activeBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type, mous,pulse,total_sec,service_id) values('$view_date1','Active_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Pending Base
$pendingBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription WHERE status IN (11,0,12) and date(sub_date)<='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription WHERE status IN (11,0,12) and date(sub_date)<='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription WHERE status IN (11,0,12) and date(sub_date)<='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription WHERE status IN (11,0,12) and date(sub_date)<='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription WHERE status IN (11,0,12) and date(sub_date)<='$view_date1'";

$pendingBaseQuery = mysql_query($pendingBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($pendingBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($pendingBaseQuery))
	{
		if($count) {
			if($circle=='') $circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','Pending_Base' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Activation
$get_activation_query="select count(msisdn),chrg_amount,service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in (2121) and event_type in('SUB') group by service_id,chrg_amount,plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";
                        
			$activation_str="Activation_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Mode Activation
$get_mactivation_query="select count(msisdn),chrg_amount,service_id,plan_id,mode from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,chrg_amount,plan_id,mode";
$get_mactivation_result = mysql_query($get_mactivation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_mactivation_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id,$mode) = mysql_fetch_array($get_mactivation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$activation_str="Mode_Activation_".$mode; //.$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$activation_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// Renewal
$get_renewal_query="select count(msisdn),chrg_amount,service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('RESUB') group by service_id,chrg_amount,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$charging_amt,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$renewal_str="Renewal_".$charging_amt;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', '$renewal_str','$circle','$service_id','$charging_amt','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

//Deactivation
$unsubBase = "select count(*),'SPL' FROM etislat_hsep.tbl_sfp_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'EPL' FROM etislat_hsep.tbl_epl_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Fun' FROM etislat_hsep.tbl_funnews_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Jokes' FROM etislat_hsep.tbl_jokes_subscription_log WHERE  date(unsub_date)='$view_date1'
UNION
select count(*),'Hollywood' FROM etislat_hsep.tbl_hollywood_subscription_log WHERE  date(unsub_date)='$view_date1'";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') 
			$circle='Others';
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous, pulse,total_sec,service_id) values('$view_date1','Deactivation_75' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// Mode Deactivation
$unsubBase = "select count(*),'SPL',UNSUB_REASON FROM etislat_hsep.tbl_sfp_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'EPL',UNSUB_REASON FROM etislat_hsep.tbl_epl_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Fun',UNSUB_REASON FROM etislat_hsep.tbl_funnews_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Jokes',UNSUB_REASON FROM etislat_hsep.tbl_jokes_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
UNION
select count(*),'Hollywood',UNSUB_REASON FROM etislat_hsep.tbl_hollywood_subscription_log WHERE  date(unsub_date)='$view_date1' group by UNSUB_REASON
";

$unsubBaseQuery = mysql_query($unsubBase, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($unsubBaseQuery);
if ($numRows > 0)
{
	while(list($count,$circle,$unsubReason) = mysql_fetch_array($unsubBaseQuery))
	{
		if($count) {
			if($circle=='') 
				$circle='Others';
			if(strtoupper($unsubReason)=='INVOL')
				$unsubReason='in';
			$unsubStr = "Mode_Deactivation_".$unsubReason;
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,charging_rate,total_count,mode_of_sub,sub_type,mous,pulse,total_sec,service_id) values('$view_date1','$unsubStr' ,'$circle','NA','$count','NA','NA','NA','NA','NA',2121)";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_content
$get_activation_query="select count(*),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type='Alert' group by plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";
			else $circle="Others";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_Content','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_Content
$get_activation_query="select count(distinct ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type='Alert' group by plan_id";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";
			else $circle="Others";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_Content','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_MO
$get_renewal_query="select count(msisdn),service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id
UNION
select count(msisdn),service_id,plan_id from master_db.tbl_billing_failure nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_MO','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_MO
$get_renewal_query="select count(distinct msisdn),service_id,plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id
UNION
select count(distinct msisdn),service_id,plan_id from master_db.tbl_billing_failure nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by service_id,plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$service_id,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_MO','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// SMS_Invalid_MO
$get_activation_query="select count(ani),valid_status FROM etislat_hsep.tbl_mo_received where date(date_time)='$view_date1' and valid_status=0 group by valid_status";
$get_activation_result = mysql_query($get_activation_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_activation_result);
if ($numRows > 0)
{
	while(list($count,$status) = mysql_fetch_array($get_activation_result))
	{
		if($count) {
			$circle="Others";
			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_Invalid_MO','$circle','2121','0','$count','NA','NA','NA')";
			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}


// SMS_MT
$get_renewal_query="select count(msisdn),plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by plan_id
UNION
select count(ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type IN ('Alert','PRERENEW') group by plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		$service_id='2121';
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'SMS_MT','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}

// UU_MT
$get_renewal_query="select count(distinct msisdn),plan_id from ".$successTable." nolock where DATE(response_time)='$view_date1' and service_id in(2121) and event_type in('SUB') group by plan_id
UNION
select count(distinct ani),plan_id FROM etislat_hsep.tbl_sms_alert_send where date(date_time)='$view_date1' and type IN ('Alert','PRERENEW') group by plan_id";
$get_renewal_result = mysql_query($get_renewal_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($get_renewal_result);
if ($numRows > 0)
{
	while(list($count,$plan_id) = mysql_fetch_array($get_renewal_result))
	{
		$service_id='2121';
		if($count) {
			if($plan_id=="125" || $plan_id =="126" || $plan_id =="166") $circle="EPL";
			elseif($plan_id=="119" || $plan_id =="124" || $plan_id =="172") $circle="SPL";
			elseif($plan_id=="118" || $plan_id =="123" || $plan_id =="170") $circle="Fun";
			elseif($plan_id=="116" || $plan_id =="121" || $plan_id =="168") $circle="Jokes";
			elseif($plan_id=="117" || $plan_id =="122" || $plan_id =="171") $circle="Hollywood";
			elseif($plan_id=="115" || $plan_id =="120" || $plan_id =="169") $circle="Astro";

			$insert_data="insert into mis_db.dailyReportEtislat(report_date,type,circle,service_id,charging_rate,total_count,mous,pulse,total_sec) values('$view_date1', 'UU_MT','$circle','$service_id','0','$count','NA','NA','NA')";

			$queryIns = mysql_query($insert_data, $dbConn);
		}
	}
}
//--------------------------- End here -----------------------------------

mysql_close($dbConn);
echo "done";
?>
