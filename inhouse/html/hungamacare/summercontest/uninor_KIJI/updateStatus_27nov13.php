<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$reportDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$rechargeDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
////////////////////////////////////////top 20 of each circle end here /////////////////////////

$get_allwinner = "select ANI,total_question_play,score,circle,level,date_time,SOU,lastChargeAmount,pulses 
from uninor_summer_contest.tbl_contest_misdaily_recharged nolock where date_time='" . $reportDate . "' and status=1 and score>=1";
$data = mysql_query($get_allwinner, $dbConn) or die(mysql_error());
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "NO Data to process";
}
else
{
while ($result_data = mysql_fetch_array($data))
{
	$ani=$result_data['ANI'];
	$getStatus=mysql_query("select transactionId,response from master_db.tbl_recharged nolock where date(request_time)='".$rechargeDate."' and msisdn='".$ani."'",$dbConn);
	$rechageStatus = mysql_fetch_array($getStatus);
	$TID=$rechageStatus['transactionId'];
	$response=explode('#',$rechageStatus['response']);
	//echo $TID."**".$response[0]."<br>";
	$Update_status = "update uninor_summer_contest.tbl_contest_misdaily_recharged set Recharge_TID='$TID',Recharge_Status='".$response[0]."' where date_time='".$reportDate."' and ANI='".$ani."'";
    $result2 = mysql_query($Update_status,$dbConn);
}
}
mysql_close($dbConn);
?>