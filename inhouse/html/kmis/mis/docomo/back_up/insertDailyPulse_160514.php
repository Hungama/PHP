<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice/////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1001','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'endless' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '59090%' and operator in('TATM') group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1001','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Endless SErvice//////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%') and dnis not in ('546461','5464626') and dnis not like '%P%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////

/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo PauseCode /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{

		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%34P%' and operator ='tatm' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) 
as pulse,status,dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,status,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_T';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',substr(dnis,9,3) as circle1, sum(ceiling(duration_in_sec/60)),'PauseCode' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,
dnis from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '%47P%' and operator ='tatm' group by circle,dnis";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$p=$pulse_tf[1];
		$pCircle = $pauseArray[$p];

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pCircle','0','$pulse_tf[5]','','1002P','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo PauseCode /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Miss Riya ///////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1009','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis IN ('5464626','5464628') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1009','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
/////////////////////////////////////////End code to insert the data for PULSE_TF for the Tata Docomo 54646 /////////////////////////////////////////

///////////////////////start code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocmoFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1005','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocmoFMJ' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_starclub_calllog where date(call_date)='$view_date1' and dnis in ('56666') and operator='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1005','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

////////////////////End code to insert the data for PULSE_TF for the Tata Docomo Filmi Meri Jaan /////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1003','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'Docomo Mtv' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis=546461 and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1003','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////Docomo RedFM /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1010','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoRedFM' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_redfm_calllog where date(call_date)='$view_date1' and dnis=55935 and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1010','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////Docomo RedFM /////////////////////////////////////////////////////////////////////


///////////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1011','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle IN ('DEL') and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1011','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////


///////////////////////////////////////////DocomoMS /////////////////////////////////////////////////////////////////////////////

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoMS' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) $pulse_tf[0]='L_PULSE_TF';
		if($pulse_tf[6]!=1) $pulse_tf[0]='N_PULSE_TF';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1000','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}


$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464630%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[2]','','1000','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}
////////////////////////////////////DocomoGL /////////////////////////////////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' 
and operator ='tatm' group by circle,status";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0')
			$pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') 
			$pulse_tf[1]='HAY';
		if($pulse_tf[6]==1) 
			$pulse_tf[0]='L_PULSE_T';
		if($pulse_tf[6]!=1) 
			$pulse_tf[0]='N_PULSE_T';

		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','0','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

$pulse_tf=array();
$pulse_tf_query="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'Docomo54646' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse
 from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and  (dnis like '54646' or dnis like '546464%' or dnis like '546465%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') and dnis not in('5464669','5464668') and dnis not like '%P%' and operator ='tatm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		if($pulse_tf[1]=='' || $pulse_tf[1]=='0') $pulse_tf[1]='UND';
		elseif(strtoupper($pulse_tf[1])=='HAR') $pulse_tf[1]='HAY';
		$insert_pulse_tf_data="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf[0]','$pulse_tf[1]','3','$pulse_tf[5]','','1002','NA','$pulse_tf[5]','NA')";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////
$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoMissRiya' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse, dnis, status 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis,status";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') 
			$pulse_tf1[1]='HAY';
		if($pulse_tf1[6]==5464669) {
			if($pulse_tf1[7]==1) 
				$pulse_tf1[0]='L_PULSE_T';
			if($pulse_tf1[7]!=1) 
				$pulse_tf1[0]='N_PULSE_T'; 
		} else {
			if($pulse_tf1[7]==1) 
				$pulse_tf1[0]='L_PULSE_T_1';
			if($pulse_tf1[7]!=1) 
				$pulse_tf1[0]='N_PULSE_T_1';
			
		}
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1009','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoMissRiya' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse, dnis 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in('5464669','5464668') and operator ='tatm' group by circle,dnis";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
		if($pulse_tf1[6]==5464669) {
			$pulse_tf1[0]='PULSE_T';
		} else {
			$pulse_tf1[0]='PULSE_T_1';
		}
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','3','$pulse_tf1[5]','','1009','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata Docomo 54646 /////////////////////////////////////////


/////////////////////////////////////////start code to insert the data for PULSE_T for the Tata DocomoGL /////////////////////////////////////////
$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse,status 
from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle,status";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
		if($pulse_tf1[6]==1) $pulse_tf1[0]='L_PULSE_T';
		if($pulse_tf1[6]!=1) $pulse_tf1[0]='N_PULSE_T'; 
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1011','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

$pulse_tf1=array();
$pulse_tf_query1="select 'PULSE_T',circle, sum(ceiling(duration_in_sec/60)),'DocomoGL' as service_name,date(call_date), sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_rasoi_calllog where date(call_date)='$view_date1' and dnis like '55001%' and circle NOT IN ('DEL') and operator ='tatm' group by circle";

$pulse_tf_result1 = mysql_query($pulse_tf_query1, $dbConn) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_tf_result1);
if ($numRows31 > 0)
{
	while($pulse_tf1 = mysql_fetch_array($pulse_tf_result1))
	{
		if($pulse_tf1[1]=='' || $pulse_tf1[1]=='0') $pulse_tf1[1]='UND';
		elseif(strtoupper($pulse_tf1[1])=='HAR') $pulse_tf1[1]='HAY';
		$insert_pulse_tf_data1="insert into mis_db.daily_report(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous,pulse,
                total_sec) values('$view_date1', '$pulse_tf1[0]','$pulse_tf1[1]','0','$pulse_tf1[5]','','1011','NA','$pulse_tf1[5]','NA')";
		$queryIns_pulse1 = mysql_query($insert_pulse_tf_data1, $dbConn);
	}
}

/////////////////////////////////////////End code to insert the data for PULSE_T for the Tata DocomoGL /////////////////////////////////////////
?>