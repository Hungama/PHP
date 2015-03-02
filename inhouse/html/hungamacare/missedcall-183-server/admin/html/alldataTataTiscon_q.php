<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
//$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
//content consumption split start here

//get date diffreance-
$getDashbord_datediff=mysql_query("SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate",$con);
list($DiffDate) = mysql_fetch_array($getDashbord_datediff); 

if($EndDate==$StartDate)
$DiffDate=1;
else
$DiffDate=$DiffDate+1;
//echo "Datediff is".$DiffDate;

function getOBDStats($sDur,$eDur,$StartDate,$EndDate,$con)
{
$sDurMins=$sDur*60;
$eDurMins=$eDur*60;
if($sDurMins!='3600')
$cond="duration>='".$sDurMins."' and duration<='".$eDurMins."' ";
else
$cond="duration>='".$sDurMins."' ";

$getDashbord_OBDStats=mysql_query("select ANI from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and status=2 and $cond
union all select ANI from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and status=2 and $cond",$con);
$total=mysql_num_rows($getDashbord_OBDStats);
return $total;
}

$dur1=getOBDStats('0','15',$StartDate,$EndDate,$con);
$dur2=getOBDStats('15','30',$StartDate,$EndDate,$con);
$dur3=getOBDStats('30','45',$StartDate,$EndDate,$con);
$dur4=getOBDStats('45','60',$StartDate,$EndDate,$con);
$dur5=getOBDStats('60','',$StartDate,$EndDate,$con);
$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4+$dur5;
//content consumption split end here

//total targeted OBD start here
$getDashbord_TargettdOBD=mysql_query("select  ANI from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and status!=0
union all select  ANI from Hungama_Tatasky.tbl_tata_pushobd_backup_25dec nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and status!=0",$con);

$totalOBD_targettd=mysql_num_rows($getDashbord_TargettdOBD);
//total targeted OBD end here

//max duration/avg duration start here
$maxDuration=0;
$avgDuration=0;
$getDashbord_MaxAvgDuration=mysql_query("select ceil(max(duration)/60) as maxDuration,ceil(AVG(duration)/60) as AvgDuration from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  
where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and status=2
union all select ceil(max(duration)/60) as maxDuration,ceil(AVG(duration)/60) as AvgDuration from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  
where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and status=2 ",$con);
while($data = mysql_fetch_array($getDashbord_MaxAvgDuration))
{
$maxDuration=$maxDuration +$data['maxDuration'];
$avgDuration=$avgDuration +$data['AvgDuration'];
}	
//max duration/avg duration end here


//Total Minutes Consumed start here
$totalOBD_attended_Content=0;
$getDashbord_OBD_content=mysql_query("select ceil(sum(duration)/60) as toalsec from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
union all select ceil(sum(duration)/60) as toalsec from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''",$con);
while($data = mysql_fetch_array($getDashbord_OBD_content))
{
$totalOBD_attended_Content= $totalOBD_attended_Content + $data['toalsec'];
}	
//Total Minutes Consumed end here

//Total Pulse Consumed start here
$getDashbord_OBDPulse_content=mysql_query("select ceil(sum(duration)/30) as toalpulse from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
union all select ceil(sum(duration)/30) as toalpulse from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''",$con);
list($totalOBD_attendedPulse_Content) = mysql_fetch_array($getDashbord_OBDPulse_content); 
//Total Pulse Consumed end here

//get all ad count for the given time range start here

$getDashbord_OBD_Ad="select sum(counter) as totalcount,day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tiscon_adcompagin nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' group by date(date_time) order by day(date_time) ASC";
$query_getDashbord_OBD_Ad = mysql_query($getDashbord_OBD_Ad,$con);
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
$total_user=0;
$getDashbord_data="select count(*) as total from Hungama_Tatasky.tbl_tata_pushobd nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
 union all select count(*) as total from Hungama_Tatasky.tbl_tata_pushobd_backup_25dec nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' ";
$query_dash_info = mysql_query($getDashbord_data,$con);
while( $data= mysql_fetch_array($query_dash_info))
{
$total_user=$total_user + $data['total'];
}	
//unique user data
$getDashbord_unique_data="select  count(distinct(ANI)) as total_unique from Hungama_Tatasky.tbl_tata_pushobd_unique nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' ";
 $query_dash_unique_info = mysql_query($getDashbord_unique_data,$con);
list($total_unique_user) = mysql_fetch_array($query_dash_unique_info); 

/*****************Total Missed Calls/Total Unique Visitors END here************************/
$allnewvsuniquevisittoday=mysql_query("select distinct(ANI) as dani,(select count(1) from Hungama_Tatasky.tbl_tata_pushobd_unique  where ANI=dani) as total
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time)=date(now())  and ANI!='' ",$con);

$totalNewUniqueVisitToday=0;
while($dataNewVisitToday= mysql_fetch_array($allnewvsuniquevisittoday))
{
	if($dataNewVisitToday['total']==1)
		{
		$totalNewUniqueVisitToday=$totalNewUniqueVisitToday+1;
		}
}
/**********************retruning_percetage vs newvisist_percetage end here ***********/
//Avg Missed calls/customer
$getAvgMissedPerUser="select count(*) as total,ANI
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
union all select count(*) as total,ANI
from Hungama_Tatasky.tbl_tata_pushobd_backup_25dec nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by ANI";
$query_AvgMissedPerUser_info = mysql_query($getAvgMissedPerUser,$con);
$missed_call_per_user_num = mysql_num_rows($query_AvgMissedPerUser_info); 

$total_missed_call_peruser=0;
while($data_tmissed= mysql_fetch_array($query_AvgMissedPerUser_info))
{
$total_missed_call_peruser=$total_missed_call_peruser+$data_tmissed['total'];
}
$missed_calls_peruser=round($total_missed_call_peruser/$missed_call_per_user_num);

//Missed Calls Vs Unique Users
$getDashbordChart_data="select count(*) as total, day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
union all select count(*) as total, day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tata_pushobd_backup_25dec nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by date(date_time) order by day ASC";

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
//$total_unique_call=$data['total_unique'];
$avg_calls=round($total_missed_call/$total_unique_call);

$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;

$chartMissedCallarray[] = array($dataof,$total_missed_call);
//$chartUniqueCallarray[] = array($dataof,$total_unique_call);
$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
$chartAvgMissedCallPerDayarray[] = array($dataof,$gettotalmissedcalldayscount);
}

//Missed call/day:
$avgmissedperday=round($gettotalmissedcallcount/$DiffDate);

//unique chart
$getDashbordChart_udata="select count(distinct(ANI)) as total_unique, day(date_time) as day,Month(date_time) as month
from Hungama_Tatasky.tbl_tata_pushobd_unique nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!=''
group by date(date_time) order by day(date_time) ASC";
$query_dashChart_uinfo = mysql_query($getDashbordChart_udata,$con);
while($data= mysql_fetch_array($query_dashChart_uinfo ))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_unique_call=$data['total_unique'];
$chartUniqueCallarray[] = array($dataof,$total_unique_call);
	
}





/***********************End here*******************************************/




/**********************India Map data start here ***************/
$total_percentage=0;
$getDashbord_totalhits=mysql_query("select count(ANI) as totalcount
from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."'
union all select count(ANI) as totalcount
from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."'",$con);
while($totalhitsdata=mysql_fetch_array($getDashbord_totalhits))
{
$total_percentage=$total_percentage + $totalhitsdata['totalcount'];
}



$getDashbordMapdata="select count(ANI) as total,circle
from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."'
union all select count(ANI) as total,circle
from Hungama_Tatasky.tbl_tataobd_success_fail_details_backup nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."'  group by circle order by circle";
$query_getDashbordMapdata = mysql_query($getDashbordMapdata,$con);
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
foreach ($Mapdataarray as $circle=>$value) {     
          	$MAP_SET_NEWChart .= "["."'".$circle."',".($value>0 ? round($value,0):0)."],\r\n";
               } 
			   
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