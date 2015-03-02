<?php
//////////////////////////////////////////////////////// UU_TF ////////////////////////////////////////////////////////////////////////////

//start code to insert the data for Unique Users  for airtel 54646 
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' or dnis like '5464646%')
and dnis not in('546461','546461000','5464612') and operator='airm' and dnis not like '%P%' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and dnis not like '%p%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and dnis not like '%p%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'endless' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000','5464612') and dnis not like '%p%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end Unique Users  for Tata Airtel 54646 

//start code to insert the pauseCode
$uu_tf=array();
$uu_tf_query="select 'UU_TF',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date)
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34p%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p=$uu_tf[1];
		$pcircle = $pauseArray[$p];
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34p%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34p%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34p%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p=$uu_tf[1];
		$pcircle = $pauseArray[$p];
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47p%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47p%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47p%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',substr(dnis,9,3) as circle, count(distinct msisdn),'pauseCode' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47p%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$p=$uu_tf[1];
		$pcircle = $pauseArray[$p];
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$pcircle','0','$uu_tf[2]','','1502P','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end Unique Users  for pauseCode

/////////////////////////////////////start code to insert the data for Unique Users  for AirtelMPMC//////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1518','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_T_3',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464640') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1518','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in('5464612') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in('5464612') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1518','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T_3',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in('5464640') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in ('5464612') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMPMC' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and dnis in('5464640') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1518','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////////////////////////End code to insert the data for Unique Users  for AirtelMPMC//////////////////////////////////

//start code to insert the data for Unique Users  for airtel Mtv
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1503','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMtv' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1503','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end
/*
//start code to insert the data for Unique Users  for AirtelRIA
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date) from mis_db.tbl_riya_calllog 
where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1509','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'AirtelRIA' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis in(5500169) and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1509','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
*/
// end AirtelRIA 

//start code to insert the data for Unique Users  for AirtelVH1
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date) 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 
and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
            values('$view_date1', '$uu_tf[0]','$uu_tf[1]','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelVH1 

//start code to insert the data for Unique Users  for AirtelGL
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date) 
from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') and status=1 group by circle)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelGL 

//start code to insert the data for Unique Users  for AirtelEDU
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1514','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelEDU' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '53222345%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1514','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelEDU

//start code to insert the data for Unique Users  for AirtelMND
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and ((dnis like '5500196%' and circle IN ('DEL')) OR (dnis like '54646196' and circle!='KAR') or dnis like '5500169' or dnis like '54646169'or dnis like '55001699') and operator='airm' and status=1 group by circle)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}


$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog 
where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis like '54646196' and circle='KAR' and operator='airm' and status=1 group by circle)";


$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

// end AirtelMND

//start code to insert the data for Unique Users  for AirtelDevo
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelDevo' as service_name,date(call_date) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1515','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelDevo' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelDevo' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1515','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelDevo


//start code to insert the data for Unique Users  for AirtelSE
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelSE' as service_name,date(call_date) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{	
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1517','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelSE' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelSE' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1517','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelSE

//start code to insert the data for Unique Users  for AirtelPK
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelPK' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1520','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelPK' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelPK' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1520','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelPK


//start code to insert the data for Unique Users  for AirtelEU
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelEU' as service_name,date(call_date) from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1501','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelEU' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelEU' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1501','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelEU

//start code to insert the data for Unique Users  for AirtelCK
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelCK' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15221','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelCK' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and status in(-1,11,0) and circle in ('CHN','TNU') AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and status IN (1) and circle in ('CHN','TNU') ) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelCK' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle in ('CHN','TNU') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15221','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelCK

////////////////////////////////////////// start code to insert the data for Unique Users  for AirtelMAN ///////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date)
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle in ('KAR') group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec)
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15222','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}


/////////////////////////////////////////////////////// Start AirtelMAN UU_T //////////////////////////////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_3',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date)
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator='airm'  group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15222','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
/////////////////////////////////////////////////////// end AirtelMAN //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////  start AirtelMAN UU_TF code /////////////////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and status in(-1,11,0) and circle in ('KAR') AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and status IN (1) and circle in ('KAR') ) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle in ('KAR') and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_TF';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_TF';

		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15222','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////  start AirtelMAN UU_TF code /////////////////////////////////////////////////////////////

