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

if (date('H') == '00')
{
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
}
else
{
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}

$get_allSummaryData="select sum(TotalMissedCall) as TotalMissedCall from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert nolock where date(date_time)>='".$PDate."' and service='EnterpriseMovieHNY'";
$dataSummary = mysql_query($get_allSummaryData, $dbConn) or die(mysql_error());
list($totalCount) = mysql_fetch_array($dataSummary); 

$get_allData="select TotalMissedCall,service,OBDConnected,AVGSuccess,OBDFailed,AVG_RESP_TIME,MIN_RESP_TIME,MAX_RESP_TIME,Data_Hour,date_time,OBDINProcess,timeToshow from Hungama_Tatasky.tbl_tata_pushobdHourlyAlert nolock  
where date(date_time)>='".$PDate."' and service='EnterpriseMovieHNY' order by Data_Hour desc";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - Happy New Year</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMovieHNY - $ctime</strong></td></tr>";
 
$message .= '<tr><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Time</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Missed Calls</td></tr>';
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
$message .= "<tr><td $class1>".$timeToshow."</td><td $class2>".$TotalMissedCall."</td></tr>";
$i++;
}
$message .= "<tr><td $class1>Total Missed Calls</td><td $class2>".number_format($totalCount)."</td></tr>";
$message .= "</table>";

$message .="</body></html>";
//echo $message;
$htmlfilename = 'EnterpriseMovieHNY_PAN.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
fclose($file);
mysql_close($dbConn);
$destPath='/home/Scripts/SMS_AUTOMATION/Data_Files/'.$htmlfilename;
//copy file on the path /home/Scripts/SMS_AUTOMATION/Data_Files
if (!copy($htmlfilename,$destPath))
{
echo "failed to copy $htmlfilename...\n";
}
else
{
echo "Copied successfully";
//unlink($htmlfilename);				  
}
?>