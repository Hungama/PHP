<?php
include ("config/dbConnect.php");
$file_ext= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$deletePreviousData="delete from mis_db.tbl_mtv_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

// Calllog call is for tata Docomo Endless Docomo
$file_to_read1="http://10.2.73.156/FetchLogMTV/mtv_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_mtv_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// end code to Calllog call is for tata Docomo Endless Docomo


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Calllog call is for 54646

$deletePreviousData="delete from mis_db.tbl_54646_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

$file_to_read1="http://10.2.73.156/FetchLogAirtel/54646_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_54646_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data for 54646



////////////////////////////////////////////////////////////// Calllog call is for VH1//////////////////////////////////////////////////


$file_to_read1="http://10.2.73.156/FetchLogVH1/vh1_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	$insert_query="insert into mis_db.tbl_54646_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
///////////////////////////////////////////// End Code to insert the data for VH1///////////////////////////////////////////////////////////////



///////////////////////////////////////////////////// Calllog call is for VH1/////////////////////////////////////////////////////////////


$file_to_read1="http://10.2.73.156/FetchLogRasoi/rasoi_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	$insert_query="insert into mis_db.tbl_54646_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
///////////////////////////////// End Code to insert the data for VH1/////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Calllog call is for MOD(Tata docomo Endless and Tata Indicom)

$deletePreviousData="delete from mis_db.tbl_radio_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

$file_to_read1="http://10.2.73.156/FetchLogMOD/MOD_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_radio_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data for MOD(Tata docomo Endless and Tata Indicom)

// Calllog call is for AirtelRIA
$deletePreviousData="delete from mis_db.tbl_riya_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

$file_to_read1="http://10.2.73.156/RIYA/RIYA_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_riya_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data forAirtelRIA

/*// Calllog call is for Cricket Mania
$deletePreviousData="delete from mis_db.tbl_cricket_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

$file_to_read1="http://119.82.69.213/FetchLogCric/cricket_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_cricket_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data for Cricket Mania

// Calllog call is for Audio Cinema
$deletePreviousData="delete from mis_db.tbl_audioCinema_calllog where date(call_date)='$file_ext'";
$delete_result = mysql_query($deletePreviousData, $dbConn) or die(mysql_error());

$file_to_read1="http://119.82.69.213/FetchLogAC/audiocinema_calllog_".$file_ext.".txt";

$file_name=file($file_to_read1);
$file_size=sizeof($file_name);
for($i=0;$i<$file_size;$i++)
{
	$file_content=explode("#",$file_name[$i]);
	$call_date=date('Y-m-d',strtotime($file_content[3]));
	$call_time=date('H-i-s',strtotime($file_content[4]));
	
	$pulse=(int)($file_content[5]/60)+1;
	$machine_data=explode("_",$file_content[1]);
	
	 $insert_query="insert into mis_db.tbl_audioCinema_calllog(machine_name,status,call_date,call_time,duration_in_sec,msisdn,content_duration,dnis,real_dnis,circle,pulse,operator) values('$file_content[1]','$file_content[2]','$call_date','$call_time','$file_content[5]','$file_content[6]','$file_content[7]','$file_content[8]','$file_content[9]','$machine_data[2]','$pulse','$machine_data[0]')";
	$query = mysql_query($insert_query, $dbConn) or die(mysql_error());
}
// End Code to insert the data for Audio Cinema */

echo "data Inserted";
mysql_close($dbConn);

?>
