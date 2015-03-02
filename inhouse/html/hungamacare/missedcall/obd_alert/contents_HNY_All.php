<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$type=strtolower($_REQUEST['last']);
$curdate = date("Y_m_d_H_i_s");
$PDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate = date('j F ,Y ', strtotime($PDate));
$sub_message = $reportdate;
$date_lasthour = date('H', strtotime('-1 hour'));
$ctime=date("d,D M H A");

if (date('H') == '00' || $type=='y')
{
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
}
else
{
$view_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
}
$alertTableName="Hungama_Tatasky.tbl_tata_pushobdHourlyAlert_qa";
$get_allSummaryData="select sum(TotalMissedCall) as TotalMissedCall from $alertTableName nolock where date_time>'" . $view_date . " 00:00:00' and service='EnterpriseMovieHNY'";
$dataSummary = mysql_query($get_allSummaryData, $dbConn) or die(mysql_error());
list($totalCount) = mysql_fetch_array($dataSummary); 

$get_allData="select TotalMissedCall,service,Data_Hour,date_time,hour(timeToshow) as realTime,OBDConnected as uniqueCalls from $alertTableName nolock  
where date_time>'" . $view_date . " 00:00:00' and service='EnterpriseMovieHNY' order by Data_Hour desc";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - Happy New Year</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMovieHNY - $ctime</strong></td></tr>";
 
$message .= '<tr><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Time</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Missed Calls</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Unique Calls</td></tr>';
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


$Data_Hour=$row['Data_Hour'];
$realTime=$row['realTime'];
$Data_Hour = sprintf("%02s", $Data_Hour);
$realTime = sprintf("%02s", $realTime);

$timeToshow=$Data_Hour.'-'.$realTime;

$TotalMissedCall=$row['TotalMissedCall'];
$TotalUniqueCalls=$row['uniqueCalls'];

$message .= "<tr><td $class1>".$timeToshow."</td><td $class2>".number_format($TotalMissedCall)."</td><td $class2>".number_format($TotalUniqueCalls)."</td></tr>";
$i++;
}
$message .= "<tr><td $class1 colspan=\"2\">Total Missed Calls</td><td $class2>".number_format($totalCount)."</td></tr>";
$message .= "</table>";

$message .="</body></html>";
//echo $message;

$htmlfilename = 'EnterpriseMovieHNY_PAN.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
fclose($file);

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
mysql_close($dbConn);
?>