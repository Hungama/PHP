<?php
error_reporting(0);
include("commonDb.php");
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
	} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo 'Data generated for -'.$view_date1;
$del="delete from Inhouse_IVR.tbl_advertisment_Dashboard where date(report_date)='".$view_date1."'";
$delquery = mysql_query($del,$con_212);
//Inhouse
$get_query="select count(ANI) as totalcount,date(date_time) as date,circle,operator,SC,service_name from Inhouse_IVR.tbl_advertisment_logging nolock
where date(date_time)='".$view_date1."' group by date(date_time),circle,SC,service_name";
$query = mysql_query($get_query,$con_212);
$numofrows=mysql_num_rows($query);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date'];
	$totalcount=$summarydata['totalcount'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$service_name=$summarydata['service_name'];
	$SC=$summarydata['SC'];
	if($summarydata['totalcount']!=0)
	{
	$insert_data="insert into Inhouse_IVR.tbl_advertisment_Dashboard(ad_id,report_date,service_name,totalcount,circle,operator,SC)
	values('0','$date' ,'$service_name','$totalcount','$circle','$operator','$SC')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
//vodafone
$get_query_voda="select count(ANI) as totalcount,date(date_time) as date,circle,operator,SC,service_name from Vodafone_IVR.tbl_advertisment_logging nolock
where date(date_time)='".$view_date1."' group by date(date_time),circle,SC,service_name";
$query_voda = mysql_query($get_query_voda,$con_voda);
$numofrows=mysql_num_rows($query_voda);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query_voda)) 
	{
	$date=$summarydata['date'];
	$totalcount=$summarydata['totalcount'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$service_name=$summarydata['service_name'];
	$SC=$summarydata['SC'];
	if($summarydata['totalcount']!=0)
	{
	$insert_data="insert into Inhouse_IVR.tbl_advertisment_Dashboard(ad_id,report_date,service_name,totalcount,circle,operator,SC)
	values('0','$date' ,'$service_name','$totalcount','$circle','$operator','$SC')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}


//Airtel
$get_query_airm="select count(ANI) as totalcount,date(date_time) as date,circle,operator,SC,service_name from Airtel_IVR.tbl_advertisment_logging nolock
where date(date_time)='".$view_date1."' group by date(date_time),circle,SC,service_name";
$query_airm = mysql_query($get_query_airm,$con_airtel);
$numofrows=mysql_num_rows($query_airm);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query_airm)) 
	{
	$date=$summarydata['date'];
	$totalcount=$summarydata['totalcount'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$service_name=$summarydata['service_name'];
	$SC=$summarydata['SC'];
	if($summarydata['totalcount']!=0)
	{
	$insert_data="insert into Inhouse_IVR.tbl_advertisment_Dashboard(ad_id,report_date,service_name,totalcount,circle,operator,SC)
	values('0','$date' ,'$service_name','$totalcount','$circle','$operator','$SC')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
//MTS

$get_query_mts="select count(ANI) as totalcount,date(date_time) as date,circle,operator,SC,service_name from MTS_IVR.tbl_advertisment_logging nolock
where date(date_time)='".$view_date1."' group by date(date_time),circle,SC,service_name";
$query_mts = mysql_query($get_query_mts,$con_mts);
$numofrows=mysql_num_rows($query_mts);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query_mts)) 
	{
	$date=$summarydata['date'];
	$totalcount=$summarydata['totalcount'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$service_name=$summarydata['service_name'];
	$SC=$summarydata['SC'];
	if($summarydata['totalcount']!=0)
	{
	$insert_data="insert into Inhouse_IVR.tbl_advertisment_Dashboard(ad_id,report_date,service_name,totalcount,circle,operator,SC)
	values('0','$date' ,'$service_name','$totalcount','$circle','$operator','$SC')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
echo "Done";
mysql_close($con_voda);
mysql_close($con_airtel);
mysql_close($con_mts);
mysql_close($con_212);
?>
