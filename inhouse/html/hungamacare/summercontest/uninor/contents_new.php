<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_uninor=array('APD','BIH','GUJ','MAH','UPE','UPW');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

$curdate = date("Y_m_d_H_i_s");

$filepath = 'csv/UninorKIJI_Recharge_' . $curdate . '.csv';
////////////////////////////////////////top 20 of each circle start here /////////////////////////
$allcircle=array();
$getCirclequery = "select distinct circle from uninor_summer_contest.tbl_contest_misdaily where date(date_time)='".$rechargeDate."' and circle not in('null','')";
$result_circle = mysql_query($getCirclequery, $dbConn) or die(mysql_error());
$result_row = mysql_num_rows($result_circle);

if ($result_row > 0) {
$fp=fopen($filepath,'a+');

fwrite($fp,'Msisdn'.','.'Today score'.','.'circle'.','.'Last charge amount'.','.'Questions played Today'.','.'Recharge Amount'.','.'SOU'.','.'Pulses'."\r\n");
$i=0;
  while ($cir_details = mysql_fetch_array($result_circle))
  {
   if(in_array($cir_details['circle'],$circle_uninor)) {
  $allcircle[$i]=$cir_details['circle'];
	$i++;
	}
  }
  foreach ($allcircle as $cir) 
  {
   $getwinner_query="select ANI, total_question_play,score,date_time,circle,SOU,lastChargeAmount,pulses from uninor_summer_contest.tbl_contest_misdaily 
				where date(date_time)='".$rechargeDate."' and  circle='".$cir."' and score>=1 order by score desc limit 20";
	$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	if ($result_row_winner > 0) {
$i=1;	
			while ($result_data = mysql_fetch_array($result_winner))
				  {
				  $amount='';
				  switch($i)
							{
							case '1': $amount=100;
							break;
							case '2': $amount=100;
							break;
							}
							$i++;
							$amount='';
				fwrite($fp,$result_data['ANI'].','.$result_data['score'].','.$circle_info[$result_data['circle']].','.$result_data['lastChargeAmount'].','.$result_data['total_question_play'].','.$amount.','.$result_data['SOU'].','.$result_data['pulses']."\r\n");
				 }
		
		}
		 }
  

	
	 }
else
{
exit;
}

////////////////////////////////////////top 20 of each circle end here /////////////////////////

$get_allwinner = "select ANI,total_question_play,score,circle,level,date_time,SOU,lastChargeAmount,pulses,Recharge_TID,Recharge_Status 
from uninor_summer_contest.tbl_contest_misdaily_recharged nolock where date_time='" . $rechargeDate . "' and status=1 and score>=1 order by score desc ";
$data = mysql_query($get_allwinner, $dbConn) or die(mysql_error());
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "No Recharge Request Found. ";
$to = "satay.tiwari@hungama.com";
$subject = "Uninor CONTEST ZONE";
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
Please find attached the top 20 scores per circle of Khelo India Jeeto India for $reportdate.<br><br>
The top 6 recharge voucher winners for $reportdate.<br><br>
</td></tr></table>";

$message .= '<table border="0" cellspacing="0" cellpadding="2" style="font-family: Century Gothic, Arial">';
$message .= '<tr>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666;border-left: 1px solid #666">Msisdn</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Today\'s score</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Circle</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 
1px solid #666; border-top: 1px solid #666"> Last charge amount</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Question\'s played Today</td>
 <td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Amount</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">SOU</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right: 
1px solid #666; border-top: 1px solid #666">Pulses</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Transaction ID</td>
<td valign="middle" bgcolor="#FFFFFF" style="border-bottom: 1px solid #666; border-right:
 1px solid #666; border-top: 1px solid #666">Recharge Status</td>
</tr>';
$i=0;
             while ($result = mysql_fetch_array($data)) {
							switch($result['level'])
							{
							case '1':
							case '2':
							case '3':
									$amount=100;
							break;
							case '2':
							case '3':
							case '4': $amount=50;
							break;
							}
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
<td $class2>".$result['score']."</td>
<td $class2>".$circle_info[$result['circle']]."</td>
<td $class2>".$result['lastChargeAmount']."</td>
<td $class2>".$result['total_question_play']."</td>
<td $class2>".$amount."</td>
<td $class2>".$result['SOU']."</td>
<td $class2>".$result['pulses']."</td>
<td $class2>".$result['Recharge_TID']."</td>
<td $class2>".$result['Recharge_Status']."</td>
</tr>";
$i++;
}
$message .= "</table>";
$message .="</body></html>";
echo $message;
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>