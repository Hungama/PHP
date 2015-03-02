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

$get_countData="select count(1) as total from Hungama_ENT_MCDOWELL.tbl_sendsms_tp nolock";
$data = mysql_query($get_countData, $dbConn) or die(mysql_error());
list($total) = mysql_fetch_array($data);
if($total>1000)
{
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= '<table  cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
$message .= '<tr>
<td>
<p>Dear Noc/Ops team,</p>
<p>Please restart SMS application for Mcdowells ASAP.</p>
</td>
</tr>';
$message .= "</table>";
$message .="</body></html>";
$htmlfilename = 'EnterpriseMcDw_sms_alert.html';
$file = fopen($htmlfilename, "w");
fwrite($file, $message);
fclose($file);
mysql_close($dbConn);
echo "content success ";

}
else{
echo "content fail ";
}
?>