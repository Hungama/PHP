<?php
/////////////////////////////////////////////////////////////// MOU_TF //////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////start code to insert the data for mous_tf for Airtel54646///////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%') 
and dnis not in('546461','546461000','5464612') and dnis not like '%P%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' )
and dnis not in('546461','546461000','5464612') and dnis not like '%P%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';

		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

//start code to insert pausecode
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle, count(id),'54646P' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf['circle'];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1502P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf['circle'];
		$pCircle = $pauseArray[$p];
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1502P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle, count(id),'54646P' as service_name,date(call_date),sum(duration_in_sec)/60 
as mous,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis like '%47P%' and operator='airm' group by dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1502P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',substr(dnis,9,3) as circle, count(id),'endless' as service_name,date(call_date),sum(duration_in_sec)/60 
as mous,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis like '%47P%' and operator='airm' group by circle,status,dnis";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$p = $mous_tf[1];
		$pCircle = $pauseArray[$p];
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$pCircle','0','$mous_tf[5]','','1502P','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end

//////////////////////////////start code to insert the data for mous_tf for AirtelMPMC////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464612') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1518','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464640') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1518','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1518','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464640') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1518','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
//////////////////////////////End code to insert the data for mous_tf for AirtelMPMC////////////////////////////////////////////////

//start code to insert the data for mous_tf for Airtel mtv
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1503','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMtv' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1503','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for Airtel mtv

//start code to insert the data for mous_tf for AirtelRIA
/*
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1509','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1509','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
*/
// end code to insert the data for mous_tf for AirtelRIA

//start code to insert the data for mous_tf for AirtelVH1
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelVH1

//start code to insert the data for mous_tf for AirtelGL
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelGL

//start code to insert the data for mous_tf for AirtelEDU
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1514','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1514','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelEDU

//start code to insert the data for mous_tf for AirtelMND
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}


$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

// end code to insert the data for mous_tf for AirtelMND


//////////////////////////////////// start code to insert the data for mous_tf for AirtelDevo ///////////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1515','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1515','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_6',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis = '510168' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1515','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T_6',circle, count(id),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis = '510168' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T_6';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T_6';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1515','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
//////////////////////////////////////// end code to insert the data for mous_tf for AirtelDevo /////////////////////////////////////////////////////


//start code to insert the data for mous_tf for AirtelSE
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelSE' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1517','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelSE' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1517','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelSE

//start code to insert the data for mous_tf for AirtelPK
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelPK' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1520','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelPK' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1520','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelPK

//start code to insert the data for mous_tf for AirtelEU
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1501','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1501','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelEU

//start code to insert the data for mous_tf for AirtelCK
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelCK' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15221','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelCK' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15221','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_tf for AirtelCK

//////////////////////////////////////// start code to insert the data for mous_tf for AirtelMAN /////////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15222','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_TF';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_TF';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15222','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
//////////////////////////////////////////////// end code to insert the data for mous_tf for AirtelMAN ////////////////////////////////////////////

//////////////////////////////////////////////// Start code to insert the data for mous_t for AirtelMAN ////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464643' and operator='airm'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15222','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
$mous_tf=array();
$mous_tf_query="select 'MOU_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from 
mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator='airm'  group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','15222','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
//////////////////////////////////////////////// end code to insert the data for mous_t for AirtelMAN ////////////////////////////////////////////

///////////////////////////////////////////////////////////  MOU_T ///////////////////////////////////////////////////////////////////////////////

// start code to insert the data for mous_t for Airte54646
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'54646' as service_name,date(call_date),sum(duration_in_sec)/60 
as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) 
and (dnis not like '%P%'  and dnis !='5464640') and dnis != '5464643' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,
                pulse,total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'54646' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) 
and (dnis not like '%P%' and dnis !='5464640') and dnis !='5464643' and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1502','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_t for Airtel54646


// start code to insert the data for mous_t for AirteVH1
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'55841' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "")
			$circle="UND";
		elseif($circle == "HAR")
			$circle="HAY";
		elseif($circle == "PUN")
			$circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'55841' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1)
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1)
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") 
			$circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1507','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_t for AirtelVH1

// start code to insert the data for mous_t for AirtelGL
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR")
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1) 
			$mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1) 
			$mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1511','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
// end code to insert the data for mous_t for AirtelGL

///////////////////////////////////////////// start code to insert the data for mous_t for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'and dnis = '5500196' and circle NOT IN ('DEL') 
and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}

$mous_tf=array();
$mous_tf_query="select 'MOU_T',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,status 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') 
and operator='airm' group by circle,status";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		if($mous_tf[6]==1) $mous_tf[0]='L_MOU_T';
		elseif($mous_tf[6]!=1) $mous_tf[0]='N_MOU_T';
		
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for mous_t for AirtelMND ///////////////////////////////////////////////////////////

/////////////////////////////////////// start code to insert the data for MOU_T_1 for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_1',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'and dnis = '55001961' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for MOU_T_1 for AirtelMND /////////////////////////////////////////////

/////////////////////////////////////// start code to insert the data for MOU_T_3 for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_3',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '55001963'  and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for MOU_T_3 for AirtelMND /////////////////////////////////////////////

/////////////////////////////////////// start code to insert the data for MOU_T_5 for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_5',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'and dnis = '55001965' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for MOU_T_5 for AirtelMND /////////////////////////////////////////////

/////////////////////////////////////// start code to insert the data for MOU_T_6 for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_6',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'and dnis = '55001966' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for MOU_T_6 for AirtelMND /////////////////////////////////////////////

/////////////////////////////////////// start code to insert the data for MOU_T_9 for AirtelMND /////////////////////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_T_9',circle, count(id),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec)/60 as mous 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1'and dnis = '55001969' and operator='airm' group by circle";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$circle = $mous_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_mous_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$mous_tf[0]','$circle','0','$mous_tf[5]','','1513','$mous_tf[5]','NA','NA')";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for MOU_T_9 for AirtelMND /////////////////////////////////////////////
?>