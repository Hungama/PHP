<?php
/////////////////////////////////////////////////////////////// SEC_TF /////////////////////////////////////////////////////////////////////////

//start code to insert the data for SEC_TF  for airtel 54646 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) 
and dnis not in('546461','546461000','5464612') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'endless' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for airtel 54646 


//start code to insert PauseCode
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle= $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1502P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle= $pauseArray[$p];
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1502P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',substr(dnis,9,3) as circle, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle= $pauseArray[$p];
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1502P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',substr(dnis,9,3) as circle, count(msisdn),'PauseCode' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$p = $sec_tf[1];
		$pCircle= $pauseArray[$p];
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$pCircle','0','$sec_tf[5]','','1502P','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end 


/////////////////////////start code to insert the data for SEC_TF  for AirtelMPMC//////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464612') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1518','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in ('5464640') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1518','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464612') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1518','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMPMC' as service_name,date(call_date),sum(duration_in_sec),status
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464640') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1518','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

/////////////////////////start code to insert the data for SEC_TF  for AirtelMPMC//////////////////////////////////////////////////

//start code to insert the data for SEC_TF  for airtel Mtv 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1503','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'Docomo Mtv' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1503','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for airtel Mtv 

//start code to insert the data for SEC_TF for AirtelRIA
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1509','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelRIA' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1509','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelRIA 

//start code to insert the data for SEC_TF for AirtelVH1
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelVH1 

//start code to insert the data for SEC_TF for AirtelGL
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
            values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_ldr_calllog 
where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
                    $circle="HAY";
		elseif($circle == "PUN") 
                    $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelGL

//start code to insert the data for SEC_TF for AirtelEDU
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1514','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEDU' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1514','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelEDU

//start code to insert the data for SEC_TF for AirtelCK
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelCK' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15221','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelCK' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15221','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelCK

//////////////////////////////////////// start code to insert the data for SEC_TF for AirtelMAN ////////////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15222','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15222','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////// end insert the data for SEC_TF  for AirtelMAN ///////////////////////////////////////////////////

//////////////////////////////////////////////////// Start insert the data for SEC_TF  for AirtelMAN ///////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_edu_calllog 
where date(call_date)='$view_date1' and dnis like '5464643' and operator='airm' and circle IN ('APD') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15222','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMAN' as service_name,date(call_date),sum(duration_in_sec),status from 
mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator='airm' and circle IN ('APD') group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15222','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////// end insert the data for SEC_TF  for AirtelMAN ///////////////////////////////////////////////////

//start code to insert the data for SEC_TF for AirtelMND
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR')) and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR')) and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR'  and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15131','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','15131','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelMND

//start code to insert the data for SEC_TF for AirtelDevo
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1515','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelDevo' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1515','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelDevo


//start code to insert the data for SEC_TF for AirtelSE
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelSE' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1517','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelSE' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1517','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelSE

//start code to insert the data for SEC_TF for AirtelPK
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelPK' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1520','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelPK' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1520','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelPK


//start code to insert the data for SEC_TF for AirtelEU
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEU' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1501','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'AirtelEU' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_TF';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_TF';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1501','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_TF  for AirtelEU

//////////////////////////////////////////////////////// SEC_T ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for SEC_T for Airtel54646
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='5464640' and dnis != '5464643' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'54646' as service_name,date(call_date),sum(duration_in_sec),status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') 
and dnis !='5464640' and dnis != '5464643' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1502','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_T  for Airtel54646

//start code to insert the data for SEC_T for AirtelVH1
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelVH1' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1507','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_T  for AirtelVH1

//start code to insert the data for SEC_T for AirtelGL
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") 
			$circle="UND";
		elseif($circle == "HAR")
			$circle="HAY";
		elseif($circle == "PUN")
			$circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelGL' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1511','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_T  for AirtelGL

//start code to insert the data for SEC_T for AirtelMND
$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$circle = $sec_tf[1];
		if($circle == "") 
			$circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}

$sec_tf=array();
$sec_tf_query="select 'SEC_T',circle, count(msisdn),'AirtelMND' as service_name,date(call_date),sum(duration_in_sec),status from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '5500196%' and circle NOT IN ('DEL') and operator='airm' group by circle,status";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		if($sec_tf[6]==1) $sec_tf[0]='L_SEC_T';
		if($sec_tf[6]!=1) $sec_tf[0]='N_SEC_T';
		
		$circle = $sec_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_sec_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$sec_tf[0]','$circle','0','$sec_tf[5]','','1513','NA','NA','NA')";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $dbConn);
	}
}
// end insert the data for SEC_T  for AirtelMND
?>