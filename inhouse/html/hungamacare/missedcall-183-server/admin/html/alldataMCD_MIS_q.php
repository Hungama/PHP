<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$prevDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');

//get date diffreance-
$getDashbord_datediff=mysql_query("SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate",$con);
list($DiffDate) = mysql_fetch_array($getDashbord_datediff); 

if($EndDate==$StartDate)
$DiffDate=1;
else
$DiffDate=$DiffDate+1;


///total dedication and total recharge pushed
$getdedication=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."'
 and type ='B_CALLS_OBD' and service='".$service."' ",$con_218);
list($totaldedication) = mysql_fetch_array($getdedication); 
$getrechargepush=mysql_query("select sum(Value) as total  from $mistable nolock
  where date between '".$StartDate."' and '".$EndDate."' and type='B_RECHARGEPUSHED' and service='".$service."' ",$con_218);
list($totalrechargepushed) = mysql_fetch_array($getrechargepush);

//end of the code







function getOBDBounceRate($sDur,$StartDate,$EndDate,$con)
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

//$bouncRateArray=getOBDBounceRate('5',$StartDate,$EndDate,$con);
//$chartbouncRateArray=json_encode(($bouncRateArray), JSON_NUMERIC_CHECK);




//content consumption split start here
$getDashbord_OBDStats=mysql_query("select sum(Value) as Total,Type from $mistable WHERE date between '".$StartDate."' and '".$EndDate."'  and service='EnterpriseMcDw' 
and type in('MOU_CNT_0-15','MOU_CNT_16-30','MOU_CNT_31-45','MOU_CNT_46-60','MOU_CNT_60-Above','MOU_CNT_0-3','MOU_CNT_4-6','MOU_CNT_7-10','MOU_CNT_11-15','MOU_CNT_16-30','MOU_CNT_31-Above') group by Type",$con_218);
$dur1=0;$dur2=0;$dur3=0;$dur4=0;$dur5=0;$dur6=0;
while($data_OBD= mysql_fetch_array($getDashbord_OBDStats))
{
$cTotal=0;
$cType='';
$cType=$data_OBD['Type'];
$cTotal=$data_OBD['Total'];
	if($cType=='MOU_CNT_0-3')
	$dur1=$cTotal;
	else if($cType=='MOU_CNT_4-6')
	$dur2=$cTotal;
	else if($cType=='MOU_CNT_7-10')
	$dur3=$cTotal;
	else if($cType=='MOU_CNT_11-15')
	$dur4=$cTotal;
	else if($cType=='MOU_CNT_16-30')
	$dur5=$cTotal;
	else if($cType=='MOU_CNT_31-Above')
	$dur6=$cTotal;
}

$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4+$dur5+$dur6;




$getDashbord_OBDStatsB=mysql_query("select sum(Value) as Total,Type from $mistable WHERE date between '".$StartDate."' and '".$EndDate."'  and service='EnterpriseMcDw' 
and type in('B_MOU_CNT_0-15','B_MOU_CNT_16-30','B_MOU_CNT_31-45','B_MOU_CNT_46-60','B_MOU_CNT_60-Above','B_MOU_CNT_0-3','B_MOU_CNT_4-6','B_MOU_CNT_7-10','B_MOU_CNT_11-15','B_MOU_CNT_16-30','B_MOU_CNT_31-Above') group by Type",$con_218);
$durB_1=0;$durB_2=0;$durB_3=0;$durB_4=0;$durB_5=0;$durB_6=0;
while($data_OBDB= mysql_fetch_array($getDashbord_OBDStatsB))
{
$cTotal=0;
$cType='';
$cType=$data_OBDB['Type'];
$cTotal=$data_OBDB['Total'];
	if($cType=='B_MOU_CNT_0-3')
	$durB_1=$cTotal;
	else if($cType=='B_MOU_CNT_4-6')
	$durB_2=$cTotal;
	else if($cType=='B_MOU_CNT_7-10')
	$durB_3=$cTotal;
	else if($cType=='B_MOU_CNT_11-15')
	$durB_4=$cTotal;
	else if($cType=='B_MOU_CNT_16-30')
	$durB_5=$cTotal;
	else if($cType=='B_MOU_CNT_31-Above')
	$durB_6=$cTotal;
}

$total_OBD_DURATION_B=$durB_1+$durB_2+$durB_3+$durB_4+$durB_5+$durB_6;






//content consumption split end here


//total targeted OBD start here
$getDashbord_TargettdOBD=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type in ('CALLS_OBD','B_CALLS_OBD') and service='".$service."' ",$con_218);
list($totalOBD_targettd) = mysql_fetch_array($getDashbord_TargettdOBD); 
//total targeted OBD end here



//total targeted Promotional OBD start here
$getDashbord_TargettdPromoOBD=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_OBD_PROMO' and service='".$service."' ",$con_218);
list($totalPromoOBD_targettd) = mysql_fetch_array($getDashbord_TargettdPromoOBD); 
//total targeted Promotional OBD end here

//total targeted Promotional OBD Pulse start here
$getDashbord_TargettdPromoOBDPulse=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='PULSE_TF_PROMO' and service='".$service."' ",$con_218);
list($totalPromoOBDPulse_targettd) = mysql_fetch_array($getDashbord_TargettdPromoOBDPulse); 
//total targeted Promotional OBD Pulse end here


//max duration/avg duration start here

$getDashbord_MaxDuration=mysql_query("select max(ceil(Value/60)) as maxDuration from $mistable nolock  
where date between '".$StartDate."' and '".$EndDate."' and type in ('SEC_MAX','B_SEC_MAX') and service='".$service."' ",$con_218);
list($maxDuration) = mysql_fetch_array($getDashbord_MaxDuration);

//PARTY A 

$getDashbord_MaxDurationA=mysql_query("select ceil(Value/60) as maxDuration from $mistable nolock  
where date between '".$StartDate."' and '".$EndDate."' and type ='SEC_MAX' and service='".$service."' ",$con_218);
list($maxDurationA) = mysql_fetch_array($getDashbord_MaxDurationA); 

$getDashbord_MaxDurationB=mysql_query("select ceil(Value/60) as maxDuration from $mistable nolock  
where date between '".$StartDate."' and '".$EndDate."' and type ='B_SEC_MAX' and service='".$service."' ",$con_218);
list($maxDurationB) = mysql_fetch_array($getDashbord_MaxDurationB); 

//max duration/avg duration end here

//Total Minutes Consumed start here
$getDashbord_OBD_content=mysql_query("select sum(Value) as totalMinConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type in('MOU_TF','B_MOU_TF') and service='".$service."'",$con_218);
list($totalOBD_attended_Content) = mysql_fetch_array($getDashbord_OBD_content); 

//PARTY A

/* $getDashbord_OBD_contentA=mysql_query("select sum(Value) as totalMinConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type ='MOU_TF' and service='".$service."'",$con_218);
list($totalOBD_attended_ContentA) = mysql_fetch_array($getDashbord_OBD_contentA); */ 


$getminute_consumedA=mysql_query("select sum(Value) as totalMinConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type ='MOU_TF' and service='".$service."'",$con_218);
list($totalgetminute_consumedA) = mysql_fetch_array($getminute_consumedA); 
$getminute_consumedB=mysql_query("select sum(Value) as totalMinConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type ='B_MOU_TF' and service='".$service."'",$con_218);
list($totalgetminute_consumedB) = mysql_fetch_array($getminute_consumedB);
//Total Minutes Consumed end here
/*
$getDashbord_OBD=mysql_query("select count(ANI) from $tblObdDetails nolock where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='MCW_PROMOTION' and status=2 and ANI!='' ",$con);
list($totalOBD_attended_Promotional) = mysql_fetch_array($getDashbord_OBD); 

if($totalOBD_attended_Content=='')
$totalOBD_attended_Content=0;

if($totalOBD_attended_Promotional=='')
$totalOBD_attended_Promotional=0;
*/
/**************New Visists vs Returning Customers section start here********************/
/*
$getDashbord_totalnewvisist=mysql_query("select distinct(ANI)
from $tblMissedCall nolock where date(date_time)=date(now()) and service='MCW_LIVEAPP' and ANI!=''",$con);
$totalnewvisist=mysql_num_rows($getDashbord_totalnewvisist);

$getDashbord_totalReturning=mysql_query("select  ANI,count(*) as total from $tblMissedCall nolock where 
date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='MCW_LIVEAPP'  group by ANI HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);

$total_percentage=$totalReturning+$totalnewvisist;
$newvisist_percetage=percentage($totalnewvisist, $total_percentage, 2);
$retruning_percetage=percentage($totalReturning, $total_percentage, 2);
*/
/************New Visists vs Returning Customers section end here************************************/



/*****************Total Missed Calls/Total Unique Visitors START here************************/

$get_TotalMissedCall="select sum(Value) as total from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'";
 $query_TotalMissedCall = mysql_query($get_TotalMissedCall,$con_218);
list($total_user) = mysql_fetch_array($query_TotalMissedCall); 


$avgDurationA=ceil($totalgetminute_consumedA/$total_user);
$avgDurationB=ceil($totalgetminute_consumedB/$total_user);

$avgDuration=ceil($totalOBD_attended_Content/$total_user);

$get_TotalUniqueCall="select sum(Value) as total_unique from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='UU_TF' and service='".$service."'";
 $query_TotalUniqueCall = mysql_query($get_TotalUniqueCall,$con_218);
list($total_unique_user) = mysql_fetch_array($query_TotalUniqueCall); 


/*****************Total Missed Calls/Total Unique Visitors END here************************/

/*
//New Visits
$getDailyVisits_data="select ANI from $tblMissedCall nolock  where date(date_time)=date(now()) and ANI!='' and service='MCW_LIVEAPP' ";
$query_daily_info = mysql_query($getDailyVisits_data,$con);
$total_dailyvisit = mysql_num_rows($query_daily_info); 

//%new visits out of total visit
$newvisist_outoftotalvisit=percentage($total_dailyvisit, $total_user, 2);
*/
/***************new logic for %of new visits starte here ************************/
/*********************% Of New Visitor****************************************/
/*
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
*/
/************************end here*********************************************************/


//% of New Visitor VS  Returning Visitor
/*
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

*/
/*******************end here ****************************************************/
$allnewvsuniquevisittoday=mysql_query("select sum(Value) from  $mistable nolock where date='".$prevDate."' and type='UU_New' and service='".$service."'",$con_218);
list($totalNewUniqueVisitToday) = mysql_fetch_array($allnewvsuniquevisittoday); 


//Avg Missed calls/customer
$missed_calls_peruser=round($total_user/$total_unique_user);
//Missed Calls Vs Unique Users


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



/*********************India Map data Start here***********************/

/*
$getDashbordMapdata="select sum(Value) as total,circle from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."' group by circle order by circle";
$query_getDashbordMapdata = mysql_query($getDashbordMapdata,$con_218);
$Mapdataarray=array();
$totalcontribution=0;
while($data_cir= mysql_fetch_array($query_getDashbordMapdata))
{
$cir=$data_cir['circle'];
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
*/			   
$getDashbord_totalhits=mysql_query("select sum(value) as totalcount
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'",$con_218);
$totalhitsdata=mysql_fetch_array($getDashbord_totalhits);
$total_percentage=$totalhitsdata['totalcount'];

$getDashbordMapdata="select sum(value) as total,circle
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and service='".$service."' group by circle order by circle";
$query_getDashbordMapdata = mysql_query($getDashbordMapdata,$con_218);
$Mapdataarray=array();
$totalcontribution=0;
$alloperatorCount=array();
while($data_cir= mysql_fetch_array($query_getDashbordMapdata))
{
//$cir=$circle_info[$data_cir['circle']];
//$total_contri=$data_cir['total'];
if($data_cir['circle']!='UND')
{
//$Mapdataarray[$cir]=$total_contri;
//$totalcontribution=$totalcontribution+$total_contri;
$cpname=$data_cir['circle'];
$totalcount_cp=$data_cir['total'];
$get_percetage=percentage($totalcount_cp, $total_percentage, 2);
//echo $totalcount_cp."#".$total_percentage."#".$cpname."#".$get_percetage."<br>";
$alloperatorCount[$cpname]=$get_percetage;
}
}
//print_r($alloperatorCount);
//foreach ($Mapdataarray as $circle=>$value) {     
  //        	$MAP_SET_NEWChart .= "["."'".$circle."',".($value>0 ? round($value,0):0)."],\r\n";
    //           } 
			   
/**********************India Map data end  here ***************/			   
			   
//get all ad count for the given time range start here

$getDashbord_OBD_Ad="select value as totalcount,day(Date) as day,Month(Date) as month
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='ADS_PLAYBACK_COUNT' and service='".$service."' group by date order by day(date) ASC";
$query_getDashbord_OBD_Ad = mysql_query($getDashbord_OBD_Ad,$con_218);
$allAdsChart=array();
$totalAdCount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
while($data= mysql_fetch_array($query_getDashbord_OBD_Ad))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_adcount=$data['totalcount'];
$totalAdCount=$totalAdCount+$total_adcount;
$allAdsChart[] = array($dataof,$total_adcount);
}
$allAdsChart2=json_encode(($allAdsChart), JSON_NUMERIC_CHECK);
//get all ad count for the given time range end here			   
//Total Song Downloade 
$getDashbord_totalSongsDownload=mysql_query("select sum(value) as totalcount
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CRBT_REQS' and service='".$service."'",$con_218);
$totalSongDownloaddata=mysql_fetch_array($getDashbord_totalSongsDownload);
$totalSong_Downloaded=$totalSongDownloaddata['totalcount'];

//Total User age verified
$getDashbord_totalUserVerified=mysql_query("select sum(value) as totalcount
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='TOTAL_AGE_VERIFIED' and service='".$service."'",$con_218);
$totalAgeVerifieddata=mysql_fetch_array($getDashbord_totalUserVerified);
$totalAge_Verified=$totalAgeVerifieddata['totalcount'];

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