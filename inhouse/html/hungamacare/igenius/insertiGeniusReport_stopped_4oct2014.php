<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$service='EnterpriseTiscon';
$flag=0;
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		$flag=1;
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//$view_date= '2014-09-01';
#$flag=1;
$del="delete from Hungama_Tatasky.tbl_dailymis where Date='".$view_date."' and service='".$service."'";
//$delquery = mysql_query($del,$con);

//Live (Called but not recorded)  Live_NC
//Non-Live (Called but not recorded) NonLive_NC
//Total
//Child 1 rec submitted   CH1_REC_SUB
//Child 2 rec submitted   CH2_REC_SUB
//Child 1 rec not-submitted   CH1_REC_NOTSUB
//Child 2 rec not-submitted   CH2_REC_NOTSUB

//Child 1 re-rec submitted   CH1_RE_REC_SUB
//Child 2 re-rec submitted   CH2_RE_REC_SUB
//Child 1 re-rec not-submitted   CH1_RE_REC_NOTSUB
//Child 2 re-rec not-submitted   CH2_RE_REC_NOTSUB
//Recorded but not submitted total  

$get_query_TotalUnique = "select count(distinct (ANI)) as Total
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' ";
$query_TotalUnique = mysql_query($get_query_TotalUnique, $dbConn);
list($TotalUniqueCall) = mysql_fetch_array($query_TotalUnique); 
echo 'Total number of customers who called - Unique '.$TotalUniqueCall."<br>";

$get_query_TotalCalls = "select count(ANI) as Total
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' ";
$query_TotalCalls = mysql_query($get_query_TotalCalls, $dbConn);
list($TotalCallsMade) = mysql_fetch_array($query_TotalCalls); 
echo 'Total number of calls made on IVR- '.$TotalCallsMade."<br>";


//Total Live 
$get_query_TotalLive_NC = "select 'Total_Live_NC' as type,count(1) as Total
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and islive=1";
$query_TotalLive_NC = mysql_query($get_query_TotalLive_NC, $dbConn);
list($type,$AlltotalLive_NC,$date) = mysql_fetch_array($query_TotalLive_NC); 
//Total Non-Live 
$get_query_TotalNonLive_NC = "select 'NonLive_NC' as type,count(1) as Total
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and islive=0";
$query_TotalLive_NonLive_NC = mysql_query($get_query_TotalNonLive_NC, $dbConn);
list($type,$AlltotalNonLive_NC,$date) = mysql_fetch_array($query_TotalLive_NonLive_NC);

$total=$AlltotalLive_NC+$AlltotalNonLive_NC;
echo "Total - ".$total."<br>";
echo 'Total Live - '. $AlltotalLive_NC."<br>";
echo 'Total Non-Live  - '. $AlltotalNonLive_NC."<br>";


//Live (Called but not recorded)  Live_NC
$get_query_Live_NC = "select 'Live_NC' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and islive=1 and isrecorded=0";
$query_Live_NC = mysql_query($get_query_Live_NC, $dbConn);
list($type,$totalLive_NC,$date) = mysql_fetch_array($query_Live_NC); 
echo 'Live (Called but not recorded) - '. $totalLive_NC."<br>";

//Non-Live (Called but not recorded) NonLive_NC //rec_type='Fresh'
$get_query_NonLive_NC = "select 'NonLive_NC' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and islive=0  and isrecorded=0";
$query_Live_NonLive_NC = mysql_query($get_query_NonLive_NC, $dbConn);
list($type,$totalNonLive_NC,$date) = mysql_fetch_array($query_Live_NonLive_NC);
echo 'Non-Live (Called but not recorded) - '. $totalNonLive_NC."<br>";

//Child 1 rec submitted   CH1_REC_SUB
$get_query_CH1_REC_SUB = "select 'CH1_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=1 and rec_type='Fresh' and issubmitted=1 and isrecorded=1";
$query_CH1_REC_SUB = mysql_query($get_query_CH1_REC_SUB, $dbConn);
list($type,$totalCH1_REC_SUB,$date) = mysql_fetch_array($query_CH1_REC_SUB);
echo 'Child 1 rec submitted - '. $totalCH1_REC_SUB."<br>";


