<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
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
  $allcircle[$i]=$cir_details['circle'];
	$i++;       
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
							case '1': $amount=200;
							break;
							case '2': $amount=150;
							break;
							case '3': $amount=100;
							break;
							}
							$i++;
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
from uninor_summer_contest.tbl_contest_misdaily_recharged where date_time='" . $rechargeDate . "' and status=1 and score>=1";
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
$message ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi All,<br><br>
Please find attached the top 20 scores per circle of Khelo India Jeeto India for $reportdate.<br><br>
The top 3 recharge voucher winners per circle for $reportdate.<br><br>
</td></tr></table>";

   $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
                    $message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>Msisdn</td><td>Today's score</td><td>circle</td><td>Last charge amount</td><td>Question's played Today</td><td>Recharge Amount</td><td>SOU</td><td>Pulses</td><td>Recharge Transaction ID</td><td>Recharge Status</td></tr>";
                    while ($result = mysql_fetch_array($data)) {
							switch($result['level'])
							{
							case '1': $amount=200;
							break;
							case '2': $amount=150;
							break;
							case '3': $amount=100;
							break;
							}
					
                  		$message .= "<tr bgcolor='#F5DEB3'><td>" . $result['ANI'] . "</td><td>" . $result['score'] . "</td><td>" . $circle_info[$result['circle']] . "</td><td>".$result['lastChargeAmount']."</td><td>" . $result['total_question_play'] . "</td><td>".$amount."</td><td>".$result['SOU']."</td><td>".$result['pulses']."</td><td>".$result['Recharge_TID']."</td><td>".$result['Recharge_Status']."</td></tr>";
                    }

                    $message .= "</table>";
					
					
$message .="</body></html>";
echo $message;

$file = fopen("emailcontent.html","w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>