<?php
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
error_reporting(0);
$type=strtolower($_REQUEST['last']);
//$type='y';
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
echo $view_date1;

$fileDumpPath = '/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/';
//include service name configuration
include ("/var/www/html/kmis/mis/livemis/mis2.0/airtel/serviceNameconfig.php");
$kpiPrevfiledate=date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$AllkpiPrevprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/airtel/livekpi_".$kpiPrevfiledate.".txt";
unlink($AllkpiPrevprocessfile);
$kpifiledate=date("Ymd");
$Allkpiprocessfile = "/var/www/html/kmis/mis/livemis/mis2.0/airtel/livekpi_".$kpifiledate.".txt";
$kpi_process_status = '***************Script start for insertDailyReportCallLive_Airtel******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
$service_array = array('AirtelEU','Airtel54646','MTVAirtel','AirtelGL','VH1Airtel','RIAAirtel','AirtelComedy','AirtelMND','AirtelPD','AirtelSE', 'AirtelDevo','AirtelPK','AirtelRegTN','AirtelRegKK');

$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date1 . ' + 1 day'));

if (strtotime($check_date) == strtotime($view_date1)) {
    $DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "'  and date>'" . $view_date1 . " 00:00:00'
                    and service IN ('" . implode("','", $service_array) . "') 
                    and (type like 'CALLS_%')";
} else {
   $DeleteQuery = "delete from misdata.livemis where (date(date)='" . $view_date1 . "' 
                        or date='" . $next_date . " 00:00:00')  and service IN ('" . implode("','", $service_array) . "') 
                        and (type like 'CALLS_%')";
}
//echo $DeleteQuery;

$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());

$call_tf_updatedQuery="select 'CALLS_TF',circle, count(id),'1502' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis like '546460%' or dnis like '546461%' or dnis like '546462%'
 or dnis like '546463%' or dnis like '546469%' ) and dnis not in('546461','546461000') and operator='airm' group by circle,hour(call_time) ";
$call_tf_updatedQuery .=" union ";
$call_tf_updatedQuery .=" select 'CALLS_T',circle, count(id),'1502' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') 
from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and (dnis=54646 or dnis like '546465%' or dnis like '546464%' or dnis like '546466%' or dnis like '546467%' or dnis like '546468%' )
 and operator='airm' group by circle,hour(call_time)";

$processErrorlog = "/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/Errorlog_".date('Ymd').".txt";

$call_tf_new_result = mysql_query($call_tf_updatedQuery, $dbConnAirtel) or die(mysql_error());
$numRowsNew = mysql_num_rows($call_tf_new_result);
if ($numRowsNew > 0)
{
	
	while($call_tf_new = mysql_fetch_array($call_tf_new_result))
	{
		if($circle_info[strtoupper($call_tf_new[1])]=='')
			$circle_info[strtoupper($call_tf_new[1])]='Other';

		$service_name=getServiceName($call_tf_new[3]);

		$insert_call_tf_data_new="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue)
		values(date_add('$call_tf_new[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_new[1])]."','$call_tf_new[0]','$call_tf_new[2]',0)";
		$queryIns_call_new = mysql_query($insert_call_tf_data_new,$LivdbConn);
		
		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1502 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processErrorlog);}
	}
}

///////////////////////////////////End Added by Athar on 1st June 2103 for Airtel 54646//////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel EU////////////////////////////////////////////////

$call_tf_updatedQueryEU="select 'CALLS_TF',circle, count(id),'1501' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_AMU_calllog 
where date(call_date)='$view_date1' and dnis like '546469%' and dnis != '5464694' and operator='airm' group by circle,hour(call_time)";
$call_tf_updatedQueryEU .=" Union select 'CALLS_TF',circle, count(id),'1501' as service_name,date(call_date),hour(call_time) ,
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_AMU_calllog 
where date(call_date)='$view_date1' and dnis = '5464694' and circle in('kol','wbl') and operator='airm' group by circle,hour(call_time)";
//echo $call_tf_updatedQueryEU;
$call_tf_new_resultEU = mysql_query($call_tf_updatedQueryEU, $dbConnAirtel) or die(mysql_error());
$numRowsNewEU = mysql_num_rows($call_tf_new_resultEU);
if ($numRowsNewEU > 0)
{
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
		error_log($file_process_status, 3, $processErrorlog);}
	
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel EU///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel MTV////////////////////////////////////////////////

$call_tf_updatedQueryMTV="select 'CALLS_TF',circle, count(id),'1503' as service_name,date(call_date),hour(call_time) ,date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mtv_calllog where date(call_date)='$view_date1' and dnis in(546461,546461000) and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultMTV = mysql_query($call_tf_updatedQueryMTV, $dbConnAirtel) or die(mysql_error());
$numRowsNewMTV = mysql_num_rows($call_tf_new_resultMTV);
if ($numRowsNewMTV > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel MTV///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel Ria////////////////////////////////////////////////

$call_tf_updatedQueryRia="select 'CALLS_TF',circle, count(id),'1509' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_riya_calllog where date(call_date)='$view_date1' and dnis=5500169 and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultRia = mysql_query($call_tf_updatedQueryRia, $dbConnAirtel) or die(mysql_error());
$numRowsNewRia = mysql_num_rows($call_tf_new_resultRia);
if ($numRowsNewRia > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
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
		error_log($file_process_status, 3, $processErrorlog);}
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}


