<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");

// delete the prevoius record
if(date('H')==01)
	echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
else
	echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));


//echo $view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$view_time1= date("h:i:s");

function getServiceName($service_id)
{
	switch($service_id)
		{
			case '1501':
				$service_name='AirtelEU';
			break;
			case '1502':
				$service_name='Airtel54646';
			break;
			case '1503':
				$service_name='MTVAirtel';
			break;
			case '1511':
				$service_name='AirtelGL';
			break;
			case '1507':
				$service_name='VH1Airtel';
			break;
			case '1509':
				$service_name='RIAAirtel';
			break;
			case '1518':
				$service_name='AirtelComedy';
			break;
			case '1513':
				$service_name='AirtelMND';
			break;
			case '1514':
				$service_name='AirtelPD';
			break;
			case '1517':
				$service_name='AirtelSE';
			break;
			case '1515':
				$service_name='AirtelDevo';
			break;
			case '1520':
				$service_name='AirtelPK';
			break;
			case '15221':
				$service_name='AirtelRegKK'; //planid-64 (21)
			break;
			case '15222':
				$service_name='AirtelRegTN'; //planid-63 (22)
			break;
		}
		return $service_name;
}


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConnAirtel) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConnAirtel) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//echo $DateFormat[0] = '2013-06-01 18:00:00';

///////// start the code to insert the data of CALLS Airtel 54646,MTV,GL,VH1 ////////////////

$service_array = array('AirtelEU','Airtel54646','MTVAirtel','AirtelGL','VH1Airtel','RIAAirtel','AirtelComedy','AirtelMND','AirtelPD','AirtelSE', 'AirtelDevo','AirtelPK','AirtelRegTN','AirtelRegKK');

$DeleteQuery="delete from misdata.livemis where date='$DateFormat[0]' and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%' OR type like 'PULSE_%' OR type like 'SEC_%' OR type like 'UU_%' OR type like 'MOU_%')";
$deleteResult12 = mysql_query($DeleteQuery,$LivdbConn) or die(mysql_error());

///////////////////////////// Added by Athar on 1st June 2103 forAirtel 54646//////////////////////////////////////////////////////////////

$call_tf_updatedQuery="select 'CALLS_TF',circle, count(id),'1502' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle,hour(call_time) ";
$call_tf_updatedQuery .=" union ";
$call_tf_updatedQuery .=" select 'CALLS_T',circle, count(id),'1502' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle,hour(call_time)";

$processlog = "/var/www/html/kmis/mis/livemis/logs/calling/callAU".date('Ymd').".txt";

