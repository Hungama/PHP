<?php
///////////////////////////////////////////////////////////  PULSE_TF ///////////////////////////////////////////////////////////////////////////////

//////////////////////////////////start code to insert the data for PULSE_TF airtel 54646///////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or 
dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
and dnis not in('546461','546461000','5464612') and dnis not like '%P%' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or 
dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') 
and dnis not like '%P%' and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end

//start code to insert pause code
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1502P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1502P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1502P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status,dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p = $pulse_tf[1];
		$pCircle = $pauseArray[$p];
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1502P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
// end

/////////////////////////////start code to insert the data for PULSE_TF AirtelMPMC///////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464612') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1518','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464640') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1518','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1518','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) 
as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464640') and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1518','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////start code to insert the data for PULSE_TF AirtelMPMC///////////////////////////////////////////////

//start code to insert the data for PULSE_TF airtel MTV
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1503','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1503','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF airtel MTV

//start code to insert the data for PULSE_TF AirtelRIA
/*
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1509','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1509','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
*/
//end code to insert the data for PULSE_TF AirtelRIA 

//start code to insert the data for PULSE_TF AirtelVH1
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelVH1 

//start code to insert the data for PULSE_TF AirtelGL
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelGL

//start code to insert the data for PULSE_TF AirtelEDU
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1514','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1514','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelEDU

//start code to insert the data for PULSE_TF AirtelMND
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR')) and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelMND

////////////////////////////////////// start code to insert the data for PULSE_TF & PULSE_T_6 AirtelDevo //////////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1515','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1515','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_6',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis = '510168' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','6','$pulse_tf[5]','','1515','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_6',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis = '510168' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T_6';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T_6';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1515','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
///////////////////////////////////////// end code to insert the data for PULSE_TF & PULSE_T_6 AirtelDevo //////////////////////////////////////////////////////

//start code to insert the data for PULSE_TF AirtelSE
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelSE' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1517','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelSE' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1517','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelSE

//start code to insert the data for PULSE_TF AirtelPK
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelPK' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1520','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelPK' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1520','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelPK

//start code to insert the data for PULSE_TF AirtelEU
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and dnis != '5464694' and operator ='airm' group by circle";
$pulse_tf_query .=" Union select 'PULSE_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis = '5464694' and circle in('kol','wbl') and operator ='airm' group by circle";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1501','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and dnis != '5464694' and operator ='airm' group by circle,status";
$pulse_tf_query .=" Union select 'PULSE_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis = '5464694' and circle in('kol','wbl') and operator ='airm' group by circle,status";
$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1501','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelEU

//start code to insert the data for PULSE_TF AirtelCK
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelCK' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator ='airm' and circle in ('TNU','CHN') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','15221','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelCK' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator ='airm' and circle in ('TNU','CHN') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','15221','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////////// end code to insert the data for PULSE_TF AirtelCK ///////////////////////////////////////////////////

///////////////////////////////////////////// start code to insert the data for PULSE_TF AirtelMAN ////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator ='airm' and circle in ('KAR') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','15222','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator ='airm' and circle in ('KAR') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','15222','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
///////////////////////////////////////////end code to insert the data for PULSE_TF AirtelMAN //////////////////////////////////////////////////////

////////////////////////////////////////// Start code to insert the data for PULSE_T AirtelMAN //////////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from 
mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464643' and operator ='airm'  group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','15222','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator ='airm'  group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','15222','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
///////////////////////////////////////////end code to insert the data for PULSE_TF AirtelMAN //////////////////////////////////////////////////////

//////////////////////////////////////////////////////// PULSE_T ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for PULSE_TF Airtel54646
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) 
and (dnis not like '%P%' and dnis !='5464640') and dnis !='5464643' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) 
and (dnis not like '%P%' and dnis !='5464640') and dnis !='5464643' and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1502','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF Airtel54646

//start code to insert the data for PULSE_TF AirtelVH1
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 
and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1507','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelVH1

//start code to insert the data for PULSE_TF AirtelGL
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse 
from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') 
group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1511','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//end code to insert the data for PULSE_TF AirtelGL

////////////////////////////////////////// start code to insert the data for PULSE_TF AirtelMND /////////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		elseif($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';
		
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$circle','0','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for PULSE_TF AirtelMND //////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for PULSE_T_1 AirtelMND ////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_1',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001961' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','1','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////// end code to insert the data for PULSE_T_1 AirtelMND ////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for PULSE_T_3 AirtelMND ////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_3',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001963'  and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','3','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////// end code to insert the data for PULSE_T_3 AirtelMND ////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for PULSE_T_5 AirtelMND ////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_5',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001965' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','5','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////// end code to insert the data for PULSE_T_5 AirtelMND ////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for PULSE_T_6 AirtelMND ////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_6',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001966' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','6','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////// end code to insert the data for PULSE_T_6 AirtelMND ////////////////////////////////////////////////

//////////////////////////////////////////// start code to insert the data for PULSE_T_9 AirtelMND ////////////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T_9',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from 
mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001969' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$circle = $pulse_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$pulse_tf[0]','$circle','9','$pulse_tf[5]','','1513','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
//////////////////////////////////////////// end code to insert the data for PULSE_T_9 AirtelMND ////////////////////////////////////////////////
?>