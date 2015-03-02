<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
function get_percentage($total, $number)
{
  if ( $total > 0 ) {
   return round($number / ($total / 100),2);
  } else {
    return 0;
  }
}

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
//$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

//get date diffreance-
$getDashbord_datediff=mysql_query("SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate",$con);
list($DiffDate) = mysql_fetch_array($getDashbord_datediff); 

if($EndDate==$StartDate)
$DiffDate=1;
else
$DiffDate=$DiffDate+1;
//echo "Datediff is".$DiffDate;
/*
function getOBDBounceRate($sDur,$StartDate,$EndDate,$con)
{
$chartOBDBounceRatearray=array();
$cond="duration<='".$sDur."' ";
$getDashbord_OBDBounceRate=mysql_query("select count(*) as total,date(date_time) as OBDDate,(select count(*) from hul_hungama.tbl_hulobd_success_fail_details where date(date_time)=OBDDate and service='HUL' and status=2 and duration<=5 group by date(date_time))as bounceANICount from hul_hungama.tbl_hulobd_success_fail_details where date(date_time) between '".$StartDate."' and '".$EndDate."'  and service='HUL' and status=2 group by date(date_time)");

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
$i++;
}

$bouncRate_percetage=percentage($total_bouncecount, $total_count, 2);
$GLOBALS['btratePercentage']=$bouncRate_percetage;

return $chartOBDBounceRatearray;
}

$bouncRateArray=getOBDBounceRate('5',$StartDate,$EndDate,$con);
$chartbouncRateArray=json_encode(($bouncRateArray), JSON_NUMERIC_CHECK);
*/

function getOBDStats($sDur,$eDur,$StartDate,$EndDate,$con)
{
if($sDur!='361')
$cond="duration>='".$sDur."' and duration<='".$eDur."' ";
else
$cond="duration>='".$sDur."' ";

$getDashbord_OBDStats=mysql_query("select count(ANI) from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' and status=2 and ANI!='' and $cond ",$con);
list($total) = mysql_fetch_array($getDashbord_OBDStats); 
return $total;
}

$dur1=getOBDStats('0','60',$StartDate,$EndDate,$con);
$dur2=getOBDStats('61','180',$StartDate,$EndDate,$con);
$dur3=getOBDStats('181','360',$StartDate,$EndDate,$con);
$dur4=getOBDStats('361','',$StartDate,$EndDate,$con);
$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4;

//most heard category -

//$getDashbord_mostHeardCategory=mysql_query("select Contentid,Contentid_counter from hul_hungama.tbl_GLC_MOSTHEARD_Content order by Contentid_counter desc",$con);
$getDashbord_mostHeardCategory=mysql_query("select Contentid,ceil(sum(mou)/60) as TotalSec from hul_hungama.tbl_MOSTHEARD_Content where
date(date_time) between '".$StartDate."' and '".$EndDate."' group by Contentid order by TotalSec desc limit 1",$con);
list($Contentid,$Contentid_counter) = mysql_fetch_array($getDashbord_mostHeardCategory); 

if($Contentid=='0104')
{
 $textmsg='(Evergreen)';
 $imgpath_Mostheard="images/4.png";
 $counter=$Contentid_counter;
}
else if($Contentid=='0102')
{
 $textmsg='(NewRelease)';
 $imgpath_Mostheard="images/2.png";
 $counter=$Contentid_counter;
}
else if($Contentid=='0101')
{
 $textmsg='(AllTimeHits)';
 $imgpath_Mostheard="images/1.png";
 $counter=$Contentid_counter;
}
else if($Contentid=='Movies')
{
 $textmsg='(Movies)';
 $imgpath_Mostheard="images/3.png";
 $counter=$Contentid_counter;
}  
else
{
 $textmsg='(None)';
 $imgpath_Mostheard="";
 $counter=0;
}
//////////////////End here/////////////



//total targeted OBD out of 900
$getDashbord_TargettdOBD=mysql_query("select  count(distinct ANI) from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' and ANI!=''",$con);
list($totalOBD_targettd) = mysql_fetch_array($getDashbord_TargettdOBD); 

//for section 7,8,9
//Max min spent by unique user
$getDashbord_MaxMin=mysql_query("select ceil(max(duration)/60) as maxDuration from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service in ('HUL')",$con);
list($maxDuration1) = mysql_fetch_array($getDashbord_MaxMin); 
$maxDuration=$maxDuration1;

//Promotional OBD's Attended
//$getDashbord_OBD=mysql_query("select count(ANI) from hul_hungama.tbl_hulobd_success_fail_details nolock where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL_PROMOTION' and ANI!='' ",$con);
$getDashbord_OBD=mysql_query("select count(ANI) from Hungama_ENT_Cinthol.tbl_cinthol_success_fail_details nolock where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' ",$con);
list($totalOBD_attended_Promotional) = mysql_fetch_array($getDashbord_OBD); 

//Total Minutes Consumed
$getDashbord_OBD_content=mysql_query("select ceil(sum(duration)/60) as toalsec from hul_hungama.tbl_hulobd_success_fail_details nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' and ANI!=''",$con);
list($totalOBD_attended_Content) = mysql_fetch_array($getDashbord_OBD_content); 

if($totalOBD_attended_Content=='')
$totalOBD_attended_Content=0;


/*****************total_user/Unique callers************************/

$getDashbord_data="select count(*) as total, count(distinct(ANI)) as total_unique from hul_hungama.tbl_hul_pushobd_sub nolock 
 where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='HUL'";
 $query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user) = mysql_fetch_array($query_dash_info); 

//Today's New Visitor(s)
$allnewvsuniquevisittoday=mysql_query("select distinct(ANI) as dani,(select count(1) from hul_hungama.tbl_hul_pushobd_sub where ANI=dani) as total
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time)=date(now())  and ANI!='' and service='HUL'",$con);

$totalNewUniqueVisitToday=0;
while($dataNewVisitToday= mysql_fetch_array($allnewvsuniquevisittoday))
{
	if($dataNewVisitToday['total']==1)
		{
		$totalNewUniqueVisitToday=$totalNewUniqueVisitToday+1;
		}
}



//Avg Missed calls/customer
$getAvgMissedPerUser="select count(*) as total,ANI
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='HUL' group by ANI";
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
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' and service='HUL' group by date(date_time) order by day(date_time) ASC";
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
$dataof=$day;
$total_missed_call=$data['total'];
$total_unique_call=$data['total_unique'];
$avg_calls=round($total_missed_call/$total_unique_call);

$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;

$chartMissedCallarray[] = array($dataof,$total_missed_call);
$chartUniqueCallarray[] = array($dataof,$total_unique_call);
$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
}

//Average Missed calls per day
//$avgmissedperday=ceil($gettotalmissedcallcount/$gettotalmissedcalldayscount);

//Average Missed calls per day New based on day selected
$avgmissedperday=round($gettotalmissedcallcount/$DiffDate);

/***********************End here*******************************************/
//India Map data
$getDashbordMapdata="select count(ANI) as total,circle
from hul_hungama.tbl_hul_pushobd_sub nolock  where date(date_time) between '".$StartDate."' and '".$EndDate."' and service='HUL' group by circle order by circle";
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
//mysql_close($con);
?>