/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel GL///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AComedy////////////////////////////////////////////////

$call_tf_updatedQueryACom="select 'CALLS_TF',circle, count(id),'1518' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis like '5464612' and operator='airm' group by circle,hour(call_time)";
$call_tf_updatedQueryACom .=" union ";
$call_tf_updatedQueryACom .=" select 'CALLS_T_3',circle, count(id),'1518' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_54646_calllog where date(call_date)='$view_date1' and dnis ='5464640' and operator='airm' group by circle,hour(call_time)";

$call_tf_new_resultACom = mysql_query($call_tf_updatedQueryACom, $dbConnAirtel) or die(mysql_error());
$numRowsNewACom = mysql_num_rows($call_tf_new_resultACom);
if ($numRowsNewACom > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for Airtel AComedy///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelPD////////////////////////////////////////////////

$call_tf_updatedQueryPD="select 'CALLS_TF',circle, count(id),'1514' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis='53222345' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultPD = mysql_query($call_tf_updatedQueryPD, $dbConnAirtel) or die(mysql_error());
$numRowsNewPD = mysql_num_rows($call_tf_new_resultPD);
if ($numRowsNewPD > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelPD///////////////////////////////////////////////////////////

//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelMND////////////////////////////////////////////////

$call_tf_updatedQueryMND="select 'CALLS_TF',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                          date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                          date(call_date)='$view_date1' and dnis='5500196' and operator='airm' and circle IN ('DEL') group by circle,hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='5500196' and operator='airm' and circle NOT IN ('DEL') group by circle,
                            hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T_3',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='55001963' and operator='airm' group by circle,
                      hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T_5',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='55001965' and operator='airm' and circle in('RAJ','ORI') group by circle,
                      hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T_6',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='55001966' and operator='airm' and circle in('upw','hpd','har','pub','jnk','bih')
                            group by circle,
                            hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T_1',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='55001961' and operator='airm'  group by circle,
                            hour(call_time)";
$call_tf_updatedQueryMND .=" union ";
$call_tf_updatedQueryMND .="select 'CALLS_T_9',circle, count(id),'1513' as service_name,date(call_date),hour(call_time),
                            date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_mnd_calllog where 
                            date(call_date)='$view_date1' and dnis ='55001969' and operator='airm'  group by circle,
                            hour(call_time)";

$call_tf_new_resultMND = mysql_query($call_tf_updatedQueryMND, $dbConnAirtel) or die(mysql_error());
$numRowsNewMND = mysql_num_rows($call_tf_new_resultMND);
if ($numRowsNewMND > 0)
{
	
	while($call_tf_newMND = mysql_fetch_array($call_tf_new_resultMND))
	{
		if($circle_info[strtoupper($call_tf_newMND[1])]=='')
			$circle_info[strtoupper($call_tf_newMND[1])]='Other';

		$service_name=getServiceName($call_tf_newMND[3]);

		$insert_call_tf_data_newMND="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
                values(date_add('$call_tf_newMND[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newMND[1])]."','$call_tf_newMND[0]','$call_tf_newMND[2]',0)";
        $queryIns_call_newMND = mysql_query($insert_call_tf_data_newMND,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1513 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processErrorlog);}
	}
}



/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelMND///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelDEVO////////////////////////////////////////////////

$call_tf_updatedQueryDEVO="select 'CALLS_TF',circle, count(id),'1515' as service_name,date(call_date),hour(call_time),
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_devotional_calllog 
where date(call_date)='$view_date1' and dnis like '51050%' and operator='airm' group by circle,hour(call_time) ";
$call_tf_updatedQueryDEVO .=" union ";
$call_tf_updatedQueryDEVO .="select 'CALLS_T_6',circle, count(id),'1515' as service_name,date(call_date),hour(call_time),
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_devotional_calllog 
where date(call_date)='$view_date1' and dnis = '510168' and operator='airm' group by circle,hour(call_time) ";
$call_tf_new_resultDEVO = mysql_query($call_tf_updatedQueryDEVO, $dbConnAirtel) or die(mysql_error());
$numRowsNewDEVO = mysql_num_rows($call_tf_new_resultDEVO);
if ($numRowsNewDEVO > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelDEVO///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelSE////////////////////////////////////////////////

$call_tf_updatedQuerySE="select 'CALLS_TF',circle, count(id),'1517' as service_name,date(call_date),hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_SPKNG_calllog where date(call_date)='$view_date1' and dnis like '571811%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultSE = mysql_query($call_tf_updatedQuerySE, $dbConnAirtel) or die(mysql_error());
$numRowsNewSE = mysql_num_rows($call_tf_new_resultSE);
if ($numRowsNewSE > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}

/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelSE///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelPK////////////////////////////////////////////////

$call_tf_updatedQueryPK="select 'CALLS_TF',circle, count(id),'1520' as service_name,date(call_date),
hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') from mis_db.tbl_radio_calllog 
where date(call_date)='$view_date1' and dnis like '5464613%' and operator='airm' group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultPK = mysql_query($call_tf_updatedQueryPK, $dbConnAirtel) or die(mysql_error());
$numRowsNewPK = mysql_num_rows($call_tf_new_resultPK);
if ($numRowsNewPK > 0)
{
	
	while($call_tf_newPK = mysql_fetch_array($call_tf_new_resultPK))
	{
		if($circle_info[strtoupper($call_tf_newPK[1])]=='')
			$circle_info[strtoupper($call_tf_newPK[1])]='Other';

		$service_name=getServiceName($call_tf_newPK[3]);

		$insert_call_tf_data_newPK="insert into misdata.livemis(Date,Service,Circle,Type,Value,Revenue) 
                values(date_add('$call_tf_newPK[6]',interval 1 hour),'$service_name', '".$circle_info[strtoupper($call_tf_newPK[1])]."','$call_tf_newPK[0]','$call_tf_newPK[2]',0)";
		$queryIns_call_newPK = mysql_query($insert_call_tf_data_newPK,$LivdbConn);

		$error = mysql_error();
		if($error){
		$file_process_status = 'Load Data Error-1520 CALLS_TF' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
		error_log($file_process_status, 3, $processErrorlog);}
	}
}
/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelPK///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelRegKK////////////////////////////////////////////////

$call_tf_updatedQueryRegKK="select 'CALLS_TF',circle, count(id),'15221' as service_name,date(call_date),hour(call_time),
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' and operator='airm' 
and circle IN ('TNU','CHN') group by circle,hour(call_time) order by hour(call_time)";

$call_tf_new_resultRegKK = mysql_query($call_tf_updatedQueryRegKK, $dbConnAirtel) or die(mysql_error());
$numRowsNewRegKK = mysql_num_rows($call_tf_new_resultRegKK);
if ($numRowsNewRegKK > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}
/////////////////////////////////End Added by Athar on 1st June 2103 for AirtelRegKK///////////////////////////////////////////////////////////


//////////////////////////////////// Added by Athar on 1st June 2103 forAirtel AirtelRegTN////////////////////////////////////////////////

$call_tf_updatedQueryRegTN="select 'CALLS_TF',circle, count(id),'15222' as service_name,date(call_date),hour(call_time),
date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis like '5464614%' 
and operator='airm' and circle IN ('KAR') group by circle,hour(call_time) ";
$call_tf_updatedQueryRegTN .=" union "; 
$call_tf_updatedQueryRegTN .=" select 'CALLS_T_3',circle, count(id),'15222' as service_name,date(call_date),
hour(call_time),date_format(concat(call_date,' ',hour(call_time)),'%Y-%m-%d %H:00:00') 
from mis_db.tbl_edu_calllog where date(call_date)='$view_date1' and dnis  ='5464643' 
and operator='airm' and circle IN ('KAR','KK') group by circle,hour(call_time) ";

$call_tf_new_resultRegTN = mysql_query($call_tf_updatedQueryRegTN, $dbConnAirtel) or die(mysql_error());
$numRowsNewRegTN = mysql_num_rows($call_tf_new_resultRegTN);
if ($numRowsNewRegTN > 0)
{
	
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
		error_log($file_process_status, 3, $processErrorlog);}
	}
}

///////////////////////////////////////////////////////////End code to insert the data  Unique Users for toll//////////////////////////////


// sleep for 10 seconds
sleep(10);
//delete data for next day default datetime 2013-10-27 00:00:00
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from misdata.livemis where date=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service IN ('".implode("','",$service_array)."') and (type like 'CALLS_%')";
if($date_Currentthour!='00')
{
if($type!='y')
{
echo "Next day data delete".$nextDeleteQuery;
$deleteResult12 = mysql_query($nextDeleteQuery,$LivdbConn) or die(mysql_error());
}
}
echo "Current hour is".$date_Currentthour;
$DeleteQuery = "delete from misdata.livemis where date(date)='" . $view_date1 . "' and hour(date)>'" . $date_Currentthour . "' and service IN ('" . implode("','", $service_array) . "') and (type like 'CALLS_%')";
if($date_Currentthour!='23')
{
if($type!='y')
{
echo $DeleteQuery;
$deleteResult12 = mysql_query($DeleteQuery, $LivdbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}


mysql_close($dbConnAirtel);
mysql_close($LivdbConn);

echo "generated";
$kpi_process_status = '*******Script end for insertDailyReportCallLive_Airtel*********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($kpi_process_status, 3, $Allkpiprocessfile);
?>