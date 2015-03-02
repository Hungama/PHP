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

$get_allData="select service,Live_NC,NonLive_NC,CH1_REC_SUB,CH2_REC_SUB,CH1_REC_NOTSUB,CH2_REC_NOTSUB,CH1_RE_REC_SUB,CH2_RE_REC_SUB,CH1_RE_REC_NOTSUB,CH2_RE_REC_NOTSUB,Data_Hour,date_time,timeToshow from Hungama_Maxlife_IGenius.tbl_HourlyAlert nolock  
where date(date_time)='".$PDate."' and service='IGENIUS' order by Data_Hour desc";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
 $message .= "<tr><td colspan='8' align='center' >Service Alert - Enterprise - Maxlife I-Genius IVR</td></tr>";
 $message .= "<tr> <td height='47' colspan='8' align='center' ><strong>EnterpriseMaxLifeIVR - $ctime</strong></td></tr>";
 
$message .= '<tr><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Time</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Total Calls</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Live</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">Non-Live</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH1_REC_SUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH2_REC_SUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH1_REC_NOTSUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH2_REC_NOTSUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH1_RE_REC_SUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH2_RE_REC_SUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH1_RE_REC_NOTSUB</td><td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 1px solid #666; border-top: 1px solid #666">CH2_RE_REC_NOTSUB</td></tr>';
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

$Live_NC = 0;
$NonLive_NC = 0;
$CH1_REC_SUB = 0;
$CH2_REC_SUB = 0;
$CH1_REC_NOTSUB = 0;
$CH2_REC_NOTSUB = 0;
$CH1_RE_REC_SUB = 0;
$CH2_RE_REC_SUB = 0;
$CH2_RE_REC_NOTSUB =0;

$timeToshow=$row['timeToshow'];


$Live_NC=$row['Live_NC'];
if($Live_NC!='')
$Live_NC=number_format($Live_NC);
else
$Live_NC='-';

$NonLive_NC=$row['NonLive_NC'];
if($NonLive_NC!='')
$NonLive_NC=number_format($NonLive_NC);
else
$NonLive_NC='-';

$CH1_REC_SUB=$row['CH1_REC_SUB'];
if($CH1_REC_SUB!='')
$CH1_REC_SUB=number_format($CH1_REC_SUB);
else
$CH1_REC_SUB='-';


$CH2_REC_SUB=$row['CH2_REC_SUB'];
if($CH2_REC_SUB!='')
$CH2_REC_SUB=number_format($CH2_REC_SUB);
else
$CH2_REC_SUB='-';

$CH1_REC_NOTSUB=$row['CH1_REC_NOTSUB'];
if($CH1_REC_NOTSUB!='')
$CH1_REC_NOTSUB=number_format($CH1_REC_NOTSUB);
else
$CH1_REC_NOTSUB='-';

$CH2_REC_NOTSUB=$row['CH2_REC_NOTSUB'];
if($CH2_REC_NOTSUB!='')
$CH2_REC_NOTSUB=number_format($CH2_REC_NOTSUB);
else
$CH2_REC_NOTSUB='-';

$CH1_RE_REC_SUB=$row['CH1_RE_REC_SUB'];
if($CH1_RE_REC_SUB!='')
$CH1_RE_REC_SUB=number_format($CH1_RE_REC_SUB);
else
$CH1_RE_REC_SUB='-';

$CH2_RE_REC_SUB=$row['CH2_RE_REC_SUB'];
if($CH2_RE_REC_SUB!='')
$CH2_RE_REC_SUB=number_format($CH2_RE_REC_SUB);
else
$CH2_RE_REC_SUB='-';


$CH1_RE_REC_NOTSUB=$row['CH1_RE_REC_NOTSUB'];
if($CH1_RE_REC_NOTSUB!='')
$CH1_RE_REC_NOTSUB=number_format($CH1_RE_REC_NOTSUB);
else
$CH1_RE_REC_NOTSUB='-';

$CH2_RE_REC_NOTSUB=$row['CH2_RE_REC_NOTSUB'];
if($CH2_RE_REC_NOTSUB!='')
$CH2_RE_REC_NOTSUB=number_format($CH2_RE_REC_NOTSUB);
else
$CH2_RE_REC_NOTSUB='-';

$TotalCall=$Live_NC+$NonLive_NC;

$TotalCall=number_format($TotalCall);


$message .= "<tr><td $class1>".$timeToshow."</td><td $class2>".$TotalCall."</td><td $class2>".$Live_NC."</td><td $class2>".$NonLive_NC."</td><td $class2>".$CH1_REC_SUB."</td><td $class2>".$CH2_REC_SUB."</td><td $class2>".$CH1_REC_NOTSUB."</td><td $class2>".$CH2_REC_NOTSUB."</td><td $class2>".$CH1_RE_REC_SUB."</td><td $class2>".$CH2_RE_REC_SUB."</td><td $class2>".$CH1_RE_REC_NOTSUB."</td><td $class2>".$CH2_RE_REC_NOTSUB."</td></tr>";
$i++;
}
$message .= "</table>";

$message .="</body></html>";
//echo $message;
$htmlfilename = 'EnterpriseMaxLifeIVR_PAN.html';
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