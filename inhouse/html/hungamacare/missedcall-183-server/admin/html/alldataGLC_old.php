<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

function getOBDBounceRate($sDur,$StartDate,$EndDate,$con)
{
$chartOBDBounceRatearray=array();
$cond="duration<='".$sDur."' ";
$getDashbord_OBDBounceRate=mysql_query("select count(1) as total,date(date_time) as OBDDate from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' and status=2 and $cond group by date(date_time) desc ",$con);
$i=1;
$total_count=0;
while($data= mysql_fetch_array($getDashbord_OBDBounceRate))
{
$count=$data['total'];
$obd_date=$data['OBDDate'];
$total_count=$total_count+$count;
$chartOBDBounceRatearray[] = array($i,$count);
$i++;
}

$bouncRate_percetage=percentage($i, $total_count, 2);
$GLOBALS['btratePercentage']=$bouncRate_percetage;
//$_SESSION['btratePercentage']=$bouncRate_percetage;

return $chartOBDBounceRatearray;
}

$bouncRateArray=getOBDBounceRate('5',$StartDate,$EndDate,$con);
/*
$bRateArray=explode("#",$bouncRate);
$bouncRateArray=$bRateArray[0];
$btratePercentage=$bRateArray[1];
*/
$chartbouncRateArray=json_encode(($bouncRateArray), JSON_NUMERIC_CHECK);


//exit;
function getOBDStats($sDur,$eDur,$StartDate,$EndDate,$con)
{
if($sDur!='60')
$cond="duration>='".$sDur."' and duration<='".$eDur."' ";
else
$cond="duration>='".$sDur."' ";

$getDashbord_OBDStats=mysql_query("select ANI from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' and status=2 and $cond ",$con);
$total=mysql_num_rows($getDashbord_OBDStats);
return $total;
}

$dur1=getOBDStats('0','10',$StartDate,$EndDate,$con);
$dur2=getOBDStats('11','30',$StartDate,$EndDate,$con);
$dur3=getOBDStats('31','60',$StartDate,$EndDate,$con);
$dur4=getOBDStats('60','',$StartDate,$EndDate,$con);
$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4;
$getDashbord_OBD=mysql_query("select ANI from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL'",$con);
$totalOBD_attended=mysql_num_rows($getDashbord_OBD);

/**************New Visists vs Returning Customers section start here********************/

$getDashbord_totalnewvisist=mysql_query("select distinct(ANI)
from hul_hungama.tbl_hul_pushobd_sub nolock where date(date_time)=date(now())",$con);
$totalnewvisist=mysql_num_rows($getDashbord_totalnewvisist);

$getDashbord_totalReturning=mysql_query("select  ANI,count(*) as total from hul_hungama.tbl_hul_pushobd_sub nolock where 
date(date_time) between '".$StartDate."' and '".$EndDate."'  group by ANI HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);

$total_percentage=$totalReturning+$totalnewvisist;
$newvisist_percetage=percentage($totalnewvisist, $total_percentage, 2);
$retruning_percetage=percentage($totalReturning, $total_percentage, 2);
/************New Visists vs Returning Customers section end here************************************/


/*****************total_user/Unique callers************************/
$getDashbord_data="select count(*) as total, count(distinct(ANI)) as total_unique from hul_hungama.tbl_hul_pushobd_sub nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' ";
$query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user) = mysql_fetch_array($query_dash_info); 

//New Visits
$getDailyVisits_data="select ANI from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time)=date(now())";
$query_daily_info = mysql_query($getDailyVisits_data,$con);
$total_dailyvisit = mysql_num_rows($query_daily_info); 

//%new visits out of total visit
$newvisist_outoftotalvisit=percentage($total_dailyvisit, $total_user, 2);

//Avg Missed calls/customer
$getAvgMissedPerUser="select count(*) as total,ANI
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' group by ANI";
$query_AvgMissedPerUser_info = mysql_query($getAvgMissedPerUser,$con);
$missed_call_per_user_num = mysql_num_rows($query_AvgMissedPerUser_info); 

$total_missed_call_peruser=0;
while($data_tmissed= mysql_fetch_array($query_AvgMissedPerUser_info))
{
$total_missed_call_peruser=$total_missed_call_peruser+$data_tmissed['total'];
}
$missed_calls_peruser=ceil($total_missed_call_peruser/$missed_call_per_user_num);

//Missed Calls Vs Unique Users
$getDashbordChart_data="select count(*) as total, count(distinct(ANI)) as total_unique,day(date_time) as day,Month(date_time) as month
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' group by date(date_time) order by day(date_time) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con);

$chartMissedCallarray=array();
$chartUniqueCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
while($data= mysql_fetch_array($query_dashChart_info))
{
$day=$data['day'];
$month=$montharray[$data['month']];
//$dataof=$month.$day;
$dataof=$day;
$total_missed_call=$data['total'];
$total_unique_call=$data['total_unique'];
$avg_calls=ceil($total_missed_call/$total_unique_call);

$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;

$chartMissedCallarray[] = array($dataof,$total_missed_call);
$chartUniqueCallarray[] = array($dataof,$total_unique_call);
$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
$chartAvgMissedCallPerDayarray[] = array($dataof,$gettotalmissedcalldayscount);
}


//Missed call/day:
$avgmissedperday=ceil($gettotalmissedcallcount/$gettotalmissedcalldayscount);

/***********************End here*******************************************/
/*
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
*/
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
mysql_close($con);
?>