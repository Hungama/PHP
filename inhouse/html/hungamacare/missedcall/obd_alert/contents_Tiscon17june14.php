<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$curdate = date("Y_m_d_H_i_s");
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate = date('j F ,Y ', strtotime($PDate));
$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));

$get_allData="select TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert nolock  
where date(date_time)='".$PDate."' and service='TATATISCON' order by Data_Hour desc";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());


$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi All,<br><br>
Please find all missed call vs OBD report for $sub_message.<br><br>
</td></tr></table>";

$message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
$message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>Time</td><td>Missed Calls</td><td>OBD's Connected</td><td>Average Success %</td><td>OBD Failed</td><td>Average Response Time (sec)</td><td>Min Response  Time (sec)</td><td>Max Response  Time (sec)</td></tr>";

while ($row = mysql_fetch_array($data)) {    
$message .= "<tr bgcolor='#F5DEB3'><td>".$row['timeToshow']."</td><td>".$row['TotalMissedCall']."</td><td>".$row['OBDConnected']."</td><td>".$row['AVGSuccess']."</td><td>".$row['OBDFailed']."</td><td>".$row['AVG_RESP_TIME']."</td><td>".$row['MIN_RESP_TIME']."</td><td>".$row['MAX_RESP_TIME']."</td></tr>";
}
$message .= "</table>";

$message .="</body></html>";
echo $message;
$htmlfilename = 'emailcontentTataTiscon_' . date('Y_m_d') . '.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
fclose($file);
mysql_close($dbConn);
?>