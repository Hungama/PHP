<?php
$cpgid=$_SESSION['cpgid'];
$campg_manager_id=$_SESSION['suid'];
if(empty($campg_manager_id))
{
session_destroy();
Header("location:index.php?ERROR=502");
}
//$cpgid='PO0Ho20131216';
$getCampgion_dataInfo="select cpgname,mobileno from Inhouse_IVR.tbl_missedcall_cpginfo nolock where cpgid='".$cpgid."'";
$getCampgion_data = mysql_query($getCampgion_dataInfo,$con);
list($campainpgname,$missed_mobileno) = mysql_fetch_array($getCampgion_data); 

function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$getDashbord_RepeatUser=mysql_query("select msisdn ,count(*) as total from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'
group by msisdn HAVING total > 1",$con);
$totalrepeat_user=mysql_num_rows($getDashbord_RepeatUser);

//total SMS Send
$getDashbord_totalsmssent=mysql_query("select msisdn from Inhouse_IVR.tbl_missedcall_smslist where 
date(added_on) between '".$StartDate."' and '".$EndDate."' and cpgid='".$cpgid."'",$con);
$totalsms_user=mysql_num_rows($getDashbord_totalsmssent);

//New Visists vs Returning Customers section start here
$getDashbord_totalnewvisist=mysql_query("select distinct(msisdn)
from Inhouse_IVR.tbl_missedcall_smslist nolock where date(added_on)=date(now()) and cpgid='".$cpgid."'",$con);
$totalnewvisist=mysql_num_rows($getDashbord_totalnewvisist);

$getDashbord_totalReturning=mysql_query("select msisdn,count(*) as total from Inhouse_IVR.tbl_missedcall_smslist nolock where 
date(added_on) between '".$StartDate."' and '".$EndDate."' and
cpgid='".$cpgid."' 
 group by msisdn HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);

$total_percentage=$totalReturning+$totalnewvisist;
$newvisist_percetage=percentage($totalnewvisist, $total_percentage, 2);
$retruning_percetage=percentage($totalReturning, $total_percentage, 2);
//New Visists vs Returning Customers section end here


//total_user/Unique callers
$getDashbord_data="select count(*) as total, count(distinct(msisdn)) as total_unique,cpgname from Inhouse_IVR.tbl_missedcall_smslist nolock 
 where date(added_on) between '".$StartDate."' and '".$EndDate."' and cpgid='".$cpgid."'";
$query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user,$cpgmanager) = mysql_fetch_array($query_dash_info); 

//New Visits
$getDailyVisits_data="select msisdn from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."' and date(added_on)=date(now())";
$query_daily_info = mysql_query($getDailyVisits_data,$con);
$total_dailyvisit = mysql_num_rows($query_daily_info); 

//%new visits out of total visit
$newvisist_outoftotalvisit=percentage($total_dailyvisit, $total_user, 2);

//Avg Missed calls/customer
$getAvgMissedPerUser="select count(*) as total,cpgname,msisdn
from Inhouse_IVR.tbl_missedcall_smslist nolock  where date(added_on) between '".$StartDate."' and '".$EndDate."' and cpgid='".$cpgid."' group by msisdn";
$query_AvgMissedPerUser_info = mysql_query($getAvgMissedPerUser,$con);
$missed_call_per_user_num = mysql_num_rows($query_AvgMissedPerUser_info); 

$total_missed_call_peruser=0;
while($data_tmissed= mysql_fetch_array($query_AvgMissedPerUser_info))
{
$total_missed_call_peruser=$total_missed_call_peruser+$data_tmissed['total'];
}
$missed_calls_peruser=ceil($total_missed_call_peruser/$missed_call_per_user_num);

//Missed Calls Vs Unique Users
$getDashbordChart_data="select count(*) as total, count(distinct(msisdn)) as total_unique,cpgname,day(added_on) as day
from Inhouse_IVR.tbl_missedcall_smslist nolock  where date(added_on) between '".$StartDate."' and '".$EndDate."' and cpgid='".$cpgid."' group by date(added_on) order by day(added_on) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con);

$chartMissedCallarray=array();
$chartUniqueCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
while($data= mysql_fetch_array($query_dashChart_info))
{
$day=$data['day'];
$total_missed_call=$data['total'];
$total_unique_call=$data['total_unique'];
$avg_calls=ceil($total_missed_call/$total_unique_call);

$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;

$chartMissedCallarray[] = array($day,$total_missed_call);
$chartUniqueCallarray[] = array($day,$total_unique_call);
$chartAvgMissedCallarray[] = array($day,$avg_calls);
$chartAvgMissedCallPerDayarray[] = array($day,$gettotalmissedcalldayscount);
}

//Missed call/day:
$avgmissedperday=ceil($gettotalmissedcallcount/$gettotalmissedcalldayscount);

//Top 5 circles with % of  total contribution
$getDashbordtop5data="select count(msisdn) as total,circle
from Inhouse_IVR.tbl_missedcall_smslist nolock  where date(added_on) between '".$StartDate."' and '".$EndDate."' and cpgid='".$cpgid."' group by circle order by total desc limit 5";
$query_dashChart_top5data = mysql_query($getDashbordtop5data,$con);
$charttop5dataarray=array();
$totalcontribution=0;
while($data_top5cir= mysql_fetch_array($query_dashChart_top5data))
{
$cir=$data_top5cir['circle'];
$total_contri=$data_top5cir['total'];
$charttop5dataarray[$cir]=$total_contri;
$totalcontribution=$totalcontribution+$total_contri;
}

//create json for all array chart data
$allMissedCallChart=json_encode(($chartMissedCallarray), JSON_NUMERIC_CHECK);

$allUniqueCallChart=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);

$iscount1=count($chartMissedCallarray);
if($iscount1>1)
{
$allMissedCallChart2=json_encode(($chartMissedCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartMissedCallarray2[0] = array(1,$total_user);
$chartMissedCallarray2[1] = array(2,$total_user);
$allMissedCallChart2=json_encode(($chartMissedCallarray2), JSON_NUMERIC_CHECK);
}
$iscount2=count($chartUniqueCallarray);
if($iscount2>1)
{
$allUniqueCallChart2=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartUniqueCallarray2[0] = array(1,$total_unique_user);
$chartUniqueCallarray2[1] = array(2,$total_unique_user);
$allUniqueCallChart2=json_encode(($chartUniqueCallarray2), JSON_NUMERIC_CHECK);
}


$iscount3=count($chartAvgMissedCallarray);
if($iscount3>1)
{
$allAvgMissedCallarray=json_encode(($chartAvgMissedCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartAvgMissedCallarray[0] = array(1,$missed_calls_peruser);
$chartAvgMissedCallarray[1] = array(2,$missed_calls_peruser);
$allAvgMissedCallarray=json_encode(($chartAvgMissedCallarray), JSON_NUMERIC_CHECK);
}

$iscount4=count($chartAvgMissedCallPerDayarray);
if($iscount4>1)
{
$chartAvgMissedCallPerDayarrayChart=json_encode(($chartAvgMissedCallPerDayarray), JSON_NUMERIC_CHECK);
}
else
{
$chartAvgMissedCallPerDayarray[0] = array(1,$avgmissedperday);
$chartAvgMissedCallPerDayarray[1] = array(2,$avgmissedperday);
$chartAvgMissedCallPerDayarrayChart=json_encode(($chartAvgMissedCallPerDayarray), JSON_NUMERIC_CHECK);
}


//print_r ($allAvgMissedCallarray);
mysql_close($con);
?>