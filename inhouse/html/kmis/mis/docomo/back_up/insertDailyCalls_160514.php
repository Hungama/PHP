<?php
//////////start code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date),status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('TATM') group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr','$call_tf[1]','0','$call_tf[2]','','1001','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'endless' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in ('TATM') group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values ('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1001','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////End code to insert the data for call_tf for Tata Docomo Endless///////////////////////////////////////////////////////////////////


////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr1='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr1='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////

////////start code to insert the data for call_tf for Tata DocomO PauseCode ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		if($call_tf[5]==1) $callStr1='L_CALLS_TF';
		elseif($call_tf[5]!=1) $callStr1='N_CALLS_TF';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr1','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		if($call_tf[5]==1) $callStr1='L_CALLS_T';
		elseif($call_tf[5]!=1) $callStr1='N_CALLS_T';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr1','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',substr(dnis,9,3) as circle1, count(id),'PauseCode' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$p = $call_tf[1];
		$pCircle = $pauseArray[$p];
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$pCircle','0','$call_tf[2]','','1002P','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo PauseCode ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO 54646 ////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr2='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr2='N_CALLS_TF';
			
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr2','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMis Riya' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of Tata Docomo Mtv////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date),status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr3='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr3='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr3','$call_tf[1]','0','$call_tf[2]','','1003','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo Mtv' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis like '546461%' and operator='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1003','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////////////////// end code to insert the data for call_tf for the service of Tata Docomo Mtv//////////////////////////////////////////

//////////////////////////Start code to insert the data for call_tf for the service of Docomo Filmi Meri Jaan////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo FMJ' as service_name,date(call_date),status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr4='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr4='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr4','$call_tf[1]','0','$call_tf[2]','','1005','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'Docomo FMJ' as service_name,date(call_date) from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666')  and operator='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1005','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////////////////// end code to insert the data for call_tf for the service of Docomo Filmi Meri Jaan///////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO Redfm ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoREDFM' as service_name,date(call_date),status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1010','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoREDFM' as service_name,date(call_date) from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1010','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo Redfm ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO GL ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo GL ///////////////////////////////////////////////////////////////////


/////////////////////////start code to insert the data for call_tf for Tata DocomO MS ///////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMS' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callStr5='L_CALLS_TF';
		elseif($call_tf[5]!=1)
			$callStr5='N_CALLS_TF';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callStr5','$call_tf[1]','0','$call_tf[2]','','1000','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}


$call_tf=array();
$call_tf_query="select 'CALLS_TF',circle, count(id),'DocomoMS' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1000','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////End code to insert the data for call_tf for Tata Docomo MS ///////////////////////////////////////////////////////////////////


//////////////start code to insert the data for call_tf for Tata DocomO 54646 ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$callTStr1='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$callTStr1='N_CALLS_T';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$callTStr1','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1'  and  (dnis = '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1002','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}
//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////



//////////////start code to insert the data for call_tf for Tata DocomO Miss Riya ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),dnis,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==5464669)
		{
			if($call_tf[6]==1)
				$call_tf[0]='L_CALLS_T';
			elseif($call_tf[6]!=1)
				$call_tf[0]='N_CALLS_T';
		}
		else
		{
			if($call_tf[6]==1)
				$call_tf[0]='L_CALLS_T_1';
			elseif($call_tf[6]!=1)
				$call_tf[0]='N_CALLS_T_1';
		}
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'Docomo54646' as service_name,date(call_date),dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==5464669) {
			$call_tf[0]='CALLS_T';
		} else {
			$call_tf[0]='CALLS_T_1';
		}
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1009','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo 54646 ///////////////////////////////////////////////////////////////////


//////////////start code to insert the data for call_tf for Tata DocomoGL ///////////////////////////////////////////////////////////////////

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'DocomoGL' as service_name,date(call_date),status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		if($call_tf[5]==1)
			$call_tf[0]='L_CALLS_T';
		elseif($call_tf[5]!=1)
			$call_tf[0]='N_CALLS_T';

		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

$call_tf=array();
$call_tf_query="select 'CALLS_T',circle, count(id),'DocomoGL' as service_name,date(call_date) from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		if($call_tf[1]=='' || $call_tf[1]=='0') $call_tf[1]='UND';
		elseif(strtoupper($call_tf[1])=='HAR') $call_tf[1]='HAY';
		$insert_call_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$call_tf[0]','$call_tf[1]','0','$call_tf[2]','','1011','NA','NA','NA')";
		$queryIns_call = mysql_query($insert_call_tf_data, $dbConn);
	}
}

//////////////////////End code to insert the data for call_tf for Tata Docomo GL ///////////////////////////////////////////////////////////////////
?>