<?php
error_reporting(1);
//require_once("../../../../db.php");
require_once("/var/www/html/hungamacare/db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$pdate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$logFile="/var/www/html/hungamacare/missedcall/admin/html/mis/log_".date("Ymd").".txt";
$logFile_prev="/var/www/html/hungamacare/missedcall/admin/html/mis/log_".$pdate.".txt";
unlink($logFile_prev);
//exit;
$logData="Process start here#".date("Y-m-d H:i:s")."\n";			  
error_log($logData,3,$logFile);

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
$service='EnterpriseTiscon';

$flag=0;
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		$flag=1;
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $view_date= '2014-12-04';
//$flag=1;
echo $view_date;
$del="delete from Hungama_Tatasky.tbl_dailymisMitr where Date='".$view_date."' and service='".$service."'";
$delquery = mysql_query($del,$con);
/*-----for All users start here -- --*/
//Total Missed Call-
$get_query_CALLS_TF = "select 'CALLS_TF' as type,count(1) as MissedCall,upper(circle) as circle
from Hungama_Tatasky.tbl_tata_pushobd where ANI!='' and date(date_time)='".$view_date."' group by circle";//group by circle
$query_CALLS_TF = mysql_query($get_query_CALLS_TF, $con);
$numofrows = mysql_num_rows($query_CALLS_TF);
$total_CALLS_TF=0;
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query_CALLS_TF)) {
        $totalMissedCall = $summarydata['MissedCall'];
		$total_CALLS_TF=$total_CALLS_TF+$totalMissedCall;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','$type','$totalMissedCall','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}

//Total Unique Missed Call-
$get_query_UU_TF = "select 'UU_TF' as type,count(distinct(ANI)) as UniqueUser,upper(circle) as circle
from Hungama_Tatasky.tbl_tata_pushobd where ANI!='' and date(date_time)='".$view_date."' group by circle";// group by circle
$query_UU_TF = mysql_query($get_query_UU_TF, $con);
$numofrows1 = mysql_num_rows($query_UU_TF);
$totalUU_TF=0;
if ($numofrows1 >= 1) {
    while ($summarydata = mysql_fetch_array($query_UU_TF)) {
        $totalUniqueUser = $summarydata['UniqueUser'];
		$totalUU_TF=$totalUU_TF+$totalUniqueUser;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','$type','$totalUniqueUser','')";
       $queryIns = mysql_query($insert_data, $con);
     }
}

