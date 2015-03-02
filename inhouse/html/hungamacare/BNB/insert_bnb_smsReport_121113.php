<?php
session_start();
$uploadvaluearray = array('contest_info'=>'Contest Info','call_logs'=>'Call Logs','mis'=>'MIS');
$db="Hungama_BNB";
//case 'VODAFONE':
$con_voda = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123'); //Voda
if (!$con_voda)
 {
  die('Could not connect: ' . mysql_error("could not connect to Voda"));
 }
 else
 {
 echo "connection OK-voda";
 }
//case 'AIRTEL':
//$con_airtel = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987'); //Airtel
//case 'MTS':
//$con_mts = mysql_connect('10.130.14.106', 'billing','billing'); //MTS
//case 'RELIANCE':
$con_212 = mysql_connect("192.168.100.224","webcc","webcc");
if (!$con_212)
 {
  die('Could not connect: ' . mysql_error("could not connect to inhouse"));
 }
 else
 {
 echo "connection OK-212";
 }
//$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$del="delete from Hungama_BNB.insertDailyreport_smsinfo where date(date_time)='".$view_date1."'";
//$delquery = mysql_query($del,$con_212);
	
//vodafone
echo $get_query="select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
from question_played where mode='SMS' group by date(date_time),circle";
$query = mysql_query($get_query,$con_voda);
echo $numofrows=mysql_num_rows($query);
exit;
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date'];
	$UU_Calls=$summarydata['UU_Calls'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	echo $totalsms=$summarydata['totalSMS'];
	if($summarydata['UU_Calls']!=0)
	{
	echo $insert_data="insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
else
{
echo "NOK";
}
/*
//mts
$get_query="select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
 from question_played where mode='SMS' group by date(date_time),circle ";
$query = mysql_query($get_query,$con_mts);
$numofrows=mysql_num_rows($query);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date'];
	$UU_Calls=$summarydata['UU_Calls'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$totalsms=$summarydata['totalSMS'];
	if($summarydata['UU_Calls']!=0)
	{
	$insert_data="insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
//airtel
$get_query="select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator 
from question_played where mode='SMS' group by date(date_time),circle ";
$query = mysql_query($get_query,$con_airtel);
$numofrows=mysql_num_rows($query);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date'];
	$UU_Calls=$summarydata['UU_Calls'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$totalsms=$summarydata['totalSMS'];
	if($summarydata['UU_Calls']!=0)
	{
	$insert_data="insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
//Inhouse
$get_query="select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
from question_played where mode='SMS' group by date(date_time),circle ";
$query = mysql_query($get_query,$con_212);
$numofrows=mysql_num_rows($query);
if($numofrows>=1)
{
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date'];
	$UU_Calls=$summarydata['UU_Calls'];
	$operator=$summarydata['operator'];
	$circle=$summarydata['circle'];
	$totalsms=$summarydata['totalSMS'];
	if($summarydata['UU_Calls']!=0)
	{
	$insert_data="insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
	$queryIns = mysql_query($insert_data, $con_212);
	}
	}
}
echo "Done";
*/
mysql_close($con_voda);
//mysql_close($con_airtel);
//mysql_close($con_mts);
mysql_close($con_212);
?>