<?php
error_reporting(0);
include("commonDb.php");
$uploadvaluearray = array('contest_info' => 'Contest Info', 'call_logs' => 'Call Logs', 'mis' => 'MIS');

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$view_date1='2013-11-18';
$del="delete from Hungama_BNB.insertDailyreport_smsinfo where date(date_time)='".$view_date1."'";
$delquery = mysql_query($del,$con_212);

//////////////////////////////////////////////////////////////////// Code start for vodafone ////////////////////////////////////////////////////////
$get_query = "select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
from Hungama_BNB.question_played where mode='SMS' and date(date_time)='".$view_date1."' group by date(date_time),circle";
$query = mysql_query($get_query, $con_voda);
$numofrows = mysql_num_rows($query);

if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query)) {
        $date = $summarydata['date'];
        $UU_Calls = $summarydata['UU_Calls'];
        $operator = $summarydata['operator'];
        $circle = $summarydata['circle'];
        $totalsms = $summarydata['totalSMS'];
        if ($summarydata['UU_Calls'] != 0) {
            $insert_data = "insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
            $queryIns = mysql_query($insert_data, $con_212);
        }
    }
}
//////////////////////////////////////////////////////////////////// Code End for vodafone ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////// Code start for MTS ////////////////////////////////////////////////////////
$get_query = "select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
 from Hungama_BNB.question_played where mode='SMS' and date(date_time)='".$view_date1."' group by date(date_time),circle ";
$query = mysql_query($get_query, $con_mts);
$numofrows = mysql_num_rows($query);
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query)) {
        $date = $summarydata['date'];
        $UU_Calls = $summarydata['UU_Calls'];
        $operator = $summarydata['operator'];
        $circle = $summarydata['circle'];
        $totalsms = $summarydata['totalSMS'];
        if ($summarydata['UU_Calls'] != 0) {
            $insert_data = "insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
            $queryIns = mysql_query($insert_data, $con_212);
        }
    }
}
//////////////////////////////////////////////////////////////////// Code End for MTS ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////// Code start for Airtel ////////////////////////////////////////////////////////
$get_query = "select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator 
from Hungama_BNB.question_played where mode='SMS' and date(date_time)='".$view_date1."' group by date(date_time),circle";
$query = mysql_query($get_query, $con_airtel);
$numofrows = mysql_num_rows($query);
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query)) {
        $date = $summarydata['date'];
        $UU_Calls = $summarydata['UU_Calls'];
        $operator = $summarydata['operator'];
        $circle = $summarydata['circle'];
        $totalsms = $summarydata['totalSMS'];
        if ($summarydata['UU_Calls'] != 0) {
            $insert_data = "insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
            $queryIns = mysql_query($insert_data, $con_212);
        }
    }
}
//////////////////////////////////////////////////////////////////// Code End for Airtel ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////// Code start for Inhouse ////////////////////////////////////////////////////////
$get_query = "select count(1) as totalSMS,count(distinct ANI) as UU_Calls,circle,date(date_time) as date,operator
from Hungama_BNB.question_played where mode='SMS' and date(date_time)='".$view_date1."' group by date(date_time),circle";
$query = mysql_query($get_query, $con_212);
$numofrows = mysql_num_rows($query);
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query)) {
        $date = $summarydata['date'];
        $UU_Calls = $summarydata['UU_Calls'];
        $operator = $summarydata['operator'];
        $circle = $summarydata['circle'];
        $totalsms = $summarydata['totalSMS'];
        if ($summarydata['UU_Calls'] != 0) {
            $insert_data = "insert into Hungama_BNB.insertDailyreport_smsinfo(contest_name,date_time,unique_user,circle,operator,total_count)
	values('BNB','$date' ,'$UU_Calls','$circle','$operator','$totalsms')";
            $queryIns = mysql_query($insert_data, $con_212);
        }
    }
}
//////////////////////////////////////////////////////////////////// Code End for Inhouse ////////////////////////////////////////////////////////

echo "Done-SMS REPORT";

mysql_close($con_voda);
mysql_close($con_airtel);
mysql_close($con_mts);
mysql_close($con_212);
?>