<?php
error_reporting(0);
include("/var/www/html/airtel/dbInhousewithAirtel.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAR'=>'Haryana','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others');
$curdate = date("Y_m_d_H_i_s");
$filepath = 'csv/AirltailLdr_Recharge_' . $curdate . '.csv';
$allcircle=array();
$fp=fopen($filepath,'a+');
fwrite($fp,'Msisdn'.','.'circle'.','.'Recharge Amount'.','.'Date Time'."\r\n");
$getwinner_query="select msisdn,circle,chrg_amount,response_time from master_db.tbl_billing_success nolock 
where service_id=1527 and date(response_time)='".$rechargeDate."' and event_type='SUB' and chrg_amount=35 and mode='WAP' order by response_time";
$result_winner = mysql_query($getwinner_query, $dbConnAirtel) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);	
if ($result_row_winner > 0) {
while ($result_data = mysql_fetch_array($result_winner))
{
fwrite($fp,$result_data['msisdn'].','.$circle_info[$result_data['circle']].','.$result_data['chrg_amount'].','.$result_data['response_time']."\r\n");
}
}
//attachment data part end here

$get_allwinner = "select ANI,circle,date_time,trxid,recharge_response 
from airtel_rasoi.ldr_contest_recharge nolock where date(date_time)='" . $rechargeDate . "' and recharge_flag in(1,11,2) order by id desc ";
$data = mysql_query($get_allwinner, $dbConn212) or die(mysql_error());
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "No Recharge Request Found. ";
$to = "satay.tiwari@hungama.com";
$subject = "Airtel LDR wap- Recharge contest";
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
<tr><td>Hi All,<br><br>
Please find attached the customers who subscribed Airtel LDR on $reportdate.<br><br>
The top 10 lucky recharge voucher winners for  $reportdate.<br><br>
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
</tr>';
$i=0;
             while ($result = mysql_fetch_array($data)) {
							$amount=10;
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