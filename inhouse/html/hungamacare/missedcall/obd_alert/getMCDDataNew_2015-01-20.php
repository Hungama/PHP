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

$dbnameMCD='Hungama_ENT_MCDOWELL';
$From_lasthour = date('H', strtotime('-1 hour'));
$To_lasthour = date('H');
$dateToShow=$From_lasthour.'-'.$To_lasthour;
if (date('H') == '00')
{
$type='y';
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
//EnterpriseMcDw-

$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));
if($date_lasthour==00)
{
$updateQuery="update Hungama_Tatasky.tbl_tata_pushobdHourlyAlert set date_time='".$PreDate."' where date(date_time)=date(now()) and Data_Hour='23' and service='MCW_LIVEAPP'";
mysql_query($updateQuery,$dbConn);
}

$MISSED_CALLS = 0;
$TotalAttempt_OBD = 0;
$OBD_CONNECTED = 0;
$OBD_FAILED = 0;
$AVG_RESTIME = 0;
$MAX_RESTIME = 0;
$MIN_RESTIME = 0;
$AVG_SUCCESS = 0;
$DATA_HOUR = 0;
$OBD_INPROCESS = 0;

$DATA_HOUR=$date_lasthour;
$getDashbord_MaxMinAvgDuration=mysql_query("select max(obd_diff) as maxDiff,min(obd_diff) as minDiff,ceil(AVG(obd_diff)) as avgDiff from $dbnameMCD.tbl_mcdowell_pushobd_liveapp nolock  
where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and hour(date_time)='" . $date_lasthour . "' ",$dbConn);
list($maxDiff,$minDiff,$avgDiff) = mysql_fetch_array($getDashbord_MaxMinAvgDuration); 

$AVG_RESTIME = $avgDiff;
$MAX_RESTIME = $maxDiff;
$MIN_RESTIME = $minDiff;



$get_allData="select count(1) as total,status,hour(date_time) as chour from $dbnameMCD.tbl_mcdowell_pushobd_liveapp nolock  
where date(date_time)='".$view_date."' and ANI!='' and service='MCW_LIVEAPP' and hour(date_time)='" . $date_lasthour . "' group by status";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());


while ($row = mysql_fetch_array($data)) {
$total=0;
$status='';
$status=$row['status'];
$total=$row['total'];
 
$MISSED_CALLS = $MISSED_CALLS+$total;

if($status!=0)
{
$TotalAttempt_OBD=$TotalAttempt_OBD+$total;
}

if($status==5)
{
$OBD_CONNECTED = $total;
}
else if($status==3)
{
$OBD_FAILED = $total;
}
else if($status==1)
{
$OBD_INPROCESS = $total;
}

}
$successPercetage=percentage($OBD_CONNECTED, $TotalAttempt_OBD, 2);


$delQuery="delete from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert where date(date_time)=date(now()) and Data_Hour='".$DATA_HOUR."' and service='MCW_LIVEAPP'";
mysql_query($delQuery,$dbConn);

$insertQuery="INSERT INTO Hungama_Tatasky.tbl_tata_pushobdHourlyAlert (TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow,TotalOBDAttempted) VALUES('".$MISSED_CALLS."','MCW_LIVEAPP','".$OBD_CONNECTED."','".$successPercetage."','".$OBD_FAILED."','".$AVG_RESTIME."','".$MIN_RESTIME."','".$MAX_RESTIME."','".$DATA_HOUR."', NOW(),'".$OBD_INPROCESS."','".$dateToShow."','".$TotalAttempt_OBD."')";
$insertdata = mysql_query($insertQuery,$dbConn);
echo "DONE";
mysql_close($dbConn);
?>