<?php
error_reporting(0);
require_once("../../../db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//database used for this app(MCD)
$service='EnterpriseMcDw';
//$dbNameMCD='Hungama_ENT_MCDOWELL_Test';
$dbNameMCD='Hungama_ENT_MCDOWELL';
$tblMissedCall=$dbNameMCD.'.tbl_mcdowell_pushobd_liveapp';
$tblObdDetails=$dbNameMCD.'.tbl_mcdowell_success_fail_details';
$tblAdDetails=$dbNameMCD.'.tbl_mcdowell_adcompagin';
$tblAgeVarificationDetails=$dbNameMCD.'.tbl_AgeVerification';
$tblCrbtreqsDetails=$dbNameMCD.'.tbl_MCW_crbtrng_reqs_LOG';
$tblPromoOBDPused=$dbNameMCD.'.tbl_mcdowell_pushobd_promotion';
$tblPromoOBDDetails=$dbNameMCD.'.tbl_mcdowell_success_fail_promotion_details';

$flag=0;
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		$flag=1;
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $view_date= '2014-07-22';
//$flag=1;
$del="delete from Hungama_Tatasky.tbl_dailymis where Date='".$view_date."' and service='".$service."'";
$delquery = mysql_query($del,$con);

$del1="delete from Hungama_Tatasky.tbl_dailymis_UUuserTemp where service='".$service."'";
$delquery1 = mysql_query($del1,$con);

//get content consumption split fuction
function getOBDStats($sDur,$eDur,$Date,$con,$tblObdDetails)
{
$sDurMins=$sDur*60;
$eDurMins=$eDur*60;
if($sDurMins!='1800')
$cond="duration>='".$sDurMins."' and duration<='".$eDurMins."' ";
else
$cond="duration>='".$sDurMins."' ";

$getDashbord_OBDStats=mysql_query("select count(ANI) from $tblObdDetails nolock  where date(date_time)='".$Date."' and ANI!='' and service='MCW_LIVEAPP' and status=2 and $cond ",$con);
//$total=mysql_num_rows($getDashbord_OBDStats);
list($total)=mysql_fetch_array($getDashbord_OBDStats);
return $total;
}

/////////////////////////// Code start for Missed Call & Unique Visitor//////////////////////


$get_query_CALLS_TF = "select 'CALLS_TF' as type,count(1) as MissedCall,circle,date(date_time) as date
from $tblMissedCall where ANI!='' and service='MCW_LIVEAPP' and date(date_time)='".$view_date."' group by circle";//group by circle
$query_CALLS_TF = mysql_query($get_query_CALLS_TF, $con);
$numofrows = mysql_num_rows($query_CALLS_TF);
$total_CALLS_TF=0;
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query_CALLS_TF)) {
        $date = $summarydata['date'];
        $totalMissedCall = $summarydata['MissedCall'];
		$total_CALLS_TF=$total_CALLS_TF+$totalMissedCall;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$date' ,'$service','$circle','$type','$totalMissedCall','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}
