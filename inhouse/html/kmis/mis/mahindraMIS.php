<?php 
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

// delete the prevoius record
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

////////////////////////// Create Mahindra XUV MIS code//////////////////////////////////

$del_query="DELETE FROM mis_db.dailyReportLiveFM WHERE report_date='".$view_date1."'";
$result = mysql_query($del_query);

$calls=array();
$calls_query="select 'CALLS_TF',count(id),'MXUV500' as service_name,date(call_date) from mis_db.tbl_mahindraxuv_calllog where date(call_date)='$view_date1' and dnis like '30781980%'";

$calls_result = mysql_query($calls_query, $dbConn) or die(mysql_error());
$numRows = mysql_num_rows($calls_result);
if ($numRows > 0)
{
        while($calls_tf = mysql_fetch_array($calls_result))
        {
                $calls_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$calls_tf[0]','ALL','0','$calls_tf[1]','','MAHXUV','NA','NA','NA')";
                $queryIns_sec = mysql_query($calls_data, $dbConn);
        }
}

$mous=array();
$mous_query="select 'MOU_TF',count(id),'MXUV500' as service_name,date(call_date),sum(duration_in_sec)/60 as mous from mis_db.tbl_mahindraxuv_calllog where date(call_date)='$view_date1' and dnis like '30781980%'";

$mous_result = mysql_query($mous_query, $dbConn) or die(mysql_error());
$numRows1 = mysql_num_rows($mous_result);
if ($numRows1 > 0)
{
        while($mous_tf = mysql_fetch_array($mous_result))
        {
                $mous_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$mous_tf[0]','ALL','0','$mous_tf[4]','','MAHXUV','$mous_tf[4]','NA','NA')";
                $queryIns_sec = mysql_query($mous_data, $dbConn);
        }
}


$pulse=array();
$pulse_query="select 'PULSE_TF',sum(ceiling(duration_in_sec/60)) as pulse ,'MXUV500' as service_name,date(call_date) from mis_db.tbl_mahindraxuv_calllog where date(call_date)='$view_date1' and dnis like '30781980%'";

$pulse_result = mysql_query($pulse_query, $dbConn) or die(mysql_error());
$numRows2 = mysql_num_rows($pulse_result);
if ($numRows2 > 0)
{
        while($pulse_tf = mysql_fetch_array($mous_result))
        {
                $mous_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$pulse_tf[0]','ALL','0','$pulse_tf[1]','','MAHXUV','NA','$pulse_tf[1]','NA')";
                $queryIns_sec = mysql_query($mous_data, $dbConn);
        }
}

$sec=array();
$sec_query="select 'SEC_TF',count(msisdn),'MXUV500' as service_name,date(call_date),sum(duration_in_sec) from mis_db.tbl_mahindraxuv_calllog where date(call_date)='$view_date1' and dnis like '30781980%'";

$sec_result = mysql_query($sec_query, $dbConn) or die(mysql_error());
$numRows3 = mysql_num_rows($sec_result);
if ($numRows3 > 0)
{
        while($sec_tf = mysql_fetch_array($sec_result))
        {
                $sec_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$sec_tf[0]','ALL','0','$sec_tf[4]','','MAHXUV','NA','NA','$sec_tf[4]')";
                $queryIns_sec = mysql_query($sec_data, $dbConn);
        }
}


$uu=array();
$uu_query="select 'UU_TF',count(distinct msisdn) as user,'MXUV500' as service_name,date(call_date) from mis_db.tbl_mahindraxuv_calllog where date(call_date)='$view_date1' and dnis like '30781980%'";

$uu_result = mysql_query($uu_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_result);
if ($numRows4 > 0)
{
        while($uu_tf = mysql_fetch_array($uu_result))
        {
                $uu_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$uu_tf[0]','ALL','0','$uu_tf[1]','','MAHXUV','NA','NA','NA')";
                $queryIns_sec = mysql_query($uu_data, $dbConn);
        }
}


$rec_query="SELECT 'REC_CALL', count(ANI), date(date_time) from mis_db.mahindraxuv where date(date_time)='$view_date1'";

$rec_result = mysql_query($rec_query, $dbConn) or die(mysql_error());
$numRows5 = mysql_num_rows($rec_result);
if ($numRows5 > 0)
{
        while($rec_tf = mysql_fetch_array($rec_result))
        {
                $rec_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$rec_tf[0]','ALL','0','$rec_tf[1]','','MAHXUV','NA','NA','NA')";
                $queryIns_sec = mysql_query($rec_data, $dbConn);
        }
}


$recuu_query="SELECT 'REC_UU', count(distinct ANI), date(date_time) from mis_db.mahindraxuv where date(date_time)='$view_date1'";
$recuu_result = mysql_query($recuu_query, $dbConn) or die(mysql_error());
$numRows6 = mysql_num_rows($recuu_result);
if ($numRows6 > 0)
{
        while($recuu_tf = mysql_fetch_array($recuu_result))
        {
                $recuu_data="insert into mis_db.dailyReportLiveFM(report_date,type,circle,charging_rate,total_count,mode_of_sub,service_id,mous, pulse,total_sec) values('$view_date1', '$recuu_tf[0]','ALL','0','$recuu_tf[1]','','MAHXUV','NA','NA','NA')";
                $queryIns_sec = mysql_query($recuu_data, $dbConn);
        }
}

///////////////////////// Create Mahindra XUV MIS code end //////////////////////////////


mysql_close($dbConn);
echo "done";
?>
