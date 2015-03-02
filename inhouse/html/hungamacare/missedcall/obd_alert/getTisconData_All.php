<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );	
	return $res;
}
$type=strtolower($_REQUEST['last']);
if (date('H') == '00' || $type=='y')
{
$type='y';
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
else
{
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
//$view_date='2014-08-12';
//$type='y';
echo $view_date;
$alertTableName="Hungama_Tatasky.tbl_tata_pushobdHourlyAlert_qa";
$check_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$next_date = date("Y-m-d", strtotime($view_date . ' + 1 day'));
if (strtotime($check_date) == strtotime($view_date)) {
    $DeleteQuery = "delete from $alertTableName where date(date_time)='" . $view_date . "'  and date_time>'" . $view_date . " 00:00:00' and service='TATATISCON'";
} else {
   $DeleteQuery = "delete from $alertTableName where (date(date_time)='" . $view_date . "' 
                        or date_time='" . $next_date . " 00:00:00') and service='TATATISCON'";
}
$deleteResult = mysql_query($DeleteQuery, $dbConn) or die(mysql_error());


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

$get_allData="select count(1) as total,hour(date_time) as chour,adddate(date_format(date_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime,count(distinct ANI) as uniqueCalls,max(obd_diff) as maxDiff,min(obd_diff) as minDiff,ceil(AVG(obd_diff)) as avgDiff,status  from Hungama_Tatasky.tbl_tata_pushobd nolock  
where date(date_time)='".$view_date."' and ANI!='' group by hour(date_time) order by hour(date_time) desc";

$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

while ($row = mysql_fetch_array($data)) 
{
$MISSED_CALLS = 0;
$OBD_CONNECTED = 0;
$OBD_FAILED = 0;
$AVG_RESTIME = 0;
$MAX_RESTIME = 0;
$MIN_RESTIME = 0;
$AVG_SUCCESS = 0;
$DATA_HOUR = 0;
$OBD_INPROCESS = 0;

$total=0;
$status='';
$status=$row['status'];
$total=$row['total'];

$AVG_RESTIME = $row['avgDiff'];
$MAX_RESTIME = $row['maxDiff'];
$MIN_RESTIME = $row['minDiff'];

$MISSED_CALLS=$row['total'];
$DATA_HOUR=$row['chour'];
$realTime=$row['realTime'];
$uniqueCalls=$row['uniqueCalls'];

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

$successPercetage=percentage($OBD_CONNECTED, $TotalAttempt_OBD, 2);

$insertQuery="INSERT INTO $alertTableName (TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow,TotalOBDAttempted) VALUES('".$MISSED_CALLS."','TATATISCON','".$OBD_CONNECTED."','".$successPercetage."','".$OBD_FAILED."','".$AVG_RESTIME."','".$MIN_RESTIME."','".$MAX_RESTIME."','".$DATA_HOUR."', '".$realTime."','".$OBD_INPROCESS."','".$realTime."','".$TotalAttempt_OBD."')";
$insertdata = mysql_query($insertQuery,$dbConn);
}
$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from $alertTableName where date_time=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service='TATATISCON'";
if($date_Currentthour!='00')
{
if($type!='y')
{
$deleteResult12 = mysql_query($nextDeleteQuery,$dbConn) or die(mysql_error());
}
}
$DeleteQuery = "delete from $alertTableName where date(date_time)='" . $view_date . "' and hour(date_time)>'" . $date_Currentthour . "' and service='TATATISCON'";
if($date_Currentthour!='23')
{
if($type!='y')
{
$deleteResult12 = mysql_query($DeleteQuery, $dbConn) or die(mysql_error());
}
else
{
echo 'NOK';
}
}
echo "DONE";
mysql_close($dbConn);
?>