///////////////Total Minute consumed////////////////
$get_totalMinuteConsumed=mysql_query("select ceil(sum(duration)/60) as toalMin,upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' group by circle",$con);
while (list($totalMinuteConsumed,$circle) = mysql_fetch_array($get_totalMinuteConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','MOU_TF','$totalMinuteConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}


///////No of OBD Pushed/////////
$get_TotalOBDPushed=mysql_query("select  count(ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time)='".$view_date."' and ANI!='' and status!=0 group by circle",$con);
while (list($TotalOBDPushed,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','CALLS_OBD','$TotalOBDPushed','')";
$queryIns = mysql_query($insert_data, $con);
}

///////No of Unique OBD Pushed/////////
$get_TotalOBDPushed=mysql_query("select  count(distinct ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 group by circle",$con);
while (list($TotalOBDPushed_UU,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','CALLS_OBD_UU','$TotalOBDPushed_UU','')";
$queryIns = mysql_query($insert_data, $con);
}

//NO of new users
$get_TotalOBDPushed_New=mysql_query("select  count(distinct ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tiscon_subscription nolock  where date(subdate)='".$view_date."' and ANI!=''  group by circle",$con);
while (list($TotalOBDPushed_NewUU,$circle) = mysql_fetch_array($get_TotalOBDPushed_New)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','CALLS_NEW_UU','$TotalOBDPushed_NewUU','')";
$queryIns = mysql_query($insert_data, $con);
}

///////No of OBD Pushed SUccess/////////
$totalSuccesOBD=0;
$get_TotalOBDPushed=mysql_query("select  count(ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 group by circle",$con);
while (list($TotalOBDPushed_SUCCESS,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
$totalSuccesOBD=$totalSuccesOBD+$TotalOBDPushed_SUCCESS;
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','CALLS_OBD_SUCCESS','$TotalOBDPushed_SUCCESS','')";
$queryIns = mysql_query($insert_data, $con);
}


//////Total SOU’s Consumed//////////////////
$totalDuration=0;
$get_totalSecConsumed=mysql_query("select sum(duration) as toalSec,upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 group by circle",$con);
while (list($totalSecConsumed,$circle) = mysql_fetch_array($get_totalSecConsumed)) {
$totalDuration=$totalDuration+$totalSecConsumed;
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)
	values('$view_date' ,'$service','$circle','SEC_TF','$totalSecConsumed','')";
$queryIns = mysql_query($insert_data, $con);
}
///////End here ///////////////////
//Language //date(lastupdatedate)='".$view_date."'
//$get_totalLangConsumed=mysql_query("select count(1) as total,circle,lang from Hungama_Tatasky.tbl_tiscon_subscription where date(lastupdatedate)='".$view_date."' and circle !='' group by circle,lang",$con);

$get_totalLangConsumed=mysql_query("select count(sub.ANI) as total,sub.circle,sub.lang from Hungama_Tatasky.tbl_tiscon_subscription sub,Hungama_Tatasky.tbl_tataobd_success_fail_details sucfail where sub.ANI=sucfail.ANI and date(sucfail.date_time)='".$view_date."'  and sucfail.status=2
and sucfail.circle=sub.circle group by sub.lang,sub.circle order by sub.circle desc",$con); 

while (list($total,$circle,$lang) = mysql_fetch_array($get_totalLangConsumed)) {

 $insert_data_hin = mysql_query("insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue)	values('$view_date' ,'$service','$circle','$lang','$total','')",$con);
 }
/*-----for All users end here -- --*/


/*-----for All users mitr start here -- ------------------------*/
//Total Missed Call-
$get_query_CALLS_TF = "select 'CALLS_TF' as type,count(1) as MissedCall,upper(circle) as circle
from Hungama_Tatasky.tbl_tata_pushobd where ANI!='' and date(date_time)='".$view_date."' and IsMitr=1 group by circle";//group by circle
$query_CALLS_TF = mysql_query($get_query_CALLS_TF, $con);
$numofrows = mysql_num_rows($query_CALLS_TF);
$total_CALLS_TF=0;
if ($numofrows >= 1) {
    while ($summarydata = mysql_fetch_array($query_CALLS_TF)) {
        $totalMissedCall = $summarydata['MissedCall'];
		$total_CALLS_TF=$total_CALLS_TF+$totalMissedCall;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','$type','$totalMissedCall','',1)";
       $queryIns = mysql_query($insert_data, $con);
     }
}

//Total Unique Missed Call-
$get_query_UU_TF = "select 'UU_TF' as type,count(distinct(ANI)) as UniqueUser,upper(circle) as circle
from Hungama_Tatasky.tbl_tata_pushobd where ANI!='' and date(date_time)='".$view_date."' and IsMitr=1 group by circle";// group by circle
$query_UU_TF = mysql_query($get_query_UU_TF, $con);
$numofrows1 = mysql_num_rows($query_UU_TF);
$totalUU_TF=0;
if ($numofrows1 >= 1) {
    while ($summarydata = mysql_fetch_array($query_UU_TF)) {
        $totalUniqueUser = $summarydata['UniqueUser'];
		$totalUU_TF=$totalUU_TF+$totalUniqueUser;
        $circle = $summarydata['circle'];
		$type = $summarydata['type'];
       $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','$type','$totalUniqueUser','',1)";
       $queryIns = mysql_query($insert_data, $con);
     }
}

///////////////Total Minute consumed////////////////
$get_totalMinuteConsumed=mysql_query("select ceil(sum(duration)/60) as toalMin,upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and IsMitr=1 group by circle",$con);
while (list($totalMinuteConsumed,$circle) = mysql_fetch_array($get_totalMinuteConsumed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','MOU_TF','$totalMinuteConsumed','',1)";
$queryIns = mysql_query($insert_data, $con);
}


///////No of OBD Pushed/////////
$get_TotalOBDPushed=mysql_query("select  count(ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time)='".$view_date."' and ANI!='' and status!=0 and IsMitr=1 group by circle",$con);
while (list($TotalOBDPushed,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','CALLS_OBD','$TotalOBDPushed','',1)";
$queryIns = mysql_query($insert_data, $con);
}

///////No of Unique OBD Pushed/////////

$get_TotalOBDPushed=mysql_query("select  count(distinct ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 and IsMitr=1 group by circle",$con);
while (list($TotalOBDPushed_UU,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
  $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','CALLS_OBD_UU','$TotalOBDPushed_UU','',1)";
$queryIns = mysql_query($insert_data, $con);
}

//No of new user
$get_TotalOBDPushed_New=mysql_query("select  count(ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tiscon_subscription nolock  
where date(subdate)='".$view_date."' and ANI in (select ANI from Hungama_Tatasky.tbl_base ) 
group by circle",$con);
while (list($TotalOBDPushed_NewUU,$circle) = mysql_fetch_array($get_TotalOBDPushed_New)) {
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','CALLS_NEW_UU','$TotalOBDPushed_NewUU','',1)";
$queryIns = mysql_query($insert_data, $con);
}

///////No of OBD Pushed SUccess/////////
$totalSuccesOBD=0;
$get_TotalOBDPushed=mysql_query("select  count(ANI),upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 and IsMitr=1 group by circle",$con);
while (list($TotalOBDPushed_SUCCESS,$circle) = mysql_fetch_array($get_TotalOBDPushed)) {
$totalSuccesOBD=$totalSuccesOBD+$TotalOBDPushed_SUCCESS;
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','CALLS_OBD_SUCCESS','$TotalOBDPushed_SUCCESS','',1)";
$queryIns = mysql_query($insert_data, $con);
}


//////Total SOU’s Consumed//////////////////
$totalDuration=0;
$get_totalSecConsumed=mysql_query("select sum(duration) as toalSec,upper(circle) as circle from Hungama_Tatasky.tbl_tataobd_success_fail_details nolock  where date(date_time)='".$view_date."' and ANI!='' and status=2 and IsMitr=1 group by circle",$con);
while (list($totalSecConsumed,$circle) = mysql_fetch_array($get_totalSecConsumed)) {
$totalDuration=$totalDuration+$totalSecConsumed;
 $insert_data = "insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)
	values('$view_date' ,'$service','$circle','SEC_TF','$totalSecConsumed','',1)";
$queryIns = mysql_query($insert_data, $con);
}
///////End here ///////////////////
//Language 
//$get_totalLangConsumed=mysql_query("select count(1) as total,circle,lang from Hungama_Tatasky.tbl_tiscon_subscription where date(lastupdatedate)='".$view_date."' and circle !='' and ANI in (select ANI from Hungama_Tatasky.tbl_base) group by circle,lang",$con);

$get_totalLangConsumed=mysql_query("select count(sub.ANI) as total,sub.circle,sub.lang from Hungama_Tatasky.tbl_tiscon_subscription sub,Hungama_Tatasky.tbl_tataobd_success_fail_details sucfail where sub.ANI=sucfail.ANI and date(sucfail.date_time)='".$view_date."'  and sucfail.status=2 and sucfail.IsMitr=1 
and sucfail.circle=sub.circle and sub.ANI in (select ANI from Hungama_Tatasky.tbl_base ) group by sub.lang,sub.circle order by sub.circle desc",$con);
while (list($total,$circle,$lang) = mysql_fetch_array($get_totalLangConsumed)) {

 $insert_data_hin = mysql_query("insert into Hungama_Tatasky.tbl_dailymisMitr(Date,Service,Circle,Type,Value,Revenue,IsMitr)	values('$view_date' ,'$service','$circle','$lang','$total','',1)",$con);
 }
/*-----for All users mitr end here -- --*/
echo "Done";
mysql_close($con);
$logData="Process end here#".date("Y-m-d H:i:s")."\n";			  
error_log($logData,3,$logFile);
?>