$call_tf_new_result = mysql_query($call_tf_updatedQuery, $dbConnAirtel) or die(mysql_error());
$numRowsNew = mysql_num_rows($call_tf_new_result);
if ($numRowsNew > 0)
{
	$delAirtel54646CallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='Airtel54646' and type in('CALLS_TF','CALLS_T')";
	$call_tf_new_delresult = mysql_query($delAirtel54646CallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_new = mysql_fetch_array($call_tf_new_result))
	{
		if($circle_info[strtoupper($call_tf_new[1])]=='')
			$circle_info[strtoupper($call_tf_new[1])]='Other';

		$service_name=getServiceName($call_tf_new[3]);

		$insert_call_tf_data_new="insert into misdata3.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_new[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_new[1])]."','$call_tf_new[0]','$call_tf_new[2]',0)";
		$queryIns_call_new = mysql_query($insert_call_tf_data_new,$LivdbConn);
		
		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1502 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

///////////////////////////////////End Added by Athar on 1st June 2103 for Airtel 54646//////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel EU////////////////////////////////////////////////

$call_tf_updatedQueryEU="select 'CALLS_TF',circle, count(id),'1501' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and dnis like '546469%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";


$call_tf_new_resultEU = mysql_query($call_tf_updatedQueryEU, $dbConnAirtel) or die(mysql_error());
$numRowsNewEU = mysql_num_rows($call_tf_new_resultEU);
if ($numRowsNewEU > 0)
{
	$delAirtelEUCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelEU' and type in('CALLS_TF','CALLS_T')";
	$call_tf_new_delresultEU = mysql_query($delAirtelEUCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newEU = mysql_fetch_array($call_tf_new_resultEU))
	{
		if($circle_info[strtoupper($call_tf_newEU[1])]=='')
			$circle_info[strtoupper($call_tf_newEU[1])]='Other';

		$service_name=getServiceName($call_tf_newEU[3]);

		$insert_call_tf_data_newEU="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newEU[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newEU[1])]."','$call_tf_newEU[0]','$call_tf_newEU[2]',0)";
		$queryIns_call_newEU = mysql_query($insert_call_tf_data_newEU,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1501 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel EU///////////////////////////////////////////////////////////



//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel MTV////////////////////////////////////////////////

$call_tf_updatedQueryMTV="select 'CALLS_TF',circle, count(id),'1503' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultMTV = mysql_query($call_tf_updatedQueryMTV, $dbConnAirtel) or die(mysql_error());
$numRowsNewMTV = mysql_num_rows($call_tf_new_resultMTV);
if ($numRowsNewMTV > 0)
{
	$delAirtelMTVCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='MTVAirtel' and type='CALLS_TF'";
	$call_tf_new_delresultMTV = mysql_query($delAirtelMTVCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newMTV = mysql_fetch_array($call_tf_new_resultMTV))
	{
		if($circle_info[strtoupper($call_tf_newMTV[1])]=='')
			$circle_info[strtoupper($call_tf_newMTV[1])]='Other';

		$service_name=getServiceName($call_tf_newMTV[3]);

		$insert_call_tf_data_newMTV="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newMTV[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newMTV[1])]."','$call_tf_newMTV[0]','$call_tf_newMTV[2]',0)";
		$queryIns_call_newMTV = mysql_query($insert_call_tf_data_newMTV,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1503 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel MTV///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel Ria////////////////////////////////////////////////

$call_tf_updatedQueryRia="select 'CALLS_TF',circle, count(id),'1509' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultRia = mysql_query($call_tf_updatedQueryRia, $dbConnAirtel) or die(mysql_error());
$numRowsNewRia = mysql_num_rows($call_tf_new_resultRia);
if ($numRowsNewRia > 0)
{
	$delAirtelRiaCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='RIAAirtel' and type='CALLS_TF'";
	$call_tf_new_delresultRia = mysql_query($delAirtelRiaCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newRia = mysql_fetch_array($call_tf_new_resultRia))
	{
		if($circle_info[strtoupper($call_tf_newRia[1])]=='')
			$circle_info[strtoupper($call_tf_newRia[1])]='Other';

		$service_name=getServiceName($call_tf_newRia[3]);

		$insert_call_tf_data_newRia="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newRia[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newRia[1])]."','$call_tf_newRia[0]','$call_tf_newRia[2]',0)";
		$queryIns_call_newRia = mysql_query($insert_call_tf_data_newRia,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1509 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel Ria///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel Vh1////////////////////////////////////////////////

$call_tf_updatedQueryVH1="select 'CALLS_TF',circle, count(id),'1507' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis=55841 and operator='airm' and circle IN ('DEL', 'NES','ASM') group by circle,hour(call_time) ";

$call_tf_updatedQueryVH1 .=" union "; 

$call_tf_updatedQueryVH1 .=" select 'CALLS_T',circle, count(id),'1507' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis in(55841) and operator='airm' and circle NOT IN ('NES', 'DEL', 'ASM') group by circle,hour(call_time)";


$call_tf_new_resultVH1 = mysql_query($call_tf_updatedQueryVH1, $dbConnAirtel) or die(mysql_error());
$numRowsNewVH1 = mysql_num_rows($call_tf_new_resultVH1);
if ($numRowsNewVH1 > 0)
{
	$delAirtelVH1CallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='VH1Airtel' and type in('CALLS_TF','CALLS_T')";
	$call_tf_new_delresultVH1 = mysql_query($delAirtelVH1CallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newVH1 = mysql_fetch_array($call_tf_new_resultVH1))
	{
		if($circle_info[strtoupper($call_tf_newVH1[1])]=='')
			$circle_info[strtoupper($call_tf_newVH1[1])]='Other';

		$service_name=getServiceName($call_tf_newVH1[3]);

		$insert_call_tf_data_newVH1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newVH1[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newVH1[1])]."','$call_tf_newVH1[0]','$call_tf_newVH1[2]',0)";
		$queryIns_call_newVH1 = mysql_query($insert_call_tf_data_newVH1,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1507 CALLS_T' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel VH1///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel GL////////////////////////////////////////////////

$call_tf_updatedQueryGL="select 'CALLS_TF',circle, count(id),'1511' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle,hour(call_time)";
$call_tf_updatedQueryGL .=" union ";
$call_tf_updatedQueryGL .=" select 'CALLS_T',circle, count(id),'1511' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_ldr_calllog where date(call_date)='$view_date1' and dnis like '55001%' and operator='airm' and circle NOT IN ('DEL') group by circle,hour(call_time)";

$call_tf_new_resultGL = mysql_query($call_tf_updatedQueryGL, $dbConnAirtel) or die(mysql_error());
$numRowsNewGL = mysql_num_rows($call_tf_new_resultGL);
if ($numRowsNewGL > 0)
{
	$delAirtelGLCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelGL' and type in('CALLS_TF','CALLS_T')";
	$call_tf_new_delresultGL = mysql_query($delAirtelGLCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newGL = mysql_fetch_array($call_tf_new_resultGL))
	{
		if($circle_info[strtoupper($call_tf_newGL[1])]=='')
			$circle_info[strtoupper($call_tf_newGL[1])]='Other';

		$service_name=getServiceName($call_tf_newGL[3]);

		$insert_call_tf_data_newGL="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newGL[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newGL[1])]."','$call_tf_newGL[0]','$call_tf_newGL[2]',0)";
		$queryIns_call_newGL = mysql_query($insert_call_tf_data_newGL,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1511 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel GL///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AComedy////////////////////////////////////////////////

$call_tf_updatedQueryACom="select 'CALLS_TF',circle, count(id),'1518' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464612' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultACom = mysql_query($call_tf_updatedQueryACom, $dbConnAirtel) or die(mysql_error());
$numRowsNewACom = mysql_num_rows($call_tf_new_resultACom);
if ($numRowsNewACom > 0)
{
	$delAirtelAComCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelComedy' and type='CALLS_TF'";
	$call_tf_new_delresultACom = mysql_query($delAirtelAComCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newACom = mysql_fetch_array($call_tf_new_resultACom))
	{
		if($circle_info[strtoupper($call_tf_newACom[1])]=='')
			$circle_info[strtoupper($call_tf_newACom[1])]='Other';

		$service_name=getServiceName($call_tf_newACom[3]);

		$insert_call_tf_data_newACom="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newACom[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newACom[1])]."','$call_tf_newACom[0]','$call_tf_newACom[2]',0)";
		$queryIns_call_newACom = mysql_query($insert_call_tf_data_newACom,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1518 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel AComedy///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelPD////////////////////////////////////////////////

$call_tf_updatedQueryPD="select 'CALLS_TF',circle, count(id),'1514' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis='53222345' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultPD = mysql_query($call_tf_updatedQueryPD, $dbConnAirtel) or die(mysql_error());
$numRowsNewPD = mysql_num_rows($call_tf_new_resultPD);
if ($numRowsNewPD > 0)
{
	$delAirtelPDCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelPD' and type='CALLS_TF'";
	$call_tf_new_delresultPD = mysql_query($delAirtelPDCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newPD = mysql_fetch_array($call_tf_new_resultPD))
	{
		if($circle_info[strtoupper($call_tf_newPD[1])]=='')
			$circle_info[strtoupper($call_tf_newPD[1])]='Other';

		$service_name=getServiceName($call_tf_newPD[3]);

		$insert_call_tf_data_newPD="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newPD[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newPD[1])]."','$call_tf_newPD[0]','$call_tf_newPD[2]',0)";
		$queryIns_call_newPD = mysql_query($insert_call_tf_data_newPD,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1514 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelPD///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelMND////////////////////////////////////////////////

$call_tf_updatedQueryMND="select 'CALLS_TF',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis='5500196' and operator='airm' and circle IN ('DEL') group by circle,hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and dnis='5500196' and operator='airm' and circle NOT IN ('DEL') group by circle,hour(call_time)";

$call_tf_new_resultMND = mysql_query($call_tf_updatedQueryMND, $dbConnAirtel) or die(mysql_error());
$numRowsNewMND = mysql_num_rows($call_tf_new_resultMND);
if ($numRowsNewMND > 0)
{
	$delAirtelMNDCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelMND' and type in('CALLS_TF','CALLS_T')";
	$call_tf_new_delresultMND = mysql_query($delAirtelMNDCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newMND = mysql_fetch_array($call_tf_new_resultMND))
	{
		if($circle_info[strtoupper($call_tf_newMND[1])]=='')
			$circle_info[strtoupper($call_tf_newMND[1])]='Other';

		$service_name=getServiceName($call_tf_newMND[3]);

		$insert_call_tf_data_newMND="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newMND[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newMND[1])]."','$call_tf_newMND[0]','$call_tf_newMND[2]',0)";
		$queryIns_call_newMND = mysql_query($insert_call_tf_data_newMND,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1513 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelMND///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelDEVO////////////////////////////////////////////////

$call_tf_updatedQueryDEVO="select 'CALLS_TF',circle, count(id),'1515' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultDEVO = mysql_query($call_tf_updatedQueryDEVO, $dbConnAirtel) or die(mysql_error());
$numRowsNewDEVO = mysql_num_rows($call_tf_new_resultDEVO);
if ($numRowsNewDEVO > 0)
{
	$delAirtelDEVOCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelDevo' and type='CALLS_TF'";
	$call_tf_new_delresultDEVO = mysql_query($delAirtelDEVOCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newDEVO = mysql_fetch_array($call_tf_new_resultDEVO))
	{
		if($circle_info[strtoupper($call_tf_newDEVO[1])]=='')
			$circle_info[strtoupper($call_tf_newDEVO[1])]='Other';

		$service_name=getServiceName($call_tf_newDEVO[3]);

		$insert_call_tf_data_newDEVO="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newDEVO[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newDEVO[1])]."','$call_tf_newDEVO[0]','$call_tf_newDEVO[2]',0)";
		$queryIns_call_newDEVO = mysql_query($insert_call_tf_data_newDEVO,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1515 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelDEVO///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelSE////////////////////////////////////////////////

$call_tf_updatedQuerySE="select 'CALLS_TF',circle, count(id),'1517' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultSE = mysql_query($call_tf_updatedQuerySE, $dbConnAirtel) or die(mysql_error());
$numRowsNewSE = mysql_num_rows($call_tf_new_resultSE);
if ($numRowsNewSE > 0)
{
	$delAirtelSECallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelSE' and type='CALLS_TF'";
	$call_tf_new_delresultSE = mysql_query($delAirtelSECallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newSE = mysql_fetch_array($call_tf_new_resultSE))
	{
		if($circle_info[strtoupper($call_tf_newSE[1])]=='')
			$circle_info[strtoupper($call_tf_newSE[1])]='Other';

		$service_name=getServiceName($call_tf_newSE[3]);

		$insert_call_tf_data_newSE="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newSE[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newSE[1])]."','$call_tf_newSE[0]','$call_tf_newSE[2]',0)";
		$queryIns_call_newSE = mysql_query($insert_call_tf_data_newSE,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1517 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelSE///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelPK////////////////////////////////////////////////

$call_tf_updatedQueryPK="select 'CALLS_TF',circle, count(id),'1520' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultPK = mysql_query($call_tf_updatedQueryPK, $dbConnAirtel) or die(mysql_error());
$numRowsNewPK = mysql_num_rows($call_tf_new_resultPK);
if ($numRowsNewPK > 0)
{
	$delAirtelPKCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelPK' and type='CALLS_TF'";
	$call_tf_new_delresultPK = mysql_query($delAirtelPKCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newPK = mysql_fetch_array($call_tf_new_resultPK))
	{
		if($circle_info[strtoupper($call_tf_newPK[1])]=='')
			$circle_info[strtoupper($call_tf_newPK[1])]='Other';

		$service_name=getServiceName($call_tf_newPK[3]);

		$insert_call_tf_data_newPK="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newPK[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newPK[1])]."','$call_tf_newPK[0]','$call_tf_newPK[2]',0)";
		$queryIns_call_newPK = mysql_query($insert_call_tf_data_newPK,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1520 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelPK///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelRegKK////////////////////////////////////////////////

$call_tf_updatedQueryRegKK="select 'CALLS_TF',circle, count(id),'15221' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('TNU','CHN') group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultRegKK = mysql_query($call_tf_updatedQueryRegKK, $dbConnAirtel) or die(mysql_error());
$numRowsNewRegKK = mysql_num_rows($call_tf_new_resultRegKK);
if ($numRowsNewRegKK > 0)
{
	$delAirtelRegKKCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelRegKK' and type='CALLS_TF'";
	$call_tf_new_delresultRegKK = mysql_query($delAirtelRegKKCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newRegKK = mysql_fetch_array($call_tf_new_resultRegKK))
	{
		if($circle_info[strtoupper($call_tf_newRegKK[1])]=='')
			$circle_info[strtoupper($call_tf_newRegKK[1])]='Other';

		$service_name=getServiceName($call_tf_newRegKK[3]);

		$insert_call_tf_data_newRegKK="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newRegKK[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newRegKK[1])]."','$call_tf_newRegKK[0]','$call_tf_newRegKK[2]',0)";
		$queryIns_call_newRegKK = mysql_query($insert_call_tf_data_newRegKK,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelRegKK///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelRegTN////////////////////////////////////////////////

$call_tf_updatedQueryRegTN="select 'CALLS_TF',circle, count(id),'15222' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultRegTN = mysql_query($call_tf_updatedQueryRegTN, $dbConnAirtel) or die(mysql_error());
$numRowsNewRegTN = mysql_num_rows($call_tf_new_resultRegTN);
if ($numRowsNewRegTN > 0)
{
	$delAirtelRegTNCallTf="delete from misdata.livemis where date>date_format('".$view_date1."','%Y-%m-%d 00:00:00') and service='AirtelRegTN' and type='CALLS_TF'";
	$call_tf_new_delresultRegTN = mysql_query($delAirtelRegTNCallTf, $LivdbConn) or die(mysql_error());
	
	while($call_tf_newRegTN = mysql_fetch_array($call_tf_new_resultRegTN))
	{
		if($circle_info[strtoupper($call_tf_newRegTN[1])]=='')
			$circle_info[strtoupper($call_tf_newRegTN[1])]='Other';

		$service_name=getServiceName($call_tf_newRegTN[3]);

		$insert_call_tf_data_newRegTN="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values(date_add('$call_tf_newRegTN[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newRegTN[1])]."','$call_tf_newRegTN[0]','$call_tf_newRegTN[2]',0)";
		$queryIns_call_newRegTN = mysql_query($insert_call_tf_data_newRegTN,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15222 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelRegTN///////////////////////////////////////////////////////////



// end by athar


//start code to insert the data for mous_tf for Airtel
$mous_tf=array();
$mous_tf_query="select 'MOU_TF',circle, count(id),'1502' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'MOU_TF',circle, count(id),'1503' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'MOU_TF',circle, count(id),'1509' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1507' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1511' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1518' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1513' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1514' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1515' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1517' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'1520' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle
UNION
select 'MOU_TF',circle, count(id),'15221' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('TNU','CHN') group by circle
UNION
select 'MOU_TF',circle, count(id),'15222' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle
UNION
select 'MOU_TF',circle, count(id),'1501' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546469%' and operator='airm' group by circle";

$mous_tf_result = mysql_query($mous_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows2 = mysql_num_rows($mous_tf_result);
if ($numRows2 > 0)
{
	while($mous_tf = mysql_fetch_array($mous_tf_result))
	{
		$service_name=getServiceName($mous_tf[3]);
		$insert_mous_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($mous_tf[1])]."','$mous_tf[0]','$mous_tf[5]',0)";
		$queryIns_mous = mysql_query($insert_mous_tf_data1, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 MOU_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
//////////////////////////////////// end//////////////////////////////////////////


///////////////////////////////////////////////////Start code to insert the data for mou_t For ////////////////////////////
$mous_t=array();
$mous_t_query="select 'MOU_T',circle, count(id),'1502' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1507' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis =55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1511' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
union
select 'MOU_T',circle, count(id),'1513' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$mous_t_result = mysql_query($mous_t_query, $dbConnAirtel) or die(mysql_error());
$numRows21 = mysql_num_rows($mous_t_result);
if ($numRows21 > 0)
{
	$mous_t_result = mysql_query($mous_t_query, $dbConnAirtel) or die(mysql_error());
	while($mous_t = mysql_fetch_array($mous_t_result))
	{
		$service_name=getServiceName($mous_t[3]);
		$insert_mous_t_data="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name','".$circle_info[strtoupper($mous_t[1])]."','$mous_t[0]','$mous_t[5]',0)";
		$queryIns_mousT = mysql_query($insert_mous_t_data, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 MOU_T' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
/////////////////////////////////////////////////////////////////END code to insert the data for mou_t Airtel////////////////////////////

/////////////////////////////////start code to insert the data for PULSE_TF for Airtel SErvice/////////////////////////////////////////
$pulse_tf=array();
$pulse_tf_query="select 'PULSE_TF',circle, count(id),'1502' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1503' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator ='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1509' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator ='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1507' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator ='airm' group by circle
union
select 'PULSE_TF',circle, count(id),'1511' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1518' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1513' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1514' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1515' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1517' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'1520' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator ='airm' group by circle
UNION
select 'PULSE_TF',circle, count(id),'15221' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator ='airm' and circle IN ('TNU','CHN') group by circle
UNION
select 'PULSE_TF',circle, count(id),'15222' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator ='airm' and circle IN ('KAR') group by circle
UNION
select 'PULSE_TF',circle, count(id),'1501' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_AMU_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546469%' and operator='airm' group by circle";

$pulse_tf_result = mysql_query($pulse_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows3 = mysql_num_rows($pulse_tf_result);
if ($numRows3 > 0)
{
	while($pulse_tf = mysql_fetch_array($pulse_tf_result))
	{
		$service_name=getServiceName($pulse_tf[3]);
		$insert_pulse_tf_data1="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_tf[1])]."','$pulse_tf[0]','$pulse_tf[5]',0)";
		$queryIns_pulse = mysql_query($insert_pulse_tf_data1, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 PULSE_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
//////////////////////////////////End code to insert the data for PULSE_TF for Airtel SErvice/////////////////////////


/////////////////////////////////////////////////////Start code to insert the data for PULSE_T Airtel////////////////////////////
$pulse_t=array();
$pulse_t_query="select 'PULSE_T',circle, count(id),'1502' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'PULSE_T',circle, count(id),'1507' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator ='airm' group by circle
union
select 'PULSE_T',circle, count(id),'1511' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator ='airm' and circle NOT IN ('DEL') group by circle
union
select 'PULSE_T',circle, count(id),'1513' as service_name,date(call_date),sum(ceiling(duration_in_sec/60)) as pulse from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator ='airm' and circle NOT IN ('DEL') group by circle";

$pulse_t_result = mysql_query($pulse_t_query, $dbConnAirtel) or die(mysql_error());
$numRows31 = mysql_num_rows($pulse_t_result);
if ($numRows31 > 0)
{
	$pulse_t_result = mysql_query($pulse_t_query, $dbConnAirtel) or die(mysql_error());
	while($pulse_t = mysql_fetch_array($pulse_t_result))
	{
		$service_name=getServiceName($pulse_t[3]);
		$insert_pulse_t_data3="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($pulse_t[1])]."','$pulse_t[0]','$pulse_t[5]',0)";
		$queryIns_pulseT = mysql_query($insert_pulse_t_data3, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 PULSE_T' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
/////////////////////////////////////////////////////////////////End code to insert the data for PULSE_T Airtel////////////////////////////



////////////////////////////start code to insert the data for Unique Users //////////////////////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_TF',circle, count(distinct msisdn),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1503' as service_name,date(call_date) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1509' as service_name,date(call_date) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and operator='airm' and circle IN ('DEL') group by circle
union
select 'UU_TF',circle, count(distinct msisdn),'1518' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and operator='airm' and circle IN ('DEL') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1514' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1515' as service_name,date(call_date) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1517' as service_name,date(call_date) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1520' as service_name,date(call_date) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'15221' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('TNU','CHN') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'15222' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle
UNION
select 'UU_TF',circle, count(distinct msisdn),'1501' as service_name,date(call_date) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546469%' and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=getServiceName($uu_tf[3]);
		$insert_uu_tf_data2="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($uu_tf[1])]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data2, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 UU_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
///////////////////////////////////////////// end Unique Users//////////////////////////////////////////////////////


////////////////////////////////////////////////////////////Start code to insert the data Unique Users for toll //////////////////////////////
$uu_tf=array();
$uu_tf_query="select 'UU_T',circle, count(distinct msisdn),'1502' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' ) and operator='airm' group by circle
union
select 'UU_T',circle, count(distinct msisdn),'1507' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('DEL','NES','ASM') and operator='airm' group by circle
union
select 'UU_T',circle, count(distinct msisdn),'1511' as service_name,date(call_date) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
UNION
select 'UU_T',circle, count(distinct msisdn),'1513' as service_name,date(call_date) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";

$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0)
{
	$uu_tf_result = mysql_query($uu_tf_query, $dbConnAirtel) or die(mysql_error());
	while($uu_tf = mysql_fetch_array($uu_tf_result))
	{
		$service_name=getServiceName($uu_tf[3]);
		$insert_uu_tf_data32="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($uu_tf[1])]."','$uu_tf[0]','$uu_tf[2]',0)";
		$queryIns_uu = mysql_query($insert_uu_tf_data32, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 UU_T' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}

////////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll//////////////////////////////


///////////////////////////////////////////start code to insert the data for SEC_TF  Toll Free//////////////////////////////////////////////////
$sec_tf=array();
$sec_tf_query="select 'SEC_TF',circle, count(msisdn),'1502' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%' or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1503' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis in(546461,546461000) and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1509' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=5500169 and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1507' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle IN ('DEL', 'NES','ASM') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1511' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle IN ('DEL') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1518' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5464612' and operator='airm' group by circle
UNION
select 'SEC_TF',circle, count(msisdn),'1513' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle IN ('DEL') and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1514' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='53222345' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1515' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_devotional_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '51050%' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1517' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '571811%' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'1520' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_radio_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464613%' and operator='airm' group by circle
union
select 'SEC_TF',circle, count(msisdn),'15221' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('CHN','TNU') group by circle
union
select 'SEC_TF',circle, count(msisdn),'15222' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '5464614%' and operator='airm' and circle IN ('KAR') group by circle
union
select 'SEC_TF',circle, count(msisdn),'1501' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '546469%' and operator='airm' group by circle";

$sec_tf_result = mysql_query($sec_tf_query, $dbConnAirtel) or die(mysql_error());
$numRows5 = mysql_num_rows($sec_tf_result);
if ($numRows5 > 0)
{
	while($sec_tf = mysql_fetch_array($sec_tf_result))
	{
		$service_name=getServiceName($sec_tf[3]);
		$insert_sec_tf_data5="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]','$service_name', '".$circle_info[strtoupper($sec_tf[1])]."','$sec_tf[0]','$sec_tf[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_tf_data5, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 sec_tf' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}
// end insert the data for SEC_TF  for toll Free


$sec_t=array();

$sec_t_query="select 'SEC_T',circle, count(msisdn),'1502' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%') group by circle
union
select 'SEC_T',circle, count(msisdn),'1507' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis=55841 and circle NOT IN ('NES','DEL','ASM') and operator='airm' group by circle
union
select 'SEC_T',circle, count(msisdn),'1511' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis like '55001%' and circle NOT IN ('DEL') and operator='airm' group by circle
union
select 'SEC_T',circle, count(msisdn),'1513' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mnd_calllog where date(call_date)='$view_date1' and call_time between time('$DateFormat[0]' - INTERVAL 60 MINUTE) and time('$DateFormat[0]') and dnis='5500196' and circle NOT IN ('DEL') and operator='airm' group by circle";


$sec_t_result = mysql_query($sec_t_query, $dbConnAirtel) or die(mysql_error());
$numRows6 = mysql_num_rows($sec_t_result);
if ($numRows6 > 0)
{
	$sec_t_result = mysql_query($sec_t_query, $dbConnAirtel) or die(mysql_error());
	while($sec_t = mysql_fetch_array($sec_t_result))
	{
		$service_name=getServiceName($sec_t[3]);
		$insert_sec_t_data4="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) values('$DateFormat[0]', '$service_name', '".$circle_info[strtoupper($sec_t[1])]."','$sec_t[0]','$sec_t[5]',0)";
		$queryIns_sec = mysql_query($insert_sec_t_data4, $LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-15221 SEC_T' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processlog);}
	}
}


mysql_close($dbConnAirtel);
mysql_close($LivdbConn);

echo "generated";
// end 
?>