//Child 2 rec submitted   CH2_REC_SUB
$get_query_CH2_REC_SUB = "select 'CH2_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=2 and rec_type='Fresh' and issubmitted=1 and isrecorded=1";
$query_CH2_REC_SUB = mysql_query($get_query_CH2_REC_SUB, $dbConn);
list($type,$totalCH2_REC_SUB,$date) = mysql_fetch_array($query_CH2_REC_SUB);
echo 'Child 2 rec submitted - '. $totalCH2_REC_SUB."<br>";

//Child 1 rec not-submitted   CH1_REC_NOTSUB
$get_query_CH1_REC_NOTSUB = "select 'CH1_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=1 and rec_type='Fresh' and issubmitted=0 and isrecorded=1";
$query_CH1_REC_NOTSUB = mysql_query($get_query_CH1_REC_NOTSUB, $dbConn);
list($type,$totalCH1_REC_NOTSUB,$date) = mysql_fetch_array($query_CH1_REC_NOTSUB);
echo 'Child 1 rec not-submitted - '. $totalCH1_REC_NOTSUB."<br>";


//Child 2 rec not-submitted   CH2_REC_NOTSUB
$get_query_CH2_REC_NOTSUB = "select 'CH2_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=2 and rec_type='Fresh' and issubmitted=0 and isrecorded=1";
$query_CH2_REC_NOTSUB = mysql_query($get_query_CH2_REC_NOTSUB, $dbConn);
list($type,$totalCH2_REC_NOTSUB,$date) = mysql_fetch_array($query_CH2_REC_NOTSUB);
echo 'Child 2 rec not-submitted - '. $totalCH2_REC_NOTSUB."<br>";


//////////////////Re Record section Start here //////////////////
//Child 1 re-rec submitted   CH1_RE_REC_SUB
$get_query_CH1_RE_REC_SUB = "select 'CH1_RE_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=1 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1";
$query_CH1_RE_REC_SUB = mysql_query($get_query_CH1_RE_REC_SUB, $dbConn);
list($type,$totalCH1_RE_REC_SUB,$date) = mysql_fetch_array($query_CH1_RE_REC_SUB);
echo 'Child 1 re-rec submitted - '. $totalCH1_RE_REC_SUB."<br>";


//Child 2 re-rec submitted   CH2_RE_REC_SUB
$get_query_CH2_RE_REC_SUB = "select 'CH2_RE_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=2 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1";
$query_CH2_RE_REC_SUB = mysql_query($get_query_CH2_RE_REC_SUB, $dbConn);
list($type,$totalCH2_RE_REC_SUB,$date) = mysql_fetch_array($query_CH2_RE_REC_SUB);
echo 'Child 2 re-rec submitted - '. $totalCH2_RE_REC_SUB."<br>";

//Child 1 re-rec not-submitted   CH1_RE_REC_NOTSUB
$get_query_CH1_RE_REC_NOTSUB = "select 'CH1_RE_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=1 and rec_type='Rerecord' and issubmitted=0 and isrecorded=1";
$query_CH1_RE_REC_NOTSUB = mysql_query($get_query_CH1_RE_REC_NOTSUB, $dbConn);
list($type,$totalCH1_RE_REC_NOTSUB,$date) = mysql_fetch_array($query_CH1_RE_REC_NOTSUB);
echo 'Child 1 re-rec not-submitted - '. $totalCH1_RE_REC_NOTSUB."<br>";

//Child 2 re-rec not-submitted   CH2_RE_REC_NOTSUB
$get_query_CH2_RE_REC_NOTSUB = "select 'CH2_RE_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where ANI!='' and date(date_time)='".$view_date."' and child_id=2 and rec_type='Rerecord' and issubmitted=0 and isrecorded=1";
$query_CH2_RE_REC_NOTSUB = mysql_query($get_query_CH2_RE_REC_NOTSUB, $dbConn);
list($type,$totalCH2_RE_REC_NOTSUB,$date) = mysql_fetch_array($query_CH2_RE_REC_NOTSUB);
echo 'Child 2 re-rec not-submitted - '. $totalCH2_RE_REC_NOTSUB."<br>";
mysql_close($dbConn);
?>