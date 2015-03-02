<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');

//get date diffreance-
$getDashbord_datediff=mysql_query("SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate",$con);
list($DiffDate) = mysql_fetch_array($getDashbord_datediff); 

if($EndDate==$StartDate)
$DiffDate=1;
else
$DiffDate=$DiffDate+1;

function getOBDBounceRate($sDur,$StartDate,$EndDate,$con,$tblObdDetails)
{
$chartOBDBounceRatearray=array();
$cond="duration<='".$sDur."' ";
$getDashbord_OBDBounceRate=mysql_query("select count(*) as total,date(date_time) as OBDDate,(select count(*) from $tblObdDetails 
where date(date_time)=OBDDate and service='MCW_LIVEAPP' and status=2 and duration<=5 and ANI!='' group by date(date_time))as bounceANICount 
from $tblObdDetails 
where date(date_time) between '".$StartDate."' and '".$EndDate."'  
and service='MCW_LIVEAPP' and status=2 and ANI!='' group by date(date_time)");

$i=1;
$total_count=0;
$total_bouncecount=0;
while($data= mysql_fetch_array($getDashbord_OBDBounceRate))
{
$count=$data['total'];
$obd_date=$data['OBDDate'];
$bounceANICount=$data['bounceANICount'];

$total_count=$total_count+$count;
$total_bouncecount=$total_bouncecount+$bounceANICount;
$chartOBDBounceRatearray[] = array($i,$count);
//$chartOBDBounceRatearray[] = array($i,$bounceANICount);
$i++;
}
//$brate=($total_bouncecount/$total_count)*100;

$bouncRate_percetage=percentage($total_bouncecount, $total_count, 2);
$GLOBALS['btratePercentage']=$bouncRate_percetage;

return $chartOBDBounceRatearray;
}

$bouncRateArray=getOBDBounceRate('5',$StartDate,$EndDate,$con,$tblObdDetails);
//print_r($bouncRateArray);
$chartbouncRateArray=json_encode(($bouncRateArray), JSON_NUMERIC_CHECK);

//exit;
function getOBDStats($sDur,$eDur,$StartDate,$EndDate,$con,$tblObdDetails)
{
if($sDur!='60')
$cond="duration>='".$sDur."' and duration<='".$eDur."' ";
else
$cond="duration>='".$sDur."' ";

$getDashbord_OBDStats=mysql_query("select ANI from $tblObdDetails nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_LIVEAPP' and ANI!='' and status=2 and $cond ",$con);
$total=mysql_num_rows($getDashbord_OBDStats);
return $total;
}

$dur1=getOBDStats('0','10',$StartDate,$EndDate,$con,$tblObdDetails);
$dur2=getOBDStats('11','30',$StartDate,$EndDate,$con,$tblObdDetails);
$dur3=getOBDStats('31','60',$StartDate,$EndDate,$con,$tblObdDetails);
$dur4=getOBDStats('60','',$StartDate,$EndDate,$con,$tblObdDetails);
$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4;

//total targeted OBD out of 900

$getDashbord_TargettdOBD=mysql_query("select  distinct ANI from $tblObdDetails nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_LIVEAPP' and status=2 and ANI!=''",$con);
$totalOBD_targettd=mysql_num_rows($getDashbord_TargettdOBD);
///date(date_time) between '".$StartDate."' and '".$EndDate."' and 
//for section 7,8,9
//Max min spent by unique user
$getDashbord_MaxMin=mysql_query("select ceil(max(duration)/60) as maxDuration from $tblObdDetails nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and status=2 and service='MCW_LIVEAPP' and ANI!=''",$con);
list($maxDuration1) = mysql_fetch_array($getDashbord_MaxMin); 
$maxDuration=$maxDuration1;

$getDashbord_OBD=mysql_query("select count(ANI) from $tblObdDetails nolock where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_PROMOTION' and status=2 and ANI!='' ",$con);
list($totalOBD_attended_Promotional) = mysql_fetch_array($getDashbord_OBD); 


$getDashbord_OBD_content=mysql_query("select ceil(sum(duration)/60) as toalsec from $tblObdDetails nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_LIVEAPP' and status=2 and ANI!=''",$con);
list($totalOBD_attended_Content) = mysql_fetch_array($getDashbord_OBD_content); 

if($totalOBD_attended_Content=='')
$totalOBD_attended_Content=0;
////date(date_time) between '".$StartDate."' and '".$EndDate."' and ( cond removed to show all count on heder section)

/**************New Visists vs Returning Customers section start here********************/

