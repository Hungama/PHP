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
//EnterpriseMovieHNY
$From_lasthour = date('H', strtotime('-1 hour'));
$To_lasthour = date('H');
$dateToShow=$From_lasthour.'-'.$To_lasthour;


$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));
if($date_lasthour==00)
{
$updateQuery="update Hungama_Tatasky.tbl_tata_pushobdHourlyAlert set date_time='".$PreDate."' where date(date_time)=date(now()) and Data_Hour='23' and service='EnterpriseMovieHNY'";
mysql_query($updateQuery,$dbConn);
}
//$date_lasthour=12;
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
$successPercetage=0;
$DATA_HOUR=$date_lasthour;

$get_allData="select count(1) as total,hour(date_time) as chour from Hungama_Movie_HNY.tbl_hny_pushsms nolock  
where date(date_time)='".$PDate."' and ANI!='' and hour(date_time)='" . $date_lasthour . "'";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

while ($row = mysql_fetch_array($data)) {
$total=0;
$total=$row['total'];
$MISSED_CALLS = $MISSED_CALLS+$total;
}
$delQuery="delete from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert where date(date_time)=date(now()) and Data_Hour='".$DATA_HOUR."' and service='EnterpriseMovieHNY'";
mysql_query($delQuery,$dbConn);

$insertQuery="INSERT INTO Hungama_Tatasky.tbl_tata_pushobdHourlyAlert (TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow,TotalOBDAttempted) VALUES('".$MISSED_CALLS."','EnterpriseMovieHNY','".$OBD_CONNECTED."','".$successPercetage."','".$OBD_FAILED."','".$AVG_RESTIME."','".$MIN_RESTIME."','".$MAX_RESTIME."','".$DATA_HOUR."', NOW(),'".$OBD_INPROCESS."','".$dateToShow."','".$TotalAttempt_OBD."')";
$insertdata = mysql_query($insertQuery,$dbConn);
echo "DONE";
mysql_close($dbConn);
?>