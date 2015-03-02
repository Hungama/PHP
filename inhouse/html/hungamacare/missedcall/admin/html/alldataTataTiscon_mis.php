<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$prevDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//$StartDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
//$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//get date diffreance-
$getDashbord_datediff=mysql_query("SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate",$con);
list($DiffDate) = mysql_fetch_array($getDashbord_datediff); 

if($EndDate==$StartDate)
$DiffDate=1;
else
$DiffDate=$DiffDate+1;

//content consumption split start here
$getDashbord_OBDStats=mysql_query("select sum(Value) as Total,Type from $mistable WHERE date between '".$StartDate."' and '".$EndDate."'  and service='EnterpriseTiscon' 
and type in('MOU_CNT_0-15','MOU_CNT_16-30','MOU_CNT_31-45','MOU_CNT_46-60','MOU_CNT_60-Above') group by Type",$con_218);
$dur1=0;$dur2=0;$dur3=0;$dur4=0;$dur5=0;
while($data_OBD= mysql_fetch_array($getDashbord_OBDStats))
{
$cTotal=0;
$cType='';
$cType=$data_OBD['Type'];
$cTotal=$data_OBD['Total'];
	if($cType=='MOU_CNT_0-15')
	$dur1=$cTotal;
	else if($cType=='MOU_CNT_16-30')
	$dur2=$cTotal;
	else if($cType=='MOU_CNT_31-45')
	$dur3=$cTotal;
	else if($cType=='MOU_CNT_46-60')
	$dur4=$cTotal;
	else if($cType=='MOU_CNT_60-Above')
	$dur5=$cTotal;
}

$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4+$dur5;
//content consumption split end here

//total targeted OBD start here
$getDashbord_TargettdOBD=mysql_query("select  sum(Value) from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_OBD' and service='".$service."' ",$con_218);
list($totalOBD_targettd) = mysql_fetch_array($getDashbord_TargettdOBD); 
//total targeted OBD end here

//max duration/avg duration start here

$getDashbord_MaxDuration=mysql_query("select ceil(Value/60) as maxDuration from $mistable nolock  
where date between '".$StartDate."' and '".$EndDate."' and type='SEC_MAX' and service='".$service."' ",$con_218);
list($maxDuration) = mysql_fetch_array($getDashbord_MaxDuration); 

//max duration/avg duration end here


//Total Minutes Consumed start here
$getDashbord_OBD_content=mysql_query("select sum(Value) as totalMinConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='MOU_TF' and service='".$service."'",$con_218);
list($totalOBD_attended_Content) = mysql_fetch_array($getDashbord_OBD_content); 
//Total Minutes Consumed end here

//Total Pulse Consumed start here
$getDashbord_OBDPulse_content=mysql_query("select sum(Value) as totalPulseConsumed from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='PULSE_T' and service='".$service."'",$con_218);
list($totalOBD_attendedPulse_Content) = mysql_fetch_array($getDashbord_OBDPulse_content); 
//Total Pulse Consumed end here


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

/*****************Total Missed Calls/Total Unique Visitors START here************************/

$get_TotalMissedCall="select sum(Value) as total from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'";
 $query_TotalMissedCall = mysql_query($get_TotalMissedCall,$con_218);
list($total_user) = mysql_fetch_array($query_TotalMissedCall); 

$avgDuration=ceil($totalOBD_attended_Content/$total_user);

$get_TotalUniqueCall="select sum(Value) as total_unique from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='UU_TF' and service='".$service."'";
 $query_TotalUniqueCall = mysql_query($get_TotalUniqueCall,$con_218);
list($total_unique_user) = mysql_fetch_array($query_TotalUniqueCall); 


/*****************Total Missed Calls/Total Unique Visitors END here************************/

$allnewvsuniquevisittoday=mysql_query("select sum(Value) from  $mistable nolock where date='".$prevDate."' and type='UU_New' and service='".$service."'",$con_218);
list($totalNewUniqueVisitToday) = mysql_fetch_array($allnewvsuniquevisittoday); 
/**********************retruning_percetage vs newvisist_percetage end here ***********/


//Avg Missed calls/customer
$missed_calls_peruser=round($total_user/$total_unique_user);
//Missed Calls Vs Unique Users


$getDashbordChart_data="select sum(value) as total, Type,day(date) as day,Month(date) as month
from $mistable nolock  
where Date between '".$StartDate."' and '".$EndDate."'  and service='EnterpriseTiscon' and type in('CALLS_TF','UU_TF') and service='".$service."' group by date,type order by day(date) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con_218);

$chartMissedCallarray=array();
$chartUniqueCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
while($data= mysql_fetch_array($query_dashChart_info))
{
$type=$data['Type'];
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
if($type=='CALLS_TF')
{
$total_missed_call=$data['total'];
//echo 'CALLS_TF#'.$total_missed_call."#".$dataof."<br>";
$chartMissedCallarray[] = array($dataof,$total_missed_call);
}
if($type=='UU_TF')
{
$total_unique_call=$data['total'];
$chartUniqueCallarray[] = array($dataof,$total_unique_call);
//echo 'UU_TF#'.$total_unique_call."#".$dataof."<br>";
}

//$avg_calls=round($total_missed_call/$total_unique_call);

//$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
//$gettotalmissedcalldayscount++;

//$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
//$chartAvgMissedCallPerDayarray[] = array($dataof,$gettotalmissedcalldayscount);
}
//Missed call/day based selected date range
//$avgmissedperday=round($gettotalmissedcallcount/$DiffDate);
//New from dailymis 
$avgmissedperday=round($total_user/$DiffDate);

//Average Missed Call per day grap data-
$getAvg_missedCallPerday="select sum(Value) as total, day(date) as day,Month(date) as month
from $mistable nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."' group by date order by Month(date),day ASC";
$query_missedCallPerday = mysql_query($getAvg_missedCallPerday,$con_218);
while($data= mysql_fetch_array($query_missedCallPerday))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$gettotalmissedcalldayscount=$data['total'];
$dataof=$day;
$chartAvgMissedCallPerDayarray[] = array($dataof,$gettotalmissedcalldayscount);
}
/***********************End here*******************************************/

/**********************India Map data start here ***************/

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
$cir=$circle_info[$data_cir['circle']];
$total_contri=$data_cir['total'];
if($data_cir['circle']!='UND')
{
$Mapdataarray[$cir]=$total_contri;
$totalcontribution=$totalcontribution+$total_contri;

$cpname=$data_cir['circle'];
$totalcount_cp=$data_cir['total'];
$get_percetage=percentage($totalcount_cp, $total_percentage, 2);
$alloperatorCount[$cpname]=$get_percetage;
}
}
//foreach ($Mapdataarray as $circle=>$value) {     
  //        	$MAP_SET_NEWChart .= "["."'".$circle."',".($value>0 ? round($value,0):0)."],\r\n";
    //           } 
			   
/**********************India Map data end  here ***************/
//create json for all array chart data

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