$get_query_UU_TF = "select 'UU_TF' as type,count(distinct(ANI)) as UniqueUser,circle,date(date_time) as date
from $tblMissedCall where ANI!='' and service='MCW_LIVEAPP' and date(date_time)='".$view_date."' group by circle";// group by circle
$query_UU_TF = mysql_query($get_query_UU_TF, $con);
$numofrows1 = mysql_num_rows($query_UU_TF);
$totalUU_TF=0;
if ($numofrows1 >= 1) {
    while ($summarydata = mysql_fetch_array($query_UU_TF)) {
        $date = $summarydata['date'];
        $totalUniqueUser = $summarydata['UniqueUser'];
		$totalUU_TF=$totalUU_TF+$totalUniqueUser;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$date' ,'$service','$circle','$type','$totalUniqueUser','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}
/////////////End here /////////////////
///////////////Total Minute consumed////////////////
$get_totalMinuteConsumed=mysql_query("select ceil(sum(duration)/60) as toalMin,circle from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' group by circle",$con);
while (list($totalMinuteConsumed,$circle) = mysql_fetch_array($get_totalMinuteConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','MOU_TF','$totalMinuteConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
////////////End here///////////////////////////

//////////Maximum Duration Listen////////
$get_MaxDurationlisten=mysql_query("select max(duration) as maxDuration from $tblObdDetails nolock  
where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and status=2 ",$con);
list($maxDurationListen) = mysql_fetch_array($get_MaxDurationlisten); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','SEC_MAX','$maxDurationListen','')";
$queryIns = mysql_query($insert_data, $con);
/////////// End here////////////////

///////No of OBD Pushed/////////
$get_TotalOBDPushed=mysql_query("select  count(ANI) from $tblMissedCall nolock  where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and status!=0",$con);
list($TotalOBDPushed) = mysql_fetch_array($get_TotalOBDPushed); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','CALLS_OBD','$TotalOBDPushed','')";
$queryIns = mysql_query($insert_data, $con);
/////////End here //////////////////

///////No of Promotion OBD Pushed/////////
/*
$get_TotalPromoOBDPushed=mysql_query("select  count(ANI) from $tblPromoOBDPused nolock  where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and status!=0",$con);
list($TotalPromoOBDPushed) = mysql_fetch_array($get_TotalPromoOBDPushed); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','CALLS_OBD_PROMO','$TotalPromoOBDPushed','')";
$queryIns = mysql_query($insert_data, $con);
/////////End here //////////////////

$get_totalPromoPulseConsumed=mysql_query("select ceil(sum(duration)/30) as toalPulse,circle from $tblPromoOBDDetails nolock  where date(date_time)='".$view_date."' and ANI!='' and service='MCW_PROMO' and status=2 group by circle",$con);
while (list($totalPromoPulseConsumed,$circle) = mysql_fetch_array($get_totalPromoPulseConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','PULSE_TF_PROMO','$totalPromoPulseConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
*/
///////Total’s New Visit////////////

//save in temp table
if(!$flag)
{
$allnewvisittoday1=mysql_query("select distinct(ANI) as dani,circle,(select count(1) from $tblMissedCall where ANI=dani) as total
from $tblMissedCall nolock  where date(date_time)=date(now())  and ANI!='' and service='MCW_LIVEAPP' group by dani,circle having total=1",$con);
while($dataNewVisitToday1= mysql_fetch_array($allnewvisittoday1))
{
$circle=$dataNewVisitToday1['circle'];
$total=$dataNewVisitToday1['total'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_UUuserTemp(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_New','$total','')";
$queryIns = mysql_query($insert_data, $con);
}

$alluniquevisittoday1=mysql_query("select distinct(ANI) as dani,circle,(select count(1) from $tblMissedCall where ANI=dani) as total
from $tblMissedCall nolock  where date(date_time)=date(now())  and ANI!='' and service='MCW_LIVEAPP' group by dani,circle having total>1",$con);
while($dataUniqueVisitToday1= mysql_fetch_array($alluniquevisittoday1))
{
$circle=$dataUniqueVisitToday1['circle'];
$total=$dataUniqueVisitToday1['total'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_UUuserTemp(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_Repeat','$total','')";
$queryIns = mysql_query($insert_data, $con);
}
}
//save in temp table end here

////////End here///////////////////



/////////////////////////UU_NEW & UU_REPEAT//////////////////////

/////////////////////////////ENd here//////////////////////////

/////////Content Consumption Split////////

$dur1=getOBDStats('0','3',$view_date,$con,$tblObdDetails);
$dur2=getOBDStats('3','6',$view_date,$con,$tblObdDetails);
$dur3=getOBDStats('6','9',$view_date,$con,$tblObdDetails);
$dur4=getOBDStats('9','15',$view_date,$con,$tblObdDetails);
$dur5=getOBDStats('15','30',$view_date,$con,$tblObdDetails);
$dur6=getOBDStats('30','',$view_date,$con,$tblObdDetails);
//$total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4+$dur5;
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_0-3','$dur1','')";
$queryIns = mysql_query($insert_data, $con);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_4-6','$dur2','')";
$queryIns = mysql_query($insert_data, $con);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_7-10','$dur3','')";
$queryIns = mysql_query($insert_data, $con);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_11-15','$dur4','')";
$queryIns = mysql_query($insert_data, $con);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_16-30','$dur5','')";
$queryIns = mysql_query($insert_data, $con);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','MOU_CNT_31-Above','$dur6','')";
$queryIns = mysql_query($insert_data, $con);
//////End here //////////////

//////Total SOU’s Consumed//////////////////
$get_totalSecConsumed=mysql_query("select sum(duration) as toalSec,circle from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and status=2 group by circle",$con);
while (list($totalSecConsumed,$circle) = mysql_fetch_array($get_totalSecConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','SEC_TF','$totalSecConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
///////End here ///////////////////

// AVG_CALLS_TF_UU_TF
////////Avg Missed Call/Visitor start here /////////////
$AVG_CALLS_TF_UU_TF=ceil($total_CALLS_TF/$totalUU_TF);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','AVG_CALLS_TF_UU_TF','$AVG_CALLS_TF_UU_TF','')";
$queryIns = mysql_query($insert_data, $con);

////////////End here/////////////////////////

////////////Ads Playback Duration////////////////
///Need to done
//ADS_PLAYBACK_SEC
/////////////////////End here //////////////////

////////////Unique Ads Played////////////////
///Need to done
//ADS_PLAYBACK_COUNT_UNIQUE
/////////////////////End here //////////////////


////////////Unique Users who listened to Ads////////////////
///Need to done
//ADS_USERS_REACHED
/////////////////////End here //////////////////


//Repeat & New user--
if(!$flag)
{
$allnewvisittoday1=mysql_query("select  count(1) as total,circle
from Hungama_Tatasky.tbl_dailymis_UUuserTemp nolock  where date='".$view_date."' and type='UU_New' and service='".$service."' group by circle",$con);

while($datanewvisittoday1= mysql_fetch_array($allnewvisittoday1))
{
$total=$datanewvisittoday1['total'];
$circle=$datanewvisittoday1['circle'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_New','$total','')";
$queryIns = mysql_query($insert_data, $con);
}
////////End here///////////////////
/////////Repeat Users//////////////////
$allRepeatUserToday=mysql_query("select  count(1) as total,circle
from Hungama_Tatasky.tbl_dailymis_UUuserTemp nolock  where date='".$view_date."' and type='UU_Repeat' and service='".$service."' group by circle",$con);

while($datarepeatVisit= mysql_fetch_array($allRepeatUserToday))
{
$total=$datarepeatVisit['total'];
$circle=$datarepeatVisit['circle'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_Repeat','$total','')";
$queryIns = mysql_query($insert_data, $con);
}
}

//hourly missed call insertion 
$get_query_Hourly_TF = "select count(ANI) as MissedCall,circle, hour(date_time) as hour,date(date_time) as date
from $tblMissedCall nolock where ANI!='' and service='MCW_LIVEAPP' and date(date_time)='".$view_date."' group by hour(date_time),circle order by hour(date_time) ASC";
$query_Hourly_TF = mysql_query($get_query_Hourly_TF, $con);
$numofrows = mysql_num_rows($query_Hourly_TF);
$total_Hourly_TF=0;
$totalMissedCall=0;
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query_Hourly_TF)) {
        $date = $summarydata['date'];
        $totalMissedCall = $summarydata['MissedCall'];
		$circle = $summarydata['circle'];
		if($summarydata['hour']<10)
		$hour='0'.$summarydata['hour'];
		else
		$hour=$summarydata['hour'];
		
		$type = 'MISSEDCALLS_'.$hour;		
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$date' ,'$service','$circle','$type','$totalMissedCall','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}

//Compaign Ad counter code start here
$get_AdsCounter=mysql_query("select sum(counter) as TotalCount from $tblAdDetails nolock  
where date(date_time)='".$view_date."'",$con);
list($TotalCount) = mysql_fetch_array($get_AdsCounter); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','ADS_PLAYBACK_COUNT','$TotalCount','')";
$queryIns = mysql_query($insert_data, $con);
//end here

//AgeVerification counter code start here
$get_AgeCounter=mysql_query("select count(ANI) as TotalCount from $tblAgeVarificationDetails nolock  
where date(LastUpdateDate)='".$view_date."'",$con);
list($TotalCount) = mysql_fetch_array($get_AgeCounter); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','TOTAL_AGE_VERIFIED','$TotalCount','')";
$queryIns = mysql_query($insert_data, $con);
//end here

//crbtrng_reqs_LOG counter code start here
$get_query_CRBT_REQS = "select 'CRBT_REQS' as type,count(1) as TotalCount,circle,date(date_time) as date
from $tblCrbtreqsDetails where ANI!='' and date(date_time)='".$view_date."' group by circle";//group by circle
$query_CRBT_REQS = mysql_query($get_query_CRBT_REQS, $con);
$numofrows = mysql_num_rows($query_CRBT_REQS);
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query_CRBT_REQS)) {
        $date = $summarydata['date'];
        $totalCrbtReqs = $summarydata['TotalCount'];
		$circle = $summarydata['circle'];
		$type = $summarydata['type'];
		$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$date' ,'$service','$circle','$type','$totalCrbtReqs','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}
//end here


echo "Done";

mysql_close($con);
?>