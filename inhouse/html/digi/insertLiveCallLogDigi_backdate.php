<?php
ini_set('max_execution_time', 0);
include ("dbDigiConnect.php");

// delete the prevoius record
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$view_time1= date("h:i:s");

//$view_date1="2013-02-05";

function getCircle($shortCode)
{
	if(strpos($shortCode,'131221'))
		$circle='Bangla';
	elseif(strpos($shortCode,'131222'))
		$circle='Nepali';
	elseif(strpos($shortCode,'131224'))
		$circle='Indian';
	return $circle;
}

$service_array = array('DIGIMA');


////// start the code to insert the data of activation Docomo Endless and Tata Docomo endless, Dovomo MTV,Docomo Star club, Docomo 54646////////////////

$DeleteQuery="delete from misdata.livemis where date(date)='$view_date1' and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());


///////////////////////////////////////////////////////////////start code to insert the data for call_tf////////////////////////  
$call_tf=array();
$call_tf_query="select 'CALLS_TF','Indian' as circle,count(id),'DIGI' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and dnis like '131224%' group by circle,hour(concat(call_date,' ',call_time))
UNION
select 'CALLS_TF','Bangla' as circle,count(id),'DIGI' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and dnis like '131221%' group by circle,hour(concat(call_date,' ',call_time))
UNION
select 'CALLS_TF','Nepali' as circle,count(id),'DIGI' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1' and dnis like '131222%' group by circle, hour(concat(call_date,' ',call_time)) ";
$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($call_tf_result);
if ($numRows1 > 0)
{
	$call_tf_result = mysql_query($call_tf_query, $dbConn) or die(mysql_error());
	while($call_tf = mysql_fetch_array($call_tf_result))
	{
		$dateFormat = $view_date1." ".$call_tf[5].":00:00";
		$insert_call_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$dateFormat','DIGIMA','".strtoupper($call_tf[1])."' ,'$call_tf[0]','$call_tf[2]',0)";
		$queryIns_call = mysql_query($insert_call_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////////End code to insert the data for call_tf  ///////////////////////////////////////

/////////////////////////////////////////////////////////////////start code to insert the data for mous_tf ////////////////////////////
$mous_tf=array();
$mous_tf_query="select 'MOU_TF','Indian' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131224%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'MOU_TF','Bangla' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131221%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'MOU_TF','Nepali' as circle,sum(duration_in_sec)/60 as count,'Digi' as service_name,date(call_date),sum(duration_in_sec)/60 as mous,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131222%' group by circle,hour(concat(call_date,' ',call_time))
";
$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	$mous_tf_result = mysql_query($mous_tf_query, $dbConn) or die(mysql_error());
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$dateFormat = $view_date1." ".$mous_tf[6].":00:00";
		$insert_mous_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$dateFormat','DIGIMA','".strtoupper($mous_tf[1])."' ,'$mous_tf[0]','$mous_tf[2]',0)";
		$queryIns_mous = mysql_query($insert_mous_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mous_tf ////////////////////////////


/////////////////////////////////////////////////////////////////Start code to insert the data for PULSE_TF ////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF','Indian' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131224%' group by circle,hour(concat(call_date,' ',call_time))
Union
select 'PULSE_TF','Bangla' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131221%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'PULSE_TF','Nepali' as circle,sum(ceiling(duration_in_sec/60)),'Digi' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse,hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131222%' group by circle,hour(concat(call_date,' ',call_time))";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	$pulse_tf_result = mysql_query($pulse_tf_query, $dbConn) or die(mysql_error());
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$dateFormat = $view_date1." ".$pulse_tf[6].":00:00";
		$insert_pulse_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$dateFormat','DIGIMA','".strtoupper($pulse_tf[1])."' ,'$pulse_tf[0]','$pulse_tf[2]',0)";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data, $LivdbConn);
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for PULSE_TF ////////////////////////////


///////////////////////////////////////////////////////////start code to insert the data for Unique Users  for toll free for  
$uu_tf=array();
$uu_tf_query="select 'UU_TF','Indian' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131224%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'UU_TF','Bangla' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131221%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'UU_TF','Nepali' as circle,count(distinct msisdn),'Digi' as service_name,date(call_date),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131222%' group by circle,hour(concat(call_date,' ',call_time))";

$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$dateFormat = $view_date1." ".$uu_tf[5].":00:00";
		$insert_uu_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$dateFormat','DIGIMA','".strtoupper($uu_tf[1])."' ,'$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data, $LivdbConn);
	}
}
///////////////////////////////////////////////////////////End code to insert the data for Unique Users  for toll free for  

////////////////////////////////////////////////////////////Start code to insert the data for SEC_TF For  /////////////////////////////
 
$sec_tf=array();
$sec_tf_query="select 'SEC_TF','Indian' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131224%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'SEC_TF','Bangla' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131221%' group by circle,hour(concat(call_date,' ',call_time))
union
select 'SEC_TF','Nepali' as circle,count(msisdn),'digi' as service_name,date(call_date),sum(duration_in_sec),hour(concat(call_date,' ',call_time)) from mis_db.tbl_digi_calllog where date(call_date)='$view_date1'  and dnis like '131222%' group by circle,hour(concat(call_date,' ',call_time))";

$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	$sec_tf_result = mysql_query($sec_tf_query, $dbConn) or die(mysql_error());
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$dateFormat = $view_date1." ".$sec_tf[6].":00:00";
		$insert_sec_tf_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$dateFormat','DIGIMA','".strtoupper($sec_tf[1])."' ,'$sec_tf[0]','$sec_tf[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_tf_data, $LivdbConn);
	}
}
////////////////////////////////////////////////////////////end code to insert the data for SEC_TF For  /////////////////////////////
//echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
