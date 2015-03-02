<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$timestamp = date("Y-m-d H:i:s");
//$timestamp=date('j-M h:i A', strtotime($timestamp1));

$message ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
$message .= "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			</head><body>";
//$message .= "<center><img src='http://119.82.69.212/hungamacare/missedcall/api/missed_call_logo.jpg' border='0' alt='Hungama Logo' align='center'></center>";

   $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
                    $message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>Msisdn</td><td>Circle</td><td>Operator</td><td>Timestamp</td></tr>";
                  	
                  		$message .= "<tr bgcolor='#F5DEB3'><td>+91" . $ani . "</td><td>" . $circle_info[$circle] . "</td><td>".$operator."</td><td>" . $timestamp . "</td></tr>";
                         $message .= "</table>";
					
					
$message .="</body></html>";
echo $message;
$file = fopen("emailcontent.html","w");
fwrite($file,$message);
chmod($file,0777);
fclose($file);

?>