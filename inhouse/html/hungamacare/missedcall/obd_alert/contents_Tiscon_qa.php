<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$curdate = date("Y_m_d_H_i_s");
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate = date('j F ,Y ', strtotime($PDate));
$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));
//17,Tue Jun 15 PM
$ctime=date("d,D M H A");

$get_allData="select TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert nolock  
where date(date_time)='".$PDate."' and service='TATATISCON' order by Data_Hour desc";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - Tata Tiscon</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseTiscon - $ctime</strong></td></tr>";
 
$message .= '<tr><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Time</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Missed Calls</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">OBDs Connected</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Average Success %</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">OBD Failed</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Average Response Time (sec)</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Min Response  Time (sec)</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Max Response  Time (sec)</td></tr>';
$i=0;
while ($row = mysql_fetch_array($data)) {    

if($i%2==0)
{
$class2='valign="middle" bgcolor="#f2f2f2" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#f2f2f2" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}
else
{
$class2='valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
$class1='valign="middle" bgcolor="#FFFFFF" style="border-left: 1px solid #666;border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;text-align:right"';
}

$timeToshow=$row['timeToshow'];
$TotalMissedCall=number_format($row['TotalMissedCall']);
$OBDConnected=number_format($row['OBDConnected']);
$AVGSuccess=number_format($row['AVGSuccess']);
$OBDFailed=number_format($row['OBDFailed']);

$AVG_RESP_TIME=$row['AVG_RESP_TIME'];
if($AVG_RESP_TIME!='')
$AVG_RESP_TIME=number_format($AVG_RESP_TIME);
else
$AVG_RESP_TIME='-';

$MIN_RESP_TIME=$row['MIN_RESP_TIME'];
if($MIN_RESP_TIME!='')
$MIN_RESP_TIME=number_format($MIN_RESP_TIME);
else
$MIN_RESP_TIME='-';

$MAX_RESP_TIME=$row['MAX_RESP_TIME'];
if($MAX_RESP_TIME!='')
$MAX_RESP_TIME=number_format($MAX_RESP_TIME);
else
$MAX_RESP_TIME='-';

$message .= "<tr><td $class1>".$timeToshow."</td><td $class2>".$TotalMissedCall."</td><td $class2>".$OBDConnected."</td><td $class2>".$AVGSuccess."</td><td $class2>".$OBDFailed."</td><td $class2>".$AVG_RESP_TIME."</td><td $class2>".$MIN_RESP_TIME."</td><td $class2>".$MAX_RESP_TIME."</td></tr>";
$i++;
}
$message .= "</table>";

$message .="</body></html>";
echo $message;
$htmlfilename = 'emailcontentTataTiscon_' . date('Y_m_d') . '.html';
//$file = fopen($htmlfilename, "w");
//fwrite($file, $message);
//fclose($file);
mysql_close($dbConn);
?>