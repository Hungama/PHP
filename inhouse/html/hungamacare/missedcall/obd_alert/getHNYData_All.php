<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
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
    $DeleteQuery = "delete from $alertTableName where date(date_time)='" . $view_date . "'  and date_time>'" . $view_date . " 00:00:00' and service='EnterpriseMovieHNY'";
} else {
   $DeleteQuery = "delete from $alertTableName where (date(date_time)='" . $view_date . "' 
                        or date_time='" . $next_date . " 00:00:00') and service='EnterpriseMovieHNY'";
}
$deleteResult = mysql_query($DeleteQuery, $dbConn) or die(mysql_error());


$get_allData="select count(1) as total,hour(date_time) as chour,adddate(date_format(date_time,'%Y-%m-%d %H:00:00'),INTERVAL 1 HOUR) as realTime,count(distinct ANI) as uniqueCalls from Hungama_Movie_HNY.tbl_hny_pushsms nolock  
where date(date_time)='".$view_date."' and ANI!='' group by hour(date_time) order by hour(date_time) desc";

$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

while ($row = mysql_fetch_array($data)) {
$MISSED_CALLS=$row['total'];
$DATA_HOUR=$row['chour'];
$realTime=$row['realTime'];
$uniqueCalls=$row['uniqueCalls'];

$insertQuery="INSERT INTO $alertTableName (TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow,TotalOBDAttempted) VALUES('".$MISSED_CALLS."','EnterpriseMovieHNY','".$uniqueCalls."','".$successPercetage."','".$OBD_FAILED."','".$AVG_RESTIME."','".$MIN_RESTIME."','".$MAX_RESTIME."','".$DATA_HOUR."', '".$realTime."','".$OBD_INPROCESS."','".$realTime."','".$TotalAttempt_OBD."')";
$insertdata = mysql_query($insertQuery,$dbConn);
}
echo "DONE";



$date_Currentthour = date('H');
$next_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
$nextDeleteQuery="delete from $alertTableName where date_time=date_format('".$next_date."','%Y-%m-%d 00:00:00') and service='EnterpriseMovieHNY'";
if($date_Currentthour!='00')
{
if($type!='y')
{
$deleteResult12 = mysql_query($nextDeleteQuery,$dbConn) or die(mysql_error());
}
}
$DeleteQuery = "delete from $alertTableName where date(date_time)='" . $view_date . "' and hour(date_time)>'" . $date_Currentthour . "' and service='EnterpriseMovieHNY'";
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
mysql_close($dbConn);
?>