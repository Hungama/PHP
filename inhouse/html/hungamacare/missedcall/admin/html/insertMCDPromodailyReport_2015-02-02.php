<?php
error_reporting(0);
require_once("../../../db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//database used for this app(MCD)
$service='EnterpriseMcDwOBD';
$dbNameMCD='Hungama_ENT_MCDOWELL';
$tblMissedCall=$dbNameMCD.'.tbl_mcdowell_pushobd_promotion';
$tblObdDetails=$dbNameMCD.'.tbl_mcdowell_success_fail_promotion_details';

$flag=0;
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		$flag=1;
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//$view_date= '2015-01-27';
//$flag=0;
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

$getDashbord_OBDStats=mysql_query("select count(ANI) from $tblObdDetails nolock  where date(date_time)='".$Date."' and ANI!='' and status=2 and $cond ",$con);
list($total)=mysql_fetch_array($getDashbord_OBDStats);
return $total;
}
echo "Step1==>";
/////////////////////////// Code start for Total Unique Subscribers Attempted: //////////////////////
$get_query_CALLS_TF = "select 'CALLS_TF' as type,count(1) as MissedCall,circle,date(date_time) as date
from $tblObdDetails nolock where ANI!='' and date(date_time)='".$view_date."' group by circle";//group by circle
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
echo "Step2==>";
$get_query_UU_TF = "select 'UU_TF' as type,count(distinct(ANI)) as UniqueUser,circle,date(date_time) as date
from $tblObdDetails nolock where ANI!='' and date(date_time)='".$view_date."' group by circle";// group by circle
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
//Total connected
echo "Step3==>";
$get_query_OBD_UU = "select 'OBD_UU' as type,count(1) as TotalConnected,circle,date(date_time) as date
from $tblObdDetails nolock where ANI!='' and status=2 and date(date_time)='".$view_date."' group by circle";// group by circle

