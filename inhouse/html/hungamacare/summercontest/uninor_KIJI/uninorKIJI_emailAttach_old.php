<?php
session_start();
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
//$dbConn_224 = mysql_connect("192.168.100.224", "webcc", "webcc");
if (!$dbConn) {
    echo '224- Could not connect';
    die('Could not connect: ' . mysql_error("could not connect to Local"));
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');

//end here
date_default_timezone_set('Asia/Calcutta');
$pname = 'satay';
$today = date("y-n-j");
$todaytime = date("H:i:s");
$dattime = $today . " " . $todaytime;

$curdate = date("Y_m_d-H_i_s");
//$curdate = date("2013_08_08-16_27_32");
$path = 'UninorKIJI_Recharge_' . $curdate . '.csv';
//make db connection to airtel db to fetch data ussd refer and the write it in to file.
//$con = mysql_connect("192.168.100.224", "webcc", "webcc");
$prevdate = date("Y-m-d", time() - 60 * 60 * 24);
$curdate = date("d-m-Y");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
//$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));

////////////////////////////////////////top 10 of each circle start here /////////////////////////
$allcircle=array();
$getCirclequery = "select distinct circle from uninor_summer_contest.tbl_contest_misdaily where date(date_time)='".$rechargeDate."' ";

$result_circle = mysql_query($getCirclequery, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result_circle);


if ($result_row > 0) {
$fp=fopen($path,'a+');

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
		//fwrite($fp,$result_data['ANI'].','.$result_data['total_question_play'].','.$result_data['score'].','.$circle_info[$result_data['circle']].','.$result_data['date_time']."\r\n");
		fwrite($fp,$result_data['ANI'].','.$result_data['score'].','.$circle_info[$result_data['circle']].','.$result_data['lastChargeAmount'].','.$result_data['total_question_play'].','.$amount.','.$result_data['SOU'].','.$result_data['pulses']."\r\n");
				 }
		
		}
		 }
  

	
	 }
else
{
echo "exit";
}

////////////////////////////////////////top 10 of each circle end here /////////////////////////

$emailSmsEngagemntArray = array('satay.tiwari@hungama.com','mukesh.malav@hungama.com','monika.patel@hungama.com','kunalk.arora@hungama.com');
//$emailSmsEngagemntArray = array('satay.tiwari@hungama.com');
$to = 'satay.tiwari@hungama.com';
$subject = "Uninor Kehlo India Jeeto India Daily  of date " . $prevdate;
$random_hash = md5(date('r', time()));
$headers = "From: Voice<voice.mis@hungama.com>\r\nReply-To: voice.mis@hungama.com";
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-" . $random_hash . "\"";
$attachment = chunk_split(base64_encode(file_get_contents($path)));
ob_start(); //Turn on output buffering
$get_allwinner = "select ANI,total_question_play,score,circle,level,date_time,SOU,lastChargeAmount,pulses from uninor_summer_contest.tbl_contest_misdaily_recharged where date_time='" . $rechargeDate . "' and status=1 and score>=1";
$data = mysql_query($get_allwinner, $dbConn) or die(mysql_error());
?>

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="UTF-8"
Content-Transfer-Encoding: 7bit

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="UTF-8"
Content-Transfer-Encoding: 7bit
<html>
    <body>
        <table cellspacing="2" cellpadding="8" border="0" width="100%">
            <tr><td style="font-family:Verdana, Arial; font-size:11px; color:#333333;width:200px;">
                    <!-- Uninor Kehlo India Jeeto India Daily REPORT-- Total no of records <?php //echo $totalnoofrecords;   ?>-->
Hi All,<br><br>

Please find attached the top 20 scores per circle of Khelo India Jeeto India for <?php echo $reportdate."<br><br>";?>

The top 3 recharge voucher winners per circle for <?php echo $reportdate;?>
<br><br>
</td></tr>
</table>
                    <?php
                    $message = '<html><body>';
                    $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
                    $message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>Msisdn</td><td>Today's score</td><td>circle</td><td>Last charge amount</td><td>Question's played Today</td><td>Recharge Amount</td><td>SOU</td><td>Pulses</td></tr>";
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
					
                        //$message .= "<tr bgcolor='#F5DEB3'><td>" . $result['ANI'] . "</td><td>" . $result['total_question_play'] . "</td><td>" . $result['score'] . "</td><td>" . $circle_info[$result['circle']] . "</td><td>" . $result['date_time'] . "</td></tr>";
						$message .= "<tr bgcolor='#F5DEB3'><td>" . $result['ANI'] . "</td><td>" . $result['score'] . "</td><td>" . $circle_info[$result['circle']] . "</td><td>".$result['lastChargeAmount']."</td><td>" . $result['total_question_play'] . "</td><td>".$amount."</td><td>".$result['SOU']."</td><td>".$result['pulses']."</td></tr>";
                    }

                    $message .= "</table>";
                    $message .= "</body></html>";
                    echo $message;
                    ?>
                </td></tr></table>
    </body></html>
--PHP-alt-<?php echo $random_hash; ?>--

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: application/doc; name="<?php echo $path; ?>" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>--
<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
//$mail_sent = @mail( 'satay.tiwari@hungama.com', $subject, $message, $headers );
foreach ($emailSmsEngagemntArray as $email) {
    $mail_sent = @mail($email, $subject, $message, $headers);

    if ($mail_sent) {
        $logdata = 'Mail sent - ' . $email . "#" . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $logdata = 'Mail failed- ' . $email . "#" . date("Y-m-d H:i:s") . "\r\n";
    }
}
echo 'done';
mysql_close($dbConn);
//delete zip file from server
unlink($path);
?>