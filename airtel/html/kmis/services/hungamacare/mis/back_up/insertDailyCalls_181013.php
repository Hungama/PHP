<?php
//////////////////////////////////////////////////////////// CALL_TF //////////////////////////////////////////////////////////////////////

/////////////////////////////start code to insert the data for call_tf Airtel 54646///////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' )
and dnis not in('546461','546461000','5464612') and dnis not like '%P%' and operator='airm' group by circle";

$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') 
and dnis not like '%P%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end

//start code to insert the data for call_tf Airtel 54646
$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle, count(id),'54646P' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$p = $call_tf['circle'];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle, count(id),'54646' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf['circle'];
		$pCircle = $pauseArray[$p];

		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle,dnis, count(id),'54646P' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$p = $call_tf['circle'];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle, count(id),'54646' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf['circle'];
		$pCircle = $pauseArray[$p];

		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end

////////////////////////////start code to insert the data for call_tf AirtelMPMC///////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1518','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' and dnis in ('5464640') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1518','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMPMC' as service_name,date(call_date),status from mis_db.tbl_54646_calllog
where date(call_date)='$view_date1' 
and dnis in ('5464612') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";	

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1518','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T_3',circle, count(id),'AirtelMPMC' as service_name,date(call_date),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464640') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";	

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1518','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
/////////////////////////////////End code to insert the data for call_tf AirtelMPMC///////////////////////////////////////////////////////////


//start code to insert the data for call_tf for the service of Airtel MTV
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1503','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1503','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of Airtel MTV

//start code to insert the data for call_tf for the service of AirtelRIA
/*
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1509','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelRIA' as service_name,date(call_date),status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1509','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelRIA
*/
//start code to insert the data for call_tf for the service of AirtelVH1
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelVH1' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelvH1

//start code to insert the data for call_tf for the service of AirtelGL
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelGL' as service_name,date(call_date) from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelGL' as service_name,date(call_date),status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelGL

//start code to insert the data for call_tf for the service of AirtelEDU
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1514','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEDU' as service_name,date(call_date),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1514','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelEDU

//start code to insert the data for call_tf for the service of AirtelMND
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR' ) 
or dnis like '5500169' or dnis like '54646169'or dnis like '55001699' ) and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR')) group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}



$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date) 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' 
and dnis like '54646196' and circle='KAR' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15131','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMND' as service_name,date(call_date),status 
from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle ='KAR' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15131','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelMND

//start code to insert the data for call_tf for the service of AirtelDevo
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelDevo' as service_name,date(call_date) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1515','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Airtel Mtv' as service_name,date(call_date),status from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1515','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelDevo


//start code to insert the data for call_tf for the service of AirtelSE
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelSE' as service_name,date(call_date) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1517','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelSE' as service_name,date(call_date),status from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1517','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelSE

//start code to insert the data for call_tf for the service of AirtelPK
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelPK' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1520','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelPK' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1520','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelPK

//start code to insert the data for call_tf for the service of AirtelEU
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEU' as service_name,date(call_date) from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1501','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelEU' as service_name,date(call_date),status from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1501','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelEU

//start code to insert the data for call_tf for the service of AirtelCK
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelCK' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('TNU','CHN') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15221','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelCK' as service_name,date(call_date),status 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' 
and circle IN ('TNU','CHN') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15221','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_tf for the service of AirtelCK

//start code to insert the data for call_tf for the service of AirtelMAN
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15222','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////// Start AirtelMAN Call_TF ///////////////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'AirtelMAN' as service_name,date(call_date),status 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' 
and circle IN ('KAR') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_TF';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15222','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
///////////////////////////////////////// end code to insert the data for call_tf for the service of AirtelMAN ////////////////////////////////////////

////////////////////////////////////////////////// Start AirtelMAN Call_T ///////////////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),status 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator='airm' 
 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15222','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
///////////////////////////////////////// end code to insert the data for call_t for the service of AirtelMAN ////////////////////////////////////////

/////////////////////////////////////////////////// Start AirtelMAN Call_T ///////////////////////////////////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_3',circle, count(id),'AirtelMAN' as service_name,date(call_date),status 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464643' and operator='airm' 
 group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','15222','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
///////////////////////////////////////// end code to insert the data for call_tf for the service of AirtelMAN ////////////////////////////////////////


//////////////////////////////////////////////////////////// CALLS_T /////////////////////////////////////////////////////////////////////////////

//start code to insert the data for call_t for the service of Airtel 54646
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' )
and (dnis not like '%P%' or dnis !=5464640) and dnis != '5464643' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR")
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'54646' as service_name,date(call_date),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) 
and (dnis not like '%P%' and dnis != 5464640) and dnis !='5464643' and operator='airm'  group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1502','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
// end code to insert the data for call_t for the service of Airtel 54646

//start code to insert the data for call_t for the service of AirtelVH1
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55841' as service_name,date(call_date) from 
mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(55841) 
and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55841' as service_name,date(call_date),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(55841) 
and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1507','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
//end code to insert the data for call_t for the service of AirtelVH1

//start code to insert the data for call_t for the service of AirtelGL
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55001' as service_name,date(call_date) 
from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' 
and operator='airm' and circle NOT IN ('DEL') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR")
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'55001' as service_name,date(call_date),
status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' 
and operator='airm' and circle NOT IN ('DEL') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1511','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
/////////////////////////////////////// end code to insert the data for call_t for the service of AirtelGL //////////////////////////////////////

/////////////////////////////////// start code to insert the data for call_t for the service of AirtelMND ///////////////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'AirtelMND' as service_name,date(call_date),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
///////////////////////////////////////end code to insert the data for call_t for the service of AirtelMND//////////////////////////////////

/////////////////////////////////// start code to insert the data for CALLS_T_1 for the service of AirtelMND //////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_1',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis ='55001961' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
/////////////////////////////////// end code to insert the data for call_t_1 for the service of AirtelMND //////////////////////////////////////

/////////////////////////////////// start code to insert the data for CALLS_T_3 for the service of AirtelMND //////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_3',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis ='55001963' and circle !='ker' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}

/////////////////////////////////// end code to insert the data for call_t_3 for the service of AirtelMND //////////////////////////////////////

/////////////////////////////////// start code to insert the data for CALLS_T_5 for the service of AirtelMND //////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_5',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis ='55001965' and circle in('RAJ','ORI') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
/////////////////////////////////// end code to insert the data for call_t_5 for the service of AirtelMND //////////////////////////////////////

/////////////////////////////////// start code to insert the data for CALLS_T_6 for the service of AirtelMND //////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_6',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis ='55001966' and circle in('upw','hpd','har','pub','jnk','bih') and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
/////////////////////////////////// end code to insert the data for call_t_6 for the service of AirtelMND //////////////////////////////////////

/////////////////////////////////// start code to insert the data for CALLS_T_9 for the service of AirtelMND //////////////////////////////////////
$call_tf=array();
$call_tf_query="select 'CALLS_T_9',circle, count(id),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis ='55001969' and operator='airm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$circle = $call_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_call_t_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$circle','0','$call_tf[2]','','1513','NA','NA','NA')";
		$queryIns_call1 = mysql_query($insert_call_t_data, $dbConn);
	}
}
/////////////////////////////////// end code to insert the data for call_t_9 for the service of AirtelMND //////////////////////////////////////
?>