<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$reportdate=date('j F ,Y ',strtotime($rechargeDate));
$circle_uninor=array('APD','BIH','GUJ','MAH','UPE','UPW');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');


$curdate = date("Y_m_d_H_i_s");

$get_allData = "select 'MissedCall' as type, count(1) as total from Hungama_Tatasky.tbl_tata_pushobd nolock  
where HOUR(NOW()) != 0
  AND  date_time BETWEEN TIME(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND TIME(NOW()) and ANI!=''
union
select 'OBD' as type,count(*) as total from Hungama_Tatasky.tbl_tata_pushobd nolock 
where HOUR(NOW()) != 0
  AND  date_time BETWEEN TIME(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND TIME(NOW()) and ANI!='' and status!=0";
$data = mysql_query($get_allData, $dbConn) or die(mysql_error());

while($row1 = mysql_fetch_array($data)) {
		$type = $row1['type'];
		$count[$type] = $row1['total'];
	}

//GLC Start here
$get_allData_GLC = "
select 'MissedCall' as type, count(1) as total from hul_hungama.tbl_hul_pushobd_sub nolock  
where HOUR(NOW()) != 0
  AND  date_time BETWEEN TIME(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND TIME(NOW()) and ANI!='' and service='HUL'
union
select 'OBD' as type,count(*) as total from hul_hungama.tbl_hul_pushobd_sub nolock 
 where HOUR(NOW()) != 0
  AND  date_time BETWEEN TIME(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND TIME(NOW())
 and ANI!='' and service='HUL' and status!=0";
 
$data_GLC = mysql_query($get_allData_GLC, $dbConn) or die(mysql_error());

while($row_GLC = mysql_fetch_array($data_GLC)) {
		$type_GLC = $row_GLC['type'];
		$count_GLC[$type_GLC] = $row_GLC['total'];
	}

	
	

	
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "No Data Found. ";
$to = "satay.tiwari@hungama.com";
$subject = "OBD Missed Call Alert";
$message = "No Request Found. Please check.";
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
Please find all missed call vs OBD report for $reportdate.<br><br>
</td></tr></table>";

   $message .= '<table rules="all" style="border-color: #666;font-size:12px;width:100%" border="0" cellpadding="2">';
   $message .= "<tr bgcolor='#000000' style='color:#ffffff'><td>OBD Application</td><td>Missed Call</td><td>OBD Attempt</td></tr>";
   $message .= "<tr bgcolor='#F5DEB3'><td>HUL GLC</td><td>&nbsp;&nbsp;".$count['MissedCall']."&nbsp;&nbsp;</td><td>&nbsp;&nbsp;".$count['OBD']."</td></tr>";
   $message .= "<tr bgcolor='#F5DEB3'><td>TATA Tiscon</td><td>&nbsp;&nbsp;".$count_GLC['MissedCall']."&nbsp;&nbsp;</td><td>&nbsp;&nbsp;".$count_GLC['OBD']."</td></tr>";
    $message .= "</table>";
			
$message .="</body></html>";
echo $message;
$htmlfilename='emailcontent_'.date('Y_m_d').'.html';
$file = fopen($htmlfilename,"w");
fwrite($file,$message);
fclose($file);
mysql_close($dbConn);
?>