////////////////////////////////////////////////////  start AirtelMAN UU_T code /////////////////////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query = "(select 'UU_T_3',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date),status,'Non Active' as 'user_status' 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis ='5464643' and operator='airm' and status in(-1,11,0) 
 AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' 
and dnis ='5464643' and operator='airm' and status IN (1)  ) group by circle)";

$uu_tf_query .= "UNION (select 'UU_T_3',circle, count(distinct msisdn),'AirtelMAN' as service_name,date(call_date),status,'Active' as 'user_status'
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis = '5464643' and operator='airm'  and status=1 
group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active') $uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active') $uu_tf[0]='N_UU_T';

		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) 
                values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','15222','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
////////////////////////////////////////////////////  End AirtelMAN UU_T code /////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////// UU_T /////////////////////////////////////////////////////////////////////////


//start code to insert the data for Unique Users  for Airtel54646
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog 
where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and dnis !='5464640' and dnis != '5464643'
and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and dnis != '5464643'
and operator='airm' and status in(-1,11,0) 
AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' 
and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and dnis != '5464643'
and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'Airtel54646' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and dnis != '5464643' and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1502','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end Airtel54646

//start code to insert the data for Unique Users  for AirtelVH1
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelVH1' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1507','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelVH1

//start code to insert the data for Unique Users  for AirtelGL
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date) from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") 
			$circle="HAY";
		elseif($circle == "PUN") 
			$circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_TF',circle, count(distinct msisdn),'AirtelGL' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1511','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
// end AirtelGL

//////////////////////////////////////////// start code to insert the data for Unique Users  for AirtelMND ///////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}

$uu_tf=array();
$uu_tf_query = "(select 'UU_T',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Non Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' and status in(-1,11,0) AND MSISDN  NOT IN( select DISTINCT MSISDN from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' and status IN (1)) group by circle)";
$uu_tf_query .= "UNION (select 'UU_T',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date),status,'Active' as 'user_status' from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis = '5500196' and circle NOT IN ('DEL') and operator='airm' and status=1 group by circle)";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		if($uu_tf[6]=='Active')
			$uu_tf[0]='L_UU_T';
		if($uu_tf[6]=='Non Active')
			$uu_tf[0]='N_UU_T';
		
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
//////////////////////////////////////////////////////////// end AirtelMND ///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////// start code to insert the data for UU_T_1  for AirtelMND ///////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_1',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis = '55001961' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////// end code to insert the data for UU_T_1 for AirtelMND ///////////////////////////////////

///////////////////////////////////////////// start code to insert the data for UU_T_3  for AirtelMND ///////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_3',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis = '55001963' and circle !='ker' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////// end code to insert the data for UU_T_3 for AirtelMND ///////////////////////////////////

///////////////////////////////////////////// start code to insert the data for UU_T_5  for AirtelMND ///////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_5',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis = '55001965' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////// end code to insert the data for UU_T_5 for AirtelMND ///////////////////////////////////

///////////////////////////////////////////// start code to insert the data for UU_T_6  for AirtelMND ///////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_6',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis = '55001966' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////// end code to insert the data for UU_T_6 for AirtelMND ///////////////////////////////////

///////////////////////////////////////////// start code to insert the data for UU_T_9  for AirtelMND ///////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T_9',circle, count(distinct msisdn),'AirtelMND' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where 
date(call_date)='$view_date1' and dnis = '55001969' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$circle = $uu_tf[1];
		if($circle == "") $circle="UND";
		elseif($circle == "HAR") $circle="HAY";
		elseif($circle == "PUN") $circle="PUB";

		$insert_uu_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$uu_tf[0]','$circle','0','$uu_tf[2]','','1513','NA','NA','NA')";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
	}
}
///////////////////////////////////////////// end code to insert the data for UU_T_9 for AirtelMND ///////////////////////////////////
?>