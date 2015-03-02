<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others');
$curdate = date("Y_m_d_H_i_s");
$filepath = 'csv/uninor54646_Recharge_' . $curdate . '.csv';
$allcircle=array();
$fp=fopen($filepath,'a+');
fwrite($fp,'Msisdn'.','.'circle'.','.'SC'.','.'Date Time'."\r\n");
$getwinner_query="select ANI,'GUJ' as circle,DNIS,date_time from uninor_hungama.tbl_GUJ nolock 
where date(date_time)='".$rechargeDate."' order by date_time";
$result_winner = mysql_query($getwinner_query, $dbConn212) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);	
if ($result_row_winner > 0) {
while ($result_data = mysql_fetch_array($result_winner))
{
fwrite($fp,$result_data['ANI'].','.$circle_info[$result_data['circle']].','.$result_data['DNIS'].','.$result_data['date_time']."\r\n");
}
}
//attachment data part end here

$get_allwinner = "select ANI,circle,date_time,trxid,recharge_response,SC
from uninor_hungama.tbl_GUJ_recharge nolock where date(date_time)='" . $rechargeDate . "' and recharge_flag in(1,11,2) order by id desc ";
$data = mysql_query($get_allwinner, $dbConn212) or die(mysql_error());
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "No Recharge Request Found. ";
$to = "satay.tiwari@hungama.com";
$subject = "Uninor 54646 GUJ- Recharge contest";
$message = "No Recharge Request Found. Please check.";
$from = "voice.mis@hungama.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
exit;
}
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table border='0' cellspacing='0' cellpadding='2' style='font-family: Century Gothic, Arial'>
<tr><td>Hi,<br><br>
Below are the the MDNs which are the 30th caller and now eligible for recharge of Rs. 100 today.
<br><br>
</td></tr></table>";

$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
$message .= '<tr>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Msisdn</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Circle</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Amount</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Transaction ID</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Status</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">SC</td>
</tr>';
$i=0;
             while ($result = mysql_fetch_array($data)) {
$amount=100;
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
$message .= "<tr><td $class1>".$result['ANI']."</td>
<td $class2>".$circle_info[$result['circle']]."</td>
<td $class2>".$amount."</td>
<td $class2>".$result['trxid']."</td>
<td $class2>".$result['recharge_response']."</td>
<td $class2>".$result['SC']."</td>
</tr>";
$i++;
}
$message .= "</table>";
$message .="</body></html>";
//echo  $message;


$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn212);
mysql_close($dbConnAirtel);
?>