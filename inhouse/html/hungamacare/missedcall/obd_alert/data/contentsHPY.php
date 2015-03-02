<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_uninor=array('APD','BIH','GUJ','MAH','UPE','UPW');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$curdate = date("Y_m_d_H_i_s");
$filepath = 'csv/HPYMissedCall_' . $curdate . '.csv';
////////////////////////////////////////All Missed Call data start here /////////////////////////
   $getwinner_query="select ANI,date_time,circle from Hungama_Movie_HNY.tbl_hny_pushsms where date(date_time)='".$rechargeDate."' order by date_time desc";
	$result_winner = mysql_query($getwinner_query, $dbConn) or die(mysql_error());
	$result_row_winner = mysql_num_rows($result_winner);	
	if ($result_row_winner > 0) {

	$fp=fopen($filepath,'a+');

fwrite($fp,'Msisdn'.','.'Circle'.','.'DateTime'."\r\n");

			while ($result_data = mysql_fetch_array($result_winner))
				  {
			fwrite($fp,$result_data['ANI'].','.$circle_info[$result_data['circle']].','.$result_data['date_time']."\r\n");
				 }
		
		}
else
{
exit;
}

////////////////////////////////////////All Missed Call data end here /////////////////////////



$get_allwinner = "select count(ANI) from Hungama_Movie_HNY.tbl_hny_pushsms where date(date_time)='".$rechargeDate."' order by date_time desc ";
$data = mysql_query($get_allwinner, $dbConn) or die(mysql_error());
//$numrows = mysql_num_rows($data);
list($numrows) = mysql_fetch_array($data); 
if ($numrows==0) 
{ 
echo "No Recharge Request Found. ";
$to = "satay.tiwari@hungama.com";
$subject = "HPY Missed Call";
$message = "No Record Found. Please check.";
$from = "voice.mis@hungama.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
exit;
}
$message ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
$message .= "<table rules='all' style='border-color: #666;font-size:12px;width:100%' border='0' cellpadding='2'>
<tr><td>Hi Team,<br><br>
Please find attached missed call data for $reportdate.<br><br>Total Missed Calls- ".number_format($numrows)."
</td></tr></table>";				
$message .="</body></html>";
echo $message;
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>