$getDashbord_totalnewvisist=mysql_query("select distinct(ANI)
from $tblMissedCall nolock where date(date_time)=date(now()) and service='MCW_LIVEAPP' and ANI!=''",$con);
$totalnewvisist=mysql_num_rows($getDashbord_totalnewvisist);

$getDashbord_totalReturning=mysql_query("select  ANI,count(*) as total from $tblMissedCall nolock where 
date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP'  group by ANI HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);

$total_percentage=$totalReturning+$totalnewvisist;
$newvisist_percetage=percentage($totalnewvisist, $total_percentage, 2);
$retruning_percetage=percentage($totalReturning, $total_percentage, 2);
/************New Visists vs Returning Customers section end here************************************/


/*****************total_user/Unique callers MCD************************/

$getDashbord_data="select count(*) as total, count(distinct(ANI)) as total_unique from $tblMissedCall nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP'";
 $query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user) = mysql_fetch_array($query_dash_info); 

//New Visits
$getDailyVisits_data="select ANI from $tblMissedCall nolock  where date(date_time)=date(now()) and ANI!='' and service='MCW_LIVEAPP' ";
$query_daily_info = mysql_query($getDailyVisits_data,$con);
$total_dailyvisit = mysql_num_rows($query_daily_info); 

//%new visits out of total visit
$newvisist_outoftotalvisit=percentage($total_dailyvisit, $total_user, 2);

/***************new logic for %of new visits starte here ************************/

$allnewvsuniquevisit=mysql_query("select distinct(ANI) as dani,(select count(1) from $tblMissedCall where ANI=dani) as total
from $tblMissedCall nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP' ",$con);
$totalUniqueVisit=0;
$totalNewUniqueVisit=0;
$p=0;
while($dataNewVisit= mysql_fetch_array($allnewvsuniquevisit))
{
	$totalUniqueVisit=$totalUniqueVisit+1;
		if($dataNewVisit['total']==1)
		{
		$totalNewUniqueVisit=$totalNewUniqueVisit+1;
		$chartOBDNewVisitarray1[] = array($p,$dataNewVisit['total']);
		}
		$p++;
}
$totalnewvisist_percetage_outofuniqueuser=percentage($totalNewUniqueVisit, $totalUniqueVisit, 2);
$chartOBDNewVisitarray2=json_encode(($chartOBDNewVisitarray1), JSON_NUMERIC_CHECK);

/*********************for testing only start here****************************************/

$getalldistinctDate=mysql_query("select distinct(date(date_time)) as disdate from $tblMissedCall nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP'",$con);
$p1=0;
while($dataNewVisitDate= mysql_fetch_array($getalldistinctDate))
{
$allnewvsuniquevisit1=mysql_query("select distinct(ANI) as dani,date(date_time) as dtime,(select count(1) from $tblMissedCall where ANI=dani  and date(date_time)<=dtime) as total
from $tblMissedCall nolock  where date(date_time)='".$dataNewVisitDate['disdate']."' and ANI!='' and service='MCW_LIVEAPP' ",$con);
$totalUniqueVisit1=0;
$totalNewUniqueVisit1=0;

while($dataNewVisit1= mysql_fetch_array($allnewvsuniquevisit1))
{
	$totalUniqueVisit1=$totalUniqueVisit1+1;
		if($dataNewVisit1['total']==1)
		{
		$totalNewUniqueVisit1=$totalNewUniqueVisit1+1;
		
		}
		
}
$p1++;
$totalnewvisist_percetage_outofuniqueuser1=percentage($totalNewUniqueVisit1, $totalUniqueVisit1, 2);
$chartOBDNewVisitarray11[] = array($p1,$totalnewvisist_percetage_outofuniqueuser1);
}
$chartOBDNewVisitarray21=json_encode(($chartOBDNewVisitarray11), JSON_NUMERIC_CHECK);

/************************end here*********************************************************/


//for today only

$getDashbord_totalReturning=mysql_query("select  ANI,count(*) as total from $tblMissedCall nolock where 
date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP' group by ANI HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);



$allnewvsuniquevisittoday=mysql_query("select distinct(ANI) as dani,(select count(1) from $tblMissedCall where ANI=dani) as total
from $tblMissedCall nolock  where date(date_time)=date(now())  and ANI!='' and service='MCW_LIVEAPP'",$con);

$totalNewUniqueVisitToday=0;
while($dataNewVisitToday= mysql_fetch_array($allnewvsuniquevisittoday))
{
	if($dataNewVisitToday['total']==1)
		{
		$totalNewUniqueVisitToday=$totalNewUniqueVisitToday+1;
		}
}


$total_percentage1=$totalReturning+$totalNewUniqueVisitToday;
$newvisist_percetage=percentage($totalNewUniqueVisitToday, $total_percentage1, 2);
$retruning_percetage=percentage($totalReturning, $total_percentage1, 2);


/*******************end here ****************************************************/





//Avg Missed calls/customer
$getAvgMissedPerUser="select count(*) as total,ANI
from $tblMissedCall nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP' group by ANI";
$query_AvgMissedPerUser_info = mysql_query($getAvgMissedPerUser,$con);
$missed_call_per_user_num = mysql_num_rows($query_AvgMissedPerUser_info); 

$total_missed_call_peruser=0;
while($data_tmissed= mysql_fetch_array($query_AvgMissedPerUser_info))
{
$total_missed_call_peruser=$total_missed_call_peruser+$data_tmissed['total'];
}
$missed_calls_peruser=ceil($total_missed_call_peruser/$missed_call_per_user_num);

//Missed Calls Vs Unique Users MCD
$getDashbordChart_data="select count(*) as total, count(distinct(ANI)) as total_unique,day(date_time) as day,Month(date_time) as month
from $tblMissedCall nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP' group by date(date_time) order by day(date_time) ASC";
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
//$avgmissedperday=ceil($gettotalmissedcallcount/$gettotalmissedcalldayscount);
$avgmissedperday=round($total_user/$DiffDate);

/***********************End here*******************************************/



//India Map data
$getDashbordMapdata="select count(ANI) as total,circle
from $tblObdDetails nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_LIVEAPP' and status=2 and ANI!='' group by circle order by circle";
$query_getDashbordMapdata = mysql_query($getDashbordMapdata,$con);
$Mapdataarray=array();
$totalcontribution=0;
while($data_cir= mysql_fetch_array($query_getDashbordMapdata))
{
$cir=$circle_info[$data_cir['circle']];
$total_contri=$data_cir['total'];
if($data_cir['circle']!='UND')
{
$Mapdataarray[$cir]=$total_contri;
$totalcontribution=$totalcontribution+$total_contri;
}
}
foreach ($Mapdataarray as $circle=>$value) {     
          	$MAP_SET_NEWChart .= "["."'".$circle."',".($value>0 ? round($value,0):0)."],\r\n";
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
//mysql_close($con);
?>