$query_OBD_UU = mysql_query($get_query_OBD_UU, $con);
$numofrows1 = mysql_num_rows($query_OBD_UU);
$totalOBD_UU=0;
if ($numofrows1 >= 1) {
    while ($summarydata = mysql_fetch_array($query_OBD_UU)) {
        $date = $summarydata['date'];
        $totalConnected = $summarydata['TotalConnected'];
		$totalOBD_UU=$totalOBD_UU+$totalConnected;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$date' ,'$service','$circle','$type','$totalOBD_UU','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}

echo "Step4==>";

///////////////Total Minute consumed////////////////
$get_totalMinuteConsumed=mysql_query("select ceil(sum(duration)/60) as toalMin,circle from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 group by circle",$con);
while (list($totalMinuteConsumed,$circle) = mysql_fetch_array($get_totalMinuteConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','MOU_TF','$totalMinuteConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
////////////End here///////////////////////////
echo "Step5==>";
//////////Maximum Duration Listen////////
$get_MaxDurationlisten=mysql_query("select max(duration) as maxDuration from $tblObdDetails nolock  
where date(date_time)='".$view_date."' and ANI!='' and status=2 ",$con);
list($maxDurationListen) = mysql_fetch_array($get_MaxDurationlisten); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','SEC_MAX','$maxDurationListen','')";
$queryIns = mysql_query($insert_data, $con);
/////////// End here////////////////
echo "Step6==>";
///////No of OBD Pushed/////////
$get_TotalOBDPushed=mysql_query("select  count(ANI) from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!=''",$con);
list($TotalOBDPushed) = mysql_fetch_array($get_TotalOBDPushed); 
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','CALLS_OBD','$TotalOBDPushed','')";
$queryIns = mysql_query($insert_data, $con);
/////////End here //////////////////
echo "Step7==>";
$get_totalPromoPulseConsumed=mysql_query("select ceil(sum(duration)/30) as toalPulse,circle from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!=''  and status=2 group by circle",$con);
while (list($totalPromoPulseConsumed,$circle) = mysql_fetch_array($get_totalPromoPulseConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','PULSE_TF','$totalPromoPulseConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}

//save in temp table
if(!$flag)
{
$allnewvisittoday1=mysql_query("select distinct(ANI) as dani,circle,(select count(1) from $tblObdDetails where ANI=dani) as total
from $tblObdDetails nolock  where date(date_time)=date(now())  and ANI!='' group by dani,circle having total=1",$con);
while($dataNewVisitToday1= mysql_fetch_array($allnewvisittoday1))
{
$circle=$dataNewVisitToday1['circle'];
$total=$dataNewVisitToday1['total'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_UUuserTemp(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_New','$total','')";
$queryIns = mysql_query($insert_data, $con);
}
echo "Step8==>";
/*
$alluniquevisittoday1=mysql_query("select distinct(ANI) as dani,circle,(select count(1) from $tblObdDetails where ANI=dani) as total
from $tblMissedCall nolock  where date(date_time)=date(now())  and ANI!='' group by dani,circle having total>1",$con);
while($dataUniqueVisitToday1= mysql_fetch_array($alluniquevisittoday1))
{
$circle=$dataUniqueVisitToday1['circle'];
$total=$dataUniqueVisitToday1['total'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_UUuserTemp(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_Repeat','$total','')";
$queryIns = mysql_query($insert_data, $con);
}
*/
}
//save in temp table end here

////////End here///////////////////
/////////Content Consumption Split////////

$dur1=getOBDStats('0','3',$view_date,$con,$tblObdDetails);
echo "Step9==>";
$dur2=getOBDStats('3','6',$view_date,$con,$tblObdDetails);
$dur3=getOBDStats('6','9',$view_date,$con,$tblObdDetails);
$dur4=getOBDStats('9','15',$view_date,$con,$tblObdDetails);
$dur5=getOBDStats('15','30',$view_date,$con,$tblObdDetails);
$dur6=getOBDStats('30','',$view_date,$con,$tblObdDetails);
echo "Step10==>";
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
echo "Step11==>";
//////Total SOU’s Consumed//////////////////
$get_totalSecConsumed=mysql_query("select sum(duration) as toalSec,circle from $tblObdDetails nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 group by circle",$con);
while (list($totalSecConsumed,$circle) = mysql_fetch_array($get_totalSecConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','SEC_TF','$totalSecConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
echo "Step12==>";
///////End here ///////////////////

// AVG_CALLS_TF_UU_TF
////////Avg Missed Call/Visitor start here /////////////
$AVG_CALLS_TF_UU_TF=ceil($total_CALLS_TF/$totalUU_TF);
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','','AVG_CALLS_TF_UU_TF','$AVG_CALLS_TF_UU_TF','')";
$queryIns = mysql_query($insert_data, $con);
echo "Step13==>";
////////////End here/////////////////////////

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
/*
$allRepeatUserToday=mysql_query("select  count(1) as total,circle
from Hungama_Tatasky.tbl_dailymis_UUuserTemp nolock  where date='".$view_date."' and type='UU_Repeat' and service='".$service."' group by circle",$con);

while($datarepeatVisit= mysql_fetch_array($allRepeatUserToday))
{
$total=$datarepeatVisit['total'];
$circle=$datarepeatVisit['circle'];
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','UU_Repeat','$total','')";
$queryIns = mysql_query($insert_data, $con);
}*/
}
echo "Step14==>";
//hourly missed call insertion 
$get_query_Hourly_TF = "select count(ANI) as MissedCall,circle, hour(date_time) as hour,date(date_time) as date
from $tblObdDetails nolock where ANI!='' and date(date_time)='".$view_date."' group by hour(date_time),circle order by hour(date_time) ASC";
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

// MCD Mcdowls_SOngDedicationquery data start here
// MCD Mcdowls_SOngDedicationquery data start here
echo 'Total dedication by Party A (DD_PARTY_A)'."<br>";
$queryUniqueSubscribersAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."' group by circle";
$result1=mysql_query($queryUniqueSubscribersAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','DD_PARTY_A','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total unique dedication by Party A (UU_DD_PARTY_A)'."<br>";
$queryUU_DD_PARTY_AAttempted="select count(distinct ANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."'";
$result1=mysql_query($queryUU_DD_PARTY_AAttempted, $con);
list($TotalUU_DD_PARTY_A) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','UU_DD_PARTY_A','".$TotalUU_DD_PARTY_A."',NULL)";
mysql_query($insertquery, $con);

echo 'Total unique Dedications(unique numbers of party B):  (UU_DD_PARTY_B)'."<br>";
$queryUU_DD_PARTY_BAttempted="select count(distinct BPARTYANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."'";
$result1=mysql_query($queryUU_DD_PARTY_BAttempted, $con);
list($TotalUU_DD_PARTY_B) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','UU_DD_PARTY_B','".$TotalUU_DD_PARTY_B."',NULL)";
mysql_query($insertquery, $con);


echo 'Total OBD pushed to party B (OBD_TF_B)'."<br>";
$queryOBD_TF_BAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."' and status!=0 group by circle";
$result1=mysql_query($queryOBD_TF_BAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','OBD_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total Duration heard by Party B(SEC_TF_B)'."<br>";
$querySEC_TF_BAttempted="select sum(duration) as Totalduration,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details_SongDedicate nolock where date(date_time)='".$view_date."' and status=2 group by circle";
$result1=mysql_query($querySEC_TF_BAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','SEC_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total users eligible for Recharge (RECHRG_ELG)'."<br>";
$queryRECHRG_ELG="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Party='A'";
$result1=mysql_query($queryRECHRG_ELG, $con);
list($TotalRECHRG_ELG) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_ELG','".$TotalRECHRG_ELG."',NULL)";
mysql_query($insertquery, $con);

echo 'Total users eligible for Recharge (RECHRG_ELG_B)'."<br>";
$queryRECHRG_ELGB="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Party='B'";
$result1=mysql_query($queryRECHRG_ELGB, $con);
list($TotalRECHRG_ELGB) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_ELG_B','".$TotalRECHRG_ELGB."',NULL)";
mysql_query($insertquery, $con);

echo 'Total successful recharge done (RECHRG_SUCCESS)'."<br>";
$queryRECHRG_SUCCESS="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='A'";
$result1=mysql_query($queryRECHRG_SUCCESS, $con);
list($TotalRECHRG_SUCCESS) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_SUCCESS_A','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);

echo 'Total Recharge failed (RECHRG_FAIL)'."<br>";
$queryRECHRG_FAIL="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' 
and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='A'";
$result1=mysql_query($queryRECHRG_FAIL, $con);
list($TotalRECHRG_FAIL) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_FAIL_A','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);

//B Party
echo 'Total successful recharge done (RECHRG_SUCCESS_B)'."<br>";
$queryRECHRG_SUCCESS="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='B'";
$result1=mysql_query($queryRECHRG_SUCCESS, $con);
list($TotalRECHRG_SUCCESS) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_SUCCESS_B','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);

echo 'Total Recharge failed (RECHRG_FAIL_B)'."<br>";
$queryRECHRG_FAIL="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='B'";
$result1=mysql_query($queryRECHRG_FAIL, $con);
list($TotalRECHRG_FAIL) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_FAIL_B','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);

// MCD Mcdowls_SOngDedicationquery data end here
echo "Done";
mysql_close($con);
?>
