<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );	
	return $res;
}
$curdate = date("Y_m_d_H_i_s");
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$PreDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$reportdate = date('j F ,Y ', strtotime($PDate));

//$dbnameMCD='Hungama_Maxlife_IGenius.tbl_HourlyAlert';
$dbnameMCD='Hungama_Maxlife_IGenius';
$From_lasthour = date('H', strtotime('-1 hour'));
$To_lasthour = date('H');
$dateToShow=$From_lasthour.'-'.$To_lasthour;

if (date('H') == '00')
{
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}

//IGENIUS-

$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));
if($date_lasthour==00)
{
$updateQuery="update Hungama_Maxlife_IGenius.tbl_HourlyAlert set date_time='".$PreDate."' where date(date_time)=date(now()) and Data_Hour='23' and service='IGENIUS'";
mysql_query($updateQuery,$dbConn);
}

$Live_NC = 0;
$NonLive_NC = 0;
$CH1_REC_SUB = 0;
$CH2_REC_SUB = 0;
$CH1_REC_NOTSUB = 0;
$CH2_REC_NOTSUB = 0;
$CH1_RE_REC_SUB = 0;
$CH2_RE_REC_SUB = 0;
$CH2_RE_REC_NOTSUB =0;
$DATA_HOUR = 0;
$CH1_RE_REC_NOTSUB = 0;
$DATA_HOUR=$date_lasthour;

//Live (Called but not recorded)  Live_NC
$get_query_Live_NC = "select 'Live_NC' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and ANI!='' and hour(date_time)='".$date_lasthour."' and islive=1 and isrecorded=0";
$query_Live_NC = mysql_query($get_query_Live_NC, $dbConn);
list($type,$Live_NC,$date) = mysql_fetch_array($query_Live_NC); 


//Non-Live (Called but not recorded) NonLive_NC
$get_query_NonLive_NC = "select 'NonLive_NC' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and islive=0 and isrecorded=0'";
$query_Live_NonLive_NC = mysql_query($get_query_NonLive_NC, $dbConn);
list($type,$NonLive_NC,$date) = mysql_fetch_array($query_Live_NonLive_NC);


//Child 1 rec submitted   CH1_REC_SUB
$get_query_CH1_REC_SUB = "select 'CH1_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=1 and rec_type='Fresh' and issubmitted=1 and isrecorded=1";
$query_CH1_REC_SUB = mysql_query($get_query_CH1_REC_SUB, $dbConn);
list($type,$CH1_REC_SUB,$date) = mysql_fetch_array($query_CH1_REC_SUB);


//Child 2 rec submitted   CH2_REC_SUB
$get_query_CH2_REC_SUB = "select 'CH2_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=2 and rec_type='Fresh' and issubmitted=1 and isrecorded=1";
$query_CH2_REC_SUB = mysql_query($get_query_CH2_REC_SUB, $dbConn);
list($type,$CH2_REC_SUB,$date) = mysql_fetch_array($query_CH2_REC_SUB);

//Child 1 rec not-submitted   CH1_REC_NOTSUB
$get_query_CH1_REC_NOTSUB = "select 'CH1_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=1 and rec_type='Fresh' and issubmitted=0 and isrecorded=1";
$query_CH1_REC_NOTSUB = mysql_query($get_query_CH1_REC_NOTSUB, $dbConn);
list($type,$CH1_REC_NOTSUB,$date) = mysql_fetch_array($query_CH1_REC_NOTSUB);


//Child 2 rec not-submitted   CH2_REC_NOTSUB
$get_query_CH2_REC_NOTSUB = "select 'CH2_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=2 and rec_type='Fresh' and issubmitted=0 and isrecorded=1";
$query_CH2_REC_NOTSUB = mysql_query($get_query_CH2_REC_NOTSUB, $dbConn);
list($type,$CH2_REC_NOTSUB,$date) = mysql_fetch_array($query_CH2_REC_NOTSUB);


//////////////////Re Record section Start here //////////////////
//Child 1 re-rec submitted   CH1_RE_REC_SUB
$get_query_CH1_RE_REC_SUB = "select 'CH1_RE_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=1 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1";
$query_CH1_RE_REC_SUB = mysql_query($get_query_CH1_RE_REC_SUB, $dbConn);
list($type,$CH1_RE_REC_SUB,$date) = mysql_fetch_array($query_CH1_RE_REC_SUB);


//Child 2 re-rec submitted   CH2_RE_REC_SUB
$get_query_CH2_RE_REC_SUB = "select 'CH2_RE_REC_SUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=2 and rec_type='Rerecord' and issubmitted=1 and isrecorded=1";
$query_CH2_RE_REC_SUB = mysql_query($get_query_CH2_RE_REC_SUB, $dbConn);
list($type,$CH2_RE_REC_SUB,$date) = mysql_fetch_array($query_CH2_RE_REC_SUB);


//Child 1 re-rec not-submitted   CH1_RE_REC_NOTSUB
$get_query_CH1_RE_REC_NOTSUB = "select 'CH1_RE_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=1 and rec_type='Rerecord' and issubmitted=0 and isrecorded=1";
$query_CH1_RE_REC_NOTSUB = mysql_query($get_query_CH1_RE_REC_NOTSUB, $dbConn);
list($type,$CH1_RE_REC_NOTSUB,$date) = mysql_fetch_array($query_CH1_RE_REC_NOTSUB);

//Child 2 re-rec not-submitted   CH2_RE_REC_NOTSUB
$get_query_CH2_RE_REC_NOTSUB = "select 'CH2_RE_REC_NOTSUB' as type,count(1) as Total,date(date_time) as date
from Hungama_Maxlife_IGenius.tbl_user_transaction nolock where date(date_time)='".$PDate."' and  ANI!='' and hour(date_time)='".$date_lasthour."' and child_id=2 and rec_type='Rerecord' and issubmitted=0 and isrecorded=1";
$query_CH2_RE_REC_NOTSUB = mysql_query($get_query_CH2_RE_REC_NOTSUB, $dbConn);
list($type,$CH2_RE_REC_NOTSUB,$date) = mysql_fetch_array($query_CH2_RE_REC_NOTSUB);


$delQuery="delete from Hungama_Maxlife_IGenius.tbl_HourlyAlert where date(date_time)=date(now()) and Data_Hour='".$DATA_HOUR."' and service='IGENIUS'";
mysql_query($delQuery,$dbConn);

$insertQuery="INSERT INTO Hungama_Maxlife_IGenius.tbl_HourlyAlert (service,Live_NC,NonLive_NC,CH1_REC_SUB,CH2_REC_SUB,CH1_REC_NOTSUB,CH2_REC_NOTSUB,CH1_RE_REC_SUB,CH2_RE_REC_SUB,CH1_RE_REC_NOTSUB,CH2_RE_REC_NOTSUB,Data_Hour,date_time,timeToshow) VALUES('IGENIUS','".$Live_NC."','".$NonLive_NC."','".$CH1_REC_SUB."','".$CH2_REC_SUB."','".$CH1_REC_NOTSUB."','".$CH2_REC_NOTSUB."','".$CH1_RE_REC_SUB."','".$CH2_RE_REC_SUB."','".$CH1_RE_REC_NOTSUB."','".$CH2_RE_REC_NOTSUB."','".$DATA_HOUR."', NOW(),'".$dateToShow."')";
$insertdata = mysql_query($insertQuery,$dbConn);
echo "DONE";
mysql_close($dbConn);
?>